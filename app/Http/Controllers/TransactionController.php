<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\Pin;
use App\Product;
use App\Order;
use App\OrderDetail;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function pinPay(Request $request)
    {
        // dd($request->all());

        $rules = [
        'pin'        => 'required',
        ];

        $messages = [
            'pin.required' => 'Please enter a PIN',
        ];

        $this->validate($request, $rules, $messages);

        // create order
        $order = new Order;
        $order->customer_id = $request->customer_id;
        $order->order_number = $order->generateOrderNumber();
        $order->amount = $request->amount;
        $order->is_fulfilled = 1;
        $order->discount = 0.00;
        $order->save();

        // order details
        foreach ($request->products as $product) {
            $orderDetail = new OrderDetail;
            $orderDetail->order_id = $order->id;
            $orderDetail->product_id = $product['id'];
            $orderDetail->qty = $product['order_qty'];
            $orderDetail->total_amount = $product['unit_price'] * $product['order_qty'];
            $orderDetail->save();            
        }

        $pin = Pin::where('pin', $request->pin)->first();

        // pin not found
        if (!$pin) {

            //record trx
            $trx = new Transaction;
            $trx->trxref = $request->trxref;
            $trx->transaction = $trx->generateTrxNumber();
            $trx->message = 'PIN not found';
            $trx->status = 'failed';
            $trx->payment_type_id = 1;
            $trx->order_id = $order->id;
            $trx->amount = $request->amount;
            $trx->save();

            $data = ['success' => false, 'message' => 'Invalid PIN', 'transaction' => $trx->transaction];
            return response()->json($data, 200);
        }

        $remainingValue = $pin->value - $pin->value_used;

        if ($remainingValue <= $request->amount) {

            //record trx
            $trx = new Transaction;
            $trx->trxref = $request->trxref;
            $trx->transaction = $trx->generateTrxNumber();
            $trx->message = 'Insufficient fund. Ticket has '.$remainingValue.' units left';
            $trx->status = 'failed';
            $trx->payment_type_id = 1;
            $trx->pin_id = $pin->id;
            $trx->order_id = $order->id;
            $trx->amount = $request->amount;
            $trx->save();

            $data = ['success' => false, 'message' => 'Insufficient fund. Ticket has '.$remainingValue.' units left', 'transaction' => $trx->transaction];
            return response()->json($data, 200);
        }

        // deduct amount on PIN
        $pin->value_used += $request->amount;
        $pin->is_exhausted = ($pin->value_used - $pin->value) <= 0 ? 1 : 0;
        $pin->save();

        //record trx
        $trx = new Transaction;
        $trx->trxref = $request->trxref;
        $trx->transaction = $trx->generateTrxNumber();
        $trx->message = 'Approved';
        $trx->status = 'success';
        $trx->payment_type_id = 1;
        $trx->pin_id = $pin->id;
        $trx->order_id = $order->id;
        $trx->amount = $request->amount;
        $trx->save();

        // update product
        foreach ($request->products as $product) {
            $p = Product::find($product['id']);
            if (!$p->is_digital) {
                $p->units_in_stock -= 1;
                $p->units_on_order -= 1;
                $p->is_fulfilled = 1;
                $p->is_available  = $p->units_in_stock > 0 ? 1 : 0;
            }
            $p->save();            
        }

        

        $data = ['success' => true, 'message' => 'Transaction Successful', 'transaction' => $trx->transaction];
        return response()->json($data, 200);
    }

    public function onlinePay(Request $request) {
        // dd($request->all());

        // create order
        $order = new Order;
        $order->customer_id = $request->customer_id;
        $order->order_number = $order->generateOrderNumber();
        $order->amount = $request->amount;
        $order->is_fulfilled = 1;
        $order->discount = 0.00;
        $order->save();

        // order details
        foreach ($request->products as $product) {
            $orderDetail = new OrderDetail;
            $orderDetail->order_id = $order->id;
            $orderDetail->product_id = $product['id'];
            $orderDetail->qty = $product['order_qty'];
            $orderDetail->total_amount = $product['unit_price'] * $product['order_qty'];
            $orderDetail->save();            
        }

        //record trx
        $trx = new Transaction;
        $trx->trxref = $request->trxref;
        $trx->transaction = $request->transaction;
        $trx->message = $request->message;
        $trx->status = $request->status;
        $trx->payment_type_id = 2;
        $trx->order_id = $order->id;
        $trx->amount = $request->amount;
        $trx->save();

        // update product
        foreach ($request->products as $product) {
            $p = Product::find($product['id']);
            if (!$p->is_digital) {
                $p->units_in_stock -= 1;
                $p->units_on_order -= 1;
                $p->is_fulfilled = 1;
                $p->is_available  = $p->units_in_stock > 0 ? 1 : 0;
            }
            $p->save();            
        }

        $data = ['success' => true, 'message' => 'Transaction Successful', 'transaction' => $trx->transaction];
        return response()->json($data, 200);

    }
}
