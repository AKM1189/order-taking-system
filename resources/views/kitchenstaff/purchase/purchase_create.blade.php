@extends('Layout.kitchen_layout')

@section('content')
<div class="d-flex justify-content-center">
    <div class="p-md-5 py-5 px-3 my-3 col-11 bg-light rounded-2">
        <div class="content-wrapper">
            <h3 class="fs-3 mb-4">Add Purchase</h3>
    
        <div class="p-0">
            <form action="/kitchen/purchase/create/{{$itemtype}}" class="mt-5" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-sm-6">
                        <label class="form-label" for='purchasedate'>Purchase Date</label>
                        <input class="form-control" type='text' name='purchasedate' id='purchasedate' value='{{ $date }}'
                            required readonly>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for='supplier'>Choose Supplier</label>
                        <select name="supplier" id="supplier" class="form-select" required>
                            <option value="">Choose Supplier</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6">    
                        <label class="form-label" for='description'>Description</label>
                        <textarea class="form-control" type="description" name="description" id="description" required></textarea>
    
                    </div>
        
                    <div class="col-sm-6">
                        <label class="form-label" for='invoice_no'>Inovice No</label>
                        <input class="form-control" type="text" name="invoice_no" id="invoice_no" required>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for='payment_type'>Payment Type</label>
                        <select name="payment_type" id="payment_type" class="form-select" required>
                            <option value="">Choose Payment Type</option>
                            <option value="Cash Payment">Cash Payment</option>
                            <option value="Card Payment">Card Payment</option>
                            <option value="Due Payment">Due Payment</option>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for='supplier'>Purchase Type</label>
                        <input type="text" name="purchase_type" class="form-control" id="purchase_type" value="{{$itemtype=='menu'? 'Menu Purchase' : 'Raw Material Purchase'}}" readonly>
                    </div>
                </div>
        
                <div class="menu-list bg-white rounded-3 p-md-5 px-3 py-5  mt-5">
                    <h3>Add Items</h3>
                    <div class="row">
                        <div class="col-sm-6">
                            <label class="form-label" for='menu'>Items</label>
                            <select name="menu" class="form-select mb-2" id="menu">
                                <option value="" selected>Select Item</option>
                                @foreach ($items as $item)
                                    @if($item->menuname && $item->menu_type == 'purchase')
                                        <option value="{{ $item->menuname }}">{{ $item->menuname }}</option>
                                    @elseif($item->itemname)
                                    <option value="{{ $item->itemname }}">{{ $item->itemname }}</option>
                                    @endif
                
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for='quantity'>Quantity</label>
                            <input class="form-control" @if($itemtype=='raw_material')step=0.1 @endif oninput='getSubTotal()' type="number" step-0.01 name="quantity" id="quantity">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for='price'>Price</label>
                            <input class="form-control" oninput='getSubTotal()' type="number" step-0.01 name="price" id="price">
                        </div>
    
                        <div class="col-sm-6">
                            <label class="form-label" for='stock'>Stock</label>
                            <input class="form-control" type="text" readonly name="stock" id="stock">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for='subtotal'>Sub Total</label>
                            <input class="form-control" type="text" name="subtotal" id="subtotal" readonly>
    
                        </div>
                        
                        @if($itemtype == 'raw_material')
                        <div class="col-sm-6">
                            <label class="form-label" for='unit'>Unit</label>
                            <input class="form-control" type="text" readonly name="unit" id="unit">
                        </div>
                        @endif
                        
                    </div>
                    <p id="null" class="mt-3 text-danger">* Fill Item Details!</p>
                    <input type="button" id="add" class="btn btn-danger mt-3 mb-3" name="submit" value="Add Item">
                    
                    
        
                    <p class="text-danger fs-6" id="item-exist">Item already added.</p>
    
                    <input type="hidden" id="hidden-items" name="hidden-items">
        
                    <div class="table-responsive">
                        <table id="#items" class="table table-bordered d-table mt-3">
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
        
        
                <label class="form-label mt-5" for='total'>Total</label>
                <input class="form-control" type="text" name="total" oninput="getBalance()" id="total" min=0 required
                readonly>
        
                <div class="row">
                    <div class="col-sm-6"> 
                        <label class="form-label" for='paid_amount'>Paid Amount</label>
                    <input class="form-control" type="number" step-0.01 oninput="getBalance()" min=0 name="paid_amount" id="paid_amount"
                        required>
                    </div>
            
                    <div class="col-sm-6">
                        <label class="form-label" for='balance'>Balance</label>
                    <input class="form-control" type="number" step-0.01 name="balance" min=0 id="balance" required readonly>
                    </div>
                </div>
                <div id="empty" class="text-danger"></div>
        
                <input class="btn btn-danger mt-3" type='submit' onclick="handlePurchase()" id="submit" value='Purchase'>
            </form>
        </div>
    </div>
    </div>
</div>
    <script>
        var items = {!! json_encode($items) !!};

        $('#menu').change(() => {
            let selected = $('#menu option:selected').text();
            const value = items.filter(item => item.menuname ? item.menuname == selected : item.itemname == selected);
            $('#stock').val(value[0].quantity);
            $('#unit').val(value[0].unit);
        })

        if ($('#item-list tr').length == 0) {
            $('#item-list').append('<td colSpan=6 class="item-check p-3 text-center">No Item is added to the purchase.</td>')
            // $('#submit').prop('disabled', true);
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
console.log($('#hidden-items').val());
function handlePurchase() {
    if ($('#hidden-items').val() == '') {
        event.preventDefault();
        $('#empty').text('Please add items to purchase');
    }
    else{
        $('#empty').text('');
    }
}

        $('#add').click(() => {
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
            // $('#submit').prop('disabled', false);
            const item = items.filter(item => item.menuname ? item.menuname == name : item.itemname == name);
            let isExisted = false;
            for (let count of totalItems) {
                if (count.id === item[0].id) {
                    isExisted = true;
                    $('#item-exist').css('display', 'block');
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

                total += parseInt(subtotal);

                $('#item-list').append(
                    `<tr height='30px' class='border-1' id='item-row' data-key=${key}>
                        <td class='border-1 ps-3'>${name}</td>
                        <td class='border-1 ps-3'>${stock}</td>
                        <td class='border-1 ps-3'>${quantity}</td>
                        <td class='border-1 ps-3'>${price}</td>
                        <td class='border-1 ps-3' id='subtotal'>${subtotal}</td>
                        <td class='border-1 ps-3'><p class='remove text-danger m-0 d-block' role='button'>Remove</p></td>
                    </tr>`
                );
                $('#total').val(total);
                $('#menu').val('');
                $('#quantity').val('');
                $('#price').val('');
                $('#subtotal').val('');
            }

                $('.remove').unbind().click((event) => {
                    event.preventDefault();
                    const row = event.target.closest('tr');
                    if (row) {
                        const index = row.attributes['data-key'].value;
                        totalItems.splice(0, 1);
                        $('#hidden-items').val(JSON.stringify(totalItems));
                        row.remove();
                        total = total - parseInt($(row).find('#subtotal').text());
                        $('#total').val(total);
                        if ($('#item-list tr').length == 0) {
                            $('#item-list').append(
                                '<td colSpan=6 class="p-3 text-center item-check">No Item is added to the purchase.</td>'
                            )
                        }
                    }
                })
            }
        })

        function getBalance() {
            if ($('#total').val() && $('#paid_amount').val()) {
                let balance = $('#total').val() - $('#paid_amount').val();
                $('#balance').val(balance);
            }
        }
    </script>
@endsection
