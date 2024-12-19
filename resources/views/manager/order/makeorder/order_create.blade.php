@extends('Layout.layout')

@section('content')
<div class="content" style=" overflow:hidden">
    {{-- <h1>Order</h1> --}}

    <div class="row">
        <div class="col-lg-7">
            <div class="col-12 pb-1 pt-2 bg-light">
                <div class="search-bar row">
                    <div class="d-flex col-sm-4 col-12 mb-2">
                        <div><a href="/waiter" class="btn btn-danger">Back</a></div>
                        <div><a href="/waiter/order/create/ordertype={{$ordertype}}@if($tableno)&tableno={{$tableno}}@endif" class="btn btn-danger px-3 ms-3">All Menu</a></div>
                    </div>
    
                    <div class="col-sm-4 mb-2 col-10">
                        <select name="category" class="form-select" id="category">
                            <option id="show-all" selected>All Menus</option>
                            @foreach ($categories as $category)
                                <option id='filter' value="{{$category->categoryname}}">{{ $category->categoryname }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-4 col-10">
                        <form action="/waiter/order/create/ordertype={{$ordertype}}@if($tableno)&tableno={{$tableno}}@endif" class="w-100" method="get">
                            <div class="input-group">
                                <input type="text" class="form-control w-100" name="search" placeholder="Search Menu"
                                    id="" autocomplete='off'>
                            </div>                      
                        </form>
                    </div>
                </div>
            </div>
    
            <div class="bg-light user-select-none" style="height: 468px; overflow-y:scroll;">
                @foreach($menus as $menu)
                    <div class="record p-1 rounded-2 my-1 order" style="display: inline-block; z-index: 99; position: relative; background-color: rgb(246, 246, 246); border: 1px solid rgb(221, 221, 221)" onclick="handleOrder(event)" data-key={{$menu->id}} role="button">
                        <div onclick="handleOrder(event)">
                            <img src="/storage/menu_images/{{$menu->menuimage}}" class="menu-image rounded-1" style="position: relative; z-index: -1;"  width="150px" height="130px" alt="{{$menu->menuname}}" title="{{$menu->menuname}}">
                        </div>
                        <div class="" style="font-size: 14px" onclick="handleOrder(event)" style="z-index: -1; position: relative;">
                            <div class="menuname">{{$menu->menuname}}</div><div>${{$menu->price}}</div>
                        </div>
                        <div class="category-id d-none">{{$menu->category_id}}</div>
                        <div data-key={{$menu->id}} class="stock-out position-absolute top-0 start-0 text-center verticle-align-middle" style="width: 100%; height: 100%; background-color:rgba(255, 255, 255, 0.7)"><p style="position: relative; user-select: none; color: red; top:35%">Unavailable</p></div>
                    </div>
                @endforeach
            </div>
        </div>
        
        <div class="col-lg-5 px-2">
            <div class="col-12 pt-1 pe-1">
                <form action="/waiter/order/create/ordertype={{$ordertype}}@if($tableno)&tableno={{$tableno}}@endif" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="d-flex justify-between"> 
                        <div class="w-100 p-1">
                            @if($tableno)
                            <label for="" class="form-label">Table No</label>
                            <input type="text" class="form-control" value='{{$tableno}}' name="table_no" readonly><br>
                            @else
                            <label for="" class="form-label">Order Token</label>
                            <input type="text" class="form-control" value='' name="token" required><br>
                            @endif
                        </div>
                        <div class="px-1"></div>
                        <div class="w-100">
                            <label for="" class="form-label">Order Type</label>
                            <input type="text" class="form-control" value='{{$ordertype}}' name="order_type" readonly><br>
                        </div> 
                        <div class="px-1"></div>
    
                        <div class="w-100">
                            <label for="" class="form-label">Waiter</label>
                            @if($user)
                            <input type="text" class="form-control" value='{{$user->name}}' name="waiter" readonly><br>
                            @endif
                        </div>            
                    </div>
            

                    <div class="table-responsive" style="height: 280px; overflow-y:scroll;">
                        <table class="table order-list table-bordered mt-3 pe-1" style="width: 100%; font-size:13px" class="my-3">
                            <thead>
                                <tr>
                                    {{-- <th class="py-3" style="width:25%; padding-left:10px">Menu ID</th> --}}
                                    <th class="">Menu</th>
                                    <th class="">Price</th>
                                    <th class="">Quanity</th>
                                    <th class="">Total</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="item-list">
                            </tbody>
                            <input id="hidden-items" class="d-none" required name="hidden-items">
                    
                        </table>
                        <div class="text-center cart opacity-25 mt-5 user-select-none" style="margin-top: -100px"><img src="/storage/logo/cart1.png" width="60px" height="60px"/><p class="mt-1">Cart Empty</p></div>
                    </div>
    
    
    
            </div>
            
            <div class="col-11">
                <div class="d-flex">
                    <div class="col-4">
                        <div class="p-2 rounded-1 px-2 me-1" class="bg-secondary" style="background-color:rgb(236, 236, 236); font-size: 14px"><span>Subtotal:</span>
                            <span>$ <input type="number" step="0.01" id="total" name="total" readonly value="0" style="outline:none; border:none; width: 30%; background:transparent"></span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-2 rounded-1 px-2" style="background-color:rgb(236, 236, 236); font-size: 14px"><span>Discount (%):</span>
                            <input type="number" step="0.01" class="bg-transparent" onchange="calculateGTotal()" min=0 style="outline:none; border:none; width: 30%;" value=0 id="discount" name="discount">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-2 rounded-1 px-2 ms-1" style="background-color:rgb(236, 236, 236); font-size: 14px"><span>Tax (%):</span>
                            <input type="number" step="0.01" class="bg-transparent" onchange="calculateGTotal()" min=0 style="outline:none; border:none; width: 30%;" value=2 id="tax" name="tax">
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <div class="p-2 rounded-1" style="background-color:rgb(236, 236, 236); font-size: 20px"><span>Grand Total:</span> <span class="ms-3 p-0">$ <input type="number" step="0.01" class="bg-transparent" style="outline:none; border:none; width: 30%;" readonly name="grand-total" id="grand-total" value="0"></span></div>
                </div>
                <div class="mt-2">
                <input type="submit" class="btn btn-danger" value="Place Order">
                </div>
            </form>

            </div>
        </div> 
    </div>

</div>
<script>
    var materials = {!! json_encode($menus) !!};
    var categories = {!! json_encode($categories) !!};

    let count = 0;
    for(let menu of materials){
        if(menu.quantity <= 0){
            $($('.stock-out')[count]).css('display', 'block');
        }
        else{
            $($('.stock-out')[count]).css('display', 'none');
            
        }
        count++;
        }

    $('#category').change(function() {
        let records = $('.record');
        let categoryid = $('.category-id');
        let categoryName = "";
        
        let value = $('#category option:selected').text();

        records.each((index, record) => {
            if (value == 'All Menus') {
                $(record).show();
            } else {
                for(let category of categories){
                category.id == $(categoryid[index]).text().trim() ? categoryName = category.categoryname : ""
            }
                $(record).toggle(categoryName == value);
            }
        })
    })

                        let totalItems = [];
                        let key = 0;
                        let total = 0;
                        let discount = $('#discount').val();
                        let tax = $('#tax').val();
                        let grandTotal = $('#grand-total').val();

                        if ($('#item-list').empty()) {
                            $('.cart').css('display', 'block');
                            $('.order-list').css('display', 'none');
                            $('#tax').attr('readonly', true);
                            $('#discount').attr('readonly', true);
                        }

                        function handleOrder(e) {
                            if ($($(e.target).parent()).attr('data-key')) {
                                $('.empty').css('display', 'none');
                                $('.check-menu').css('display', 'none');
                                $('#tax').attr('readonly', false);
                                $('#discount').attr('readonly', false);

                                let id = $($(e.target).parent()).attr('data-key');
                                let subtotal = 0;
                                let quantity = 1;
                                let item = materials.filter(item => item.id == id);

                                let isExisted = false;
                                for (let count of totalItems) {
                                    if (count.id === item[0].id) {
                                        isExisted = true;
                                    }
                                }
                                if (!isExisted && item[0].quantity > 0) {
                                    key++;
                                    $('.order-list').css('display', 'table');
                                    $('.cart').css('display', 'none');
                                    let price = item[0].price;
                                    // console.log(price);
                                    subtotal = quantity * price;
                                    total += subtotal;
                                    grandTotal = total + total * ( tax / 100) - total * (discount / 100);
                                    totalItems.push({
                                        'id': item[0].id,
                                        // 'note' : 
                                        'quantity': quantity,
                                        'subtotal': subtotal,
                                    });
                                    $('#total').val(total);
                                    $('#grand-total').val(grandTotal.toFixed(2));

                                    $('#hidden-items').val(JSON.stringify(totalItems));
                                    // <td class='border-1 ps-2'><input type="number" class='rquantity' style="border:none; outline:none" data-key=${key} value='${price}' min=0></td>
                                    $('#item-list').append(
                                        `<tr id='item-row' data-key=${key}>
                                            <input type='hidden' class='itemid' value='${item[0].id}'>
                                            <td>${item[0].menuname}</td>
                                            <td class='rprice'  id='price'>${item[0].price}</td>
                                            <td><input type="number" class='rquantity' style="border:none; width:60%; outline:none" data-key=${key} value='${quantity}' min=1 max=${item[0].quantity}></td>
                                            <td id='subtotal'>${subtotal}</td>
                                            <td><div class="d-flex justify-content-around"><span class='remove text-danger m-0' role='button'><i class="fa-regular fa-trash-can"></i></span><span role='button'><i class="fa-regular fa-pen-to-square"></i></span></div></td>
                                        </tr>`
                                    )
                                }

                                $('.rquantity').unbind().change((event) => {
                                    let row = event.target.closest('tr');
                                    let rquantity = event.target.closest('input', $('.rquantity').get(0));
                                    let rsubtotal = $(row).find('#subtotal');
                                    let rprice = $(row).find('.rprice').text();
                                    let itemid = $(row).find('.itemid').val();
                                    quantity = event.target.value;
                                    subtotal = 0;
                                    subtotal = parseInt(rprice) * quantity;
                                    rsubtotal.text(subtotal);
                                    totalItems.filter(item => {
                                        if (item.id == itemid) {
                                            item.quantity = quantity;
                                            item.subtotal = subtotal;
                                        }
                                    });
                                    total = 0;
                                    for (material of totalItems) {
                                        total += material.subtotal;
                                    }

                                    $('#total').val(total);
                                    calculateGTotal();
                                    $('#hidden-items').val(JSON.stringify(totalItems));
                                });

                                $('.remove').unbind().click((event) => {
                                    event.preventDefault();
                                    const row = event.target.closest('tr');
                                    if (row) {
                                        let itemid = $(row).find('.itemid').val();
                                        totalItems = totalItems.filter(item => item.id != itemid);
                                        $('#hidden-items').val(JSON.stringify(totalItems));
                                        total = 0;
                                        for (material of totalItems) {
                                            total += material.subtotal;
                                        }
                                        $('#total').val(total);
                                        calculateGTotal()
                                        row.remove();
                                        if ($('#item-list tr').length == 0) {
                                            $('.cart').css('display', 'block');
                                            $('.order-list').css('display', 'none');
                                            $('#tax').attr('readonly', true);
                                            $('#discount').attr('readonly', true);
                                        }
                                    }
                                })
                            }
                        }

                        function calculateGTotal() {
                            let total = parseFloat($('#total').val());
                            let discount = $('#discount').val();
                            let tax = $('#tax').val();
                            console.log(total, discount, tax)
                            let grandTotal = total + total * ( tax / 100) - total * (discount / 100);
                            $('#grand-total').val(grandTotal.toFixed(2));
                        }
</script>
@endsection

