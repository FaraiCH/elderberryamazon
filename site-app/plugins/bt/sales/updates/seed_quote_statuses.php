<?php namespace Bt\Sales\Updates;

use Seeder;
use Bt\Sales\Models\QuoteStatus;
use Bt\Sales\Models\ActionToGroup;
use RainLab\User\Models\UserGroup;
use Db;

class SeedQuoteStatuses extends Seeder
{
    public function run()
    {
        // 1. Define Quote Statuses
        $statuses = [
            [1, 'New Quote', 'New Quote', 10, 0],
            [2, 'InComplete For Edit', 'InComplete For Edit', null, 1],
            [3, 'Delivery Requested', 'Request Delivery', 11, 1],
            [4, 'Delivery Approved', 'Approve Delivery', null, 1],
            [5, 'Discount Requested', 'Request Discount', 12, 1],
            [6, 'Discount Approved', 'Approve Discount', null, 1],
            [7, 'Manager Approved Quote', 'Manager Approved Quote', null, 1],
            [8, 'Quote Sent To Client', 'Complete Quote and Send To Client', null, 1],
            [9, 'Quote Signed By Client', 'Upload Signed Quote', null, 1],
            [10, 'Purchase Order', 'Upload Purchase Order', null, 1],
            [11, 'Invoiced', 'Create Invoice', null, 1],
            [12, 'Waiting For Payment', 'Waiting For Payment', null, 1],
            [13, 'Payment Received', 'Payment Received', null, 1],
            [14, 'In Production', 'Send To Production', 13, 0],
            [15, 'Quote Canceled', 'Cancel Quote', null, 1],
            [16, 'Production Started', 'Production Started', null, 0],
            [17, 'Production Completed', 'Production Completed', null, 1],
            [18, 'Production OnHold', 'Production OnHold', null, 1],
            [19, 'Notify Finance', 'Notify Finance', 5, 1],
            [20, 'Production Cancel', 'Production Cancel', 17, 1],
            [21, 'Order Cancelled', 'Order Cancelled', 4, 1],
            [22, 'Prospective Client', 'Prospective Client', 3, 0],
            [23, 'Qualified', 'Qualified', null, 0],
            [24, 'Win', 'Win', null, 0],
            [25, 'Loss', 'Loss', null, 0],
            [26, 'Quote Completed', 'Quote Completed', null, 0],
        ];

        foreach ($statuses as $status) {
            QuoteStatus::updateOrCreate(
                ['id' => $status[0]],
                [
                    'name' => $status[1],
                    'action' => $status[2],
                    'email_groups_id' => $status[3],
                    'candelete' => $status[4],
                ]
            );
        }

        // 2. Map Statuses to "Registered" user group (ID 2) so they are visible in the dropdown
        $registeredGroup = UserGroup::where('code', 'registered')->first();
        if ($registeredGroup) {
            $groupId = $registeredGroup->id;

            // Get all status IDs
            $statusIds = QuoteStatus::pluck('id')->all();

            foreach ($statusIds as $statusId) {
                ActionToGroup::updateOrCreate(
                    ['user_groups_id' => $groupId, 'quote_statuses_id' => $statusId]
                );
            }
        }
    }
}
