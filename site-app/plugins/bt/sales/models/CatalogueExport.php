<?php namespace Bt\Sales\Models;

use Db;
use \Backend\Models\ExportModel;
use \October\Rain\Support\Collection;
use \Bt\Sales\Models\Catalogue;

class CatalogueExport extends ExportModel {

    /**
     * @var array Fillable fields
     */
    // protected $fillable = [];
    
    public function exportData($columns, $sessionKey = null)
    {

        $catalogue = Catalogue::all();
        $catalogue->each(function($catalogue) use ($columns) {
            $catalogue->addVisible($columns);
        });
        return $catalogue->toArray();
    }
}