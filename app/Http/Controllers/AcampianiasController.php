<?php

namespace App\Http\Controllers;

use App\Models\Acampania;
use App\Models\AdmisionePostulante;
use App\Models\Campania;
use App\Models\Cliente;
use App\Models\Estudiante;
use App\Models\Pmedico;
use App\Models\Sdo;
use Carbon\Carbon;
use Facade\FlareClient\Http\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class AcampianiasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:salud.acampanias.index')->only('index');
        $this->middleware('can:salud.acampanias.create')->only('create','store');
        $this->middleware('can:salud.acampanias.edit')->only('edit','update');
        $this->middleware('can:salud.acampanias.destroy')->only('destroy');
        $this->middleware('can:salud.acampanias.show')->only('show');
    }
    public function index(Request $request)
    {
        //
        $searchText = null;
        if(isset($request->searchText)){
            $atenciones = Acampania::whereHas('estudiante.postulante.cliente',function($query) use($request){
                $query->where('dniRuc','like','%'.$request->searchText.'%')
                ->orWhere('apellido','like','%'.$request->searchText.'%')
                ->orWhere('nombre','like','%'.$request->searchText.'%');
            })->get();
            $searchText = $request->searchText;
        }else{
            $atenciones = Acampania::orderBy('id','desc')->paginate(20);
        }
        $sexos = [
            'Femenino'=>'Femenino',
            'Masculino'=>'Masculino'
        ];
        $gss = [
            'ND'=>'ND',
            'A'=>'A',
            'B'=>'B',
            'O'=>'O',
            'AB'=>'AB'
        ];
        $fss = [
            'ND'=>'ND',
            '+'=>'+',
            '-'=>'-'
        ];
        $psi = [
            'Sin diagnostico'=>'Sin diagnostico',
            'Necesita tarapia psicológica'=>'Necesita tarapia psicológica',
            'Necesita consejo y orientación psicológica'=>'Necesita consejo y orientación psicológica',
            'Paciente estable'=>'Paciente estable'
        ];
        $campanias = Campania::orderBy('id','desc')->pluck('nombre','id')->toArray();
        return view('salud.acampanias.index',compact('atenciones','sexos','gss','fss','campanias','searchText','psi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $sexos = [
            'Femenino'=>'Femenino',
            'Masculino'=>'Masculino'
        ];
        $gss = [
            'ND'=>'ND',
            'A'=>'A',
            'B'=>'B',
            'O'=>'O',
            'AB'=>'AB'
        ];
        $fss = [
            'ND'=>'ND',
            '+'=>'+',
            '-'=>'-'
        ];
        $psi = [
            'Sin diagnostico'=>'Sin diagnostico',
            'Necesita tarapia psicológica'=>'Necesita tarapia psicológica',
            'Necesita consejo y orientación psicológica'=>'Necesita consejo y orientación psicológica',
            'Paciente estable'=>'Paciente estable'
        ];
        $campanias = Campania::orderBy('id','desc')->pluck('nombre','id')->toArray();
        if(isset($request->buscar_dni)){
            $dni = $request->buscar_dni;
            $estudiante = Estudiante::whereHas('postulante.cliente',function($query) use($dni) {
                $query->where('dniRuc','=',$dni);
            })->first();
            return view('salud.acampanias.create',compact('estudiante','sexos','campanias','gss','fss','psi'));
        }
        return view('salud.acampanias.create');
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
            DB::beginTransaction();
            //code...
            //y el numero de la atencion
            $numero = Acampania::orderBy('numero','desc')->first()->numero+1;
            //actualizar el cliente
            $cliente = Cliente::findOrFail($request->idCliente);
            $cliente->telefono = $request->telefono;
            $cliente->telefono2 = $request->telefono2;
            $cliente->direccion = $request->direccion;
            $cliente->update();
            //actualizamos la postulacion
            $estudiante = Estudiante::findOrFail($request->estudiante_id);
            $postulante = AdmisionePostulante::findOrFail($estudiante->admisione_postulante_id);
            $postulante->fechaNacimiento = $request->fechaNacimiento;
            $postulante->sexo = $request->sexo;
            $postulante->save();
            //creamos le atencion de la campaña
            $acampania = new Acampania();
            $acampania->numero = $numero;
            $acampania->psi_resultado = $request->psi_resultado;
            $acampania->estudiante_id = $request->estudiante_id;
            $acampania->campania_id = $request->campania_id;
            $acampania->vitales_temperatura = $request->vitales_temperatura;
            $acampania->vitales_fc = $request->vitales_fc;
            $acampania->vitales_fr = $request->vitales_fr;
            $acampania->vitales_saturacion = $request->vitales_saturacion;
            $acampania->vitales_sys = $request->vitales_sys;
            $acampania->vitales_dia = $request->vitales_dia;
            $acampania->nutri_peso = $request->nutri_peso;
            $acampania->nutri_perimetro = $request->nutri_perimetro;
            $acampania->lab_glicemia = $request->lab_glicemia;
            $acampania->lab_trigliceridos = $request->lab_trigliceridos;
            $acampania->lab_colesterol = $request->lab_colesterol;
            $acampania->lab_hto = $request->lab_hto;
            $acampania->lab_hemoglobina = $request->lab_hemoglobina;
            $acampania->user_id = auth()->id();
            $acampania->fecha = Carbon::now();
            $acampania->save();
            //creamos el perfil
            Pmedico::updateOrCreate(['estudiante_id' => $request->estudiante_id],
            ['lab_gs' => $request->lab_gs,'lab_fs' => $request->lab_fs,'nutri_talla' => $request->nutri_talla]);
            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return Redirect::route('salud.acampanias.index')->with('error',$th->getMessage());
        }
        return Redirect::route('salud.acampanias.index')->with('info','se registro los datos correctamente');
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
        $sdo = Sdo::findOrFail($id);
        return view('salud.acampanias.show',compact('sdo'));
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
        $sexos = [
            'Femenino'=>'Femenino',
            'Masculino'=>'Masculino'
        ];
        $gss = [
            'ND'=>'ND',
            'A'=>'A',
            'B'=>'B',
            'O'=>'O',
            'AB'=>'AB'
        ];
        $fss = [
            'ND'=>'ND',
            '+'=>'+',
            '-'=>'-'
        ];
        $psi = [
            'Sin diagnostico'=>'Sin diagnostico',
            'Necesita tarapia psicológica'=>'Necesita tarapia psicológica',
            'Necesita consejo y orientación psicológica'=>'Necesita consejo y orientación psicológica',
            'Paciente estable'=>'Paciente estable'
        ];
        $campanias = Campania::orderBy('id','desc')->pluck('nombre','id')->toArray();
        $acampania = Acampania::findOrFail($id);
        return view('salud.acampanias.edit',compact('sexos','gss','fss','acampania','campanias','psi'));
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
        try {
            DB::beginTransaction();
            //code...
            $acampania = Acampania::findOrFail($id);
            //actualizar el cliente
            $cliente = Cliente::findOrFail($request->idCliente);
            $cliente->telefono = $request->telefono;
            $cliente->telefono2 = $request->telefono2;
            $cliente->direccion = $request->direccion;
            $cliente->update();
            //actualizamos la postulacion
            $estudiante = Estudiante::findOrFail($request->estudiante_id);
            $postulante = AdmisionePostulante::findOrFail($estudiante->admisione_postulante_id);
            $postulante->fechaNacimiento = $request->fechaNacimiento;
            $postulante->sexo = $request->sexo;
            $postulante->save();
            //actualizamos la atencion de la campaña
            $acampania = Acampania::findOrFail($id);
            $acampania->psi_resultado = $request->psi_resultado;
            $acampania->estudiante_id = $request->estudiante_id;
            $acampania->campania_id = $request->campania_id;
            $acampania->vitales_temperatura = $request->vitales_temperatura;
            $acampania->vitales_fc = $request->vitales_fc;
            $acampania->vitales_fr = $request->vitales_fr;
            $acampania->vitales_saturacion = $request->vitales_saturacion;
            $acampania->vitales_sys = $request->vitales_sys;
            $acampania->vitales_dia = $request->vitales_dia;
            $acampania->nutri_peso = $request->nutri_peso;
            $acampania->nutri_perimetro = $request->nutri_perimetro;
            $acampania->lab_glicemia = $request->lab_glicemia;
            $acampania->lab_trigliceridos = $request->lab_trigliceridos;
            $acampania->lab_colesterol = $request->lab_colesterol;
            $acampania->lab_hto = $request->lab_hto;
            $acampania->lab_hemoglobina = $request->lab_hemoglobina;
            $acampania->user_id = auth()->id();
            $acampania->fecha = Carbon::now();
            $acampania->update();
            //creamos el perfil
            Pmedico::updateOrCreate([
                'estudiante_id' => $request->estudiante_id,
                'lab_gs' => $request->lab_gs,
                'lab_fs' => $request->lab_fs,
                'nutri_talla' => $request->nutri_talla,
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return Redirect::route('salud.acampanias.index')->with('error',$th->getMessage());
        }
        return Redirect::route('salud.acampanias.index')->with('info','se actualizo los datos correctamente');
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
        try {
            $acampania = Acampania::findOrFail($id);
            $acampania->delete();
        } catch (\Throwable $th) {
            //throw $th;
            return Redirect::route('salud.acampanias.index')->with('error',$th->getMessage());
        }
        return Redirect::route('salud.acampanias.index')->with('info','se elimino el registro correctamente');
    }
}
