@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah transaction</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-coins"></i> Tambah transaction</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('transactions.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Transaction Date</th>
                                    <th>Description</th>
                                    <th>Account</th>
                                    <th>Amount</th>
                                    <th>Payment Method</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="date" name="transaction_date" class="form-control" required>
                                    </td>
                                    <td>
                                        <input type="text" name="description" class="form-control" placeholder="Description" required>
                                    </td>
                                    <td>
                                        <select name="account_id" class="form-control" required>
                                            <option value="">Select Account</option>
                                            @foreach($accounts as $account)
                                                <option value="{{ $account->id }}">{{ $account->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="amount" class="form-control" placeholder="Amount" required>
                                    </td>
                                    <td>
                                        <input type="text" name="payment_method" class="form-control" placeholder="payment_method" required>
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
