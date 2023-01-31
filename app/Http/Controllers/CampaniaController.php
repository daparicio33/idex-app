<?php

namespace App\Http\Controllers;

use App\Models\Acampania;
use App\Models\AdmisionePostulante;
use App\Models\Campania;
use App\Models\Cliente;
use App\Models\Estudiante;
use App\Models\Pmedico;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CampaniaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        return $this->middleware('auth');
    }
    public function index()
    {
        //
        $campanias = Campania::orderBy('id','desc')->get();
        return view('salud.campanias.index',compact('campanias'));
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
    public function show(Request $request, $id)
    {
        //
        dd($request);
    }
    public function csv(Request $request, $id){
        try {
            //code...
            DB::beginTransaction();
            $numero=0;
            $error = 0;
            $campania = Campania::findOrFail($id);
            if($request->hasFile('csv')){
                $file = $request->file('csv');
                $f = fopen($file, 'r');
                $linea = 0;
                while (($datos = fgetcsv($f,0,';')) !== false){
                    //ingresamos una nueva linea
                    if($linea != 0){
                        $estudiante = Estudiante::whereHas('postulante.cliente',function($query) use($datos){
                            $query->where('dniRuc','=',$datos[0]);
                        })->first();
                        if(isset($estudiante->id)){
                            //insertamos perfil médico
                            $pmedico = new Pmedico();
                            $pmedico->lab_gs = $datos[12];
                            $pmedico->lab_fs = $datos[13];
                            $pmedico->nutri_talla = $datos[14];
                            $pmedico->estudiante_id = $estudiante->id;
                            $pmedico->save();
                            //insertamos la atencion
                            //vamos a sacar la numeracion
                            $ultima_atencion = Acampania::orderBy('numero','desc')->first();
                            if(isset($ultima_atencion->numero)){
                                $numero = $ultima_atencion->numero + 1;
                            }else{
                                $numero=1;
                            }
                            //registro la atencion de la campaña
                            $acampania = new Acampania();
                            $acampania->numero=$numero;
                            $acampania->estudiante_id=$estudiante->id;
                            $acampania->campania_id=$campania->id;
                            $acampania->fecha=Carbon::now();
                            $acampania->user_id=auth()->id();
                            $acampania->vitales_fc=0;
                            $acampania->vitales_fr=0;
                            $acampania->vitales_sys=$datos[5];
                            $acampania->vitales_dia=$datos[6];
                            $acampania->vitales_temperatura=$datos[1];
                            $acampania->vitales_saturacion=$datos[2];
                            $acampania->nutri_peso=$datos[3];
                            $acampania->nutri_perimetro=$datos[4];
                            $acampania->lab_glicemia=$datos[7];
                            $acampania->lab_trigliceridos=$datos[9];
                            $acampania->lab_colesterol=$datos[8];
                            $acampania->lab_hto=$datos[10];
                            $acampania->lab_hemoglobina=$datos[11];
                            $acampania->save();
                        }else{
                            $error++;
                        }
                    }
                    $linea ++;
                }   
                fclose($f);
            }
            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            return Redirect::route('salud.campanias.index')->with('error',$th->getMessage());
        }
        return Redirect::route('salud.campanias.index')->with('info','se subio de forma masiva todos los usuario');

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