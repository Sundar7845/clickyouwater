<?php

namespace App\Http\Controllers\Logistic\Stock;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\LogisticDriverInfo;
use App\Models\LogisticStock;
use App\Models\LogisticStockHistory;
use App\Models\Products;
use App\Traits\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    use Common;
    //Product Stock Report View
    public function logisticStocksView()
    {
        try {
            $drivers = LogisticDriverInfo::select('logistic_driver_infos.id', 'logistic_driver_infos.driver_name')
                ->join('users', 'users.ref_id', 'logistic_driver_infos.logistic_partner_id')
                ->where('users.id', Auth::user()->id)
                ->where('users.role_id', Auth::user()->role_id)
                ->get();
            $categories = Category::where('is_active', 1)->whereNull('deleted_at')->get();
            return view('logistic.stock.logistic_stock', compact('categories', 'drivers'));
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    //Product Wise Stock Report View
    public function logisticStocks(Request $request)
    {
        try {
            $product_id = $request->product_id;
            $driver_id = $request->driver_id;
            $product_name = Products::where('id', $product_id)->pluck('product_name')->first();
            return view('logistic.stock.stock', compact('product_id', 'product_name', 'driver_id'));
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    //Prodcuts Stock Report
    public function logisticProductStockData(Request $request)
    {
        try {

            $logisticProductStockData = "";
            $query = LogisticStock::select(
                DB::raw('sum(logistic_stocks.order_qty) as order_qty'),
                DB::raw('sum(logistic_stocks.filled_qty) as filled_qty'),
                DB::raw('sum(logistic_stocks.empty_qty) as empty_qty'),
                DB::raw('sum(logistic_stocks.damaged_qty) as damaged_qty'),
                'logistic_stocks.id',
                'categories.category_name',
                'products.product_name',
                'products.id as product_id'
            )
                ->join('products', 'products.id', '=', 'logistic_stocks.product_id')
                ->join('categories', 'categories.id', '=', 'products.category_id')
                ->join('logistic_driver_infos', 'logistic_driver_infos.id', '=', 'logistic_stocks.driver_id')
                ->join('logistic_partners', 'logistic_partners.id', '=', 'logistic_driver_infos.logistic_partner_id')
                ->where('logistic_partners.id', Auth::user()->ref_id)
                ->groupBy('logistic_stocks.product_id');


            if ($request->category_id > 0) {
                $query = $query->where('categories.id', $request->category_id);
            }

            if ($request->driver_id > 0) {
                $query = $query->where('logistic_stocks.driver_id', $request->driver_id);
            }

            $logisticProductStockData = $query->get();

            return datatables()->of($logisticProductStockData)->toJson();
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    //Product Wise Stock Report - Empty Cans
    public function logisticEmptyCanStockList(Request $request)
    {
        try {
            $product_id = $request->product_id;
            $driver_id = $request->driver_id;
            $logisticEmptyCanStockList = "";
            $query = LogisticStockHistory::select('logistic_stock_histories.*', 'categories.category_name', 'products.product_name', 'products.id as product_id')
                ->join('products', 'products.id', 'logistic_stock_histories.product_id')
                ->join('categories', 'categories.id', 'products.category_id')
                ->join('logistic_driver_infos', 'logistic_driver_infos.id', 'logistic_stock_histories.driver_id')
                ->join('logistic_partners', 'logistic_partners.id', 'logistic_driver_infos.logistic_partner_id')

                ->where('logistic_stock_histories.inward_from_manufacture_qty', '=', 0)
                ->where('logistic_stock_histories.inward_return_manufacture_qty', '=', 0)
                ->where('logistic_stock_histories.outward_to_hub_qty', '=', 0)

                ->where('logistic_stock_histories.product_id', $product_id)
                ->where('logistic_partners.id', Auth::user()->ref_id);

            if ($request->driver_id > 0) {
                $query = $query->where('logistic_stock_histories.driver_id', $driver_id);
            }

            $logisticEmptyCanStockList = $query->get();

            return datatables()->of($logisticEmptyCanStockList)->toJson();
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    //Product Wise Stock Report - Filled Cans
    public function logisticFilledCanStockList(Request $request)
    {
        try {
            $product_id = $request->product_id;
            $driver_id = $request->driver_id;
            $logisticFilledCanStockList = "";
            $query = LogisticStockHistory::select('logistic_stock_histories.*', 'categories.category_name', 'products.product_name', 'products.id as product_id')
                ->join('products', 'products.id', 'logistic_stock_histories.product_id')
                ->join('categories', 'categories.id', 'products.category_id')
                ->join('logistic_driver_infos', 'logistic_driver_infos.id', 'logistic_stock_histories.driver_id')
                ->join('logistic_partners', 'logistic_partners.id', 'logistic_driver_infos.logistic_partner_id')

                ->where('logistic_stock_histories.inward_from_hub_empty_qty', '=', 0)
                ->where('logistic_stock_histories.outward_to_manufacture_qty', '=', 0)

                ->where('logistic_stock_histories.product_id', $product_id)
                ->where('logistic_partners.id', Auth::user()->ref_id);

            if ($request->driver_id > 0) {
                $query = $query->where('logistic_stock_histories.driver_id', $driver_id);
            }

            $logisticFilledCanStockList = $query->get();

            return datatables()->of($logisticFilledCanStockList)->toJson();
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }
}
