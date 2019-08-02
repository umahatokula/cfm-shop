<table class="table">
    <thead>
        <tr>
            <th colspan="3" class="text-center">
                <h4 class="text-primary fw-600 m-0">{{$pin->pin}}</h4>
            </th>
        </tr>
        <tr>
            <th>Order</th>
            <th>Amount</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pin->transactions as $transaction)
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        @endforeach
    </tbody>
</table>
