<?php

namespace Bt\Sales\Models;

use Model;

/**
 * QuoteApprovalIntro Model
 */
class QuoteApprovalIntro extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'bt_sales_quote_approval_intro';

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
    protected $jsonable = [];

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
    public $belongsTo = [
        'quote' => ['Bt\Sales\Models\Newquote', 'key' => 'quote_id']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function beforeCreate()
    {
        $appUrl = env('APP_URL');

        $quoteId = $this->quote->id;
        $quoteKeyPass = $this->quote->key_pass;
        $clientName = $this->quote->billing_name;
        $salesPersonName =  $this->quote->user->name . ' ' . $this->quote->user->surname;
        $quoteClosingDate = $this->quote->closing_date;

        $clientQuoteApprovalLink = "$appUrl/quoteapproval/$quoteKeyPass/$quoteId";

        $this->subject = "BT Quote Approval - Ref-#$quoteId";

        $this->body = trim('
                        <p>Dear <strong>' . $clientName . '</strong></p>
                        <p><strong>' . $salesPersonName . '</strong> has finished the quotation that needs your approval. The details are provided below</p>
                        <p><strong>Quote Ref:</strong> #' . $quoteId . '</p>
                        <p><strong>Expiry Date:</strong> ' . $quoteClosingDate . '</p>
                        <p><strong>Links:</strong></p>
                        <p><a href="' . $clientQuoteApprovalLink . '" target="_blank">Client quote approval link</a></p>
                        <p>Thank you for your attention to this matter.</p>
                        <p><strong>Best regards</strong></p>
                        <p>BT Team</p>
                    ');

    }

    public function beforeDelete()
    {
        $this->subject = null;
        $this->body = null;
    }

    public function afterDelete()
    {
        $this->quote->quote_approval_activity_log()->delete();

    }
}
