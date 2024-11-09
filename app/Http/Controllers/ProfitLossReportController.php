<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\JournalEntry;
use App\Models\Expense;
use App\Models\Taxe; // Model pajak
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProfitLossReportController extends Controller
{
    public function index(Request $request)
    {
        // Ambil rentang tanggal dari request
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        // Ambil akun yang memiliki klasifikasi terkait dengan Pendapatan dan Beban
        $accounts = Account::with(['journal_entries' => function ($query) use ($startDate, $endDate) {
            $query->whereHas('journals', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('transaction_date', [$startDate, $endDate]);
            });
        }])->get();

        // Data Pendapatan: Ambil akun-akun dengan klasifikasi 'Pendapatan' dan ambil debit-nya
        $revenueData = [];
        $totalRevenue = 0;
        foreach ($accounts as $account) {
            if ($account->klasifikasi) {
                foreach ($account->journal_entries as $entry) {
                    $revenueData[] = [
                        'account_number' => $account->account_number,
                        'account_name' => $account->name,
                        'debit' => $entry->debit,
                        'classification' => $account->klasifikasi,
                    ];
                    $totalRevenue += $entry->debit;
                }
            }
        }

        // Data Beban: Ambil akun-akun dengan klasifikasi 'Beban' dan ambil credit-nya
        $expenseData = [];
        $totalExpenses = 0;
        foreach ($accounts as $account) {
            if ($account->klasifikasi) {
                foreach ($account->journal_entries as $entry) {
                    $expenseData[] = [
                        'account_number' => $account->account_number,
                        'account_name' => $account->name,
                        'credit' => $entry->credit,
                        'classification' => $account->klasifikasi,
                    ];
                    $totalExpenses += $entry->credit;
                }
            }
        }

        // Ambil data pajak dengan relasi akun
        $taxes = Taxe::whereBetween('tax_date', [$startDate, $endDate])->with('account')->get();
        $taxData = $taxes->map(function ($tax) {
            return [
                'account_number' => $tax->account->account_number,
                'account_name' => $tax->account->name,
                'amount' => $tax->rate,
            ];
        });

        // Ambil data expense dalam rentang tanggal
        $expenses = Expense::whereBetween('payment_date', [$startDate, $endDate])->with('account')->get();
        $expensessData = $expenses->map(function ($expensess) {
            return [
                'account_number' => $expensess->account->account_number,
                'account_name' => $expensess->account->name,
                'amount' => $expensess->amount,
            ];
        });

        // Gabungkan pajak dan pengeluaran ke dalam total beban
        $totalTaxes = $taxData->sum('amount');
        $totalExpenses += $totalTaxes;
        $totalExpenses += $expenses->sum('amount');

        // Hitung laba bersih
        $netProfit = $totalRevenue - $totalExpenses;

        // Kirim data ke view
        return view('reports.index', compact(
            'accounts', 'totalRevenue', 'totalExpenses', 'netProfit',
            'startDate', 'endDate', 'revenueData', 'taxData', 'expenseData', 'expensessData'
        ));
    }
}
