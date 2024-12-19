@extends('Layout.layout')

@section('content')
<div class="d-flex justify-content-center">
    <div class="col-lg-6 col-md-10 bg-light p-5 my-3 rounded-2">
        <h2 class="text-center">Payment</h2>
        <div class="row my-4">
            <div class="input col-6">
                <label for="" class="form-label mb-0">OrderID : <b>{{$order->id}}</b></label>
            </div>
            <div class="input col-6 text-end">
                @if($tableno)
                <label for="" lass="form-label">Table : <b>{{$tableno}}</b></label>
                @elseif($token)
                <label for="" lass="form-label">Token : <b>{{$token}}</b></label>
                @endif
            </div>
        </div>
    <form action="/waiter/order/payment/{{$order->id}}" method="POST">
        @csrf
        @method('PUT')
        <div class="my-3">
            <label for="" lass="form-label">Grand Total</label>
        <input type="text" class="form-control" id="total" value="{{$order->grandtotal}}" readonly>
        </div>

        <div class="my-3">
            <label for="payment-type" lass="form-label">Payment Type</label>
            <select name="payment-type" class="form-select" id="payment-type">
                <option value="Cash">Cash</option>
                <option value="Card">Card</option>
                <option value="PayPal">PayPal</option>
                <option value="GPay">GPay</option>
            </select>
        </div>
    
        <div class="my-3">
            <label for="paid" lass="form-label">Paid Amount</label>
            <input type="text" id="paid" name="paid" oninput="handleChange()" class="form-control">
        </div>
    
        <div class="my-3">
            <label for="change" lass="form-label">Change Amount</label>
        <input type="text" id="change" name="change" class="form-control">
        </div>

        <input type="submit" class="btn btn-danger mt-3" value="Pay Now">
        </form>
    
    </div>
</div>

<script>
    function handleChange() {
        let change = $('#paid').val() - $('#total').val();
        $('#change').val(change.toFixed(2));
    }
</script>
@endsection