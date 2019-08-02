@extends('master')

@section('body')

<!-- Page Headings Start -->
<div class="row justify-content-between align-items-center mb-10">

    <div class="col-12 col-lg-auto mb-20">
        <div class="page-heading">
            <h3>Add Product</h3>
        </div>
    </div><!-- Page Heading End -->

    <!-- Page Button Group Start -->
    <div class="col-12 col-lg-auto mb-20">
        <div class="buttons-group">
            <button class="button button-outline button-primary">Save & Publish</button>
            <button class="button button-outline button-info">Save to Draft</button>
            <button class="button button-outline button-danger">Delete Product</button>
        </div>
    </div><!-- Page Button Group End -->

</div><!-- Page Headings End -->

<div class="row">
    <div class="col-xlg-12 col-md-12 col-12 mb-30">
        <div class="">
            <!-- Add or Edit Product Start -->
            <div class="add-edit-product-wrap col-12">

                <div class="add-edit-product-form">
                    {!! Form::open(['route' => 'products.store', 'files' => true]) !!}
                        <div class="row mbn-20">

                            <div class="col-12 mb-20">
                                <div class="row mbn-10">
                                    <div class="col-sm-3 col-12 mb-10"><label for="name">Name</label>
                                    </div>
                                    <div class="col-sm-9 col-12 mb-10">
                                        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name',
                                        'placeholder' => 'Name']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-20">
                                <div class="row mbn-10">
                                    <div class="col-sm-3 col-12 mb-10"><label for="description"> Description</label>
                                    </div>
                                    <div class="col-sm-9 col-12 mb-10">
                                        {!! Form::text('description', null, ['class' => 'form-control', 'id' =>
                                        'description', 'placeholder' => 'Description']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-20">
                                <div class="row mbn-10">
                                    <div class="col-sm-3 col-12 mb-10"><label for="unit_price"> Unit Price</label></div>
                                    <div class="col-sm-9 col-12 mb-10">
                                        {!! Form::text('unit_price', null, ['class' => 'form-control', 'id' =>
                                        'unit_price', 'placeholder' => 'Unit Price']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-20">
                                <div class="row mbn-10">
                                    <div class="col-sm-3 col-12 mb-10"><label for="discount_price"> Discount
                                            Price</label></div>
                                    <div class="col-sm-9 col-12 mb-10">
                                        {!! Form::text('discount_price', '0.00', ['class' => 'form-control', 'id' =>
                                        'discount_price', 'placeholder' => 'Discount Price']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-20">
                                <div class="row mbn-10">
                                    <div class="col-sm-3 col-12 mb-10"><label for="quantity_per_unit"> Quantity per
                                            Unit</label></div>
                                    <div class="col-sm-9 col-12 mb-10">
                                        {!! Form::text('quantity_per_unit', null, ['class' => 'form-control', 'id' =>
                                        'quantity_per_unit', 'placeholder' => 'Quantity per Unit']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-20">
                                <div class="row mbn-10">
                                    <div class="col-sm-3 col-12 mb-10"><label for="units_in_stock"> Units in
                                            stock</label></div>
                                    <div class="col-sm-9 col-12 mb-10">
                                        {!! Form::text('units_in_stock', null, ['class' => 'form-control', 'id' =>
                                        'units_in_stock', 'placeholder' => 'Units in stock']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-20">
                                <div class="row mbn-10">
                                    <div class="col-sm-3 col-12 mb-10"><label for="categories"> Categories</label></div>
                                    <div class="col-sm-9 col-12 mb-10">
                                        {!! Form::select('categories[]', $categories, null, ['class' => 'form-control',
                                        'id' => 'categories', 'placeholder' => 'Categories']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-20">
                                <div class="row mbn-10">
                                    <div class="col-sm-3 col-12 mb-10"><label for="is_taxable"> Is taxable</label>
                                    </div>
                                    <div class="col-sm-9 col-12 mb-10">
                                        <div class="adomx-checkbox-radio-group">
                                            <label class="adomx-checkbox-2">
                                                <input name="is_taxable" id="is_taxable" type="checkbox"> <i
                                                    class="icon"></i>
                                                Is taxable</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-20">
                                <div class="row mbn-10">
                                    <div class="col-sm-3 col-12 mb-10"><label for="is_discountable"> Is
                                            Discountable</label>
                                    </div>
                                    <div class="col-sm-9 col-12 mb-10">
                                        <div class="adomx-checkbox-radio-group">
                                            <label class="adomx-checkbox-2">
                                                <input name="is_discountable" id="is_discountable" type="checkbox"> <i
                                                    class="icon"></i>
                                                Is Discountable</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-20">
                                <div class="row mbn-10">
                                    <div class="col-sm-3 col-12 mb-10"><label for="is_digital"> Is Digital</label>
                                    </div>
                                    <div class="col-sm-9 col-12 mb-10">
                                        <div class="adomx-checkbox-radio-group">
                                            <label class="adomx-checkbox-2">
                                                <input name="is_digital" id="is_digital" type="checkbox"> <i
                                                    class="icon"></i> Is Digital</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-20">
                                <div class="row mbn-10">
                                    <div class="col-sm-3 col-12 mb-10"><label for="image"> Upload Image</label>
                                    </div>
                                    <div class="col-sm-9 col-12 mb-10">
                                        <div class="adomx-checkbox-radio-group">
                                            <label class="adomx-checkbox-2">
                                                <input name="image" class="dropify" type="file" data-height="220">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mb-20">
                                <input type="submit" value="submit" class="button button-primary">
                                <input type="submit" value="cancle" class="button button-danger">
                            </div>

                        </div>
                    {!! Form::close() !!}
                </div>

            </div><!-- Add or Edit Product End -->
        </div>
    </div>
</div>
@endsection
