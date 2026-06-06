<?php namespace Bt\Maintenance\Updates;

use Lang;
use Seeder;
use Bt\Sales\Models\Diameter as Diameter;
use Bt\Sales\Models\Product as Product;
use Flynsarmy\CsvSeeder\CsvSeeder;

/**
 * Class SeederDefaultStatus
 * @package Lovata\OrdersShopaholic\Updates
 */
class SeederToolsTE extends Seeder
{
    public function __construct()
    {
        $this->table = 'your_table';
        $this->sFilePath = 'bt/sales/updates/csv/production_updates.csv';
    }

    public function run()
    {
        trace_log(base_path().'csv/production_updates.csv');
        $dobj = Diameter::all();
        $convertdiameter = array();
        foreach ($dobj as $key => $value) {
        $convertdiameter{$value->name} = $value->id;
        }

        // print dd($convertdiameter);
       
        $filename = plugins_path($this->sFilePath);
        $file = fopen($filename, "r");
        //Skip first line
        fgetcsv($file);
        while ( ($data = fgetcsv($file, 200, ",")) !==FALSE ) {
        // print $data[0]." - ".$data[1]."\n";
        if($data[0] > 0 && $data[1] > 0){
        $obj = Product::where('diameter_id',"=",$convertdiameter{$data[1]})->where('pn_ratings_id',"=",$data[0])->first();
              
        if(!empty($obj)){
        print "found:".$data[10]." > ".$obj->value." - ".$obj->production_value."\n";
        // $obj->od_min = $data[2];
        // $obj->od_max = $data[3];
        // $obj->ovality_max = $data[4];
        // $obj->coil = $data[5];
        // $obj->wt_min = $data[6];
        // $obj->wt_ave = $data[7];
        // $obj->wt_max = $data[8];
        // $obj->pipe_id = $data[9];
        $obj->production_value = $data[10] ;
        //print dd($obj);
        $obj->save();
        }
        }
            
        }

       
    }
}

