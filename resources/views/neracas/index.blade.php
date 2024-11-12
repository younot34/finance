@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Neraca</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-balance-scale"></i> Neraca</h4>
                </div>

                <div class="card-body">
                    <!-- Form Filter Tanggal -->
                    <form action="{{ route('neracas.index') }}" method="GET" class="form-inline mb-4">
                        <div class="form-group mr-2">
                            <label for="start_date" class="mr-2">Start date:</label>
                            <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                        </div>
                        <div class="form-group mr-2">
                            <label for="end_date" class="mr-2">End date:</label>
                            <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Show</button>
                    </form>

                    <!-- Tabel Data Neraca -->
                    <div class="table-responsive">
                        <center><strong><p>RSU AISYIYAH PURWOREJO</p></strong></center>
                        <center><strong><p>NERACA</p></strong></center>
                        <center><strong><p class="text-muted">{{ \Carbon\Carbon::parse(request('start_date'))->translatedFormat('F Y') }}</p></strong></center>

                        <!-- Menampilkan Saldo Awal di Atas Tabel -->

                        @foreach ($balances as $balance)
                            <h5 class="text-right font-weight-bold">Saldo Awal: {{ number_format($initial_balance, 2) }}</h5>
                            <h4 class="mt-4">{{ $balance['klasifikasi'] }}</h4>
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>Account Details</th>
                                        <th class="text-right">Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($balance['subKlasifikasi'] as $subBalance)
                                        <tr>
                                            <td><strong>{{ $subBalance['subKlasifikasi'] }}</strong></td>
                                            <td></td>
                                        </tr>
                                        @foreach ($subBalance['accounts'] as $account)
                                            <tr>
                                                <td style="padding-left: 40px;">{{ $account['account_number'] }} {{ $account['account_name'] }}</td>
                                                <td class="text-right">{{ number_format($account['balance'], 2) }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td class="font-weight-bold" style="padding-left: 40px;">Total {{ $subBalance['subKlasifikasi'] }}</td>
                                            <td class="text-right font-weight-bold"><strong><hr></strong>{{ number_format($subBalance['totalBalance'], 2) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td class="font-weight-bold">Total {{ $balance['klasifikasi'] }}</td>
                                        <td class="text-right font-weight-bold"><strong><hr></strong>{{ number_format($balance['totalBalance'], 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <h5 class="text-right font-weight-bold mt-4">Saldo Akhir: {{ number_format($final_balance, 2) }}</h5>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    h4 {
        font-size: 1.5em;
        font-weight: bold;
        color: #4a4a4a;
    }
    table {
        width: 100%;
        margin-top: 10px;
    }
    table tbody tr td:first-child {
        font-family: 'Courier New', Courier, monospace;
    }
    table tbody tr td {
        padding: 8px 0;
    }
    table tbody tr td.level-1 {
        padding-left: 20px;
    }
    table tbody tr td.level-2 {
        padding-left: 40px;
    }
    table tbody tr td.level-3 {
        padding-left: 60px;
    }
</style>
@stop
