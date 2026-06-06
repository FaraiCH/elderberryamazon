<?php namespace Bt\Sheq\Models;

use Model;
use Bt\Sheq\Models\Question;
use Bt\PLCommon\Classes\DynamicForm;
/**
 * QuestionElement Model
 */
class QuestionElement extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'tbl_question_element';

    /**
     * @var array guarded attributes aren't mass assignable
     */
    protected $guarded = ['*'];

    /**
     * @var array fillable attributes are mass assignable
     */
    protected $fillable = [];

    /**
     * @var array rules for validation
     */
    public $rules = [];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [];

    /**
     * @var array jsonable attribute names that are json encoded and decoded from the database
     */
    protected $jsonable = [
        'questions'
    ];

    /**
     * @var array appends attributes to the API representation of the model (ex. toArray())
     */
    protected $appends = [];

    /**
     * @var array hidden attributes removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [];

    /**
     * @var array dates attributes that should be mutated to dates
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * @var array hasOne and other relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function getQuestionOptions(){
        return Question::pluck('name', 'id');
    }

    public function getFieldHtmlCode(){
        $obj = new DynamicForm($this->questions,null,$this->label);
        return $obj->getRaw();
    }

    public function getFieldHtmlCodeAnswer($answer){
        $obj = new DynamicForm($this->questions,$answer,$this->label);
        return $obj->getRaw();
    }




}
