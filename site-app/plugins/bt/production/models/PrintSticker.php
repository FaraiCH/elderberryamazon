<?php namespace Bt\Production\Models;

use Model;
use BackendAuth;
use Bt\Production\Models\Pipestickeritem;

/**
 * PrintSticker Model
 */
class PrintSticker extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_production_print_stickers';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [
        'pipestickeritem' => ['Bt\Production\Models\Pipestickeritem','key'=>'sticker_id']
    ];
    public $belongsTo = [
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id']
    ];
    
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function beforeCreate()
    {
        $user = BackendAuth::getUser();
        if (!$user) return;
        $this->created_by = $user->id;
    }
    public function beforeUpdate()
    {
        $user = BackendAuth::getUser();
        if (!$user) return;
        $this->updated_by = $user->id;
    }

    public function afterCreate()
    {
        $user = BackendAuth::getUser();
        if (!$user) return;
        $this->created_by = $user->id;

        for ($i=1; $i <= $this->stickercount; $i++) {
            $new = new Pipestickeritem();
            $new->counter = $i;
            $new->sticker_id = $this->id;
            $new->save();
        }
    }
}
