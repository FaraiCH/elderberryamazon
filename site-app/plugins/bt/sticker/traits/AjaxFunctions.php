<?php

namespace Bt\Sticker\Traits;

use Bt\Production\Models\ControlSheet;

trait AjaxFunctions
{
    function AjaxSearch($model, $inputValue) : array
    {
        //Create Search Data for the Control Sheet Search Box
        $results = [];
        $objs = $model::where('id','LIKE', '%'. $inputValue . '%')->get()->toArray();

        foreach ($objs as $obj)
        {
            if(!empty($obj))
            {
                $results[] = [
                    'id' =>  $obj['id'],
                    'text' => "CS# " . $obj['id']  . ' #JB ' . $obj['jobcard_id'] . '-'. $obj['batch_id']
                ];
            }
        }
        return ['results' => $results];
    }
}
