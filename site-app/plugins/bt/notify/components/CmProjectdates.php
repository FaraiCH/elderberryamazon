<?php namespace Bt\Notify\Components;

use Cms\Classes\ComponentBase;
use Bt\Notify\Models\Projectdates;

class CmProjectdates extends ComponentBase
{
    public $data;
    public $dtimer;
    public function componentDetails()
    {
        return [
            'name'        => 'CmProjectdates Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun(){
        $this->dtimer = 0;
        $this->data = Projectdates::where('status',1)->orderby("projectdate")->get();

        foreach ($this->data as $mine)
        {
            if(!empty($mine->projectdate))
            {
                $this->dtimer++;
            }
        }
     }

}
