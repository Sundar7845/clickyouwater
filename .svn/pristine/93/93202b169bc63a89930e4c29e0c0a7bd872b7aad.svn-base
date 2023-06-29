<?php

namespace App\Http\Controllers\Admin\ProductsManagement;

use App\Enums\MenuPermissionType;
use App\Http\Controllers\Controller;
use App\Models\AdminOrderDet;
use App\Models\Brands;
use App\Models\Cart;
use App\Models\Category;
use App\Models\CustomerStock;
use App\Models\CustomerStockHistory;
use App\Models\DeliveryPersonStock;
use App\Models\DeliveryPersonStockHistory;
use App\Models\HubReturnItemsDet;
use App\Models\HubStock;
use App\Models\HubStockHistory;
use App\Models\LogisticBookingDet;
use App\Models\LogisticStock;
use App\Models\LogisticStockHistory;
use App\Models\Manufacturer;
use App\Models\ManufactureStock;
use App\Models\ManufactureStockHistory;
use App\Models\Order;
use App\Models\OrderDet;
use App\Models\Products;
use App\Models\ProductType;
use App\Models\QuickCart;
use App\Models\StockInProduction;
use App\Models\StockOutwardDet;
use App\Models\Surrender;
use App\Models\SurrenderDet;
use App\Models\UserDepositHistory;
use App\Models\UserDepositRefundHistory;
use App\Traits\Common;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Validation\Rule;

class ProductsController extends Controller
{
    use Common;
    public function products(Request $request)
    {
        try {
            $categories = Category::where('is_active', 1)->whereNull('deleted_at')->get();
            return view('admin.product_management.products.products', compact('categories'));
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function getProductTypesBrands(Request $request)
    {
        try {
            $productType = ProductType::where('category_id', $request->category_id)->whereNull('deleted_at')->where('is_active', 1)->get();
            $brands = Brands::where('product_type_id', $request->product_type_id)->whereNull('deleted_at')->where('is_active', 1)->get();
            return response()->json([
                'productType' => $productType,
                'brands' => $brands
            ]);
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function addProducts(Request $request)
    {
        $request->validate([
            'ddlCategory' => 'required',
            'ddlProducttype' => 'required',
            'ddlBrand' => 'required',
            'txtProductName' => [
                'required',
                Rule::unique('products', 'product_name')
                    ->where('category_id', $request->ddlCategory)
                    ->where('product_type_id', $request->ddlProducttype)
                    ->where('brand_id', $request->ddlBrand)
                    ->whereNull('deleted_at')
                    ->ignore($request->hdProductId),
            ],
            'txtCustomerPrice' => 'required',
            'txtWholesalePrice' => 'required',
            'txtCapacity' => 'required',
            'txtDescription' => 'required',
            'txtCgst' => 'required',
            'txtSgst' => 'required',
            'txtHsnSaccode' => 'required',
            // 'txtExpirydurationIndays' => 'required',
            // 'productImage' => 'required'
        ], [
            'txtProductName.unique' => 'Product name already exists.'
        ]);
        DB::beginTransaction();
        try {
            if ($request->hdProductId == null) {

                $image = $request->file('productImage');
                $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                image::make($image)->save('upload/products/' . $name_gen);
                $save_url = 'upload/products/' . $name_gen;

                Products::create([
                    'category_id' => $request->ddlCategory,
                    'product_type_id' => $request->ddlProducttype,
                    'brand_id' => $request->ddlBrand,
                    'product_name' => $request->txtProductName,
                    'customer_price' => $request->txtCustomerPrice,
                    'wholesale_price' => $request->txtWholesalePrice,
                    'is_emptycan_return' => ($request->canreturn == null ? 0 : 1),
                    'capacity' => $request->txtCapacity,
                    'desc' => $request->txtDescription,
                    'CGST' => $request->txtCgst,
                    'SGST' => $request->txtSgst,
                    // 'expiry_duration_days' => $request->txtExpirydurationIndays,
                    'hsn_sac_code' => $request->txtHsnSaccode,
                    'product_image' => $save_url,
                    'created_by' => Auth::user()->id,
                    'created_at' => Carbon::now()
                ]);
                $notification = array(
                    'message' => 'Product Created Successfully',
                    'alert-type' => 'success'
                );
            } else {

                $oldImage = $request->hdProductImg;

                if ($request->file('productImage')) {
                    @unlink($oldImage);
                    $image = $request->file('productImage');
                    $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                    Image::make($image)->save('upload/products/' . $name_gen);
                    $save_url = 'upload/products/' . $name_gen;

                    Products::findorfail($request->hdProductId)->update([
                        'product_image' => $save_url,
                        'updated_by' => Auth::user()->id
                    ]);
                }

                Products::findorfail($request->hdProductId)->update([
                    'category_id' => $request->ddlCategory,
                    'product_type_id' => $request->ddlProducttype,
                    'brand_id' => $request->ddlBrand,
                    'product_name' => $request->txtProductName,
                    'customer_price' => $request->txtCustomerPrice,
                    'wholesale_price' => $request->txtWholesalePrice,
                    'is_emptycan_return' => ($request->canreturn == null ? 0 : 1),
                    'capacity' => $request->txtCapacity,
                    'desc' => $request->txtDescription,
                    'CGST' => $request->txtCgst,
                    'SGST' => $request->txtSgst,
                    // 'expiry_duration_days' => $request->txtExpirydurationIndays,
                    'hsn_sac_code' => $request->txtHsnSaccode,
                    'updated_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Product Updated Successfully',
                    'alert-type' => 'success'
                );
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $notification = array(
                'message' => 'Product Not Created!',
                'alert-type' => 'error'
            );
            $this->Log(__FUNCTION__, $request->method(), $e->getMessage(), Auth::user()->id, $request->ip(), gethostname());
        }

        return redirect()->route('products')->with($notification);
    }

    public function getProductsData()
    {
        try {
            $productsData = Products::select(
                'products.*',
                'categories.category_name',
                'brands.brand_name',
                'product_types.product_type_name'
            )
                ->join('categories', 'categories.id', 'products.category_id')
                ->join('product_types', 'product_types.id', 'products.product_type_id')
                ->join('brands', 'brands.id', 'products.brand_id')
                ->orderBy('products.id', 'ASC')
                ->get();

            return datatables()->of($productsData)
                ->addColumn('action', function ($row) {
                    $html = "";
                    if ($this->isUserHavePermission(MenuPermissionType::Edit)) {
                        $html = '<i class="text-primary ti ti-pencil me-1"
                onclick="doEdit(' . $row->id . ');"></i> ';
                    }
                    // if ($this->isUserHavePermission(MenuPermissionType::Delete)) {
                    //     $html .= '<i class="text-danger ti ti-trash me-1" id="confrim-color(' . $row->id . ')" onclick="showDelete(' . $row->id . ');"></i>';
                    // }
                    return $html;
                })->toJson();
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function getProductsById($id)
    {
        try {
            $products = Products::select('products.*', 'categories.category_name', 'brands.brand_name', 'product_types.product_type_name')
                ->join('categories', 'categories.id', 'products.category_id')
                ->join('product_types', 'product_types.id', 'products.product_type_id')
                ->join('brands', 'brands.id', 'products.brand_id')
                ->where('products.id', $id)->first();
            return response()->json([
                'products' => $products
            ]);
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }


    public function deleteProducts($id)
    {
        DB::beginTransaction();
        try {
            $references = [
                AdminOrderDet::class, Cart::class, CustomerStock::class, CustomerStockHistory::class, DeliveryPersonStock::class, DeliveryPersonStockHistory::class, HubReturnItemsDet::class, HubStock::class, HubStockHistory::class, LogisticBookingDet::class, LogisticStock::class, LogisticStockHistory::class, ManufactureStock::class, ManufactureStockHistory::class, OrderDet::class, QuickCart::class, StockInProduction::class, StockOutwardDet::class, SurrenderDet::class, UserDepositHistory::class, UserDepositRefundHistory::class,
            ];

            $count = 0;
            foreach ($references as $reference) {
                $count += $reference::where('product_id', $id)->count();
            }
            if ($count === 0) {
                $product = Products::findOrFail($id);
                $product->delete();
                $product->update([
                    'deleted_by' => Auth::user()->id
                ]);

                $notification = [
                    'message' => 'Product Deleted Successfully',
                    'alert' => 'success'
                ];
            } else {
                $notification = [
                    'message' => 'Product Could Not Be Deleted!',
                    'alert' => 'error'
                ];
            }
            DB::commit();
            return response()->json([
                'responseData' => $notification
            ]);
        } catch (QueryException $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = [
                'message' => 'Product could not be deleted',
                'alert' => 'error'
            ];
            return response()->json([
                'responseData' => $notification
            ]);
        }
    }


    public function activeStatus($id, $status)
    {
        DB::beginTransaction();
        try {
            Products::findorfail($id)->update([
                'is_active' => $status,
                'updated_by' => Auth::user()->id
            ]);

            if ($status == 0) {
                Cart::where('product_id', $id)->delete();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }
}
