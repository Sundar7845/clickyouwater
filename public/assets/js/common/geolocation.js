let map;
let marker;
let markers = [];
let geocoder;
$(document).ready(function () {
    initMaps();
});
var initMaps = function () {

    map = new google.maps.Map(document.getElementById('map'), {
        center: {
            lat: 11.004556,
            lng: 76.961632
        },
        zoom: 18
    });
    //Init geocoder service
    geocoder = new google.maps.Geocoder();


    google.maps.event.addListener(map, 'click', function (event) {
        Swal.fire({
            title: "Are you sure?",
            text: "You want to change the current geo location!",
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
                // console.log(event.latLng.toUrlValue());
                $("#txtLatitude").val(event.latLng.toUrlValue().split(',')[0]);
                $("#txtLongtitude").val(event.latLng.toUrlValue().split(',')[1]);
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
                $("#txtGeoLocation").val(results[0].formatted_address);
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

    function placeMarkerOnEdit() {
        if (($("#txtLatitude").val() != undefined && $("#txtLatitude").val() != "") && ($("#txtLongtitude").val() != undefined && $("#txtLongtitude").val() != "")) {
            var location = new google.maps.LatLng($("#txtLatitude").val(), $("#txtLongtitude").val());
            placeMarker(location);
            map.setCenter(location);
        }
    }

    // var dist = getDistance("11.0643172", "76.9605309", "11.0438472", "76.9994912", "K");
    // console.log(dist);
}

//11.0643172,76.9605309
//11.0438472,76.9994912

//Calculate distance between latitude and longitude
function getDistance(fromLat, fromLng, toLat, toLng, unit = '') {
    theta = fromLng - toLng;
    dist = sin(deg2rad(fromLat)) * sin(deg2rad(toLat)) + cos(deg2rad(fromLat)) * cos(deg2rad(toLat)) * cos(deg2rad(theta));
    dist = acos(dist);
    dist = rad2deg(dist);
    miles = dist * 60 * 1.1515;

    //Convert unit and return distance
    unit = strtoupper(unit);
    if (unit == "K") {
        return round(miles * 1.609344, 2) + ' km';
    }
    else if (unit == "M") {
        return round(miles * 1609.344, 2) + ' meters';
    }
    else {
        return round(miles, 2) + ' miles';
    }
}