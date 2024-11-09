<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Carbon\Carbon;

class NeracaController extends Controller
{
    public function index(Request $request)
    {
        // Ambil rentang tanggal dari request
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        // Ambil akun-akun dengan jurnal entri dan filter berdasarkan transaction_date di tabel journals
        $accounts = Account::with(['journal_entries' => function ($query) use ($startDate, $endDate) {
            if ($startDate && $endDate) {
                $query->whereHas('journals', function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('transaction_date', [$startDate, $endDate]);
                });
            }
        }])->get()->groupBy('klasifikasi');

        // Hitung total saldo setiap subKlasifikasi dan klasifikasi
        $balances = $accounts->map(function ($accountsByKlasifikasi, $klasifikasi) {
            $klasifikasiTotalDebit = 0;
            $klasifikasiTotalCredit = 0;

            $subKlasifikasiData = $accountsByKlasifikasi->groupBy('subKlasifikasi')->map(function ($group, $subKlasifikasi) use (&$klasifikasiTotalDebit, &$klasifikasiTotalCredit) {
                $totalDebit = 0;
                $totalCredit = 0;

                // Hitung saldo untuk masing-masing akun dalam subKlasifikasi
                $accountData = $group->map(function ($account) use (&$totalDebit, &$totalCredit) {
                    $debit = $account->journal_entries->sum('debit');
                    $credit = $account->journal_entries->sum('credit');
                    $balance = $debit - $credit;

                    // Tambahkan ke total subKlasifikasi
                    $totalDebit += $debit;
                    $totalCredit += $credit;

                    return [
                        'account_number' => $account->account_number,
                        'account_name' => $account->name,
                        'debit' => $debit,
                        'credit' => $credit,
                        'balance' => $balance,
                    ];
                });

                // Tambahkan saldo subKlasifikasi ke total klasifikasi
                $klasifikasiTotalDebit += $totalDebit;
                $klasifikasiTotalCredit += $totalCredit;

                return [
                    'subKlasifikasi' => $subKlasifikasi,
                    'accounts' => $accountData,
                    'totalDebit' => $totalDebit,
                    'totalCredit' => $totalCredit,
                    'totalBalance' => $totalDebit - $totalCredit,
                ];
            });

            return [
                'klasifikasi' => $klasifikasi,
                'subKlasifikasi' => $subKlasifikasiData,
                'totalDebit' => $klasifikasiTotalDebit,
                'totalCredit' => $klasifikasiTotalCredit,
                'totalBalance' => $klasifikasiTotalDebit - $klasifikasiTotalCredit,
            ];
        });

        return view('neracas.index', compact('balances'));
    }
}
