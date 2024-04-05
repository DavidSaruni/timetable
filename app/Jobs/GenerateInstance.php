<?php

namespace App\Jobs;

use App\Models\TimetableInstance;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class GenerateInstance implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timetableInstance;

    /**
     * Create a new job instance.
     */
    public function __construct(TimetableInstance $timetableInstance)
    {
        $this->timetableInstance = $timetableInstance;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Print the current time to the console
        echo date('Y-m-d H:i:s') . PHP_EOL;
        // Print the timetableInstance name
        echo $this->timetableInstance->name . PHP_EOL;
        // update the status of the timetableInstance
        $this->timetableInstance->status = 'Generating';
        $this->timetableInstance->save();
        echo $this->timetableInstance->status . PHP_EOL;
        // Create table $instanceDbName_sessions
        echo 'Creating Sessions Schema' . PHP_EOL;
        $this->generateSessionsSchema();
        echo 'Schema Created' . PHP_EOL;
        echo 'Populating Sessions' . PHP_EOL;
        // Populate table $instanceDbName_sessions
        $this->populateSessions();
        echo 'Sessions Populated' . PHP_EOL;
        // add a 15 second wait
        echo 'Power Nap...' . PHP_EOL;
        sleep(15);
        // assign sessions to schema slots
        echo 'Assigning Sessions to Schema Slots' . PHP_EOL;
        $this->assignSessionsToSchemaSlots();
        // update the status of the timetableInstance
        $this->timetableInstance->status = 'Done';
        $this->timetableInstance->save();
    }

    /**
     * Generate the sessions schema.
     */
    public function generateSessionsSchema()
    {
        Schema::create($this->timetableInstance->table_prefix.'_group_schema', function ($table) 
        {
            $table->increments('schema_id');
            $table->integer('group_id');
            $table->integer('lecturer_id')->nullable();
            $table->integer('session_id')->nullable();
            $table->integer('lectureroom_id')->nullable();
            $table->integer('location_id')->nullable();
            $table->integer('lab_id')->nullable();
            $table->string('day_of_week');
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Populate the sessions table.
     */
    public function populateSessions()
    {
        $groups = DB::table('groups_view')->get();
        foreach ($groups as $group)
        {
            $school_periods = DB::table('school_periods')->where('school_id', $group->school_id)->get();
            foreach ($school_periods as $school_period)
            {
                // split the school period into 1 hour slots
                $slots = (strtotime($school_period->end_time) - strtotime($school_period->start_time)) / (3600);
                $start_time = $school_period->start_time;
                for ($i=0; $i < $slots; $i++) { 
                    $end_time = date('H:i:s', strtotime('+1 hour', strtotime($start_time)));
                    DB::table($this->timetableInstance->table_prefix.'_group_schema')->insert([
                        'group_id' => $group->group_id,
                        'lecturer_id' => null,
                        'session_id' => null,
                        'lectureroom_id' => null,
                        'lab_id' => null,
                        'day_of_week' => $school_period->day_of_week,
                        'start_time' => $start_time,
                        'end_time' => $end_time,
                        'status' => 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $start_time = $end_time;
                }
            }
        }
    }

    /**
     * Get suitable schema slots for a session.
    */
    public function runAssign($session)
    {
        $session = DB::table($this->timetableInstance->table_prefix.'_sessions')->find($session);
        if(!$session)
        {
            echo 'Session not found' . PHP_EOL;
            return null;
        }
        if($session->is_assigned == 1)
        {
            echo 'Session already assigned' . PHP_EOL;
            return null;
        }
        if($session->is_full_day == 1)
        {
            echo 'Session is full day' . PHP_EOL;
            // get the school id for the session
            $school_id = DB::table($this->timetableInstance->table_prefix.'_groups')->where('group_id', $session->group_id)->value('school_id');
            $cohort_id = DB::table($this->timetableInstance->table_prefix.'_groups')->where('group_id', $session->group_id)->value('cohort_id');
            // get the locations accessible to the school
            $locations = DB::table($this->timetableInstance->table_prefix.'_locations')->where('school_id', $school_id)->where('cohort_id', null)->get();
            // randomize the locations
            $locations = $locations->shuffle();
            foreach ($locations as $location) {
                $schemaSlots = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('group_id', $session->group_id)->where('day_of_week', $location->day)->get();
                // check if there is any $schemaSlot with session_id that is not null in the above $schemaSlots
                $schemaSlot = $schemaSlots->where('session_id', '!=', null)->first();
                // if there is a $schemaSlot with session_id that is not null, proceed to the next location
                if ($schemaSlot) {
                    continue;
                }
                // get all the sessions with the same unit code and cohort code
                $sessions = DB::table($this->timetableInstance->table_prefix.'_sessions')->where('unit_code', $session->unit_code)->where('cohort_code', $session->cohort_code)->where('is_full_day', 1)->get();
                // check if there is any $schemaSlot with session_id that is not null for each session in $sessions as determines by session->group_id
                foreach ($sessions as $session) {
                    $schemaSlot = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('group_id', $session->group_id)->where('day_of_week', $location->day)->where('session_id', '!=', null)->first();
                    if ($schemaSlot) {
                        break 1;
                    }
                }
                // for each session
                foreach ($sessions as $session) {
                    // assign the session to the $schemaSlots for that day
                    $schemaSlots = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('group_id', $session->group_id)->where('day_of_week', $location->day)->get();
                    foreach ($schemaSlots as $schemaSlot) {
                        DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('schema_id', $schemaSlot->schema_id)->update([
                            'session_id' => $session->id,
                            'location_id' => $location->id,
                            'status' => 1,
                            'updated_at' => now(),
                        ]);
                    }
                    DB::table($this->timetableInstance->table_prefix.'_locations')->where('id', $location->id)->update([
                        'cohort_id' => $cohort_id,
                        'updated_at' => now(),
                    ]);
                    DB::table($this->timetableInstance->table_prefix.'_sessions')->where('id', $session->id)->update([
                        'is_assigned' => 1,
                        'updated_at' => now(),
                    ]);
                }
                // suitable location found. stop the loop
                break 1;
            }
            echo 'Full Day Session Assigned Successfully!!!' . PHP_EOL;
        }
        // check if session has lecture preference
        $lecprefs = $this->LecPrefTimes($session->id);
        echo count($lecprefs). ' lecture preferences found for ' . $session->unit_code . $session->cohort_code . ' ' . $session->group_name . PHP_EOL;
        // check if session has time preference
        $timeprefs = $this->TimePrefs($session->id);
        echo count($timeprefs). ' time preferences found for ' . $session->unit_code . $session->cohort_code . ' ' . $session->group_name . PHP_EOL;
        // get available time slots
        $availableSlots = $this->getAvailableTimes($session, $lecprefs, $timeprefs);
        if (count($availableSlots) > 0)
        {
            echo count($availableSlots). ' available time slots found for ' . $session->unit_code . $session->cohort_code . ' ' . $session->group_name . PHP_EOL;
            // get available rooms based on preferences
            if($session->is_lab == 1)
            {
                // check if session has lab preference
                $labprefs = $this->LabPrefs($session->id);
                echo count($labprefs). ' lab preferences found for ' . $session->unit_code . $session->cohort_code . ' ' . $session->group_name . PHP_EOL;
                $availableLabs = $this->getAvailableLabs($session, $labprefs);
                if(count($availableLabs) > 0)
                {
                    echo count($availableLabs). ' available labs found for ' . $session->unit_code . $session->cohort_code . ' ' . $session->group_name . PHP_EOL;
                    echo 'Assigning ' . $session->unit_code . $session->cohort_code . ' ' . $session->group_name . ' to a lab...' . PHP_EOL;
                    // assign algorithm
                    $state = $this->assignLabAlgo($session, $availableSlots, $availableLabs);
                    if ($state == true) 
                    {
                        echo 'Unit ' . $session->unit_code .' '. $session->cohort_code . ' ' . $session->group_name .' Assigned Successfully!!!' . PHP_EOL;
                        return true;
                    }
                    else 
                    {
                        echo 'Failed to assign ' . $session->unit_code .' '. $session->cohort_code . ' ' . $session->group_name .' Unit Assingment Failed!!!' . PHP_EOL;
                        return null;
                    }
                }
                else
                {
                    echo 'No available labs found for ' . $session->unit_code . $session->cohort_code . ' ' . $session->group_name .' Unit Assingment Failed!!!' . PHP_EOL;
                    return null;
                }
            }
            else
            {
                // check if session has lectureroom preference
                $roomprefs = $this->RoomPrefs($session->id);
                echo count($roomprefs). ' lectureroom preferences found for ' . $session->unit_code .' '. $session->cohort_code . ' ' . $session->group_name . PHP_EOL;
                $availableRooms = $this->getAvailableRooms($session, $roomprefs);
                if(count($availableRooms) > 0)
                {
                    echo count($availableRooms). ' Possible rooms found for ' . $session->unit_code .' '. $session->cohort_code . ' ' . $session->group_name . PHP_EOL;
                    echo 'Assigning ' . $session->unit_code .' '. $session->cohort_code . ' ' . $session->group_name . ' to a room...' . PHP_EOL;
                    // assign algorithm
                    $state = $this->assignRoomAlgo($session, $availableSlots, $availableRooms);
                    if ($state == true) 
                    {
                        echo 'Unit ' . $session->unit_code .' '. $session->cohort_code . ' ' . $session->group_name .' Assigned Successfully!!!' . PHP_EOL;
                        return true;
                    }
                    else 
                    {
                        echo 'Failed to assign ' . $session->unit_code .' '. $session->cohort_code . ' ' . $session->group_name .' Unit Assingment Failed!!!' . PHP_EOL;
                        return null;
                    }
                }
                else
                {
                    echo 'No available rooms found for ' . $session->unit_code .' '. $session->cohort_code . ' ' . $session->group_name .' Unit Assingment Failed!!!' . PHP_EOL;
                    return null;
                }
            }
        }
        else
        {
            echo 'No available time slots found for ' . $session->unit_code .' '. $session->cohort_code . ' ' . $session->group_name .' Unit Assingment Failed!!!' . PHP_EOL;
            return null;
        }
    }

    /**
     * Get suitable schema slots for a session.
    */
    public function runAssignF($session)
    {
        $session = DB::table($this->timetableInstance->table_prefix.'_sessions')->find($session);
        if(!$session)
        {
            echo 'Session not found' . PHP_EOL;
            return null;
        }
        if($session->is_assigned == 1)
        {
            echo 'Session already assigned' . PHP_EOL;
            return null;
        }
        // set $lecprefs and $timeprefs to empty arrays
        $lecprefs = [];
        $timeprefs = [];
        // get available time slots
        $availableSlots = $this->getAvailableTimes($session, $lecprefs, $timeprefs);
        if (count($availableSlots) > 0)
        {
            echo count($availableSlots). ' available time slots found for ' . $session->unit_code . $session->cohort_code . ' ' . $session->group_name . PHP_EOL;
            // get available rooms based on preferences
            if($session->is_lab == 1)
            {
                // check if session has lab preference
                $labprefs = $this->LabPrefs($session->id);
                echo count($labprefs). ' lab preferences found for ' . $session->unit_code . $session->cohort_code . ' ' . $session->group_name . PHP_EOL;
                $availableLabs = $this->getAvailableLabs($session, $labprefs);
                if(count($availableLabs) > 0)
                {
                    echo count($availableLabs). ' available labs found for ' . $session->unit_code . $session->cohort_code . ' ' . $session->group_name . PHP_EOL;
                    echo 'Assigning ' . $session->unit_code . $session->cohort_code . ' ' . $session->group_name . ' to a lab...' . PHP_EOL;
                    // assign algorithm
                    $state = $this->assignLabAlgo($session, $availableSlots, $availableLabs);
                    if ($state == true) 
                    {
                        echo 'Unit ' . $session->unit_code .' '. $session->cohort_code . ' ' . $session->group_name .' Assigned Successfully!!!' . PHP_EOL;
                        return true;
                    }
                    else 
                    {
                        echo 'Failed to assign ' . $session->unit_code .' '. $session->cohort_code . ' ' . $session->group_name .' Unit Assingment Failed!!!' . PHP_EOL;
                        return null;
                    }
                }
                else
                {
                    echo 'No available labs found for ' . $session->unit_code . $session->cohort_code . ' ' . $session->group_name .' Unit Assingment Failed!!!' . PHP_EOL;
                    return null;
                }
            }
            else
            {
                // check if session has lectureroom preference
                $roomprefs = $this->RoomPrefs($session->id);
                echo count($roomprefs). ' lectureroom preferences found for ' . $session->unit_code .' '. $session->cohort_code . ' ' . $session->group_name . PHP_EOL;
                $availableRooms = $this->getAvailableRooms($session, $roomprefs);
                if(count($availableRooms) > 0)
                {
                    echo count($availableRooms). ' Possible rooms found for ' . $session->unit_code .' '. $session->cohort_code . ' ' . $session->group_name . PHP_EOL;
                    echo 'Assigning ' . $session->unit_code .' '. $session->cohort_code . ' ' . $session->group_name . ' to a room...' . PHP_EOL;
                    // assign algorithm
                    $state = $this->assignRoomAlgo($session, $availableSlots, $availableRooms);
                    if ($state == true) 
                    {
                        echo 'Unit ' . $session->unit_code .' '. $session->cohort_code . ' ' . $session->group_name .' Assigned Successfully!!!' . PHP_EOL;
                        return true;
                    }
                    else 
                    {
                        echo 'Failed to assign ' . $session->unit_code .' '. $session->cohort_code . ' ' . $session->group_name .' Unit Assingment Failed!!!' . PHP_EOL;
                        return null;
                    }
                }
                else
                {
                    echo 'No available rooms found for ' . $session->unit_code .' '. $session->cohort_code . ' ' . $session->group_name .' Unit Assingment Failed!!!' . PHP_EOL;
                    return null;
                }
            }
        }
        else
        {
            echo 'No available time slots found for ' . $session->unit_code .' '. $session->cohort_code . ' ' . $session->group_name .' Unit Assingment Failed!!!' . PHP_EOL;
            return null;
        }
    }

    /**
     * Get lab preferences for a session.
     */
    public function LabPrefs($session_id)
    {
        $labprefs = DB::select("
            SELECT ".$this->timetableInstance->table_prefix."_unit_preffered_labs . * FROM ".$this->timetableInstance->table_prefix."_unit_preffered_labs
            INNER JOIN ".$this->timetableInstance->table_prefix."_sessions
            ON ".$this->timetableInstance->table_prefix."_sessions.unit_id = ".$this->timetableInstance->table_prefix."_unit_preffered_labs.unit_id
            WHERE ".$this->timetableInstance->table_prefix."_sessions.id = ".$session_id."
        ");
        return $labprefs;
    }

    /**
     * Get lecture preferences for a session.
     */
    public function LecPrefTimes($session_id)
    {
        $lecprefs = DB::select("
            SELECT ".$this->timetableInstance->table_prefix."_lecturer_preferred_times . * FROM ".$this->timetableInstance->table_prefix."_lecturer_preferred_times
            INNER JOIN ".$this->timetableInstance->table_prefix."_sessions
            ON ".$this->timetableInstance->table_prefix."_sessions.lecturer_id = ".$this->timetableInstance->table_prefix."_lecturer_preferred_times.lecturer_id
            WHERE ".$this->timetableInstance->table_prefix."_sessions.id = ".$session_id."
        ");
        return $lecprefs;
    }

    /**
     * Get time preferences for a session.
     */
    public function TimePrefs($session_id)
    {
        $timeprefs = DB::select("
            SELECT ".$this->timetableInstance->table_prefix."_unit_preferred_times . * FROM ".$this->timetableInstance->table_prefix."_unit_preferred_times
            INNER JOIN ".$this->timetableInstance->table_prefix."_sessions
            ON ".$this->timetableInstance->table_prefix."_sessions.unit_id = ".$this->timetableInstance->table_prefix."_unit_preferred_times.unit_id
            WHERE ".$this->timetableInstance->table_prefix."_sessions.id = ".$session_id."
        ");
        return $timeprefs;
    }

    /**
     * Get available times for a session.
     * @param $session
     * @param $lecprefs
     * @param $timeprefs
     * @return array
     */
    public function getAvailableTimes($session, $lecprefs, $timeprefs)
    {
        $group_id = $session->group_id;
        $lecturehours = $session->lecturer_hours;
        $labhours = $session->lab_hours;
        $isLab = $session->is_lab;
        if($isLab == 1)
        {
            $hours = $labhours;
        }
        else
        {
            $hours = $lecturehours;
        }
        // get all applicable schema slots
        $schemaSlots = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('group_id', $group_id)->where('session_id', null)->get();
        // if session has lecture preference and time preference
        $matchingPrefs = [];
        $availableSlots = [];
        $timeSlots = [];
        foreach($schemaSlots as $schemaSlot)
        {
            $timeSlots[] = [
                'day_of_week' => $schemaSlot->day_of_week,
                'start_time' => $schemaSlot->start_time,
                'end_time' => $schemaSlot->end_time
            ];
        }
        if(count($lecprefs) > 0 && count($timeprefs) > 0)
        {
            foreach ($lecprefs as $lecpref) {
                foreach ($timeprefs as $timepref) {
                    if ($lecpref->day_of_week == $timepref->day_of_week ) {
                        if ($lecpref->start_time <= $timepref->end_time && $lecpref->end_time >= $timepref->start_time) {
                            $matchingPrefs[] = [
                                'day_of_week' => $timepref->day_of_week,
                                'start_time' => $timepref->start_time,
                                'end_time' => $timepref->end_time
                            ];
                        }
                    }
                }
            }
        }
        elseif(count($lecprefs) > 0)
        {
            $matchingPrefs = [];
            foreach ($lecprefs as $lecpref) {
                $matchingPrefs[] = [
                    'day_of_week' => $lecpref->day_of_week,
                    'start_time' => $lecpref->start_time,
                    'end_time' => $lecpref->end_time
                ];
            }
        }
        elseif(count($timeprefs) > 0)
        {
            $matchingPrefs = [];
            foreach ($timeprefs as $timepref) {
                $matchingPrefs[] = [
                    'day_of_week' => $timepref->day_of_week,
                    'start_time' => $timepref->start_time,
                    'end_time' => $timepref->end_time
                ];
            }
        }
        else
        {
            $matchingPrefs = [];
        }
        if(count($matchingPrefs) == 0)
        {
            $availableSlots = $timeSlots;
        }
        else
        {
            // get all applicable schema slots
            $matchingPrefs = array_unique($matchingPrefs, SORT_REGULAR);
            foreach($matchingPrefs as $matchingPref)
            {
                foreach ($timeSlots as $timeSlot) {
                    $duration = (strtotime($timeSlot['end_time']) - strtotime($timeSlot['start_time'])) / (3600);

                    if ($matchingPref['day_of_week'] == $timeSlot['day_of_week'] &&
                        $matchingPref['start_time'] >= $timeSlot['start_time'] &&
                        $matchingPref['end_time'] <= $timeSlot['end_time']) {
                        $availableSlots[] = $timeSlot;
                    }
                    elseif ($matchingPref['day_of_week'] == $timeSlot['day_of_week'] &&
                        $matchingPref['start_time'] >= $timeSlot['start_time'] &&
                        $duration >= $hours) {
                        $availableSlots[] = $timeSlot;
                    }
                    // if timeslot for next period is available assign it until the required hours are met
                    elseif ($matchingPref['day_of_week'] == $timeSlot['day_of_week'] &&
                        $matchingPref['start_time'] >= $timeSlot['start_time'] &&
                        $duration < $hours) {
                        // get next timeslot
                        if (isset($timeSlots[array_search($timeSlot, $timeSlots) + 1])) {
                            $nextTimeSlot = $timeSlots[array_search($timeSlot, $timeSlots) + 1];
                            // check if next timeslot is consecutive
                            if ($nextTimeSlot['day_of_week'] == $timeSlot['day_of_week'] &&
                                $nextTimeSlot['start_time'] == $timeSlot['end_time']) {
                                    $duration = (strtotime($nextTimeSlot['end_time']) - strtotime($timeSlot['start_time'])) / (3600);
                                    if ($duration >= $hours) {
                                        $timeSlot['end_time'] = $nextTimeSlot['end_time'];
                                        $availableSlots[] = $timeSlot;
                                    }
                                    else {
                                        // get next timeslot
                                        if (isset($timeSlots[array_search($nextTimeSlot, $timeSlots) + 1])) {
                                            $nextTimeSlot1 = $timeSlots[array_search($nextTimeSlot, $timeSlots) + 1];
                                            // check if next timeslot is consecutive
                                            if ($nextTimeSlot1['day_of_week'] == $timeSlot['day_of_week'] &&
                                                $nextTimeSlot1['start_time'] == $nextTimeSlot['end_time']) {
                                                    $duration = (strtotime($nextTimeSlot1['end_time']) - strtotime($timeSlot['start_time'])) / (3600);
                                                    if ($duration >= $hours) {
                                                        $timeSlot['end_time'] = $nextTimeSlot1['end_time'];
                                                        $availableSlots[] = $timeSlot;
                                                    }
                                                    else {
                                                        // get next timeslot
                                                        if (isset($timeSlots[array_search($nextTimeSlot1, $timeSlots) + 1])) {
                                                            $nextTimeSlot2 = $timeSlots[array_search($nextTimeSlot1, $timeSlots) + 1];
                                                            // check if next timeslot is consecutive
                                                            if ($nextTimeSlot2['day_of_week'] == $timeSlot['day_of_week'] &&
                                                                $nextTimeSlot2['start_time'] == $nextTimeSlot1['end_time']) {
                                                                    $duration = (strtotime($nextTimeSlot2['end_time']) - strtotime($timeSlot['start_time'])) / (3600);
                                                                    if ($duration >= $hours) {
                                                                        $timeSlot['end_time'] = $nextTimeSlot2['end_time'];
                                                                        $availableSlots[] = $timeSlot;
                                                                    }
                                                                    else {
                                                                        // get next timeslot
                                                                        if (isset($timeSlots[array_search($nextTimeSlot2, $timeSlots) + 1])) {
                                                                            $nextTimeSlot3 = $timeSlots[array_search($nextTimeSlot2, $timeSlots) + 1];
                                                                            // check if next timeslot is consecutive
                                                                            if ($nextTimeSlot3['day_of_week'] == $timeSlot['day_of_week'] &&
                                                                                $nextTimeSlot3['start_time'] == $nextTimeSlot2['end_time']) {
                                                                                    $duration = (strtotime($nextTimeSlot3['end_time']) - strtotime($timeSlot['start_time'])) / (3600);
                                                                                    if ($duration >= $hours) {
                                                                                        $timeSlot['end_time'] = $nextTimeSlot3['end_time'];
                                                                                        $availableSlots[] = $timeSlot;
                                                                                    }
                                                                            }
                                                                        }
                                                                    }
                                                            }
                                                        }
                                                    }
                                            }
                                        }
                                    }
                            }
                        }
                        else {
                            continue;
                        }
                    }
                } 
            }
        }
        // ensure that the available slots are unique
        $availableSlots = array_unique($availableSlots, SORT_REGULAR);
        return $availableSlots;
    }

    /**
     * Get available labs for a session.
     * @param $session
     * @param $labprefs
     * @return array
     */
    public function getAvailableLabs($session, $labprefs)
    {
        $possibleLabs = [];
        $program = DB::table($this->timetableInstance->table_prefix.'_programs')->where('program_id', $session->program_id)->first();
        $school_id = $program->school_id;
        $labs = DB::table($this->timetableInstance->table_prefix.'_labs')->where('school_id', $school_id)->where('lab_type', $session->labtype_id)->get();
        if(count($labprefs) > 0){
            foreach ($labprefs as $labpref) {
                foreach ($labs as $lab) {
                    if ($lab->lab_capacity >= ($session->student_count + 5)) {
                        if ($lab->lab_id == $labpref->lab_id) {
                            $labDetails = [
                                'lab_id' => $lab->lab_id,
                                'lab_name' => $lab->lab_name,
                                'lab_capacity' => $lab->lab_capacity,
                                'lab_type' => $lab->lab_type,
                                'name' => $lab->name
                            ];
                            $possibleLabs[] = $labDetails;
                        }
                    }
                }
            }
            if(count($possibleLabs) == 0)
            {
                foreach ($labs as $lab) {
                    if ($lab->name != "External") {
                        if ($lab->lab_capacity >= ($session->student_count + 5)) {
                            $labDetails = [
                                'lab_id' => $lab->lab_id,
                                'lab_name' => $lab->lab_name,
                                'lab_capacity' => $lab->lab_capacity,
                                'lab_type' => $lab->lab_type,
                                'name' => $lab->name
                            ];
                            $possibleLabs[] = $labDetails;
                        }
                    }
                }
                if (count($possibleLabs) == 0) {
                    foreach ($labs as $lab) {
                        if ($lab->name != "External") {
                            if ($lab->lab_capacity >= ($session->student_count)) {
                                $labDetails = [
                                    'lab_id' => $lab->lab_id,
                                    'lab_name' => $lab->lab_name,
                                    'lab_capacity' => $lab->lab_capacity,
                                    'lab_type' => $lab->lab_type,
                                    'name' => $lab->name
                                ];
                                $possibleLabs[] = $labDetails;
                            }
                        }
                    }
                }
            }
        }
        else
        {
            foreach ($labs as $lab) {
                if ($lab->name != "External") {
                    if ($lab->lab_capacity >= ($session->student_count + 5)) {
                        $labDetails = [
                            'lab_id' => $lab->lab_id,
                            'lab_name' => $lab->lab_name,
                            'lab_capacity' => $lab->lab_capacity,
                            'lab_type' => $lab->lab_type,
                            'name' => $lab->name
                        ];
                        $possibleLabs[] = $labDetails;
                    }
                }
            }
            if (count($possibleLabs) == 0) {
                foreach ($labs as $lab) {
                    if ($lab->name != "External") {
                        if ($lab->lab_capacity >= ($session->student_count)) {
                            $labDetails = [
                                'lab_id' => $lab->lab_id,
                                'lab_name' => $lab->lab_name,
                                'lab_capacity' => $lab->lab_capacity,
                                'lab_type' => $lab->lab_type,
                                'name' => $lab->name
                            ];
                            $possibleLabs[] = $labDetails;
                        }
                    }
                }
            }
        }
        $possibleLabs = array_unique($possibleLabs, SORT_REGULAR);
        // sort labs by capacity in ascending order
        usort($possibleLabs, function($a, $b) {
            return $a['lab_capacity'] <=> $b['lab_capacity'];
        });
        return $possibleLabs;
    }

    /**
     * Assign a session to a lab.
     * @param $session
     * @param $availableSlots
     * @param $availableLabs
     * @return bool
     */
    public function assignLabAlgo($session, $availableSlots, $availableLabs)
    {
        $hours = $session->lab_hours;
        shuffle($availableSlots);
        foreach ($availableSlots as $availableSlot) {
            foreach ($availableLabs as $availableLab) {
                $schemaSlots = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('group_id', $session->group_id)->where('day_of_week', $availableSlot['day_of_week'])->where('session_id', null)->where('status', 0)->where('start_time', '=', $availableSlot['start_time'])->get();
                $schemaSlots->shuffle();
                if(count($schemaSlots) > 0)
                {
                    foreach($schemaSlots as $slot)
                    {
                        $schemaSlotDuration = (strtotime($slot->end_time) - strtotime($slot->start_time)) / (3600);
                        if ($hours > $schemaSlotDuration) {
                            // get next timeslot as the slot with current slot id + 1
                            $nextSlot = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('schema_id', $slot->schema_id + 1)->first();
                            // check if next timeslot is available
                            if(!$nextSlot)
                            {
                                // next timeslot is not available skip to next for loop
                                continue;
                            }
                            else
                            {
                                if ($nextSlot->status == 1) {
                                    // next timeslot is not available skip to next slot
                                    continue;
                                }
                                else {
                                    // check if the slots are consecutive
                                    if($slot->end_time == $nextSlot->start_time)
                                    {
                                        $schemaSlotDuration = (strtotime($nextSlot->end_time) - strtotime($slot->start_time)) / (3600);
                                        if ($hours <= $schemaSlotDuration) {
                                            // check if lab is available
                                            $labSchemaSlots1 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lab_id', $availableLab['lab_id'])->where('start_time', '=', $slot->start_time)->get();
                                            $labSchemaSlots2 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lab_id', $availableLab['lab_id'])->where('start_time', '=', $nextSlot->start_time)->get();
                                            if(count($labSchemaSlots1)>0 || count($labSchemaSlots2)>0){
                                                // lab is not available skip to next slot
                                                continue;
                                            }
                                            else {
                                                // check if lecturer is available
                                                $lecturerSchemaSlots1 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lecturer_id', $session->lecturer_id)->where('start_time', '=', $slot->start_time)->get();
                                                $lecturerSchemaSlots2 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lecturer_id', $session->lecturer_id)->where('start_time', '=', $nextSlot->start_time)->get();
                                                if(count($lecturerSchemaSlots1)>0 || count($lecturerSchemaSlots2)>0){
                                                    // lecturer is not available skip to next slot
                                                    continue;
                                                }
                                                else {
                                                    // assign session to timeslot and get out of loop
                                                    // begin db transaction
                                                    DB::beginTransaction();
                                                    DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('schema_id', $slot->schema_id)->update([
                                                        'session_id' => $session->id,
                                                        'lab_id' => $availableLab['lab_id'],
                                                        'lecturer_id' => $session->lecturer_id,
                                                        'status' => 1,
                                                    ]);
                                                    DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('schema_id', $nextSlot->schema_id)->update([
                                                        'session_id' => $session->id,
                                                        'lab_id' => $availableLab['lab_id'],
                                                        'lecturer_id' => $session->lecturer_id,
                                                        'status' => 1,
                                                    ]);
                                                    DB::table($this->timetableInstance->table_prefix.'_sessions')->where('id', $session->id)->update([
                                                        'is_assigned' => 1,
                                                    ]);
                                                    DB::commit();
                                                    echo 'Unit Assingment Successful!!!' . PHP_EOL;
                                                    return true;
                                                }
                                            }
                                        }
                                        else {
                                            // get next timeslot as the slot with next slot id + 1
                                            $nextSlot1 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('schema_id', $nextSlot->schema_id + 1)->first();
                                            // check if next timeslot is available
                                            if(!$nextSlot1)
                                            {
                                                // next timeslot is not available skip to next for loop
                                                continue;
                                            }
                                            else {
                                                if ($nextSlot1->status == 1) {
                                                    // next timeslot is not available skip to next slot
                                                    continue;
                                                }
                                                else {
                                                    // check if the slots are consecutive
                                                    if($nextSlot->end_time == $nextSlot1->start_time)
                                                    {
                                                        $schemaSlotDuration = (strtotime($nextSlot1->end_time) - strtotime($slot->start_time)) / (3600);
                                                        if ($hours > $schemaSlotDuration) {
                                                            // get next timeslot as the slot with next slot id + 1
                                                            $nextSlot2 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('schema_id', $nextSlot1->schema_id + 1)->first();
                                                            // check if next timeslot is available
                                                            if(!$nextSlot2)
                                                            {
                                                                // next timeslot is not available skip to next for loop
                                                                continue;
                                                            }
                                                            else {
                                                                if ($nextSlot2->status == 1) {
                                                                    // next timeslot is not available skip to next slot
                                                                    continue;
                                                                }
                                                                else {
                                                                    // check if the slots are consecutive
                                                                    if($nextSlot1->end_time == $nextSlot2->start_time)
                                                                    {
                                                                        $schemaSlotDuration = (strtotime($nextSlot2->end_time) - strtotime($slot->start_time)) / (3600);
                                                                        if ($hours > $schemaSlotDuration) {
                                                                            // get next timeslot as the slot with next slot id + 1
                                                                            $nextSlot3 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('schema_id', $nextSlot2->schema_id + 1)->first();
                                                                            // check if next timeslot is available
                                                                            if(!$nextSlot3)
                                                                            {
                                                                                // next timeslot is not available skip to next for loop
                                                                                continue;
                                                                            }
                                                                            else {
                                                                                if ($nextSlot3->status == 1) {
                                                                                    // next timeslot is not available skip to next slot
                                                                                    continue;
                                                                                }
                                                                                else {
                                                                                    // check if the slots are consecutive
                                                                                    if($nextSlot2->end_time == $nextSlot3->start_time)
                                                                                    {
                                                                                        $schemaSlotDuration = (strtotime($nextSlot3->end_time) - strtotime($slot->start_time)) / (3600);
                                                                                        if ($hours > $schemaSlotDuration) {
                                                                                            // get next timeslot as the slot with next slot id + 1
                                                                                            $nextSlot4 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('schema_id', $nextSlot3->schema_id + 1)->first();
                                                                                            // check if next timeslot is available
                                                                                            // we will continue with this logic later
                                                                                        }
                                                                                        else {
                                                                                            // check if lab is available
                                                                                            $labSchemaSlots1 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lab_id', $availableLab['lab_id'])->where('start_time', '=', $slot->start_time)->get();
                                                                                            $labSchemaSlots2 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lab_id', $availableLab['lab_id'])->where('start_time', '=', $nextSlot->start_time)->get();
                                                                                            $labSchemaSlots3 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lab_id', $availableLab['lab_id'])->where('start_time', '=', $nextSlot1->start_time)->get();
                                                                                            $labSchemaSlots4 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lab_id', $availableLab['lab_id'])->where('start_time', '=', $nextSlot2->start_time)->get();
                                                                                            $labSchemaSlots5 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lab_id', $availableLab['lab_id'])->where('start_time', '=', $nextSlot3->start_time)->get();
                                                                                            if(count($labSchemaSlots1)>0 || count($labSchemaSlots2)>0 || count($labSchemaSlots3)>0 || count($labSchemaSlots4)>0 || count($labSchemaSlots5)>0){
                                                                                                // lab is not available skip to next slot
                                                                                                continue;
                                                                                            }
                                                                                            else {
                                                                                                // check if lecturer is available
                                                                                                $lecturerSchemaSlots1 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lecturer_id', $session->lecturer_id)->where('start_time', '=', $slot->start_time)->get();
                                                                                                $lecturerSchemaSlots2 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lecturer_id', $session->lecturer_id)->where('start_time', '=', $nextSlot->start_time)->get();
                                                                                                $lecturerSchemaSlots3 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lecturer_id', $session->lecturer_id)->where('start_time', '=', $nextSlot1->start_time)->get();
                                                                                                $lecturerSchemaSlots4 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lecturer_id', $session->lecturer_id)->where('start_time', '=', $nextSlot2->start_time)->get();
                                                                                                $lecturerSchemaSlots5 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lecturer_id', $session->lecturer_id)->where('start_time', '=', $nextSlot3->start_time)->get();
                                                                                                if(count($lecturerSchemaSlots1)>0 || count($lecturerSchemaSlots2)>0 || count($lecturerSchemaSlots3)>0 || count($lecturerSchemaSlots4)>0 || count($lecturerSchemaSlots5)>0){
                                                                                                    // lecturer is not available skip to next slot
                                                                                                    continue;
                                                                                                }
                                                                                                else {
                                                                                                    // assign session to timeslot and get out of loop
                                                                                                    // begin db transaction
                                                                                                    DB::beginTransaction();
                                                                                                    DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('schema_id', $slot->schema_id)->update([
                                                                                                        'session_id' => $session->id,
                                                                                                        'lab_id' => $availableLab['lab_id'],
                                                                                                        'lecturer_id' => $session->lecturer_id,
                                                                                                        'status' => 1,
                                                                                                    ]);
                                                                                                    DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('schema_id', $nextSlot->schema_id)->update([
                                                                                                        'session_id' => $session->id,
                                                                                                        'lab_id' => $availableLab['lab_id'],
                                                                                                        'lecturer_id' => $session->lecturer_id,
                                                                                                        'status' => 1,
                                                                                                    ]);
                                                                                                    DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('schema_id', $nextSlot1->schema_id)->update([
                                                                                                        'session_id' => $session->id,
                                                                                                        'lab_id' => $availableLab['lab_id'],
                                                                                                        'lecturer_id' => $session->lecturer_id,
                                                                                                        'status' => 1,
                                                                                                    ]);
                                                                                                    DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('schema_id', $nextSlot2->schema_id)->update([
                                                                                                        'session_id' => $session->id,
                                                                                                        'lab_id' => $availableLab['lab_id'],
                                                                                                        'lecturer_id' => $session->lecturer_id,
                                                                                                        'status' => 1,
                                                                                                    ]);
                                                                                                    DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('schema_id', $nextSlot3->schema_id)->update([
                                                                                                        'session_id' => $session->id,
                                                                                                        'lab_id' => $availableLab['lab_id'],
                                                                                                        'lecturer_id' => $session->lecturer_id,
                                                                                                        'status' => 1,
                                                                                                    ]);
                                                                                                    DB::table($this->timetableInstance->table_prefix.'_sessions')->where('id', $session->id)->update([
                                                                                                        'is_assigned' => 1,
                                                                                                    ]);
                                                                                                    DB::commit();
                                                                                                    echo 'Unit Assingment Successful!!!' . PHP_EOL;
                                                                                                    return true;
                                                                                                }
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                        else {
                                                                            // check if lab is available
                                                                            $labSchemaSlots1 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lab_id', $availableLab['lab_id'])->where('start_time', '=', $slot->start_time)->get();
                                                                            $labSchemaSlots2 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lab_id', $availableLab['lab_id'])->where('start_time', '=', $nextSlot->start_time)->get();
                                                                            $labSchemaSlots3 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lab_id', $availableLab['lab_id'])->where('start_time', '=', $nextSlot1->start_time)->get();
                                                                            $labSchemaSlots4 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lab_id', $availableLab['lab_id'])->where('start_time', '=', $nextSlot2->start_time)->get();
                                                                            if(count($labSchemaSlots1)>0 || count($labSchemaSlots2)>0 || count($labSchemaSlots3)>0 || count($labSchemaSlots4)>0){
                                                                                // lab is not available skip to next slot
                                                                                continue;
                                                                            }
                                                                            else {
                                                                                // check if lecturer is available
                                                                                $lecturerSchemaSlots1 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lecturer_id', $session->lecturer_id)->where('start_time', '=', $slot->start_time)->get();
                                                                                $lecturerSchemaSlots2 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lecturer_id', $session->lecturer_id)->where('start_time', '=', $nextSlot->start_time)->get();
                                                                                $lecturerSchemaSlots3 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lecturer_id', $session->lecturer_id)->where('start_time', '=', $nextSlot1->start_time)->get();
                                                                                $lecturerSchemaSlots4 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lecturer_id', $session->lecturer_id)->where('start_time', '=', $nextSlot2->start_time)->get();
                                                                                if(count($lecturerSchemaSlots1)>0 || count($lecturerSchemaSlots2)>0 || count($lecturerSchemaSlots3)>0 || count($lecturerSchemaSlots4)>0){
                                                                                    // lecturer is not available skip to next slot
                                                                                    continue;
                                                                                }
                                                                                else {
                                                                                    // assign session to timeslot and get out of loop
                                                                                    // begin db transaction
                                                                                    DB::beginTransaction();
                                                                                    DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('schema_id', $slot->schema_id)->update([
                                                                                        'session_id' => $session->id,
                                                                                        'lab_id' => $availableLab['lab_id'],
                                                                                        'lecturer_id' => $session->lecturer_id,
                                                                                        'status' => 1,
                                                                                    ]);
                                                                                    DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('schema_id', $nextSlot->schema_id)->update([
                                                                                        'session_id' => $session->id,
                                                                                        'lab_id' => $availableLab['lab_id'],
                                                                                        'lecturer_id' => $session->lecturer_id,
                                                                                        'status' => 1,
                                                                                    ]);
                                                                                    DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('schema_id', $nextSlot1->schema_id)->update([
                                                                                        'session_id' => $session->id,
                                                                                        'lab_id' => $availableLab['lab_id'],
                                                                                        'lecturer_id' => $session->lecturer_id,
                                                                                        'status' => 1,
                                                                                    ]);
                                                                                    DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('schema_id', $nextSlot2->schema_id)->update([
                                                                                        'session_id' => $session->id,
                                                                                        'lab_id' => $availableLab['lab_id'],
                                                                                        'lecturer_id' => $session->lecturer_id,
                                                                                        'status' => 1,
                                                                                    ]);
                                                                                    DB::table($this->timetableInstance->table_prefix.'_sessions')->where('id', $session->id)->update([
                                                                                        'is_assigned' => 1,
                                                                                    ]);
                                                                                    DB::commit();
                                                                                    echo 'Unit Assingment Successful!!!' . PHP_EOL;
                                                                                    return true;
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        else {
                                                            // check if lab is available
                                                            $labSchemaSlots1 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lab_id', $availableLab['lab_id'])->where('start_time', '=', $slot->start_time)->get();
                                                            $labSchemaSlots2 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lab_id', $availableLab['lab_id'])->where('start_time', '=', $nextSlot->start_time)->get();
                                                            $labSchemaSlots3 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lab_id', $availableLab['lab_id'])->where('start_time', '=', $nextSlot1->start_time)->get();
                                                            if(count($labSchemaSlots1)>0 || count($labSchemaSlots2)>0 || count($labSchemaSlots3)>0){
                                                                // lab is not available skip to next slot
                                                                continue;
                                                            }
                                                            else {
                                                                // check if lecturer is available
                                                                $lecturerSchemaSlots1 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lecturer_id', $session->lecturer_id)->where('start_time', '=', $slot->start_time)->get();
                                                                $lecturerSchemaSlots2 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lecturer_id', $session->lecturer_id)->where('start_time', '=', $nextSlot->start_time)->get();
                                                                $lecturerSchemaSlots3 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lecturer_id', $session->lecturer_id)->where('start_time', '=', $nextSlot1->start_time)->get();
                                                                if(count($lecturerSchemaSlots1)>0 || count($lecturerSchemaSlots2)>0 || count($lecturerSchemaSlots3)>0){
                                                                    // lecturer is not available skip to next slot
                                                                    continue;
                                                                }
                                                                else {
                                                                    // assign session to timeslot and get out of loop
                                                                    // begin db transaction
                                                                    DB::beginTransaction();
                                                                    DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('schema_id', $slot->schema_id)->update([
                                                                        'session_id' => $session->id,
                                                                        'lab_id' => $availableLab['lab_id'],
                                                                        'lecturer_id' => $session->lecturer_id,
                                                                        'status' => 1,
                                                                    ]);
                                                                    DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('schema_id', $nextSlot->schema_id)->update([
                                                                        'session_id' => $session->id,
                                                                        'lab_id' => $availableLab['lab_id'],
                                                                        'lecturer_id' => $session->lecturer_id,
                                                                        'status' => 1,
                                                                    ]);
                                                                    DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('schema_id', $nextSlot1->schema_id)->update([
                                                                        'session_id' => $session->id,
                                                                        'lab_id' => $availableLab['lab_id'],
                                                                        'lecturer_id' => $session->lecturer_id,
                                                                        'status' => 1,
                                                                    ]);
                                                                    DB::table($this->timetableInstance->table_prefix.'_sessions')->where('id', $session->id)->update([
                                                                        'is_assigned' => 1,
                                                                    ]);
                                                                    DB::commit();
                                                                    echo 'Unit Assingment Successful!!!' . PHP_EOL;
                                                                    return true;
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    else {
                                        // next timeslot is not available skip to next slot
                                        continue;
                                    }
                                }
                            }
                        }
                        else {
                            // check if lab is available
                            $labSchemaSlots = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lab_id', $availableLab['lab_id'])->where('start_time', '=', $slot->start_time)->get();
                            if(count($labSchemaSlots)>0){
                                // lab is not available skip to next slot
                                continue;
                            }
                            else {
                                // check if lecturer is available
                                $lecturerSchemaSlots = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lecturer_id', $session->lecturer_id)->where('start_time', '=', $slot->start_time)->get();
                                if(count($lecturerSchemaSlots)>0){
                                    // lecturer is not available skip to next slot
                                    continue;
                                }
                                else {
                                    // assign session to timeslot and get out of loop
                                    // begin db transaction
                                    DB::beginTransaction();
                                    DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('schema_id', $slot->schema_id)->update([
                                        'session_id' => $session->id,
                                        'lab_id' => $availableLab['lab_id'],
                                        'lecturer_id' => $session->lecturer_id,
                                        'status' => 1,
                                    ]);
                                    DB::table($this->timetableInstance->table_prefix.'_sessions')->where('id', $session->id)->update([
                                        'is_assigned' => 1,
                                    ]);
                                    DB::commit();
                                    echo 'Unit Assingment Successful!!!' . PHP_EOL;
                                    return true;
                                }
                            }
                        }
                    }
                }
                else
                {
                    echo 'No available schema slots found for ' . $session->unit_code .' '. $session->cohort_code . ' ' . $session->group_name .' Unit Assingment Failed!!!' . PHP_EOL;
                    return null;
                }
            }
        }
    }

    /**
     * Get lectureroom preferences for a session.
     */
    public function RoomPrefs($session_id)
    {
        $roomprefs = DB::select("
            SELECT ".$this->timetableInstance->table_prefix."_unit_preffered_rooms . * FROM ".$this->timetableInstance->table_prefix."_unit_preffered_rooms
            INNER JOIN ".$this->timetableInstance->table_prefix."_sessions
            ON ".$this->timetableInstance->table_prefix."_sessions.unit_id = ".$this->timetableInstance->table_prefix."_unit_preffered_rooms.unit_id
            WHERE ".$this->timetableInstance->table_prefix."_sessions.id = ".$session_id."
        ");
        return $roomprefs;
    }

    /**
     * Get available rooms for a session.
     * @param $session
     * @param $roomprefs
     * @return array
     */
    public function getAvailableRooms($session, $roomprefs)
    {
        $possibleRooms = [];
        $program = DB::table($this->timetableInstance->table_prefix.'_programs')->where('program_id', $session->program_id)->first();
        $school_id = $program->school_id;
        $rooms = DB::table($this->timetableInstance->table_prefix.'_lecturerooms')->where('school_id', $school_id)->get();
        if(count($roomprefs) > 0)
        {
            foreach ($roomprefs as $roompref) {
                foreach ($rooms as $room) {
                    if ($room->lecture_room_capacity >= ($session->student_count + 5)) {
                        if ($room->lecture_room_id == $roompref->lecture_room_id) {
                            $roomDetails = [
                                'lecture_room_id' => $room->lecture_room_id,
                                'lecture_room_name' => $room->lecture_room_name,
                                'lecture_room_capacity' => $room->lecture_room_capacity,
                                'name' => $room->name
                            ];
                            $possibleRooms[] = $roomDetails;
                        }
                    }
                }
            }
            if(count($possibleRooms) == 0)
            {
                foreach ($rooms as $room) {
                    if ($room->name != "External") {
                        if ($room->lecture_room_capacity >= ($session->student_count + 5)) {
                            $roomDetails = [
                                'lecture_room_id' => $room->lecture_room_id,
                                'lecture_room_name' => $room->lecture_room_name,
                                'lecture_room_capacity' => $room->lecture_room_capacity,
                                'name' => $room->name
                            ];
                            $possibleRooms[] = $roomDetails;
                        }
                    }
                }
                if (count($possibleRooms) == 0) {
                    foreach ($rooms as $room) {
                        if ($room->name != "External") {
                            if ($room->lecture_room_capacity >= ($session->student_count)) {
                                $roomDetails = [
                                    'lecture_room_id' => $room->lecture_room_id,
                                    'lecture_room_name' => $room->lecture_room_name,
                                    'lecture_room_capacity' => $room->lecture_room_capacity,
                                    'name' => $room->name
                                ];
                                $possibleRooms[] = $roomDetails;
                            }
                        }
                    }
                }
            }
        }
        else    
        {
            foreach ($rooms as $room) {
                if ($room->name != "External") {
                    if ($room->lecture_room_capacity >= ($session->student_count + 5)) {
                        $roomDetails = [
                            'lecture_room_id' => $room->lecture_room_id,
                            'lecture_room_name' => $room->lecture_room_name,
                            'lecture_room_capacity' => $room->lecture_room_capacity,
                            'name' => $room->name
                        ];
                        $possibleRooms[] = $roomDetails;
                    }
                }
            }
            if (count($possibleRooms) == 0) {
                foreach ($rooms as $room) {
                    if ($room->name != "External") {
                        if ($room->lecture_room_capacity >= ($session->student_count)) {
                            $roomDetails = [
                                'lecture_room_id' => $room->lecture_room_id,
                                'lecture_room_name' => $room->lecture_room_name,
                                'lecture_room_capacity' => $room->lecture_room_capacity,
                                'name' => $room->name
                            ];
                            $possibleRooms[] = $roomDetails;
                        }
                    }
                }
            }
        }
        $possibleRooms = array_unique($possibleRooms, SORT_REGULAR);
        // sort rooms by capacity in ascending order
        usort($possibleRooms, function($a, $b) {
            return $a['lecture_room_capacity'] <=> $b['lecture_room_capacity'];
        });
        return $possibleRooms;
    }

    /**
     * Assign a session to a room.
     * @param $session
     * @param $availableSlots
     * @param $availableRooms
     * @return bool
     */
    public function assignRoomAlgo($session, $availableSlots, $availableRooms)
    {
        $hours = $session->lecturer_hours;
        // get consecutive slots whose duration is equal to or just greater than the required hours
        
        shuffle($availableSlots);
        foreach ($availableSlots as $availableSlot) {
            foreach ($availableRooms as $availableRoom) {
                $schemaSlots = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('group_id', $session->group_id)->where('day_of_week', $availableSlot['day_of_week'])->where('session_id', null)->where('status', 0)->where('start_time', '=', $availableSlot['start_time'])->get();
                $schemaSlots->shuffle();
                if(count($schemaSlots) > 0)
                {
                    foreach($schemaSlots as $slot)
                    {
                        $schemaSlotDuration = (strtotime($slot->end_time) - strtotime($slot->start_time)) / (3600);
                        if ($hours > $schemaSlotDuration) {
                            // get next timeslot as the slot with current slot id + 1
                            $nextSlot = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('schema_id', $slot->schema_id + 1)->first();
                            // check if next timeslot is available
                            if(!$nextSlot)
                            {
                                // next timeslot is not available skip to next for loop
                                continue;
                            }
                            else
                            {
                                if ($nextSlot->status == 1) {
                                    // next timeslot is not available skip to next slot
                                    continue;
                                }
                                else {
                                    // check if the slots are consecutive
                                    if($slot->end_time == $nextSlot->start_time)
                                    {
                                        $schemaSlotDuration = (strtotime($nextSlot->end_time) - strtotime($slot->start_time)) / (3600);
                                        if ($hours <= $schemaSlotDuration) {
                                            // check if room is available
                                            $roomSchemaSlots1 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lectureroom_id', $availableRoom['lecture_room_id'])->where('start_time', '=', $slot->start_time)->get();
                                            $roomSchemaSlots2 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lectureroom_id', $availableRoom['lecture_room_id'])->where('start_time', '=', $nextSlot->start_time)->get();
                                            if(count($roomSchemaSlots1)>0 || count($roomSchemaSlots2)>0){
                                                // room is not available skip to next slot
                                                continue;
                                            }
                                            else {
                                                // check if lecturer is available
                                                $lecturerSchemaSlots1 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lecturer_id', $session->lecturer_id)->where('start_time', '=', $slot->start_time)->get();                            
                                                $lecturerSchemaSlots2 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lecturer_id', $session->lecturer_id)->where('start_time', '=', $nextSlot->start_time)->get();                            
                                                if(count($lecturerSchemaSlots1)>0 || count($lecturerSchemaSlots2)>0){
                                                    // lecturer is not available skip to next slot
                                                    continue;
                                                }
                                                else {
                                                    // assign session to timeslot and get out of loop
                                                    // begin db transaction
                                                    DB::beginTransaction();
                                                    DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('schema_id', $slot->schema_id)->update([
                                                        'session_id' => $session->id,
                                                        'lectureroom_id' => $availableRoom['lecture_room_id'],
                                                        'lecturer_id' => $session->lecturer_id,
                                                        'status' => 1,
                                                    ]);
                                                    DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('schema_id', $nextSlot->schema_id)->update([
                                                        'session_id' => $session->id,
                                                        'lectureroom_id' => $availableRoom['lecture_room_id'],
                                                        'lecturer_id' => $session->lecturer_id,
                                                        'status' => 1,
                                                    ]);
                                                    DB::table($this->timetableInstance->table_prefix.'_sessions')->where('id', $session->id)->update([
                                                        'is_assigned' => 1,
                                                    ]);
                                                    DB::commit();
                                                    echo 'Unit Assingment Successful!!!' . PHP_EOL;
                                                    return true;
                                                }
                                            }
                                        }
                                        else {
                                            // get next timeslot as the slot with next slot id + 1
                                            $nextSlot1 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('schema_id', $nextSlot->schema_id + 1)->first();
                                            // check if next timeslot is available
                                            if(!$nextSlot1)
                                            {
                                                // next timeslot is not available skip to next for loop
                                                continue;
                                            }
                                            else
                                            {
                                                if ($nextSlot1->status == 1) {
                                                    // next timeslot is not available skip to next slot
                                                    continue;
                                                }
                                                else {
                                                    // check if the slots are consecutive
                                                    if($nextSlot->end_time == $nextSlot1->start_time)
                                                    {
                                                        $schemaSlotDuration = (strtotime($nextSlot1->end_time) - strtotime($slot->start_time)) / (3600);
                                                        if ($hours <= $schemaSlotDuration) {
                                                            // check if room is available
                                                            $roomSchemaSlots1 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lectureroom_id', $availableRoom['lecture_room_id'])->where('start_time', '=', $slot->start_time)->get();
                                                            $roomSchemaSlots2 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lectureroom_id', $availableRoom['lecture_room_id'])->where('start_time', '=', $nextSlot->start_time)->get();
                                                            $roomSchemaSlots3 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lectureroom_id', $availableRoom['lecture_room_id'])->where('start_time', '=', $nextSlot1->start_time)->get();
                                                            if(count($roomSchemaSlots1)>0 || count($roomSchemaSlots2)>0 || count($roomSchemaSlots3)>0){
                                                                // room is not available skip to next slot
                                                                continue;
                                                            }
                                                            else {
                                                                // check if lecturer is available
                                                                $lecturerSchemaSlots1 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lecturer_id', $session->lecturer_id)->where('start_time', '=', $slot->start_time)->get();
                                                                $lecturerSchemaSlots2 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lecturer_id', $session->lecturer_id)->where('start_time', '=', $nextSlot->start_time)->get();
                                                                $lecturerSchemaSlots3 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lecturer_id', $session->lecturer_id)->where('start_time', '=', $nextSlot1->start_time)->get();
                                                                if(count($lecturerSchemaSlots1)>0 || count($lecturerSchemaSlots2)>0 || count($lecturerSchemaSlots3)>0){
                                                                    // lecturer is not available skip to next slot
                                                                    continue;
                                                                }
                                                                else {
                                                                    // assign session to timeslot and get out of loop
                                                                    // begin db transaction
                                                                    DB::beginTransaction();
                                                                    DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('schema_id', $slot->schema_id)->update([
                                                                        'session_id' => $session->id,
                                                                        'lectureroom_id' => $availableRoom['lecture_room_id'],
                                                                        'lecturer_id' => $session->lecturer_id,
                                                                        'status' => 1,
                                                                    ]);
                                                                    DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('schema_id', $nextSlot->schema_id)->update([
                                                                        'session_id' => $session->id,
                                                                        'lectureroom_id' => $availableRoom['lecture_room_id'],
                                                                        'lecturer_id' => $session->lecturer_id,
                                                                        'status' => 1,
                                                                    ]);
                                                                    DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('schema_id', $nextSlot1->schema_id)->update([
                                                                        'session_id' => $session->id,
                                                                        'lectureroom_id' => $availableRoom['lecture_room_id'],
                                                                        'lecturer_id' => $session->lecturer_id,
                                                                        'status' => 1,
                                                                    ]);
                                                                    DB::table($this->timetableInstance->table_prefix.'_sessions')->where('id', $session->id)->update([
                                                                        'is_assigned' => 1,
                                                                    ]);
                                                                    DB::commit();
                                                                    echo 'Unit Assingment Successful!!!' . PHP_EOL;
                                                                    return true;
                                                                }
                                                            }
                                                        }
                                                        else {
                                                            // get next timeslot as the slot with next slot id + 1
                                                            $nextSlot2 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('schema_id', $nextSlot1->schema_id + 1)->first();
                                                            // check if next timeslot is available
                                                            if(!$nextSlot2)
                                                            {
                                                                // next timeslot is not available skip to next for loop
                                                                continue;
                                                            }
                                                            else
                                                            {
                                                                if ($nextSlot2->status == 1) {
                                                                    // next timeslot is not available skip to next slot
                                                                    continue;
                                                                }
                                                                else {
                                                                    // check if the slots are consecutive
                                                                    if($nextSlot1->end_time == $nextSlot2->start_time)
                                                                    {
                                                                        $schemaSlotDuration = (strtotime($nextSlot2->end_time) - strtotime($slot->start_time)) / (3600);
                                                                        if ($hours <= $schemaSlotDuration) {
                                                                            // check if room is available
                                                                            $roomSchemaSlots1 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lectureroom_id', $availableRoom['lecture_room_id'])->where('start_time', '=', $slot->start_time)->get();
                                                                            $roomSchemaSlots2 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lectureroom_id', $availableRoom['lecture_room_id'])->where('start_time', '=', $nextSlot->start_time)->get();
                                                                            $roomSchemaSlots3 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lectureroom_id', $availableRoom['lecture_room_id'])->where('start_time', '=', $nextSlot1->start_time)->get();
                                                                            $roomSchemaSlots4 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lectureroom_id', $availableRoom['lecture_room_id'])->where('start_time', '=', $nextSlot2->start_time)->get();
                                                                            if(count($roomSchemaSlots1)>0 || count($roomSchemaSlots2)>0 || count($roomSchemaSlots3)>0 || count($roomSchemaSlots4)>0){
                                                                                // room is not available skip to next slot
                                                                                continue;
                                                                            }
                                                                            else {
                                                                                // check if lecturer is available
                                                                                $lecturerSchemaSlots1 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lecturer_id', $session->lecturer_id)->where('start_time', '=', $slot->start_time)->get();
                                                                                $lecturerSchemaSlots2 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lecturer_id', $session->lecturer_id)->where('start_time', '=', $nextSlot->start_time)->get();
                                                                                $lecturerSchemaSlots3 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lecturer_id', $session->lecturer_id)->where('start_time', '=', $nextSlot1->start_time)->get();
                                                                                $lecturerSchemaSlots4 = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lecturer_id', $session->lecturer_id)->where('start_time', '=', $nextSlot2->start_time)->get();
                                                                                if(count($lecturerSchemaSlots1)>0 || count($lecturerSchemaSlots2)>0 || count($lecturerSchemaSlots3)>0 || count($lecturerSchemaSlots4)>0){
                                                                                    // lecturer is not available skip to next slot
                                                                                    continue;
                                                                                }
                                                                                else {
                                                                                    // assign session to timeslot and get out of loop
                                                                                    // begin db transaction
                                                                                    DB::beginTransaction();
                                                                                    DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('schema_id', $slot->schema_id)->update([
                                                                                        'session_id' => $session->id,
                                                                                        'lectureroom_id' => $availableRoom['lecture_room_id'],
                                                                                        'lecturer_id' => $session->lecturer_id,
                                                                                        'status' => 1,
                                                                                    ]);
                                                                                    DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('schema_id', $nextSlot->schema_id)->update([
                                                                                        'session_id' => $session->id,
                                                                                        'lectureroom_id' => $availableRoom['lecture_room_id'],
                                                                                        'lecturer_id' => $session->lecturer_id,
                                                                                        'status' => 1,
                                                                                    ]);
                                                                                    DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('schema_id', $nextSlot1->schema_id)->update([
                                                                                        'session_id' => $session->id,
                                                                                        'lectureroom_id' => $availableRoom['lecture_room_id'],
                                                                                        'lecturer_id' => $session->lecturer_id,
                                                                                        'status' => 1,
                                                                                    ]);
                                                                                    DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('schema_id', $nextSlot2->schema_id)->update([
                                                                                        'session_id' => $session->id,
                                                                                        'lectureroom_id' => $availableRoom['lecture_room_id'],
                                                                                        'lecturer_id' => $session->lecturer_id,
                                                                                        'status' => 1,
                                                                                    ]);
                                                                                    DB::table($this->timetableInstance->table_prefix.'_sessions')->where('id', $session->id)->update([
                                                                                        'is_assigned' => 1,
                                                                                    ]);
                                                                                    DB::commit();
                                                                                    echo 'Unit Assingment Successful!!!' . PHP_EOL;
                                                                                    return true;
                                                                                }
                                                                            }
                                                                        }
                                                                        else {
                                                                            // next timeslot is not available skip to next slot ``` nextSlot2 ```
                                                                            continue;
                                                                        }
                                                                    }
                                                                    else {
                                                                        // next timeslot is not available skip to next slot
                                                                        continue;
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                    else {
                                                        // next timeslot is not available skip to next slot
                                                        continue;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    else {
                                        // next timeslot is not available skip to next slot
                                        continue;
                                    }
                                }
                            }
                        }
                        else {
                            // check if room is available
                            $roomSchemaSlots = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lectureroom_id', $availableRoom['lecture_room_id'])->where('start_time', '=', $slot->start_time)->get();
                            if(count($roomSchemaSlots)>0){
                                // room is not available skip to next slot
                                continue;
                            }
                            else {
                                // check if lecturer is available
                                $lecturerSchemaSlots = DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('day_of_week', $slot->day_of_week)->where('lecturer_id', $session->lecturer_id)->where('start_time', '=', $slot->start_time)->get();                                
                                if(count($lecturerSchemaSlots)>0){
                                    // lecturer is not available skip to next slot
                                    continue;
                                }
                                else {
                                    // assign session to timeslot and get out of loop
                                    // begin db transaction
                                    DB::beginTransaction();
                                    DB::table($this->timetableInstance->table_prefix.'_group_schema')->where('schema_id', $slot->schema_id)->update([
                                        'session_id' => $session->id,
                                        'lectureroom_id' => $availableRoom['lecture_room_id'],
                                        'lecturer_id' => $session->lecturer_id,
                                        'status' => 1,
                                    ]);
                                    DB::table($this->timetableInstance->table_prefix.'_sessions')->where('id', $session->id)->update([
                                        'is_assigned' => 1,
                                    ]);
                                    DB::commit();
                                    echo 'Unit Assingment Successful!!!' . PHP_EOL;
                                    return true;
                                }
                            }

                        }
                    }
                }
                else
                {
                    echo 'No available schema slots found for ' . $session->unit_code .' '. $session->cohort_code . ' ' . $session->group_name .' Unit Assingment Failed!!!' . PHP_EOL;
                    return null;
                }
            }
        }
    }

    /**
     * Assign sessions to schema slots.
     */
    public function assignSessionsToSchemaSlots()
    {
        // get all groups
        $groups = DB::table($this->timetableInstance->table_prefix.'_groups')->get();
        // get all full day sessions that are not assigned
        $fullDaySessions = $this->timetableInstance->fullDaySessions();
        // shuffle the unassigned sessions
        $fullDaySessions = $fullDaySessions->shuffle();
        // loop through each session until all sessions are assigned
        foreach ($fullDaySessions as $session)
        {
            $this->runAssign($session->id);
        }
        // get all sessions greater than 3 hours and assign
        $sessionsGreaterThan3Hours = $this->timetableInstance->sessionsGreaterThan3Hours();
        $sessionsGreaterThan3Hours = $sessionsGreaterThan3Hours->shuffle();
        foreach ($sessionsGreaterThan3Hours as $session)
        {
            $this->runAssign($session->id);
        }
        // get all sessions with preferences that are not assigned
        $sessionsWithPrefs = $this->timetableInstance->sessionsWithPrefs();
        $unassignedSessions = array_filter($sessionsWithPrefs, function ($session) {
            return $session->is_assigned == 0;
        });
        // shuffle the unassigned sessions
        shuffle($unassignedSessions);   
        // loop through each session until all sessions are assigned
        foreach ($unassignedSessions as $session)
        {
            $this->runAssign($session->id);
        }
        // get all sessions with no preferences that are not assigned
        $sessionsWithNoPrefs = $this->timetableInstance->sessionsWithoutPrefs();
        $unassignedSessions = array_filter($sessionsWithNoPrefs, function ($session) {
            return $session->is_assigned == 0;
        });
        // order the sessions by sum of lecturer hours and lab hours as from largest to smallest. Note that the $unassignedSessions here is an array
        $unassignedSessions = collect($unassignedSessions)->sortByDesc(function ($session) {
            return $session->lecturer_hours + $session->lab_hours;
        });
        // loop through each session until all sessions are assigned
        foreach ($unassignedSessions as $session)
        {
            $this->runAssign($session->id);
        }
        // repeat this process for each group 5 times unless all sessions are assigned
        $i = 0;
        while($i < 5) {
            $i++;
            foreach($groups as $group)
            {
                // get all sessions that are not assigned
                $unassignedSessions = $this->timetableInstance->unAssignedSessions($group->group_id);
                // order the sessions by sum of lecturer hours and lab hours as from largest to smallest
                $unassignedSessions = $unassignedSessions->sortByDesc(function ($session) {
                    return $session->lecturer_hours + $session->lab_hours;
                });
                // loop through each session until all sessions are assigned
                foreach ($unassignedSessions as $session)
                {
                    $this->runAssign($session->id);
                }        
            }
        }
        // now run assign ignoring preferences for all unassigned units
        foreach($groups as $group)
        {
            // get all sessions that are not assigned
            $unassignedSessions = $this->timetableInstance->unAssignedSessions($group->group_id);
            // order the sessions by sum of lecturer hours and lab hours as from largest to smallest
            $unassignedSessions = $unassignedSessions->sortByDesc(function ($session) {
                return $session->lecturer_hours + $session->lab_hours;
            });
            // loop through each session until all sessions are assigned
            foreach ($unassignedSessions as $session)
            {
                $this->runAssignF($session->id);
            }        
        }
    }
}
