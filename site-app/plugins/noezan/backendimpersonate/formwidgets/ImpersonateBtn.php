<?php namespace Noezan\BackendImpersonate\FormWidgets;

use Backend\Classes\FormWidgetBase;
use Backend\Models\User as BackendUserModel;
use Backend\Controllers\Users as BackendUsersController;
use BackendAuth;
use Redirect;
use Flash;
/**
 * ImpersonateBtn Form Widget
 */
class ImpersonateBtn extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'impersonate_btn';

    /**
     * @inheritDoc
     */
    public function init()
    {
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('impersonatebtn');
    }

    /**
     * prepareVars for view data
     */
    public function prepareVars()
    {
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;
    }

    /**
     * @inheritDoc
     */
    public function loadAssets()
    {
        $this->addCss('css/impersonatebtn.css', 'Noezan.BackendImpersonate');
        $this->addJs('js/impersonatebtn.js', 'Noezan.BackendImpersonate');
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        return $value;
    }
    public function onTestImperonate($id){
 
        $model = BackendUserModel::find($id);
        BackendAuth::impersonate($model);
        Flash::success("You are now impersonating ".$model->first_name." ".$model->last_name);
        return \Backend::redirect('backend/users/myaccount');
    }
}
