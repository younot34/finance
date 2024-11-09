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
                    <form action="{{ route('journals.store') }}" method="POST" enctype="multipart/form-data">
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
                                        <input type="date" name="transaction_date" class="form-control">
                                    </td>
                                    <td>
                                        <select type="text" name="account_id[]" class="form-control">
                                            <option value="">Select Account</option>
                                            @foreach($accounts as $account)
                                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="no_ref[]" class="form-control" placeholder="No ref">
                                    </td>
                                    <td>
                                        <input type="text" name="description[]" class="form-control" placeholder="Description">
                                    </td>
                                    <td>
                                        <input type="number" name="debit[]" class="form-control">
                                    </td>
                                    <td>
                                        <input type="number" name="credit[]" class="form-control">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i> SIMPAN</button>
                        <button class="btn btn-light" type="button" id="adddataButton">TAMBAH DATA</button>
                        <button class="btn btn-warning btn-reset" type="reset"><i class="fa fa-redo"></i> RESET</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        const journalContainer = document.getElementById('journal-container');

        function addNoRefListener(input) {
            input.addEventListener('input', function() {
                const noRef = input.value;

                if (noRef) {
                    fetch(`/check-no-ref?no_ref=${noRef}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.exists) {
                                swal({
                                    title: "No. Ref sudah ada!",
                                    text: "Apakah Anda ingin melanjutkan?",
                                    icon: "warning",
                                    buttons: [
                                        'YA',
                                        'TIDAK'
                                    ],
                                    dangerMode: true,
                                }).then((response) => {
                                    if (response.isConfirmed) {
                                        swal({
                                            title: "Lanjutkan!",
                                            text: "Anda memilih untuk melanjutkan.",
                                            icon: "success",
                                            showConfirmButton: true,
                                            showCancelButton: false,
                                        });
                                    } else {
                                        window.location.href = "{{ route('journals.index') }}";
                                    }
                                });
                            }
                        })
                        .catch(error => console.error('Error:', error)); // Tambahkan log error jika ada masalah
                }
            });
        }

        // Pasang event listener ke semua no_ref input yang ada
        document.querySelectorAll('input[name="no_ref[]"]').forEach(addNoRefListener);

            // Event listener untuk tombol TAMBAH DATA
            document.getElementById('adddataButton').addEventListener('click', function() {
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td></td>
                    <td>
                        <select name="account_id[]" class="form-control">
                            <option value="">Select Account</option>
                            @foreach($accounts as $account)
                                <option value="{{ $account->id }}">{{ $account->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text" name="no_ref[]" class="form-control" placeholder="No ref">
                    </td>
                    <td>
                        <input type="text" name="description[]" class="form-control" placeholder="Description">
                    </td>
                    <td>
                        <input type="number" name="debit[]" class="form-control">
                    </td>
                    <td>
                        <input type="number" name="credit[]" class="form-control">
                    </td>
                `;
                journalContainer.appendChild(newRow);

                // Pasang event listener pada input no_ref yang baru
                const newNoRefInput = newRow.querySelector('input[name="no_ref[]"]');
                addNoRefListener(newNoRefInput);
            });
        });
    </script>
</div>
@stop
