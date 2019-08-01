<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Resources\Order as OrderResource;
use App\Http\Resources\OrderCollection;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with('order_details')->paginate();

        if (request()->wantsJson()) {
            return response([
                'data' => new OrderCollection($orders)
            ], 200);
        }

        return view('orders.index')->with('orders', $orders);
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
    public function store(Request $request)
    {
        // dd($request->all());

    	$rules = [
            'order_number' => 'required',
            ];
    
            $messages = [
            'order_number.required' => 'Order Number is required',
            ];
    
            $this->validate($request, $rules, $messages);
    
            $order                  = new Order;
            $order->customer_id     = $request->customer_id;
            $order->order_number    = $order->generateOrderNumber();
            $order->amount          = $request->amount;
            $order->payment_id      = $request->payment_id;
            $order->error_msg       = $request->error_msg;
            
            
            if($order->save()) {

                foreach($request->order_details as $detail) {
                    $orderDetail                = new OrderDetail;
                    $orderDetail->order_id      = $order->id;
                    $orderDetail->product_id    = $detail['product_id'];
                    $orderDetail->qty           = $detail['qty'];
                    $orderDetail->price         = $detail['price'];
                    $orderDetail->save();
                }

                if (request()->json()) {
                    return response([
                        'data' => new OrderCollection(Order::with('order_details')->paginate())
                    ], 200);
                }

                return redirect('orders');
            }
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $order = Order::where('id', $order->id)->with('order_details.product')->first();

        if (request()->expectsJson()) {
            return response([
                'data' => new OrderResource($order)
            ], 200);
        }

        return view('orders.show')->with('order', $order);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
