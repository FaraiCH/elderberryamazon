<?php

namespace Bt\Sales\Components;

use Bt\Maintenance\Models\Vehicle;
use Bt\Sales\Models\DispatchItem;
use Bt\Sales\Models\Newquote;
use Bt\Sales\Models\TransportFee;
use Bt\Sales\Models\TransportRatesDestination;
use Bt\Sales\Models\TransportType;
use Cms\Classes\ComponentBase;
use Bt\Sales\Models\Product;
use Bt\Sales\Models\Catalogue;
use Bt\Sales\Models\QuoteStatus;
use FontLib\Table\Type\post;
use Illuminate\Mail\Transport\Transport;
use RainLab\User\Models\UserGroup;
use Bt\Sales\Models\PricePerKg;
use Bt\Sales\Models\Quoteitems;
use Bt\Sales\Models\QuoteItemCatalogue;
use Bt\Sales\Models\Newquote as ModelNewquote;
use Bt\Sales\Models\QuoteEmail as ModelQuoteEmail;
use Bt\Sales\Models\QuoteReponse as QuoteReponseModel;
use Carbon\Carbon;
use Bt\Sales\Models\ReceivedNonReceived;
use Bt\Sales\Models\ReasonForQuote;
use Bt\Sales\Models\ClientCategoryTarget;
use Bt\Sales\Models\ClientCategory;

use Bt\Sales\Models\Client as ClientModel;

use Auth;
use Flash;
use Input;
use Validator;
use Redirect;
use ValidationException;
use GuzzleHttp\Client;
use Http;
use Mail;
use Config;
use Renatio\DynamicPDF\Classes\PDF;
use DB;


class NewqouteV2 extends ComponentBase
{
    public $produn;
    public $priceperkg;
    public $rateupdate;
    public function componentDetails()
    {
        return [
            'name'        => 'newqoute Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {

        #$this->businesses = $this->loadBusiness();
        $this->loadAssets();
        $PricePerKg = PricePerKg::first();
        $RateUpdate = TransportFee::orderBy('date', 'desc')->where('active', 1)->first();
        $this->priceperkg = $PricePerKg->amount;
//
//        $this->page['rateupdate'] = $RateUpdate->date;
    }

    public function loadAssets()
    {
        $this->addCss('https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css', 'Bt.Sales');
        //        $this->addJs('assets/js/chosen.jquery.js', 'Bt.Sales');
        $this->addJs('assets/js/formV2.js', 'Bt.Sales', '2');

        $this->addJs('https://code.jquery.com/ui/1.12.1/jquery-ui.js', 'Bt.Sales');
        $this->addJs('assets/js/formfilter.js', 'Bt.Sales');
        $this->addJs('assets/js/meh.js', 'Bt.Sales');
        $this->addJs('https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', 'Bt.Sales');
    }

    public function loadProduct()
    {
        return Product::all();
    }
    public function loadSecondsProduct()
    {
        return Catalogue::all();
    }
    public function loadSecondsProductArray()
    {
        return json_encode(Catalogue::all()->pluck('price', 'id')->toarray());
    }
    public function loadReasonForQuote()
    {
        return ReasonForQuote::orderby('id', 'desc')->get();
    }

    public function loadReceivedNonReceived()
    {
        return ReceivedNonReceived::all();
    }
    public function loadUniqueCompany()
    {

        // return ModelNewquote::distinct()->get(['id','company_name']);
        //        $user = Auth::getUser();

        return ModelNewquote::where('created_at', '>=', Carbon::now()->subDays(200)->toDateTimeString())->active()->orderBy('id', 'desc')->get();
    }

    public function loadClient()
    {
        return ClientModel::orderBy('company_name', 'asc')->get();
    }





    public function onFetchCompany()
    {
        if (Input::has('quotecopy') &&  Input::get('quotecopy') > 0) {
            $this->page['copy'] = ModelNewquote::find(Input::get('quotecopy'));
        }
    }

    public function onUpdatepreview()
    {
        $arr = array();
        $arr_clean = array();
        $arr_delivery = array();
        $this->page['response'] = null;
        $this->page['deliveryitem'] = null;
        $PricePerKg = PricePerKg::first();
        $total = 0;
        $costs = 0;
        $qty = 0;
        $totalweight_of_item = 0;
        $transport_costs = 0;
        $transportfee = null;
        for ($i = 1; $i < 1000; $i++) {

            if (Input::get('destination_' . $i) && Input::has('destination_' . $i) > 0) {
                $transportfee = TransportFee::where('transportratesdestination_id', Input::get('destination_' . $i))->where('active', 1)->orderBy('date', 'desc')->first();
            }
            if (Input::get('vehicle_type_' . $i) && Input::has('vehicle_type_' . $i) != null) {
                if (!empty($transportfee)) {
                    $delivery_type = Input::get('delivery_type_' . $i);
                    if($delivery_type == 'bt'){
                        $vehicletype =  Input::get('vehicle_type_' . $i);
                        $vehicletype_column =  'bt_'. $vehicletype;
                    }else{
                        $vehicletype = Input::get('vehicle_type_' . $i);
                        $vehicletype_column = $vehicletype;
                    }
                    if (Input::has('hide_quote_' . $i)) {
                        $discount_perc = Input::get('discount_' . $i);
                        $discount_price = 0;
                        if($discount_perc)
                            $discount_price = $transportfee->$vehicletype_column * ($discount_perc/100);
                        $transport_costs += ($transportfee->$vehicletype_column - $discount_price) * Input::get('trip_qty_' . $i);

                    }
                }
            }

            if (Input::has('product_' . $i) &&  Input::has('unitlength_' . $i) &&  Input::has('units_' . $i)) {
                if (Input::get('product_' . $i) > 0 && Input::get('unitlength_' . $i) > 0  && Input::get('units_' . $i) > 0) {
                    $product = Product::find(Input::get('product_' . $i));
                    if ($product->value > 0) {
                        $unitlength = Input::get('unitlength_' . $i);
                        $units = Input::get('units_' . $i);
                        $totalweight = $product->value * $unitlength * $units;
                        $totalweight_of_item += $totalweight;
                    }
                }
            }
        }

        for ($i = 1; $i < 1000; $i++) {
            if (Input::has('product_' . $i) &&  Input::has('unitlength_' . $i) &&  Input::has('units_' . $i)) {
                if (Input::get('product_' . $i) > 0 && Input::get('unitlength_' . $i) > 0  && Input::get('units_' . $i) > 0) {
                    $product = Product::find(Input::get('product_' . $i));
                    if ($product->value > 0) {
                        $unitlength = Input::get('unitlength_' . $i);
                        $units = Input::get('units_' . $i);

                        $weight = $product->value * $unitlength;
                        $totalweight = $product->value * $unitlength * $units;
                        $view_price = 0;
                        if($transport_costs > 0){
                            $view_price = Input::get('priceperkg_' . $i) + ($transport_costs/$totalweight_of_item);
                        }else{
                            $view_price = Input::get('priceperkg_' . $i);
                        }
                        $priceperkg = Input::get('priceperkg_' . $i);
                        $unitprice = $product->value * $view_price * $unitlength;
                        $price = $unitprice * $units;
                        if ($price > 0) {
                            $total += $price;
                            #$arr[] = array('price' =>  $this->bigmoney($price),'unitprice' =>  $this->bigmoney($unitprice), 'product' => $product , 'units' => $units, 'unitlength' => $unitlength, 'weight' => $weight,'item' => $i );
                            $desc = "HDPE PE 100 " . $product->PNRating->name . " " . $product->Diameter->name . "mm " . $unitlength . "m length ";

                            $premiumprice = 0;
                            if (isset($product->PNRating) && !empty($product->PNRating)) {
                                $premiumprice = $product->PNRating->premiumprice;
                            }

                            $arr[] = array('producttype' => 1, 'description' => $desc, 'product_id' =>  Input::get('product_' . $i), 'price' =>  $price, 'unitprice' => $unitprice, 'product' => $product, 'units' => $units, 'unitlength' => $unitlength, 'weight' => $weight, 'totalweight' => $totalweight, 'item' => $i, 'priceperkg' => $priceperkg, 'view_price' => $view_price, 'premiumprice' => $premiumprice);
                        }
                    }


                    //
                }
            }


        }

        for ($i = 1; $i < 1000; $i++) {
            $transportfee = null;
            $rate_per_trans = 0;
            $save_rate_per_trans = 0;
            $save_costs = 0;
            if (Input::get('destination_' . $i) && Input::has('destination_' . $i) > 0) {
                $transportfee = TransportFee::where('transportratesdestination_id', Input::get('destination_' . $i))->where('active', 1)->orderBy('date', 'desc')->first();
            }
            if (Input::get('vehicle_type_' . $i) && Input::has('vehicle_type_' . $i) != null) {
                $transportfee = null;
                if (Input::get('destination_' . $i) && Input::has('destination_' . $i) > 0) {
                    $transportfee = TransportFee::where('transportratesdestination_id', Input::get('destination_' . $i))->where('active', 1)->orderBy('date', 'desc')->first();
                }
                if (!empty($transportfee)) {
                    $delivery_type = Input::get('delivery_type_' . $i);
                    if($delivery_type == 'bt'){
                        $vehicletype =  Input::get('vehicle_type_' . $i);
                        $vehicletype_column =  'bt_'. $vehicletype;
                    }else{
                        $vehicletype = Input::get('vehicle_type_' . $i);
                        $vehicletype_column = $vehicletype;
                    }
                    $vehicle = TransportType::where('to_column', $vehicletype)->first();
                    $qty = Input::get('trip_qty_' . $i);

                    $discount_perc = Input::get('discount_' . $i);
                    $hide = Input::get('hide_quote_' . $i);
                    $comment = Input::get('comment_delivery_' . $i);
                    if(isset($hide)){
                        $costs = 0;
                        $hide = 1;
                    }else{
                        $hide = 0;
                        if($discount_perc > 0){
                            $discount_price = $transportfee->$vehicletype_column * ($discount_perc/100);
                            $costs = $transportfee->$vehicletype_column - $discount_price;
                        }
                        else
                            $costs = $transportfee->$vehicletype_column;
                    }
                    if($discount_perc > 0){
                        $discount_price = $transportfee->$vehicletype_column * ($discount_perc/100);
                        $save_costs = $transportfee->$vehicletype_column - $discount_price;
                    }
                    else
                    {
                        $save_costs = $transportfee->$vehicletype_column;
                    }

                    if($totalweight_of_item > 0)
                    {
                        $rate_per_trans = $costs / $totalweight_of_item;
                        $save_rate_per_trans = $save_costs
                            / $totalweight_of_item;
                    }
                    trace_log($save_rate_per_trans);
                    $arr_delivery[] = array(
                        'd_type' => $delivery_type,
                        'destination' => $transportfee->transportratesdestination->name,
                        'vehicle_type' => $vehicle->name,
                        'qty' => $qty,
                        'cost' => $costs,
                        'save_cost' => $save_costs,
                        'total_weight' => $totalweight_of_item,
                        'rate_per_transport' => $rate_per_trans,
                        'save_rate_per_transport' => $save_rate_per_trans,
                        'destination_id' => $transportfee->transportratesdestination->id,
                        'vehicle_id' => $vehicle->id,
                        'discount' => $discount_perc,
                        'hide' => $hide,
                        'comment' => $comment
                    );
                    $total += $costs * $qty;

                }

            }
        }
        for ($i = 1; $i < 1000; $i++) {
            if (Input::has('catalogue_' . $i) && Input::has('catalogue_units_' . $i)) {

                if (Input::get('catalogue_' . $i) > 0 && Input::get('catalogue_units_' . $i) > 0) {

                    $product = Catalogue::find(Input::get('catalogue_' . $i));
                    if (Input::get('catunitprice_' . $i) > 0) {
                        $units = Input::get('catalogue_units_' . $i);

                        $unitprice = Input::get('catunitprice_' . $i);
                        $price = $unitprice * $units;
                        if ($price > 0) {
                            $total += $price;
                            #$arr[] = array('price' =>  $this->bigmoney($price),'unitprice' =>  $this->bigmoney($unitprice), 'product' => $product , 'units' => $units, 'unitlength' => $unitlength, 'weight' => $weight,'item' => $i );
                            $desc = $product->name;
                            $premiumprice = 0;



                            $arr[] = array('producttype' => 2, 'description' => $desc, 'product_id' =>  Input::get('catalogue_' . $i), 'price' =>  $price, 'unitprice' => $unitprice, 'product' => $product, 'units' => $units, 'unitlength' => 0, 'weight' => 0, 'totalweight' => 0, 'item' => $i,  'premiumprice' => $premiumprice);
                        }
                    }


                    //
                }
            }
        }

        if (!empty($arr)) {
            $vat = 0.15;
            if (Input::has('vat') && Input::get('vat') > 0) {
                $vat = 0.15;
            } else {
                $vat = 0.0;
            }

            $deliveryamount = 0.0;
            if (Input::has('deliveryamount') && Input::get('deliveryamount') > 0) {
                $deliveryamount = Input::get('deliveryamount');
                $total += $deliveryamount;
            }
            $this->page['totals'] = array('deliveryamount' => $deliveryamount, 'total' => $total, 'vat' => $vat, 'totalvat' => $total * $vat, 'totalincvat' => (($total * $vat) + $total));

            $this->page['response'] = $arr;
        }
        if (!empty($arr_delivery)) {
            $vat = 0.15;
            if (Input::has('vat') && Input::get('vat') > 0) {
                $vat = 0.15;
            } else {
                $vat = 0.0;
            }

            $deliveryamount = 0.0;
            if (Input::has('deliveryamount') && Input::get('deliveryamount') > 0) {
                $deliveryamount = Input::get('deliveryamount');
                $total += $deliveryamount;
            }
            $this->page['totals'] = array('deliveryamount' =>  $deliveryamount, 'total' =>  $total, 'vat' => $vat, 'totalvat' =>  $total * $vat, 'totalincvat' => (($total * $vat) + $total));
            $this->page['deliveryitem'] = $arr_delivery;
        }
    }

    function bigmoney($r)
    {
        return  number_format(sprintf("%.2f", $r), 2, '.', '');
    }

    public function onSave()
    {
        $user = Auth::getUser();
        $validator = null;

        $validator = Validator::make(
            [
                'billing_name' =>  Input::get('billing_name'),
                'company_name' =>  Input::get('company_name'),
                'physical_address' => Input::get('physical_address'),
                'physical_code' => Input::get('physical_code'),
                'email' => Input::get('email'),
                'phone' =>  Input::get('phone')
            ],
            [
                'billing_name' => 'required',
                'company_name' => 'required',
                'physical_address' => 'required',
                'physical_code' => 'required',
                'email' => 'required',
                'phone' => 'required'
            ]
        );


        if ($validator->fails()) {
            throw new ValidationException($validator);
        }


        $this->onUpdatepreview();
        if (!empty($this->page['totals'])) {

            $PricePerKg = PricePerKg::first();

            $q = new ModelNewquote;
            $q->user_id = $user->id;
            $q->quote_status_id = 1;
            $q->priceperkg = 0;


            $q->agency = Input::get('agency');

            if (Input::has('client_id') && Input::get('client_id') != null) {
                $clientSave = ClientModel::where('company_name', Input::get('client_id'))->first();
                if (!empty($clientSave)) {
                    $q->client_id = $clientSave->id;
                }
            }
            $q->billing_name = Input::get('billing_name');
            $q->company_name = Input::get('company_name');
            $q->reg_number = Input::get('reg_number');
            $q->vat_number = Input::get('vat_number');
            $q->deliveryrequest = Input::get("requestdelivery");
            $q->deliverytype_id = Input::get("deliverytype");
            $q->physical_address = Input::get('physical_address');
            $q->physical_code = Input::get('physical_code');
            $q->postal_address = Input::get('postal_address');
            $q->postal_code = Input::get('postal_code');

            $q->closing_date = Input::get('closing_date');
            $q->received_non_received_order_id = Input::get('received_non_received_order_id');
            $q->reason_for_quote_id = Input::get('reason_for_quote_id');



            $q->deliveryamounthidden = Input::get('deliveryamounthidden');
            $q->deliveryamountmargins = Input::get('deliveryamountmargins');
            $q->buyoutmargins = Input::get('buyoutmargins');


            $q->email = Input::get('email');
            $q->phone = Input::get('phone');
            $q->notes = Input::get('notes');

            $totals = $this->page['totals'];

            $q->deliveryamount = $totals['deliveryamount'];
            $q->vat = $totals['vat'];
            $q->total = $totals['total'];
            $q->totalvat = $totals['totalvat'];
            $q->totalincvat = $totals['totalincvat'];
            $delObj = $this->page['deliveryitem'];
            if (!empty($delObj)) {
                foreach ($delObj as $val) {
                    if($val['discount'] > 0 && empty($val['comment'])){
                        Flash::error('A delivery discount does not have a comment');
                        return;
                    }
                }
            }
            $q->save();

            if (!empty($delObj)) {
                foreach ($delObj as $val) {
                    if($val['discount'] > 0 && empty($val['comment'])){
                        Flash::error('A delivery discount does not have a comment');
                        return;
                    }
                    $q_dispatch = new DispatchItem();
                    $q_dispatch->quote_id = $q->id;
                    $q_dispatch->vehicle_type = $val['d_type'];
                    $q_dispatch->destination_id = $val['destination_id'];
                    $q_dispatch->vehicle_id = $val['vehicle_id'];
                    $q_dispatch->vihicle_load_weight = $val['total_weight'];
                    $q_dispatch->qty = $val['qty'];
                    $q_dispatch->hide = $val['hide'];
                    $q_dispatch->rate_per_transport = $val['save_rate_per_transport'];
                    $q_dispatch->discount = $val['discount'];
                    $q_dispatch->comment = $val['comment'];
                    $q_dispatch->unit_price = $val['save_cost'];
                    $q_dispatch->total = $val['qty'] * $val['save_cost'];
                    $q_dispatch->save();
                }
            }

            if ($q->id > 0) {
                $obj = $this->page['response'];

                foreach ($obj as $key => $val) {
                    if ($val['producttype'] == 1) {
                        $i = new Quoteitems;
                        $i->product_id = $val['product_id'];
                        $i->quote_id = $q->id;
                        $i->description = $val['description'];
                        $i->price = $val['price'];
                        $i->unitprice = $val['unitprice'];
                        $i->units = $val['units'];
                        $i->unitlength = $val['unitlength'];
                        $i->weight = $val['weight'];
                        $i->totalweight = $val['totalweight'];
                        $i->priceperkg = $val['priceperkg'];
                        $i->save();
                    } else {
                        $i = new QuoteItemCatalogue;
                        $i->product_id = $val['product_id'];
                        $i->quote_id = $q->id;
                        $i->description = $val['description'];
                        $i->price = $val['price'];
                        $i->unitprice = $val['unitprice'];
                        $i->units = $val['units'];

                        $i->save();
                    }
                }
                $q->fixTotal();



                $data['user_id'] = $user->id;
                $data['quote_id'] = $q->id;




                $qr = new QuoteReponseModel();

                $data['quote_status_id'] = 1;
                $qr->subQuoteReponse($data);

                // if(Input::has("set_status") && Input::get("set_status") == 3){
                //     $data['quote_status_id'] = 15;
                //     $qr->subQuoteReponse($data);
                // }else{

                // if(Input::has("set_status") && Input::get("set_status") == 2){
                //     $data['quote_status_id'] = 2;
                //     $qr->subQuoteReponse($data);
                // }

                if (Input::has("requestdelivery")) {
                    if (Input::get("requestdelivery") > 0) {
                        $data['quote_status_id'] = 3;
                        $data['notes'] = Input::get("deliveryaddress");
                        $qr->subQuoteReponse($data);
                    }
                }

                if (Input::has("amountdiscount_perc") && Input::has("discountnotes")) {
                    if (Input::get("amountdiscount_perc")) {
                        $data['quote_status_id'] = 5;
                        $data['notes'] = Input::get("discountnotes");
                        $qr->subQuoteReponse($data);
                    }
                }

                if (Input::has('deliveryamount') && Input::get('deliveryamount') > 0) {
                    $qr_d = new QuoteReponseModel();
                    #-----------------------
                    $data_qr = array();
                    $data_qr['user_id'] = $q->user_id;
                    $data_qr['quote_id'] = $q->id;
                    $data_qr['quote_status_id'] =  4;
                    $data_qr['notes'] = "Add delivery from quote";
                    $data_qr['deliveryamount'] = Input::get('deliveryamount');
                    $qr_d->subQuoteReponse($data_qr);
                }




                #}

                #if(Input::has("set_status") && Input::get("set_status") == 1){
                // $data['quote_status_id'] = 8;
                // $qr->subQuoteReponse($data);

                $qemail = new ModelQuoteEmail;
                $qemail->user_id = $user->id;
                $qemail->quote_id = $q->id;
                // $q->email_cc = Input::get('email_cc');
                $qemail->email_to = $q->email;
                $qemail->save();

                $data = [
                    'name' => $q->billing_name,
                    'company_name' => $q->company_name,
                    'response_quote' => $q->user->email,
                    'email_to' => $q->user->email,
                    'notes' =>  null,
                    'ref' => "#BT-" . $q->id
                ];


//
//                Mail::send('BT.sales.newquote', $data, function ($message) use ($data, $q) {
//                    $message->to($data['email_to'], $data['response_quote']);
//                    $message->subject("BT Industrial Quote - Sales Copy: " . $data['ref']);
//                    #$pdf = PDF::loadView('bt.sales::pdfitem',array('quote'=>$quote))->stream();
//                    #$message->attach( $pdf->download($quote->id.'.pdf'), ['as' => 'newquote.jpg']);
//                    $message->attach(Config::get('app.url') . "/quote/item/download/" . $q->id . ".pdf", ['as' => 'newquote.pdf']);
        });

                $objgroup = QuoteStatus::where("id", 1)->first();
                $groupid = $objgroup->email_groups_id;

                $groupusers = UserGroup::where('id', $groupid)->first();

                foreach ($groupusers->users as $key => $value) {
                    if ($data['email_to'] != $value->email) {

//
//                        Mail::send('BT.sales.newquote', $data, function ($message) use ($data, $q, $value) {
//                            $message->to($value->email, $value->name);
//                            $message->subject("BT Industrial Quote - New Quote Notify: " . $data['ref']);
//                            #$pdf = PDF::loadView('bt.sales::pdfitem',array('quote'=>$quote))->stream();
//                            #$message->attach( $pdf->download($quote->id.'.pdf'), ['as' => 'newquote.jpg']);
//                            $message->attach(Config::get('app.url') . "/quote/item/download/" . $q->id . ".pdf", ['as' => 'newquote.pdf']);
        });
                    }
                }
                #}

                Flash::success("New quote created succesfully...");
                $url = $this->controller->pageUrl('quote/item', [':item' => $q->id]);
                return Redirect::to($url);
            } else {
                Flash::error("Error: Could not save quote...");
                return;
            }
        } else {
            Flash::error("There was an error in your quote, empty quote items...");
            return;
        }





        ###Flash::success("Your post was shared succesfully");
        #$url = $this->controller->pageUrl('wall');
        #return Redirect::to($url);
    }

    public function getTarget()
    {

        $list = ClientCategoryTarget::where('category_id', 6)->orderby('run_date', 'desc')->orderby('category_id')->get()->take(4);
        $monster = [];

        foreach ($list as $key => $value) {
            $date_ = Carbon::parse($value->run_date);
            $m = $date_->format('M');;

            $current = Carbon::now();

            $y = $date_->year;
            $k = $y . "_" . $m;
            $monster[$k]["month"] = $m;
            $monster[$k]["year"] = $y;
            $monster[$k]["catname"] = $value->category->name;
            $monster[$k]['arr_cat'][$value->category_id]['target'] = $value->target;
            $monster[$k]['arr_cat'][$value->category_id]['straight'] = $value->straight;
            $monster[$k]['arr_cat'][$value->category_id]['coil'] = $value->coil;

            $monster[$k]["active"] =  ($current->format('M') ==  $date_->format('M')) ? 1 : 0;
        }
        return $monster;
    }

    public function onBusinessName()
    {
        if (Input::has('quotecopy') && Input::get('quotecopy') != null) {
            $quote = Newquote::find(Input::get('quotecopy'));
            if (!empty($quote)) {

                return [
                    '#credit_balance' => $this->renderPartial('@credit', ['quote' => $quote])
                ];
            } else {
                return [
                    '#credit_balance' => $this->renderPartial('@credit', ['quote' => ''])
                ];
            }
        }
    }

    public function onGetSomething()
    {
        if (Input::has('q') && Input::get('q') != null) {
            $quote = Newquote::find(Input::get('q'));
            if (isset($quote)) {
                $datecreated = new \DateTime($quote->created_at);
                $quoteObj = ['id' => $quote->id, 'text' => '#QT' . $quote->id . ' : ' . $quote->company_name . ' : ' . $datecreated->format('d/m/Y') . ' : Pipes ' . $quote->items->count() . ' : Extras ' . $quote->itemscat->count()];
                return json_encode(array($quoteObj));
            } else {
                return json_encode(array(array('id' => 999999, 'text' => 'Quote Not Found')));
            }
        }
    }

    public function onBusinessClient()
    {
        if (Input::has('client_id') && Input::get('client_id') != null) {
            $client = ClientModel::where('company_name', Input::get('client_id'))->first();
            if (!empty($client)) {
                return [
                    '#credit_balance' => $this->renderPartial('@credit', ['company' => $client])
                ];
            } else {
                return [
                    '#credit_balance' => $this->renderPartial('@credit', ['company' => ''])
                ];
            }
        }
    }

    public function onGetsClient()
    {
        $quoteObj = [];
        if (Input::has('q') && Input::get('q') != null) {
            $quote = ClientModel::where('company_name', 'like', '%' . Input::get('q') . '%')->get();
            if (isset($quote)) {
                foreach ($quote as $client) {
                    $quoteObj[] = ['id' => $client->company_name, 'text' => '' . $client->id . ' : ' . $client->company_name];
                }
                return json_encode($quoteObj);
            } else {
                return json_encode(array(array('id' => 999999, 'text' => 'No Client Found')));
            }
        }
    }

    public function getTargetCats()
    {
        return ClientCategory::where('id', 6)->orderBy('id')->get();
    }

    public function onLoadDeliveryDestination()
    {
        return TransportRatesDestination::all();
    }

    public function onLoadDelveryVehicleType()
    {
        return TransportType::all();
    }
}
