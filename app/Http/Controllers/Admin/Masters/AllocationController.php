<?php

namespace App\Http\Controllers\Admin\Masters;

use App\Enums\MenuPermissionType;
use App\Http\Controllers\Controller;
use App\Models\Brands;
use App\Models\Category;
use App\Models\City;
use App\Models\ProductType;
use App\Models\State;
use App\Models\StateBrandAllocation;
use App\Traits\Common;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AllocationController extends Controller
{
    use Common;
    public function allocation()
    {
        try {
            //Get states
            $states = $this->getStates();
            $category = Category::where('is_active', 1)->whereNull('deleted_at')->get();
            $brands = Brands::select('brands.*', 'product_types.product_type_name', 'categories.category_name')
                ->join('product_types', 'product_types.id', 'brands.product_type_id')
                ->join('categories', 'categories.id', 'brands.category_id')
                ->where('brands.is_active', 1)
                ->whereNull('brands.deleted_at')
                ->get();
            return view('admin.masters.allocation.allocation', compact('states', 'category', 'brands'));
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function getProductType(Request $request)
    {
        try {
            $productType = ProductType::where('category_id', $request->category_id)->where('is_active', 1)->whereNull('deleted_at')->get();
            $brands = Brands::where('product_type_id', $request->product_type_id)->where('is_active', 1)->whereNull('deleted_at')->get();
            return response()->json([
                'productType' => $productType,
                'brands' => $brands
            ]);
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function addBrandallocate(Request $request)
    {
        $request->validate([
            'ddlState' => 'required',
            'ddlCity' => 'required',
            'taballocatedbrandname' => 'required',
        ]);
        DB::beginTransaction();
        try {

            $allocated_city = StateBrandAllocation::where('city_id', $request->ddlCity)->first();
            if ($allocated_city == null) {
                $array = $request->taballocatedbrandname;
                $string = implode(',', $array);
                StateBrandAllocation::create([
                    'state_id' => $request->ddlState,
                    'city_id' => $request->ddlCity,
                    'brand_id' => $string,
                    'created_by' => Auth::user()->id,
                    'created_at' => Carbon::now()
                ]);
                $notification = array(
                    'message' => 'Brands Allocated Successfully',
                    'alert-type' => 'success'
                );
            } else {
                $array = $request->taballocatedbrandname;
                $string = implode(',', $array);
                StateBrandAllocation::findorfail($allocated_city->id)->update([
                    'state_id' => $request->ddlState,
                    'city_id' => $request->ddlCity,
                    'brand_id' => $string,
                    'updated_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Brands Allocation Updated Successfully',
                    'alert-type' => 'success'
                );
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $notification = array(
                'message' => 'Brand Not Allocated!',
                'alert-type' => 'error'
            );
            $this->Log(__FUNCTION__, $request->method(), $e->getMessage(), Auth::user()->id, $request->ip(), gethostname());
        }
        return redirect()->route('allocations')->with($notification);
    }

    public function getBrandallocateById($id)
    {
        try {
            $brandallocation = StateBrandAllocation::select('state_brand_allocations.*', 'states.state_name', 'cities.city_name', 'brands.brand_name', 'categories.category_name', 'product_types.product_type_name')
                ->join('states', 'states.id', 'state_brand_allocations.state_id')
                ->join('cities', 'cities.id', 'state_brand_allocations.city_id')
                ->join('brands', 'brands.id', 'state_brand_allocations.brand_id')
                ->join('product_types', 'product_types.id', 'state_brand_allocations.product_type_id')
                ->join('categories', 'categories.id', 'state_brand_allocations.category_id')
                ->where('state_brand_allocations.id', $id)
                ->first();
            return response()->json([
                'brandallocation' => $brandallocation
            ]);
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function deleteBrandallocate($id)
    {
        DB::beginTransaction();
        try {
            $brandallocation = StateBrandAllocation::findorfail($id);
            $brandallocation->delete();
            $brandallocation->update([
                'deleted_by' => Auth::user()->id
            ]);

            $notification = array(
                'message' => 'Brands Allocation Deleted Successfully!',
                'alert' => 'success'
            );
            DB::commit();
            return response()->json([
                'responseData' => $notification
            ]);
        } catch (QueryException $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => 'Brands Allocation Could Not Be Deleted!',
                'alert' => 'error'
            );
            return response()->json([
                'responseData' => $notification
            ]);
        }
    }

    public function getBrandallocateData()
    {
        try {
            $brandallocation = StateBrandAllocation::select('state_brand_allocations.*', 'states.state_name', 'cities.city_name', 'brands.brand_name', 'categories.category_name', 'product_types.product_type_name')
                ->join('states', 'states.id', 'state_brand_allocations.state_id')
                ->join('cities', 'cities.id', 'state_brand_allocations.city_id')
                ->join('product_types', 'product_types.id', 'state_brand_allocations.product_type_id')
                ->join('categories', 'categories.id', 'state_brand_allocations.category_id')
                ->join('brands', 'brands.id', 'state_brand_allocations.brand_id')->get();

            // $brandallocation->transform(function ($item) {
            //     $brandIds = explode(',', $item->brand_id);
            //     $brandNames = Brands::whereIn('id', $brandIds)->pluck('brand_name')->toArray();
            //     $item->brand_names = implode(', ', $brandNames);
            //     return $item;
            // });

            return datatables()->of($brandallocation)
                ->addColumn('action', function ($row) {
                    $html = "";
                    if ($this->isUserHavePermission(MenuPermissionType::Edit)) {
                        $html = '<i class="text-primary ti ti-pencil me-1" onclick="doEdit(' . $row->id . ');"></i> ';
                    }
                    if ($this->isUserHavePermission(MenuPermissionType::Delete)) {
                        $html .= '<i class="text-danger ti ti-trash me-1" id="confrim-color(' . $row->id . ')" onclick="showDelete(' . $row->id . ');"></i>';
                    }
                    return $html;
                })->toJson();
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function brandsData(Request $request)
    {
        $allocatedBrands = "";
        $query = StateBrandAllocation::select('brand_id')
            ->where('state_brand_allocations.state_id', $request->state_id)
            ->where('state_brand_allocations.city_id', $request->city_id);

        $allocatedBrands = $query->get();
        $brandIds = $allocatedBrands->pluck('brand_id')->first();
        //$brandId = Brands::whereNotIn('id', explode(',', $brandIds))->get();
        //dd($brandId);

        $brands = Brands::select('brands.*', 'product_types.product_type_name', 'categories.category_name')
            ->join('product_types', 'product_types.id', 'brands.product_type_id')
            ->join('categories', 'categories.id', 'brands.category_id')
            ->whereNotIn('brands.id', explode(',', $brandIds))
            ->where('brands.is_active', 1)
            ->whereNull('brands.deleted_at')
            ->get();

        return response()->json([
            'brands' => $brands
        ]);
    }

    public function allocateBrand(Request $request)
    {
        $allocatebrand = "";
        $query = StateBrandAllocation::select('state_brand_allocations.brand_id')
            ->distinct();

        $query = $query->where('state_brand_allocations.state_id', $request->state_id)
            ->where('state_brand_allocations.city_id', $request->city_id);


        $allocatebrand = $query->get();

        $brandIds = $allocatebrand->pluck('brand_id')->toArray();

        $splitValues = [];
        foreach ($brandIds as $brandId) {
            $splitValues = array_merge($splitValues, explode(',', $brandId));
        }

        $brands = [];
        foreach ($splitValues as $item) {
            $brand = Brands::select('brands.*', 'product_types.product_type_name', 'categories.category_name')
                ->join('product_types', 'product_types.id', 'brands.product_type_id')
                ->join('categories', 'categories.id', 'brands.category_id')
                ->where('brands.id', $item)
                ->where('brands.is_active', 1)
                ->whereNull('brands.deleted_at')
                ->get();
            $brands[] = $brand;
        }

        return response()->json([
            'brands' => $brands
        ]);
    }
}
