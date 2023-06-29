<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['menu_name' => 'Dashboard', 'group_name' => '', 'parent_id' => 0, 'is_mainmenu' => 1, 'is_module' => 0, 'menu_order' => 1, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/dashboard', 'icon' => 'menu-icon tf-icons ti ti-smart-home'],
            ['menu_name' => 'Order Management', 'group_name' => '', 'parent_id' => 0, 'is_mainmenu' => 1, 'is_module' => 1, 'menu_order' => 2, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '', 'icon' => 'menu-icon tf-icons ti ti-layout-sidebar'],
            ['menu_name' => 'Customer Orders', 'group_name' => '', 'parent_id' => 2, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/customerorders', 'icon' => ''],
            ['menu_name' => 'Wholesale Orders', 'group_name' => '', 'parent_id' => 2, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 0, 'show_superadmin' => 0, 'menu_url' => '/wholesaleorders', 'icon' => ''],
            ['menu_name' => 'Manufacturer Orders', 'group_name' => '', 'parent_id' => 2, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/manufacturerorders', 'icon' => ''],
            ['menu_name' => 'Hub Orders', 'group_name' => '', 'parent_id' => 2, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/hub/orders', 'icon' => ''],
            ['menu_name' => 'Cancelled Orders', 'group_name' => '', 'parent_id' => 2, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/cancelledorders', 'icon' => ''],
            ['menu_name' => 'Pending Orders', 'group_name' => '', 'parent_id' => 2, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/pendingorders', 'icon' => ''],
            ['menu_name' => 'Bulk Orders', 'group_name' => '', 'parent_id' => 2, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 0, 'show_superadmin' => 0, 'menu_url' => '/bulkorders', 'icon' => ''],
            ['menu_name' => 'Accounts', 'group_name' => '', 'parent_id' => 0, 'is_mainmenu' => 1, 'is_module' => 1, 'menu_order' => 11, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '', 'icon' => 'menu-icon tf-icons ti ti-file-dollar'],
            ['menu_name' => 'Payments', 'group_name' => '', 'parent_id' => 10, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/payments', 'icon' => ''],
            ['menu_name' => 'Payments List', 'group_name' => '', 'parent_id' => 10, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/paymentslist', 'icon' => ''],
            ['menu_name' => 'Expenses', 'group_name' => '', 'parent_id' => 10, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/expense', 'icon' => ''],
            ['menu_name' => 'Expenses List', 'group_name' => '', 'parent_id' => 10, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/expenselist', 'icon' => ''],
            ['menu_name' => 'Generate Coupons', 'group_name' => '', 'parent_id' => 25, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 0, 'show_superadmin' => 1, 'menu_url' => '/generatecoupon', 'icon' => ''],
            ['menu_name' => 'Refferal History', 'group_name' => '', 'parent_id' => 56, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/referralhistory', 'icon' => ''],
            ['menu_name' => 'Offers', 'group_name' => '', 'parent_id' => 0, 'is_mainmenu' => 1, 'is_module' => 1, 'menu_order' => 8, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '', 'icon' => 'menu-icon tf-icons ti ti-percentage'],
            ['menu_name' => 'Offers', 'group_name' => '', 'parent_id' => 25, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/offer', 'icon' => ''],
            ['menu_name' => 'Offers Allocate', 'group_name' => '', 'parent_id' => 25, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/offersallocate', 'icon' => ''],
            ['menu_name' => 'Customers', 'group_name' => '', 'parent_id' => 0, 'is_mainmenu' => 1, 'is_module' => 1, 'menu_order' => 3, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '', 'icon' => 'menu-icon tf-icons ti ti-users'],
            ['menu_name' => 'Customers List', 'group_name' => '', 'parent_id' => 46, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/customers', 'icon' => ''],
            ['menu_name' => 'Reports', 'group_name' => '', 'parent_id' => 0, 'is_mainmenu' => 1, 'is_module' => 1, 'menu_order' => 12, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '', 'icon' => 'menu-icon tf-icons ti ti-flag'],
            ['menu_name' => 'Service Unavailable', 'group_name' => '', 'parent_id' => 56, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/serviceunavailable', 'icon' => ''],
            ['menu_name' => 'Settings', 'group_name' => '', 'parent_id' => 0, 'is_mainmenu' => 1, 'is_module' => 1, 'menu_order' => 15, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '', 'icon' => 'menu-icon tf-icons ti ti-settings'],
            ['menu_name' => 'Admin Settings', 'group_name' => '', 'parent_id' => 68, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/admin/settings', 'icon' => ''],
            ['menu_name' => 'Default Settings', 'group_name' => '', 'parent_id' => 68, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 0, 'show_superadmin' => 1, 'menu_url' => '/settings', 'icon' => ''],
            ['menu_name' => 'Auto Code Settings', 'group_name' => '', 'parent_id' => 68, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/billnosettings', 'icon' => ''],
            ['menu_name' => 'Refferal Settings', 'group_name' => '', 'parent_id' => 68, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/referralsettings', 'icon' => ''],
            ['menu_name' => 'Roles & Permission', 'group_name' => '', 'parent_id' => 0, 'is_mainmenu' => 1, 'is_module' => 1, 'menu_order' => 13, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '', 'icon' => 'menu-icon tf-icons ti ti-lock'],
            ['menu_name' => 'Menu Permission', 'group_name' => '', 'parent_id' => 73, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/roles-permission', 'icon' => ''],
            ['menu_name' => 'Users', 'group_name' => '', 'parent_id' => 73, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/users', 'icon' => ''],
            ['menu_name' => 'Manufacturer', 'group_name' => '', 'parent_id' => 0, 'is_mainmenu' => 1, 'is_module' => 1, 'menu_order' => 4, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '', 'icon' => 'menu-icon tf-icons ti ti-building-factory'],
            ['menu_name' => 'Add Manufacturer', 'group_name' => '', 'parent_id' => 76, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/manufacturer', 'icon' => ''],
            ['menu_name' => 'Manufacturer List', 'group_name' => '', 'parent_id' => 76, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/manufacturerlist', 'icon' => ''],
            ['menu_name' => 'Hub', 'group_name' => '', 'parent_id' => 0, 'is_mainmenu' => 1, 'is_module' => 1, 'menu_order' => 5, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '', 'icon' => 'menu-icon tf-icons ti ti-bolt'],
            ['menu_name' => 'Add Hub', 'group_name' => '', 'parent_id' => 79, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/hub', 'icon' => ''],
            ['menu_name' => 'Hub List', 'group_name' => '', 'parent_id' => 79, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/hublist', 'icon' => ''],
            ['menu_name' => 'Logistic Partner', 'group_name' => '', 'parent_id' => 0, 'is_mainmenu' => 1, 'is_module' => 1, 'menu_order' => 6, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '', 'icon' => 'menu-icon tf-icons ti ti-packge-export'],
            ['menu_name' => 'Add Logistic', 'group_name' => '', 'parent_id' => 82, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 1, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/addlogistic', 'icon' => ''],
            ['menu_name' => 'Logistic List', 'group_name' => '', 'parent_id' => 82, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 2, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/logisticlist', 'icon' => ''],
            ['menu_name' => 'Delivery Person', 'group_name' => '', 'parent_id' => 0, 'is_mainmenu' => 1, 'is_module' => 1, 'menu_order' => 7, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '', 'icon' => 'menu-icon tf-icons ti ti-truck'],
            ['menu_name' => 'Add Delivery Person', 'group_name' => '', 'parent_id' => 85, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/deliveryperson', 'icon' => ''],
            ['menu_name' => 'Delivery Person List', 'group_name' => '', 'parent_id' => 85, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/deliverypersonlist', 'icon' => ''],
            ['menu_name' => 'wholesale Partner', 'group_name' => '', 'parent_id' => 0, 'is_mainmenu' => 1, 'is_module' => 1, 'menu_order' => 20, 'is_visible' => 0, 'show_superadmin' => 0, 'menu_url' => '', 'icon' => 'menu-icon tf-icons ti ti-home'],
            ['menu_name' => 'Add wholesale Partner', 'group_name' => '', 'parent_id' => 88, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 0, 'show_superadmin' => 0, 'menu_url' => '/wholesalepartner', 'icon' => ''],
            ['menu_name' => 'wholesale Partner List', 'group_name' => '', 'parent_id' => 88, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 0, 'show_superadmin' => 0, 'menu_url' => '/wholesale-partnerlist', 'icon' => ''],
            ['menu_name' => 'Products', 'group_name' => '', 'parent_id' => 0, 'is_mainmenu' => 1, 'is_module' => 1, 'menu_order' => 9, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '', 'icon' => 'menu-icon tf-icons ti ti-color-swatch'],
            ['menu_name' => 'Categories', 'group_name' => '', 'parent_id' => 91, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/category', 'icon' => ''],
            ['menu_name' => 'Product Types', 'group_name' => '', 'parent_id' => 91, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/producttype', 'icon' => ''],
            ['menu_name' => 'Brands', 'group_name' => '', 'parent_id' => 91, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/brands', 'icon' => ''],
            ['menu_name' => 'Products', 'group_name' => '', 'parent_id' => 91, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/products', 'icon' => ''],
            ['menu_name' => 'Masters', 'group_name' => '', 'parent_id' => 0, 'is_mainmenu' => 1, 'is_module' => 1, 'menu_order' => 10, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '', 'icon' => 'menu-icon tf-icons ti ti-layout-grid'],
            ['menu_name' => 'State', 'group_name' => '', 'parent_id' => 96, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 1, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/state', 'icon' => ''],
            ['menu_name' => 'District', 'group_name' => '', 'parent_id' => 96, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 2, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/city', 'icon' => ''],
            ['menu_name' => 'Area', 'group_name' => '', 'parent_id' => 96, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 3, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/area', 'icon' => ''],
            ['menu_name' => 'Document Type', 'group_name' => '', 'parent_id' => 96, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 4, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/documenttype', 'icon' => ''],
            ['menu_name' => 'Documents', 'group_name' => '', 'parent_id' => 131, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/documentconfig', 'icon' => ''],
            ['menu_name' => 'Expense Group', 'group_name' => '', 'parent_id' => 96, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 5, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/expensegroup', 'icon' => ''],
            ['menu_name' => 'Ledger', 'group_name' => '', 'parent_id' => 96, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 6, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/ledger', 'icon' => ''],
            ['menu_name' => 'Asset', 'group_name' => '', 'parent_id' => 96, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 7, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/asset', 'icon' => ''],
            ['menu_name' => 'Asset Type', 'group_name' => '', 'parent_id' => 96, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 8, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/assettype', 'icon' => ''],
            ['menu_name' => 'Employee', 'group_name' => '', 'parent_id' => 96, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 9, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/employee', 'icon' => ''],
            ['menu_name' => 'Employee List', 'group_name' => '', 'parent_id' => 96, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 10, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/employeelist', 'icon' => ''],
            ['menu_name' => 'Brand Allocation', 'group_name' => '', 'parent_id' => 91, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/allocation', 'icon' => ''],
            ['menu_name' => 'Department', 'group_name' => '', 'parent_id' => 96, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 11, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/department', 'icon' => ''],
            ['menu_name' => 'Designation', 'group_name' => '', 'parent_id' => 96, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 12, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/designation', 'icon' => ''],
            ['menu_name' => 'Roles', 'group_name' => '', 'parent_id' => 96, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 13, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/role', 'icon' => ''],
            ['menu_name' => 'Orders', 'group_name' => 'Manufacturer', 'parent_id' => 0, 'is_mainmenu' => 1, 'is_module' => 0, 'menu_order' => 23, 'is_visible' => 1, 'show_superadmin' => 0, 'menu_url' => '/manorders', 'icon' => 'menu-icon tf-icons ti ti-layout-sidebar'],
            ['menu_name' => 'Stock Report', 'group_name' => 'Manufacturer', 'parent_id' => 0, 'is_mainmenu' => 1, 'is_module' => 0, 'menu_order' => 24, 'is_visible' => 1, 'show_superadmin' => 0, 'menu_url' => '/manstocksview', 'icon' => 'menu-icon tf-icons ti ti-file-dollar'],
            ['menu_name' => 'Documents', 'group_name' => 'Manufacturer', 'parent_id' => 0, 'is_mainmenu' => 1, 'is_module' => 0, 'menu_order' => 25, 'is_visible' => 1, 'show_superadmin' => 0, 'menu_url' => '/mandocuments', 'icon' => 'menu-icon tf-icons ti ti-forms'],
            ['menu_name' => 'Orders', 'group_name' => 'Hub', 'parent_id' => 0, 'is_mainmenu' => 1, 'is_module' => 0, 'menu_order' => 28, 'is_visible' => 1, 'show_superadmin' => 0, 'menu_url' => '/huborderlist', 'icon' => 'menu-icon tf-icons ti ti-layout-sidebar'],
            ['menu_name' => 'Stock Report', 'group_name' => 'Hub', 'parent_id' => 0, 'is_mainmenu' => 1, 'is_module' => 0, 'menu_order' => 29, 'is_visible' => 1, 'show_superadmin' => 0, 'menu_url' => '/hubstocksview', 'icon' => 'menu-icon tf-icons ti ti-file-dollar'],
            ['menu_name' => 'Documents', 'group_name' => 'Hub', 'parent_id' => 0, 'is_mainmenu' => 1, 'is_module' => 0, 'menu_order' => 30, 'is_visible' => 1, 'show_superadmin' => 0, 'menu_url' => '/hubdocuments', 'icon' => 'menu-icon tf-icons ti ti-forms'],
            ['menu_name' => 'Wallet', 'group_name' => '', 'parent_id' => 131, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/wallet-transaction-through', 'icon' => ''],
            ['menu_name' => 'Payment', 'group_name' => '', 'parent_id' => 131, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 0, 'show_superadmin' => 1, 'menu_url' => '/paymentmethod', 'icon' => ''],
            ['menu_name' => 'Logistic Vehicle Info', 'group_name' => '', 'parent_id' => 82, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 3, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/logisticvehicleinfo', 'icon' => ''],
            ['menu_name' => 'Logistic Driver Info', 'group_name' => '', 'parent_id' => 82, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 4, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/logisticdriverinfo', 'icon' => ''],
            ['menu_name' => 'Vehicle Brand', 'group_name' => '', 'parent_id' => 96, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 14, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/vehiclebrands', 'icon' => ''],
            ['menu_name' => 'Bank', 'group_name' => '', 'parent_id' => 96, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 15, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/banks', 'icon' => ''],
            ['menu_name' => 'Banners', 'group_name' => '', 'parent_id' => 96, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 16, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/banners', 'icon' => ''],
            ['menu_name' => 'Notification', 'group_name' => '', 'parent_id' => 131, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/notification-config', 'icon' => ''],
            ['menu_name' => 'Configurations', 'group_name' => '', 'parent_id' => 0, 'is_mainmenu' => 1, 'is_module' => 1, 'menu_order' => 14, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '', 'icon' => 'menu-icon tf-icons ti ti-checkbox'],
            ['menu_name' => 'Incentive List', 'group_name' => '', 'parent_id' => 85, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 0, 'show_superadmin' => 1, 'menu_url' => '/deliverypersonincentive', 'icon' => 'menu-icon tf-icons ti ti-users'],
            ['menu_name' => 'Logistic Documents', 'group_name' => '', 'parent_id' => 82, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 5, 'is_visible' => 1, 'show_superadmin' => 0, 'menu_url' => '/logisticdocuments', 'icon' => 'menu-icon tf-icons ti ti-forms'],
            ['menu_name' => 'Reasons', 'group_name' => '', 'parent_id' => 96, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 17, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/reasons', 'icon' => ''],
            ['menu_name' => 'Surrender Requests', 'group_name' => '', 'parent_id' => 46, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/surrenderrequests', 'icon' => ''],
            ['menu_name' => 'Purchase', 'group_name' => '', 'parent_id' => 10, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 0, 'show_superadmin' => 1, 'menu_url' => '/purchase', 'icon' => ''],
            ['menu_name' => 'Purchase List', 'group_name' => '', 'parent_id' => 10, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 0, 'show_superadmin' => 1, 'menu_url' => '/purchaselist', 'icon' => ''],
            ['menu_name' => 'Purchase Return', 'group_name' => '', 'parent_id' => 10, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 0, 'show_superadmin' => 1, 'menu_url' => '/purchasereturn', 'icon' => ''],
            ['menu_name' => 'Purchase Return List', 'group_name' => '', 'parent_id' => 10, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 0, 'show_superadmin' => 1, 'menu_url' => '/purchasereturnlist', 'icon' => ''],
            ['menu_name' => 'Stock Outward', 'group_name' => '', 'parent_id' => 10, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 0, 'show_superadmin' => 1, 'menu_url' => '/stockoutward', 'icon' => ''],
            ['menu_name' => 'Stock Outward List', 'group_name' => '', 'parent_id' => 10, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 0, 'show_superadmin' => 1, 'menu_url' => '/stockoutwardlist', 'icon' => ''],
            ['menu_name' => 'Receipts', 'group_name' => '', 'parent_id' => 10, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 0, 'show_superadmin' => 1, 'menu_url' => '/receipt', 'icon' => ''],
            ['menu_name' => 'Receipt List', 'group_name' => '', 'parent_id' => 10, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 0, 'show_superadmin' => 1, 'menu_url' => '/receiptlist', 'icon' => ''],
            ['menu_name' => 'Customer Feedback', 'group_name' => '', 'parent_id' => 46, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/customerfeedback', 'icon' => ''],
            ['menu_name' => 'Invoice Downloaded', 'group_name' => '', 'parent_id' => 2, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/invoicedownloadedorders', 'icon' => ''],
            ['menu_name' => 'Vehicles', 'group_name' => 'Logistic Partner', 'parent_id' => 0, 'is_mainmenu' => 1, 'is_module' => 0, 'menu_order' => 34, 'is_visible' => 1, 'show_superadmin' => 0, 'menu_url' => '/vehicles', 'icon' => 'menu-icon tf-icons ti ti-truck'],
            ['menu_name' => 'Drivers', 'group_name' => 'Logistic Partner', 'parent_id' => 0, 'is_mainmenu' => 1, 'is_module' => 0, 'menu_order' => 35, 'is_visible' => 1, 'show_superadmin' => 0, 'menu_url' => '/drivers', 'icon' => 'menu-icon tf-icons ti ti-users'],
            ['menu_name' => 'Documents', 'group_name' => 'Logistic Partner', 'parent_id' => 0, 'is_mainmenu' => 1, 'is_module' => 0, 'menu_order' => 36, 'is_visible' => 1, 'show_superadmin' => 0, 'menu_url' => '/documents', 'icon' => 'menu-icon tf-icons ti ti-file'],
            ['menu_name' => 'Delivery Person List', 'group_name' => 'Hub', 'parent_id' => 0, 'is_mainmenu' => 1, 'is_module' => 0, 'menu_order' => 33, 'is_visible' => 1, 'show_superadmin' => 0, 'menu_url' => '/hubdeliverypersonlist', 'icon' => 'menu-icon tf-icons ti ti-truck'],
            ['menu_name' => 'Stock', 'group_name' => '', 'parent_id' => 0, 'is_mainmenu' => 1, 'is_module' => 1, 'menu_order' => 38, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '', 'icon' => 'menu-icon tf-icons ti ti-layout-grid'],
            ['menu_name' => 'Outward', 'group_name' => '', 'parent_id' => 150, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 39, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/stockoutward', 'icon' => ''],
            ['menu_name' => 'Outward List', 'group_name' => '', 'parent_id' => 150, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 40, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/stockoutwardlist', 'icon' => ''],
            ['menu_name' => 'Place Order', 'group_name' => '', 'parent_id' => 150, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 41, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/adminorder', 'icon' => ''],
            ['menu_name' => 'Order List', 'group_name' => '', 'parent_id' => 150, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 42, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/adminorderlist', 'icon' => ''],
            ['menu_name' => 'Stock Report', 'group_name' => 'Logistic Partner', 'parent_id' => 0, 'is_mainmenu' => 1, 'is_module' => 0, 'menu_order' => 37, 'is_visible' => 1, 'show_superadmin' => 0, 'menu_url' => '/logisticstocksview', 'icon' => 'menu-icon tf-icons ti ti-packge-export'],
            ['menu_name' => 'Stock Reports', 'group_name' => '', 'parent_id' => 56, 'is_mainmenu' => 0, 'is_module' => 0, 'menu_order' => 0, 'is_visible' => 1, 'show_superadmin' => 1, 'menu_url' => '/stockreports', 'icon' => '']
        ];

        Menu::insert($data);
    }
}