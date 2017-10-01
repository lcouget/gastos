<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Income;
use App\Category;
use Jenssegers\Agent\Agent;
use Validator;

class IncomeController extends Controller
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
            'income_date' => 'required|date',
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
        $incomes = Income::where('user_id', $user->id)->with('category')->get();

        foreach ($incomes as $income) {
            $income->income_date_formatted = date('d-M', strtotime($income->income_date));
            $income->amount_formatted = number_format($income->amount, 2, ',', '.');
        }

        return view('incomes.list', compact('incomes', 'isMobile'));
    }

    protected function add(Request $request)
    {
        if ($request->isMethod('get')) {
            //carga de formulario de
            $categories = Category::with('categoryType')
                ->where('active', 1)
                ->where('category_type_id', 1) // toDo: ver como filtrar bien por nombre de categoria
                ->orderBy('category')
                ->get();

            $isMobile = $this->isMobile;

            return view('incomes.add', compact('categories', 'isMobile'));
        } else {

            $data = $request->all();

            //validaciones
            if (empty($data['category_id'])) {
                $request->session()->flash('alert-danger', 'Se debe especificar la categoría.');
                return back()->withInput();
            }

            if (empty($data['income_date'])) {
                $request->session()->flash('alert-danger', 'Se debe especificar la fecha de ingreso.');
                return back()->withInput();
            }

            if (empty($data['amount'])) {
                $request->session()->flash('alert-danger', 'Se debe especificar el monto a ingresar.');
                return back()->withInput();
            }

            //seteo de fecha...
            if (!$this->isMobile) {
                $incomeDate = explode('/', $data['income_date']);
                $data['income_date'] = $incomeDate[2] . '-' . $incomeDate[1] . '-' . $incomeDate[0];
            }

            $data['amount'] = doubleval($data['amount']);

            $validator = Validator::make($data, $this->rules());
            if ($validator->fails()) {
                return redirect('ingreso/agregar')
                    ->withErrors($validator)
                    ->withInput();
            }

            $data['user_id'] = Auth::user()->id;
            $income = Income::create($data);

            if (empty($income)) {
              $error = [
                 'msg' => 'Se ha producido un error inesperado. Por favor vuelva a intentarlo.'
              ];
              return back()
                  ->withErrors($error)
                  ->withInput();
            }

            $request->session()->flash('alert-success', 'Se ha agregado el ingreso satisfactoriamente.');
            return redirect('ingreso/listar');
        }
    }

    /**
     * { function_description }
     *
     * @param      \Illuminate\Http\Request  $request  The request
     * @param      <type>                    $id       The identifier
     */
    protected function edit (Request $request, $id)
    {
        if ($request->isMethod('get')) {

            $income = Income::where('id', $id)->first();

            $incomeDate = explode('-', $income->income_date);
            $income->income_date_formatted = $incomeDate[2] . '/' . $incomeDate[1] . '/' . $incomeDate[0];

            $categories = Category::with('categoryType')
                ->where('active', 1)
                ->where('category_type_id', 1) // toDo: ver como filtrar bien por nombre de categoria
                ->orderBy('category')
                ->get();

            $isMobile = $this->isMobile;

            return view('incomes.edit', compact('categories', 'income', 'isMobile'));
        } else {
            $data = $request->all();

            //validaciones
            if (empty($data['category_id'])) {
                $request->session()->flash('alert-danger', 'Se debe especificar la categoría.');
                return back()->withInput();
            }

            if (empty($data['income_date'])) {
                $request->session()->flash('alert-danger', 'Se debe especificar la fecha de ingreso.');
                return back()->withInput();
            }

            if (empty($data['amount'])) {
                $request->session()->flash('alert-danger', 'Se debe especificar el monto a ingresar.');
                return back()->withInput();
            }

            //seteo de fecha...
             if (!$this->isMobile) {
                $incomeDate = explode('/', $data['income_date']);
                $data['income_date'] = $incomeDate[2] . '-' . $incomeDate[1] . '-' . $incomeDate[0];
            }

            $data['amount'] = doubleval($data['amount']);

            $validator = Validator::make($data, $this->rules());
            if ($validator->fails()) {
                return redirect('ingreso/agregar')
                    ->withErrors($validator)
                    ->withInput();
            }

            $data['user_id'] = Auth::user()->id;
            $income = Income::where('id', $id)->first();

            if (!empty($income)) {
                $income->update($data);
            } else {
              $error = [
                 'msg' => 'Se ha producido un error inesperado. Por favor vuelva a intentarlo.'
              ];
              return back()
                  ->withErrors($error)
                  ->withInput();
            }

            $request->session()->flash('alert-success', 'Se ha modificado el ingreso satisfactoriamente.');
            return redirect('ingreso/listar');
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
        $income = Income::where('id', $id)->first();
        $income->delete();

        $request->session()->flash('alert-success', 'Se ha borrado el ingreso satisfactoriamente.');
        return redirect('ingreso/listar');
    }
}
