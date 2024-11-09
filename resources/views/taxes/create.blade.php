@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah Tax</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-coins"></i> Tambah Tax</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('taxes.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Tax Date</th>
                                    <th>Description</th>
                                    <th>Rate</th>
                                    <th>Account</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="date" name="tax_date" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" name="description" class="form-control" placeholder="Description" required>
                                    </td>
                                    <td>
                                        <input type="number" name="rate" class="form-control" placeholder="Rate" required>
                                    </td>
                                    <td>
                                        <select name="account_id" class="form-control" required>
                                            <option value="">Select Account</option>
                                            @foreach($accounts as $account)
                                                <option value="{{ $account->id }}">{{ $account->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button class="btn btn-primary mr-1" type="submit"><i class="fa fa-paper-plane"></i> SIMPAN</button>
                        <button class="btn btn-warning" type="reset"><i class="fa fa-redo"></i> RESET</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
