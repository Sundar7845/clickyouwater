<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Models\CustomerAddress;
use App\Traits\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceUnavailableController extends Controller
{
    use Common;
    public function getServiceUnavailableReport()
    {
        $customer = CustomerAddress::where('is_service_available', 0)->whereNUll('deleted_at')->get();
        $states = $this->getStates();
        return view('admin.reports.unavailable_reports', compact('customer', 'states'));
    }

    public function getServiceUnavailableReportData(Request $request)
    {
        try {
            $serviceUnavilableData = "";
            $query = CustomerAddress::select('customer_addresses.*', 'customers.mobile', 'customers.customer_name', 'states.state_name', 'cities.city_name')
                ->join('customers', 'customers.id', 'customer_addresses.customer_id')
                ->join('states', 'states.id', 'customer_addresses.state_id')
                ->join('cities', 'cities.id', 'customer_addresses.city_id')
                ->where('is_service_available', 0)
                ->whereNUll('customer_addresses.deleted_at');

            if ($request->state_id > 0) {
                $query = $query->where('customer_addresses.state_id', $request->state_id);
            }
            if ($request->city_id > 0) {
                $query = $query->where('customer_addresses.city_id', $request->city_id);
            }

            $serviceUnavilableData = $query->get();
            return datatables()->of($serviceUnavilableData)
                ->toJson();
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }
}
