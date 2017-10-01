<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Expense;
use App\Income;
use App\Category;
use Jenssegers\Agent\Agent;
use Validator;

class ReportController extends Controller
{
    private $agent;
    private $isMobile;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->agent = new Agent();
        $this->isMobile = ($this->agent->isMobile() || $this->agent->isTablet()) ? 1 : 0;

        $this->middleware('auth');
    }

    protected function monthList(Request $request)
    {
        $isMobile = $this->isMobile;

        $currentMonthExpenses =  Expense::where('user_id', $request->user()->id)->where('expense_date', '>=', date('Y-m-01'))->with('category')->orderBy('expense_date', 'asc')->get();
        $currentMonth  =  Income::where('user_id', $request->user()->id)->where('income_date', '>=', date('Y-m-01'))->with('category')->orderBy('income_date', 'asc')->get();

        foreach ($currentMonthExpenses as $expense) {
            $expense->class = 'Gasto';
            $expense->date = strtotime($expense->expense_date);
            $expense->date_formatted = date('d/m', strtotime($expense->expense_date));
            $expense->amount_formatted = number_format($expense->amount, 2, ',', '.');
        }

        foreach ($currentMonth as $income) {
            $income->class = 'Ingreso';
            $income->date = strtotime($income->income_date);
            $income->date_formatted = date('d/m', strtotime($income->income_date));
            $income->amount_formatted = number_format($income->amount, 2, ',', '.');
        }

        $currentMonth = $currentMonth->merge($currentMonthExpenses);

        return view('reports.current_month_list', compact('currentMonth', 'isMobile'));
    }
}