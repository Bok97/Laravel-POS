@extends('layouts.admin')

@section('title', 'Create Customer')
@section('content-header', 'Create Customer')

@section('content')

    <div class="card">
        <div class="card-body">

            <form action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           id="name"
                           placeholder="Full Name" value="{{ old('name') }}">
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="email"
                           placeholder="Email" value="{{ old('email') }}">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone"
                           placeholder="Phone" value="{{ old('phone') }}">
                    @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                           id="address"
                           placeholder="Address" value="{{ old('address') }}">
                    @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <button class="btn btn-primary" type="submit">Create</button>
            </form>
        </div>
    </div>
@endsection

