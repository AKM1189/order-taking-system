@extends('dashboard.manager_dashboard')

@section('dashboard')
<div class="main-panel">
    <div class="content-wrapper">
        <a href="/manager/menu" class="btn btn-danger mb-3">< Back</a>
        <h3 class="fs-3 mb-4">Update Menu</h3>
        <div class="col-10 p-0">
            <form action="/manager/menu/update/{{ $menu->id }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-6">
                        <label for='menuname' class="form-label">Menu Name</label>
                <input type='text' name='menuname' class="form-control" value='{{ $menu->menuname }}' id='menuname' required>
    
                <label for='description' class="form-label">Description</label>
                <input type="text" name="description" class="form-control" value='{{ $menu->description }}' id="description" required>
    
                <label for='quantity' class="form-label">Menu Quantity</label>
                <input type="number" name="quantity" class="form-control" value='{{ $menu->quantity }}' readonly id="quantity" required>
                    </div>

                    <div class="col-6">
                        <label for="category" class="form-label">Category</label>
                <select name="category" class="form-select" id="category" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->id == $menu->category_id ? 'selected' : '' }}>
                            {{ $category->categoryname }}</option>
                    @endforeach
                </select>
                <a href="/manager/category/create" class="text-decoration-none">Add Category</a><br>
    
                <label for="menu-type" class="form-label">Preparation Type</label>
                <select name="menu-type" class="form-select" id="menu-type" required>
                    <option value="cook" {{ $menu->menu_type == 'cook' ? 'selected' : '' }}>Cook</option>
                    <option value="purchase" {{ $menu->menu_type == 'purchase' ? 'selected' : '' }}>Purchase</option>
                </select>
    
                <label for='status' class="form-label">Item Status</label>
                <input type="text" class="form-control" name="status" id="status" value="{{$menu->status}}" readonly>

                    </div>
                </div>
    
                
    
    
                <label for="material" class="form-label">Ingredient</label>
                <select name="material" class="form-select" id="material">
                    <option value="">Select Ingredients</option>
                    @foreach ($materials as $material)
                        <option value="{{ $material->id }}">{{ $material->itemname }}</option>
                    @endforeach
                </select>
    
                <div class="table-responsive">
                    <table class="table table-bordered mt-3" style="width:100%; font-size:13px" class="my-3">
                        <thead>
                            <tr>
                                <th class="py-3" style="width:25%; padding-left:10px">Item Name</th>
                                <th class="py-3" style="width:25%">Consumption Quantity</th>
                                <th class="py-3" style="width:10%">Unit</th>
                                <th class="py-3" style="width:10%">Price</th>
                                <th class="py-3" style="width:12%">SubTotal</th>
                                <th class="py-3" style="width:12%">Action</th>
                            </tr>
                        </thead>
                        <tbody id="item-list">
                        </tbody>
                        <input type="hidden" id="hidden-items" name="hidden-items">
        
                        <td colspan=4><b>Total Cost</b></td>
                        <td colspan=2><input type="number" style="outline:none; border:none" step='0.01' readonly value=0 id="total"
                                name="total"></td>
                    </table>
                </div>
    
                <label for='price' class="form-label">Menu Price</label>
                <input type="number" name="price" step="0.01" required value='{{ $menu->price }}' class="form-control" id="price">

                <label for='menuimage' class="form-label">Menu Image</label><br>
                <input type="file" name="menuimage" id="menuimage" class="form-control-file"
                    onchange="previewPhoto('/storage/menu_images/{{ $menu->menuimage }}')">
                <div class="d-flex justify-content-center">
                    <img src="/storage/menu_images/{{ $menu->menuimage }}" class="my-3" onclick="openimage()"
                        id="uploadimage" style="width:200px; max-height:200px" alt="menu">
                </div>
    
                <input type='submit' class="btn btn-primary d-block my-3" value='Update'>
            </form>
        </div>
    </div>
</div>

    <script>
        const previewImage = document.getElementById('preview-image');
        function displayImage(e) {
            if (e.target.files.length > 0) {
                previewImage.src = URL.createObjectURL(e.target.files[0]);
            }
            previewImage.style.display = 'block';
        }

        var menu = {!! json_encode($menu) !!};
        var materials = {!! json_encode($materials) !!};
        var menuItems = menu.raw_material;

        let totalItems = [];
        for (let item of menuItems) { 
            totalItems.push({
                'id': item.id,
                'quantity': item.pivot.quantity,
                'subtotal': item.pivot.subtotal,
            });
        }
        let key = 0;
        let total = 0;

        if(totalItems){
            $('#hidden-items').val(JSON.stringify(totalItems));
        }

        for (let item of menuItems) {
            $('#item-list').append(
                `<tr height='30px' class='border-1' id='item-row' data-key=${key}>
                        <input type='hidden' class='itemid' value='${item.pivot.itemid}'>
                        <td class='border-1 ps-2'>${item.itemname}</td>
                        <td class='border-1 ps-2'><input type="number" class='rquantity' step="0.1" style="border:none; outline:none" data-key=${key} value='${item.pivot.quantity}' min=0></td>
                        <td class='border-1 ps-2'>${item.unit}</td>
                        <td class='border-1 ps-2 rprice' id='price'>${item.price}</td>
                        <td class='border-1 ps-2' class='subtotal'><input type="number" step=0.01 style="border:none; outline:none" data-key=${key} class='rsubtotal' readonly value='${item.pivot.subtotal}'></td>
                        <td class='border-1 ps-2'><p class='remove text-danger m-0' role='button'>Remove</p></td>
                    </tr>`
            )
            total = menu.cost;
            $('#total').val(menu.cost);
        };

        if (totalItems.length == 0) {
            $('#item-list').append(
                '<td colSpan=6 class="empty p-3 text-center">No ingredient is selected.</td>'
            )
        }

        $('#material').change(() => {

            $('.empty').css('display', 'none');

            let id = $('#material').val();
            let subtotal = 0;
            let quantity = 1;

            key++;
            let item = materials.filter(item => item.id == id);
            let isExisted = false;
            for (let count of totalItems) {
                if (count.id === item[0].id) {
                    isExisted = true;
                }
            }
            if (!isExisted) {
                let price = item[0].price
                subtotal = quantity * price;
                $('#item-list').append(
                    `<tr height='30px' class='border-1' id='item-row' data-key=${key}>
                        <input type='hidden' class='itemid' value='${item[0].id}'>
                        <td class='border-1 ps-2'>${item[0].itemname}</td>
                        <td class='border-1 ps-2'><input type="number" step=0.1 class='rquantity' style="border:none; outline:none" data-key=${key} value='${quantity}' min=0></td>
                        <td class='border-1 ps-2'>${item[0].unit}</td>
                        <td class='border-1 ps-2 rprice' id='price'>${item[0].price}</td>
                        <td class='border-1 ps-2' class='subtotal'><input type="number" step=0.01 style="border:none; outline:none" data-key=${key} class='rsubtotal' readonly value='${subtotal}'></td>
                        <td class='border-1 ps-2'><p class='remove text-danger m-0' role='button'>Remove</p></td>
                    </tr>`
                );

                total += parseFloat(subtotal);
                $('#total').val(total.toFixed(2));
                totalItems.push({
                    'id': item[0].id,
                    'quantity': quantity,
                    'subtotal': subtotal
                });
                $('#hidden-items').val(JSON.stringify(totalItems));

            } else {
                console.log('item already exists');
            }

            $('.rquantity').unbind().change((event) => {
                console.log('quantity changed');
                updateQuantity();
            });

            $('.remove').unbind().click((event) => {
                removeItems();
            })

        })

        $('.rquantity').unbind().change((event) => {
                updateQuantity();
            });

        $('.remove').unbind().click((event) => {
            removeItems();
        })

        function removeItems() {
            event.preventDefault();
            const row = event.target.closest('tr');
            if (row) {
                let itemid = $(row).find('.itemid').val();
                totalItems = totalItems.filter(item => item.id != itemid);
                $('#hidden-items').val(JSON.stringify(totalItems));
                total = 0;
                for (material of totalItems) {
                    total += parseFloat(material.subtotal);
                }
                $('#total').val(total.toFixed(2));
                row.remove();
                if (totalItems.length == 0) {
                    $('#item-list').append(
                        '<td colSpan=6 class="empty p-3 text-center">No ingredient is selected.</td>'
                    )
                }
            }
        }

        function updateQuantity() {
            let row = event.target.closest('tr');
                let rquantity = event.target.closest('input', $('.rquantity').get(0));
                let rsubtotal = $(row).find('.rsubtotal');
                let rprice = $(row).find('.rprice').text();
                let itemid = $(row).find('.itemid').val();
                quantity = event.target.value;
                subtotal = 0;
                subtotal = parseFloat(rprice) * parseFloat(quantity);
                rsubtotal.val(subtotal.toFixed(2));

                totalItems.filter(item => {
                    if (item.id == itemid) {
                        item.quantity = quantity;
                        item.subtotal = subtotal;
                    }
                });
                total = 0;
                for (material of totalItems) {
                    total += parseFloat(material.subtotal);
                }

                $('#total').val(total.toFixed(2));
                $('#hidden-items').val(JSON.stringify(totalItems));
        }
    </script>
@endsection