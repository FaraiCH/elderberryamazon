<?php namespace Bt\SHEQ\Components;

use Cms\Classes\ComponentBase;
use Bt\SHEQ\Models\Audits as AuditsModel;
use Illuminate\Support\Carbon;

class CmAudit extends ComponentBase
{
    public $data;
    public $dtimer;
    public function componentDetails()
    {
        return [
            'name'        => 'CmAudit Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }
     public function onRun(){

        $this->dtimer = 0;
        $this->data = AuditsModel::whereDate('auditdate', '>=', Carbon::now())->orderBy('auditdate')->get();

        foreach ($this->data as $mine)
        {
          if(!empty($mine->auditdate))
          {
              $this->dtimer++;
          }
        }
     }
}
