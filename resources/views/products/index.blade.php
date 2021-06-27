@extends('layouts.admin')

@section('title', 'Product List')
@section('content-header', 'Product List')
@section('css')
<link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection
@section('content')
<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Product Image</th>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $item )
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td><img src="{{ Storage::url($item->image) }}" alt="" width="100"></td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>RM{{ $item->price }}</td>
                    <td>
                        <a href="{{ route('products.edit', $item) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                        <button class="btn btn-danger btn-delete" data-url="{{route('products.destroy', $item)}}"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pull-right">
            {{  $products->render() }}
        </div>
        <div class="pull-right">
            <a href="{{route('products.create')}}" class="btn btn-primary btn-lg">Create New Product</a>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $(document).on('click', '.btn-delete', function () {
            $this = $(this);
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "Confirm to delete this product?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    $.post($this.data('url'), {_method: 'DELETE', _token: '{{csrf_token()}}'}, function (res) {
                        $this.closest('tr').fadeOut(500, function () {
                            $(this).remove();
                        })
                    })
                }
            })
        })
    })
</script>
@endsection
