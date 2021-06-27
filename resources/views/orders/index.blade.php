@extends('layouts.admin')

@section('title', 'Orders History')
@section('content-header', 'Order History')


@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-5">
                <form action="{{route('orders.index')}}">
                    <div class="row">
                        <div class="col-md-5">
                            <input type="date" name="start_date" class="form-control" value="{{request('start_date')}}" />
                        </div>
                        <div class="col-md-5">
                            <input type="date" name="end_date" class="form-control" value="{{request('end_date')}}" />
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-outline-primary" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Product Total Price</th>
                    <th>Received Amount</th>
                    <th>Status</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$order->getCustomerName()}}</td>
                    <td>RM{{$order->formattedTotal()}}</td>
                    <td>RM{{$order->formattedReceivedAmount()}}</td>
                    <td>
                        @if($order->formattedTotal() == $order->formattedReceivedAmount())
                            <span class="badge badge-success">Paid</span>
                        @endif
                    </td>
                    <td>{{$order->created_at}}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>RM{{ number_format($total, 2) }}</th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
        <div class="pull-right">
            {{ $orders->render() }}
        </div>
        <div class="pull-right">
            <a href="{{route('cart.index')}}" class="btn btn-primary">POS Mangement System</a>
        </div>
    </div>
</div>
@endsection

