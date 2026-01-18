<?php
namespace App\Http\Controllers\DashBoard;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\EsewaPayment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;



class EsewaPaymentController extends Controller
{
    protected $product_code;
    protected $esewa_url;
    protected $secret_key;
    protected $esewa_status_url;

    public function __construct()
    {
        if (env('ESEWA_TESTING')) {
            $this->product_code = env('ESEWA_MERCHANT_ID_TESTING');
            $this->esewa_url = env('ESEWA_PAYMENT_URL_TESTING');
            $this->esewa_status_url = env('ESEWA_PAYMENT_STATUS_URL_TESTING');
            $this->secret_key = env('ESEWA_SECRET_KEY_TESTING');
        } else {
            $this->product_code = env('ESEWA_MERCHANT_ID');
            $this->esewa_url = env('ESEWA_PAYMENT_URL');
            $this->esewa_status_url = env('ESEWA_PAYMENT_STATUS_URL');
            $this->secret_key = env('ESEWA_SECRET_KEY');
        }
    }

    public function createSignature($amount, $transaction_uuid, $product_code, $secretKey)
    {
        $message = "total_amount=$amount,transaction_uuid=$transaction_uuid,product_code=$product_code";
        $s = hash_hmac('sha256', $message, $secretKey, true);
        return base64_encode($s);
    }

    public function showPaymentForm()
    {
        $order = Order::where('user_id', Auth::id())
            ->latest()
            ->firstOrFail();
        // or however you fetch the order


        $amount = ($order->total);
        $transaction_uuid = uniqid();
        $order_id = $order->id;


        $signature = $this->createSignature($amount, $transaction_uuid, $this->product_code, $this->secret_key);

        // Save the temp_payment details to the database
        EsewaPayment::create([
            'order_id' => $order_id,
            'amount' => $amount,
            'transaction_uuid' => $transaction_uuid,
            'ref_id' => null,
            'signature' => $signature,
            'status' => 'pending',
        ]);


        $esewaData = [
            'esewa_url' => $this->esewa_url,
            'amount' => $amount,
            'product_service_charge' => 0,
            'tax_amount' => 0,
            'product_delivery_charge' => 0,
            'total_amount' => $amount,
            'product_code' => $this->product_code,
            'transaction_uuid' => $transaction_uuid,
            'signed_field_names' => 'total_amount,transaction_uuid,product_code',
            'signature' => $signature,
            'success_url' => route('payment.success'),
            'failure_url' => route('payment.failure'),
        ];

        return view('payment.form', compact('esewaData'));
    }


    public function submitToEsewa(Request $request)
    {

        //sendinng controller
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'product_delivery_charge' => 'required|numeric|min:0',
            'product_service_charge' => 'required|numeric|min:0',
            'tax_amount' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'success_url' => 'required|url',
            'failure_url' => 'required|url',
        ]);
    }

    public function checkEsewaPayementStatus($esewaResponse, $paymentData)
    {
        $url = $this->esewa_status_url . '?' . http_build_query([
            'product_code' => $this->product_code,
            'total_amount' => $paymentData->amount,
            'transaction_uuid' => $esewaResponse['transaction_uuid'],
        ]);

        $response = Http::get($url);
        if ($response->successful()) {
            $response = $response->json();
            if ($response['status'] == 'COMPLETE') {
                return $response['ref_id'];
            }
        }

        return null;
    }

    public function paymentSuccess(Request $request)
    {
        $paymentStatus = false;
        $esewaResponse = $request->get('data');

        if (!$esewaResponse) {
            return redirect()->route('payment.failure')->with('error', 'Payment failed. Please try again.');
        }

        $esewaResponse = json_decode(base64_decode($esewaResponse), true);

        if (!$esewaResponse || !isset($esewaResponse['transaction_uuid'])) {
            return redirect()->route('payment.failure')->with('error', 'Invalid payment response.');
        }

        $esewaPayment = EsewaPayment::where('transaction_uuid', $esewaResponse['transaction_uuid'])->first();

        if (!$esewaPayment) {
            return redirect()->route('payment.failure')->with('error', 'Payment record not found.');
        }

        if ($esewaResponse['status'] == 'COMPLETE') {
            $ref_id = $this->checkEsewaPayementStatus($esewaResponse, $esewaPayment);

            if (!$ref_id) {
                return redirect()->route('payment.failure')->with('error', 'Payment verification failed.');
            }

            $esewaPayment->update(['status' => 'success', 'ref_id' => $ref_id]);
            Transaction::where('order_id', $esewaPayment->order_id)->update(['status' => 'approved']);
            $paymentStatus = true;
        }

        if ($paymentStatus) {
            return redirect()->route('order.confirmation', [
                'order_id' => $esewaPayment->order_id
            ])->with('success', 'Your order has been placed successfully.');
        } else {
            return redirect()->route('checkout')->with('error', 'Payment failed. Please try again.');
        }
    }
    public function paymentFailure()
    {
        return view('payment.failure')->with('error', 'Payment failed. Please try again.');
    }
}
