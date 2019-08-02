@extends('master')

@section('body')

<!-- Page Headings Start -->
<div class="row justify-content-between align-items-center mb-10">

    <div class="col-12 col-lg-auto mb-20">
        <div class="page-heading">
            <h3>Products</h3>
        </div>
    </div><!-- Page Heading End -->

</div><!-- Page Headings End -->

<div class="row">

    <!--Manage Product List Start-->
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-vertical-middle">
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>In Stock</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>{{$product->sku}}</td>
                        <td><a href="#">{{$product->name}}</a></td>
                        <td>{{$product->unit_price}}</td>
                        <td>{{$product->units_in_stock}}</td>
                        <td><span class="badge badge-{{$product->is_available ? 'success' : 'danger'}}">{{$product->is_available ? 'in-stock' : 'out-of-stock'}}</span></td>
                        <td>
                            <div class="table-action-buttons">
                                <a class="view button button-box button-xs button-primary" data-toggle="modal"
                                data-target="#modal"
                                data-remote="{{route('products.show', $product->id)}}" href="#"><i class="zmdi zmdi-more"></i></a>
                                <a class="edit button button-box button-xs button-info"  data-toggle="modal"
                                data-target="#modal"
                                data-remote="{{route('products.edit', $product->id)}}" href="#"><i class="zmdi zmdi-edit"></i></a>
                                <a class="delete button button-box button-xs button-danger" href="#"><i class="zmdi zmdi-delete"></i></a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!--Manage Product List End-->

</div>
@endsection
