<?php namespace Bt\SHEQ\Classes;


use Bt\Sheq\Models\EmployeeQuestionnaire;
use Carbon\Carbon;

class SheqSupport
{
    public static function EmpQuestionCounter(){
        $mycounter = EmployeeQuestionnaire::where('end_date', '!=', null)->where('created_at','>', Carbon::now()->subDays(5))->count();
        return $mycounter;
    }
}
