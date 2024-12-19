@extends('dashboard.manager_dashboard')

@section('dashboard')
<div class="main-panel">
    <div class="content-wrapper">
        <a href="/manager/report/purchase" class="btn btn-danger mb-3">< Back</a>
        <h3 class="fs-3 mb-3">Order Detail</h3>

    <div class="col-sm-10 p-0">
        <form action="#" class="mt-4" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-sm-6">
                    <label class="form-label" for='purchasedate'>Order Date</label>
                    <input class="form-control" type='text' name='purchasedate' id='purchasedate' value='{{ $order->orderdate }}'
                        required readonly>
                    </div>
                <div class="col-sm-6">
                    <label class="form-label" for='supplier'>Order Time</label>
                    <input type="text" name="" value="{{$order->ordertime}}" readonly class="form-control" id="">
                </div>
            </div>
            <div class="row">
                @if($table)
                <div class="col-sm-6">
                    <label class="form-label" for='purchasedate'>Table</label>
                    <input class="form-control" type='text' name='purchasedate' id='purchasedate' value='{{ $table->tablenumber }}'
                        required readonly>
                </div>
                @elseif($order->order_token)
                <div class="col-sm-6">
                    <label class="form-label" for='purchasedate'>Table</label>
                    <input class="form-control" type='text' name='purchasedate' id='purchasedate' value='{{ $order->order_token }}'
                        required readonly>
                </div>
                @endif
                <div class="col-sm-6">
                    <label class="form-label" for='supplier'>Waiter</label>
                    <input type="text" name="" value="{{$user->name}}" readonly class="form-control" id="">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <label class="form-label" for='supplier'>Waiter</label>
                    <input type="text" name="" value="{{$type->typename}}" readonly class="form-control" id="">
                </div>
            </div>
    
            <div c lass="menu-list bg-white rounded-3 p-md-5 mt-5">

                <input type="hidden" id="hidden-items" name="hidden-items">
    
                <div class="table-responsive">
                    <table id="#items" class="table table-bordered d-table mt-3">
                        <thead>
                            <tr class="border-1">
                                <th class="ps-3 py-3 vertical-align-middle">No</th>
                                <th class="ps-3 py-3 vertical-align-middle">Menu</th>
                                <th class="ps-3 py-3 vertical-align-middle">Quantity</th>
                                <th class="ps-3 py-3 vertical-align-middle">Price</th>
                                <th class="ps-3 py-3 vertical-align-middle">Unit Total</th>
                            </tr>
                        </thead>
                        <tbody id="item-list">
        
                        </tbody>
                    </table>
                </div>
            </div>
    
            <div class="row">
                <div class="col-sm-6">
                    <label class="form-label" for='total'>Subtotal</label>
                    <input class="form-control" type="text" name="total" step=0.01 value="{{$order->subtotal}}" oninput="getBalance()" min=0 required
                    readonly>
                </div>
                <div class="col-sm-6">
                    <label class="form-label" for='paid_amount'>Discount Amount</label>
                    <input class="form-control" type="number" readonly step=0.01 oninput="getBalance()" value="{{$order->discount}}" min=0 name="paid_amount" id="paid_amount"
                        required>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <label class="form-label" for='balance'>Tax</label>
                    <input class="form-control" type="number" step=0.01 name="balance" value="{{$order->tax}}" min=0 id="balance" required readonly>
                </div>   
                
                <div class="col-sm-6">
                    <label class="form-label" for='total'>Grand Total</label>
                <input class="form-control" type="text" name="total" step=0.01 value="{{$order->grandtotal}}" oninput="getBalance()" min=0 required
                readonly> 
                 </div>
            </div>
        
            <div id="empty" class="text-danger"></div>
        </form>
    </div>
</div>
</div>

    <script>
        var items = {!! json_encode($menus) !!};
        var order = {!! json_encode($order) !!};
        var orderItems = {};

        orderItems = order.menu;
        
        let total = 0;
        let key = 1;
        let totalItems = [];
        $('p').css('display', 'none');
        $('#item-exist').css('display', 'none');

        if(orderItems){
            $('.item-check').css('display', 'none');
            for (let item of orderItems) {
                console.log(item);
                $('#item-list').append(
                    `<tr height='30px' class='border-1' id='item-row' data-key=${key}>
                            <td class='border-1 ps-3'>${key}</td>
                            <input type='hidden' class='itemid' value='${item.pivot.menuid}'>
                            <td class='border-1 ps-3'>${item.menuname?item.menuname:item.itemname}</td>
                            <td class='border-1 ps-3'>${item.pivot.unit_quantity}</td>
                            <td class='border-1 ps-3' id='price'>${item.price}</td>
                            <td class='border-1 ps-3' class='subtotal'>${item.pivot.subtotal}</td>
                        </tr>`
                )
                key++;

            };
        }
        
    </script>
@endsection
