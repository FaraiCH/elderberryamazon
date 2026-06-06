<?php namespace Bt\Sales\Components;

use Cms\Classes\ComponentBase;
use Bt\Sales\Models\Newquote as NewQuoteModel;
use Bt\Sales\Models\QuoteAccept as QuoteAcceptModel;
use Input;
use Validator;
use ValidationException;
use Mail;
use Request;

/**
 * QuoteApproval Component
 */
class QuoteApproval extends ComponentBase
{
    public bool $quoteValid = false;
    public bool $quoteApprovalCompleted = false;
    public string $quoteApprovalFirstName;
    public string $quoteApprovalLastName;
    public string $quoteApprovalDate;
    public string $quoteId;
    public string $quoteKeyPass;

    public function componentDetails()
    {
        return [
            'name' => 'Quote Approval Component',
            'description' => 'Quote Approval Component'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    /**
     * load component assets
     * @return void
     */
    public function loadComponentAssets(): void
    {
        // load component css
        $this->addCss([
            '~/plugins/bt/sales/assets/css/quoteapproval.css',
        ]);
        
        // load component js
        $this->addJs([
            '~/plugins/bt/sales/assets/js/quoteapproval.js',
        ]);
    }
    
    public function onRun() {
        $this->loadComponentAssets();

        $quoteId = $this->param('id');
        $quoteKey = $this->param('key');

        $quote =  NewQuoteModel::with('accept')->where('id', $quoteId)->where('key_pass', $quoteKey)->first();

        if(empty($quote)) {
            return;
        }
        
        $this->quoteValid = true;
        $this->page->title = 'Quote Approval #' . $quote->id;
        $this->quote_approval = $quote;
        $this->quoteId = $quote->id;
        $this->quoteKeyPass = $quote->key_pass;

        if($quote->accept) {
            $this->quoteApprovalCompleted = true;
            $this->page['quoteApprovalFormResponse'] = 'By ' . $quote->accept->first_name . ' ' . $quote->accept->last_name;
        }

    }

    public function onQuoteApproval()
    {
        $validator = Validator::make(Input::all(), [
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'signature' => 'required',
            'terms' => 'required',
        ], [
            'terms.required' => 'You must agree to terms and conditions before continuing'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $quoteId = $this->param('id');
        $quote = QuoteAcceptModel::with('quote')->where('quote_id', $quoteId)->first();

        if(!$quote)
        {
            $quoteAccept = QuoteAcceptModel::create([
                'quote_id' => $quoteId,
                'accept' => now(),
                'ip_address' => Request::ip(),
                'first_name' => ucfirst(strtolower(Input::get('name'))),
                'last_name' => ucfirst(strtolower(Input::get('surname'))),
            ]);

            // remove the data URI scheme part (e.g., "data:image/png;base64,")
            $base64String = preg_replace('#^data:image/\w+;base64,#i', '', Input::get('signature'));

            // decode the base64 string
            $imageData = base64_decode($base64String);

            // attach the signature to the quote approval
            $file = (new \System\Models\File)->fromData($imageData, $quoteAccept->quote_id . '_quote_approval_signature.png');
            $quoteAccept->signature = $file;

            $quoteAccept->save();

            $this->quoteApprovalEmailNotification($quoteAccept);
            $this->quoteApprovalFirstName = $quoteAccept->first_name;
            $this->quoteApprovalLastName = $quoteAccept->last_name;
    
            $this->page['quoteApprovalFormResponse'] = "By $this->quoteApprovalFirstName $this->quoteApprovalLastName";
            return;
        }

        $this->page['quoteApprovalFormResponse'] = 'Unable to approve quote, please contact us for assistance.';
        return;
    }

    /**
     * send email when client approves quote
     * @param QuoteAcceptModel $quoteAccept
     * @return void
     */
    public function quoteApprovalEmailNotification(QuoteAcceptModel $quoteAccept): void
    {
        $data['to_email'] = $quoteAccept->quote->user->email;
        $data['to_name'] = $quoteAccept->first_name .' '. $quoteAccept->last_name;
        $data['message'] = "Quote approved by $quoteAccept->first_name $quoteAccept->last_name on $quoteAccept->created_at";

        Mail::send('bt.sales.quoteApprovalNotification', $data, function ($message) use ($data) {
            $message->to([
                $data['to_email'] => $data['to_name'],
            ]);
        });
    }
}
