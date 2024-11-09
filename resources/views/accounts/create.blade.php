@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah</h1>
        </div>

        <div class="section-body">

            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-exam"></i> Tambah</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('accounts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group col-md-3">
                            <label>Code Account</label>
                            <input type="text" name="account_number" class="form-control" placeholder="000" pattern="\d*">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Account Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Name Account">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Sub Klasifikasi</label>
                            <input type="text" name="subKlasifikasi" class="form-control" placeholder="sub klasifikasi">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Klasifikasi</label>
                            <input type="text" name="klasifikasi" class="form-control" placeholder="klasifikasi">
                        </div>
                        <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i> SIMPAN</button>
                        <button class="btn btn-warning btn-reset" type="reset"><i class="fa fa-redo"></i> RESET</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@stop
