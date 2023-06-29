<?php

namespace App\Http\Controllers\Admin\Accounts;

use App\Enums\DocumentModulesType;
use App\Http\Controllers\Controller;
use App\Models\Manufacturer;
use App\Models\ManufactureStock;
use App\Models\ManufactureStockHistory;
use App\Models\Products;
use App\Models\StockOutward;
use App\Models\StockOutwardDet;
use App\Traits\Common;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockOutwardController extends Controller
{
    use Common;
    //Stock OutWard View
    public function StockOutward()
    {
        try {
            $stockOutwardNo = $this->getAutoGeneratedCode(DocumentModulesType::StockOutward);
            $manufacturer = Manufacturer::where('is_active', 1)->whereNull('deleted_at')->get();
            $products = Products::select('products.id as product_id', 'products.product_name as product_name')
                ->join('categories', 'categories.id', 'products.category_id', 'products.id as product_id')
                ->where('categories.is_watercan', 1)
                ->where('products.is_active', 1)
                ->whereNull('products.deleted_at')
                ->get();
            return view('admin.accounts.stock_outward.stock_outward', compact('stockOutwardNo', 'manufacturer', 'products'));
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    //Store OutWard Data
    public function addStockOutward(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                "stockOutwardNo" => 'required',
                "ddlManufacturerName" => 'required',
                "tabProductName" => 'required',
                "tabProductQty" => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            $productName = $request->tabProductName;
            $productQty = $request->tabProductQty;

            if (count($productName) && count($productName) == count($productQty)) {

                $stockOutward = StockOutward::create([
                    "outward_no" => $request->stockOutwardNo,
                    "manufacture_id" => $request->ddlManufacturerName,
                    "created_by" => Auth::user()->id,
                    "updated_by" => Auth::user()->id
                ]);

                foreach ($productName as $key => $product) {
                    StockOutwardDet::create([
                        'stock_outward_id' => $stockOutward->id,
                        'product_id' => $product,
                        'qty' => $productQty[$key]
                    ]);

                    //Store Stock Data in Manufacturer Stock
                    ManufactureStock::updateOrCreate([
                        'product_id' => $product,
                        'manufacture_id' => $request->ddlManufacturerName,
                    ], [
                        'manufacture_id' => $request->ddlManufacturerName,
                        'product_id' => $product,
                        'empty_qty' => DB::raw('empty_qty + ' . $productQty[$key])
                    ]);

                    $product = Products::find($product);
                    ManufactureStockHistory::Create([
                        'manufacture_id' => $request->ddlManufacturerName,
                        'product_type_id' => $product->product_type_id,
                        'brand_id' => $product->brand_id,
                        'category_id' => $product->category_id,
                        'product_id' => $product->id,
                        'mf_inward_qty' => $productQty[$key],
                    ]);
                }
            }

            //Increase StockOutward count in settings table
            $this->updateLiveCount(DocumentModulesType::StockOutward, 1);

            DB::commit();
            $notification = array(
                'message' => 'Outward Added Successfully',
                'alert-type' => 'success'
            );
        } catch (\Exception $e) {
            DB::rollback();
            $notification = array(
                'message' => 'Something Went Wrong!',
                'alert-type' => 'error'
            );
            $this->Log(__FUNCTION__, $request->method(), $e->getMessage(), Auth::user()->id, $request->ip(), gethostname());
        }
        return redirect()->route('stockoutward')->with($notification);
    }

    public function stockOutwardList()
    {
        try {
            $manufacturer = Manufacturer::where('is_active', 1)->whereNull('deleted_at')->get();
            return view('admin.accounts.stock_outward.stock_outward_list', compact('manufacturer'));
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function stockOutwardData(Request $request)
    {
        try {
            $stockOutwardData = "";
            $query = StockOutward::select('stock_outwards.*', 'manufacturers.manufacturer_name', 'stock_outward_dets.product_id', 'products.product_name', 'stock_outward_dets.qty')
                ->join('stock_outward_dets', 'stock_outward_dets.stock_outward_id', 'stock_outwards.id')
                ->join('products', 'products.id', 'stock_outward_dets.product_id')
                ->join('manufacturers', 'manufacturers.id', 'stock_outwards.manufacture_id');

            if ($request->manufacturer_id > 0) {
                $query = $query->where('stock_outwards.manufacture_id', $request->manufacturer_id);
            }

            $stockOutwardData = $query->get();

            return datatables()->of($stockOutwardData)->toJson();
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }
}