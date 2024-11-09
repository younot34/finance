@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah Expense</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-coins"></i> Tambah Expense</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('expenses.update', $expense->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Payment Date</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Vendor</th>
                                    <th>Account</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="date" name="payment_date" value="{{ $expense->payment_date ? date('Y-m-d', strtotime($expense->payment_date)) : date('Y-m-d') }}" class="form-control" required>
                                    </td>
                                    <td>
                                        <input type="text" name="description" value="{{ $expense->description ?? old('description') }}" class="form-control" placeholder="Description" required>
                                    </td>
                                    <td>
                                        <input type="number" step="0.01" name="amount" value="{{ $expense->amount ?? old('amount') }}" class="form-control" placeholder="Amount" required>
                                    </td>
                                    <td>
                                        <select name="vendor_id" class="form-control" required>
                                            <option value="{{ $expense->vendor_id ?? old('vendor_id') }}">Select Vendor</option>
                                            @foreach($vendors as $vendor)
                                                <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select name="account_id"  class="form-control" required>
                                            <option value="{{ $expense->account_id ?? old('account_id') }}">Select Account</option>
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
