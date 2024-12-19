@extends('dashboard.manager_dashboard')

@section('dashboard')
    <div class="main-panel">
        <div class="content-wrapper">
            <h3 class="fs-3 mb-4">Purchase Report</h3>

            <form action="/manager/report/purchase" method="GET">
                @csrf
                <div class="row mb-3 mb-sm-0">
                    <div class="col-8 col-md-4 mb-4">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" name="search" placeholder="Search Purchase"
                                id="" autocomplete='off'>
                        </div>
                    </div>
                    <div class="col-3 col-md-1">
                        <input type="submit" class="btn btn-danger" value="Search">
                    </div>
                    <div class="col-7 col-md-4">
                        <a href="/manager/report/purchase" class="btn btn-danger">All Purchase</a>
                    </div>
                </div>
            </form>

            <form action="/manager/report/purchase" method="POST">
                @csrf
                @method('PUT')
                <div class="row mb-2 align-items-center pe-0 col-12 col-lg-8 justify-content-between">
                    <div class="col-sm-5 col-6 col-lg-5 p-0 pe-1 mb-1">
                        <div class="input-group input-group-sm">
    
                            <input type="date" name="date" class="form-control " id="date">
                        </div>
                    </div>
                    <div class="col-sm-5 col-6 col-lg-5 p-0 pe-1 mb-1">
                        <select name="type" id="type" class="form-select">
                            <option value="">Choose Purchase Type</option>
                            <option value="Menu Purchase">Menu Purchase</option>
                            <option value="Raw Material Purchase">Raw Material Purchase</option>
                        </select>
                    </div>
                    <div class="col-2 ps-0 mb-1">
                        <input type="submit" class="btn btn-danger" value="Filter">
                    </div>
                </div>
            </form>

            

            <div class="table-responsive">
                <table class="table table-bordered col-11" id="mytable">
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
                                <a href="/manager/report/purchase/{{$purchase->id}}" class="text-danger text-decoration-none">Detail</a>
                            </td>
                        </tr>
                        @empty
                            <h6>Purchase Not Found</h6>
                        @endforelse
                    </tbody>
                </table>
                
                
            </div>
            {{$purchases->links()}}
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
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="jquery.tablesort.js"></script>
<script>
    let data = {!! json_encode($purchases) !!};
    handleEmpty(data);
    $(document).ready(function () {
            console.log('ready')
            $('#mytable').tablesort();
        $('#mytable').hide();
        })

</script>

@endsection
