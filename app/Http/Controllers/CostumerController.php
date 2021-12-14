<?php

namespace App\Http\Controllers;

use App\Costumer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CostumerController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('costumers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return response()->json($request);

        $costumer = Costumer::create([
            'name' => $request->name,
            'company_name' => $request->company_name,
            'status_id' => 1
        ]);

        return response()->json($costumer);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Costumer  $costumer
     * @return \Illuminate\Http\Response
     */
    public function show(Costumer $costumer)
    {
        $costumers = Costumer::where('status_id', '!=', 3)->get();

        return response()->json($costumers);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Costumer  $costumer
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $costumer = Costumer::find($id);

        return response()->json($costumer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Costumer  $costumer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $costumer = Costumer::find($request->id);

        $costumer->name = $request->name;
        $costumer->company_name = $request->company_name;
        $costumer->save();

        return response()->json($costumer);
    }

    public function changeStatus(Request $request)
    {
        $costumer = Costumer::find($request->id);

        $costumer->status_id = $request->status;
        $costumer->save();

        return response()->json($costumer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Costumer  $costumer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Costumer $costumer)
    {
        //
    }
}
