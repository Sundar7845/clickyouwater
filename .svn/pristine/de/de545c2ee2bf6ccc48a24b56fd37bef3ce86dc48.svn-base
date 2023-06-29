<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Brands;
use App\Models\Cart;
use App\Models\CustomerAddress;
use App\Models\Products;
use App\Models\StateBrandAllocation;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\Common;
use App\Traits\ResponseAPI;
use Illuminate\Support\Facades\Auth;

class BrandsController extends Controller
{
    use Common;
    use ResponseAPI;

    public function getBrands($id = null)
    {
        try {
            if ($id != null) {
                $brands = Brands::where('is_active', 1)->where('product_type_id', $id)->get(['brand_name', 'brand_image', 'product_type_id', 'id']);
            } else {
                $brands = Brands::where('is_active', 1)->get(['brand_name', 'brand_image', 'product_type_id', 'id']);
            }

            // Append base URL to product_image field
            foreach ($brands as $brand) {
                $brand->brand_image = $this->getBaseUrl() . '/' . $brand->brand_image;
            }

            $response = [
                'status' => true,
                'data' => $brands,
            ];
            return response($response, 200);
        } catch (\Exception $e) {

            $this->Log(__FUNCTION__, request()->method(), $e->getMessage(), 1, request()->ip(), gethostname(), 1);
            // return $this->error($e->getMessage(), 200);
            $response = array(
                'message' => $this->errorMessage,
                'status' => false,
            );
            return response($response, 500);
        }
    }
    public function checkBrandAvailability($address_id = null)
    {
        try {
            $delivery_address = CustomerAddress::find($address_id);
            $array_res = [];
            if (Auth::user()->carts) {
                foreach (Auth::user()->carts as $product) {
                    $products = Products::find($product->product_id);
                    $checkallocation = StateBrandAllocation::where('city_id', $delivery_address->city_id)->where('state_id', $delivery_address->state_id)
                        ->where('brand_id', 'LIKE', '%' . $products->brand_id . '%')->get();
                    if ($checkallocation->count() != 0) {
                        $product->is_available = true;
                    } else {
                        $product->is_available = false;
                    }
                    $array_res[] = array(
                        "product_id" => $product->product_id,
                        "is_available" => $product->is_available
                    );
                }
            }
            $response = [
                'status' => true,
                'data' => $array_res,
            ];
            return response($response, 200);
        } catch (\Exception $e) {

            $this->Log(__FUNCTION__, request()->method(), $e->getMessage(), 1, request()->ip(), gethostname(), 1);
            // return $this->error($e->getMessage(), 200);
            $response = array(
                'message' => $this->errorMessage,
                'status' => false,
            );
            return response($response, 500);
        }
    }
}
