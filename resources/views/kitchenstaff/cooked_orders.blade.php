@extends('Layout.kitchen_layout')

@section('content')
<div class="content">
    <h3 class="m-3">Cooked Orders</h3>
@if(count($orders) === 0)
    <p class="m-3">No Cooked Orders</p>
@endif
@foreach($orders as $order)
    <div class="order bg-light d-inline-block p-3 px-4 rounded-3 mx-3">
        <p>OrderID - {{$order->id}}</p>
        @foreach($tables as $table)
            @if($table->id == $order->table_id)
                <p>Table - {{$table->tablenumber}}</p>
            @endif
        @endforeach

        @if($order->order_token != "")
            <p>Token - {{$order->order_token}}</p>
        @endif
        @foreach($types as $type)
            @if($type->id == $order->type_id)
                <p>Type - {{$type->typename}}</p>
            @endif
        @endforeach
    {{-- <p>Time - {{$order->ordertime}}</p> --}}

    {{-- @foreach($users as $staff)
        @if($staff->id == $order->staff_id)
            <p>Staff - {{$staff->name}}</p>
        @endif
    @endforeach --}}
    {{-- <div>Progress - <span class="status"></span>%</div> --}}
    <div class="mt-3 mb-1">Status - {{$order->orderstatus}}</div>

    <a href="/kitchen/order/{{$order->id}}" class="btn btn-danger mt-3">Detail</a>
    </div>
@endforeach

</div>

<script>
    let orders = {!! json_encode($orders) !!};
    let orderDetails = {!! json_encode($orderDetails) !!};
    let details = [];
    let statusCount = 0;
    let loop = 0;
    for(let order of orders) {
        let menuCount = 0;
        details = orderDetails.filter(orderDetail => orderDetail.orderid == order.id);
        for(let detail of details) {
            if(detail.orderid == order.id) {
                if(detail.menu_status == 'Ready' || detail.menu_status == 'Served') {
                    statusCount++;
                }
            }
        menuCount++;
        }
        let progress = (statusCount / details.length) * 100
        console.log(statusCount, menuCount);
        $('.status').eq(loop).text(parseInt(progress));
        statusCount = 0;
        loop++;
    }

    $('#cookedorders').addClass('active text-danger');


</script>
@endsection