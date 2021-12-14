<?php

namespace App\Http\Controllers;

use App\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::where('status_id', '!=', 3)->get();

        return view('sections.index', ["secciones" =>  $sections]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sections.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required|string',
            'name' => 'required|string',
            'price' => 'required',
        ]);

        $section = Section::create([
            'code' => $request->code,
            'name' => $request->name,
            'price' => $request->price,
            'status_id' => 1
        ]);

        return response()->json(['response' => 200]);
    }

    public function changeStatus(Request $request)
    {
        $section = Section::find($request->id);

        $section->status_id = $request->status;
        $section->save();

        return response()->json($section);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $section = Section::find($id);

        return view('sections.edit', ['seccion' => $section]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // dd($request);
        $section = Section::find($request->id);

        $section->code = $request->code;
        $section->name = $request->name;
        $section->price = $request->price;

        if($section->save()) {
            return back()->with('response', 200);
        } else {
            return back()->with('response', 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
        //
    }
}
