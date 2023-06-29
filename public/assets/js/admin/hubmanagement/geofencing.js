let map;
let marker;
let markers = [];
let geocoder;
let coordinates = [];
let hubcoordinates = [];
$(document).ready(function () {
    initMaps();
});
var initMaps = function () {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {

            map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                },
                zoom: 18
            });
            //Init geocoder service
            geocoder = new google.maps.Geocoder();


            google.maps.event.addListener(map, 'click', function (event) {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You want to change the hub location!",
                    icon: "error",
                    showCancelButton: true,
                    confirmButtonText: "Yes, do it!",
                    customClass: {
                        confirmButton: "btn btn-success me-3",
                        cancelButton: "btn btn-danger",
                    },
                    buttonsStyling: false,
                }).then(function (result) {
                    if (result.value) {
                        deleteMarkers();
                        placeMarker(event.latLng);
                        geocode({ location: event.latLng });
                        console.log(event.latLng.toUrlValue());
                        $("#txtlatitude").val(event.latLng.toUrlValue().split(',')[0]);
                        $("#txtlangtitute").val(event.latLng.toUrlValue().split(',')[1]);
                    }
                });
            });

            function geocode(request) {
                geocoder
                    .geocode(request)
                    .then((result) => {
                        const { results } = result;
                        // console.log(results[0].formatted_address);
                        // console.log(JSON.stringify(result, null, 2));
                        $("#txtgeolocation").val(results[0].formatted_address);
                        return results;
                    })
                    .catch((e) => {
                        alert("Geocode was not successful for the following reason: " + e);
                    });
            }

            function placeMarker(location) {

                var marker = new google.maps.Marker({
                    position: location,
                    map: map
                });
                markers.push(marker);

            }

            // Sets the map on all markers in the array.
            function setMapOnAll(map) {
                for (let i = 0; i < markers.length; i++) {
                    markers[i].setMap(map);
                }
            }

            // Removes the markers from the map, but keeps them in the array.
            function hideMarkers() {
                setMapOnAll(null);
            }

            // Shows any markers currently in the array.
            function showMarkers() {
                setMapOnAll(map);
            }

            // Deletes all markers in the array by removing references to them.
            function deleteMarkers() {
                hideMarkers();
                markers = [];
            }

            placeMarkerOnEdit();
            drawPolygonCurrentHubEdit();
            drawPolygonOtherHubs();

            // google.maps.event.addListener(hub.getPath(), 'insert_at', function (index, obj) {
            //     console.log('Vertex removed');
            // });
            // google.maps.event.addListener(hub.getPath(), 'set_at', function (index, obj) {
            //     console.log('Vertex moved');
            // });

            // google.maps.event.addListener(hub, 'dragend', function () {
            //     console.log('Drag ended');
            // });

            function placeMarkerOnEdit() {
                if (($("#txtcoordinates").val() != undefined && $("#txtcoordinates").val() != "") && ($("#txtcoordinates").val() != undefined && $("#txtcoordinates").val() != "")) {
                    var location = new google.maps.LatLng($("#txtlatitude").val(), $("#txtlangtitute").val());
                    placeMarker(location);
                    map.setCenter(location);
                }
            }

            function drawPolygonCurrentHubEdit() {
                //Draw Polygon 
                if ($("#txtcoordinates").val() != undefined && $("#txtcoordinates").val() != "") {
                    let coordinates = $("#txtcoordinates").val();

                    let coordsArray = coordinates.split('),(');

                    console.log(coordsArray);

                    for (let i = 0; i < coordsArray.length; i += 2) {
                        hubcoordinates.push({ lat: parseFloat(coordsArray[i]), lng: parseFloat(coordsArray[i + 1]) });
                    }
                }
                drawPolygon(hubcoordinates, false, false, true);

            }


            function drawPolygonOtherHubs() {

                $.ajax({
                    url: "/get/hubcoordinates",
                    type: "GET",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    data: {
                        hub_id: $("#hub_id").val(),
                        _token: $('meta[name="csrf-token"]').attr("content"),
                    },
                    dataType: "json",
                    success: function (response) {
                        $.each(response.response, function (index, value) {
                            // console.log(value.geo_coordinates);
                            let coordinates = value.geo_coordinates;

                            let coordsArray = coordinates.split(',');
                            let otherhubcoordinates = [];
                            for (let i = 0; i < coordsArray.length; i += 2) {
                                otherhubcoordinates.push({ lat: parseFloat(coordsArray[i]), lng: parseFloat(coordsArray[i + 1]) });
                            }

                            drawPolygon(otherhubcoordinates);
                        });
                    },
                });

            }

            function drawPolygon(hubcoordinates, isEditable = false, isDraggable = false, isClickable = false) {
                // Construct the polygon.
                const hub = new google.maps.Polygon({
                    paths: hubcoordinates,
                    clickable: isClickable,
                    draggable: isDraggable,
                    editable: isEditable,
                    fillColor: "#ffff00",
                    fillOpacity: 0.2,
                });

                hub.setMap(map);

                if (isClickable) {
                    google.maps.event.addListener(hub, 'click', function (e) {
                        setSelection(hub);
                    });
                }
            }

            var all_overlays = [];
            var selectedShape;
            var drawingManager = new google.maps.drawing.DrawingManager({
                // drawingMode: google.maps.drawing.OverlayType.MARKER,
                drawingControl: true,
                drawingControlOptions: {
                    position: google.maps.ControlPosition.TOP_CENTER,
                    drawingModes: [
                        //google.maps.drawing.OverlayType.MARKER,
                        //google.maps.drawing.OverlayType.CIRCLE,
                        google.maps.drawing.OverlayType.POLYGON,
                        //google.maps.drawing.OverlayType.RECTANGLE
                    ]
                },
                // markerOptions: {
                //     icon: 'images/beachflag.png'
                // },
                polygonOptions: {
                    clickable: true,
                    draggable: true,
                    editable: true,
                    fillColor: '#ffff00',
                    fillOpacity: 0.2,

                }
            });

            function clearSelection() {
                if (selectedShape) {
                    selectedShape.setEditable(false);
                    selectedShape = null;
                }
            }

            function setSelection(shape) {
                clearSelection();
                selectedShape = shape;
                shape.setEditable(true);
                google.maps.event.addListener(selectedShape.getPath(), 'insert_at', getPolygonCoords(shape));
                google.maps.event.addListener(selectedShape.getPath(), 'set_at', getPolygonCoords(shape));
            }

            function deleteSelectedShape() {
                if (selectedShape) {
                    selectedShape.setMap(null);
                    coordinates.length = 0;
                    $("#txtcoordinates").val(coordinates);
                }
            }

            function deleteAllShape() {
                for (var i = 0; i < all_overlays.length; i++) {
                    all_overlays[i].overlay.setMap(null);
                }
                all_overlays = [];
            }

            function CenterControl(controlDiv, map) {

                // Set CSS for the control border.
                var controlUI = document.createElement('div');
                controlUI.style.backgroundColor = '#fff';
                controlUI.style.border = '2px solid #fff';
                controlUI.style.borderRadius = '3px';
                controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
                controlUI.style.cursor = 'pointer';
                controlUI.style.marginBottom = '22px';
                controlUI.style.textAlign = 'center';
                controlUI.title = 'Select to delete the shape';
                controlDiv.appendChild(controlUI);

                // Set CSS for the control interior.
                var controlText = document.createElement('div');
                controlText.style.color = 'rgb(25,25,25)';
                controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
                controlText.style.fontSize = '16px';
                controlText.style.lineHeight = '38px';
                controlText.style.paddingLeft = '5px';
                controlText.style.paddingRight = '5px';
                controlText.innerHTML = 'Delete Selected Area';
                controlUI.appendChild(controlText);

                // Setup the click event listeners: simply set the map to Chicago.
                controlUI.addEventListener('click', function () {
                    deleteSelectedShape();
                });

            }
            drawingManager.setMap(map);
            var getPolygonCoords = function (newShape) {
                console.log("We are one");
                var len = newShape.getPath().getLength();
                for (var i = 0; i < len; i++) {
                    // console.log(newShape.getPath().getAt(i).toUrlValue(6));
                    coordinates.push(newShape.getPath().getAt(i).toUrlValue());
                }
                // $("#txtcoordinates").val(coordinates);
            };

            google.maps.event.addListener(drawingManager, 'polygoncomplete', function (event) {
                console.log("polygon complete");
                event.getPath().getLength();
                google.maps.event.addListener(event.getPath(), 'insert_at', function () {
                    console.log("insert_at");
                    var len = event.getPath().getLength();
                    for (var i = 0; i < len; i++) {
                        // console.log(event.getPath().getAt(i).toUrlValue(5));
                        coordinates.push(event.getPath().getAt(i).toUrlValue());
                    }
                });
                google.maps.event.addListener(event.getPath(), 'set_at', function () {
                    console.log("set_at");
                    var len = event.getPath().getLength();
                    for (var i = 0; i < len; i++) {
                        // console.log(event.getPath().getAt(i).toUrlValue(5));
                        coordinates.push(event.getPath().getAt(i).toUrlValue());
                    }
                });
            });

            google.maps.event.addListener(drawingManager, 'overlaycomplete', function (event) {

                console.log("overlay complete");
                all_overlays.push(event);
                if (event.type !== google.maps.drawing.OverlayType.MARKER) {
                    drawingManager.setDrawingMode(null);
                    //Write code to select the newly selected object.

                    var newShape = event.overlay;
                    newShape.type = event.type;
                    google.maps.event.addListener(newShape, 'click', function () {
                        setSelection(newShape);
                    });

                    setSelection(newShape);

                    $('#txtcoordinates').val(event.overlay.getPath().getArray());
                }
            });


            var centerControlDiv = document.createElement('div');
            var centerControl = new CenterControl(centerControlDiv, map);

            centerControlDiv.index = 1;
            map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(centerControlDiv);
        });
    }
};
