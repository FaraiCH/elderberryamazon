<?php namespace Bt\Production\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Bt\Production\Models\Pipestickeritem;
use Bt\Production\Models\PrintSticker as StickerModel;
use Bt\Sales\Models\Quoteitems;

/**
 * Print Sticker Back-end Controller
 */
class PrintSticker extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController',
        'Backend.Behaviors.ImportExportController',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';
    public $importExportConfig = 'config_import_export.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.Production', 'production', 'printsticker');
    }

    public function stickerlist(){
        $this->pageTitle = 'Scanned Items';
        BackendMenu::setContext('Bt.Production', 'production', 'scanlist');
        $this->addCss("/plugins/bt/reporting/assets/css/bootstrap.min.css", "1.0.0");
        $this->addCss("/plugins/bt/reporting/assets/css/backlaout.css", "1.0.0");
        $this->addCss("/plugins/bt/reporting/assets/css/dataTables.bootstrap5.min.css", "1.0.0");
        $this->addCss("/plugins/bt/reporting/assets/css/responsive.bootstrap5.min.css", "1.0.0");
        $this->addJs("https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js", "1.0.0");
        $this->addJs("https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap5.min.js", "1.0.0");
        $this->addJs("/plugins/bt/reporting/assets/js/backlaout.js", "1.0.0");

        $this->addJs("https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js", "1.0.0");
        $this->addJs("//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js", "1.0.0");
        $this->addJs("//cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/pdfmake.min.js", "1.0.0");
        $this->addJs("//cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/vfs_fonts.js", "1.0.0");
        $this->addJs("//cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js", "1.0.0");

        $stickerObj = [];

        $pipestcikerConditions = Pipestickeritem::where('controlsheet_id', '>', 0)->where('qcstatus_id', "!=", 2)->where('dispatch_date', '>=', '2024-06-01')->where('pickslip_id', '>', 0);
        foreach ($pipestcikerConditions->get() as $pipsticker)
        {
            $quote_item = $pipsticker->quote_item_id;
            if(isset($pipsticker->quote_item->quote_id))
            {
                $quote = $pipsticker->quote_item->quote_id;
                $diameter = $pipsticker->quote_item->product->Diameter->name . 'mm ';
                $pnrating =  $pipsticker->quote_item->product->PNRating->name;
                $unitlength = $pipsticker->quote_item->unitlength . 'm';
                $ordered_units = $pipsticker->quote_item->units;
            }
            else
            {
                $ordered_units = 0;
                $quote = '';
                $diameter = '';
                $pnrating =  '';
                $unitlength = '';
            }


            $controlsheet_id =  $pipsticker->controlsheets->jobcard_id . "-" .  $pipsticker->controlsheets->batch_id;
            $batch_id = $pipsticker->batch_id;
            $stickerObj[$quote_item]['quotes'] = $quote;
            $stickerObj[$quote_item]['batch'] = $controlsheet_id;
            $stickerObj[$quote_item]['diameter'] = $diameter;
            $stickerObj[$quote_item]['pn'] =  $pnrating;
            $stickerObj[$quote_item]['length'] =  $unitlength;
            $stickerObj[$quote_item]['ordered'] = $ordered_units;
            $stickerObj[$quote_item]['approved'] = Pipestickeritem::where('batch_id', $batch_id)->where('qcstatus_id', 1)->count();
            $stickerObj[$quote_item]['delivered'] = Pipestickeritem::where('batch_id', $batch_id)->where('dispatch_date', '!=', null)->count();
        }

        $this->vars['stickerObj'] = $stickerObj;
    }

    public function scanned()
    {
        $this->pageTitle = 'Scanned Pipes Today';

        $this->addCss("//cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css", "1.0.0");
        $this->addCss("https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.css", "1.0.0");
        $this->addJs("//cdn.datatables.net/2.0.8/js/dataTables.min.js", "1.0.0");
        $this->addJs("https://cdn.datatables.net/2.0.8/js/dataTables.js", "1.0.0");
        $this->addJs("https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js", "1.0.0");
        $this->addJs("https://cdn.datatables.net/buttons/3.0.2/js/buttons.dataTables.js", "1.0.0");
        $this->addJs("https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js", "1.0.0");
        $this->addJs("https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js", "1.0.0");
        $this->addJs("https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js", "1.0.0");
        $this->addJs("https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js", "1.0.0");
        $this->addJs("https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js", "1.0.0");

        $this->vars['stickerObj'] = Pipestickeritem::where('sticker_scanned_date','>=', "2024-07-22 00:00:00")->where('is_active', 1)->get();
    }

    public function stock()
    {
        $this->pageTitle = 'Production and Sales';

        $this->addCss("//cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css", "1.0.0");
        $this->addCss("https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.css", "1.0.0");
        $this->addJs("//cdn.datatables.net/2.0.8/js/dataTables.min.js", "1.0.0");
        $this->addJs("https://cdn.datatables.net/2.0.8/js/dataTables.js", "1.0.0");
        $this->addJs("https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js", "1.0.0");
        $this->addJs("https://cdn.datatables.net/buttons/3.0.2/js/buttons.dataTables.js", "1.0.0");
        $this->addJs("https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js", "1.0.0");
        $this->addJs("https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js", "1.0.0");
        $this->addJs("https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js", "1.0.0");
        $this->addJs("https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js", "1.0.0");
        $this->addJs("https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js", "1.0.0");

        $this->vars['stickerObj'] = Pipestickeritem::where('sticker_scanned_date','>=', "2024-07-22 06:00:00")->where('is_active', 1)->get();
    }
}
