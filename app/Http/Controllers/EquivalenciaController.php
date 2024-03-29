<?php

namespace App\Http\Controllers;

use App\Models\Mformativo;
use App\Models\Udidactica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class EquivalenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        //
        $unidades = Udidactica::where('udidactica_id','!=',NULL)->get();
        return view('sacademica.equivalencias.index',compact('unidades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $modulos = Mformativo::all();
        $unidades = Udidactica::orderBy('nombre','asc')->get();
        return view('sacademica.equivalencias.create',compact('unidades'));
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
        try {
            //code...
            $oldunidad = Udidactica::findOrFail($request->old_id);
            $oldunidad->udidactica_id = $request->new_id;
            $oldunidad->update();
        } catch (\Throwable $th) {
            //throw $th;
            return Redirect::route('sacademica.equivalencias.index')->with('error',$th->getMessage());
        }
        return Redirect::route('sacademica.equivalencias.index')->with('info','se guardo la equivalencia correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $unidad = Udidactica::findOrFail($id);
        $unidad->udidactica_id = NULL;
        $unidad->update();
        return Redirect::route('sacademica.equivalencias.index')->with('info','se elimino la equivalencia correctamente');
    }
}
