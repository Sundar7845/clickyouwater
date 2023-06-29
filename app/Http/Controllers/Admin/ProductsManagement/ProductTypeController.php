<?php

namespace App\Http\Controllers\Admin\ProductsManagement;

use App\Enums\MenuPermissionType;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\MainProductType;
use App\Models\Products;
use App\Models\ProductType;
use App\Traits\Common;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductTypeController extends Controller
{
    use Common;
    public function prodctType()
    {
        try {
            $productType = ProductType::whereNull('deleted_at')->get();
            $category = Category::whereNull('deleted_at')->where('is_active', 1)->get();
            return view('admin.product_management.product_type.product_type', compact('productType', 'category'));
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function addProductType(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ddlCategory' => 'required',
            'txtProductTypeName' => [
                'required',
                Rule::unique('product_types', 'product_type_name')
                    ->WhereNull('deleted_at')
                    ->where(function ($query) use ($request) {
                        return $query->where('category_id', $request->ddlCategory);
                    })
                    ->ignore($request->hdProductTypeId),
            ],
            'txtDeliveryCharge' => 'required',
            'txtDeliveryDuration' => 'required',
            'timeOrderBefore' => 'required',
            'txtNewCanDeposit' => 'required',
            'txtMinQty' => 'required',
            'txtMaxQty' => 'required',
            'txtdescription' => 'required'
        ], [
            'txtProductTypeName.unique' => 'Product type Name already exists.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            if ($request->hdProductTypeId == null) {
                ProductType::create([
                    'category_id' => $request->ddlCategory,
                    'product_type_name' => $request->txtProductTypeName,
                    'delivery_charge' => $request->txtDeliveryCharge,
                    'delivery_duration' => $request->txtDeliveryDuration,
                    'order_before_time' => $request->timeOrderBefore,
                    'newcan_deposit_amt' => $request->txtNewCanDeposit,
                    'min_order_qty' => $request->txtMinQty,
                    'max_order_qty' => $request->txtMaxQty,
                    'desc' => $request->txtdescription,
                    'is_elite' => $request->chkElite ?? 0,
                    'is_active' => 1,
                    'created_by' => Auth::user()->id,
                    'created_at' => Carbon::now()
                ]);
                $notification = array(
                    'message' => 'Product Type Created Successfully',
                    'alert-type' => 'success'
                );
            } else {
                ProductType::findorfail($request->hdProductTypeId)->update([
                    'category_id' => $request->ddlCategory,
                    'product_type_name' => $request->txtProductTypeName,
                    'delivery_charge' => $request->txtDeliveryCharge,
                    'delivery_duration' => $request->txtDeliveryDuration,
                    'order_before_time' => $request->timeOrderBefore,
                    'newcan_deposit_amt' => $request->txtNewCanDeposit,
                    'min_order_qty' => $request->txtMinQty,
                    'max_order_qty' => $request->txtMaxQty,
                    'desc' => $request->txtdescription,
                    'is_elite' => $request->chkElite ?? 0,
                    'is_active' => 1,
                    'updated_by' => Auth::user()->id
                ]);
                $notification = array(
                    'message' => 'Product Type Updated Successfully',
                    'alert-type' => 'success'
                );
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $notification = array(
                'message' => 'Product Type Not Created!',
                'alert-type' => 'error'
            );
            $this->Log(__FUNCTION__, $request->method(), $e->getMessage(), Auth::user()->id, $request->ip(), gethostname());
        }
        return redirect()->route('product-type')->with($notification);
    }

    public function deleteProductType($id)
    {
        DB::beginTransaction();
        try {
            $productType = ProductType::findorfail($id);
            $productType->delete();
            $productType->update([
                'deleted_by' => Auth::user()->id
            ]);

            $notification = array(
                'message' => 'Product Type Deleted Successfully',
                'alert' => 'success'
            );
            DB::commit();
            return response()->json([
                'responseData' => $notification
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => 'Product Type could not be deleted',
                'alert' => 'error'
            );
            return response()->json([
                'responseData' => $notification
            ]);
        }
    }

    public function getProductTypeById($id)
    {
        try {
            $productType = ProductType::where('id', $id)->whereNull('deleted_at')->first();
            return response()->json([
                'ProductType' => $productType
            ]);
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function getProductTypeData()
    {
        try {
            $productType = ProductType::select(
                'product_types.*',
                'categories.category_name',
                'categories.is_active as catIs_active',
                DB::raw("DATE_FORMAT(product_types.order_before_time, '%h:%i %p') as formatted_start_date"),
                'brands.product_type_id as brands_product_type_id'
            )
                ->join('categories', 'categories.id', 'product_types.category_id')
                ->leftJoin('brands', 'brands.product_type_id', 'product_types.id')
                ->whereNull('product_types.deleted_at')
                ->groupBy('product_types.id')
                ->orderBy('product_types.id', 'ASC')
                ->get();

            return datatables()->of($productType)
                ->addColumn('formatted_order_before_time', function ($row) {
                    return $row->formatted_start_date;
                })
                ->addColumn('action', function ($row) {
                    $html = "";
                    if ($row->catIs_active == 1) {
                        if ($this->isUserHavePermission(MenuPermissionType::Edit)) {
                            $html = '<i class="text-primary ti ti-pencil me-1" onclick="doEdit(' . $row->id . ');"></i> ';
                        }
                    }
                    if ($this->isUserHavePermission(MenuPermissionType::Delete) && $row->brands_product_type_id == null) {
                        $html .= '<i class="text-danger ti ti-trash me-1" id="confrim-color(' . $row->id . ')" onclick="showDelete(' . $row->id . ');"></i>';
                    }
                    return $html;
                })
                ->toJson();
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function activeStatus($id, $status)
    {
        DB::beginTransaction();
        try {
            ProductType::findorfail($id)->update([
                'is_active' => $status,
                'updated_by' => Auth::user()->id
            ]);
            if ($status == 0) {
                $productIds = Products::where('product_type_id', $id)->pluck('id')->toArray();
                Cart::whereIn('product_id', $productIds)->delete();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }
}
