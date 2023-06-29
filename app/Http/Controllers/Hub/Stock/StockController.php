<?php

namespace App\Http\Controllers\Hub\Stock;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\HubStock;
use App\Models\HubStockHistory;
use App\Models\Products;
use App\Traits\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    use Common;
    //Product Stock Report View
    public function hubStocksView()
    {
        try {
            $categories = Category::where('is_active', 1)->whereNull('deleted_at')->get();
            return view('hub.stock.hub_stock', compact('categories'));
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    //Product Wise Stock Report View
    public function hubStocks(Request $request)
    {
        try {
            $product_id = $request->product_id;
            $product_name = Products::where('id', $product_id)->pluck('product_name')->first();
            return view('hub.stock.stock', compact('product_id', 'product_name'));
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    //Prodcuts Stock Report
    public function hubProductStockData(Request $request)
    {
        try {
            $hubProductStockData = "";

            $query = HubStock::select('hub_stocks.*', 'categories.category_name', 'products.product_name', 'products.id as product_id')
                ->join('products', 'products.id', 'hub_stocks.product_id')
                ->join('categories', 'categories.id', 'products.category_id')
                ->join('users', 'users.ref_id', 'hub_stocks.hub_id')
                ->where('users.id', Auth::user()->id)
                ->where('users.role_id', Auth::user()->role_id);

            if ($request->category_id > 0) {
                $query = $query->where('categories.id', $request->category_id);
            }

            $hubProductStockData = $query->get();

            return datatables()->of($hubProductStockData)->toJson();
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    //Product Wise Stock Report - Empty Cans
    public function hubEmptyCanStockList(Request $request)
    {
        try {
            $product_id = $request->product_id;
            $hubemptycanstocklist = "";
            $query = HubStockHistory::select('hub_stock_histories.*', 'categories.category_name', 'products.product_name', 'products.id as product_id')
                ->join('products', 'products.id', 'hub_stock_histories.product_id')
                ->join('categories', 'categories.id', 'products.category_id')
                ->join('users', 'users.ref_id', 'hub_stock_histories.hub_id')

                ->where('hub_stock_histories.inward_from_logistics_qty', '=', 0)
                ->where('hub_stock_histories.inward_return_qty', '=', 0)
                ->where('hub_stock_histories.outward_to_delivery_qty', '=', 0)
                ->where('hub_stock_histories.outward_filled_return_qty', '=', 0)

                ->where('hub_stock_histories.product_id', $product_id)
                ->where('users.id', Auth::user()->id)
                ->where('users.role_id', Auth::user()->role_id);

            $hubemptycanstocklist = $query->get();

            return datatables()->of($hubemptycanstocklist)->toJson();
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    //Product Wise Stock Report - Filled Cans
    public function hubFilledCanStockList(Request $request)
    {
        try {
            $product_id = $request->product_id;
            $hubFilledCanStockList = "";
            $query = HubStockHistory::select('hub_stock_histories.*', 'categories.category_name', 'products.product_name', 'products.id as product_id')
                ->join('products', 'products.id', 'hub_stock_histories.product_id')
                ->join('categories', 'categories.id', 'products.category_id')
                ->join('users', 'users.ref_id', 'hub_stock_histories.hub_id')

                ->where('hub_stock_histories.inward_from_delivery_qty', '=', 0)
                ->where('hub_stock_histories.outward_to_logistics_qty', '=', 0)

                ->where('hub_stock_histories.product_id', $product_id)
                ->where('users.id', Auth::user()->id)
                ->where('users.role_id', Auth::user()->role_id);

            $hubFilledCanStockList = $query->get();

            return datatables()->of($hubFilledCanStockList)->toJson();
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }
}
