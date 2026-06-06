<?php namespace Plugin\Updates;

use Seeder;
use Bt\Production\Models\ControlSheet;
use Bt\Production\Models\JobCardBatch;
use Bt\Production\Models\Pipestickeritem;

class PipestickeritemSeeder extends Seeder
{
    public function run()
    {
        $pipestickeritems = Pipestickeritem::all();

        foreach ($pipestickeritems as $pipestickeritem) {
            $controlsheet_id = $pipestickeritem->controlsheet_id;

            if ($controlsheet_id) {
                $controlsheet = ControlSheet::find($controlsheet_id);

                if ($controlsheet && $controlsheet->jobcard && $controlsheet->jobcard->pipe) {
                    $jobcard_id = $controlsheet->jobcard->id;
                    $batches = JobCardBatch::where('jobcard_id', $jobcard_id)->pluck('id')->toArray();

                    if (!empty($batches)) {
                        $batch_id = reset($batches);
                        $pipestickeritem->batch_id = $batch_id;
                        $pipestickeritem->save();
                    }
                }
            }
        }
    }
}
