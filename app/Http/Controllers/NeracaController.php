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
                $query->whereHas('journal', function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('transaction_date', [$startDate, $endDate]);
                });
            }
        }])->get()->groupBy('klasifikasi');

        // Hitung total saldo setiap subKlasifikasi dan klasifikasi
        $balances = $accounts->map(function ($accountsByKlasifikasi, $klasifikasi) use ($startDate) {
            $klasifikasiTotalDebit = 0;
            $klasifikasiTotalCredit = 0;

            $subKlasifikasiData = $accountsByKlasifikasi->groupBy('subKlasifikasi')->map(function ($group, $subKlasifikasi) use (&$klasifikasiTotalDebit, &$klasifikasiTotalCredit, $startDate) {
                $totalDebit = 0;
                $totalCredit = 0;

                // Hitung saldo untuk masing-masing akun dalam subKlasifikasi
                $accountData = $group->map(function ($account) use (&$totalDebit, &$totalCredit, $startDate) {
                    // Hitung debit dan kredit dalam periode yang dipilih
                    $debit = $account->journal_entries->sum('debit');
                    $credit = $account->journal_entries->sum('credit');
                    $balance = $debit - $credit;

                    // Hitung saldo awal sebelum tanggal mulai periode
                    $initialDebit = $account->journal_entries()
                        ->whereHas('journal', function ($query) use ($startDate) {
                            $query->whereDate('transaction_date', '<', $startDate);
                        })->sum('debit');

                    $initialCredit = $account->journal_entries()
                        ->whereHas('journal', function ($query) use ($startDate) {
                            $query->whereDate('transaction_date', '<', $startDate);
                        })->sum('credit');

                    $initialBalance = $initialDebit - $initialCredit;

                    // Saldo akhir (saldo awal + saldo berjalan selama periode)
                    $finalBalance = $initialBalance + $balance;

                    // Tambahkan ke total subKlasifikasi
                    $totalDebit += $debit;
                    $totalCredit += $credit;

                    return [
                        'account_number' => $account->account_number,
                        'account_name' => $account->name,
                        'initial_balance' => $initialBalance,
                        'debit' => $debit,
                        'credit' => $credit,
                        'balance' => $balance,
                        'final_balance' => $finalBalance,
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
        // // Hitung saldo awal dan saldo akhir total
        // $initial_balance = Account::whereHas('journal_entries.journals', function ($query) use ($startDate) {
        //     $query->whereDate('transaction_date', '<', $startDate);
        // })->sum('balance');

        // $final_balance = $initial_balance + $balances->sum('totalBalance');

        return view('neracas.index', compact('balances'));
    }
}
