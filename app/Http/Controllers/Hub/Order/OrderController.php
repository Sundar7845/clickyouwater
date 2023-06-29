<?php

namespace App\Http\Controllers\Hub\Order;

use App\Enums\RoleTypes;
use App\Http\Controllers\Controller;
use App\Models\Hub;
use App\Models\User;
use App\Traits\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    use Common;
    public function order()
    {
        return view('hub.order.order');
    }

    public function hubOrderData()
    {
        try {
            // $hub_id = User::where('id', Auth::user()->id)->value('ref_id');
            $hub_id = $this->getRefId(Auth::user()->id, RoleTypes::Hub);
            $hubOrder = $this->getAllOrders("Hub", 0, $hub_id)->get();
            return datatables()->of($hubOrder)
                ->addColumn('action', function ($row) {
                    $html = '<a href="/huborderlist/' . $row->id . '" class="btn btn-xs btn-primary">View</a>';
                    return $html;
                })
                ->toJson();
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }
}
