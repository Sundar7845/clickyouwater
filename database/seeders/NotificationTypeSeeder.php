<?php

namespace Database\Seeders;

use App\Models\NotificationType;
use Illuminate\Database\Seeder;

class NotificationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['notification_type' => 'Order Placed'],
            ['notification_type' => 'Payment Success'],
            ['notification_type' => 'Payment Failed'],
            ['notification_type' => 'Wholesale Customer Approved'],
            ['notification_type' => 'Wholesale Customer Rejected'],
            ['notification_type' => 'Invoice Downloaded'],
            ['notification_type' => 'Order Cancelled'],
            ['notification_type' => 'Order Shipped'],
            ['notification_type' => 'Order Delivered'],
            ['notification_type' => 'Wallet Pending'],
            ['notification_type' => 'Wallet Success'],
            ['notification_type' => 'Wallet Failed'],
            ['notification_type' => 'Referral'],
            ['notification_type' => 'Used'],
            ['notification_type' => 'Offers'],
            ['notification_type' => 'Order Could Not Delivered'],
            ['notification_type' => 'Refund Requested'],
            ['notification_type' => 'Surrender Requested'],
            ['notification_type' => 'Surrender Approved'],
            ['notification_type' => 'Surrender Rejected'],
            ['notification_type' => 'Surrender Can Collected'],
            ['notification_type' => 'Surrender Request Cancelled'],
            ['notification_type' => 'Logistic Booked'],
            ['notification_type' => 'Manufacture Delivered'],
            ['notification_type' => 'Logistic Received from Manufacture'],
            ['notification_type' => 'Order Assigned'],
            ['notification_type' => 'Order Accepted By DP'],
            ['notification_type' => 'Order Rejected By DP'],
            ['notification_type' => 'Refund Request Approved'],
            ['notification_type' => 'Hub Order Placed'],
            ['notification_type' => 'Hub Order Cancelled By Customer'],
            ['notification_type' => 'Hub Order Cancelled By Admin'],
            ['notification_type' => 'Hub Order Accepted By DP'],
            ['notification_type' => 'Hub Order Rejected By DP'],
            ['notification_type' => 'Hub Order Delivered'],
            ['notification_type' => 'Hub Order Could Not Delivered'],
            ['notification_type' => 'Hub Surrender Approved'],
        ];
        NotificationType::insert($data);
    }
}
