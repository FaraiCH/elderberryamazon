<?php namespace Bt\Sales\Components;

use Bt\Sales\Models\Srn;
use Bt\Sales\Models\SrnItem;
use Carbon\Carbon;
use Cms\Classes\ComponentBase;

class Srnnotify extends ComponentBase
{
    public $data;
    public $stats;
    public function componentDetails()
    {
        return [
            'name'        => 'srnnotify Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun(){

        $this->data = Srn::orderBy('id', 'desc')->whereDate('created_at', Carbon::now()->subDays(7))->get();
        $this->stats = array();
        $count = 0;

        foreach($this->data as $inh)
        {
            if(!empty(isset($inh->images_delivery)))
            {
                foreach($inh->images_delivery as $h)
                {
                        if($count >= 12)
                        {
                            return null;
                        }
                        else
                        {
                            $subsetSrnnotify = null;
                            if (strlen($inh->client->company_name) >= 16)
                            {
                                $subset = substr($inh->client->company_name, 0, 24). " ... ";
                                $this->stats[] = array('name' =>  $subset , 'pic' => $h->getThumb('140','140', 'crop'), 'date' => $inh->schedule_date);
                            }
                            else
                            {
                                $this->stats[] = array('name' =>  $inh->client->company_name , 'pic' => $h->getThumb('140', '140', 'crop'), 'date' => $inh->schedule_date);
                            }
                            $count++;
                        }
                }
            }


        }


    }
}
