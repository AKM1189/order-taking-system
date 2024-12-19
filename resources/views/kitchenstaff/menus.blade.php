@extends('Layout.kitchen_layout')

@section('content')
<div>
    <div class="main-panel px-md-5 px-3 pt-5">
        <div class="content-wrapper">
            {{-- <h3 class="fs-3 mb-4">Menu</h3> --}}
            {{-- <a href="/manager/menu/create" class="btn btn-danger mb-4">Add New Menu</a> --}}

            <form action="/kitchen/menus" method="GET">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-4 col-sm-6 d-flex pe-3">
                        <div class="input-group input-group me-1">
                            <input type="text" class="form-control" name="search" placeholder="Search Menu"
                                id="" autocomplete='off'>
                        </div>
                        <div>
                            <input type="submit" class="btn btn-danger" value="Search">
                        </div>                        
                    </div>
                    <div class="col-md-2 col-sm-6 mb-3">
                        <a href="/kitchen/menus" class="btn btn-danger">All Menus</a>    
                    </div>                   
                    <div class="col-md-3 col-sm-4 col-6 mb-2">
                        <select name="category" class="form-select" id="category">
                            <option id="show-all" selected>All Menus</option>
                            @foreach ($categories as $category)
                                <option id='filter' value="{{$category->categoryname}}">{{ $category->categoryname }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-4 col-6">
                        <select name="status" class="form-select" id="status">
                            <option value="All">All</option>
                            <option value="available">Available</option>
                            <option value="low stock">Low Stock</option>
                            <option value="stock out">Stock Out</option>
                        </select>
                    </div>
                </div>
            </form>


            <div class="table-responsive">
                <table class="table table-responsive-sm table-bordered col-12 mt-3 col-md-10" id="table">
                    <thead>
                        <tr>
                            <th class="py-3">Menu</th>
                            <th class="py-3">Description</th>
                            <th class="py-3">Stock</th>
                            <th class="py-3">Category</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Image</th>
                            <th class="py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        @forelse($menus as $menu)
                            <tr class="record" data-type="{{ $menu->category->categoryname }}">
                                <td>{{ $menu->menuname }}</td>
                                <td>{{ $menu->description }}</td>
                                <td>{{ $menu->quantity }}</td>
                                <td class="category-name">{{ $menu->category->categoryname }}</td>
                                <td class="status-name">{{$menu->status}}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <img src="/storage/menu_images/{{ $menu->menuimage }}" alt="menu"
                                        style="width:50px; height:50px">
                                    </div>
                                </td>
                                <td>
                                    @if($menu->menu_type == 'cook')
                                    <a href="/kitchen/manufacture/{{$menu->id}}" class="text-danger text-decoration-none">Cook</a> |
                                    <a href="/kitchen/unmanufacture/{{$menu->id}}" class="text-danger text-decoration-none">Uncook</a>
                                    @elseif($menu->menu_type == 'purchase')
                                    <a href="/kitchen/purchase" class="text-danger text-decoration-none">Purchase</a>
                                    @endif
                                    {{-- <form action="/manager/menu/delete/{{ $menu->id }}" method='POST'>
                                        @csrf
                                        @method('DELETE')
                                        <a href="/manager/menu/update/{{ $menu->id }}" style="text-decoration:none">Update</a>
                                        <input type="submit" class="text-danger border-0 bg-transparent" value="Delete">
                                    </form> --}}
                                </td>
                            </tr>
                        @empty
                            <h6>Menu Not Found</h6>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="toast position-absolute top-0 end-0" style="z-index: 1050; opacity: 1 !important;" id="toastNotice" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header justify-content-between">
                    <strong class="mr-auto">Manufacture</strong>
                    <button type="button" class="ml-2 mb-1 close bg-transparent border-0" data-bs-dismiss="toast" aria-label="Close">
                      <span aria-hidden="true" class="fs-4">&times;</span>
                    </button>
                  </div>
                <div class="toast-body">
                    {{session('menu_add_success')}}{{session('menu_add_duplicate')}}{{session('menu_update_success')}}{{session('menu_delete_success')}}{{session('menu_delete_fail')}}{{session('manufacture_success')}}{{session('unmanufacture_success')}}{{session('unmanufacture_fail')}}{{session('stock_unavailable')}}
                </div>
              </div>

            <p id="noti" style="display: none">{{session('menu_add_success')}}{{session('menu_add_duplicate')}}{{session('menu_update_success')}}{{session('menu_delete_success')}}{{session('menu_delete_fail')}}{{session('manufacture_success')}}{{session('unmanufacture_success')}}{{session('unmanufacture_fail')}}{{session('stock_unavailable')}}</p>
            </div>
    </div>

  <script src="{{asset('/js/toast.js')}}"></script>
  <script src="{{asset('/js/empty.js')}}"></script>



            <script>
                var menus = {!! json_encode($menus) !!};
                handleEmpty(menus);

                $('#category').change(function() {
                    let records = $('.record');
                    let categoryName = $('.category-name');
                    let value = $('#category option:selected').text();

                    records.each((index, record) => {
                        if (value == 'All Menus') {
                            $(record).show();
                        } else {
                            console.log(index);
                            let category = $(categoryName[index]).text().trim();
                            $(record).toggle(category == value);
                        }
                    })
                })

                $('#status').change(function() {
                    let records = $('.record');
                    let statusName = $('.status-name');
                    let value = $('#status').val();

                    records.each((index, record) => {
                        if (value == 'All') {
                            $(record).show();
                        } else {
                            let status = $(statusName[index]).text().trim();
                            $(record).toggle(status == value);
                        }
                    })
                })

                $('#menus').addClass('active text-danger');

            </script>
</div>
@endsection