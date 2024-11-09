@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Laporan Laba Rugi</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-balance-scale"></i> Laporan Laba Rugi</h4>
                </div>

                <div class="card-body">
                    <!-- Form Filter Tanggal -->
                    <form action="{{ route('reports.index') }}" method="GET" class="form-inline mb-4">
                        <div class="form-group mr-2">
                            <label for="start_date" class="mr-2">Tanggal Mulai:</label>
                            <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                        </div>
                        <div class="form-group mr-2">
                            <label for="end_date" class="mr-2">Tanggal Akhir:</label>
                            <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Tampilkan</button>
                    </form>

                    <!-- Tabel Laba Rugi -->
                    <div class="table-responsive">
                        <center><strong><p>RSU AISYIYAH PURWOREJO</p></strong></center>
                        <center><strong><p>LAPORAN LABA RUGI</p></strong></center>
                        <center><strong><p class="text-muted">{{ \Carbon\Carbon::parse(request('start_date'))->translatedFormat('F Y') }} - {{ \Carbon\Carbon::parse(request('end_date'))->translatedFormat('F Y') }}</p></strong></center>

                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>Account Detail</th>
                                    <th class="text-right">Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data Pendapatan -->
                                <tr><td><strong>Pendapatan</strong></td></tr>
                                @foreach($revenueData as $revenue)
                                    @if($revenue['debit'] > 0) <!-- Pastikan ada nilai debit -->
                                        <tr>
                                            <td>{{ $revenue['account_number'] }} - {{ $revenue['account_name'] }} ({{ $revenue['classification'] }})</td>
                                            <td class="text-right">{{ number_format($revenue['debit'], 2) }}</td>
                                        </tr>
                                    @endif
                                @endforeach

                                <!-- Total Pendapatan -->
                                <tr>
                                    <td><strong>Total Pendapatan</strong></td>
                                    <td class="text-right"><hr>{{ number_format($totalRevenue, 2) }}<hr></td>
                                </tr>

                                <!-- Data Beban (credit) -->
                                <tr><td><strong>Beban</strong></td></tr>
                                @foreach($expenseData as $expense)
                                    @if($expense['credit'] > 0) <!-- Pastikan ada nilai credit -->
                                        <tr>
                                            <td>{{ $expense['account_number'] }} - {{ $expense['account_name'] }} ({{ $expense['classification'] }})</td>
                                            <td class="text-right">{{ number_format($expense['credit'], 2) }}</td>
                                        </tr>
                                    @endif
                                @endforeach

                                <!-- Data Expense -->
                                @foreach($expensessData as $expensess)
                                    @if($expensess['amount'] > 0) <!-- Pastikan ada nilai amount -->
                                        <tr>
                                            <td>{{ $expensess['account_number'] }} - {{ $expensess['account_name'] }}</td>
                                            <td class="text-right">{{ number_format($expensess['amount'], 2) }}</td>
                                        </tr>
                                    @endif
                                @endforeach

                                <!-- Data Pajak -->
                                @foreach($taxData as $tax)
                                    @if($tax['amount'] > 0) <!-- Pastikan ada nilai amount -->
                                        <tr>
                                            <td>{{ $tax['account_number'] }} - {{ $tax['account_name'] }}</td>
                                            <td class="text-right">{{ number_format($tax['amount'], 2) }}</td>
                                        </tr>
                                    @endif
                                @endforeach

                                <!-- Total Pengeluaran -->
                                <tr>
                                    <td><strong>Total Beban</strong></td>
                                    <td class="text-right"><hr>{{ number_format($totalExpenses, 2) }}</td>
                                </tr>

                                <!-- Laba Bersih -->
                                <tr>
                                    <td class="font-weight-bold"><strong>Laba Bersih</strong></td>
                                    <td class="text-right font-weight-bold"><hr>{{ number_format($netProfit, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<style>
    /* CSS untuk tampilan akar pohon */
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
    /* Indentasi bertingkat untuk sub-klasifikasi */
    table tbody tr td {
        padding: 8px 0;
    }
    /* Atur padding untuk elemen sesuai level hirarki */
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
@endsection
