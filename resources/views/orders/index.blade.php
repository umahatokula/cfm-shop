@extends('master')

@section('body')

<!-- Page Headings Start -->
<div class="row justify-content-between align-items-center mb-10">

    <div class="col-12 col-lg-auto mb-20">
        <div class="page-heading">
            <h3>Orders</h3>
        </div>
    </div><!-- Page Heading End -->

</div><!-- Page Headings End -->

<div class="row">

    <!--Order List Start-->
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-vertical-middle">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                    <tr>
                    <td>{{$order->order_number}}</td>
                        <td>{{$order->customer_id}}</td>
                        <td>{{number_format($order->amount, 2)}}</td>
                        <td>{{$order->created_at}}</td>
                        <td><span class="badge badge-{{$order->is_fulfilled?'success':'danger'}}">{{$order->is_fulfilled?'fulfilled':'pending'}}</span></td>
                        <td class="action h4">
                            <div class="table-action-buttons">
                                <a class="view button button-box button-xs button-primary"  data-toggle="modal"
                                data-target="#modal"
                                data-remote="{{route('orders.show', $order->id)}}" href="#"><i class="zmdi zmdi-eye"></i></a>

                                <a class="edit button button-box button-xs button-warning" href="{{route('orders.details', $order->id)}}"><i class="zmdi zmdi-more"></i></a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!--Order List End-->

</div>
@endsection
