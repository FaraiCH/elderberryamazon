<?php namespace Bt\Logistics\Classes;

use Bt\Sales\Models\DeliveryPlan;
use Bt\Sales\Models\Quoteitems;
use Bt\Sales\Models\Srn;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;

class DailyLogistics implements FromArray, ShouldAutoSize
{
    public function array(): array
    {
        $srn = Srn::where('schedule_date', '>', '2023-03-01')->with(['pickslip', 'quote'])->get();
        return [$this->LoadDetails($srn)];
    }

    public function LoadDetails($Srns)
    {
        $dailyLoadObj = [];

        //Insert the Header for the export
        $dailyLoadObj[0] = $this->header();

        foreach ($Srns as $srn){
            $item_ordered = 0;
            $full_item_delivery = 0;
            foreach ($srn->items as $item){

//                 The problem with this item is that it can be taken from anywhere, not necessarily the quote
//                 We count any item put into an srn matching the description of a quote item as a correct srn item entry
                if(isset($item->pipe->quoteitems->product_id))
                {
                    $item_ordered = Quoteitems::where('quote_id', $srn->quote_id)->where('product_id', $item->pipe->quoteitems->product_id)->where('unitlength', $item->pipe->quoteitems->unitlength);


                    $full_item_delivery = $item->pipe->quoteitems->getSameItemDelivered($srn->quote_id,$item->pipe->quoteitems->product_id, $item->pipe->quoteitems->unitlength, '', '')->sum('units');
                    $actual_dispatch = $item->pipe->quoteitems->getSameItemDelivered($srn->quote_id,$item->pipe->quoteitems->product_id, $item->pipe->quoteitems->unitlength, '', '')->count();
                }
                if($full_item_delivery == 0){
                    $status = 0;
                }else{
                    if($item_ordered->sum('units') > 0){
                        $status = ($full_item_delivery/$item_ordered->sum('units')) * 100;
                        if(isset($item->pipe->quoteitems->units)){
                            if( ($item->pipe->quoteitems->units - $full_item_delivery) <= 0){
                                $status = 100;
                            }
                        }
                    }else{
                        $status = 0;
                    }
                }
                if(isset($item->pipe->quoteitems->unitlength)){
                    $unitlength = $item->pipe->quoteitems->unitlength;
                }else
                {
                    $unitlength = 0;
                }

                if(isset($item->pipe->quoteitems->product->production_value)){
                    $productionValue =  $item->pipe->quoteitems->product->production_value;
                }else{
                    $productionValue = 0;
                }

                $dailyLoadObj[$item->id]['quote_id'] = $srn->quote_id;
                $dailyLoadObj[$item->id]['srn_id'] = $srn->id;
                $dailyLoadObj[$item->id]['schedule_date'] = $srn->schedule_date;
                $dailyLoadObj[$item->id]['client_name'] = $srn->quote->company_name;
                $dailyLoadObj[$item->id]['pipe_size'] = $item->pipe->quoteitems->product->Diameter->name ?? 0;
                $dailyLoadObj[$item->id]['pipe_length'] = $item->pipe->quoteitems->unitlength ?? 0;
                $dailyLoadObj[$item->id]['pipe_pn'] = $item->pipe->quoteitems->product->PNRating->name ?? 0;
                $dailyLoadObj[$item->id]['units_ordered'] =  $item_ordered->sum('units') ?? 0;
                $dailyLoadObj[$item->id]['status'] = number_format($status, 2) . "%";
                $dailyLoadObj[$item->id]['unit_weight'] = $item_ordered->sum('weight') ?? 0;
                $dailyLoadObj[$item->id]['total_ordered_weight'] = $item_ordered->sum('totalweight') ?? 0;
                $dailyLoadObj[$item->id]['actual_dispatch'] = $actual_dispatch;
                $dailyLoadObj[$item->id]['units_delivered_load'] = $item->units;
                $dailyLoadObj[$item->id]['item_delivered_to_date'] = $full_item_delivery;
                $dailyLoadObj[$item->id]['weight_delivered_to_date'] = $item->pipe->quoteitems->weight ?? 0 * $full_item_delivery;
                $dailyLoadObj[$item->id]['delivery_type'] = $srn->type->name;
                $dailyLoadObj[$item->id]['transporter_name'] = $srn->logistics_company;
//                $dailyLoadObj[$item->id]['truck_size'] = $srn->quote->dispatch->vehicle;
                $dailyLoadObj[$item->id]['truck_size'] = '';
                $dailyLoadObj[$item->id]['truck_registration'] = $srn->pickslip->plate_number ?? '';
                if(isset($item->pipe->quoteitems->product->value))
                {
                    $dailyLoadObj[$item->id]['srn_weight'] =  $item->units * $unitlength * $item->pipe->quoteitems->product->value ?? 0;
                }
                else
                {
                    $dailyLoadObj[$item->id]['srn_weight'] =  0;
                }

                $dailyLoadObj[$item->id]['estimated_weight_production'] = $unitlength  * $productionValue;
//                $dailyLoadObj[$item->id]['srn_weight_for_dispatch'] = $item->units * $unitlength *  $item->pipe->quoteitems->product->value;
                $dailyLoadObj[$item->id]['production_weight'] = $item->units * $unitlength *  $productionValue;
//                $dailyLoadObj[$item->id]['production_weight_dispatch'] = $item->units * $unitlength *  $productionValue;
                $dailyLoadObj[$item->id]['weight_bridge'] = "Not Developed";
                $dailyLoadObj[$item->id]['load_diff_srn'] = "Needs Weight Bridge";
                $dailyLoadObj[$item->id]['load_diff_pro'] = "Needs Weight Bridge";
                $dailyLoadObj[$item->id]['vehicle_arrival'] = $srn->pickslip->vehicle_arrival ?? 0;
                $dailyLoadObj[$item->id]['vehicle_depature'] = $srn->pickslip->vehicle_depature ?? 0;
                $dailyLoadObj[$item->id]['comments'] = $srn->notes_delivery;

            }
        }
        return $dailyLoadObj;
    }

    public function header() : array
    {
        // Create the export header
        return [
                'quote_id' => "Quote NO",
                'srn_id' => 'SRN No',
                'schedule_date' => 'Dispatch Date (SRN)',
                'client_name' => 'Client Name',
                'pipe_size' => "Pipe Size",
                'pipe_length' => "Pipe Length",
                'pipe_pn' => "Pn Rating",
                'units_ordered' => "Units Ordered",
                'status' => "Dispatch Progress",
                'unit_weight' => "Units Weight",
                'total_ordered_weight' => "Total Ordered Weights",
                'actual_dispatch' => "Actual Dispatch",
                'units_delivered_load' => "Units Delivered",
                'item_delivered_to_date' => "Units Delivered To Date",
                'weight_delivered_to_date' => "Weight Delivered To Date",
                'delivery_type' => "Delivery Type",
                'transporter_name' => "Transporter Name",
                'truck_Size' => "Truck Size",
                'truck_registration' => "Truck Registration",
                'srn_weight' => "SRN Weight",
                'estimated_weight_production' => "Estimated Weight Production",
//                'srn_weight_for_dispatch' => "Srn Weight for Dispatch",
                'production_weight' => "Production Weight",
//                'production_weight_dispatch' => "Production Weight Dispatch",
                'weight_bridge' => "Weight Bridge",
                'load_diff_srn' => "Load Difference SRN",
                'load_diff_pro' => "Load Difference Production",
                'vehicle_arrival' => "Vehicle Arrival Time",
                'vehicle_depature' => "Vehicle Depature Time",
                'comments' => "Comment",
        ];
    }
}
