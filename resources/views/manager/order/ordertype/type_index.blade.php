@extends('dashboard.manager_dashboard')

@section('dashboard')
    <div class="main-panel">
        <div class="content-wrapper">
            <h3 class="fs-3 mb-4">Order Type</h3>

        <a href="/manager/type/create" class="btn btn-danger mb-4">Add New Order Type</a>


        <form action="/manager/type" method="GET">
            @csrf
            <div class="row">
                <div class="col-4 mb-4">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" name="search" placeholder="Search Category"
                            id="" autocomplete='off'>
                    </div>
                </div>
                <div class="col-1">
                    <input type="submit" class="btn btn-danger" value="Search">
                </div>
                <div class="col-3">
                    <a href="/manager/type" class="btn btn-danger">All Order Type</a>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered col-6" id="table">
                <thead>
                    <tr>
                        <th class="py-3">Type Name</th>
                        <th class="py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($types as $type)
                    <tr>
                        <td>{{$type->typename}}</td>
                        <td>
                            <form action="/manager/type/delete/{{$type->id}}" method='POST'>
                                @csrf
                                @method('DELETE')
                                <a href="/manager/type/update/{{$type->id}}" style="text-decoration: none">Update</a>
                                <input type="submit"  class="text-danger"
                                style="border: none; background-color: transparent" value="Delete">
                            </form> 
                        </td>
                    @empty
                        <h6>Order Type Not Found</h6>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        

        <div class="toast position-absolute top-0 end-0" style="z-index: 1050; opacity: 1 !important;" id="toastNotice" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
              <strong class="mr-auto">Order Type</strong>
              <button type="button" class="ml-2 mb-1 close" data-bs-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="toast-body">
                {{session('type_add_success')}}{{session('type_add_duplicate')}}{{session('type_update_success')}}{{session('type_delete_success')}}{{session('type_delete_fail')}}
            </div>
          </div>

        <p id="noti" style="display: none">{{session('type_add_success')}}{{session('type_add_duplicate')}}{{session('type_update_success')}}{{session('type_delete_success')}}{{session('type_delete_fail')}}</p>
        </div>
</div>

<script src="{{asset('/js/toast.js')}}"></script>
<script src="{{asset('/js/empty.js')}}"></script>

<script>
    let data = {!! json_encode($types) !!};
    handleEmpty(data);
</script>
@endsection
