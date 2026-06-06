<?php namespace Bt\Sales\Updates;

use Seeder;
use Bt\Sales\Models\QuoteStatus;

class SeederOrderStatus extends Seeder
{
    public function run()
    {
         $arStatusList = [
             ['action' => 'New Quote', 'name' => 'New Quote'],
             ['action' => 'InComplete For Edit', 'name' => 'InComplete For Edit'],
             ['action' => 'Request Delivery', 'name' => 'Delivery Requested'],
             ['action' => 'Approve Delivery', 'name' => 'Delivery Approved'],
             ['action' => 'Request Discount', 'name' => 'Discount Requested'],
             ['action' => 'Approve Discount', 'name' => 'Discount Approved'],
             ['action' => 'Put Quote On Hold', 'name' => 'Quote On Hold'],
             ['action' => 'Complete Quote and Send To Client', 'name' => 'Quote Sent To Client'],
             ['action' => 'Upload Signed Quote', 'name' => 'Quote Signed By Client'],
             ['action' => 'Approve Quote', 'name' => 'Quote Approved'],
             ['action' => 'Invoice - Send To Sage', 'name' => 'Invoiced'],
             ['action' => 'Paid - From SAGE', 'name' => 'Paid - From SAGE'],
             ['action' => 'Make Payment - Manual', 'name' => 'Paid - Manual'],
             ['action' => 'Send To Production', 'name' => 'In Production'],
             ['action' => 'Cancel Quote', 'name' => 'Quote Canceled'],
             ['action' => 'Production Started', 'name' => 'Production Started'],
             ['action' => 'Production Completed', 'name' => 'Production Completed'],
             ['action' => 'Production OnHold', 'name' => 'Production OnHold']
         ];

         foreach ($arStatusList as $arStatusData) {
             QuoteStatus::create($arStatusData);
         }
    }
}
