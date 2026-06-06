<?php

namespace Bt\PLCommon\Classes;
use DB;
class RunStoreProcedures {


   
    public function __construct() {
       
       
    }

    public static function runSetQuoteClientID(){
    	
        DB::select('CALL procedureSetQuoteClientID()');
        
    } 

    public static function runSetStickerSrnID(){
        DB::select('CALL procedureSetStickerSrnID()');
        
    }

     public static function runprocedurePrepareElecricityReport(){
        DB::select('CALL procedurePrepareElecricityReport()');
        
    }


   
}

?>
