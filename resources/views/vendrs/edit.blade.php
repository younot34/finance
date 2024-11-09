@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit</h1>
        </div>

        <div class="section-body">

            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-exam"></i> Edit </h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('vendrs.update', $vendor->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group col-md-3">
                            <label>Name</label>
                            <input type="text" name="name" value="{{$vendor->name ?? old('name')}}" class="form-control">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Address</label>
                            <input type="text" name="address" value="{{$vendor->address ?? old('address')}}" class="form-control" >
                        </div>
                        <div class="form-group col-md-3">
                            <label>Email</label>
                            <input type="text" name="email" value="{{$vendor->email ?? old('email')}}" class="form-control" >
                        </div>
                        <div class="form-group col-md-3">
                            <label>Phone</label>
                            <input type="text" name="phone" value="{{$vendor->phone ?? old('phone')}}" class="form-control" pattern="\d*">
                        </div>
                        <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i> SIMPAN</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

@stop
