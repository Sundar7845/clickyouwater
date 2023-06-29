<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\Common;
use App\Traits\ResponseAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    //
    use Common;
    use ResponseAPI;

    public function getCategories()
    {
        try {

            $categorys = DB::table('categories')
                ->select(['category_name', 'category_image', 'id'])
                ->where('is_active', 1)
                ->whereNull('deleted_at')
                ->orderByDesc('is_watercan')
                ->get();
            // Append base URL to product_image field
            foreach ($categorys as $category) {
                $category->category_image = $this->getBaseUrl() . '/' . $category->category_image;
            }
            $response = [
                'status' => true,
                'data' => $categorys,
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
