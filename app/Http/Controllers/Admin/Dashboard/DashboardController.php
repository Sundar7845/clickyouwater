<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Enums\RoleTypes;
use App\Enums\StatusTypes;
use App\Http\Controllers\Admin\StockManagement\ManufacturerStockController;
use App\Http\Controllers\Controller;
use App\Models\CustomerType;
use App\Models\DeliveryPerson;
use App\Models\Expense;
use App\Models\Hub;
use App\Models\HubManufactureConfig;
use App\Models\LogisticDriverInfo;
use App\Models\LogisticPartner;
use App\Models\LogisticVehicleInfo;
use App\Models\Manufacturer;
use App\Models\ManufactureStock;
use App\Models\Menu;
use App\Models\Offer;
use App\Models\Order;
use App\Models\OrderDet;
use App\Models\StockInProduction;
use App\Models\User;
use App\Models\UserReferralHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\Common;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class DashboardController extends Controller
{
  use Common;
  public function dashboard()
  {
    try {
      $now = \Carbon\Carbon::now();
      //total user count
      $totalUserCount = User::where('role_id', RoleTypes::Customer)->count();

      //total user this month count
      $thisMonthCount = User::where('role_id', RoleTypes::Customer)->whereYear('created_at', '=', $now->year)
        ->whereMonth('created_at', '=', $now->month)
        ->count();

      //total user today count
      $todayCount = User::where('role_id', RoleTypes::Customer)->whereDate('created_at', '=', $now->toDateString())
        ->count();

      //total referral user count
      $refferalUserCount = UserReferralHistory::count();

      //total referral user this month count
      $refferalthisMonthCount = UserReferralHistory::whereYear('referred_on', '=', $now->year)
        ->whereMonth('referred_on', '=', $now->month)
        ->count();

      //total referral user today count
      $refferalTodayCount = UserReferralHistory::whereDate('referred_on', '=', $now->toDateString())
        ->count();

      //total offer count
      $totaloffercount = Offer::count();

      //total today offer count
      $todayoffercount = Offer::whereDate('created_at', '=', $now->toDateString())
        ->count();

      //offer this month total count
      $offerThisMonthCount = Offer::whereYear('created_at', '=', $now->year)
        ->whereMonth('created_at', '=', $now->month)
        ->count();

      //manufacturer total count
      $manutotalcount = Manufacturer::count();

      //man today total count
      $mantodaycount = Manufacturer::whereDate('created_at', '=', $now->toDateString())
        ->count();

      //man this month total count
      $manThisMonthCount = Manufacturer::whereYear('created_at', '=', $now->year)
        ->whereMonth('created_at', '=', $now->month)
        ->count();

      //total hub count
      $totalhubcount = Hub::count();

      //today hub count
      $hubtodaycount = Hub::whereDate('created_at', '=', $now->toDateString())
        ->count();

      //this month hub count
      $hubThisMonthCount = Hub::whereYear('created_at', '=', $now->year)
        ->whereMonth('created_at', '=', $now->month)
        ->count();

      //delivery person total count
      $totaldeliverypersoncount = DeliveryPerson::count();

      //today delivery person count
      $deliverypersontodaycount = DeliveryPerson::whereDate('created_at', '=', $now->toDateString())
        ->count();

      //this month delivery person count
      $deliverypersonThisMonthCount = DeliveryPerson::whereYear('created_at', '=', $now->year)
        ->whereMonth('created_at', '=', $now->month)
        ->count();

      //logistic partner total count
      $totallogisticpartnercount = LogisticPartner::count();

      //today logistic partner count
      $logisticpartnertodaycount = LogisticPartner::whereDate('created_at', '=', $now->toDateString())
        ->count();

      //this month logistic partner count
      $logisticpartnerThisMonthCount = LogisticPartner::whereYear('created_at', '=', $now->year)
        ->whereMonth('created_at', '=', $now->month)
        ->count();

      //Driver total count
      $totallogisticdrivercount = LogisticDriverInfo::count();

      //today Driver count
      $logisticdrivertodaycount = LogisticDriverInfo::whereDate('created_at', '=', $now->toDateString())
        ->count();

      //this month Driver count
      $logisticdriverThisMonthCount = LogisticDriverInfo::whereYear('created_at', '=', $now->year)
        ->whereMonth('created_at', '=', $now->month)
        ->count();

      //Total Order Count
      $totalOrdersCount = Order::count();

      //Today Order Count
      $todayOrdersCount = Order::whereDate('created_at', '=', $now->toDateString())
        ->count();

      //This Month Order Count
      $thisMonthOrdersCount = Order::whereYear('created_at', '=', $now->year)
        ->whereMonth('created_at', '=', $now->month)
        ->count();

      //Total Earnings
      $totalEarnings = Order::select(DB::raw('sum(grand_total) - sum(total_discount_amount) as orderValue'))
        ->whereIn('status_id', [StatusTypes::OrderPlaced, StatusTypes::AssignedToDelivery, StatusTypes::OrderShipped, StatusTypes::OrderDelivered])
        ->pluck('orderValue')
        ->first();

      //Today Earnings
      $todayEarnings = Order::select(DB::raw('sum(grand_total) - sum(total_discount_amount) as orderValue'))
        ->whereIn('status_id', [StatusTypes::OrderPlaced, StatusTypes::AssignedToDelivery, StatusTypes::OrderShipped, StatusTypes::OrderDelivered])
        ->whereDate('created_at', '=', $now->toDateString())
        ->pluck('orderValue')
        ->first();

      //This Week Earnings
      $thisWeekEarnings = Order::select(DB::raw('sum(grand_total) - sum(total_discount_amount) as orderValue'))
        ->whereIn('status_id', [StatusTypes::OrderPlaced, StatusTypes::AssignedToDelivery, StatusTypes::OrderShipped, StatusTypes::OrderDelivered])
        ->whereYear('created_at', '=', $now->year)
        ->where(DB::raw('WEEK(created_at)'), '=', $now->week)
        ->pluck('orderValue')
        ->first();

      //This Month Earnings
      $thisMonthEarnings = Order::select(DB::raw('sum(grand_total) - sum(total_discount_amount) as orderValue'))
        ->whereIn('status_id', [StatusTypes::OrderPlaced, StatusTypes::AssignedToDelivery, StatusTypes::OrderShipped, StatusTypes::OrderDelivered])
        ->whereYear('created_at', '=', $now->year)
        ->whereMonth('created_at', '=', $now->month)
        ->pluck('orderValue')
        ->first();

      //Company Closing
      //Total Order value without deposit amount
      $orderValue = Order::select(DB::raw('sum(grand_total) - sum(total_discount_amount) - sum(deposit_amount) as orderValue'))
        ->whereIn('status_id', [StatusTypes::OrderPlaced, StatusTypes::AssignedToDelivery, StatusTypes::OrderShipped, StatusTypes::OrderDelivered])
        ->pluck('orderValue')
        ->first();

      $totDeposit = Order::select(DB::raw('sum(deposit_amount) as totDeposit'))
        ->whereIn('status_id', [StatusTypes::OrderPlaced, StatusTypes::AssignedToDelivery, StatusTypes::OrderShipped, StatusTypes::OrderDelivered])
        ->pluck('totDeposit')
        ->first();

      $totWallet = User::select(DB::raw('sum(wallet_points) as totWallet'))
        ->pluck('totWallet')
        ->first();

      $companyClosing = ($orderValue + $totDeposit);

      $totalorders = $this->getAllOrders()->latest()->take(10)->get();

      /*********************Hub Counts */
      //Hub Total Order Count
      $hubtotalOrdersCount = Order::whereIn('status_id', [StatusTypes::OrderPlaced, StatusTypes::AssignedToDelivery, StatusTypes::OrderShipped, StatusTypes::OrderDelivered])
        ->where('hub_id', $this->getRefId(Auth::user()->id, RoleTypes::Hub))
        ->count();

      //Hub Today Order Count
      $hubtodayOrdersCount = Order::whereIn('status_id', [StatusTypes::OrderPlaced, StatusTypes::AssignedToDelivery, StatusTypes::OrderShipped, StatusTypes::OrderDelivered])
        ->where('hub_id', $this->getRefId(Auth::user()->id, RoleTypes::Hub))
        ->whereDate('created_at', '=', $now->toDateString())
        ->count();

      //Hub This Month Order Count
      $hubthisMonthOrdersCount = Order::whereIn('status_id', [StatusTypes::OrderPlaced, StatusTypes::AssignedToDelivery, StatusTypes::OrderShipped, StatusTypes::OrderDelivered])
        ->where('hub_id', $this->getRefId(Auth::user()->id, RoleTypes::Hub))
        ->whereYear('created_at', '=', $now->year)
        ->whereMonth('created_at', '=', $now->month)
        ->count();

      /*********************Manufacture Counts */
      $hubs = HubManufactureConfig::where('manufacturer_id', $this->getRefId(Auth::user()->id, RoleTypes::Manufacturer));
      $hubIds = $hubs->pluck('hub_id')->toArray(); // get an array of hub_ids from $hubs

      //Manufacture Today Order Count
      $mantodayOrdersCount = Order::select('orders.*')
        ->join('users', 'users.id', 'orders.user_id')
        ->whereIn('status_id', [StatusTypes::OrderPlaced, StatusTypes::AssignedToDelivery, StatusTypes::OrderShipped, StatusTypes::OrderDelivered])
        ->where('orders.hub_id', $hubIds)
        ->where('users.id', Auth::user()->id)
        ->where('users.role_id', Auth::user()->role_id)
        ->where('orders.transaction_date', '<', now()->subHours(48))
        ->whereDate('orders.created_at', '=', $now->toDateString())
        ->count();

      //Manufacture This Month Order Count
      $manthisMonthOrdersCount = Order::select('orders.*')
        ->join('users', 'users.id', 'orders.user_id')
        ->whereIn('status_id', [StatusTypes::OrderPlaced, StatusTypes::AssignedToDelivery, StatusTypes::OrderShipped, StatusTypes::OrderDelivered])
        ->where('orders.hub_id', $hubIds)
        ->where('users.id', Auth::user()->id)
        ->where('users.role_id', Auth::user()->role_id)
        ->where('orders.transaction_date', '<', now()->subHours(48))
        ->whereYear('orders.created_at', '=', $now->year)
        ->whereMonth('orders.created_at', '=', $now->month)
        ->count();

      //Manufacture Total Order Count
      $mantotalOrdersCount = Order::select('orders.*')
        ->join('users', 'users.id', 'orders.user_id')
        ->whereIn('status_id', [StatusTypes::OrderPlaced, StatusTypes::AssignedToDelivery, StatusTypes::OrderShipped, StatusTypes::OrderDelivered])
        ->whereIn('orders.hub_id', $hubIds)
        ->where('users.id', Auth::user()->id)
        ->where('users.role_id', Auth::user()->role_id)
        ->where('orders.transaction_date', '<', now()->subHours(48))
        ->count();

      //Admin Dashboard Weekly Sales Data
      $startDate = Carbon::now()->subDays(7)->startOfWeek();
      $endDate = Carbon::now()->endOfWeek();

      $orders = Order::whereIn('status_id', [StatusTypes::OrderPlaced, StatusTypes::AssignedToDelivery, StatusTypes::OrderShipped, StatusTypes::OrderDelivered])
        ->whereBetween('transaction_date', [$startDate, $endDate])
        ->groupBy('transaction_date')
        ->selectRaw('DATE_FORMAT(transaction_date, "%a") as day, SUM(grand_total - total_discount_amount) as count')
        ->orderByRaw('DAYOFWEEK(transaction_date)')
        ->get();

      $weekDays = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

      $weeklySales = [];
      $mon = $orders->where('day', 'Mon')->count();
      $tue = $orders->where('day', 'Tue')->count();
      $wed = $orders->where('day', 'Wed')->count();
      $thu = $orders->where('day', 'Thu')->count();
      $fri = $orders->where('day', 'Fri')->count();
      $sat = $orders->where('day', 'Sat')->count();
      $sun = $orders->where('day', 'Sun')->count();

      array_push($weeklySales, $mon);
      array_push($weeklySales, $tue);
      array_push($weeklySales, $wed);
      array_push($weeklySales, $thu);
      array_push($weeklySales, $fri);
      array_push($weeklySales, $sat);
      array_push($weeklySales, $sun);
      //End Admin Dashboard Weekly Sales Data


      //Admin Dashboard Sales & Expenses Charts
      $ordersData = [];
      $expenseData = [];

      // Get the current date
      $currentDate = Carbon::now();

      $months = [];
      // Iterate over the last six months
      for ($i = 6; $i >= 1; $i--) {
        // Get the start and end date of the current month
        $startDate = Carbon::now()->subMonths($i)->startOfMonth();
        $endDate = Carbon::now()->subMonths($i)->endOfMonth();


        // Get the orders within the current month
        $orders = Order::select(DB::raw('sum(grand_total) - sum(total_discount_amount) as orderValue'))
          ->whereBetween('transaction_date', [$startDate, $endDate])
          ->whereIn('status_id', [
            StatusTypes::OrderPlaced,
            StatusTypes::AssignedToDelivery,
            StatusTypes::OrderShipped,
            StatusTypes::OrderDelivered
          ])
          ->groupBy('transaction_date')
          ->pluck('orderValue')
          ->first();

        //Last six months expense data
        $expenses = Expense::whereBetween('created_at', [$startDate, $endDate])
          ->groupBy('created_at')
          ->sum('amount');

        // Store the order count for the current month
        array_push($ordersData, $orders);
        array_push($expenseData, $expenses);
        array_push($months, $startDate->format('M'));
      }
      $lastSixMonths = array_values($months);
      $lastSixMonthorders = $ordersData;
      $lastSixMonthExpenses = $expenseData;


      //Hub Dashboard Content
      //Today Orders
      $hubTodayOrders = Order::where('hub_id', $this->getRefId(Auth::user()->id, RoleTypes::Hub))
        ->whereIn('status_id', [StatusTypes::OrderPlaced, StatusTypes::AssignedToDelivery, StatusTypes::OrderShipped, StatusTypes::OrderDelivered])
        ->whereDate('created_at', '=', $now->toDateString())
        ->count();
      //This Month Orders
      $hubthisMonthOrders = Order::where('hub_id', $this->getRefId(Auth::user()->id, RoleTypes::Hub))
        ->whereIn('status_id', [StatusTypes::OrderPlaced, StatusTypes::AssignedToDelivery, StatusTypes::OrderShipped, StatusTypes::OrderDelivered])
        ->whereYear('created_at', '=', $now->year)
        ->whereMonth('created_at', '=', $now->month)
        ->count();
      //Total Orders
      $hubTotalOrders = Order::where('hub_id', $this->getRefId(Auth::user()->id, RoleTypes::Hub))
        ->whereIn('status_id', [StatusTypes::OrderPlaced, StatusTypes::AssignedToDelivery, StatusTypes::OrderShipped, StatusTypes::OrderDelivered])
        ->count();

      //Logistic Dashboard Content
      $logisticTotalVehicles = LogisticVehicleInfo::where('logistic_partner_id', Auth::user()->ref_id)->count();
      $logisticTotalDrivers = LogisticDriverInfo::where('logistic_partner_id', Auth::user()->ref_id)->count();


      //Manufacturer Cans Order Count
      $manfacturerCansOrderData = ManufactureStock::select('manufacture_stocks.*', 'categories.category_name', 'products.product_name')
        ->join('products', 'products.id', 'manufacture_stocks.product_id')
        ->join('categories', 'categories.id', 'products.category_id')
        ->join('users', 'users.ref_id', 'manufacture_stocks.manufacture_id')
        ->where('users.id', Auth::user()->id)
        ->where('users.role_id', Auth::user()->role_id)
        ->where('categories.is_watercan', 1)
        ->where('manufacture_stocks.order_qty', '>', 0)
        ->get();
      $manufacturerCansOrderCount = $manfacturerCansOrderData->count();


      //Manufacturer Others Order Count
      $manfacturerOthersOrderData = ManufactureStock::select('manufacture_stocks.*', 'categories.category_name', 'products.product_name')
        ->join('products', 'products.id', 'manufacture_stocks.product_id')
        ->join('categories', 'categories.id', 'products.category_id')
        ->join('users', 'users.ref_id', 'manufacture_stocks.manufacture_id')
        ->where('users.id', Auth::user()->id)
        ->where('users.role_id', Auth::user()->role_id)
        ->where('categories.is_watercan', 0)
        ->where('manufacture_stocks.order_qty', '>', 0)
        ->get();
      $manfacturerOthersOrderCount = $manfacturerOthersOrderData->count();

      //Manufacturer Stock In Product Count
      $manfacturerStockInProductionData = StockInProduction::select('stock_in_productions.*', 'categories.category_name', 'product_types.product_type_name', 'products.product_name')
        ->join('products', 'products.id', 'stock_in_productions.product_id')
        ->join('product_types', 'product_types.id', 'products.product_type_id')
        ->join('categories', 'categories.id', 'products.category_id')
        ->join('users', 'users.ref_id', 'stock_in_productions.manufacture_id')
        ->where('users.id', Auth::user()->id)
        ->where('users.role_id', Auth::user()->role_id)
        ->where('stock_in_productions.qty', '>', 0)
        ->get();
      $manfacturerStockInProductionCount = $manfacturerStockInProductionData->count();

      //Manufacturer Stock Count
      $manfacturerStockData = ManufactureStock::select('manufacture_stocks.*', 'categories.category_name', 'product_types.product_type_name', 'products.product_name')
        ->join('products', 'products.id', 'manufacture_stocks.product_id')
        ->join('product_types', 'product_types.id', 'products.product_type_id')
        ->join('categories', 'categories.id', 'products.category_id')
        ->join('users', 'users.ref_id', 'manufacture_stocks.manufacture_id')
        ->where('users.id', Auth::user()->id)
        ->where('users.role_id', Auth::user()->role_id)
        ->where('manufacture_stocks.filled_qty', '>', 0)
        ->get();
      $manfacturerStockCount = $manfacturerStockData->count();

      //Manufacturer Empty Cans Count
      $manfacturerEmptyCanData = ManufactureStock::select('manufacture_stocks.*', 'categories.category_name', 'product_types.product_type_name', 'products.product_name')
        ->join('products', 'products.id', 'manufacture_stocks.product_id')
        ->join('product_types', 'product_types.id', 'products.product_type_id')
        ->join('categories', 'categories.id', 'products.category_id')
        ->join('users', 'users.ref_id', 'manufacture_stocks.manufacture_id')
        ->where('users.id', Auth::user()->id)
        ->where('users.role_id', Auth::user()->role_id)
        ->where('manufacture_stocks.empty_qty', '>', 0)
        ->get();
      $manfacturerEmptyCanCount = $manfacturerEmptyCanData->count();


      //Manufacturer Damaged Can Count
      $manfacturerDamagedCanData = ManufactureStock::select('manufacture_stocks.*', 'categories.category_name', 'product_types.product_type_name', 'products.product_name')
        ->join('products', 'products.id', 'manufacture_stocks.product_id')
        ->join('product_types', 'product_types.id', 'products.product_type_id')
        ->join('categories', 'categories.id', 'products.category_id')
        ->join('users', 'users.ref_id', 'manufacture_stocks.manufacture_id')
        ->where('users.id', Auth::user()->id)
        ->where('users.role_id', Auth::user()->role_id)
        ->where('manufacture_stocks.damaged_qty', '>', 0)
        ->get();

      $manfacturerDamagedCanCount = $manfacturerDamagedCanData->count();

      return view('admin.dashboard.dashboard', compact(
        'totalUserCount',
        'thisMonthCount',
        'todayCount',
        'refferalUserCount',
        'refferalthisMonthCount',
        'refferalTodayCount',
        'totaloffercount',
        'todayoffercount',
        'offerThisMonthCount',
        'manutotalcount',
        'mantodaycount',
        'manThisMonthCount',
        'totalhubcount',
        'hubtodaycount',
        'hubThisMonthCount',
        'totaldeliverypersoncount',
        'deliverypersontodaycount',
        'deliverypersonThisMonthCount',
        'totallogisticpartnercount',
        'logisticpartnertodaycount',
        'logisticpartnerThisMonthCount',
        'totallogisticdrivercount',
        'logisticdrivertodaycount',
        'logisticdriverThisMonthCount',
        'totalOrdersCount',
        'todayOrdersCount',
        'thisMonthOrdersCount',
        'totalEarnings',
        'todayEarnings',
        'thisWeekEarnings',
        'thisMonthEarnings',
        'companyClosing',
        'orderValue',
        'totDeposit',
        'totWallet',
        'totalorders',
        'hubtotalOrdersCount',
        'hubtodayOrdersCount',
        'hubthisMonthOrdersCount',
        'mantotalOrdersCount',
        'mantodayOrdersCount',
        'manthisMonthOrdersCount',
        'weekDays',
        'weeklySales',
        'lastSixMonths',
        'lastSixMonthorders',
        'lastSixMonthExpenses',
        'logisticTotalVehicles',
        'logisticTotalDrivers',
        'hubTotalOrders',
        'hubTodayOrders',
        'hubthisMonthOrders',
        'manufacturerCansOrderCount',
        'manfacturerOthersOrderCount',
        'manfacturerStockInProductionCount',
        'manfacturerStockCount',
        'manfacturerEmptyCanCount',
        'manfacturerDamagedCanCount'
      ));
    } catch (\Exception $e) {
      $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
    }
  }

  //common function need
  public function getAdminRecentOrdersdata(Request $request)
  {
    try {

      $totalorders = $this->getAllOrders()->latest()->take(10)->get();
      return datatables()->of($totalorders)->toJson();
    } catch (\Exception $e) {
      $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
    }
  }

  public function profile()
  {
    $profiledetails = Auth::user();
    return view('admin.dashboard.profile', compact('profiledetails'));
  }

  public function unauthorized()
  {
    return view('unauthorized');
  }

  public function pageNotFound()
  {
    return view('404');
  }

  public function ProfileUpdate(Request $request)
  {
    try {
      $request->validate([
        'txtUserName' => 'required',
        'txtMobile' => 'required|numeric|digits:10|unique:users,mobile,' . $request->hdProfileId,
      ]);

      if ($request->file('ProfileImage')) {
        $path = $request->file('ProfileImage')->store('temp');
        $file = $request->file('ProfileImage');
        $extension = $file->getClientOriginalExtension();
        $fileName = $this->generateRandom(16) . '.' . $extension;
      }

      User::findorFail($request->hdProfileId)->update([
        'user_name' => $request->txtUserName,
        'mobile' => $request->txtMobile,
        'user_img_path' => ($request->hasFile('ProfileImage')) ? $this->fileUpload($file, 'upload/users/' . $request->hdProfileId, $fileName) : $request->hdProfileImg,
        'updated_by' => Auth::user()->id
      ]);

      if ($request->filled('txtPassword')) {
        $password = Hash::make($request->txtPassword);
        User::findorFail($request->hdProfileId)->update([
          'password' => $password
        ]);
      }


      $notification = array(
        'message' => 'Profile Updated Successfully',
        'alert-type' => 'success'
      );
      return redirect()->route('profile')->with($notification);
    } catch (\Exception $e) {
      $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
    }
  }

  //Get Manfacturer Cans Order Data for Manufacturer Dashboard
  public function manfacturerCansOrderData(Request $request)
  {
    try {
      $manfacturerCansOrderData = ManufactureStock::select('manufacture_stocks.*', 'categories.category_name', 'product_types.product_type_name', 'products.product_name')
        ->join('products', 'products.id', 'manufacture_stocks.product_id')
        ->join('product_types', 'product_types.id', 'products.product_type_id')
        ->join('categories', 'categories.id', 'products.category_id')
        ->join('users', 'users.ref_id', 'manufacture_stocks.manufacture_id')
        ->where('users.id', Auth::user()->id)
        ->where('users.role_id', Auth::user()->role_id)
        ->where('categories.is_watercan', 1)
        ->where('manufacture_stocks.order_qty', '>', 0)
        ->get();

      return datatables()->of($manfacturerCansOrderData)->toJson();
    } catch (\Exception $e) {
      $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
    }
  }

  //Get Manfacturer Others Order Data for Manufacturer Dashboard
  public function manfacturerOthersOrderData(Request $request)
  {
    try {
      $manfacturerOthersOrderData = ManufactureStock::select('manufacture_stocks.*', 'categories.category_name', 'product_types.product_type_name', 'products.product_name')
        ->join('products', 'products.id', 'manufacture_stocks.product_id')
        ->join('product_types', 'product_types.id', 'products.product_type_id')
        ->join('categories', 'categories.id', 'products.category_id')
        ->join('users', 'users.ref_id', 'manufacture_stocks.manufacture_id')
        ->where('users.id', Auth::user()->id)
        ->where('users.role_id', Auth::user()->role_id)
        ->where('categories.is_watercan', 0)
        ->where('manufacture_stocks.order_qty', '>', 0)
        ->get();

      return datatables()->of($manfacturerOthersOrderData)->toJson();
    } catch (\Exception $e) {
      $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
    }
  }

  //Get Manfacturer Stock InProduction Data for Manufacturer Dashboard
  public function manfacturerStockInProductionData(Request $request)
  {
    try {
      $manfacturerStockInProductionData = StockInProduction::select('stock_in_productions.*', 'categories.category_name', 'product_types.product_type_name', 'products.product_name')
        ->join('products', 'products.id', 'stock_in_productions.product_id')
        ->join('product_types', 'product_types.id', 'products.product_type_id')
        ->join('categories', 'categories.id', 'products.category_id')
        ->join('users', 'users.ref_id', 'stock_in_productions.manufacture_id')
        ->where('users.id', Auth::user()->id)
        ->where('users.role_id', Auth::user()->role_id)
        ->where('stock_in_productions.qty', '>', 0)
        ->get();

      return datatables()->of($manfacturerStockInProductionData)->toJson();
    } catch (\Exception $e) {
      $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
    }
  }


  //Get Manufacturer Stock Data for Manufacturer Dashboard
  public function manfacturerStockData(Request $request)
  {
    try {
      $manfacturerStockData = ManufactureStock::select('manufacture_stocks.*', 'categories.category_name', 'product_types.product_type_name', 'products.product_name')
        ->join('products', 'products.id', 'manufacture_stocks.product_id')
        ->join('product_types', 'product_types.id', 'products.product_type_id')
        ->join('categories', 'categories.id', 'products.category_id')
        ->join('users', 'users.ref_id', 'manufacture_stocks.manufacture_id')
        ->where('users.id', Auth::user()->id)
        ->where('users.role_id', Auth::user()->role_id)
        ->where('manufacture_stocks.filled_qty', '>', 0)
        ->get();

      return datatables()->of($manfacturerStockData)->toJson();
    } catch (\Exception $e) {
      $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
    }
  }


  //Get Manufacturer Empty Can Data for Manufacturer Dashboard
  public function manfacturerEmptyCanData(Request $request)
  {
    try {
      $manfacturerEmptyCanData = ManufactureStock::select('manufacture_stocks.*', 'categories.category_name', 'product_types.product_type_name', 'products.product_name')
        ->join('products', 'products.id', 'manufacture_stocks.product_id')
        ->join('product_types', 'product_types.id', 'products.product_type_id')
        ->join('categories', 'categories.id', 'products.category_id')
        ->join('users', 'users.ref_id', 'manufacture_stocks.manufacture_id')
        ->where('users.id', Auth::user()->id)
        ->where('users.role_id', Auth::user()->role_id)
        ->where('manufacture_stocks.empty_qty', '>', 0)
        ->get();

      return datatables()->of($manfacturerEmptyCanData)->toJson();
    } catch (\Exception $e) {
      $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
    }
  }

  //Get Manufacturer Damaged Can Data for Manufacturer Dashboard
  public function manfacturerDamagedCanData(Request $request)
  {
    try {
      $manfacturerDamagedCanData = ManufactureStock::select('manufacture_stocks.*', 'categories.category_name', 'product_types.product_type_name', 'products.product_name')
        ->join('products', 'products.id', 'manufacture_stocks.product_id')
        ->join('product_types', 'product_types.id', 'products.product_type_id')
        ->join('categories', 'categories.id', 'products.category_id')
        ->join('users', 'users.ref_id', 'manufacture_stocks.manufacture_id')
        ->where('users.id', Auth::user()->id)
        ->where('users.role_id', Auth::user()->role_id)
        ->where('manufacture_stocks.damaged_qty', '>', 0)
        ->get();

      return datatables()->of($manfacturerDamagedCanData)->toJson();
    } catch (\Exception $e) {
      $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
    }
  }

  //Get yearly Sales Data for Manufacturer Dashboard
  public function yearlySalesData(Request $request)
  {
    try {

      $year = Carbon::now()->year;

      $yearlySales = Order::select(
        DB::raw('YEAR(transaction_date) as year'),
        DB::raw('MONTH(transaction_date) as month'),
        DB::raw('SUM(grand_total) as total_grand_total')
      )
        ->whereIn('status_id', [StatusTypes::OrderPlaced, StatusTypes::AssignedToDelivery, StatusTypes::OrderShipped, StatusTypes::OrderDelivered])
        ->whereYear('transaction_date', $year)
        ->groupBy('year', 'month')
        ->orderBy('month', 'asc')
        ->get();

      $yearlyExpense = Expense::select(
        DB::raw('YEAR(created_at) as year'),
        DB::raw('MONTH(created_at) as month'),
        DB::raw('SUM(amount) as total_grand_total')
      )
        ->whereYear('created_at', $year)
        ->groupBy('year', 'month')
        ->orderBy('month', 'asc')
        ->get();

      $response = [];

      $allMonths = range(1, 12);

      // Loop through all months
      foreach ($allMonths as $month) {
        $found = false;

        // Search for the month in the existing data
        foreach ($yearlySales as $sales) {
          if ($sales->month === $month) {
            $found = true;
            $salesGrandTotal = $sales->total_grand_total;
            break;
          }
        }

        // Search for the month in the existing data
        foreach ($yearlyExpense as $expense) {
          if ($expense->month === $month) {
            $found = true;
            $expenseGrandTotal = $expense->total_grand_total;
            break;
          }
        }

        // If the month is not found, set the total grand total to 0
        if (!$found) {
          $salesGrandTotal = 0;
          $expenseGrandTotal = 0;
        }

        $monthName = date('M', mktime(0, 0, 0, $month, 1));

        $response[] = [
          'month' => $monthName,
          'order_amount' => round($salesGrandTotal / 1000),
          'expense_amount' => round($expenseGrandTotal / 1000)
        ];
      }

      return response()->json($response);
    } catch (\Exception $e) {
      $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
    }
  }
}
