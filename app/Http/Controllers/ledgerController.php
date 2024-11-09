<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\JournalEntry;
use App\Models\Journal;
use Illuminate\Http\Request;
use Carbon\Carbon;


class ledgerController extends Controller
{
    public function index(Request $request)
    {
        $startDate = Carbon::parse($request->start_date);  // Menggunakan Carbon untuk mem-parsing tanggal
        $endDate = Carbon::parse($request->end_date);
        $accountId = $request->account_id;

        // Ambil transaksi berdasarkan filter yang dipilih, dengan join ke tabel journals untuk mengambil transaction_date
        $transactions = JournalEntry::with('account') // Load relationship with accounts
            ->join('journals', 'journal_entries.journal_id', '=', 'journals.id')
            ->where('journal_entries.account_id', $accountId)
            ->whereBetween('journals.transaction_date', [$startDate, $endDate])
            ->orderBy('journals.transaction_date')
            ->get();

        // Hitung total debit dan kredit
        $total_debit = $transactions->sum('debit');
        $total_credit = $transactions->sum('credit');

        // Ambil akun yang tersedia
        $accounts = Account::all();

        // Hitung saldo awal berdasarkan akun yang dipilih (jika ada)
        $opening_balance = $this->getOpeningBalance($accountId, $startDate);

        return view('ledgers.index', compact('transactions', 'accounts', 'total_debit', 'total_credit', 'opening_balance'));
    }

    private function getOpeningBalance($accountId, $startDate)
    {
        // Logika untuk mendapatkan saldo awal, sesuaikan dengan kebutuhan Anda
        $opening_balance = JournalEntry::join('journals', 'journal_entries.journal_id', '=', 'journals.id')
            ->where('journal_entries.account_id', $accountId)
            ->where('journals.transaction_date', '<', $startDate)
            ->sum('debit') - JournalEntry::join('journals', 'journal_entries.journal_id', '=', 'journals.id')
            ->where('journal_entries.account_id', $accountId)
            ->where('journals.transaction_date', '<', $startDate)
            ->sum('credit');

        return $opening_balance;
    }

}
