@extends('Layout.layout')

@section('content')
<div class="content" style=" overflow:hidden">
@if(count($orders) === 0)
    <p class="m-3">No Served Orders.</p>
@endif
@foreach($orders as $order)
    <div class="order bg-light d-inline-block p-3 px-4 rounded-3 mx-3 mt-3">
        <div class="d-flex justify-content-between">
            <p>OrderID - {{$order->id}}</p>
            {{-- <div> --}}
                <a href="/waiter/order/update/{{$order->id}}"><span title="Update"><i class="fa-regular fa-pen-to-square"></i></span></a>    
            {{-- </div>         --}}
        </div>
        @foreach($tables as $table)
            @if($table->id == $order->table_id)
                <p>Table - {{$table->tablenumber}}</p>
            @endif
        @endforeach
        @if($order->order_token != "")
            <p>Token - {{$order->order_token}}</p>
        @endif
        {{-- <p>Date - {{$order->orderdate}}</p> --}}
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
    
    <div class="my-2 mb-3">Status - <span class="order-status">{{$order->orderstatus}}</span></div>
    <div class="d-flex">
        <a href="/waiter/order/{{$order->id}}" class="btn btn-danger me-2">Detail</a>
    <div>
        <div id="id" class="id d-none">{{$order->id}}</div>
        {{-- @if($order->orderstatus !== 'Served') --}}
        <a class="serve btn btn-success" href="/waiter/order/payment/{{$order->id}}">Payment</a>
        {{-- @endif --}}
    </div>
    </div>

    </div>

@endforeach

<div class="toast position-absolute top-0 end-0" style="z-index: 1050; opacity: 1 !important;" id="toastNotice" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header justify-content-between">
        <strong class="mr-auto">Order Payment</strong>
        <button type="button" class="ml-2 mb-1 close bg-transparent border-0" data-bs-dismiss="toast" aria-label="Close">
          <span aria-hidden="true" class="fs-4">&times;</span>
        </button>
      </div>
    <div class="toast-body">
        {{session('payment-success')}}
    </div>
  </div>

<p id="noti" style="display: none">{{session('payment-success')}}</p>

</div>
<script src="{{asset('/js/toast.js')}}"></script>

<script>
    let orderLists = {!! json_encode($orderLists) !!}
    let menus = [];
    console.log(orderLists)
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
            // $('.order-progress').eq(loop).text(parseInt(progress));
            if(progress === 100) {
                $('.serve').eq(loop).removeClass('disabled');
            }
        loop++;
    }


    $('#servedorders').addClass('active text-danger');

    // function changeOrderStatus() {
    //     let parent = event.target.closest('div');
    //     let id = $(parent).children('#id').text();
    //     let menuDetail = menus.filter((menu) => menu.orderid == id);
    //     let button = event.target;
    //     $.ajax({
    //         url: `/waiter/order`,
    //         type: "PUT",
    //         data: {
    //             orderid: id,
    //             menus: menuDetail,
    //             "_token": "{{ csrf_token() }}"
    //         },
    //         success: function(response) {
    //             // $('.order-status').text('Served');
    //             // $(button).hide();
    //         },
    //         error: function(xhr) {
    //             console.log('Error:', xhr.responseText);
    //         }
    //     });
    // }
</script>
@endsection