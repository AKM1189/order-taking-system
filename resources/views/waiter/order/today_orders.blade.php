@extends('Layout.layout')

@section('content')
<div class="p-lg-5 p-3">
    @if(count($orders) === 0) 
        <p>There is no order today.</p>
    @else
    <div class="table-responsive col-12">
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
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
    
</div>
<script>
    $('#todayorders').addClass('active text-danger');
</script>
@endsection