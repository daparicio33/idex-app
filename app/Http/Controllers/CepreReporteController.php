<?php

namespace App\Http\Controllers;

use App\Models\Cepre;
use App\Models\CepreEstudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CepreReporteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:cepres.reportes.index')->only('index');
        $this->middleware('can:cepres.reportes.create')->only('create','store');
        $this->middleware('can:cepres.reportes.edit')->only('edit','update');
        $this->middleware('can:cepres.reportes.destroy')->only('destroy');
        $this->middleware('can:cepres.reportes.show')->only('show');
    }
    public function index(Request $request)
    {
        //
        $cepres = Cepre::orderBy('periodoCepre','desc')->pluck('periodoCepre','idCepre')->toArray();
        if(isset($request->idCepre)){
            $cepre = Cepre::findOrFail($request->idCepre);
            $estudiantes = CepreEstudiante::where('idCepre','=',$cepre->idCepre)->get();
            $programas = DB::table('cepre_estudiantes as ce')
            ->select('c.nombreCarrera as programa',DB::raw("count(*) as cantidad"))
            ->join('ccarreras as c','c.idCarrera','=','ce.idCarrera')
            ->where('ce.idCepre','=',$cepre->idCepre)
            ->groupBy('c.nombreCarrera')
            ->get();
            return view('cepres.reportes.index',compact('cepres','cepre','estudiantes','programas'));
        }
        return view('cepres.reportes.index',compact('cepres'));
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
    }
}
