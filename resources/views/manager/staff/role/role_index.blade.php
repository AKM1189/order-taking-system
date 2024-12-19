@extends('dashboard.manager_dashboard')

@section('dashboard')
    <div class="main-panel">
        <div class="content-wrapper">
            <h3 class="fs-3 mb-4">Role</h3>
            <a href="/manager/role/create" class="btn btn-danger mb-4">Add New Role</a>

        <form action="/manager/role" method="GET">
            @csrf

            <div class="row mb-3">
                <div class="col-8 col-md-4 mb-4">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" name="search" placeholder="Search Category"
                            id="" autocomplete='off'>
                    </div>
                </div>
                <div class="col-3 col-md-1">
                    <input type="submit" class="btn btn-danger" value="Search">
                </div>
                <div class="col-5 col-md-4">
                    <a href="/manager/role" class="btn btn-danger">All Role</a>
                </div>
            </div>
        </form>
        {{-- <a href="{{ route('role.index', ['column' => 'rolename', 'direction' => 'asc']) }}">Sort by Name (Asc)</a> --}}
        {{-- <a href="{{ route('role.index', ['column' => 'rolename', 'direction' => 'desc']) }}">Sort by Name (Desc)</a> --}}

        <div class="table-responsive">
            <table class="table table-bordered col-7" id="myTable">
                <thead>
                    <tr>
                        <th class="py-3">Role Name</th>
                        <th class="py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                    <tr>
                        <td>{{$role->rolename}}</td>
                        <td>
                            <form action="/manager/role/delete/{{$role->id}}" method='POST'>
                                @csrf
                                @method('DELETE')
                                <a href="/manager/role/update/{{$role->id}}" class="text-decoration-none">Update</a>
                                <input type="submit" class="text-danger bg-transparent border-0" value="Delete">
                            </form>
                        </td>
                    </tr>
                    @empty
                        <h3>Role Not Found</h3>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="toast position-absolute top-0 end-0" style="z-index: 1050; opacity: 1 !important;" id="toastNotice" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
              <strong class="mr-auto">Role</strong>
              <button type="button" class="ml-2 mb-1 close" data-bs-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="toast-body">
                {{session('role_add_success')}}{{session('role_add_duplicate')}}{{session('role_update_success')}}{{session('role_delete_success')}}{{session('role_delete_fail')}}
            </div>
          </div>

        <p id="noti" style="display: none">{{session('role_add_success')}}{{session('role_add_duplicate')}}{{session('role_update_success')}}{{session('role_delete_success')}}{{session('role_delete_fail')}}</p>

    </div>
</div>
<script src="{{asset('/js/toast.js')}}"></script>

@endsection
