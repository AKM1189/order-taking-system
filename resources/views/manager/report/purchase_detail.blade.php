@extends('dashboard.manager_dashboard')

@section('dashboard')
<div class="main-panel">
    <div class="content-wrapper">
        <a href="/manager/report/purchase" class="btn btn-danger mb-3">< Back</a>
        <h3 class="fs-3 mb-3">Purchase Detail</h3>

    <div class="col-sm-12 col-md-10 p-0">
        <form action="#" class="mt-4" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-sm-6">
                    <label class="form-label" for='purchasedate'>Purchase Date</label>
                    <input class="form-control" type='text' name='purchasedate' id='purchasedate' value='{{ $purchase->created_at->toDateString() }}'
                        required readonly>
                </div>
                <div class="col-sm-6">
                    <label class="form-label" for='supplier'>Choose Supplier</label>
                    <input type="text" name="" value="{{$supplier->name}}" readonly class="form-control" id="">
                </div>  
                <div class="col-sm-6">
                    <label class="form-label" for='supplier'>Purchase Type</label>
                    <input type="text" name="purchase_type" class="form-control" readonly id="purchase_type" value="{{$purchase->purchase_type}}">
                </div>
                <div class="col-sm-6">
                    <label class="form-label" for='invoice_no'>Inovice No</label>
                    <input class="form-control" type="text" name="invoice_no" readonly value="{{$purchase->invoice_no}}" id="invoice_no" required>
                </div>
                <div class="col-sm-6">

                    <label class="form-label" for='payment_type'>Payment Type</label>
                    <input type="text" name="" value="{{$purchase->payment_type}}" readonly class="form-control" id="">
                </div>
                <div class="col-sm-6">
                    <label class="form-label" for='description'>Description</label>
                    <textarea class="form-control" type="description" readonly name="description" id="description" required>{{$purchase->description}}</textarea>
                </div>
            </div>
    
            <div class="menu-list bg-white rounded-3 mt-3 mb-3">

                <input type="hidden" id="hidden-items" name="hidden-items">
    
                <div class="table-responsive">
                    <table id="#items" class="table table-bordered d-table m-0">
                        <thead>
                            <tr class="border-1">
                                <th class="ps-3 py-3 vertical-align-middle">No</th>
                                <th class="ps-3 py-3 vertical-align-middle">Item</th>
                                <th class="ps-3 py-3 vertical-align-middle">Stock</th>
                                <th class="ps-3 py-3 vertical-align-middle">Quantity</th>
                                <th class="ps-3 py-3 vertical-align-middle">Price</th>
                                <th class="ps-3 py-3 vertical-align-middle">Cost</th>
                            </tr>
                        </thead>
                        <tbody id="item-list">
        
                        </tbody>
                    </table>
                </div>
            </div>
    
    
            <label class="form-label" for='total'>Total</label>
            <input class="form-control" type="text" name="total" step=0.01 value="{{$purchase->total}}" oninput="getBalance()" id="total" min=0 required
            readonly>
    
            <div class="row">
                <div class="col-sm-6">
                    <label class="form-label" for='paid_amount'>Paid Amount</label>
                <input class="form-control" type="number" readonly step=0.01 oninput="getBalance()" value="{{$purchase->paid_amount}}" min=0 name="paid_amount" id="paid_amount"
                    required>
                </div>
        
               <div class="col-sm-6">
                <label class="form-label" for='balance'>Balance</label>
                    <input class="form-control" type="number" step=0.01 name="balance" value="{{$purchase->balance}}" min=0 id="balance" required readonly>
                </div>        
            </div>
            <div id="empty" class="text-danger"></div>
        </form>
    </div>
</div>
</div>

    <script>
        var items = {!! json_encode($items) !!};
        var purchase = {!! json_encode($purchase) !!};
        var purchaseItems = {};

        if(purchase.purchase_type == 'Menu Purchase'){
            purchaseItems = purchase.menu;
        }
        else if(purchase.purchase_type == 'Raw Material Purchase'){
            purchaseItems = purchase.raw_material;
        }

        $('#menu').change(() => {
            let selected = $('#menu option:selected').text();
            const value = items.filter(item => item.menuname ? item.menuname == selected : item.itemname == selected);
            $('#stock').val(value[0].quantity);
            $('#unit').val(value[0].unit);
        })

        if ($('#item-list tr').length == 0) {
            $('#item-list').append('<td colSpan=5 class="item-check p-3 text-center">No Item is added to the purchase.</td>')
            $('#submit').prop('disabled', true);
        }
    

        let total = 0;
        let key = 1;
        let totalItems = [];
        $('p').css('display', 'none');
        $('#item-exist').css('display', 'none');

        for (let item of purchaseItems) {
        totalItems.push({
            'id': item.id,
            'price': item.pivot.price,
            'quantity': item.pivot.quantity,
            'subtotal': item.pivot.subtotal,
        });
        }

        if(totalItems){
            $('#hidden-items').val(JSON.stringify(totalItems));
            $('#submit').prop('disabled', false);
        }
        if(purchaseItems){
            $('.item-check').css('display', 'none');
            for (let item of purchaseItems) {
                console.log(item);
                $('#item-list').append(
                    `<tr height='30px' class='border-1' id='item-row' data-key=${key}>
                            <input type='hidden' class='itemid' value='${item.pivot.menu_id?item.pivot.menu_id:item.pivot.material_id}'>
                            <td class='border-1 ps-3'>${key}</td>
                            <td class='border-1 ps-3'>${item.menuname?item.menuname:item.itemname}</td>
                            <td class='border-1 ps-3'>${item.quantity}</td>
                            <td class='border-1 ps-3'>${item.pivot.quantity}</td>
                            <td class='border-1 ps-3' id='price'>${item.pivot.price}</td>
                            <td class='border-1 ps-3' class='subtotal'>${item.pivot.subtotal}</td>
                        </tr>`
                )
                total = purchase.total;
                $('#total').val(total);
                key++;
            };
        }

        if (totalItems.length == 0) {
            $('#item-list').append(
                '<td colSpan=6 class="empty p-3 text-center">No Item is added to the purchase.</td>'
            )
        }
        
    </script>
@endsection
