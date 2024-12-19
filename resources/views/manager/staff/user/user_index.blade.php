@extends('dashboard.manager_dashboard')

@section('dashboard')
    <div class="main-panel">
        <div class="content-wrapper">
            <h3 class="fs-3 mb-4">User</h3>
        
            <a href="/manager/user/create" class="btn btn-danger mb-4">Add New user</a>

            <form action="/manager/user" method="GET">
                @csrf
                <div class="row">
                    <div class="col-md-5 mb-4 col-sm-6 d-flex pe-3">
                        <div class="input-group input-group-sm me-1">
                            <input type="text" class="form-control" name="search" placeholder="Search User"
                                id="" autocomplete='off'>
                        </div>
                        <div>
                            <input type="submit" class="btn btn-danger" value="Search">
                        </div>
                    </div>
                    <div class="col-5 col-md-2 col-sm-6 mb-3">
                        <a href="/manager/user" class="btn btn-danger">All User</a>
                    </div>
                    <div class="col-7 col-md-3 col-sm-6">
                        <select name="role" class="form-select" id="role">
                            <option id="show-all" selected>All Role</option>
                            @foreach ($roles as $role)
                                <option id='filter' value="{{$role->rolename}}">{{ $role->rolename }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-responsive-sm col-12 mt-3 col-md-10">
                    <thead>
                        <tr>
                            <th class="py-3">User Name</th>
                            <th class="py-3">Email</th>
                            <th class="py-3">Role</th>
                            <th class="py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $record)
                        <tr class="record">
                            <td>{{$record->name}}</td>
                            <td>{{$record->email}}</td>
                            <td class="role-name">{{$record->role->rolename}}</td>
                            <td>
                                <form action="/manager/user/delete/{{$record->id}}" method='POST'>
                                    @csrf
                                    @method('DELETE')
                                    <a href="/manager/user/update/{{$record->id}}" class="text-decoration-none">Update</a>
                                    <input type="submit" class="bg-transparent border-0 text-danger" value="Delete">
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        
            <div class="toast position-absolute top-0 end-0" style="z-index: 1050; opacity: 1 !important;" id="toastNotice" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                  <strong class="mr-auto">User</strong>
                  <button type="button" class="ml-2 mb-1 close" data-bs-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="toast-body">
                    {{session('user_add_success')}}{{session('user_add_duplicate')}}{{session('user_update_success')}}{{session('user_delete_success')}}{{session('user_delete_fail')}}
                </div>
              </div>

            <p id="noti" style="display: none">{{session('user_add_success')}}{{session('user_add_duplicate')}}{{session('user_update_success')}}{{session('user_delete_success')}}{{session('user_delete_fail')}}</p>
            </div>
    </div>

  <script src="{{asset('/js/toast.js')}}"></script>

    <script>
        $('#role').change(function() {
                    let records = $('.record');
                    let roleName = $('.role-name');
                    let value = $('#role option:selected').text();

                    records.each((index, record) => {
                        if (value == 'All Role') {
                            $(record).show();
                        } else {
                            let role = $(roleName[index]).text().trim();
                            $(record).toggle(role == value);
                        }
                    })
                })
    </script>
@endsection