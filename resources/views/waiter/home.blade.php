@extends('Layout.layout')

@section('content')

<div class="d-flex justify-content-center">
    <div class="col-lg-8 col-md-10 col-sm-12 p-3">
        <div class="my-4 d-flex">
            <h3 class="me-3">Dining Order</h3>
            <div>
                <a href="/waiter/order/create/ordertype=Pickup Order" class="btn btn-danger">Pickup Order</a>
            </div>
       </div>
    <div class="row">
        @foreach($tables as $table)
        <div class="col-lg-3 col-sm-4 mb-3">
            @if($table->status == 'Occupied')
                <div class="p-5 rounded-3 text-center m-1 text-white" style="background-color: #ff6666">
                    <div>{{$table->tablenumber}}</div>
                    <div>Seat - {{$table->capacity}}</div>
                    <div>{{$table->status}}</div>
                </div>
            @else
            <a href="/waiter/order/create/ordertype=Dining Order&tableno={{$table->tablenumber}}" class="text-decoration-none">
                <div class="p-5 rounded-3 text-center m-1 text-black" style="background-color: #2dff73">
                    <div>{{$table->tablenumber}}</div>
                    <div>Seat - {{$table->capacity}}</div>
                    <div>{{$table->status}}</div>
                </div>
            </a>
            @endif
    </div>
            @endforeach
    
            <div class="toast position-absolute top-0 end-0" style="z-index: 1050; opacity: 1 !important;" id="toastNotice" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header justify-content-between">
                @if(session('order_add_success') || session('order_update_success'))
                <strong class="mr-auto">Order</strong>
                @elseif(session('user_update_success'))
                <strong class="mr-auto">Profile</strong>
                @endif
                  <button type="button" class="ml-2 mb-1 close bg-transparent border-0" data-bs-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true" class="fs-4">&times;</span>
                  </button>
                </div>
                <div class="toast-body">
                    {{session('order_add_success')}}{{session('order_update_success')}}{{session('user_update_success')}}
                </div>
              </div>
    
            <p id="noti" style="display: none">{{session('order_add_success')}}{{session('order_update_success')}}{{session('user_update_success')}}</p>
    </div>
    </div>
</div>

<script src="{{asset('/js/toast.js')}}"></script>
<script>
    $('#home').addClass('active text-danger');
</script>
@endsection