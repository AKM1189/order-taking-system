@extends('dashboard.manager_dashboard')

@section('dashboard')
    <div class="main-panel">
        <div class="content-wrapper">
            <h3 class="fs-3 mb-4">Menu</h3>
            <a href="/manager/menu/create" class="btn btn-danger mb-4">Add New Menu</a>

            <form action="/manager/menu" method="GET">
                @csrf
                <div class="row">
                    <div class="col-md-5 mb-4 col-sm-6 d-flex pe-3">
                        <div class="input-group input-group-sm me-1">
                            <input type="text" class="form-control" name="search" placeholder="Search Menu"
                                id="" autocomplete='off'>
                        </div>
                        <div>
                            <input type="submit" class="btn btn-danger" value="Search">
                        </div>                        
                    </div>
                    <div class="col-md-2 col-sm-6 mb-3">
                        <a href="/manager/menu" class="btn btn-danger">All Menu</a>    
                    </div>                   
                    <div class="col-md-3 col-sm-6">
                        <select name="category" class="form-select" id="category">
                            <option id="show-all" selected>All Menus</option>
                            @foreach ($categories as $category)
                                <option id='filter' value="{{$category->categoryname}}">{{ $category->categoryname }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>


           <div class="table-responsive">
            <table class="table table-bordered col-12 mt-3 col-md-10" id="table">
                <thead>
                    <tr>
                        <th class="py-3">Menu</th>
                        <th class="py-3">Description</th>
                        <th class="py-3">Quantity</th>
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
                            <td>{{$menu->status}}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <img src="/storage/menu_images/{{ $menu->menuimage }}" alt="menu"
                                    style="width:30px; height:30px">
                                </div>
                            </td>
                            <td>
                                <form action="/manager/menu/delete/{{ $menu->id }}" method='POST'>
                                    @csrf
                                    @method('DELETE')
                                    <a href="/manager/menu/update/{{ $menu->id }}" style="text-decoration:none">Update</a>
                                    <input type="submit" class="text-danger border-0 bg-transparent" value="Delete">
                                </form>
                            </td>
                        </tr>
                    @empty
                        <h6>Menu Not Found</h6>
                    @endforelse
                </tbody>
            </table>
           </div>
           {{$menus->links()}}

            <div class="toast position-absolute top-0 end-0" style="z-index: 1050; opacity: 1 !important;" id="toastNotice" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                  <strong class="mr-auto">Menu</strong>
                  <button type="button" class="ml-2 mb-1 close" data-bs-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="toast-body">
                    {{session('menu_add_success')}}{{session('menu_add_duplicate')}}{{session('menu_update_success')}}{{session('menu_delete_success')}}{{session('menu_delete_fail')}}
                </div>
              </div>

            <p id="noti" style="display: none">{{session('menu_add_success')}}{{session('menu_add_duplicate')}}{{session('menu_update_success')}}{{session('menu_delete_success')}}{{session('menu_delete_fail')}}</p>
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
            </script>
        @endsection
