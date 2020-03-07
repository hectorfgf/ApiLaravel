<?php

namespace App\Http\Controllers;

use App\Fruta;
use Illuminate\Http\Request;

class FrutaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $frutas = Fruta::all();
        return response()->json(['message' => 'success', 'frutas' => $frutas],200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'size' => 'required|in:pequeño,mediano,grande',
            'color' => 'string',
        ]);
        $fruta = Fruta::create($request->all());

        return response()->json(['message' => 'success', 'fruta' => $fruta],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fruta = Fruta::findOrFail($id);
        return response()->json(['message' => 'success', 'fruta' => $fruta],200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'size' => 'required|in:pequeño,mediano,grande',
            'color' => 'string',
        ]);
        $fruta = Fruta::findOrFail($id)->update($request->all());

        return response()->json(['message' => 'success'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fruta = Fruta::findOrFail($id);
        if($fruta->delete()){
            return response()->json(['message' => 'success'],200);
        }
        return response()->json(['message' => 'error', 'error' => 'Cannot delete the element'], 409);

    }
}
