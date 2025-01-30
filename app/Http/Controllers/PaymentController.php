<?php


namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PaymentController extends Controller
{


    public function index()
    {
        return view('payment-form');
    }



    public function submitPaymentForm(Request $request)
    {
        $request->validate([

            'amount' => 'required'

        ], [

            'amount' => 'Amount is Required'

        ]);
        $name='shubham';
        $amount = $request->input('amount');

        if ($name != '' && $amount != '') {

            $merchantId = 'PGTESTPAYUAT';

            $apiKey = '099eb0cd-02cf-4e2a-8aca-3e6c6aff0399';
            $redirectUrl = route('confirm');
            $order_id = uniqid();


            $transaction_data = array(
                'merchantId' => "$merchantId",
                'merchantTransactionId' => "$order_id",
                "merchantUserId" => $order_id,
                'amount' => $amount * 100,
                'redirectUrl' => "$redirectUrl",
                'redirectMode' => "POST",
                'callbackUrl' => "$redirectUrl",
                "paymentInstrument" => array(
                    "type" => "PAY_PAGE",
                )
            );


            $encode = json_encode($transaction_data);
            $payloadMain = base64_encode($encode);
            $salt_index = 1; //key index 1
            $payload = $payloadMain . "/pg/v1/pay" . $apiKey;
            $sha256 = hash("sha256", $payload);
            $final_x_header = $sha256 . '###' . $salt_index;
            $request = json_encode(array('request' => $payloadMain));

            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $request,
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json",
                    "X-VERIFY: " . $final_x_header,
                    "accept: application/json"
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $res = json_decode($response);

                // Store information into database

                $data = [
                    'amount' => $amount,
                    'transaction_id' => $order_id,
                    'payment_status' => 'PAYMENT_PENDING',
                    'response_msg' => $response,
                    'providerReferenceId' => '',
                    'merchantOrderId' => '',
                    'checksum' => ''
                ];

                Payment::create($data);

                // end database insert

                if (isset($res->code) && ($res->code == 'PAYMENT_INITIATED')) {

                    $payUrl = $res->data->instrumentResponse->redirectInfo->url;

                    return redirect()->away($payUrl);
                } else {
                    //HANDLE YOUR ERROR MESSAGE HERE
                    dd('ERROR : ' . json_encode($res));
                }
            }
        }
    }


    public function confirmPayment(Request $request)
    {

        if ($request->code == 'PAYMENT_SUCCESS') {
            $transactionId = $request->transactionId;
            $merchantId = $request->merchantId;
            $providerReferenceId = $request->providerReferenceId;
            $merchantOrderId = $request->merchantOrderId;
            $checksum = $request->checksum;
            $status = $request->code;

            //Transaction completed, You can add transaction details into database


            $data = [
                'providerReferenceId' => $providerReferenceId,
                'checksum' => $checksum,

            ];
            if ($merchantOrderId != '') {
                $data['merchantOrderId'] = $merchantOrderId;
            }

            Payment::where('transaction_id', $transactionId)->update($data);

            return view('confirm_payment', compact('providerReferenceId', 'transactionId'));
        } else {

            //HANDLE YOUR ERROR MESSAGE HERE
            dd('ERROR : ' . $request->code . ', Please Try Again Later.');
        }
    }
}
