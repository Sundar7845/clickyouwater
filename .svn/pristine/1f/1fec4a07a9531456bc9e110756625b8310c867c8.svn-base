<?php

namespace App\Http\Controllers\Manufacturer\Stock;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ManufactureStock;
use App\Models\ManufactureStockHistory;
use App\Models\Products;
use App\Models\StockInProduction;
use App\Traits\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    use Common;
    //Product Stock Report View
    public function manStocksView()
    {
        $categories = Category::where('is_active', 1)->whereNull('deleted_at')->get();
        return view('manufacturer.stock.manstock', compact('categories'));
    }

    //Product Wise Stock Report View
    public function manufactuererStocks(Request $request)
    {
        $product_id = $request->product_id;
        $product_name = Products::where('id', $product_id)->pluck('product_name')->first();
        return view('manufacturer.stock.stock', compact('product_id', 'product_name'));
    }

    //Prodcuts Stock Report
    public function manufacturerProductStockData(Request $request)
    {
        try {
            $manufacturerProductStock = "";

            $query = ManufactureStock::select('manufacture_stocks.*', 'categories.category_name', 'products.product_name', 'products.id as product_id')
                ->join('products', 'products.id', 'manufacture_stocks.product_id')
                ->join('categories', 'categories.id', 'products.category_id')
                ->join('users', 'users.ref_id', 'manufacture_stocks.manufacture_id')
                ->where('users.id', Auth::user()->id)
                ->where('users.role_id', Auth::user()->role_id);

            if ($request->category_id > 0) {
                $query = $query->where('categories.id', $request->category_id);
            }

            $manufacturerProductStock = $query->get();

            return datatables()->of($manufacturerProductStock)->toJson();
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    //Product Wise Stock Report - Empty Cans
    public function emptyCanStockList(Request $request)
    {
        try {
            $product_id = $request->product_id;
            $emptyCanStockList = "";
            $query = ManufactureStockHistory::select('manufacture_stock_histories.*', 'categories.category_name', 'products.product_name', 'products.id as product_id')
                ->join('products', 'products.id', 'manufacture_stock_histories.product_id')
                ->join('categories', 'categories.id', 'products.category_id')
                ->join('users', 'users.ref_id', 'manufacture_stock_histories.manufacture_id')

                ->where('manufacture_stock_histories.mf_production_inward_qty', '=', 0)
                ->where('manufacture_stock_histories.mf_logistic_outward_qty', '=', 0)
                ->where('manufacture_stock_histories.mf_logistic_return_qty', '=', 0)

                ->where('manufacture_stock_histories.product_id', $product_id)
                ->where('users.id', Auth::user()->id)
                ->where('users.role_id', Auth::user()->role_id);

            $emptyCanStockList = $query->get();

            return datatables()->of($emptyCanStockList)->toJson();
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    //Product Wise Stock Report - Filled Cans
    public function filledCanStockList(Request $request)
    {
        try {
            $product_id = $request->product_id;
            $filledCanStockList = "";
            $query = ManufactureStockHistory::select('manufacture_stock_histories.*', 'categories.category_name', 'products.product_name', 'products.id as product_id')
                ->join('products', 'products.id', 'manufacture_stock_histories.product_id')
                ->join('categories', 'categories.id', 'products.category_id')
                ->join('users', 'users.ref_id', 'manufacture_stock_histories.manufacture_id')

                ->where('manufacture_stock_histories.mf_inward_qty', '=', 0)
                ->where('manufacture_stock_histories.mf_inward_return_qty', '=', 0)
                ->where('manufacture_stock_histories.mf_logistic_inward_qty', '=', 0)
                ->where('manufacture_stock_histories.mf_damage_qty', '=', 0)
                ->where('manufacture_stock_histories.mf_filling_outward_qty', '=', 0)
                ->where('manufacture_stock_histories.mf_filling_outward_return_qty', '=', 0)

                ->where('manufacture_stock_histories.product_id', $product_id)
                ->where('users.id', Auth::user()->id)
                ->where('users.role_id', Auth::user()->role_id);

            $filledCanStockList = $query->get();

            return datatables()->of($filledCanStockList)->toJson();
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }
}
