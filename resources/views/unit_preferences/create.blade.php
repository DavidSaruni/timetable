@extends('layouts.app', ['class' => 'g-sidenav-show bg-primary-100'])

@section('breadcrumb')
    <li class="breadcrumb-item text-sm text-white"><a class="opacity-5 text-white" href="{{ route('preferences') }}">Preferences</a></li>
@endsection

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Create Unit Preferences'])
    <div class="container-fluid py-4">
        <div class="card card-primary">
            <form method="post" action="{{ route('unitPreferences.store') }}" autocomplete="off">
                @csrf
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-0">{{ $unit->name }}</h6>
                    </div>
                </div>
                <div class="card-body p-3">
                    <input type="hidden" name="unit_id" value="{{ $unit->unit_id }}">
                    <hr class="my-2">
                    <label>Periods</label>
                    <p class="mb-0">
                        Select all the preferred times for the unit. 
                        <br>
                        <span class="text-danger text-sm">Note: </span>
                        <span class="text-sm">
                            If a time is not selected, it will be assumed that the unit cannot be scheduled during that time.
                        </span>
                    </p>
                    <div class="row">
                        @foreach ($school_periods as $day => $school_period)
                            <div class="col">
                                <label>{{ $day }}</label>
                                <div class="input-group mb-3">
                                    <select name="school_period_ids[]" multiple class="form-control" id="choices-button" aria-label="school_period_ids" aria-describedby="school_period_ids-addon">
                                        @foreach ($school_period as $period)
                                            <option value="{{ $period->school_period_id }}">{{ date('H:i', strtotime($period->start_time))   }} - {{ date('H:i', strtotime($period->end_time))     }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <p class="mb-0">
                        <span class="text-danger text-sm">Note: </span>
                        <span class="text-sm">
                            If a time is not selected, it will be assumed that the unit cannot be scheduled during that time.
                        </span>
                    </p>
                    <hr class="my-2">
                    <label>Lecture Rooms</label>
                    <p class="mb-0">
                        Select all the preferred rooms for the unit.
                        <br>
                        <span class="text-danger text-sm">Note: </span>
                        <span class="text-sm">
                            If a room is not selected, it will be assumed that the unit cannot be scheduled in that room.
                        </span>
                    </p>
                    <div class="row">
                        @foreach ($buildings as $building)
                            <div class="col-md-3">
                                <label>{{ $building->name }}</label>
                                <div class="input-group mb-3">
                                    <select name="lecture_room_ids[]" multiple class="form-control" id="choices-button" aria-label="lecture_room_ids" aria-describedby="lecture_room_ids-addon">
                                        @foreach ($building->lectureRooms as $lecture_room)
                                            <option value="{{ $lecture_room->lecture_room_id }}">{{ $lecture_room->lecture_room_name }} - {{ $lecture_room->lecture_room_capacity }} Seats</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <p class="mb-0">
                        <span class="text-danger text-sm">Note: </span>
                        <span class="text-sm">
                            If a room is not selected, it will be assumed that the unit cannot be scheduled in that room.
                        </span>
                    </p>
                    <hr class="my-2">
                    @if($unit->has_lab == true)
                        <label>Laboratory Rooms</label>
                        <p class="mb-0">
                            Select all the preferred rooms for the unit.
                            <br>
                            <span class="text-danger text-sm">Note: </span>
                            <span class="text-sm">
                                If a room is not selected, it will be assumed that the unit cannot be scheduled in that room.
                            </span>
                        </p>
                        <div class="row">
                            @foreach ($buildings as $building)
                                @if ($building->labs->count() > 1)
                                    @if($building->labs->where('lab_type', $unit->labtype_id)->count() > 0)
                                        <div class="col-md-4">
                                            <label>{{ $building->name }}</label>
                                            <div class="input-group mb-3">
                                                <select name="lab_ids[]" multiple class="form-control" id="choices-button" aria-label="lab_ids" aria-describedby="lab_ids-addon">
                                                    @foreach ($building->labs as $lab)
                                                        @if($lab->lab_type == $unit->labtype_id)
                                                            <option value="{{ $lab->lab_id }}">{{ $lab->lab_name }} - {{ $lab->lab_capacity }} Seats</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                        <p class="mb-0">
                            <span class="text-danger text-sm">Note: </span>
                            <span class="text-sm">
                                If a room is not selected, it will be assumed that the unit cannot be scheduled in that room.
                            </span>
                        </p>
                        <hr class="my-2">
                    @endif
                </div>
                <div class="card-footer px-3 border-0 d-flex align-items-center justify-content-between">
                    <a href="{{ route('preferences') }}" class="btn btn-sm btn-secondary btn-round px-3">Back</a>
                    <button type="submit" class="btn btn-sm btn-primary btn-round px-3">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection
