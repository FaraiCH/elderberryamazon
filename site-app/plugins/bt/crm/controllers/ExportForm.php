<?php namespace Bt\CRM\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Export Form Back-end Controller
 */
class ExportForm extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.CRM', 'crm', 'exportform');
    }
    public function formExtendFields($form)
    {
       
                $form->addFields([
                'declaration' => [
                    'label'   => 'Declarations',
                    'type' => 'richeditor',
                    'toolbarButtons' => 'bold|italic|underline',
                    'size' => 'large',
                    'default' => '<p><b><u>RE: DECLARATION BY PRODUCER</u></b></p><p>For the purpose of claiming preferential treatment under the provisions of Rule 2 of the Annex on the Rules of Origin for the products to be between the Member States of the South African Development Community:</p><p>I HEREBY DECLARE:<ol><li>That the goods listed here in quantities as specified below have been produced by this company / enterprise / workshop supplier:</li><li>The goods listed below are manufactured in RSA.</li><li>The evidence is available that the goods listed below comply with the origin criteria as specified by the annexure on the rules of origin for a South African Development Company.</li></ol></p>'
                ],
            ]);
        

          
    }
}
