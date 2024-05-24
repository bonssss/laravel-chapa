<?php

namespace App\Http\Controllers;

use App\Models\Payment\Payment;
use Chapa\Chapa\Facades\Chapa as Chapa;
use Illuminate\Http\Request;

class ChapaController extends Controller
{
    /**
     * Initialize Rave payment process
     * @return void
     */
    protected $reference;

    public function __construct()
    {
        $this->reference = Chapa::generateReference();
    }
    public function initialize(Request $request)
    {
        //This generates a payment reference
        $reference = $this->reference;


        // Enter the details of the payment
        $data = [

            'amount' => $request->amount,
            'email' => $request->email,
            'tx_ref' => $reference,
            'currency' => "ETB",
            'callback_url' => route('callback', [$reference]),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            "customization" => [
                "title" => ' Laravel chapa',
                "description" => " test this"
            ]
        ];


        $payment = Chapa::initializePayment($data);


        if ($payment['status'] !== 'success') {
            // notify something went wrong

            return;
        }

        return redirect($payment['data']['checkout_url']);
    }

    /**
     * Obtain Rave callback information
     * @return void
     */
    public function callback($reference)
    {
        // Verify the transaction
        $data = Chapa::verifyTransaction($reference);

        // Check if the payment was successful
        if ($data['status'] == 'success') {
            Payment::create([
                'reference' => $reference,
                'amount' => $data['data']['amount'],
                'currency' => $data['data']['currency'],
                'f_name' => request()->first_name,
                'l_name' => request()->last_name,
                'email' => request()->email,



            ]);
            // Handle successful payment
            return view('payment.success');
        } else {
            // Handle failed payment
            return view('payment.fail');
        }
    }
}
