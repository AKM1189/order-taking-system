@extends('Layout.layout')

@section('content')
<div class="content" style=" overflow:hidden">
    @if(count($orders) === 0)
    <p class="m-3">No Ongoing Orders.</p>
@endif
@foreach($orders as $key=>$order)
    <div class="order bg-light d-inline-block p-3 px-4 rounded-3 mx-3 mt-3">
        <div class="d-flex justify-content-between">
            <p>OrderID - {{$order->id}}</p>
                <a href="/waiter/order/update/{{$order->id}}"><span title="Update"><i class="fa-regular fa-pen-to-square"></i></span></a>    
        </div>
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
    <p>Time - {{$order->ordertime}}</p>

    @foreach($users as $ordereduser)
        @if($ordereduser->id == $order->staff_id)
            <p>Staff - {{$ordereduser->name}}</p>
        @endif
    @endforeach
    
    <div>Progress - <span class="order-progress"></span>%</div>
    <div class="my-2 mb-3">Status - <span class="order-status">{{$order->orderstatus}}</span></div>
    <div class="d-flex">
        <a href="/waiter/order/{{$order->id}}" class="btn btn-danger me-2">Detail</a>
    <div>
        <div id="id" class="id d-none">{{$order->id}}</div>
        @if($order->orderstatus !== 'Served')
        <button class="serve btn btn-success disabled" onclick="changeOrderStatus({{$key}})">Serve</button>
        @endif
    </div>
    </div>

    </div>
@endforeach
</div>

<script>
    let orderLists = {!! json_encode($orderLists) !!}
    let menus = [];
    let loop = 0;
    for(let order of orderLists) {
        let status = [];
        let ready = 0;
        let cooking = 0; 
        let count = 0;
        for(let menu of order.menu){
            if(menu.pivot.menu_status == 'Ready' || menu.pivot.menu_status == 'Served') {
                ready++;
            }
            count++;
            menus.push(menu.pivot);
        }
        let progress = (ready / count) * 100
            $('.order-progress').eq(loop).text(parseInt(progress));
            if(progress === 100) {
                $('.serve').eq(loop).removeClass('disabled');
            }
        loop++;
    }


    function changeOrderStatus(loop) {
        let parent = event.target.closest('div');
        console.log(loop);
        let id = $(parent).children('#id').text();
        let menuDetail = menus.filter((menu) => menu.orderid == id);
        let button = event.target;
        $.ajax({
            url: `/waiter/order`,
            type: "PUT",
            data: {
                orderid: id,
                menus: menuDetail,
                "_token": "{{ csrf_token() }}"
            },
            success: function(response) {
                $($('.order-status')[loop]).text('Served');
                $(button).hide();
            },
            error: function(xhr) {
                console.log('Error:', xhr.responseText);
            }
        });
    }


    $('#ongoingorders').addClass('active text-danger');

</script>
@endsection