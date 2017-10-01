<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Expense;
use App\Category;
use Jenssegers\Agent\Agent;
use Validator;

class ExpenseController extends Controller
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $doubleRegex = "/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/";

        return [
            'expense_date' => 'required|date',
            'amount' => 'required',
        ];
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $isMobile = $this->isMobile;
        $expenses = Expense::where('user_id', $user->id)->with('category')->orderBy('expense_date', 'asc')->get();

        foreach ($expenses as $expense) {
            $expense->expense_date_formatted = date('d/m', strtotime($expense->expense_date));
            $expense->amount_formatted = number_format($expense->amount, 2, ',', '.');
        }

        return view('expenses.list', compact('expenses','isMobile'));
    }

    protected function add(Request $request)
    {
        if ($request->isMethod('get')) {
            //carga de formulario de
            $categories = Category::with('categoryType')
                ->where('active', 1)
                ->where('category_type_id', 2) // toDo: ver como filtrar bien por nombre de categoria
                ->orderBy('category')
                ->get();

            $isMobile = $this->isMobile;

            return view('expenses.add', compact('categories', 'isMobile'));
        } else {

            $data = $request->all();

            //validaciones
            if (empty($data['category_id'])) {
                $request->session()->flash('alert-danger', 'Se debe especificar la categoría.');
                return back()->withInput();
            }

            if (empty($data['expense_date'])) {
                $request->session()->flash('alert-danger', 'Se debe especificar la fecha de ingreso.');
                return back()->withInput();
            }

            if (empty($data['amount'])) {
                $request->session()->flash('alert-danger', 'Se debe especificar el monto a ingresar.');
                return back()->withInput();
            }

            //seteo de fecha...
            if (!$this->isMobile) {
                $expenseDate = explode('/', $data['expense_date']);
                $data['expense_date'] = $expenseDate[2] . '-' . $expenseDate[1] . '-' . $expenseDate[0];
            }

            $data['amount'] = doubleval($data['amount']);

            $validator = Validator::make($data, $this->rules());
            if ($validator->fails()) {
                return redirect('gasto/agregar')
                    ->withErrors($validator)
                    ->withInput();
            }

            $data['user_id'] = Auth::user()->id;
            $expense = Expense::create($data);

            if (empty($expense)) {
              $error = [
                 'msg' => 'Se ha producido un error inesperado. Por favor vuelva a intentarlo.'
              ];
              return back()
                  ->withErrors($error)
                  ->withInput();
            }

            $request->session()->flash('alert-success', 'Se ha agregado el gasto satisfactoriamente.');
            return redirect('gasto/listar');
        }
    }

    /**
     * { function_description }
     *
     * @param      \Illuminate\Http\Request  $request  The request
     * @param      <type>                    $id       The identifier
     */
    protected function edit(Request $request, $id)
    {
        if ($request->isMethod('get')) {

            $expense = Expense::where('id', $id)->first();

            $expenseDate = explode('-', $expense->expense_date);
            $expense->expense_date_formatted = $expenseDate[2] . '/' . $expenseDate[1] . '/' . $expenseDate[0];

            $categories = Category::with('categoryType')
                ->where('active', 1)
                ->where('category_type_id', 2) // toDo: ver como filtrar bien por nombre de categoria
                ->orderBy('category')
                ->get();

            $isMobile = $this->isMobile;

            return view('expenses.edit', compact('categories', 'expense', 'isMobile'));
        } else {
            $data = $request->all();

            //validaciones
            if (empty($data['category_id'])) {
                $request->session()->flash('alert-danger', 'Se debe especificar la categoría.');
                return back()->withInput();
            }

            if (empty($data['expense_date'])) {
                $request->session()->flash('alert-danger', 'Se debe especificar la fecha de gasto.');
                return back()->withInput();
            }

            if (empty($data['amount'])) {
                $request->session()->flash('alert-danger', 'Se debe especificar el monto a ingresar.');
                return back()->withInput();
            }

            //seteo de fecha...
            if (!$this->isMobile) {
                $expenseDate = explode('/', $data['expense_date']);
                $data['expense_date'] = $expenseDate[2] . '-' . $expenseDate[1] . '-' . $expenseDate[0];
            }

            $data['amount'] = doubleval($data['amount']);

            $validator = Validator::make($data, $this->rules());
            if ($validator->fails()) {
                return redirect('gasto/agregar')
                    ->withErrors($validator)
                    ->withInput();
            }

            $data['user_id'] = Auth::user()->id;
            $expense = Expense::where('id', $id)->first();

            if (!empty($expense)) {
                $expense->update($data);
            } else {
              $error = [
                 'msg' => 'Se ha producido un error inesperado. Por favor vuelva a intentarlo.'
              ];
              return back()
                  ->withErrors($error)
                  ->withInput();
            }

            $request->session()->flash('alert-success', 'Se ha modificado el gasto satisfactoriamente.');
            return redirect('gasto/listar');
        }
    }

    /**
     * { function_description }
     *
     * @param      \Illuminate\Http\Request  $request  The request
     * @param      <type>                    $id       The identifier
     *
     * @return     <type>                    ( description_of_the_return_value )
     */
    protected function delete (Request $request, $id)
    {
        $expense = expense::where('id', $id)->first();
        $expense->delete();

        $request->session()->flash('alert-success', 'Se ha borrado el gasto satisfactoriamente.');
        return redirect('gasto/listar');
    }
}
