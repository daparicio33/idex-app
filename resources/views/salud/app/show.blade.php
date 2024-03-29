@extends('layouts.saludcontenido')
@section('menu')
<div class="flex w-full pt-2 content-center justify-between md:w-1/3 md:justify-end">
    <ul class="list-reset flex justify-between flex-1 md:flex-none items-center">
        <li class="flex-1 md:flex-none md:mr-3">
            <div class="relative inline-block">
                <button onclick="toggleDD('myDropdown')" class="drop-button text-white py-2 px-2"> <span class="pr-2"><i class="fas fa-users fa-2x"></i></span> Hola, {{ $estudiante->postulante->cliente->nombre }}</button>
                <div id="myDropdown" class="dropdownlist absolute bg-gray-800 text-white right-0 mt-3 p-3 overflow-auto z-30 invisible">
                    <a href="{{ route('salud.app.profile',$estudiante->id) }}" class="p-2 hover:bg-gray-800 text-white text-sm no-underline hover:no-underline block"><i class="fa fa-user fa-fw fa-2x"></i> Perfil</a>
                    <a href="https://carnetvacunacion.minsa.gob.pe/" class="p-2 hover:bg-gray-800 text-white text-sm no-underline hover:no-underline block"><i class="fas fa-syringe fa-2x"></i> Vacunas</a>
                    <a href="{{ route('salud.app.herramientas',$estudiante->id) }}" class="p-2 hover:bg-gray-800 text-white text-sm no-underline hover:no-underline block"><i class="fas fa-balance-scale fa-2x"></i> Herramientas</a>
                    <div class="border border-gray-800"></div>
                    <a href="{{ route('salud.app.index') }}" class="p-2 hover:bg-gray-800 text-white text-sm no-underline hover:no-underline block"><i class="fas fa-sign-out-alt fa-fw fa-2x"></i> Cerrar</a>
                </div>
            </div>
        </li>
    </ul>
</div>
@stop
@section('cuerpo')
<div id="main" class="main-content flex-1 bg-gray-100 mt-12 md:mt-2 pb-24 md:pb-5">
    @if($estudiante->acampanias->count()>0)
    <div class="bg-gray-800 pt-14">
        <div class="rounded-tl-3xl bg-gradient-to-r from-blue-900 to-gray-800 p-4 shadow text-2xl text-white">
            <h5 class="font-bold pl-2">Perfil Médico.</h5>
        </div>
    </div>
    <div class="flex flex-wrap"> 
        <div class="w-full md:w-1/2 xl:w-1/3 p-6">
            <!--Metric Card-->
            <div class="bg-gradient-to-b from-red-200 to-red-100 border-b-4 border-red-600 rounded-lg shadow-xl p-5">
                    <p class="mb-3">
                        <i class="fas fa-balance-scale fa-2x"></i> <b>Peso</b> {{ $estudiante->acampanias[0]->nutri_peso }} Kg.
                    </p>
                    <p class="mb-3">
                        <i class="fas fa-ruler-vertical fa-2x"></i> <b>Talla</b> {{ $estudiante->pmedico->nutri_talla }} cm.
                    </p>
                    <p class="mb-3">
                        <i class="fas fa-circle-notch fa-2x"></i> <b>Perímetro Abdominal</b> {{ $estudiante->acampanias[0]->nutri_perimetro }} cm.
                    </p>
                    <p class="mb-3">
                        <i class="fas fa-syringe fa-2x"></i> <b>Grupo Sanguineo</b> {{ $estudiante->pmedico->lab_gs }}
                    </p>
                    <p class="mb-3">
                        <i class="fas fa-prescription fa-2x"></i> <b>Factor Sanguineo</b> {{ $estudiante->pmedico->lab_fs }}
                    </p> 
            </div>
            <!--/Metric Card-->
        </div>
    </div>
    @endif 

    {{-- datos del alumno --}}
    <div class="bg-gray-800 pt-14">
        <div class="rounded-tl-3xl bg-gradient-to-r from-blue-900 to-gray-800 p-4 shadow text-2xl text-white">
            <h5 class="font-bold pl-2">Bienvenida IDEX.</h5>
        </div>
    </div>
    <div class="flex flex-wrap">                    
        <div class="w-full md:w-1/2 xl:w-1/3 p-6">
            <!--Metric Card-->
                                  
            <div class="bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-xl p-5">
                <h3 style="font-size: 2rem">Español</h3>  
                <p style="text-align: justify">La presente iniciativa nace en la investigación denominada: herramienta informática con enfoque intercultural para seguimiento de los estudiantes de un instituto superior tecnológico Perú Japón, 2022, la misma que mantiene como objetivo principal: determinar la relación de una herramienta informática con enfoque intercultural para seguimiento de los estudiantes de un Instituto Superior Tecnológico Perú Japón, 2022, planteando el reaprovechamiento del uso de las tecnologías digitales  y el fomento de la interculturalidad en nuestra casa de estudios siendo modelo a todas las instituciones educativas de nuestro País.
                    Proponemos modelos de apertura de oportunidades, con aumento de la productividad, eficiencia de las actividades humanas, tomar decisiones acertadas y reducción de posibilidad de errores.
                </p>
                <p style="text-align: right;color: rgb(67, 67, 240)">(Creador) Dr. Manuel Jesús Quispe Narváez	CEP 67230</p>
                <p style="text-align: right;color: rgb(67, 67, 240)">(Desarrollador) P.T. Davis Aparicio Palomino</p>
                <p style="text-align: right;color: rgb(67, 67, 240)">(Traductor) Est. Agronegocios. Jhakson Yampis Puancha</p>
            </div>
            <!--/Metric Card-->
        </div>
        <div class="w-full md:w-1/2 xl:w-1/3 p-6">
            <!--Metric Card-->
            <div class="bg-gradient-to-b from-pink-200 to-pink-100 border-b-4 border-pink-500 rounded-lg shadow-xl p-5">
                <h3 style="font-size: 2rem">Awajun</h3>  
                <p style="text-align: justify">Juu takatak nagkamnae wají autusa diyamu daáji: “herramienta informática con enfoque intercultural para seguimiento de los estudiantes de un instituto superior tecnológico Perú Japón, 2022”, aántsag émamkemas umigtatamujin: “determinar la relación de una herramienta informática con enfoque intercultural para seguimiento de los estudiantes de un Instituto Superior Tecnológico Perú Japón, 2022”, tecnologías digitales tawa nuunú awagki takaku aántsag interculturalidad iína jeén, papií augtainum augmatku, íina nugkee País taji nui instituciones educativas ayaá dushakam juna takatan diísa unuimagtinme tusa. 
                    Taji nuka, takat diísa emamaina nú, takamain ayanú ujantinme tamauwa nú pachisa, wají juwamua nú dukap awagmaunum, emamkesa takat aents takatai ainanui, shiíg anentaimja umiamu antsag dewamaina nú ujumak awasatatamau. 
                </p>
                <p style="text-align: right;color: rgb(241, 65, 45)">(Creador) Dr. Manuel Jesús Quispe Narváez	CEP 67230</p>
                <p style="text-align: right;color: rgb(241, 65, 45)">(Desarrollador) P.T. Davis Aparicio Palomino</p>
                <p style="text-align: right;color: rgb(241, 65, 45)">(Traductor) Est. Agronegocios. Jhakson Yampis Puancha</p>
            </div>
            <!--/Metric Card-->
        </div>
    </div>
@stop