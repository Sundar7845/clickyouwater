<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\API\Manufacture\ManufactureController;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Customer;
use App\Models\CustomerStock;
use App\Models\DeliveryPerson;
use App\Models\DeliveryPersonStock;
use App\Models\Hub;
use App\Models\HubStock;
use App\Models\LogisticPartner;
use App\Models\LogisticStock;
use App\Models\Manufacturer;
use App\Models\ManufactureStock;
use App\Models\StockInProduction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    //Overall Reports View
    public function stockReports()
    {
        $manufacturer_stocks = ManufactureStock::select(DB::raw('sum(filled_qty) as filled_qty'), DB::raw('sum(empty_qty) as empty_qty'), DB::raw('sum(damaged_qty) as damaged_qty'), DB::raw('sum(order_qty) as order_qty'))->first();
        $manufacturer_production_stocks = StockInProduction::select(DB::raw('sum(qty) as prodution_qty'))->value('prodution_qty');
        $logistic_stocks = LogisticStock::select(DB::raw('sum(filled_qty) as filled_qty'), DB::raw('sum(empty_qty) as empty_qty'), DB::raw('sum(damaged_qty) as damaged_qty'))->first();
        $hub_stocks = HubStock::select(DB::raw('sum(filled_qty) as filled_qty'), DB::raw('sum(empty_qty) as empty_qty'), DB::raw('sum(damaged_qty) as damaged_qty'), DB::raw('sum(order_qty) as order_qty'))->first();
        $delivery_person_stocks = DeliveryPersonStock::select(DB::raw('sum(qty) as filled_qty'), DB::raw('sum(collected_empty_qty) as empty_qty'), DB::raw('sum(lost_qty) as damaged_qty'), DB::raw('sum(extra_qty) as extra_qty'))->first();
        $customer_stocks = CustomerStock::select(DB::raw('sum(empty_qty) as empty_qty'), DB::raw('sum(damaged_qty) as damaged_qty'), DB::raw('sum(extra_qty) as extra_qty'))->first();

        //Total Stocks
        $manufacturer_total_stock = ManufactureStock::select(DB::raw('sum(filled_qty) + sum(empty_qty) + sum(damaged_qty) as manufacturer_total_stock'))->value('manufacturer_total_stock');
        $logistic_total_stock = LogisticStock::select(DB::raw('sum(filled_qty) + sum(empty_qty) + sum(damaged_qty) as logistic_total_stock'))->value('logistic_total_stock');
        $hub_total_stock = HubStock::select(DB::raw('sum(filled_qty) + sum(empty_qty) + sum(damaged_qty) as hub_total_stock'))->value('hub_total_stock');
        $delivery_person_total_stock = DeliveryPersonStock::select(DB::raw('sum(qty) + sum(extra_qty) + sum(collected_empty_qty) + sum(lost_qty) as delivery_person_total_stock'))->value('delivery_person_total_stock');
        $customer_total_stock = CustomerStock::select(DB::raw('sum(empty_qty) + sum(damaged_qty) + sum(extra_qty) as customer_total_stock'))->value('customer_total_stock');

        //Total Damaged Stocks
        $manufacturer_damaged = ManufactureStock::select(DB::raw('sum(damaged_qty) as manufacturer_damaged'))->value('manufacturer_damaged');
        $logistic_damaged = LogisticStock::select(DB::raw('sum(damaged_qty) as logistic_damaged'))->value('logistic_damaged');
        $hub_damaged = HubStock::select(DB::raw('sum(damaged_qty) as hub_damaged'))->value('hub_damaged');
        $delivery_person_damaged = DeliveryPersonStock::select(DB::raw('sum(lost_qty) as delivery_person_damaged'))->value('delivery_person_damaged');
        $customer_damaged = CustomerStock::select(DB::raw('sum(damaged_qty) as customer_damaged'))->value('customer_damaged');

        $total_damaged_stock = $manufacturer_damaged + $logistic_damaged + $hub_damaged + $delivery_person_damaged + $customer_damaged;

        //Total Stocks Count
        $total_stocks_count = $manufacturer_total_stock + $manufacturer_production_stocks + $logistic_total_stock + $hub_total_stock + $delivery_person_total_stock + $customer_total_stock;

        //manufacturer_total_stock + manufacturer_production_stocks
        $manufacturer_total_stock = $manufacturer_total_stock + $manufacturer_production_stocks;
        return view('admin.reports.stock_reports', compact(
            'manufacturer_stocks',
            'manufacturer_production_stocks',
            'manufacturer_total_stock',
            'logistic_stocks',
            'logistic_total_stock',
            'hub_stocks',
            'hub_total_stock',
            'delivery_person_stocks',
            'delivery_person_total_stock',
            'customer_stocks',
            'customer_total_stock',
            'total_stocks_count',
            'total_damaged_stock',
            'manufacturer_damaged',
            'logistic_damaged',
            'hub_damaged',
            'delivery_person_damaged',
            'customer_damaged'
        ));
    }


    //Manufacturer Stocks Reports Data
    public function manufactureStockReports()
    {
        $categories = Category::where('is_active', 1)->whereNull('deleted_at')->get();
        $manufactures = Manufacturer::where('is_active', 1)->whereNull('deleted_at')->get();
        return view('admin.reports.stock_manufacture_reports', compact('categories', 'manufactures'));
    }
    public function manufactureProductStockReport(Request $request)
    {
        try {
            $manufactureProductStockReport = "";

            $query = ManufactureStock::select('manufacture_stocks.*', 'categories.category_name', 'products.product_name', 'products.id as product_id', 'stock_in_productions.qty')
                ->join('products', 'products.id', 'manufacture_stocks.product_id')
                ->join('stock_in_productions', 'stock_in_productions.manufacture_id', 'manufacture_stocks.manufacture_id')
                ->join('categories', 'categories.id', 'products.category_id')
                ->orWhere('manufacture_stocks.filled_qty', '>', 0)
                ->orWhere('manufacture_stocks.empty_qty', '>', 0)
                ->orWhere('manufacture_stocks.damaged_qty', '>', 0);

            if ($request->category_id > 0) {
                $query = $query->where('categories.id', $request->category_id);
            }

            if ($request->manufacture_id > 0) {
                $query = $query->where('manufacture_stocks.manufacture_id', $request->manufacture_id);
            }

            $manufactureProductStockReport = $query->get();

            return datatables()->of($manufactureProductStockReport)->toJson();
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    //Logistic Stocks Reports Data
    public function logisticsStockReports()
    {
        $categories = Category::where('is_active', 1)->whereNull('deleted_at')->get();
        $logistics = LogisticPartner::where('is_active', 1)->whereNull('deleted_at')->get();
        return view('admin.reports.stock_logistics_reports', compact('categories', 'logistics'));
    }
    public function logisticproductstockreport(Request $request)
    {
        try {
            $logisticproductstockreport = "";

            $query = LogisticStock::select('logistic_stocks.*', 'categories.category_name', 'products.product_name', 'products.id as product_id')
                ->join('products', 'products.id', '=', 'logistic_stocks.product_id')
                ->join('categories', 'categories.id', '=', 'products.category_id')
                ->join('logistic_driver_infos', 'logistic_driver_infos.id', '=', 'logistic_stocks.driver_id')
                ->join('logistic_partners', 'logistic_partners.id', '=', 'logistic_driver_infos.logistic_partner_id')
                ->orWhere('logistic_stocks.filled_qty', '>', 0)
                ->orWhere('logistic_stocks.empty_qty', '>', 0)
                ->orWhere('logistic_stocks.damaged_qty', '>', 0);

            if ($request->category_id > 0) {
                $query = $query->where('categories.id', $request->category_id);
            }

            if ($request->logistics_id > 0) {
                $query = $query->where('logistic_partners.id', $request->logistics_id);
            }

            $logisticproductstockreport = $query->get();

            return datatables()->of($logisticproductstockreport)->toJson();
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    //Hub Stocks Reports Data
    public function hubStockReports()
    {
        $categories = Category::where('is_active', 1)->whereNull('deleted_at')->get();
        $hubs = Hub::where('is_active', 1)->whereNull('deleted_at')->get();
        return view('admin.reports.stock_hub_reports', compact('categories', 'hubs'));
    }
    public function hubProductStockReport(Request $request)
    {
        try {
            $hubProductStockReport = "";

            $query = HubStock::select('hub_stocks.*', 'categories.category_name', 'products.product_name', 'products.id as product_id')
                ->join('products', 'products.id', 'hub_stocks.product_id')
                ->join('categories', 'categories.id', 'products.category_id')
                ->orWhere('hub_stocks.filled_qty', '>', 0)
                ->orWhere('hub_stocks.empty_qty', '>', 0)
                ->orWhere('hub_stocks.damaged_qty', '>', 0);

            if ($request->category_id > 0) {
                $query = $query->where('categories.id', $request->category_id);
            }

            if ($request->hub_id > 0) {
                $query = $query->where('hub_stocks.hub_id', $request->hub_id);
            }

            $hubProductStockReport = $query->get();

            return datatables()->of($hubProductStockReport)->toJson();
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    //Delivery Person Stocks Reports Data
    public function deliverypersonStockReports()
    {
        $categories = Category::where('is_active', 1)->whereNull('deleted_at')->get();
        $deliverypersons = DeliveryPerson::where('is_active', 1)->whereNull('deleted_at')->get();
        return view('admin.reports.stock_deliveryperson_reports', compact('categories', 'deliverypersons'));
    }
    public function deliverypersonProductStockReport(Request $request)
    {
        try {
            $deliverypersonProductStockReport = "";

            $query = DeliveryPersonStock::select('delivery_person_stocks.*', 'categories.category_name', 'products.product_name', 'products.id as product_id')
                ->join('products', 'products.id', 'delivery_person_stocks.product_id')
                ->join('categories', 'categories.id', 'products.category_id')
                ->join('users', 'users.id', 'delivery_person_stocks.delivery_user_id')
                ->join('delivery_people', 'delivery_people.id', 'users.ref_id')
                ->orWhere('delivery_person_stocks.qty', '>', 0)
                ->orWhere('delivery_person_stocks.collected_empty_qty', '>', 0)
                ->orWhere('delivery_person_stocks.lost_qty', '>', 0)
                ->orWhere('delivery_person_stocks.extra_qty', '>', 0);

            if ($request->category_id > 0) {
                $query = $query->where('categories.id', $request->category_id);
            }

            if ($request->deliveryperson_id > 0) {
                $query = $query->where('delivery_people.id', $request->deliveryperson_id);
            }

            $deliverypersonProductStockReport = $query->get();

            return datatables()->of($deliverypersonProductStockReport)->toJson();
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }


    //Customer Stocks Reports Data
    public function customerStockReports()
    {
        $categories = Category::where('is_active', 1)->whereNull('deleted_at')->get();
        $customers = Customer::whereNull('deleted_at')->get();
        return view('admin.reports.stock_customer_reports', compact('categories', 'customers'));
    }
    public function customersProductStockReport(Request $request)
    {
        try {
            $customersProductStockReport = "";

            $query = CustomerStock::select('customer_stocks.*', 'categories.category_name', 'products.product_name', 'products.id as product_id')
                ->join('products', 'products.id', 'customer_stocks.product_id')
                ->join('categories', 'categories.id', 'products.category_id')
                ->join('users', 'users.id', 'customer_stocks.user_id')
                ->join('customers', 'customers.id', 'users.ref_id')
                ->orWhere('customer_stocks.empty_qty', '>', 0)
                ->orWhere('customer_stocks.damaged_qty', '>', 0)
                ->orWhere('customer_stocks.extra_qty', '>', 0);

            if ($request->category_id > 0) {
                $query = $query->where('categories.id', $request->category_id);
            }

            if ($request->customer_id > 0) {
                $query = $query->where('customers.id', $request->customer_id);
            }

            $customersProductStockReport = $query->get();

            return datatables()->of($customersProductStockReport)->toJson();
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }
}
