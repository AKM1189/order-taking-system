@extends('dashboard.manager_dashboard')

@section('dashboard')
    <div class="main-panel">
        <div class="content-wrapper">
            <h3 class="fs-3 mb-4">Purchase Lists</h3>

            <a href="/manager/purchase/create/menu" class="btn btn-danger mb-4">Purchase Menu</a>
            <a href="/manager/purchase/create/raw_material" class="btn btn-danger mb-4">Purchase Raw Material</a>


            <form action="/manager/purchase" method="GET">
                @csrf
                <div class="row mb-3">
                    <div class="col-9 col-md-4 mb-4">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" name="search" placeholder="Search Purchase"
                                id="" autocomplete='off'>
                        </div>
                    </div>
                    <div class="col-3 col-md-2 col-lg-1">
                        <input type="submit" class="btn btn-danger" value="Search">
                    </div>
                    <div class="col-7 col-md-3">
                        <a href="/manager/purchase" class="btn btn-danger">All Purchase</a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered col-11" id="table">
                    <thead>
                        <tr>
                            <th class="py-3">Purchase Date</th>
                            <th class="py-3">Invoice No</th>
                            <th class="py-3">Purchase Type</th>
                            <th class="py-3">Total</th>
                            <th class="py-3">Paid Amount</th>
                            <th class="py-3">Balance</th>
                            <th class="py-3">Payment Type</th>
                            <th class="py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($purchases as $purchase)
                        <tr>
                            <td>{{$purchase->created_at->toDateString()}}</td>
                            <td>{{$purchase->invoice_no}}</td>
                            <td>{{$purchase->purchase_type}}</td>
                            <td>{{$purchase->total}}</td>
                            <td>{{$purchase->paid_amount}}</td>
                            <td>{{$purchase->balance}}</td>
                            <td>{{$purchase->payment_type}}</td>
                            <td>
                                <form action="/manager/purchase/delete/{{$purchase->purchase_type == 'Menu Purchase'? 'menu' : 'rawmaterial'}}&{{$purchase->id}}" method='POST'>
                                    @csrf
                                    @method('DELETE')
                                    <a href="/manager/purchase/update/{{$purchase->purchase_type == 'Menu Purchase'? 'menu' : 'rawmaterial'}}&{{$purchase->id}}" class="text-decoration-none">Update</a>
                                    <input type="submit" class="text-danger bg-transparent border-0" value="Delete">
                                </form>
                            </td>
                        </tr>
                        @empty
                            <h6>Purchase Not Found</h6>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="toast position-absolute top-0 end-0" style="z-index: 1050; opacity: 1 !important;" id="toastNotice" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                  <strong class="mr-auto">Purchase</strong>
                  <button type="button" class="ml-2 mb-1 close" data-bs-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="toast-body">
                    {{session('purchase_add_success')}}{{session('purchase_add_duplicate')}}{{session('purchase_update_success')}}{{session('purchase_delete_success')}}{{session('purchase_delete_fail')}}
                </div>
              </div>

            <p id="noti" style="display: none">{{session('purchase_add_success')}}{{session('purchase_add_duplicate')}}{{session('purchase_update_success')}}{{session('purchase_delete_success')}}{{session('purchase_delete_fail')}}</p>
            </div>
    </div>

<script src="{{asset('/js/toast.js')}}"></script>
<script src="{{asset('/js/empty.js')}}"></script>
<script>
    let data = {!! json_encode($purchases) !!};
    handleEmpty(data);
</script>

@endsection
