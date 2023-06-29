<?php

namespace Database\Seeders;

use App\Enums\NotificationTypes;
use App\Models\NotificationTypeVariables;
use Illuminate\Database\Seeder;

class NotificationTypeVariablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'notification_type_id' => NotificationTypes::OrderPlaced,
                'variables' => '{{orderno}}',
                'replace_column' => 'order_no'
            ],
        ];

        NotificationTypeVariables::insert($data);
    }
}
