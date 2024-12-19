@extends('dashboard.manager_dashboard')

@section('dashboard')
    <div class="main-panel">
        <div class="content-wrapper">
            <h3 class="fs-3 mb-4">Ingredients</h3>

        <a href="/manager/material/create" class="btn btn-danger mb-4">Add New Material</a>

        <form action="/manager/material" method="GET">
            @csrf

            <div class="row">
                <div class="col-4 mb-4 ">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" name="search" placeholder="Search Ingredient"
                            id="" autocomplete='off'>
                    </div>
                </div>
                <div class="col-1">
                    <input type="submit" class="btn btn-danger" value="Search">
                </div>
                <div class="col-3">
                    <a href="/manager/material" class="btn btn-danger">All Ingredients</a>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered col-7" id="table">
                <thead>
                    <tr>
                        <th class="py-3">Category Name</th>
                        <th class="py-3">Price</th>
                        <th class="py-3">Quantity</th>
                        <th class="py-3">Unit</th>
                        <th class="py-3">Action</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @forelse($materials as $material)
                        <td>{{$material->itemname}}</td>
                        <td>{{$material->price}}</td>
                        <td>{{$material->quantity}}</td>
                        <td>{{$material->unit}}</td>
                        <td>
                            <form action="/manager/material/delete/{{$material->id}}" method='POST'>
                                @csrf
                                @method('DELETE')
                                <a href="/manager/material/update/{{$material->id}}" class="text-decoration-none">Update</a>
                                <input type="submit" class="text-danger border-0 bg-transparent" value="Delete">
                            </form>
                        </td>
                    </tr>
                    @empty
                        <h6>Material Not Found</h6>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{$materials->links()}}
        
        
        <div class="toast position-absolute top-0 end-0" style="z-index: 1050; opacity: 1 !important;" id="toastNotice" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
              <strong class="mr-auto">Ingredients</strong>
              <button type="button" class="ml-2 mb-1 close" data-bs-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="toast-body">
                {{session('material_add_success')}}{{session('material_add_duplicate')}}{{session('material_update_success')}}{{session('material_delete_success')}}{{session('material_delete_fail')}}
            </div>
          </div>

        <p id="noti" style="display: none">{{session('material_add_success')}}{{session('material_add_duplicate')}}{{session('material_update_success')}}{{session('material_delete_success')}}{{session('material_delete_fail')}}</p>
        </div>
</div>

<script src="{{asset('/js/toast.js')}}"></script>
<script src="{{asset('/js/empty.js')}}"></script>

<script>
let data = {!! json_encode($materials) !!};
handleEmpty(data);
</script>
@endsection
