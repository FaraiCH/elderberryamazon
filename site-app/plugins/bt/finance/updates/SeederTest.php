<?php

namespace Bt\Finance\Updates;
use October\Rain\Database\Updates\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Lang;;
use Bt\Sales\Models\PettyCashApprove;

class SeederTest extends Seeder
{
    public function run()
    {
        $startPettyCashId = 1662;
        $endPettyCashId = 1906;

        for ($pettyCashId = $startPettyCashId; $pettyCashId <= $endPettyCashId; $pettyCashId++) {
            // Check if the pettycash_id is null
            if (is_null($pettyCashId)) {
                continue; // Skip this iteration if pettycash_id is not null
            }

            DB::table('bt_finance_petty_cash_approves')->insert([
                'pettycash_id' => $pettyCashId,
                'status_id' => 1,
                'created_by' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
