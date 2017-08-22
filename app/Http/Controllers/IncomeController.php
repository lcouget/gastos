<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Income;
use App\Category;
use Validator;

class IncomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
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
        $incomes = Income::where('user_id', $user->id)->with('category')->get();

        return view('incomes.list', compact('incomes'));
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

            return view('incomes.add', compact('categories'));
        } else {
            $data = $request->all();
            $incomeDate = explode('/', $data['income_date']);
            $data['income_date'] = $incomeDate[2] . '-' . $incomeDate[1] . '-' . $incomeDate[0];

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
                  //toDo: hacer errores
              ];
              return redirect('ingreso/agregar')
                  ->withErrors($error)
                  ->withInput();
            }

            return redirect('ingreso/listar'); // toDo: ver mensajes de success
        }
    }

    protected function edit (Request $request, $id)
    {
        //ToDo...
    }

    protected function delete (Request $request, $id)
    {
        //ToDo...
    }
}
