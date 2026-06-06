<?php namespace Bt\Finance\Models;

use Db;
use \Backend\Models\ExportModel;
use \October\Rain\Support\Collection;
use \Bt\Finance\Models\Requisition;

class RequisitionExport extends ExportModel
{

    /**
     * @var array Fillable fields
     */
    // protected $fillable = [];

    public function exportData($columns, $sessionKey = null)
    {
        if (isset($_SESSION['req'])) {
            $finance_status = $_SESSION['req'];
        } else {
            $finance_status = 'all';
        }
        $records = Requisition::where('cancelled', '=', 0)->where('archived', '=', 0)
        ->with([

            'linemanager'  => function ($query) {
                $query->addSelect(['id','name','surname']);
            },

            'financeapprove'  => function ($query) {
                $query->addSelect(['requesition_id','status_id']);
            },
            'managerapprove'  => function ($query) {
                $query->addSelect(['requesition_id','status_id']);
            },
            'lineapprove'  => function ($query) {
                $query->addSelect(['requesition_id','status_id']);
            },

            'updatedby' => function ($query) {
                $query->addSelect(['id', 'first_name', 'last_name']);
            },
            'createdby' => function ($query) {
                $query->addSelect(['id', 'first_name', 'last_name']);
            },
            'requestby' => function ($query) {
                $query->addSelect(['id', 'first_name', 'last_name']);
            },
            'project' => function ($query) {
                $query->addSelect(['id','name']);
            }
        ]);
        if (!isset($finance_status) || $finance_status == 'all') {
            $records = $records->get();
        } else {
            if ($finance_status == 'rejected') {
                $records = $records->whereHas('financeapprove', function ($query) {
                    $query->where('status_id', '!=', 1);
                })->get();
            }
            if ($finance_status == 'paid') {
                $records = $records->whereHas('financeapprove', function ($query) {
                    $query->where('status_id', 1);
                })->get();
            }
            if ($finance_status == 'pending') {
                $records = $records->doesnthave('financeapprove')->get();
            }
        }

        $records->each(function ($record) use ($columns) {
            $record->addVisible($columns);
        });


        $collection = collect($records->toArray());
        $data = $collection->map(function ($item) {
            if (is_array($item)) {
                foreach ($item as $key => $value) {
                    if ($key == "lineapprove" || $key == "managerapprove" || $key == "financeapprove") {
                        $item[$key] = "Pending";
                        if (is_array($value) && isset($value["status_id"])) {
                            if ($key == "financeapprove") {
                                $item[$key] = (($value["status_id"] == 1) ? "Paid":"Rejected");
                            } else {
                                $item[$key] = (($value["status_id"] == 1) ? "Approved":"Rejected");
                            }
                        }
                    }
                    if (is_array($value) && isset($value["name"])) {
                        $item[$key] = $value["name"];
                        if (is_array($value) && isset($value["surname"])) {
                            $item[$key] = $value["name"]." ".$value["surname"];
                        }
                    }

                    if (is_array($value) && isset($value["first_name"])) {
                        $item[$key] = $value["first_name"]." ".$value["last_name"];
                    }
                    if ($key == "archived") {
                        $item[$key] = $value == 1? "Yes":"No";
                    }
                    if ($key == "cancelled") {
                        $item[$key] = $value == 1? "Yes":"No";
                    }
                }
            }
            return $item;
        });

        return $data->toArray();
    }
}
