@extends('dashboard.manager_dashboard')

@section('dashboard')
    <div class="main-panel">
        <div class="content-wrapper">
            <h3 class="fs-3 mb-4">Supplier</h3>

            <a href="/manager/supplier/create" class="btn btn-danger mb-4">Add New Supplier</a>


            <form action="/manager/supplier" method="GET">
                @csrf
                <div class="row mb-4">
                    <div class="col-8 col-md-4 mb-4">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" name="search" placeholder="Search Supplier"
                                id="" autocomplete='off'>
                        </div>
                    </div>
                    <div class="col-3 col-md-1">
                        <input type="submit" class="btn btn-danger" value="Search">
                    </div>
                    <div class="col-6 col-md-4">
                        <a href="/manager/supplier" class="btn btn-danger">All Suppliers</a>
                    </div>
                </div>
            </form>

            <div class="table-responsive m-0 p-0 col-lg-10">
                <table class="table table-bordered" id="table">
                    <thead>
                        <tr>
                            <th class="py-3">Supplier Name</th>
                            <th class="py-3">Phone</th>
                            <th class="py-3">Email</th>
                            <th class="py-3">Address</th>
                            <th class="py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suppliers as $supplier)
                        <tr>
                            <td>{{$supplier->name}}</td>
                            <td>{{$supplier->phone}}</td>
                            <td>{{$supplier->email}}</td>
                            <td>{{$supplier->address}}</td>
                            <td>
                                <form action="/manager/supplier/delete/{{$supplier->id}}" method='POST'>
                                    @csrf
                                    @method('DELETE')
                                    <a href="/manager/supplier/update/{{$supplier->id}}" class="text-decoration-none">Update</a>
                                    <input type="submit" class="bg-transparent border-0 text-danger" value="Delete">
                                </form>
                            </td>
    
                        </tr>
                        @empty
                            <h6>Supplier not found.</h6>
                        @endforelse
                    </tbody>
                </table>
            </div>

        <div class="toast position-absolute top-0 end-0" style="z-index: 1050; opacity: 1 !important;" id="toastNotice" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
              <strong class="mr-auto">Supplier</strong>
              <button type="button" class="ml-2 mb-1 close" data-bs-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="toast-body">
                {{session('supplier_add_success')}}{{session('supplier_add_duplicate')}}{{session('supplier_update_success')}}{{session('supplier_delete_success')}}{{session('supplier_delete_fail')}}
            </div>
          </div>

        <p id="noti" style="display: none">{{session('supplier_add_success')}}{{session('supplier_add_duplicate')}}{{session('supplier_update_success')}}{{session('supplier_delete_success')}}{{session('supplier_delete_fail')}}</p>
        </div>
</div>

<script src="{{asset('/js/toast.js')}}"></script>

<script src="{{asset('/js/empty.js')}}"></script>
<script>
    let myarray = {!! json_encode($suppliers) !!};
    handleEmpty($suppliers);
</script>

@endsection
