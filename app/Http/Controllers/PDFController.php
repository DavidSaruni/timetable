<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class PDFController extends Controller
{
    public function groupPDF(Request $request)
    {
        $table = $request->table.'_group_schema';
        $group_id = $request->group_id;
        $group = DB::table($request->table.'_groups')->where('group_id', $group_id)->first();
        $school = DB::table($request->table.'_schools')->where('school_id', $group->school_id)->first();
        $cohort = $group->cohort_id;
        $locations = DB::table($request->table.'_locations')->where('cohort_id', $cohort)->get();
        $locationsDays = [];
        foreach($locations as $location){
            $locationsDays[] = $location->day;
        }
        $group_schema = DB::table($table)->where('group_id', $group_id)->orderBy('schema_id', 'asc')->get();
        $structure = DB::table($table)->where('group_id', $group_id)->where('day_of_week', 'Monday')->orderBy('schema_id', 'asc')->get();
        $break = null;
        // get the earliest start time and latest end time
        $start = $structure->min('start_time');
        $end = $structure->max('end_time');
        // get the number of hours between the start and end time
        $hours = strtotime($end) - strtotime($start);
        // get the number of slots in the day
        $slots = $structure->count();
        if($hours > $slots){
            $startTimes0 = $structure->pluck('start_time');
            $endTimes0 = $structure->pluck('end_time');
            // get the hours that are only in the start times
            $startTimes = $startTimes0->diff($endTimes0);
            $endTimes = $endTimes0->diff($startTimes0);
            // remove the hour equal to the start time
            $startTimes = $startTimes->filter(function($value, $key) use ($start){
                return $value != $start;
            });
            $endTimes = $endTimes->filter(function($value, $key) use ($end){
                return $value != $end;
            });
            // save the break hour
            $break_end = $startTimes->first();
            $break_start = $endTimes->first();
            $break = $break_start.' - '.$break_end;
        }
        $skeleton = [];
        foreach($structure as $slot){
            $skeleton[] = [
                'start_time' => $slot->start_time,
                'end_time' => $slot->end_time,
                'break' => 'no'
            ];
        }
        if($break != null){
            $skeleton[] = [
                'start_time' => $break_start,
                'end_time' => $break_end,
                'break' => 'yes'
            ];
        }
        // sort the skeleton by start time
        usort($skeleton, function($a, $b){
            return strtotime($a['start_time']) - strtotime($b['start_time']);
        });
        # remember to add the break
        // break, chapel, '' #class
        // colspan, #colspan
        // unit_name, unit_code, lecturer_name, building, room_name
        $cells = collect();
        foreach($group_schema->keyBy('day_of_week') as $day => $slot){
            $cells[$day] = collect();
            $day_slots = $group_schema->where('day_of_week', $day);
            // check if $day is in $locationsDays
            if(!in_array($day, $locationsDays)){
                if($break != null){
                    $cells[$day]->push([
                        'class' => 'break',
                        'colspan' => 1,
                        'start_time' => $break_start,
                        'unit_name' => '',
                        'unit_code' => '',
                        'lecturer_name' => '',
                        'building' => '',
                        'room_name' => ''
                    ]);
                }
            }
            if($day == 'Wednesday'){
                // check if there is a group with a full day session
                $fd = 0;
                foreach($day_slots as $cell){
                    if($cell->session_id != null){
                        $session = DB::table($request->table.'_sessions')->where('id', $cell->session_id)->first();
                        if($session->is_full_day == 1){
                            $fd = 1;
                            break;
                        }
                    }
                }
                if($fd != 1)
                {
                    $cells[$day]->push([
                        'class' => 'chapel',
                        'colspan' => 2,
                        'start_time' => '11:00:00',
                        'unit_name' => '',
                        'unit_code' => '',
                        'lecturer_name' => '',
                        'building' => '',
                        'room_name' => ''
                    ]);
                }
            }
            $sesh = [];
            foreach($day_slots as $cell){
                if($cell->session_id != null){
                    // check if the session_id is in the array
                    if(in_array($cell->session_id, $sesh)){
                        continue;
                    }
                    else{
                        $sesh[] = $cell->session_id;
                    }
                    $session = DB::table($request->table.'_sessions')->where('id', $cell->session_id)->first();
                    $class = '';
                    if($session->is_lab == 1){
                        $lab = DB::table($request->table.'_labs')->where('lab_id', $cell->lab_id)->first();
                        $building = $lab->name;
                        $lecturer_name = 'Lab Session';
                        $room_name = $lab->lab_name;
                    }
                    elseif($session->is_full_day == 1){
                        $location = DB::table($request->table.'_locations')->where('id', $cell->location_id)->first();
                        $building = $location->name;
                        $lecturer_name = 'Full Day Session';
                        $room_name = '';
                        $class = 'full-day';
                    }
                    else{
                        $lecturer = DB::table($request->table.'_lecturers')->where('user_id', $session->lecturer_id)->first();
                        $lectureroom = DB::table($request->table.'_lecturerooms')->where('lecture_room_id', $cell->lectureroom_id)->first();
                        $building = $lectureroom->name;
                        $lecturer_name = $lecturer->title.' '.$lecturer->lecturer_name;
                        $room_name = $lectureroom->lecture_room_name;
                    }
                    $slotCount = count($day_slots->where('session_id', $cell->session_id));
                    if($session->is_full_day == 1 && $break != null){
                        $slotCount = $session->lecturer_hours;
                    }
                    $cells[$day]->push([
                        'class' => $class,
                        'colspan' => $slotCount,
                        'start_time' => $cell->start_time,
                        'unit_name' => $session->unit_name,
                        'unit_code' => $session->unit_code,
                        'lecturer_name' => $lecturer_name,
                        'building' => $building,
                        'room_name' => $room_name
                    ]);
                }
                else{
                    $cells[$day]->push([
                        'class' => 'break',
                        'colspan' => 1,
                        'start_time' => $cell->start_time,
                        'unit_name' => '',
                        'unit_code' => '',
                        'lecturer_name' => '',
                        'building' => '',
                        'room_name' => ''
                    ]);
                }
            }
        }
        $cohort_name = $group->cohort_name;
        if($group->group_name != "Default")
        {
            $cohort_name .= " - Group ".$group->group_name;
        }
        $data = [];
        $data['group'] = $group;
        $data['school'] = $school;
        $data['school_name'] = $school->school_name;
        $data['instance'] = $request->instance_name;
        $data['instance_id'] = $request->instance_id;
        $data['gen'] = $request->gen;
        $data['cohort_name'] = $cohort_name;
        return view('pdf.group', compact('group_schema', 'data', 'skeleton', 'cells'));
        // $pdf = PDF::loadView('pdf.group', compact('group_schema', 'data', 'skeleton', 'cells'));
        // return $pdf->download($cohort_name.' '.$request->instance_name.'.pdf');
    }

    public function individualPDF(Request $request)
    {
        $table = $request->table.'_group_schema';
        $lecturer_id = $request->lecturer_id;
        $lecturer = DB::table($request->table.'_lecturers')->where('user_id', $lecturer_id)->first();
        $start = '07:00:00';
        $end = '19:00:00';
        $hours = strtotime($end) - strtotime($start);
        $slots = $hours / 3600;
        $structure = DB::table($table)->where('lecturer_id', $lecturer_id)->orderBy('schema_id', 'asc')->get();
        $cells = collect();
        $lecturer_schema = collect();

        // Define the weekdays and hours of the day
        $weekdays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $hours = range(7, 18);
        $i = 0;

        // Loop over each weekday and hour of the day
        foreach ($weekdays as $weekday) {
            foreach ($hours as $hour) {
                $start_time = sprintf('%02d:00:00', $hour);
                $end_time = sprintf('%02d:00:00', $hour + 1);

                // Add a new schema for the current weekday and hour
                $lecturer_schema->push([
                    'uid' => $i++,
                    'class' => "break",
                    'colspan' => null,
                    'unit_name' => null,
                    'unit_code' => null,
                    'building' => null,
                    'room_name' => null,
                    'group' => null,
                    'lab_name' => null,
                    'day_of_week' => $weekday,
                    'start_time' => $start_time,
                    'end_time' => $end_time
                ]);
            }
        }

        // Update the existing items in the collection
        $structure = $structure->sortBy('day_of_week')->sortBy('start_time');
        $lecturer_schema = $lecturer_schema->map(function ($item) use ($structure, $request) {
            $day = $item['day_of_week'];
            $start_time = $item['start_time'];
            $end_time = $item['end_time'];
            $map = $structure->where('day_of_week', $day)->where('start_time', $start_time)->where('end_time', $end_time)->first();
            if ($map) {
                $sesh = DB::table($request->table.'_sessions')->where('id', $map->session_id)->first();
                $item['class'] = null;
                $item['colspan'] = null;
                $item['unit_name'] = $sesh->unit_name;
                $item['unit_code'] = $sesh->unit_code;
                if($sesh->is_lab == 1){
                    $lab = DB::table($request->table.'_labs')->where('lab_id', $map->lab_id)->first();
                    $item['building'] = $lab->name;
                    $item['room_name'] = $lab->lab_name;
                    $item['lab_name'] = $lab->lab_name;
                }
                else {
                    $lecturer = DB::table($request->table.'_lecturers')->where('user_id', $sesh->lecturer_id)->first();
                    $lectureroom = DB::table($request->table.'_lecturerooms')->where('lecture_room_id', $map->lectureroom_id)->first();
                    $item['building'] = $lectureroom->name;
                    $item['room_name'] = $lectureroom->lecture_room_name;
                    $item['lab_name'] = null;
                }
                $group = DB::table($request->table.'_groups')->where('group_id', $map->group_id)->first();
                $item['group'] = $group->acronym. ' ('.$group->group_name.')';
                $item['day_of_week'] = $map->day_of_week;
                $item['start_time'] = $map->start_time;
                $item['end_time'] = $map->end_time;
            }
            return $item;
        });

        $data = [];
        $data['lecturer'] = $lecturer->title.' '.$lecturer->lecturer_name;
        $data['instance'] = $request->instance_name;
        $data['instance_id'] = $request->instance_id;
        $data['gen'] = $request->gen;
        //return view('pdf.individual', compact('lecturer_schema', 'data', 'cells'));
        $pdf = PDF::loadView('pdf.individual', compact('lecturer_schema', 'data', 'cells'));
        return $pdf->download($lecturer->title.' '.$lecturer->lecturer_name.' '.$request->instance_name.'.pdf');
    }
}
