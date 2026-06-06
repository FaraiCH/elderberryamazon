<?php

namespace Bt\Inventory\Components;

use Cms\Classes\ComponentBase;
use Bt\Inventory\Models\Purchase;
use Bt\Inventory\Models\Supplier;
use Bt\Inventory\Models\RawMaterialReceiving;
use Bt\Inventory\Models\BagBatch;
use Bt\Inventory\Models\InventoryType; 
use Bt\Inventory\Models\BatchPrefix; 
use Bt\Inventory\Models\PartNames; 
use System\Models\File;
use Validator;
use Redirect;
use Input;

class CmRawMaterialReceiving extends ComponentBase
{
    public $suppliers;

    public function componentDetails()
    {
        return [
            'name'        => 'Raw Material Receiving',
            'description' => 'Component for receiving raw materials.'
        ];
    }
    public function loadAssets()
    {
        $this->addCss('assets/css/raw_styling.css', 'Bt.Inventory'); 
        $this->addJs('assets/js/rawmaterial_receiving.js', 'Bt.Inventory');

    }
    public function onRun()
    {
        $this->loadAssets();
        $this->page['suppliers']= Supplier::all();
        $this->page['inventoryTypes'] = InventoryType::all();
        $this->page['batchPrefixes'] = BatchPrefix::all();
        $this->page['products'] = PartNames::all();
    }


    public function onShowPONumbers()
    {
        $supplierId = post('supplier_id');
        $poNumbers = Purchase::where('supplier_id', $supplierId)->where('is_completed', 0)->whereRaw("TRIM(po_number) <> ''")->orderBy('po_number', 'DESC')->pluck('po_number')->toArray();

        array_unshift($poNumbers, 'Select PO');
        return [
            'poNumbers' => $poNumbers
        ];
    }

    public function onSelectPO()
    {
        $poId = post('po_number');
        $poDetails = Purchase::where('po_number', $poId)->first();
        if (isset($poDetails)) {
        $supplierBatch = $poDetails->supplier_batch;
            return ['poDetails' => $poDetails, 'supplier_batch' => $supplierBatch];
        } else {
            return ['error' => 'Invalid PO number selected.'];
        }
    }

    public function onSaveReceiving()
{
    $weightPerBag = 0;
    $poId = post('po_number');
    $purchase = Purchase::where('po_number', $poId)->first();

    // Check if the purchase order exists
    if ($purchase) {
        $receiving = new RawMaterialReceiving();
        $receiving->date_of_receipt = now();
        $receiving->purchase_id = $purchase->id;
        $receiving->productname = Input::get('part_name_id');
        $receiving->pallet_number = Input::get('bags');
        $receiving->bags = Input::get('bags');
        $receiving->pricekg = $purchase->pricekg;
        if (empty($purchase->supplier_batch)) {
            $batchPrefix = Input::get('batch_prefix_id');
            $newBatchValue = date('Ymd') . $batchPrefix;
            $receiving->supplier_batch = $newBatchValue;
        } else {
            $receiving->supplier_batch = $purchase->supplier_batch;
        }
        if (Input::has('files')) {
            $receiving->files = Input::file('files');
        }
        $receiving->weight = Input::get('weight');
        $validator = Validator::make(Input::all(), $receiving->rules);

        // Save the receiving record
        $receiving->save();

        // Generate batch numbers and their details
        $batchNumbers = []; 
        $batchPrefix = Input::get('batch_prefix_id');
        $bags = Input::get('bags');
        $weight = Input::get('weight');
        $weightPerBag = $weight / $bags;
        $actualWeights = Input::get('actual_weight');

        for ($i = 1; $i <= $bags; $i++) {
            $batchNumber = '';
            // Check if batch is required
            $batchRequired = Input::get('batch_required');
            if ($batchRequired === 'yes') {
                $batchNumber = now()->format('Ymd') . $batchPrefix . '-' . $i;
            } else {
                $batchNumber = $purchase->supplier_batch . $batchPrefix . '-' . $i;
            }

            // Check if the index exists in the $actualWeights array
            $actualWeight = isset($actualWeights[$i - 1]) ? $actualWeights[$i - 1] : 0;

            BagBatch::create([
                'raw_material_receiving_id' => $receiving->id,
                'bags' => $i,
                'weight' => ($weightPerBag) ? $weightPerBag : 0,
                'actual_weight' => $actualWeight, 
                'batch_number' => $batchNumber
            ]);
        }
        return Redirect::back()->with('success', 'Receiving record and batch numbers saved successfully.');
    } else {
        return Redirect::back()->with('error', 'Invalid PO number selected.');
    }
}



}
