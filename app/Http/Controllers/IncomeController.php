<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Income;

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
        return [
            'title' => 'required|unique:posts|max:255',
            'body' => 'required',
        ];
    }

    protected function validator($data)
    {
        return Validator::make($data, $this->rules());
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $incomes = Income::where('user_id', '=', $user->id)->with('category')->get();
        return view('incomes.list', $incomes);
    }

    protected function create(Request $request)
    {
        if ($request->isMethod('get')) {
            return viev('incomes.create');
        }
    }

    protected function store(Request $request)
    {
        $data = $request->all();
        $validator = $this->validator($data);

        if ($validator->fails()) {
            return redirect('incomes/list')
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();
        $income = Income::create($data);
        $income->user()->save($user);

        if (empty($income)) {

          $error = [
              //toDo: hacer errores
          ];
          return redirect('incomes/list')
              ->withErrors($error)
              ->withInput();
        }

    }
}
