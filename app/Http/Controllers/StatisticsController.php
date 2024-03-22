<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Carbon\Carbon;
class StatisticsController extends Controller
{
    //

    public function getGeneralStatistics(Request $request){

        $title = "Estadisticas generales";

        $dia_inicio = Carbon::now()->subDays(30)->startOfDay();
        $dia_fin = Carbon::now()->endOfDay();
        $citas = \App\Models\MedicalConsultation::whereDate('consultation_date', '>=', $dia_inicio)->whereDate('consultation_date', '<=', $dia_fin)->groupBy('status')->selectRaw('COUNT(*) as cantidad, status')->get();

        $citasDia = \App\Models\MedicalConsultation::
                whereDate('consultation_date', '>=', $dia_inicio)
                ->whereDate('consultation_date', '<=', $dia_fin)
                ->groupBy('status')
                ->groupBy(\DB::raw('Date(consultation_date)'))
                ->selectRaw('COUNT(*) as cantidad, status, Date(consultation_date) as consultation_date')->get();

        $citasPorDia = [
            'Domingo' => [],
            'Lunes' => [],
            'Martes' => [],
            'Miercoles' => [],
            'Jueves' => [],
            'Viernes' => [],
            'Sabado' => [],
        ];


        foreach($citasDia as $cita){
            if(Carbon::parse($cita->consultation_date)->dayOfWeek == Carbon::SUNDAY)
                $citasPorDia['Domingo'][] = $cita;
            if(Carbon::parse($cita->consultation_date)->dayOfWeek == Carbon::MONDAY)
                $citasPorDia['Lunes'][] = $cita;
            if(Carbon::parse($cita->consultation_date)->dayOfWeek == Carbon::TUESDAY)
                $citasPorDia['Martes'][] = $cita;
            if(Carbon::parse($cita->consultation_date)->dayOfWeek == Carbon::WEDNESDAY)
                $citasPorDia['Miercoles'][] = $cita;
            if(Carbon::parse($cita->consultation_date)->dayOfWeek == Carbon::THURSDAY)
                $citasPorDia['Jueves'][] = $cita;
            if(Carbon::parse($cita->consultation_date)->dayOfWeek == Carbon::FRIDAY)
                $citasPorDia['Viernes'][] = $cita;
            if(Carbon::parse($cita->consultation_date)->dayOfWeek == Carbon::SATURDAY)
                $citasPorDia['Sabado'][] = $cita;
        }

        $doctores = \App\Models\User::leftjoin('doctor_hierarchies', 'doctor_hierarchies.id','users.doctor_hierarchy_id')->where('rol', 'DOCTOR')->groupBy('hierarchy')
            ->selectRaw('count(*) as cantidad, hierarchy')->get();


        $asistenciasQuirofano = \App\Models\User::leftjoin('doctor_hierarchies', 'doctor_hierarchies.id','users.doctor_hierarchy_id')
            ->leftjoin('attendance', 'attendance.doctor_id', 'users.id')
            ->where('rol', 'DOCTOR')->where('resident',1)->where('attendance.type','OPERATING_ROOM_ATTENDANCE')
            ->groupBy('hierarchy')
            ->whereDate('attendance_date', '>=', $dia_inicio)->whereDate('attendance_date', '<=', $dia_fin)
            ->selectRaw('count(*) as cantidad, hierarchy')->get();

        $morbilidad = \App\Models\Morbidity::
        whereDate('created_at', '>=', $dia_inicio)->whereDate('created_at', '<=', $dia_fin)
        ->groupBy(\DB::raw('Date(created_at)'))->orderBy('fecha', 'ASC')
        ->selectRaw('COUNT(*) as cantidad, Date(created_at) as fecha')->get();



        return view('admin.estadisticas.general-statistics', compact([
            'title',
            'citas',
            'citasPorDia',
            'doctores',
            'asistenciasQuirofano',
            'morbilidad',
        ]));
    }

}
