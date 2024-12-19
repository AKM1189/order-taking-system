@extends('Layout.kitchen_layout')

@section('content')
<div class="order d-flex justify-content-center p-3 px-4 rounded-3 mx-3 ">
    {{-- <h1>Detail</h1> --}}
<div class="col-8">
    <div class="order-detail d-flex">
        <div class="order-input me-2">
            <label for="id" class="form-label">OrderID</label>
            <input type="text" class="form-control" value="{{$order->id}}" readonly>
        </div>
        @if($table) 
        <div class="order-input me-2">
            <label class="form-label">Table</label>
            <input type="text" class="form-control" value="{{$table->tablenumber}}" readonly>
        </div>
        @else
        <div class="order-input me-2">
            <label class="form-label">Order Token</label>
            <input type="text" class="form-control" value="{{$order->order_token}}" readonly>
        </div>
        @endif
        <div class="order-input me-2">
            <label class="form-label">Order Type</label>
            <input type="text" class="form-control" value="{{$type->typename}}" readonly>
        </div>
        <div class="order-input me-2">
            <label class="form-label">Order Time</label>
            <input type="text" class="form-control" value="{{$order->ordertime}}" readonly>
        </div>
        <div class="order-input me-2">
            <label class="form-label">Staff</label>
            <input type="text" class="form-control" value="@if($user){{$user->name}}@endif" readonly>
        </div>
    </div>
    {{-- <p>OrderID - {{$order->id}}</p> --}}
    {{-- @foreach($tables as $table)
        @if($table->id == $order->table_id) --}}
            {{-- <p>Table - {{$table->tablenumber}}</p> --}}
        {{-- @endif
    @endforeach --}}
    {{-- <a href="/waiter/order/update/{{$order->id}}"><span title="Update"><i class="fa-regular fa-pen-to-square"></i></span></a> --}}
    {{-- <p>Date - {{$order->orderdate}}</p> --}}
    {{-- @foreach($types as $type)
        @if($type->id == $order->type_id) --}}
            {{-- <p>Type - {{$type->typename}}</p> --}}
        {{-- @endif
    @endforeach --}}
{{-- <p>Time - {{$order->ordertime}}</p> --}}

{{-- @foreach($users as $user)
    @if($user->id == $order->staff_id) --}}
        {{-- <p>Staff - {{$user->name}}</p> --}}
    {{-- @endif
@endforeach --}}
<div class="my-3"><b>Progress - <span id="status"></span>%</b></div>

<div>{{session('unavailable')}}</div>
<div class="">
    <div id="menu-lists">
    
    </div>
</div>

{{-- <p>status - {{$order->orderstatus}}</p> --}}
</div>
</div>

<script>
    let order = {!! json_encode($order) !!};
    let menus = order.menu;
    let statusCount = 0;
    let menuCount = 0;
    let menuDetail = [];
    for(let menu of menus){
        $('#menu-lists').append(
            `<div class='menu col-12 py-3 px-5 my-2 w-100 d-flex justify-content-between align-items-center border rounded-1' style="box-shadow: 1px 1px 6px -4px grey; height: 70px"  data-key='${menu.id}'>
                <input type='hidden' id='id' value='${menu.id}'>
                <div class='col-5'><span>${menu.pivot.unit_quantity}</span> x <span>${menu.menuname}</span></div>
                <span class='col-1'><span class='ready' onclick='changeStatus(${menu.id})'></span></span>
            </div>`
        )

        menuDetail.push(menu.pivot);
        if(menu.pivot.menu_status == 'Cooking') {
                $($('.ready')[menuCount]).text('Ready');
                $($('.ready')[menuCount]).addClass('btn btn-danger');            
        }
        else if(menu.pivot.menu_status == 'Ready' || menu.pivot.menu_status == 'Served'){
            statusCount++;
            $($('.ready')[menuCount]).text(menu.pivot.menu_status);
            // $($('.ready')[menuCount]).css('display', 'none');
            $($('.menu')[menuCount]).css('background-color', '#ccffcc');
        }
        menuCount++;
    }
    
    function changeStatus(id) {
        // console.log(id);
        let menu = menus.filter(menu => menu.id == id);
        // console.log()
        if(menu[0].pivot.menu_status == 'Cooking') {
            menu[0].pivot.menu_status = 'Ready';
        
        menu = menu[0].pivot;
        let div = event.target.closest('div');
        let menuid = $(div).children('#id').val();
        statusCount = 0;

        $.ajax({
            url: `/kitchen/order/${id}`,
            type: "PUT",
            data: {
                orderid: order.id,
                menus: menuDetail,
                menuid: menuid,
                "_token": "{{ csrf_token() }}"
            },
            success: function(response) {
                let id = $(div).data('key');
                menuCount = 0;
                // console.log(response)
                for(let menu of response) {
                if(menu.menuid == id){
                    if(menu.menu_status == 'Ready' || menu.menu_status == 'Served'){
                        $($('.ready')[menuCount]).text(menu.menu_status);
                        $($('.ready')[menuCount]).removeClass('btn btn-danger');
                        $($('.menu')[menuCount]).css('background-color', '#ccffcc');
                    }
                }
                if(menu.menu_status == 'Ready' || menu.menu_status == 'Served'){
                    statusCount++;
                }
                menuCount++;
            }
                let progress = (statusCount / menuCount) * 100
                $('#status').text(`${parseInt(progress)}`);
            },
            error: function(xhr) {
                console.log('Error:', xhr.responseText);
            }
        });
    }
    }

    let progress = (statusCount / menuCount) * 100
    $('#status').append(`${parseInt(progress)}`);
    
</script>
@endsection