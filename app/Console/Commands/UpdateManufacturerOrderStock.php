<?php

namespace App\Console\Commands;

use App\Enums\StatusTypes;
use App\Models\HubManufactureConfig;
use App\Models\ManufactureStock;
use App\Models\Order;
use App\Models\OrderDet;
use Illuminate\Console\Command;
use App\Traits\Common;

class UpdateManufacturerOrderStock extends Command
{
    use Common;

    protected $signature = 'updatemanufacturerorderstock:run';

    protected $description = 'Update Manufacturer Order Stock';

    public function handle()
    {   //Find Placed Order Before 48hrs
        $orders = Order::whereIn('status_id', [StatusTypes::OrderPlaced, StatusTypes::AssignedToDelivery, StatusTypes::OrderShipped, StatusTypes::OrderNotDelivered])->where('is_manufacture_received', 0)->where('transaction_date', '<', now()->subHours($this->getAdminSetting()->show_orders_to_manufacturer))->get();

        foreach ($orders as $order) {
            //Find Manufacturer against the orders
            $manufacturer_ids = HubManufactureConfig::where('hub_id', $order->hub_id)->pluck('manufacturer_id')->toArray();
            //Find Order Details against the orders
            $orderDets = OrderDet::where('order_id', $order->id)->get();
            //Loop Order Details and And Each Manufacuturer to update Order Qty against Manufacturer and Product
            foreach ($orderDets as $orderDet) {
                foreach ($manufacturer_ids as $manufacturer_id) {
                    ManufactureStock::updateOrCreate(
                        [
                            "manufacture_id" => $manufacturer_id,
                            "product_id" => $orderDet->product_id,
                        ],
                        [
                            "order_qty" => ManufactureStock::where([
                                "manufacture_id" => $manufacturer_id,
                                "product_id" => $orderDet->product_id,
                            ])->value('order_qty') + $orderDet->qty,
                        ]
                    );
                    //Update Orders after Manufacturer Received
                    Order::where('id', $orderDet->order_id)
                        ->update([
                            'is_manufacture_received' => 1
                        ]);
                }
            }
        }
        //Record Log History
        $this->Log(__FUNCTION__, "UPDATE", "Update Manufacturer Order Stock", 1, request()->ip(), gethostname());
    }
}
