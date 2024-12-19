@extends('dashboard.manager_dashboard')

@section('dashboard')
<div class="main-panel">
    <div class="content-wrapper">
        <a href="/manager/purchase" class="btn btn-danger mb-3">< Back</a>
        <h3 class="fs-3 mb-4">Update Purchase</h3>

    <div class="col-10 p-0">
        <form action="/manager/purchase/update/{{$purchase->id}}" class="mt-5" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col">
                    <label class="form-label" for='purchasedate'>Purchase Date</label>
                    <input class="form-control" type='text' name='purchasedate' id='purchasedate' value='{{ $purchase->created_at->toDateString() }}'
                        required readonly>
    
                    <label class="form-label" for='supplier'>Choose Supplier</label>
                    <select name="supplier" id="supplier" class="form-select" required>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ $supplier->id == $purchase->supplier_id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                    <a href="/manager/supplier/create" style="text-decoration:none">Add Supplier</a><br>
                    
                    <label class="form-label" for='supplier'>Purchase Type</label>
                    <input type="text" name="purchase_type" class="form-control" id="purchase_type" value="{{$purchase->purchase_type}}">

                </div>
    
                <div class="col">
                    <label class="form-label" for='invoice_no'>Inovice No</label>
                    <input class="form-control" type="text" name="invoice_no" value="{{$purchase->invoice_no}}" id="invoice_no" required>
    
                    <label class="form-label" for='payment_type'>Payment Type</label>
                    <select name="payment_type" id="payment_type" class="form-select" required>
                        <option value="Cash Payment" {{ $purchase->payment_type == 'Cash Payment' ? 'selected' : '' }}>Cash Payment</option>
                        <option value="Card Payment" {{ $purchase->payment_type == 'Card Payment' ? 'selected' : '' }}>Card Payment</option>
                        <option value="Due Payment" {{ $purchase->payment_type == 'Due Payment' ? 'selected' : '' }}>Due Payment</option>
                    </select>

                    <label class="form-label" for='description'>Description</label>
                    <textarea class="form-control" type="description" name="description" id="description" required>{{$purchase->description}}</textarea>
                </div>
            </div>
    
            <div class="menu-list bg-white rounded-3 p-5 mt-5">
                <h3>Add Items</h3>

                <div class="row">
                    <div class="col-6">
                        <label class="form-label" for='menu'>Items</label>
                        <select name="menu" class="form-select mb-3" id="menu">
                            <option value="" selected>Select Item</option>
                            @foreach ($items as $item)
                                @if($item->menuname && $item->menu_type == 'purchase')
                                    <option value="{{ $item->menuname }}">{{ $item->menuname }}</option>
                                @elseif($item->itemname)
                                <option value="{{ $item->itemname }}">{{ $item->itemname }}</option>
                                @endif
            
                            @endforeach
                        </select>

                        <label class="form-label" for='quantity'>Quantity</label>
                        <input class="form-control" oninput='getSubTotal()' type="number" @if($purchase->purchase_type=='Raw Material Purchase')step=0.1 @endif name="quantity" id="quantity">
                    
                        <label class="form-label" for='subtotal'>Sub Total</label>
                        <input class="form-control" type="text" name="subtotal" id="subtotal" readonly>
                    </div>

                    <div class="col-6">
                        <label class="form-label" for='stock'>Stock</label>
                        <input class="form-control" type="text" readonly name="stock" id="stock">
            
                        @if($purchase->purchase_type == 'Raw Material Purchase')
                        <label class="form-label" for='unit'>Unit</label>
                        <input class="form-control" type="text" readonly name="unit" id="unit">
                        @endif

                        <label class="form-label" for='price'>Price</label>
                        <input class="form-control" oninput='getSubTotal()' type="number" step=0.01 name="price" id="price">
                    </div>
                </div>
    
                <p id="null" class="mt-3 text-danger">* Fill Item Details!</p>
                <input type="button" id="add" class="btn btn-danger mt-3 mb-3" name="submit" value="Add Item">
    
                <p class="text-danger fs-6" id="item-exist">Item already added.</p>

                <input type="hidden" id="hidden-items" name="hidden-items">
    
                <div class="table-responsive">
                    <table id="#items" class="table table-bordered d-table mt-3" style="table-layout: fixed">
                        <thead>
                            <tr class="border-1">
                                <th class="ps-3 py-3 vertical-align-middle">Item</th>
                                <th class="ps-3 py-3 vertical-align-middle">Stock</th>
                                <th class="ps-3 py-3 vertical-align-middle">Quantity</th>
                                <th class="ps-3 py-3 vertical-align-middle">Price</th>
                                <th class="ps-3 py-3 vertical-align-middle">Cost</th>
                                <th class="ps-3 py-3 vertical-align-middle">Action</th>
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
                <div class="col-6">
                    <label class="form-label" for='paid_amount'>Paid Amount</label>
                <input class="form-control" type="number" step=0.01 oninput="getBalance()" value="{{$purchase->paid_amount}}" min=0 name="paid_amount" id="paid_amount"
                    required>
                </div>
        
               <div class="col-6">
                <label class="form-label" for='balance'>Balance</label>
                    <input class="form-control" type="number" step=0.01 name="balance" value="{{$purchase->balance}}" min=0 id="balance" required readonly>
                </div>        
            </div>
            <div id="empty" class="text-danger"></div>
    
            <input class="btn btn-danger mt-3" type='submit' id="submit" onclick="handlePurchase()" value='Purchase'>
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
        
        function handlePurchase() {
            if ($('#hidden-items').val() == '') {
                event.preventDefault();
                $('#empty').text('Please add items to purchase');
            }
            else{
                $('#empty').text('');
            }
        }

        function getSubTotal() {
            let quantity = $('#quantity').val();
            let price = $('#price').val();
            if (quantity && price) {
                let subtotal = quantity * price;
                $('#subtotal').val(subtotal.toFixed(2));
            }
            return;
        }

        let total = 0;
        let key = 0;
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
                            <td class='border-1 ps-3'>${item.menuname?item.menuname:item.itemname}</td>
                            <td class='border-1 ps-3'>${item.quantity}</td>
                            <td class='border-1 ps-3'><input type="number" class='rquantity' ${purchase.purchase_type=='Raw Material Purchase'?'step=0.1':''} style="border:none; outline:none; width:80%" data-key=${key} value='${item.pivot.quantity}' min=0></td>
                            <td class='border-1 ps-3' id='price'><input type="number" step-0.01 class='rprice' style="border:none; outline:none; width:80%" data-key=${key} value='${item.pivot.price}' min=0></td>
                            <td class='border-1 ps-3' class='subtotal'><input type="number" step-0.01 class='rsubtotal' readonly style="border:none; outline:none; width:80%" data-key=${key} value='${item.pivot.subtotal}' min=0></td>
                            <td class='border-1 ps-3'><p class='remove text-danger m-0 d-block' role='button'>Remove</p></td>
                        </tr>`
                )
                total = purchase.total;
                $('#total').val(total);
            };
        }

        if (totalItems.length == 0) {
            $('#item-list').append(
                '<td colSpan=6 class="empty p-3 text-center">No Item is added to the purchase.</td>'
            )
        }


        $('#add').click(() => {
            $('.item-check').css('display', 'none');
            $('.item-check').css('display', 'none');
            $('table').css({
                'display': 'block'
            });
            let name = $('#menu').val();
            let stock = $('#stock').val();
            let quantity = $('#quantity').val();
            let price = $('#price').val();
            let subtotal = $('#subtotal').val();
            
            if (!name || !quantity || !price || !subtotal) {
                !name ? $('#menu').addClass(' is-invalid') : $('#menu').removeClass(' is-invalid');
                !quantity ? $('#quantity').addClass(' is-invalid') : $('#quantity').removeClass(' is-invalid');
                !price ? $('#price').addClass(' is-invalid') : $('#price').removeClass(' is-invalid');
                $('p').css('display', 'block');
                $('#item-exist').css('display', 'none');
            } else {
            $('#submit').prop('disabled', false);
            const item = items.filter(item => item.menuname ? item.menuname == name : item.itemname == name);

            let isExisted = false;
            for (let count of totalItems) {
                if (count.id === item[0].id) {
                    isExisted = true;
                    $('#item-exist').css('display', 'block');
                    $('#stock').val('');
                    $('#price').val('');
                    $('#quantity').val('');
                    $('#subtotal').val('');
                    return;
                }
                else{
                    isExisted = false;
                    $('#item-exist').css('display', 'none');

                }
            }
            if (!isExisted) {
                key++;
                totalItems.push({
                    'id': item[0].id,
                    'quantity': quantity,
                    'price': price,
                    'subtotal': subtotal
                });

                $('#hidden-items').val(JSON.stringify(totalItems));
                $('#menu').removeClass(' is-invalid');
                $('#quantity').removeClass(' is-invalid');
                $('#price').removeClass(' is-invalid');
                $('p').css('display', 'none');

                total += parseFloat(subtotal);

                $('#item-list').append(
                    `<tr height='30px' class='border-1' id='item-row' data-key=${key}>
                        <input type='hidden' class='itemid' value='${item[0].id}'>
                        <td class='border-1 ps-3'>${name}</td>
                        <td class='border-1 ps-3'>${stock}</td>
                        <td class='border-1 ps-3'><input type="number" class='rquantity' ${purchase.purchase_type=='Raw Material Purchase'?'step=0.1':''} style="border:none; outline:none; width:80%" data-key=${key} value='${quantity}' min=0></td>
                        <td class='border-1 ps-3' id='price'><input type="number" step-0.01 class='rprice' style="border:none; outline:none; width:80%" data-key=${key} value='${price}' min=0></td>
                        <td class='border-1 ps-3' class='subtotal'><input type="number" step-0.01 class='rsubtotal' style="border:none; outline:none; width:80%" data-key=${key} value='${subtotal}' min=0></td>
                        <td class='border-1 ps-3'><p class='remove text-danger m-0 d-block' role='button'>Remove</p></td>
                    </tr>`
                );
                $('#total').val(total.toFixed(2));
                $('#menu').val('');
                $('#quantity').val('');
                $('#price').val('');
                $('#subtotal').val('');
                getBalance();
            }

                $('.remove').unbind().click((event) => {
                    removeItems();
                })

                $('.rquantity').unbind().change((event) => {
                    updateQuantity('quantity');
                });

                $('.rprice').unbind().change((event) => {
                    updateQuantity('price');
                });
            }
        })

        $('.remove').unbind().click((event) => {
            removeItems();
        })

        $('.rquantity').unbind().change((event) => {
            updateQuantity('quantity');
        });

        $('.rprice').unbind().change((event) => {
            updateQuantity('price');
        });

        function removeItems() {
            event.preventDefault();
            const row = event.target.closest('tr');
            $('#item-exist').css('display', 'none');

            if (row) {
                const index = row.attributes['data-key'].value;
                totalItems.splice(0, 1);
                $('#hidden-items').val(JSON.stringify(totalItems));
                row.remove();

                total = 0;
                for (material of totalItems) {
                    total += parseInt(material.subtotal);
                }
                getBalance();
                $('#total').val(total);
                if ($('#item-list tr').length == 0) {
                    $('#item-list').append(
                        '<td colSpan=6 class="p-3 text-center item-check">No Item is added to the purchase.</td>'
                    )
                    $('#submit').prop('disabled', true);
                }
            }
        }

        function updateQuantity(input) {
            let row = event.target.closest('tr');
                let rquantity = $(row).find('.rquantity').val();
                let rsubtotal = $(row).find('.rsubtotal');
                let rprice = $(row).find('.rprice').val();
                let itemid = $(row).find('.itemid').val();
                subtotal = 0;
                if(input == 'quantity'){
                    let quantity = event.target.value;
                    subtotal = parseFloat(rprice) * parseFloat(quantity);
                    totalItems.filter(item => {
                    if (item.id == itemid) {
                        item.quantity = quantity;
                        item.subtotal = subtotal;
                    }
                });
                }
                else{
                    let price = event.target.value;
                    subtotal = parseFloat(price) * parseFloat(rquantity);
                    totalItems.filter(item => {
                    if (item.id == itemid) {
                        item.price = price;
                        item.subtotal = subtotal;
                    }
                });
                }
                rsubtotal.val(subtotal.toFixed(2));
                
                total = 0;
                for (material of totalItems) {
                    total += parseFloat(material.subtotal);
                }
                $('#total').val(total.toFixed(2));
                getBalance()
                $('#hidden-items').val(JSON.stringify(totalItems));
        }
        
        
        function getBalance() {
            if ($('#total').val() && $('#paid_amount').val()) {
                let balance = $('#total').val() - $('#paid_amount').val();
                $('#balance').val(balance.toFixed(2));
            }
        }
    </script>
@endsection
