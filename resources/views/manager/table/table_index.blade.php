@extends('dashboard.manager_dashboard')

@section('dashboard')
    <div class="main-panel">
        <div class="content-wrapper">
            <h3 class="fs-3 mb-4">Table</h3>
            <a href="/manager/table/create" class="btn btn-danger mb-4">Add New Table</a>

            <form action="/manager/table" method="GET">
                @csrf
                <div class="row mb-3">
                    <div class="col-8 col-md-4 mb-4">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" name="search" placeholder="Search Table"
                                id="" autocomplete='off'>
                        </div>
                    </div>
                    <div class="col-3 col-md-1">
                        <input type="submit" class="btn btn-danger" value="Search">
                    </div>
                    <div class="col-5 col-md-4">
                        <a href="/manager/table" class="btn btn-danger">All Table</a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered col-8" id="table">
                    <thead>
                        <tr>
                            <th class="py-3">Table Number</th>
                            <th class="py-3">Capacity</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tables as $table)
                            <tr>
                                <td>{{ $table->tablenumber }}</td>
                                <td>{{ $table->capacity }}</td>
                                <td>{{ $table->status }}</td>
                                <td>
                                    <form action="/manager/table/delete/{{ $table->id }}" method='POST'>
                                        @csrf
                                        @method('DELETE')
                                        <a href="/manager/table/update/{{ $table->id }}" class="text-decoration-none">Update</a>
                                        <input type="submit" class="text-danger bg-transparent border-0" value="Delete">
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <h3>Table Not Found</h3>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="toast position-absolute top-0 end-0" style="z-index: 1050; opacity: 1 !important;" id="toastNotice" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                  <strong class="mr-auto">Table</strong>
                  <button type="button" class="ml-2 mb-1 close" data-bs-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="toast-body">
                    {{session('table_add_success')}}{{session('table_add_duplicate')}}{{session('table_update_success')}}{{session('table_delete_success')}}{{session('table_delete_fail')}}
                </div>
              </div>

            <p id="noti" style="display: none">{{session('table_add_success')}}{{session('table_add_duplicate')}}{{session('table_update_success')}}{{session('table_delete_success')}}{{session('table_delete_fail')}}</p>
            </div>
    </div>

  <script src="{{asset('/js/toast.js')}}"></script>
  <script src="{{asset('/js/empty.js')}}"></script>

  <script>
      let data = {!! json_encode($tables) !!};
      handleEmpty(data);
  </script>
@endsection
