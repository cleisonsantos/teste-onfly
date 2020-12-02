<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illumminate\Support\Facades\Auth;

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
        $user = Auth::user();
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
        $expense->description = $request->description;
        $expense->amount = $request->amount;
        $expense->picture = $request->picture;
        $expense->user = $request->user;
        $expense->save();
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
        $expense = Expense::all();
        return ($expense);
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
        $expense->amount = $request->amount;
        $expense->picture = $request->picture;
        $expense->user = $request->user;
        $expense->save();
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
        $expense->delete();
    }
}
