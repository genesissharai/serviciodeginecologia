<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\DailyAttendance;
use \App\Models\OperatingRoomAttendance;

class AttendanceController extends Controller
{
    //


    public function dailyAttendanceView(Request $request){
        $searchTerms = $request->input();
        $doctors = \App\Models\User::where('rol',"DOCTOR")->where('status',1)->get();
        $jerarquiasDoctor = \App\Models\DoctorHierarchy::all();
        $action = '/asistencia_diaria';
        $attendances =
            DailyAttendance::
            when($request->fecha_inicio, function($q) use($request){
                $q->whereDate('attendance_date', ">=" , ($request->fecha_inicio));
            })
            ->when($request->fecha_fin, function($q) use($request){
                $q->whereDate('attendance_date', "<=" ,  ($request->fecha_fin));
            })
            ->when(($request->name), function($q) use($request){
                $q->whereHas('doctor', function($q2)  use($request){
                    $q2->where(function($q3) use($request){
                        $q3->where("name", "like", "%$request->name%")
                            ->orWhere("last_name", "like", "%$request->name%");
                    });
                });
            })
            ->when(($request->email), function($q) use($request){
                $q->whereHas('doctor', function($q2)  use($request){
                    $q2->where("email", $request->email);
                });
            })
            ->when(($request->ci), function($q) use($request){
                $q->whereHas('doctor', function($q2)  use($request){
                    $q2->where("ci", $request->ci);
                });
            })
            ->when(($request->doctor_hierarchy_id), function($q) use($request){
                $q->whereHas('doctor', function($q2)  use($request){
                    $q2->whereHas('doctorHierarchy',function($q3) use($request){
                        $q3->where("doctor_hierarchy_id", $request->doctor_hierarchy_id);
                    });
                });
            })
            ->where('type', strtoupper("daily_attendance"))
            ->orderBy('attendance_date','DESC')
            ->orderBy('id','DESC')
            ->paginate(100);
            $title = "Asistencia diaria";

            return view('admin.asistencias.asistencia-diaria', compact([
                'title',
                'action',
                'doctors',
                'attendances',
                'jerarquiasDoctor',
                'searchTerms',
            ]));

    }

    public function operatingRoomAttendanceView(Request $request){
        $searchTerms = $request->input();
        $doctors = \App\Models\User::where('rol',"DOCTOR")->where('status',1)->whereHas('doctorHierarchy', function($q){
            $q->where('doctor_hierarchies.resident', 1);
        })->get();
        $jerarquiasDoctor = \App\Models\DoctorHierarchy::where('resident',1)->get();
        $action = '/asistencia_quirofano';
        $attendances =
            OperatingRoomAttendance::
            when($request->fecha_inicio, function($q) use($request){
                $q->whereDate('attendance_date', ">=" , ($request->fecha_inicio));
            })
            ->when($request->fecha_fin, function($q) use($request){
                $q->whereDate('attendance_date', "<=" ,  ($request->fecha_fin));
            })
            ->when(($request->name), function($q) use($request){
                $q->whereHas('doctor', function($q2)  use($request){
                    $q2->where(function($q3) use($request){
                        $q3->where("name", "like", "%$request->name%")
                            ->orWhere("last_name", "like", "%$request->name%");
                    });
                });
            })
            ->when(($request->email), function($q) use($request){
                $q->whereHas('doctor', function($q2)  use($request){
                    $q2->where("email", $request->email);
                });
            })
            ->when(($request->ci), function($q) use($request){
                $q->whereHas('doctor', function($q2)  use($request){
                    $q2->where("ci", $request->ci);
                });
            })
            ->when(($request->doctor_hierarchy_id), function($q) use($request){
                $q->whereHas('doctor', function($q2)  use($request){
                    $q2->whereHas('doctorHierarchy',function($q3) use($request){
                        $q3->where("doctor_hierarchy_id", $request->doctor_hierarchy_id);
                    });
                });
            })
            ->where('type', strtoupper("operating_room_attendance"))
            ->orderBy('attendance_date','DESC')
            ->orderBy('id','DESC')
            ->paginate(100);
            $title = "Asistencia a quirofano";

            return view('admin.asistencias.asistencia-quirofano', compact([
                'title',
                'action',
                'doctors',
                'attendances',
                'jerarquiasDoctor',
                'searchTerms',
            ]));

    }

    public function storeDailyAttendance(Request $request){
        \DB::beginTransaction();
        try {

            $attendance = new DailyAttendance;
            $attendance->doctor_id = $request->user_id;
            $attendance->attendance_date = $request->attendance_date;
            $attendance->type = strtoupper("daily_attendance");
            $attendance->save();
            session()->flash("success", "Asistencia registgrada con exito");

            \DB::commit();

            return redirect()->back()->withInput();
        } catch (\Throwable $th) {
            //throw $th;
            \DB::rollback();
            return redirect()->back()->withErrors(["errors" => "Algo ha fallado"]);

        }
    }

    public function deleteDailyAttendance(Request $request){
        \DB::beginTransaction();
        try{
            $attendance = DailyAttendance::find($request->attendance_id);
            $attendance->delete();
            session()->flash("success", "Asistencia eliminada con exito");

            \DB::commit();

            return redirect()->back();
        }catch(\Exception $e){
            \DB::rollback();
            \Log::info($e);
            return redirect()->back()->withErrors(["errors" => "Algo ha fallado"]);
        }
    }

    public function storeOperatingRoomAttendance(Request $request){
        \DB::beginTransaction();
        try {

            $attendance = new OperatingRoomAttendance;
            $attendance->doctor_id = $request->user_id;
            $attendance->attendance_date = $request->attendance_date;
            $attendance->subject = $request->subject;
            $attendance->type = strtoupper("operating_room_attendance");
            $attendance->save();
            session()->flash("success", "Asistencia registgrada con exito");

            \DB::commit();

            return redirect()->back()->withInput();
        } catch (\Throwable $th) {
            //throw $th;
            \DB::rollback();
            return redirect()->back()->withErrors(["errors" => "Algo ha fallado"]);

        }
    }

    public function deleteOperatingRoomAttendance(Request $request){
        \DB::beginTransaction();
        try{
            $attendance = OperatingRoomAttendance::find($request->attendance_id);
            $attendance->delete();
            session()->flash("success", "Asistencia eliminada con exito");

            \DB::commit();

            return redirect()->back();
        }catch(\Exception $e){
            \DB::rollback();
            \Log::info($e);
            return redirect()->back()->withErrors(["errors" => "Algo ha fallado"]);
        }
    }
}
