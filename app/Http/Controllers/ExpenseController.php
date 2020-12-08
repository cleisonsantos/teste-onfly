<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        # code...
        $this->middleware('auth');
    }
    public function index()
    {
        //
        $expense = Expense::all();
        return response()->json($expense);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $expense = new Expense();
        $user = Auth::id();
        $expense->user = $user;
        $expense->description = $request->description;
        $expense->expense_date = $request->expenseDate;
        $expense->amount = $request->amount;
        $file = $request->picture;
        $expense->picture = $file->store('despesa');
        $expense->save();
        return 'Despesa salva!';
        //var_dump($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        //
        $expense->description = $request->description;
        $expense->expense_date = $request->expenseDate;
        $expense->amount = $request->amount;
        $picture = $request->picture;
        // var_dump($picture);
        if (is_object($picture)) {
            $oldPicture = '/' . $expense->picture;
            if (Storage::disk('public')->exists($oldPicture)) {
                Storage::disk('public')->delete($oldPicture);
            }
            $expense->picture = $picture->store('despesa');
        }
        $expense->save();
        // var_dump($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        //
        $picture = '/' . $expense->picture;
        if (Storage::disk('public')->exists($picture)) {
            Storage::disk('public')->delete($picture);
        }
        $expense->delete();
        return 'Deletado!';
    }
}
