@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Ledger</h1>
        </div>

        <div class="section-body">

            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-book"></i> Ledger</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('ledgers.index') }}" method="GET">
                        @hasanyrole('petugas1|petugas2|petugas3|petugas4|petugas5|petugas6|petugas7|direktur|karyawan|admin')
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="start_date">Start Date</label>
                                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="end_date">End Date</label>
                                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="account_id">Select Account</label>
                                        <select name="account_id" id="account_id" class="form-control">
                                            <option value="">Semua Akun</option>
                                            @foreach($accounts as $account)
                                                <option value="{{ $account->id }}" {{ request('account_id') == $account->id ? 'selected' : '' }}>{{ $account->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <button type="submit" class="btn btn-primary">Show Data</button>
                                </div>
                            </div>
                        </div>
                        @endhasanyrole
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Date</th>
                                    <th scope="col">No.ref</th>
                                    <th scope="col">Account Name</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Debit</th>
                                    <th scope="col">Credit</th>
                                    <th scope="col">Opening Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $balance = $opening_balance; @endphp
                                @foreach ($transactions as $transaction)
                                    @php
                                        $balance += $transaction->debit - $transaction->credit;
                                    @endphp
                                    <tr>
                                        <td>{{ $transaction->journals->transaction_date }}</td>
                                        <td>{{ $transaction->no_ref }}</td>
                                        <td>{{ $transaction->account->name }}</td>
                                        <td>{{ $transaction->description }}</td>
                                        <td>{{ number_format($transaction->debit, 2) }}</td>
                                        <td>{{ number_format($transaction->credit, 2) }}</td>
                                        <td>{{ number_format($balance, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4">Total</th>
                                    <th>{{ number_format($total_debit, 2) }}</th>
                                    <th>{{ number_format($total_credit, 2) }}</th>
                                    <th>{{ number_format($balance, 2) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@stop
