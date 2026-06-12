<?php namespace Bt\Sales\Updates;

use Seeder;
use RainLab\User\Models\UserGroup;

class SeederUserGroups extends Seeder
{
    public function run()
    {
        $groups = [
            ['name' => 'Guest', 'code' => 'guest', 'description' => 'Default group for guest users.'],
            ['name' => 'Registered', 'code' => 'registered', 'description' => 'Default group for registered users.'],
            ['name' => 'Sales', 'code' => 'sales', 'description' => ''],
            ['name' => 'Production Manager', 'code' => 'production', 'description' => ''],
            ['name' => 'Finance Manager', 'code' => 'finance', 'description' => ''],
            ['name' => 'Executive User', 'code' => 'executive-user', 'description' => ''],
            ['name' => 'Stock Room Clerk', 'code' => 'stock-room-clerk', 'description' => ''],
            ['name' => 'Notify', 'code' => 'notify', 'description' => 'Test'],
            ['name' => 'Raw Material Notification', 'code' => 'raw-material-notification', 'description' => ''],
            ['name' => 'New quote notify', 'code' => 'new-quote-notify', 'description' => ''],
            ['name' => 'Request Delivery Email Notify', 'code' => 'request-delivery-email-notify', 'description' => ''],
            ['name' => 'Request Discount Email Notify', 'code' => 'request-discount-email-notify', 'description' => ''],
            ['name' => 'Quote Production Email Notify', 'code' => 'quote-production-email-notify', 'description' => ''],
            ['name' => 'Production Approval', 'code' => 'production-approval', 'description' => 'Production Approval'],
            ['name' => 'Delivery Plan Notify', 'code' => 'delivery-plan-notify', 'description' => ''],
            ['name' => 'Head Office', 'code' => 'head-office', 'description' => 'Head Office - Noezan And Lekola'],
            ['name' => 'Production Team', 'code' => 'production-team', 'description' => 'Production Team'],
            ['name' => 'Completed Order Notify', 'code' => 'completed-order-notify', 'description' => ''],
            ['name' => 'Delivered/Collected Notify', 'code' => 'delivered-collected-notify', 'description' => ''],
            ['name' => 'QC approval', 'code' => 'qc-approval', 'description' => 'qc-approval'],
            ['name' => 'Checklist Notify', 'code' => 'checklist-notify', 'description' => 'Checklist Notify'],
            ['name' => 'Return Note Notification', 'code' => 'return-note-notification', 'description' => ''],
            ['name' => 'Management Notify', 'code' => 'management-notify', 'description' => ''],
            ['name' => 'Logistics Schedule Approval', 'code' => 'logistics-schedule-approval', 'description' => 'Mail to logistics group to approve Schedules'],
            ['name' => 'Dev', 'code' => 'dev', 'description' => ''],
            ['name' => 'PN Rating Notice', 'code' => 'pn-rating-notice', 'description' => ''],
            ['name' => 'Petty Cash Notification', 'code' => 'petty-cash-notification', 'description' => 'Petty Cash Notification'],
            ['name' => 'Maintenance Jobcard', 'code' => 'maintenance-jobcard', 'description' => ''],
            ['name' => 'Vehicle Notification', 'code' => 'vehicle-notification', 'description' => ''],
            ['name' => 'Job-Card Notification', 'code' => 'job-card-notification', 'description' => ''],
            ['name' => 'Pipe Approval', 'code' => 'pipe-approval', 'description' => ''],
            ['name' => 'Coc Request', 'code' => 'coc-request', 'description' => ''],
            ['name' => 'Boardroom Booking', 'code' => 'boardroom-booking', 'description' => ''],
            ['name' => 'Baila Breakdown', 'code' => 'baila-breakdown', 'description' => ''],
            ['name' => 'Visitor', 'code' => 'visitor', 'description' => ''],
            ['name' => 'Production Tablets', 'code' => 'tablets', 'description' => ''],
            ['name' => 'Pipe Failed Notify', 'code' => 'pipe-failed-notify', 'description' => 'This is to notify QC and Production Team of a pipe that has been marked as failed'],
            ['name' => 'Finance PO Notification', 'code' => 'finance-po-notification', 'description' => ''],
            ['name' => 'QC Override', 'code' => 'qc-override', 'description' => 'Override QC'],
        ];

        foreach ($groups as $group) {
            UserGroup::updateOrCreate(['code' => $group['code']], $group);
        }
    }
}
