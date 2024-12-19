@extends('dashboard.manager_dashboard')

@section('dashboard')
    <div class="main-panel">
        <div class="content-wrapper">
            <h3 class="fs-3 mb-4">Order Report</h3>

            <form action="/manager/report/order" method="GET">
                @csrf
                <div class="row mb-3">
                    <div class="col-8 col-md-4 mb-4">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" name="search" placeholder="Search Order"
                                id="" autocomplete='off'>
                        </div>
                    </div>
                    <div class="col-3 col-md-1">
                        <input type="submit" class="btn btn-danger" value="Search">
                    </div>
                    <div class="col-5 col-md-4">
                        <a href="/manager/report/order" class="btn btn-danger">All Order</a>
                    </div>
                </div>
            </form>

            <form action="/manager/report/order" method="POST">
                @csrf
                @method('PUT')
                <div class="row mb-2 align-items-center">
                    <div class="row col-12 col-sm-11 justify-content-between">
                        <div class="col-sm-3 col-6 pe-1 mb-1">
                            <div class="input-group input-group-sm">
        
                                <input type="date" name="date" class="form-control " id="date">
                            </div>
                        </div>
                        <div class="col-sm-3 col-6 px-sm-1 pe-1 mb-sm-0 mb-1">
                            <select name="type" id="type" class="form-select">
                                <option value="">Choose Order Type</option>
                                @foreach($types as $type)
                                    <option value="{{$type->id}}">{{$type->typename}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-3 col-6 px-sm-1 pe-1 mb-1">
                            <select name="table" id="table" class="form-select">
                                <option value="">Choose Table</option>
                                @foreach($tables as $table)
                                    <option value="{{$table->id}}">{{$table->tablenumber}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-3 col-6 px-sm-1 pe-1 mb-1">
                            <select name="waiter" id="waiter" class="form-select">
                                <option value="">Choose Waiter</option>
                                @foreach($users as $waiter)
                                    @if($waiter->role_id == '2' || $waiter->role_id == '1')
                                    <option value="{{$waiter->id}}">{{$waiter->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-1 mb-2">
                        <input type="submit" class="btn btn-danger" value="Filter">
                    </div>
                </div>
            </form>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="py-3">OrderID</th>
                <th class="py-3">Order Date</th>
                <th class="py-3">Order Time</th>
                <th class="py-3">Order Type</th>
                <th class="py-3">Table No</th>
                <th class="py-3">Waiter</th>
                <th class="py-3">Total</th>
                <th class="py-3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{$order->id}}</td>
                <td>{{$order->orderdate}}</td>
                <td>{{$order->ordertime}}</td>
                <td>
                    @foreach($types as $type)
                        @if($type->id == $order->type_id)
                            {{$type->typename}}
                        @endif
                    @endforeach
                </td>
                <td>
                    @foreach($tables as $table)
                        @if($table->id == $order->table_id)
                            {{$table->tablenumber}}
                        @endif
                    @endforeach
                    @foreach($types as $type)
                        @if($type->id == $order->type_id)
                            @if($type->typename == 'Pickup Order')
                                {{$order->order_token}}
                            @endif
                        @endif
                    @endforeach
                </td>
                <td>
                    @foreach($users as $staff)
                        @if($staff->id == $order->staff_id)
                            {{$staff->name}}
                        @endif
                    @endforeach
                </td>
                <td>{{$order->grandtotal}}</td>
                <td><a href="/manager/report/order/{{$order->id}}" class="text-danger text-decoration-none">Detail</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
        </div>
    </div>
<script>
    $('#todayorders').addClass('active text-danger');
</script>
@endsection