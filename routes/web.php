<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*==================================================ADMIN START==============================================================*/
//Website
Route::get('website', [App\Http\Controllers\WebsiteController::class, 'website'])->name('website');

Route::get('invoicetest', [App\Http\Controllers\invoicecontroller::class, 'invoice']);
//Login
Route::get('/', [App\Http\Controllers\Login\LoginController::class, 'loginForm'])->name('login');
Route::post('admin/login', [App\Http\Controllers\Login\LoginController::class, 'login'])->name('admin.login');
Route::group(['middleware' => ['auth', 'prevent-back-history']], function () {
    Route::get('admin/logout', [App\Http\Controllers\Login\LoginController::class, 'logout'])->name('admin.logout');

    // Route::get('/forget-password', [App\Http\Controllers\Admin\Login\LoginController::class, 'forgetPassword'])->name('forget-password');

    //Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/adminordersData/{customer_id}', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'getAdminRecentOrdersdata'])->name('get.admin.recentorders');
    Route::get('/manfacturerCansOrderData', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'manfacturerCansOrderData'])->name('manfacturerCansOrderData');
    Route::get('/manfacturerOthersOrderData', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'manfacturerOthersOrderData'])->name('manfacturerOthersOrderData');
    Route::get('/manfacturerStockInProductionData', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'manfacturerStockInProductionData'])->name('manfacturerStockInProductionData');
    Route::get('/manfacturerStockData', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'manfacturerStockData'])->name('manfacturerStockData');
    Route::get('/manfacturerEmptyCanData', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'manfacturerEmptyCanData'])->name('manfacturerEmptyCanData');
    Route::get('/manfacturerDamagedCanData', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'manfacturerDamagedCanData'])->name('manfacturerDamagedCanData');
    Route::get('/revenuegrowthdata', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'adminRevenueGrowthData'])->name('get.revenue.growth');
    Route::get('/yearlysalesdata', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'yearlySalesData'])->name('get.yearly.sales');

    //profile
    Route::get('/profile', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'Profile'])->name('profile');
    Route::post('/profile/update', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'ProfileUpdate'])->name('profile.update');
    Route::get('/unauthorized', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'unauthorized'])->name('unauthorized');
    Route::get('/404', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'pageNotFound'])->name('404');

    //Admin Dashboard Tile Data's

    //customer-order
    Route::get('/customerorders', [App\Http\Controllers\Admin\OrderManagement\CustomerOrdersController::class, 'customerOrders'])->name('customerorders');
    Route::post('gethubbycity', [App\Http\Controllers\Admin\OrderManagement\CustomerOrdersController::class, 'getHubByCity'])->name('gethubbycity');
    Route::get('/customerorder/data/{type?}', [App\Http\Controllers\Admin\OrderManagement\CustomerOrdersController::class, 'customerOrderData'])->name('customerorderdata');
    Route::get('/orderdetail/{id}', [App\Http\Controllers\Admin\OrderManagement\OrderDetailController::class, 'orderDetail'])->name('orderdetail');

    //Invoice downloaded Orders
    Route::get('/invoicedownloadedorders', [App\Http\Controllers\Admin\OrderManagement\InvoiceDownloadedOrdersController::class, 'invoiceDownloadedOrders'])->name('invoicedownloadedorders');
    Route::get('/invoicedownloadedorders/data/', [App\Http\Controllers\Admin\OrderManagement\InvoiceDownloadedOrdersController::class, 'invoiceDownloadedOrdersData'])->name('invoicedownloadedordersdata');

    //manufacturer
    Route::get('/manufacturerorders', [App\Http\Controllers\Admin\OrderManagement\ManufacturerOrdersController::class, 'manufacturerOrders'])->name('manufacturerorders');
    Route::get('/manorders', [App\Http\Controllers\Admin\OrderManagement\ManufacturerOrdersController::class, 'manOrders'])->name('man.orders');
    Route::get('/getmanufacturers', [App\Http\Controllers\Admin\OrderManagement\ManufacturerOrdersController::class, 'getManufactures'])->name('getmanufacturers');
    Route::get('/manufacturer/data', [App\Http\Controllers\Admin\OrderManagement\ManufacturerOrdersController::class, 'manufactureOrderData'])->name('manufactureorderdata');
    Route::get('/manufacturerorderlist/{id}', [App\Http\Controllers\Admin\OrderManagement\ManufacturerOrdersController::class, 'manufacturerOrderList'])->name('manufacturerorderlist');
    Route::get('/manufacturerorderdetails', [App\Http\Controllers\Admin\OrderManagement\ManufacturerOrdersController::class, 'manufacturerOrderDetail'])->name('manufacturerorderdetail');

    //Manufacturer Stock Data
    Route::get('/manstocksview', [App\Http\Controllers\Manufacturer\Stock\StockController::class, 'manStocksView'])->name('manStocksView');
    Route::get('/manufacturerproductstockdata', [App\Http\Controllers\Manufacturer\Stock\StockController::class, 'manufacturerProductStockData'])->name('manufacturerProductStockData');
    Route::get('/manufactuererstocks/{id?}', [App\Http\Controllers\Manufacturer\Stock\StockController::class, 'manufactuererStocks'])->name('manufactuererstocks');
    Route::get('/emptycanstocklist', [App\Http\Controllers\Manufacturer\Stock\StockController::class, 'emptyCanStockList'])->name('emptyCanStockList');
    Route::get('/filledcanstocklist', [App\Http\Controllers\Manufacturer\Stock\StockController::class, 'filledCanStockList'])->name('filledCanStockList');

    //Hub Stock Data
    Route::get('hubstocksview', [App\Http\Controllers\Hub\Stock\StockController::class, 'hubStocksView'])->name('hubStocksView');
    Route::get('/hubstocks/{id?}', [App\Http\Controllers\Hub\Stock\StockController::class, 'hubStocks'])->name('hubStocks');
    Route::get('/hubproductstockdata', [App\Http\Controllers\Hub\Stock\StockController::class, 'hubProductStockData'])->name('hubProductStockData');
    Route::get('/hubemptycanstocklist', [App\Http\Controllers\Hub\Stock\StockController::class, 'hubEmptyCanStockList'])->name('hubEmptyCanStockList');
    Route::get('/hubfilledcanstocklist', [App\Http\Controllers\Hub\Stock\StockController::class, 'hubFilledCanStockList'])->name('hubFilledCanStockList');

    //Hub Stock Data
    Route::get('logisticstocksview', [App\Http\Controllers\Logistic\Stock\StockController::class, 'logisticStocksView'])->name('logisticStocksView');
    Route::get('/logisticstocks/{id?}', [App\Http\Controllers\Logistic\Stock\StockController::class, 'logisticStocks'])->name('logisticStocks');
    Route::get('/logisticproductstockdata', [App\Http\Controllers\Logistic\Stock\StockController::class, 'logisticProductStockData'])->name('logisticProductStockData');
    Route::get('/logisticemptycanstocklist', [App\Http\Controllers\Logistic\Stock\StockController::class, 'logisticEmptyCanStockList'])->name('logisticEmptyCanStockList');
    Route::get('/logisticfilledcanstocklist', [App\Http\Controllers\Logistic\Stock\StockController::class, 'logisticFilledCanStockList'])->name('logisticFilledCanStockList');

    //hub-order
    Route::get('/hub/orders', [App\Http\Controllers\Admin\OrderManagement\HubOrdersController::class, 'hubOrders'])->name('huborders');
    Route::get('/get/hubs', [App\Http\Controllers\Admin\OrderManagement\HubOrdersController::class, 'getHubs'])->name('gethub');
    Route::get('/hub/data', [App\Http\Controllers\Admin\OrderManagement\HubOrdersController::class, 'hubOrderData'])->name('huborderdata');
    Route::get('/huborderlist/{id?}', [App\Http\Controllers\Admin\OrderManagement\HubOrdersController::class, 'hubOrderList'])->name('huborderlist');
    Route::get('/huborderdetail', [App\Http\Controllers\Admin\OrderManagement\HubOrdersController::class, 'hubOrderDetail'])->name('huborderdetail');
    Route::post('/assign/order', [App\Http\Controllers\Admin\OrderManagement\HubOrdersController::class, 'assignDeliveryPerson'])->name('assignorder');

    //Cancel Order
    Route::get('/cancelledorders', [App\Http\Controllers\Admin\OrderManagement\CancelledOrdersController::class, 'cancelledOrders'])->name('cancelledorders');
    Route::get('/cancelorder/data/', [App\Http\Controllers\Admin\OrderManagement\CancelledOrdersController::class, 'cancelledOrdersData'])->name('cancelledordersdata');

    //Pending Ordres
    Route::get('/pendingorders', [App\Http\Controllers\Admin\OrderManagement\PendingOrdersController::class, 'pendingOrders'])->name('pendingorders');
    Route::get('/pendingorder/data/', [App\Http\Controllers\Admin\OrderManagement\PendingOrdersController::class, 'pendingOrdersData'])->name('pendingordersdata');

    //expense
    Route::get('/expense', [App\Http\Controllers\Admin\Accounts\ExpenseController::class, 'expenses'])->name('expenses');
    Route::post('/expenses/create', [App\Http\Controllers\Admin\Accounts\ExpenseController::class, 'expenseCreate'])->name('expensecreate');
    Route::get('/expenselist', [App\Http\Controllers\Admin\Accounts\ExpenseController::class, 'expenseList'])->name('expenselist');
    Route::get('/expense/data', [App\Http\Controllers\Admin\Accounts\ExpenseController::class, 'expenseData'])->name('expensedata');
    Route::get('/expense/employeedata', [App\Http\Controllers\Admin\Accounts\ExpenseController::class, 'expenseEmployeeData'])->name('expenseemployeedata');
    Route::get('/get/ledgerbalanceinfo', [App\Http\Controllers\Admin\Accounts\ExpenseController::class, 'LedgerBalanceInfo'])->name('ledgerbalanceinfo');
    Route::get('update/expensecancel/{id}', [App\Http\Controllers\Admin\Accounts\ExpenseController::class, 'updateCancelStatus'])->name('expenseupdatecancelstatus');
    Route::get('export/expense', [App\Http\Controllers\Admin\Accounts\ExpenseController::class, 'export'])->name('expenses.export');

    //payments
    Route::get('/payments', [App\Http\Controllers\Admin\Accounts\PaymentsController::class, 'payments'])->name('payments');
    Route::get('/get/genaralexpense', [App\Http\Controllers\Admin\Accounts\PaymentsController::class, 'paymentsForExpense'])->name('paymentexpense');
    Route::get('/get/balanceinfo', [App\Http\Controllers\Admin\Accounts\PaymentsController::class, 'BalanceInfo'])->name('paymentbalanceinfo');
    Route::get('/get/pendingbills', [App\Http\Controllers\Admin\Accounts\PaymentsController::class, 'getPendingBillsData'])->name('getpendingbills');
    Route::post('/payments/create', [App\Http\Controllers\Admin\Accounts\PaymentsController::class, 'createPayment'])->name('paymentcreate');
    Route::get('/paymentslist', [App\Http\Controllers\Admin\Accounts\PaymentsController::class, 'paymentsList'])->name('paymentslist');
    Route::get('/generalpayment/data', [App\Http\Controllers\Admin\Accounts\PaymentsController::class, 'generalPaymentData'])->name('generalpaymentdata');
    Route::get('/employeepayment/data', [App\Http\Controllers\Admin\Accounts\PaymentsController::class, 'employeePaymentData'])->name('employeepaymentdata');
    Route::get('update/paymnetcancel/{id}', [App\Http\Controllers\Admin\Accounts\PaymentsController::class, 'updateCancelStatus'])->name('updatecancelstatus');

    //Stock Outwart
    Route::get('/stockoutward', [App\Http\Controllers\Admin\Accounts\StockOutwardController::class, 'StockOutward'])->name('stockoutward');
    Route::post('/addStockoutward', [App\Http\Controllers\Admin\Accounts\StockOutwardController::class, 'addStockOutward'])->name('add.stockoutward');
    Route::get('/stockoutwardlist', [App\Http\Controllers\Admin\Accounts\StockOutwardController::class, 'stockOutwardList'])->name('stockoutwardlist');
    Route::get('/stockoutwarddata', [App\Http\Controllers\Admin\Accounts\StockOutwardController::class, 'stockOutwardData'])->name('stockOutwardData');

    //Stock Outwart
    Route::get('/adminorder', [App\Http\Controllers\Admin\AdminOrders\AdminOrderController::class, 'adminOrders'])->name('adminOrders');
    Route::post('/addadminorder', [App\Http\Controllers\Admin\AdminOrders\AdminOrderController::class, 'addAdminOrder'])->name('add.addadminorder');
    Route::get('/adminorderlist', [App\Http\Controllers\Admin\AdminOrders\AdminOrderController::class, 'adminOrderList'])->name('adminorderlist');
    Route::get('/adminoderdata', [App\Http\Controllers\Admin\AdminOrders\AdminOrderController::class, 'adminOrderData'])->name('adminoderdata');

    //Discount Management
    Route::get('/generatecoupon', [App\Http\Controllers\Admin\DiscountManagement\CouponController::class, 'generateCoupon'])->name('generate-coupon');
    Route::post('/add/generatecoupon', [App\Http\Controllers\Admin\DiscountManagement\CouponController::class, 'addgenerateCoupon'])->name('add.generatecoupon');
    Route::get('/generatecoupon/data', [App\Http\Controllers\Admin\DiscountManagement\CouponController::class, 'getgenerateCouponData'])->name('get.generatecoupon');
    Route::post('/coupon/{id}/{status}', [App\Http\Controllers\Admin\DiscountManagement\CouponController::class, 'activeStatus'])->name('coupon.status');
    Route::get('/getcoupon/{id}', [App\Http\Controllers\Admin\DiscountManagement\CouponController::class, 'getCouponById'])->name('get.couponbyid');
    Route::get('/delete/coupon/{id}', [App\Http\Controllers\Admin\DiscountManagement\CouponController::class, 'deleteCoupon'])->name('delete.coupon');

    //Refferal History
    Route::get('/referralhistory', [App\Http\Controllers\Admin\DiscountManagement\ReferralHistoryController::class, 'referralHistory'])->name('referral-history');
    Route::get('/refferalcustomer/data/{type?}', [App\Http\Controllers\Admin\DiscountManagement\ReferralHistoryController::class, 'getRefferalCustomerdata'])->name('get.referralcustomer');
    Route::get('/referralcode/{id}', [App\Http\Controllers\Admin\DiscountManagement\ReferralHistoryController::class, 'referralCode'])->name('referral-code');

    //Offers
    Route::get('/offer/{id?}', [App\Http\Controllers\Admin\Offer\OffersController::class, 'offers'])->name('offers');
    Route::post('/add/offers', [App\Http\Controllers\Admin\Offer\OffersController::class, 'offersCreate'])->name('add.offers');
    Route::get('/offers/data/{type?}', [App\Http\Controllers\Admin\Offer\OffersController::class, 'getOffersData'])->name('get.offersdata');
    Route::post('/offers/{id}/{status}', [App\Http\Controllers\Admin\Offer\OffersController::class, 'activeStatus'])->name('offers.status');
    Route::get('/getoffers/{id}', [App\Http\Controllers\Admin\Offer\OffersController::class, 'getOfferById'])->name('get.offerbyid');
    Route::get('/delete/offers/{id}', [App\Http\Controllers\Admin\Offer\OffersController::class, 'deleteOffers'])->name('delete.offers');

    //offer allocate
    Route::get('/offersallocate', [App\Http\Controllers\Admin\Offer\OffersAllocateController::class, 'offersAllocate'])->name('offers-allocate');
    Route::post('/get/offerallocation/hubs/', [App\Http\Controllers\Admin\Offer\OffersAllocateController::class, 'getHubs'])->name('getofferallocatehubs');
    Route::post('/add/offerallocation', [App\Http\Controllers\Admin\Offer\OffersAllocateController::class, 'addOfferAllocation'])->name('add.offerallocation');
    Route::get('/offerallocate/data', [App\Http\Controllers\Admin\Offer\OffersAllocateController::class, 'getOfferAllocatedata'])->name('get.offerallocateddata');
    Route::get('/getofferallocation/{id}', [App\Http\Controllers\Admin\Offer\OffersAllocateController::class, 'getOfferAllocationById'])->name('get.offerallocatedbyid');
    Route::post('/get/offerallocation/pointsallocation', [App\Http\Controllers\Admin\Offer\OffersAllocateController::class, 'getPointsAllocation'])->name('get.pointsallocation');

    //Manufacturer Management
    Route::get('/manufacturer/{id?}', [App\Http\Controllers\Admin\ManufacturerManagement\ManufacturerController::class, 'manufacturer'])->name('manufacturer');
    Route::get('/manufacturerlist', [App\Http\Controllers\Admin\ManufacturerManagement\ManufacturerController::class, 'manufacturerList'])->name('manufacturer-list');
    Route::get('/manufacturerview', [App\Http\Controllers\Admin\ManufacturerManagement\ManufacturerController::class, 'view'])->name('manufacturer-view');
    Route::post('/manufacture-create', [App\Http\Controllers\Admin\ManufacturerManagement\ManufacturerController::class, 'manufactureCreate'])->name('manufacture-create');
    Route::post('/manufacture-update/{id?}', [App\Http\Controllers\Admin\ManufacturerManagement\ManufacturerController::class, 'manufactureUpdate'])->name('manufacture-update');
    Route::post('/get-manufacturerlist', [App\Http\Controllers\Admin\ManufacturerManagement\ManufacturerController::class, 'get_manufacturerlist'])->name('get-manufacturerlist');
    Route::get('/manufacturerData/{type?}', [App\Http\Controllers\Admin\ManufacturerManagement\ManufacturerController::class, 'manufacturerData'])->name('manufacturerData');
    Route::post('manufacturer/{id}/{status}', [App\Http\Controllers\Admin\ManufacturerManagement\ManufacturerController::class, 'activeStatus'])->name('activeManufacturerStatus');
    Route::get('delete/manufacturer/{id}', [App\Http\Controllers\Admin\ManufacturerManagement\ManufacturerController::class, 'deleteManufacturer'])->name('delete.manufacturer');
    Route::get('manufacturerdocument/{id}', [App\Http\Controllers\Admin\ManufacturerManagement\ManufacturerController::class, 'manufactureDocument'])->name('manufacturedocument');
    Route::post('/verifymanufacturerdocument/{id}/{status}', [App\Http\Controllers\Admin\ManufacturerManagement\ManufacturerController::class, 'verifyDocument'])->name('manufactureverifydocument');

    //Hub Management
    Route::get('/hub/{id?}', [App\Http\Controllers\Admin\HubManagement\HubController::class, 'hub'])->name('hub');
    Route::post('/hub-create', [App\Http\Controllers\Admin\HubManagement\HubController::class, 'hubCreate'])->name('hub-create');
    Route::post('/hub-update/{id?}', [App\Http\Controllers\Admin\HubManagement\HubController::class, 'hubUpdate'])->name('hub-update');
    Route::get('/hublist', [App\Http\Controllers\Admin\HubManagement\HubController::class, 'hubList'])->name('hub-list');
    Route::get('/hubData/{type?}', [App\Http\Controllers\Admin\HubManagement\HubController::class, 'hubData'])->name('hubData');
    Route::post('hub/{id}/{status}', [App\Http\Controllers\Admin\HubManagement\HubController::class, 'activeHubStatus'])->name('activeHubStatus');
    Route::get('delete/hub/{id}', [App\Http\Controllers\Admin\HubManagement\HubController::class, 'deleteHub'])->name('deletehub');
    Route::post('/vehicle/info', [App\Http\Controllers\Admin\HubManagement\HubController::class, 'addVehicleInfo'])->name('addvehicleinfo');
    Route::get('/get/hubcoordinates', [App\Http\Controllers\Admin\HubManagement\HubController::class, 'getHubCoordinates'])->name('gethubcoordinates');
    Route::get('hubdocument/{id}', [App\Http\Controllers\Admin\HubManagement\HubController::class, 'hubDocument'])->name('hubdocument');
    Route::post('/verifyhubdocument/{id}/{status}', [App\Http\Controllers\Admin\HubManagement\HubController::class, 'verifyDocument'])->name('hubverifydocument');
    Route::post('/get/brands', [App\Http\Controllers\Admin\HubManagement\HubController::class, 'getBrands'])->name('getvehiclebrands');
    Route::post('/get/manufacturer', [App\Http\Controllers\Admin\HubManagement\HubController::class, 'getManufacturer'])->name('getManufacturer');

    //Delivery Person Management
    Route::get('/deliveryperson/{id?}', [App\Http\Controllers\Admin\DeliveryPersonManagement\DeliveryPersonController::class, 'deliveryPerson'])->name('deliveryperson');
    Route::get('delivery/person/data/{type?}', [App\Http\Controllers\Admin\DeliveryPersonManagement\DeliveryPersonController::class, 'getdeliveryPersonData'])->name('get.deliveryperson');
    Route::post('deliveryperson/{id}/{status}', [App\Http\Controllers\Admin\DeliveryPersonManagement\DeliveryPersonController::class, 'activeStatus'])->name('activeDeliveryPersonStatus');
    Route::get('getdeliveryperson/{id}', [App\Http\Controllers\Admin\DeliveryPersonManagement\DeliveryPersonController::class, 'getDeliveryPersonById'])->name('get.deliverypersonbyid');
    Route::get('/deliverypersonlist', [App\Http\Controllers\Admin\DeliveryPersonManagement\DeliveryPersonController::class, 'deliveryPersonList'])->name('deliverypersonlist');
    Route::get('/hubdeliverypersonlist', [App\Http\Controllers\Admin\DeliveryPersonManagement\DeliveryPersonController::class, 'deliveryPersonList']);
    Route::post('/deliverypersoncreate', [App\Http\Controllers\Admin\DeliveryPersonManagement\DeliveryPersonController::class, 'deliveryPersonCreate'])->name('deliverypersoncreate');
    Route::get('delete/deliverperson/{id}', [App\Http\Controllers\Admin\DeliveryPersonManagement\DeliveryPersonController::class, 'Deletedeliveryperson'])->name('deletedeliveryperson');
    Route::post('/deliveryperson/list', [App\Http\Controllers\Admin\DeliveryPersonManagement\DeliveryPersonController::class, 'deliveryListFilter'])->name('deliverypersonfilter');
    Route::get('/get/vehicleinfo', [App\Http\Controllers\Admin\DeliveryPersonManagement\DeliveryPersonController::class, 'vehicleInfo'])->name('deliverypersonvechicleinfo');
    Route::get('/deliverypeopledocument/{id}', [App\Http\Controllers\Admin\DeliveryPersonManagement\DeliveryPersonController::class, 'deliveryPeopleDocument'])->name('deliverypeopledocument');
    Route::post('/verifydeliverypeopledocument/{id}/{status}', [App\Http\Controllers\Admin\DeliveryPersonManagement\DeliveryPersonController::class, 'verifyDocument'])->name('deliverypeopleverifydocument');

    //Logistic Management
    Route::get('/addlogistic/{id?}', [App\Http\Controllers\Admin\LogisticManagement\LogisticController::class, 'logisticPartner'])->name('logistic');
    Route::post('/logistic/create', [App\Http\Controllers\Admin\LogisticManagement\LogisticController::class, 'addLogisticPartner'])->name('logisticCreate');
    Route::get('/logisticData/{type?}', [App\Http\Controllers\Admin\LogisticManagement\LogisticController::class, 'logisticData'])->name('logisticData');
    Route::post('logistic/{id}/{status}', [App\Http\Controllers\Admin\LogisticManagement\LogisticController::class, 'activeStatus'])->name('activeLogisticStatus');
    Route::get('/logisticlist', [App\Http\Controllers\Admin\LogisticManagement\LogisticController::class, 'logisticPartnerList'])->name('logisticList');
    Route::get('delete/logisticlist/{id}', [App\Http\Controllers\Admin\LogisticManagement\LogisticController::class, 'DeletelogisticList'])->name('deletelogistic');
    Route::post('/get/hubs', [App\Http\Controllers\Admin\LogisticManagement\LogisticController::class, 'getHubs'])->name('gethubs');
    Route::get('logisticdocument/{id}', [App\Http\Controllers\Admin\LogisticManagement\LogisticController::class, 'logisticDocument'])->name('logisticdocument');
    Route::post('/verifylogisticdocument/{id}/{status}', [App\Http\Controllers\Admin\LogisticManagement\LogisticController::class, 'verifyDocument'])->name('logisticverifydocument');

    //add Logistic Vehicle info
    Route::get('/logisticvehicleinfo', [App\Http\Controllers\Admin\LogisticManagement\LogisticVehicleInfoController::class, 'logisticVehicleInfo'])->name('logisticVehicleInfo');
    Route::get('/vehicles', [App\Http\Controllers\Admin\LogisticManagement\LogisticVehicleInfoController::class, 'logisticVehicleInfo'])->name('vehicles');
    Route::post('/add/logisticvehicleinfo', [App\Http\Controllers\Admin\LogisticManagement\LogisticVehicleInfoController::class, 'addLogisticVehicleInfo'])->name('add.logisticVehicleInfo');
    Route::get('/delete/logisticvehicleinfo/{id}', [App\Http\Controllers\Admin\LogisticManagement\LogisticVehicleInfoController::class, 'deletLogisticVehicleInfo'])->name('delete.logisticVehicleInfo');
    Route::get('/getlogisticvehicleinfo/{id}', [App\Http\Controllers\Admin\LogisticManagement\LogisticVehicleInfoController::class, 'getLogisticVehicleInfoById'])->name('getLogisticVehicleInfoById');
    Route::get('/logisticvehicleinfo/data', [App\Http\Controllers\Admin\LogisticManagement\LogisticVehicleInfoController::class, 'getLogisticVehicleInfoData'])->name('get.logisticVehicleInfo');
    Route::post('/get-vehicle-brands-by-fuel-type/{fuelTypeId}', [App\Http\Controllers\Admin\LogisticManagement\LogisticVehicleInfoController::class, 'getVehicleBrandsByFuelType'])->name('getVehicleBrandsByFuelType');

    //add Logistic Driver Info
    Route::get('/logisticdriverinfo', [App\Http\Controllers\Admin\LogisticManagement\LogisticDriverInfoController::class, 'logisticDriverInfo'])->name('logisticDriverInfo');
    Route::get('/drivers', [App\Http\Controllers\Admin\LogisticManagement\LogisticDriverInfoController::class, 'logisticDriverInfo'])->name('drivers');
    Route::post('/add/logisticdriverinfo', [App\Http\Controllers\Admin\LogisticManagement\LogisticDriverInfoController::class, 'addLogisticDriverInfo'])->name('add.logisticDriverInfo');
    Route::get('/delete/logisticdriverinfo/{id}', [App\Http\Controllers\Admin\LogisticManagement\LogisticDriverInfoController::class, 'deletLogisticDriverInfo'])->name('delete.logisticDriverInfo');
    Route::get('/getlogisticdriverinfo/{id}', [App\Http\Controllers\Admin\LogisticManagement\LogisticDriverInfoController::class, 'getLogisticDriverInfoById'])->name('get.logisticDriverInfoById');
    Route::get('/logisticdriverinfo/data/{type?}', [App\Http\Controllers\Admin\LogisticManagement\LogisticDriverInfoController::class, 'getLogisticDriverInfoData'])->name('get.logisticDriverInfo');
    Route::post('/getLogisticVehicleById/{id}', [App\Http\Controllers\Admin\LogisticManagement\LogisticDriverInfoController::class, 'getLogisticVehicleById'])->name('getVehicleLogisticId');
    Route::post('/getHubsByLogisticId/{id}', [App\Http\Controllers\Admin\LogisticManagement\LogisticDriverInfoController::class, 'getHubsByLogisticId'])->name('getHubsByLogisticId');
    Route::post('/logisticdriverinfo/{id}/{status}', [App\Http\Controllers\Admin\LogisticManagement\LogisticDriverInfoController::class, 'activeStatus'])->name('logisticdriverinfo.status');

    //Customer Management
    Route::get('/customers', [App\Http\Controllers\Admin\CustomerManagement\CustomerController::class, 'customers'])->name('customers');
    Route::get('/customeroutstanding', [App\Http\Controllers\Admin\CustomerManagement\CustomerController::class, 'customerOutstandingList'])->name('customerOutstandingList');
    Route::get('/outstandingData', [App\Http\Controllers\Admin\CustomerManagement\CustomerController::class, 'outstandingData'])->name('outstandingData`');
    Route::get('/settledOutstanding', [App\Http\Controllers\Admin\CustomerManagement\CustomerController::class, 'doSettledOutstanding'])->name('doSettledOutstanding');
    Route::get('/collectedOutstanding', [App\Http\Controllers\Admin\CustomerManagement\CustomerController::class, 'doCollectedOutstanding'])->name('doCollectedOutstanding');
    Route::get('/customersData/{type?}', [App\Http\Controllers\Admin\CustomerManagement\CustomerController::class, 'customersData'])->name('getcustomers');
    Route::post('/customer/{id}/{status}', [App\Http\Controllers\Admin\CustomerManagement\CustomerController::class, 'activeStatus'])->name('customer.status');
    Route::get('/ordersData/{customer_id}', [App\Http\Controllers\Admin\CustomerManagement\CustomerController::class, 'getRecentOrdersdata'])->name('get.recentorders');
    Route::get('/customerfeedback', [App\Http\Controllers\Admin\CustomerManagement\CustomerController::class, 'customerFeedback'])->name('customerfeedback');
    Route::get('/customerfeedbackData', [App\Http\Controllers\Admin\CustomerManagement\CustomerController::class, 'customerFeedbackData'])->name('customerfeedbackdata');
    Route::get('/customersperformance', [App\Http\Controllers\Admin\CustomerManagement\CustomerController::class, 'customersPerformance'])->name('customers-performance');

    Route::get('/customerssummary/{id}', [App\Http\Controllers\Admin\CustomerManagement\CustomerController::class, 'customersSummary'])->name('customers-summary');
    Route::get('/depostihistory/{id}', [App\Http\Controllers\Admin\CustomerManagement\CustomerController::class, 'depostiHistory'])->name('depostiHistory');
    Route::get('/depositHistoryData/{customer_id}', [App\Http\Controllers\Admin\CustomerManagement\CustomerController::class, 'depositHistoryData'])->name('depositHistoryData');
    Route::get('/getRefundDetails/{id}', [App\Http\Controllers\Admin\CustomerManagement\CustomerController::class, 'getRefundDetails'])->name('getRefundDetails');

    Route::get('/surrendercan', [App\Http\Controllers\Admin\CustomerManagement\SurrenderCanController::class, 'SurrenderCan'])->name('surrender-can');
    Route::get('/surrenderrequests', [App\Http\Controllers\Admin\CustomerManagement\SurrenderCanController::class, 'SurrenderRequests'])->name('surrender-requests');
    Route::get('/surrenderrequest/data/', [App\Http\Controllers\Admin\CustomerManagement\SurrenderCanController::class, 'getSurrenderRequests'])->name('getsurrenderrequests');
    Route::get('/surrenderbankinfo/{id}', [App\Http\Controllers\Admin\CustomerManagement\SurrenderCanController::class, 'getSurrenderBankInfo'])->name('getSurrenderBankInfo');
    Route::get('/surrenderdetails/{id}', [App\Http\Controllers\Admin\CustomerManagement\SurrenderCanController::class, 'SurrenderRequestDetails'])->name('Surrenderrequestdetails');
    Route::get('/approve/{id}', [App\Http\Controllers\Admin\CustomerManagement\SurrenderCanController::class, 'SurrenderRequestApprove'])->name('Surrenderrequestapprove');
    Route::get('/processrefund/{id}', [App\Http\Controllers\Admin\CustomerManagement\SurrenderCanController::class, 'processRefund'])->name('processRefund');
    Route::post('/reject', [App\Http\Controllers\Admin\CustomerManagement\SurrenderCanController::class, 'SurrenderRequestReject'])->name('Surrenderrequestreject');

    //Feedback Management
    Route::get('/feedback', [App\Http\Controllers\Admin\FeedBack\FeedBackController::class, 'feedBack'])->name('feedback');

    //Reports Management
    // Route::get('/manufacturerreports', [App\Http\Controllers\Admin\Reports\ReportsController::class, 'manufacturerReports'])->name('manufacturer-reports');
    // Route::get('/hubreports', [App\Http\Controllers\Admin\Reports\ReportsController::class, 'hubReports'])->name('hub-reports');
    // Route::get('/deliveryreports', [App\Http\Controllers\Admin\Reports\ReportsController::class, 'deliveryReports'])->name('delivery-reports');
    // Route::get('/productsreports', [App\Http\Controllers\Admin\Reports\ReportsController::class, 'productsReports'])->name('products-reports');
    // Route::get('/ordersreports', [App\Http\Controllers\Admin\Reports\ReportsController::class, 'ordersReports'])->name('orders-reports');
    // Route::get('/paymentsreports', [App\Http\Controllers\Admin\Reports\ReportsController::class, 'paymentsReports'])->name('payments-reports');

    //Admin Stock Reports
    Route::get('/stockreports', [App\Http\Controllers\Admin\Reports\ReportsController::class, 'stockReports'])->name('stock-reports');
    //Manufacturer
    Route::get('/manufacturereports', [App\Http\Controllers\Admin\Reports\ReportsController::class, 'manufactureStockReports'])->name('stock_manufacture_reports');
    Route::get('/manufactureproductstockreport', [App\Http\Controllers\Admin\Reports\ReportsController::class, 'manufactureProductStockReport'])->name('manufactureProductStockReport');
    //Logistics
    Route::get('/logisticsreports', [App\Http\Controllers\Admin\Reports\ReportsController::class, 'logisticsStockReports'])->name('stock_logistics_reports');
    Route::get('/logisticproductstockreport', [App\Http\Controllers\Admin\Reports\ReportsController::class, 'logisticProductStockReport'])->name('logisticProductStockReport');
    //Hub
    Route::get('/hubreports', [App\Http\Controllers\Admin\Reports\ReportsController::class, 'hubStockReports'])->name('stock_hub_reports');
    Route::get('/hubproductstockreport', [App\Http\Controllers\Admin\Reports\ReportsController::class, 'hubProductStockReport'])->name('hubProductStockReport');
    //Delivery Person
    Route::get('/deliverypersonreports', [App\Http\Controllers\Admin\Reports\ReportsController::class, 'deliverypersonStockReports'])->name('stock_deliveryperson_reports');
    Route::get('/deliverypersonproductstockreport', [App\Http\Controllers\Admin\Reports\ReportsController::class, 'deliverypersonProductStockReport'])->name('deliverypersonProductStockReport');
    //Customer
    Route::get('/customerreports', [App\Http\Controllers\Admin\Reports\ReportsController::class, 'customerStockReports'])->name('stock_customer_reports');
    Route::get('/customersproductstockreport', [App\Http\Controllers\Admin\Reports\ReportsController::class, 'customersProductStockReport'])->name('customersProductStockReport');

    //service unavilabel report
    Route::get('/serviceunavailable', [App\Http\Controllers\Admin\Reports\ServiceUnavailableController::class, 'getServiceUnavailableReport'])->name('serviceunavilablereport');
    Route::get('/serviceunavilable/data', [App\Http\Controllers\Admin\Reports\ServiceUnavailableController::class, 'getServiceUnavailableReportData'])->name('serviceunavilablereportdata');

    //Settings
    Route::get('/settings', [App\Http\Controllers\Admin\Settings\SettingsController::class, 'settings'])->name('settings');
    Route::post('/settings-create', [App\Http\Controllers\Admin\Settings\SettingsController::class, 'settingsCreate'])->name('settings-create');
    Route::post('/settings-manufacturer', [App\Http\Controllers\Admin\Settings\SettingsController::class, 'settingsmanufacturer'])->name('settings-manufacturer');
    Route::post('/settings-hub', [App\Http\Controllers\Admin\Settings\SettingsController::class, 'settingshub'])->name('settings-hub');
    Route::post('/settings-logistic', [App\Http\Controllers\Admin\Settings\SettingsController::class, 'settingslogistic'])->name('settings-logistic');
    Route::post('/settings-customer', [App\Http\Controllers\Admin\Settings\SettingsController::class, 'settingscustomer'])->name('settings-customer');

    //Admin Settings
    Route::get('/admin/settings', [App\Http\Controllers\Admin\Settings\AdminSettingsController::class, 'AdminSettings'])->name('adminsettings');
    Route::post('/admin/settings-create', [App\Http\Controllers\Admin\Settings\AdminSettingsController::class, 'AdminSettingsCreate'])->name('adminsettingscreate');
    Route::post('/sms/settings-create', [App\Http\Controllers\Admin\Settings\AdminSettingsController::class, 'SmsSettingsCreate'])->name('smssettingscreate');
    Route::post('/Geo/apisettings-create', [App\Http\Controllers\Admin\Settings\AdminSettingsController::class, 'GeoApiSettingsCreate'])->name('geoapisettingscreate');

    //payment gateway
    Route::post('/paymentgateway/paymentgatewaycashondelivery-create/{payment_method_id}', [App\Http\Controllers\Admin\Settings\AdminSettingsController::class, 'PaymentGatewayCashonDeliveryCreate'])->name('paymentGatewateCashonDeliveryCreate');
    Route::post('/paymentgateway/paymentgatewayrazorpay-create/{payment_method_id}', [App\Http\Controllers\Admin\Settings\AdminSettingsController::class, 'PaymentGatewayRazorpayCreate'])->name('paymentGatewaterazorpaycreate');
    Route::post('/admin/maintenancemode/{id}/{status}', [App\Http\Controllers\Admin\Settings\AdminSettingsController::class, 'activeMaintenancemode'])->name('activemaintenancemode');

    //Payment Method Controller//
    Route::get('/paymentmethod', [App\Http\Controllers\Admin\Settings\PaymentConfigController::class, 'PaymentMethod'])->name('paymentmethod');
    Route::post('add/paymentmethod', [App\Http\Controllers\Admin\Settings\PaymentConfigController::class, 'addPaymentMethod'])->name('add.paymentmethod');
    Route::get('delete/paymentmethod/{id}', [App\Http\Controllers\Admin\Settings\PaymentConfigController::class, 'deletePaymentMethod'])->name('delete.paymentmethod');
    Route::get('paymentmethod/data', [App\Http\Controllers\Admin\Settings\PaymentConfigController::class, 'getPaymentMethodData'])->name('get.paymentmethod');
    Route::get('getpaymentmethod/{id}', [App\Http\Controllers\Admin\Settings\PaymentConfigController::class, 'getPaymentMethodById'])->name('getpaymentmethod');

    //Bill No Settings//
    Route::get('/billnosettings', [App\Http\Controllers\Admin\Settings\BillSettingsController::class, 'BillSettings'])->name('bill-settings');
    Route::post('add/masterbillnosettings', [App\Http\Controllers\Admin\Settings\BillSettingsController::class, 'addMasterBillSettings'])->name('masterbillsettings');

    //Referral settings
    Route::get('/referralsettings', [App\Http\Controllers\Admin\Settings\RefferalSettingsController::class, 'referralSettings'])->name('referral-points');
    Route::post('/add/referralpoints', [App\Http\Controllers\Admin\Settings\RefferalSettingsController::class, 'addReferralPoints'])->name('add.referralsettings');

    //Banners
    Route::get('/banners', [App\Http\Controllers\Admin\Settings\BannerController::class, 'banners'])->name('banners');
    Route::post('/add/banner', [App\Http\Controllers\Admin\Settings\BannerController::class, 'addBanner'])->name('addBanner');
    Route::get('delete/banner/{id}', [App\Http\Controllers\Admin\Settings\BannerController::class, 'deleteBanner'])->name('deleteBanner');
    Route::get('banner/data', [App\Http\Controllers\Admin\Settings\BannerController::class, 'getBannerData'])->name('getBannerData');
    Route::get('getbanner/{id}', [App\Http\Controllers\Admin\Settings\BannerController::class, 'getBannerById'])->name('getBanner');
    Route::post('banner/{id}/{status}', [App\Http\Controllers\Admin\Settings\BannerController::class, 'activeBannerStatus'])->name('activeBannerStatus');

    //Users Roles and Permissions Management
    Route::get('/users', [App\Http\Controllers\Admin\UserRightsManagement\UsersController::class, 'users'])->name('users');
    Route::post('/create-user', [App\Http\Controllers\Admin\UserRightsManagement\UsersController::class, 'createUser'])->name('create-user');
    Route::get('/listmenus/{id}', [App\Http\Controllers\Admin\UserRightsManagement\UsersController::class, 'listMenus'])->name('listmenus');
    Route::get('/userpermission/data', [App\Http\Controllers\Admin\UserRightsManagement\UsersController::class, 'getUserPermissionData'])->name('userpermission-data');
    Route::get('/getuserpermission/{id}', [App\Http\Controllers\Admin\UserRightsManagement\UsersController::class, 'getUserPermissionById'])->name('getUserPermission');
    Route::post('userpermission/{id}/{status}', [App\Http\Controllers\Admin\UserRightsManagement\UsersController::class, 'activeStatus'])->name('activeUserPermissionStatus');
    Route::get('delete/userpermission/{id}', [App\Http\Controllers\Admin\UserRightsManagement\UsersController::class, 'deleteUserPermission'])->name('delete.userpermission');
    Route::post('/check-mobile-number', [App\Http\Controllers\Admin\UserRightsManagement\UsersController::class, 'checkMobileNumber'])->name('checkMobileNumber');

    Route::get('/roles-permission', [App\Http\Controllers\Admin\UserRightsManagement\UserRightsController::class, 'rights'])->name('rights');
    Route::get('/get-menus', [App\Http\Controllers\Admin\UserRightsManagement\UserRightsController::class, 'getMenus'])->name('get-menus');
    Route::post('/create-permission', [App\Http\Controllers\Admin\UserRightsManagement\UserRightsController::class, 'createPermission'])->name('create-permission');
    Route::get('/permission/data', [App\Http\Controllers\Admin\UserRightsManagement\UserRightsController::class, 'getPermissionData'])->name('permission-data');
    Route::get('/getpermission/{id}', [App\Http\Controllers\Admin\UserRightsManagement\UserRightsController::class, 'getPermissionById'])->name('getPermission');
    Route::get('delete/permission/{id}', [App\Http\Controllers\Admin\UserRightsManagement\UserRightsController::class, 'deletePermission'])->name('delete.permission');

    //Products Management

    //Category
    Route::get('/category', [App\Http\Controllers\Admin\ProductsManagement\CategoryController::class, 'category'])->name('category');
    Route::post('add/category', [App\Http\Controllers\Admin\ProductsManagement\CategoryController::class, 'addCategory'])->name('add.category');
    Route::get('delete/category/{id}', [App\Http\Controllers\Admin\ProductsManagement\CategoryController::class, 'deleteCategory'])->name('delete.category');
    Route::get('category/data', [App\Http\Controllers\Admin\ProductsManagement\CategoryController::class, 'getCategoryData'])->name('get.category');
    Route::get('getcategory/{id}', [App\Http\Controllers\Admin\ProductsManagement\CategoryController::class, 'getCategoryById'])->name('getcategory');
    Route::post('category/{id}/{status}', [App\Http\Controllers\Admin\ProductsManagement\CategoryController::class, 'activeStatus'])->name('activeCategoryStatus');

    //product-Type
    Route::get('producttype', [App\Http\Controllers\Admin\ProductsManagement\ProductTypeController::class, 'prodctType'])->name('product-type');
    Route::post('add/product-type', [App\Http\Controllers\Admin\ProductsManagement\ProductTypeController::class, 'addProductType'])->name('add.prodctType');
    Route::get('delete/producttype/{id}', [App\Http\Controllers\Admin\ProductsManagement\ProductTypeController::class, 'deleteProductType'])->name('delete.prodctType');
    Route::get('producttype/data', [App\Http\Controllers\Admin\ProductsManagement\ProductTypeController::class, 'getProductTypeData'])->name('get.prodctType');
    Route::get('getproducttype/{id}', [App\Http\Controllers\Admin\ProductsManagement\ProductTypeController::class, 'getProductTypeById'])->name('getprodctType');
    Route::post('producttype/{id}/{status}', [App\Http\Controllers\Admin\ProductsManagement\ProductTypeController::class, 'activeStatus'])->name('activeProductTypeStatus');

    //Brands
    Route::get('/brands', [App\Http\Controllers\Admin\ProductsManagement\BrandsController::class, 'brands'])->name('brands');
    Route::get('/get/producttypes', [App\Http\Controllers\Admin\ProductsManagement\BrandsController::class, 'getProductTypes'])->name('getproducttype');
    Route::post('add/brands', [App\Http\Controllers\Admin\ProductsManagement\BrandsController::class, 'addBrands'])->name('add.brands');
    Route::get('delete/brands/{id}', [App\Http\Controllers\Admin\ProductsManagement\BrandsController::class, 'deleteBrands'])->name('delete.brands');
    Route::get('brands/data', [App\Http\Controllers\Admin\ProductsManagement\BrandsController::class, 'getBrandsData'])->name('get.brands');
    Route::get('getbrands/{id}', [App\Http\Controllers\Admin\ProductsManagement\BrandsController::class, 'getBrandsById'])->name('getbrands');
    Route::post('brands/{id}/{status}', [App\Http\Controllers\Admin\ProductsManagement\BrandsController::class, 'activeStatus'])->name('activeBrandStatus');

    //product
    Route::get('/products', [App\Http\Controllers\Admin\ProductsManagement\ProductsController::class, 'products'])->name('products');
    Route::get('/get/producttypesbrands', [App\Http\Controllers\Admin\ProductsManagement\ProductsController::class, 'getProductTypesBrands'])->name('getproducttypebrands');
    Route::post('add/products', [App\Http\Controllers\Admin\ProductsManagement\ProductsController::class, 'addProducts'])->name('add.products');
    Route::get('delete/products/{id}', [App\Http\Controllers\Admin\ProductsManagement\ProductsController::class, 'deleteProducts'])->name('delete.products');
    Route::get('products/data', [App\Http\Controllers\Admin\ProductsManagement\ProductsController::class, 'getProductsData'])->name('get.products');
    Route::get('getproducts/{id}', [App\Http\Controllers\Admin\ProductsManagement\ProductsController::class, 'getProductsById'])->name('getproducts');
    Route::post('products/{id}/{status}', [App\Http\Controllers\Admin\ProductsManagement\ProductsController::class, 'activeStatus'])->name('activeProductStatus');

    //Masters

    //state
    Route::get('/state', [App\Http\Controllers\Admin\Masters\StateController::class, 'state'])->name('state');
    Route::get('/syncstate', [App\Http\Controllers\Admin\Masters\StateController::class, 'syncState'])->name('syncState');
    Route::get('state/data', [App\Http\Controllers\Admin\Masters\StateController::class, 'getStateData'])->name('getstatedata');
    Route::post('state/{id}/{status}', [App\Http\Controllers\Admin\Masters\StateController::class, 'activeStatus'])->name('activeStateStatus');
    Route::post('get-states', [App\Http\Controllers\Admin\Masters\StateController::class, 'getStaesByCountry'])->name('get-states');

    //city
    Route::get('/city', [App\Http\Controllers\Admin\Masters\CityController::class, 'city'])->name('city');
    Route::get('/synccity', [App\Http\Controllers\Admin\Masters\CityController::class, 'syncCity'])->name('synccity');
    Route::get('city/data', [App\Http\Controllers\Admin\Masters\CityController::class, 'getCityData'])->name('getcitydata');
    Route::post('city/{id}/{status}', [App\Http\Controllers\Admin\Masters\CityController::class, 'activeStatus'])->name('activeCityStatus');
    Route::post('/get-city', [App\Http\Controllers\Admin\Masters\CityController::class, 'getCityByStates'])->name('get-city');

    //area
    Route::get('/area', [App\Http\Controllers\Admin\Masters\AreaController::class, 'area'])->name('area');
    Route::post('get/cities', [App\Http\Controllers\Admin\Masters\AreaController::class, 'getCity'])->name('getcity');
    Route::post('add/area', [App\Http\Controllers\Admin\Masters\AreaController::class, 'addArea'])->name('add.area');
    Route::get('delete/area/{id}', [App\Http\Controllers\Admin\Masters\AreaController::class, 'deleteArea'])->name('delete.area');
    Route::get('area/data', [App\Http\Controllers\Admin\Masters\AreaController::class, 'getAreaData'])->name('get.area');
    Route::get('getarea/{id}', [App\Http\Controllers\Admin\Masters\AreaController::class, 'getAreaById'])->name('getarea');
    Route::post('area/{id}/{status}', [App\Http\Controllers\Admin\Masters\AreaController::class, 'activeStatus'])->name('activeAreaStatus');
    Route::post('getareabycity', [App\Http\Controllers\Admin\Masters\AreaController::class, 'getAreaByCity'])->name('getareabycity');

    ///Expense Group
    Route::get('/expensegroup', [App\Http\Controllers\Admin\Masters\ExpenseGroupController::class, 'expenseGroup'])->name('expensegroup');
    Route::post('add/expensegroup', [App\Http\Controllers\Admin\Masters\ExpenseGroupController::class, 'addExpenseGroup'])->name('addexpensegroup');
    Route::get('expensegroup/data', [App\Http\Controllers\Admin\Masters\ExpenseGroupController::class, 'getExpenseGroupdata'])->name('get.expensegroup');
    Route::post('expensegroup/{id}/{status}', [App\Http\Controllers\Admin\Masters\ExpenseGroupController::class, 'activeStatus'])->name('activeExpensegroupStatus');
    Route::get('getexpensegroup/{id}', [App\Http\Controllers\Admin\Masters\ExpenseGroupController::class, 'getExpensegroupById'])->name('getexpensegroup');
    Route::get('delete/expensegroup/{id}', [App\Http\Controllers\Admin\Masters\ExpenseGroupController::class, 'deleteExpensegroup'])->name('delete.expensegroup');

    //ledger
    Route::get('/ledger', [App\Http\Controllers\Admin\Masters\LedgerController::class, 'ledger'])->name('ledger');
    Route::post('add/ledger', [App\Http\Controllers\Admin\Masters\LedgerController::class, 'addLedger'])->name('addledger');
    Route::get('ledger/data', [App\Http\Controllers\Admin\Masters\LedgerController::class, 'getLedgerdata'])->name('getledger');
    Route::post('ledger/{id}/{status}', [App\Http\Controllers\Admin\Masters\LedgerController::class, 'activeStatus'])->name('activeLedgerstatus');
    Route::get('getledger/{id}', [App\Http\Controllers\Admin\Masters\LedgerController::class, 'getLedgerById'])->name('getledgerbyid');
    Route::get('delete/ledger/{id}', [App\Http\Controllers\Admin\Masters\LedgerController::class, 'deleteLedger'])->name('delete.ledger');

    //Brand-Allocation
    Route::get('allocationbrands/data', [App\Http\Controllers\Admin\Masters\AllocationController::class, 'brandsData'])->name('getbrandsdata');
    Route::get('/allocate/brand', [App\Http\Controllers\Admin\Masters\AllocationController::class, 'allocateBrand'])->name('allocatebrand');

    Route::get('/allocation', [App\Http\Controllers\Admin\Masters\AllocationController::class, 'allocation'])->name('allocations');
    Route::post('add/brandallocate', [App\Http\Controllers\Admin\Masters\AllocationController::class, 'addBrandallocate'])->name('addBrandallocate');
    Route::get('delete/brandallocate/{id}', [App\Http\Controllers\Admin\Masters\AllocationController::class, 'deleteBrandallocate'])->name('delete.Brandallocate');
    Route::get('brandallocate/data', [App\Http\Controllers\Admin\Masters\AllocationController::class, 'getBrandallocateData'])->name('get.Brandallocate');
    Route::get('getbrandallocate/{id}', [App\Http\Controllers\Admin\Masters\AllocationController::class, 'getBrandallocateById'])->name('getBrandallocate');
    Route::get('/get/producttype', [App\Http\Controllers\Admin\Masters\AllocationController::class, 'getProductType'])->name('getproducttypes');

    //department
    Route::get('/department', [App\Http\Controllers\Admin\Masters\DepartmentController::class, 'department'])->name('department');
    Route::post('add/department', [App\Http\Controllers\Admin\Masters\DepartmentController::class, 'addDepartment'])->name('add.department');
    Route::get('delete/department/{id}', [App\Http\Controllers\Admin\Masters\DepartmentController::class, 'deleteDepartment'])->name('delete.department');
    Route::get('department/data', [App\Http\Controllers\Admin\Masters\DepartmentController::class, 'getDepartmentData'])->name('get.department');
    Route::get('getdepartment/{id}', [App\Http\Controllers\Admin\Masters\DepartmentController::class, 'getDepartmentById'])->name('getdepartment');
    Route::post('department/{id}/{status}', [App\Http\Controllers\Admin\Masters\DepartmentController::class, 'activeStatus'])->name('activeDepartmentStatus');

    //Banks
    Route::get('/banks', [App\Http\Controllers\Admin\Masters\BankController::class, 'Banks'])->name('bank');
    Route::post('/add/banks', [App\Http\Controllers\Admin\Masters\BankController::class, 'addBank'])->name('add.bank');
    Route::get('/bank/data', [App\Http\Controllers\Admin\Masters\BankController::class, 'getBankData'])->name('get.bank');
    Route::get('/getbank/{id}', [App\Http\Controllers\Admin\Masters\BankController::class, 'getBankById'])->name('getbank');
    Route::get('/delete/bank/{id}', [App\Http\Controllers\Admin\Masters\BankController::class, 'deleteBank'])->name('delete.bank');

    //Designation
    Route::get('/designation', [App\Http\Controllers\Admin\Masters\DesignationController::class, 'designation'])->name('designation');
    Route::post('add/designation', [App\Http\Controllers\Admin\Masters\DesignationController::class, 'addDesignation'])->name('add.designation');
    Route::get('delete/designation/{id}', [App\Http\Controllers\Admin\Masters\DesignationController::class, 'deleteDesignation'])->name('delete.designation');
    Route::get('designation/data', [App\Http\Controllers\Admin\Masters\DesignationController::class, 'getDesignationData'])->name('get.designation');
    Route::get('getdesignation/{id}', [App\Http\Controllers\Admin\Masters\DesignationController::class, 'getDesignationById'])->name('getdesignation');
    Route::post('designation/{id}/{status}', [App\Http\Controllers\Admin\Masters\DesignationController::class, 'activeStatus'])->name('activeDesignationStatus');

    //role
    Route::get('/role', [App\Http\Controllers\Admin\Masters\RoleController::class, 'role'])->name('role');
    Route::post('/updaterole', [App\Http\Controllers\Admin\Masters\RoleController::class, 'updateRole'])->name('updaterole');
    Route::get('role/data', [App\Http\Controllers\Admin\Masters\RoleController::class, 'getRoleData'])->name('getroledata');
    Route::get('role/{id}', [App\Http\Controllers\Admin\Masters\RoleController::class, 'getRoleById'])->name('getroles');

    //Vehicle Brands
    Route::get('/vehiclebrands', [App\Http\Controllers\Admin\Masters\VehicleBrandController::class, 'vehicleBrands'])->name('vehiclebrands');
    Route::post('add/vehiclebrands', [App\Http\Controllers\Admin\Masters\VehicleBrandController::class, 'addVehicleBrands'])->name('add.vehiclebrands');
    Route::get('delete/vehiclebrands/{id}', [App\Http\Controllers\Admin\Masters\VehicleBrandController::class, 'deletVehicleBrands'])->name('delete.vehiclebrands');
    Route::get('getvehiclebrands/{id}', [App\Http\Controllers\Admin\Masters\VehicleBrandController::class, 'getVehicleBrandnById'])->name('getehiclebrands');
    Route::get('vehiclebrands/data', [App\Http\Controllers\Admin\Masters\VehicleBrandController::class, 'getVehicleBrandsData'])->name('get.vehiclebrands');

    //Employee
    Route::get('/employee/{id?}', [App\Http\Controllers\Admin\Masters\EmployeeController::class, 'employee'])->name('employee');
    Route::post('/employee-create', [App\Http\Controllers\Admin\Masters\EmployeeController::class, 'employeeCreate'])->name('employee-create');
    Route::post('/employee-update', [App\Http\Controllers\Admin\Masters\EmployeeController::class, 'employeeUpdate'])->name('employee-update');
    Route::get('/employeelist', [App\Http\Controllers\Admin\Masters\EmployeeController::class, 'employeeList'])->name('employee-list');
    Route::get('delete/employee/{id}', [App\Http\Controllers\Admin\Masters\EmployeeController::class, 'deleteEmp'])->name('delete.epmloyee');
    Route::get('employees/data', [App\Http\Controllers\Admin\Masters\EmployeeController::class, 'getEmployeeData'])->name('employeedata');
    Route::post('employee/{id}/{status}', [App\Http\Controllers\Admin\Masters\EmployeeController::class, 'activeStatus'])->name('employeeactive');
    Route::post('get/assetname', [App\Http\Controllers\Admin\Masters\EmployeeController::class, 'getAssetName'])->name('getassetname');
    Route::get('employeedocument/{id}', [App\Http\Controllers\Admin\Masters\EmployeeController::class, 'employeeDocument'])->name('employeedocument');
    Route::post('/verifyemployeedocument/{id}/{status}', [App\Http\Controllers\Admin\Masters\EmployeeController::class, 'verifyDocument'])->name('employeeverifydocument');

    //DocumentType  
    Route::get('/documenttype', [App\Http\Controllers\Admin\Masters\DocumentController::class, 'documentType'])->name('documenttype');
    Route::post('add/documenttype', [App\Http\Controllers\Admin\Masters\DocumentController::class, 'addDocumentType'])->name('addDocumenttype');
    Route::get('delete/documenttype/{id}', [App\Http\Controllers\Admin\Masters\DocumentController::class, 'deleteDocumentType'])->name('delete.documenttype');
    Route::get('documenttype/data', [App\Http\Controllers\Admin\Masters\DocumentController::class, 'getDocumentTypeData'])->name('get.documenttype');
    Route::get('getdocumenttype/{id}', [App\Http\Controllers\Admin\Masters\DocumentController::class, 'getDocumentTypeById'])->name('getdocumenttype');

    //Documents Configuration
    Route::get('documentconfig', [App\Http\Controllers\Admin\Masters\DocumentConfigController::class, 'documentConfig'])->name('documentconfig');
    Route::post('add/documentconfig', [App\Http\Controllers\Admin\Masters\DocumentConfigController::class, 'adddocumentConfig'])->name('adddocumentconfig');
    Route::get('delete/documentconfig/{id}', [App\Http\Controllers\Admin\Masters\DocumentConfigController::class, 'deletedocumentConfig'])->name('delete.documentconfig');
    Route::get('documentconfig/data', [App\Http\Controllers\Admin\Masters\DocumentConfigController::class, 'getdocumentConfigData'])->name('get.documentconfig');
    Route::get('documentconfig/{id}/{type}', [App\Http\Controllers\Admin\Masters\DocumentConfigController::class, 'getdocumentConfigById'])->name('getdocumentconfig');
    Route::post('documentconfig/{id}/{status}', [App\Http\Controllers\Admin\Masters\DocumentConfigController::class, 'activeStatus'])->name('activedocumentconfigStatus');

    //Reason Type Masters
    Route::get('/reasons', [App\Http\Controllers\Admin\Masters\ReasonController::class, 'Reasons'])->name('reasons');
    Route::post('/add/reasons', [App\Http\Controllers\Admin\Masters\ReasonController::class, 'addReasons'])->name('add.reasons');
    Route::get('/reasons/data', [App\Http\Controllers\Admin\Masters\ReasonController::class, 'getReasonsdata'])->name('get.reasons');
    Route::get('/getreasons/{id}', [App\Http\Controllers\Admin\Masters\ReasonController::class, 'getReasonsById'])->name('getreasonsbyid');
    Route::get('/delete/reasons/{id}', [App\Http\Controllers\Admin\Masters\ReasonController::class, 'deleteReasons'])->name('delete.deletereasons');

    //Asset Type
    Route::get('/assettype', [App\Http\Controllers\Admin\Masters\AssetTypeController::class, 'assetType'])->name('asset-type');
    Route::post('add/assettype', [App\Http\Controllers\Admin\Masters\AssetTypeController::class, 'addAssetType'])->name('add.asset-type');
    Route::get('assettype/data', [App\Http\Controllers\Admin\Masters\AssetTypeController::class, 'getAssetTypeData'])->name('get.asset-type');
    Route::get('getassettype/{id}', [App\Http\Controllers\Admin\Masters\AssetTypeController::class, 'getAssetTypeById'])->name('getasset-type');
    Route::get('delete/assettype/{id}', [App\Http\Controllers\Admin\Masters\AssetTypeController::class, 'deleteAssetType'])->name('delete.asset-type');

    //Asset////
    Route::get('/asset', [App\Http\Controllers\Admin\Masters\AssetController::class, 'asset'])->name('asset');
    Route::post('add/asset', [App\Http\Controllers\Admin\Masters\AssetController::class, 'addAsset'])->name('add.asset');
    Route::get('asset/data', [App\Http\Controllers\Admin\Masters\AssetController::class, 'getAssetData'])->name('get.asset');
    Route::get('getasset/{id}', [App\Http\Controllers\Admin\Masters\AssetController::class, 'getAssetById'])->name('getasset');
    Route::get('delete/asset/{id}', [App\Http\Controllers\Admin\Masters\AssetController::class, 'deleteAsset'])->name('delete.asset');
    Route::post('get/assetid', [App\Http\Controllers\Admin\Masters\AssetController::class, 'getAssetId'])->name('getassetid');

    //Wallet Transaction Type
    Route::get('/wallet-transaction-through', [App\Http\Controllers\Admin\Settings\WalletTransactionThroughController::class, 'walletTransactionThrough'])->name('wallettransactionthrough');
    Route::post('/add/wallet-transaction-through', [App\Http\Controllers\Admin\Settings\WalletTransactionThroughController::class, 'addWalletTransactionThrough'])->name('add.wallet.transaction.through');
    Route::get('/wallet_transaction_thourgh_data/data', [App\Http\Controllers\Admin\Settings\WalletTransactionThroughController::class, 'getWalletTransactionThroughData'])->name('get.wallet.transaction.through');
    Route::get('/getwallettransactionthrough/{id}', [App\Http\Controllers\Admin\Settings\WalletTransactionThroughController::class, 'getWalletTransactionThroughById'])->name('getwallettransactionthroughbyid');
    Route::get('/delete/wallettransactionthrough/{id}', [App\Http\Controllers\Admin\Settings\WalletTransactionThroughController::class, 'deleteWalletTransactionThroughById'])->name('delete.wallettransactionthroughbyid');

    //Notification Config Settings
    Route::get('/notification-config', [App\Http\Controllers\Admin\Settings\NotificationConfigController::class, 'notificationConfig'])->name('notificationConfig');
    Route::post('/add/notification-config', [App\Http\Controllers\Admin\Settings\NotificationConfigController::class, 'addNotificationConfig'])->name('addNotificationConfig');
    Route::get('/notification-config/data', [App\Http\Controllers\Admin\Settings\NotificationConfigController::class, 'getNotificationConfigData'])->name('getNotificationConfigData');
    Route::get('/getnotificationconfig/{id}', [App\Http\Controllers\Admin\Settings\NotificationConfigController::class, 'getNotificationConfigById'])->name('getNotificationConfigById');
    Route::get('/delete/getnotificationconfig/{id}', [App\Http\Controllers\Admin\Settings\NotificationConfigController::class, 'deletegetNotificationConfig'])->name('deletegetNotificationConfig');
    Route::post('/get/messageformat', [App\Http\Controllers\Admin\Settings\NotificationConfigController::class, 'getMessageFormat'])->name('getmessageformat');
    /*==============================================ADMIN END===============================================*/

    /*==============================================MANUFACTURER START=======================================*/
    //Documents
    Route::get('manufactuererdocuments/{id?}', [App\Http\Controllers\Manufacturer\Document\DocumentController::class, 'document'])->name('manufacturerdocuments');
    Route::get('mandocuments/{id?}', [App\Http\Controllers\Manufacturer\Document\DocumentController::class, 'document'])->name('mandocuments');
    Route::post('manufactuererdocuments/create', [App\Http\Controllers\Manufacturer\Document\DocumentController::class, 'createDocuments'])->name('manufacturerdocumentscreate');
    /*==============================================MANuFACTURER END=======================================*/

    /*==============================================HUB START=======================================*/
    //Order
    Route::get('huborders', [App\Http\Controllers\Hub\Order\OrderController::class, 'order'])->name('hubloginorder');
    //Document
    Route::get('hubdocuments/{id?}', [App\Http\Controllers\Hub\Document\DocumentController::class, 'document'])->name('hubdocuments');
    Route::get('authhubdocuments/{id?}', [App\Http\Controllers\Hub\Document\DocumentController::class, 'document'])->name('authhubdocuments');
    Route::post('hubdocument/create', [App\Http\Controllers\Hub\Document\DocumentController::class, 'createDocuments'])->name('hubdocumentscreate');
    /*==============================================HUB END=======================================*/

    /*==============================================LOGISTIC START=======================================*/
    //Document
    Route::get('/logisticdocuments/{id?}', [App\Http\Controllers\Logistic\Document\DocumentController::class, 'document'])->name('logisticdocuments');
    Route::get('/documents/{id?}', [App\Http\Controllers\Logistic\Document\DocumentController::class, 'document'])->name('documents');
    Route::post('logisticdocument/create', [App\Http\Controllers\Logistic\Document\DocumentController::class, 'createDocuments'])->name('logisticdocumentscreate');
    /*==============================================LOGISTIC END=======================================*/
});
