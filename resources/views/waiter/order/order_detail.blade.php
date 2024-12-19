@extends('Layout.layout')

@section('content')
<div class="order d-flex justify-content-center p-3 px-4 rounded-3 mx-3 ">
    {{-- <h1>Detail</h1> --}}
<div class="col-12 col-md-10 col-lg-8">
    <div class="order-detail row">
        <div class="order-input col-md-3 col-sm-5 col-12">
            <label for="id" class="form-label">OrderID</label>
            <input type="text" class="form-control" value="{{$order->id}}" readonly>
        </div>
        @if($table)
        <div class="order-input col-md-3 col-sm-5 col-12">
            <label class="form-label">Table</label>
            <input type="text" class="form-control" value="{{$table->tablenumber}}" readonly>
        </div>
        @else
        <div class="order-input col-md-3 col-sm-5 col-12">
            <label class="form-label">Order Token</label>
            <input type="text" class="form-control" value="{{$order->order_token}}" readonly>
        </div>
        @endif
        <div class="order-input col-md-3 col-sm-5 col-12">
            <label class="form-label">Order Type</label>
            <input type="text" class="form-control" value="{{$type->typename}}" readonly>
        </div>
        <div class="order-input col-md-3 col-sm-5 col-12">
            <label class="form-label">Order Time</label>
            <input type="text" class="form-control" value="{{$order->ordertime}}" readonly>
        </div>
        <div class="order-input col-md-3 col-sm-5 col-12">
            <label class="form-label">Staff</label>
            <input type="text" class="form-control" value="@if($user){{$user->name}}@endif" readonly>
        </div>
    </div>

<div class="my-3"><b>Progress - <span id="status"></span>%</b></div>

<div class="">
    <div id="menu-lists">
    
    </div>
</div>

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
            `<div class='menu py-3 px-sm-5 px-3 my-1 w-100 d-flex justify-content-between border rounded-1' style="box-shadow: 1px 1px 6px -4px grey"  data-key='${menu.id}'>
                <div><span>${menu.pivot.unit_quantity}</span> x <span>${menu.menuname}</span></div>
                <span class='ready'>${menu.pivot.menu_status}</span>
                <span class='btn btn-success serve d-none' onclick='changeStatus(${menu.id})'>Serve</span>
            </div>`
            
        )
        menuDetail.push(menu.pivot);
        if(menu.pivot.menu_status == 'Ready'){
            statusCount++;
            $($('.menu')[menuCount]).css('background-color', '#ccffcc');
            $($('.serve')[menuCount]).removeClass('d-none')
            $($('.ready')[menuCount]).addClass('d-none')
        }
        else if(menu.pivot.menu_status == 'Served') {
            statusCount++;
            $($('.menu')[menuCount]).css('background-color', '#ccffcc');

        }
        else if(menu.pivot.menu_status == 'Cooking'){
            $($('.ready')[menuCount]).addClass('text-danger');
            // $($('.menu')[menuCount]).css('background-color', '#ffee');
        }

        menuCount++;
    }

    function changeStatus(id) {
        let menu = menus.filter(menu => menu.id == id);
        menu[0].pivot.menu_status = 'Served';
        menu = menu[0].pivot;
        let div = event.target.closest('div');

        $.ajax({
            url: `/waiter/order/${id}`,
            type: "PUT",
            data: {
                orderid: order.id,
                menus: menuDetail,
                "_token": "{{ csrf_token() }}"
            },
            success: function(response) {
                let id = $(div).data('key');
                statusCount = 0;
                for(let menu of menuDetail) {
                    
                    if(menu.menuid == id){
                    $(div).children('.ready').text(menu.menu_status);
                    if(menu.menu_status == 'Ready'){
                        statusCount++;
                    }
                    else if(menu.menu_status == 'Served') {
                        statusCount++;
                        $(div).css('background-color', '#ccffcc');
                        $(div).children('.serve').addClass('d-none')
                        $(div).children('.ready').removeClass('d-none')
                    }
                }
                statusCount++;
            }
            },
            error: function(xhr) {
                console.log('Error:', xhr.responseText);
            }

        });
    }

    let progress = (statusCount / menuCount) * 100
    $('#status').append(`${parseInt(progress)}`);
    
</script>
@endsection