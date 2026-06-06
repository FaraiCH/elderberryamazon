<?php namespace Bt\Sheq\Models;

use Model;

/**
 * Question Model
 */
class Question extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'tbl_question';

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
    public $rules = [
        'name' => 'required',
        'type' => 'required',
        'label' => 'required',
    ];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [];

    /**
     * @var array jsonable attribute names that are json encoded and decoded from the database
     */
        protected $jsonable = [
        'field_values',
        'validation',
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

    /**
   * Generate form fields types list
   *  @return array
   */
      public function getTypeOptions($value, $formData)
      {

        $fieldTypes = $this->getFieldTypes();

        $types = [];

        if(!$fieldTypes) {
          return [];
        }

        foreach ($fieldTypes as $key => $value) {
          $types[$key] = 'janvince.smallcontactform::lang.settings.form_field_types.'.$key;
        }
        // trace_log( $types);
        return $types;

      }

       /**
   * HTML field types mapping array
   * @return array
   */
  public static function getFieldTypes($type = false) {

    $types = [

      'header' => [
        'html_open' => 'input',
        'label' => true,
        'wrapper_class' => 'form-group',
        'field_class' => 'form-control',
        'use_name_attribute' => true,
        'attributes' => [
          'type' => 'text',
        ],
        'html_close' => null,
      ],

      'text' => [
        'html_open' => 'input',
        'label' => true,
        'wrapper_class' => 'form-group',
        'field_class' => 'form-control',
        'use_name_attribute' => true,
        'attributes' => [
          'type' => 'text',
        ],
        'html_close' => null,
      ],

      'email' => [
        'html_open' => 'input',
        'label' => true,
        'wrapper_class' => 'form-group',
        'field_class' => 'form-control',
        'use_name_attribute' => true,
        'attributes' => [
          'type' => 'email',
        ],
        'html_close' => null,
      ],

      'textarea' => [
        'html_open' => 'textarea',
        'label' => true,
        'wrapper_class' => 'form-group',
        'field_class' => 'form-control',
        'use_name_attribute' => true,
        'attributes' => [
          'rows' => 5,
        ],
        'html_close' => 'textarea',
      ],

      'checkbox' => [
        'html_open' => 'input',
        'label' => false,
        'wrapper_class' => null,
        'field_class' => null,
        'inner_label' => true,
        'use_name_attribute' => true,
        'attributes' => [
          'type' => 'checkbox',
        ],
        'html_close' => null,
      ],

      'radio' => [
        'html_open' => 'input',
        'label' => false,
        'wrapper_class' => null,
        'field_class' => null,
        'inner_label' => true,
        'use_name_attribute' => true,
        'attributes' => [
          'type' => 'checkbox',
        ],
        'html_close' => null,
      ],

      'dropdown' => [
        'html_open' => 'select',
        'label' => true,
        'wrapper_class' => 'form-group',
        'field_class' => 'form-control',
        'inner_label' => false,
        'use_name_attribute' => true,
        'attributes' => [
        ],
        'html_close' => 'select',
      ],

      'file' => [
        'html_open' => 'input',
        'label' => true,
        'wrapper_class' => 'form-group',
        'field_class' => 'form-control',
        'inner_label' => false,
        'use_name_attribute' => true,
        'attributes' => [
          'type' => 'file',
        ],
        'html_close' => null,
      ],

      'table' => [
        'html_open' => "div",
        'label' => true,
        'wrapper_class' => null,
        'field_class' => null,
        'inner_label' => false,
        'use_name_attribute' => false,
        'attributes' => [
        ],
        'html_close' => "div",
      ],


      'custom_code' => [
        'html_open' => "div",
        'label' => true,
        'wrapper_class' => null,
        'field_class' => null,
        'inner_label' => false,
        'use_name_attribute' => false,
        'attributes' => [
        ],
        'html_close' => "div",
      ],

      'custom_content' => [
        'html_open' => "div",
        'label' => true,
        'wrapper_class' => null,
        'field_class' => null,
        'inner_label' => false,
        'use_name_attribute' => false,
        'attributes' => [
        ],
        'html_close' => "div",
      ],

    ];

    if($type){
      if(!empty($types[$type])){
        return $types[$type];
      }
    }

    return $types;

  }

   /**
   * Generate form fields types list
   *  @return array
   */
  public function getValidationTypeOptions($value, $formData)
  {

      return [
      'required' => 'janvince.smallcontactform::lang.settings.form_field_validation.required',
      'email' => 'janvince.smallcontactform::lang.settings.form_field_validation.email',
      'numeric' => 'janvince.smallcontactform::lang.settings.form_field_validation.numeric',
      'custom' => 'janvince.smallcontactform::lang.settings.form_field_validation.custom',
    ];
  }

}
