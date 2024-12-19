@extends('dashboard.manager_dashboard')

@section('dashboard')
    <div class="main-panel">
        <div class="content-wrapper">

            <h3 class="fs-3 mb-4">Unanufacture</h3>
        
            <div class="col-10 col-sm-6 p-0">
                <form action="/manager/unmanufacture" method="POST">
                    @csrf
                    @method('PUT')
                    <label for="menu">Menu</label>
                    <select name="menu" id="menu" class="form-select" required>
                      <option value="">Select Menu</option>
                        @foreach ($menus as $item)
                            @if($item->menuname && $item->menu_type == 'cook')
                                <option value="{{ $item->id }}">{{ $item->menuname }}</option>
                            @endif
                        @endforeach
                    </select>

                    <label for="quantity">Quantity</label>
                    <input type="number" class="form-control" name="quantity" required>

                    <input type="submit" class="btn btn-danger mt-3" value="Unmanufacture">
                </form>
            </div>

            <div class="toast position-absolute top-0 end-0" style="z-index: 1050; opacity: 1 !important;" id="toastNotice" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                  <strong class="mr-auto">Unanufacture</strong>
                  <button type="button" class="ml-2 mb-1 close" data-bs-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="toast-body">
                    {{session('unmanufacture_success')}}{{session('unmanufacture_fail')}}
                </div>
              </div>

            <p id="noti" style="display: none">{{session('unmanufacture_success')}}{{session('unmanufacture_fail')}}</p>
            </div>
    </div>

  <script src="{{asset('/js/toast.js')}}"></script>
@endsection