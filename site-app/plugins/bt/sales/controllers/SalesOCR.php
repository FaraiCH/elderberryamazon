<?php namespace Bt\Sales\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Clegginabox\PDFMerger\PDFMerger;
use Illuminate\Support\Facades\Storage;
use October\Rain\Support\Facades\Flash;
use thiagoalessio\TesseractOCR\TesseractOCR;
use DB;
use Bt\Sales\Models\Srn;
use Illuminate\Support\Facades\Input;
use Org_Heigl\Ghostscript\Ghostscript;
use Illuminate\Support\Facades\Session;

/**
 * Sales O C R Back-end Controller
 */
class SalesOCR extends Controller
{
    /**
     * @var array Behaviors that are implemented by this controller.
     */
    public $implement = [
//        'Backend.Behaviors.FormController',
//        'Backend.Behaviors.ListController'
    ];

//    /**
//     * @var string Configuration file for the `FormController` behavior.
//     */
//    public $formConfig = 'config_form.yaml';
//
//    /**
//     * @var string Configuration file for the `ListController` behavior.
//     */
//    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Bt.Sales', 'sales', 'salesocr');
        $this->addCss("/plugins/bt/sales/assets/css/thumbnail.css");
        $this->addCss("/plugins/bt/sales/assets/css/lightbox.css");
        $this->addCss("/plugins/bt/sales/assets/css/Content/ejthemes/bootstrap-theme/ej.web.all.min.css");
        $this->addCss("/plugins/bt/sales/assets/css/Content/ejthemes/responsive-css/ej.responsive.css");
        $this->addJs("/plugins/bt/sales/assets/js/lightbox-plus-jquery.js");
        $this->addJs("/plugins/bt/sales/assets/js/lightbox-plus-jquery.js");
        $this->addJs("/plugins/bt/sales/assets/js/jsrender.min.js");
        $this->addJs("/plugins/bt/sales/assets/js/Scripts/ej.web.all.min.js");
        $this->addJs("/plugins/bt/sales/assets/js/meh.js");

    }

    /*
* Instructions:
* - Install Tesseract on the system
* - Use Composer to install the Tesseract PHP wrapper by Thiagoalessio
* - Install the latest version of Ghostscript
* - Make sure you can use Ghostscript and the installation is registered on the system (eg. PATH for Windows)
* - Use Composer to install Ghostscript wrapper for PHP by Org_Heigl
* - Find the variable $PATH (btindustrial/vendor/org_heigl/ghostscript/src/Ghostscript.php)
* - and change the path to the location of Ghostscript installed on the system (eg installation directory on Unix/linux would be  /usr/local/bin/gs)
* - Done
*/


    public function index()
    {
        $this->pageTitle = "Document Scans";
    }

    #Get the files and save them to a place for processing
    public function onCheck(){

        $filename = $_FILES['scans']['name'];
        $bossname = basename($filename, ".pdf");
        $directory = 'storage/app/scans/';
        $temp = 'storage/app/temp/';
        Input::file('scans')->move($directory . $bossname .'/', $filename);

        $pdfLocation = getcwd(). '/storage/app/scans/' . $bossname .'/' . $filename;

        Session::put('defLocation', getcwd(). '/storage/app/scans/' . $bossname);
        Session::put('filename', $bossname);
        Session::put('pdfMain', $pdfLocation);
        $pdfOutput = getcwd() . '/storage/app/scans/' . $bossname .'/' . $bossname. '_%03d.jpeg';

        $this->conversionOn($pdfLocation, $pdfOutput);

        $this->onScans();

        return [
            '#scans' => $this->makePartial('p_scans')
        ];
    }

    #Convert the pdf to the desired image/images using Ghostscript(system) and Ghostcript(php wrapper)
    public function conversionOn($pdfLocation, $pdfOutput)
    {
        #Option 1 : loop through PDF, might convert from PDF to PDF modules later using PDFMerger,
        $obj = new Ghostscript();
        $obj->setDevice('jpeg')
            ->setInputFile($pdfLocation)
            ->setOutputFile($pdfOutput)
            // Set the resolution to 96 pixel per inch
            ->setResolution(300)
            // Set Text-antialiasing to the highest level
            ->setTextAntiAliasing(Ghostscript::ANTIALIASING_HIGH)
            // Set the jpeg-quality to 100 (This is device-dependent!)
            ->getDevice()->setQuality(100);
            // convert the input file to an image
        if (true === $obj->render()) {
            Flash::success('Your document was loaded without issue');
        } else {
            Flash::error('Your document failed to save');
        }
    }

    #Check the file for validity
    public function onScans()
    {
        $directory = Session::get('defLocation');
        $dir = new \DirectoryIterator($directory);
        $documentNames = array();
        $allresults = array();
        $count = 1;
        foreach ($dir as $fileinfo) {

            if(!$fileinfo->isDot()) {
                $documentNames[$fileinfo->getFilename()] = $fileinfo->getFilename();
                if(strpos($documentNames[$fileinfo->getFilename()], 'jpeg') !== false)
                {
                    $scan_r = array();
                    $path = 'storage/app/scans/' . Session::get('filename'). '/'. $documentNames[$fileinfo->getFilename()];
                    $tess = new TesseractOCR($path);
                    $myResults = $tess->run();
                    $scan_r['fullresults'] = $myResults;
                    $scan_r['pages'] = $count;
                    $scan_r['thumb'] = "/".$path;
                    $match = $this->isMyMatch($myResults); // PASS RESULTS STRING
                    $scan_r['match'] = is_array($match);
                    $scan_r['match_key'] = null;
                    $scan_r['match_id'] = null;
                    if(is_array($match)){
                        $scan_r['match_key'] = $match[0];
                        $scan_r['match_id'] = $match[1];
                        $scan_r['srnobj'] = Srn::find($match[1]);
                    }
                    $allresults[] = $scan_r;
                    $count++;
                }
            }
        }
        $this->vars['result'] = $allresults;
    }

    public function isMyMatch($str_results)
    {
        //Use preg_match() to match the patterns in a resulted string
        //Note: strpos() can also be applied to avoid patterns
        preg_match('/(#BT-SRN|#BT-CCN|#BT-DN)(\d{4})/i',$str_results, $matches, PREG_OFFSET_CAPTURE);
        if(!empty($matches)){
            return array($matches[1][0],$matches[2][0]);
        }
        #fix
        preg_match('/(#BT-SRN|#BT-CCN|#BT-DN).(\d{3})/i', $str_results
        , $matches, PREG_OFFSET_CAPTURE);
        if(!empty($matches)){
            return array($matches[1][0],$matches[2][0]);
        }
        return null;
    }

    #Function Must Save and Store The Required Documents Into Their Places
    public function onSaveThe()
    {

        $object = Input::get('scan_check');
        $num = Input::get('scan_num');
        $name = Input::get('scan_name');

        if(!empty(isset($object))) {
            foreach ($object as $i => $pick) {
                for ($j = 1; $j <= count($name); $j++) {
                    if ($pick == $j) {
                        $truename = substr($name[$j - 1], -3);
                        if ($truename == 'SRN' || $truename == 'CCN' || $truename == 'DN' || $truename == '-DN') {
                            $scan_r['srnobj'] = Srn::find($num[$j - 1]);
                            $change = ltrim($num[$j - 1], "0");
                            Storage::disk('local')->makeDirectory('tempscans/' . $change);
                            $pdf = new PDFMerger();
                            $fileend2 = base_path() . '/' . 'storage/app/tempscans/' . $change . '/Scan-' . $truename . $change . '.pdf';
                            $file = Session::get('pdfMain');
                            $pdf->addPDF($file, $pick, 'P');
                            $pdf->merge('file', $fileend2, 'P');
                            $this->saveKey($scan_r['srnobj']);

                        }
                    }
                }
            }
        }
        else {
                    Flash::error("You did not pick anything to save");
        }

    }


    #SaveThe Function is too long. Continue for SaveThe in saveKey Function
    public function saveKey($Key)
    {
        //Get path to the merged or single documents using the ID
        $directory = base_path() . '/' . 'storage/app/tempscans/' . $Key->id . '/';

        $dir = new \DirectoryIterator($directory);
        $documentNames = array();
        $count = 0; //count the pages
        foreach ($dir as $fileinfo) {
            if (!$fileinfo->isDot()) {
                //Get File names and avoid directory dots (eg (.)(..)(...))
                $documentNames[$count] = $fileinfo->getFilename();
                if (strpos($documentNames[$count], 'pdf') !== false) {
                    if (strpos($documentNames[$count], 'SRN'))
                    {
                        $Key->files_srn = $directory . $documentNames[$count];

                    }
                    elseif (strpos($documentNames[$count], 'CCN'))
                    {
                        $Key->files_collection = $directory . $documentNames[$count];

                    }
                    elseif (strpos($documentNames[$count], 'DN'))
                    {
                        $Key->files_delivery = $directory . $documentNames[$count];

                    }
                    $Key->save();
                    $count++;
                }
            }
        }
        Flash::success('Documents have been processed and saved.');

    }
}





