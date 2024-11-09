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
                    <form action="{{ route('accounts.update', $account->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group col-md-3">
                            <label>Code Account</label>
                            <input type="text" name="account_number" value="{{$account->account_number ?? old('account_number')}}" class="form-control" placeholder="account number" pattern="\d*">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Account Name</label>
                            <input type="text" name="name" value="{{$account->name ?? old('name')}}" class="form-control" placeholder="name">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Sub Klasifikasi</label>
                            <input type="text" name="subKlasifikasi" value="{{$account->subKlasifikasi ?? old('subKlasifikasi')}}" class="form-control" placeholder="subKlasifikasi">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Klasifikasi</label>
                            <input type="text" name="klasifikasi" value="{{$account->klasifikasi ?? old('klasifikasi')}}" class="form-control" placeholder="klasifikasi">
                        </div>
                        <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i> SIMPAN</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

@stop
