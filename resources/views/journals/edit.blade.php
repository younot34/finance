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
                    <h4><i class="fas fa-exam"></i> Edit</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('journals.update', $journal->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Account</th>
                                    <th>No.ref</th>
                                    <th>Description</th>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                </tr>
                            </thead>
                            <tbody id="journal-container">
                                <tr>
                                    <td>
                                        <input type="date" name="transaction_date" value="{{ $journal->transaction_date ? date('Y-m-d', strtotime($journal->transaction_date)) : date('Y-m-d') }}" class="form-control">
                                    </td>
                                    @foreach ($journal->journal_entries as $index => $entri)

                                    @endforeach
                                    <td>
                                        <select type="text" name="account_id[]" value="{{ $entri->account_id ?? old('account_id') }}" class="form-control">
                                            <option value="">Select Account</option>
                                            @foreach($accounts as $account)
                                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="no_ref" value="{{$entri->no_ref ?? old('no_ref')}}" class="form-control" placeholder="no_ref">
                                    </td>
                                    <td>
                                        <input type="text" name="description[]" value="{{ $entri->description ?? old('description') }}" class="form-control" placeholder="Description">
                                    </td>
                                    <td>
                                        <input type="number" name="debit[]" value="{{ $entri->debit ?? old('debit') }}" class="form-control">
                                    </td>
                                    <td>
                                        <input type="number" name="credit[]" value="{{ $entri->credit ?? old('credit') }}" class="form-control">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i> SIMPAN</button>
                        <button class="btn btn-light" type="button" id="adddataButton">TAMBAH DATA</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script>
        var accounts = @json($accounts); // Kirim data accounts ke JavaScript

        var adddataButton = document.getElementById('adddataButton');
        if (adddataButton) {
            adddataButton.addEventListener('click', function() {
                var container = document.getElementById('journal-container');
                var newRow = document.createElement('tr');
                var options = '<option value="">Select Account</option>';

                accounts.forEach(function(account) {
                    options += `<option value="${account.id}">${account.name}</option>`;
                });

                newRow.innerHTML = `
                <th scope="col"></th>
                <td>
                    <select name="account_id[]" class="form-control">
                        ${options}
                    </select>
                </td>
                <td>
                    <input type="text" name="no_ref" value="{{$entri->no_ref ?? old('no_ref')}}" class="form-control" placeholder="no_ref">
                </td>
                <td>
                    <input type="text" name="description[]" class="form-control" placeholder="Description">
                </td>
                <td>
                    <input type="text" name="debit[]" class="form-control" placeholder="Debit">
                </td>
                <td>
                    <input type="text" name="credit[]" class="form-control" placeholder="Credit">
                </td>
                `;

                container.appendChild(newRow);
            });
        }
    </script>
</div>
@stop
