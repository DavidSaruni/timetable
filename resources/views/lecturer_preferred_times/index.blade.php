@extends('layouts.app', ['class' => 'g-sidenav-show bg-primary-100'])

@section('breadcrumb')
@endsection

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Preferences'])
    <div class="container-fluid py-4">
        <div class="card">
            <div class="pb-0 p-3">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="mb-0">Lecturer Preferences</h5>
                    <a href="javascript:;" class="btn bg-gradient-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addLecturerPreferenceModal">Add Lecturer Preference</a>
                </div>
                <div class="px-4" id="alert">
                </div>
                <div class="table-responsive card-body p-0">
                    <table class="table table-flush" id="dt-basic">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-uppercas text-secondary text-xxs font-weight-bolder opacity-7">
                                    Lecturer
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Role
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Preferred Times
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody> 
                            @foreach ($lecturer_preferred_times as $user)
                                <tr class="align-middle">
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="{{asset('assets/img/tim.png')}}" class="avatar avatar-sm me-3">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-xs">{{$user->title}} {{$user->name}}</h6>
                                                <p class="text-xs text-secondary mb-0">{{$user->email}}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($user->isDean())
                                            <span class="text-xs font-weight-bold">Dean</span>
                                            <p class="text-xs text-secondary mb-0">{{$user->deanOf->name}}</p>
                                        @elseif($user->isHeadOfDepartment())
                                            <span class="text-xs font-weight-bold">HOD - {{$user->headOfDepartmentOf->school->name}}</span>
                                            <p class="text-xs text-secondary mb-0">{{$user->headOfDepartmentOf->name}}</p>
                                        @elseif($user->isLecturer())
                                            <span class="text-xs font-weight-bold">Lecturer</span>
                                            <p class="text-xs text-secondary mb-0">Kabarak University</p>
                                        @elseif($user->isAdmin())
                                            <span class="text-xs font-weight-bold">System Admin</span>
                                            <p class="text-xs text-secondary mb-0">Kabarak University</p>
                                        @elseif($user->isUser())
                                            <span class="text-xs font-weight-bold">User</span>
                                            <p class="text-xs text-secondary mb-0">Kabarak University</p>
                                        @endif
                                    </td>
                                    <td>
                                        @foreach($user->preferences() as $preference)
                                            <h6 class="text-xs text-secondary mb-0">{{$preference}}</h6>
                                        @endforeach
                                    </td>
                                    <td>
                                        <form action="{{ route('lecturerpreferences.destroy') }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" name="lecturer_id" value="{{ $user->user_id }}">
                                            <button type="submit" class="btn bg-gradient-primary btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach              
                        </tbody>
                    </table>
                </div>
                <div class="card-footer px-3 border-0 d-flex align-items-center justify-content-between">
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <div class="pb-0 p-3">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="mb-0">Unit Preferences</h5>
                    <a href="javascript:;" class="btn bg-gradient-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addUnitPreferenceModal">Add Unit Preference</a>
                </div>
                <div class="px-4" id="alert">
                </div>
                <div class="table-responsive card-body p-0">
                    <table class="table table-flush" id="dt-basic5">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-uppercas text-secondary text-xxs font-weight-bolder opacity-7">
                                    Unit
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Preferred Venue
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Preferred Times
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody> 
                            @foreach ($unit_preferences as $unit)
                                <tr class="align-middle">
                                    <td>
                                        <span class="text-xs font-weight-bold">{{$unit->name}}</span>
                                        <p class="text-xs text-secondary mb-0">{{$unit->code}}</p>
                                    </td>
                                    <td>
                                        @forelse($unit->prefLocationsAttribute() as $location => $venues)
                                            <h6 class="text-xs font-weight-bold">{{$location}}</h6>
                                            <p class="text-xs text-secondary mb-0">
                                                @foreach($venues as $venue)
                                                    {{$venue['room']}}
                                                    @if(!$loop->last)
                                                        ,
                                                    @endif
                                                @endforeach
                                            </p>
                                        @empty
                                            <p class="text-xs text-secondary mb-0">Any Venue</p>
                                        @endforelse
                                    </td>
                                    <td>
                                        @forelse($unit->prefTimesAttribute() as $day => $times)
                                            <h6 class="text-xs font-weight-bold">{{$day}}</h6>
                                            @php
                                                $count = $times->count();
                                                $maxTimes = $unit->school->getPeriodsInDayAttribute();
                                            @endphp
                                    
                                            @if($count == 0)
                                                <p class="text-xs text-secondary mb-0">Not Available</p>
                                            @elseif($count == $maxTimes)
                                                <p class="text-xs text-secondary mb-0">Any Time</p>
                                            @else
                                                @php
                                                    $formattedTimes = [];
                                                    $i = 0;
                                                    while ($i < $count) {
                                                        $start_time = $times[$i]->start_time;
                                                        $end_time = $times[$i]->end_time;
                                                        while ($i < $count - 1 && $end_time == $times[$i + 1]->start_time) {
                                                            $end_time = $times[$i + 1]->end_time;
                                                            $i++;
                                                        }
                                                        $formattedTimes[] = $start_time === $end_time ? $start_time : "$start_time - $end_time";
                                                        $i++;
                                                    }
                                                    $formattedTime = implode(', ', $formattedTimes);
                                                @endphp
                                                <p class="text-xs text-secondary mb-0">{{$formattedTime}}</p>
                                            @endif
                                        @empty
                                            <p class="text-xs text-secondary mb-0">Any Time</p>
                                        @endforelse
                                    </td>
                                    
                                    <td>
                                        <form action="{{ route('unitPreferences.destroy') }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" name="unit_preference_id" value="{{ $unit->unit_preference->unit_preference_id }}">
                                            <button type="submit" class="btn bg-gradient-primary btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach              
                        </tbody>
                    </table>
                </div>
                <div class="card-footer px-3 border-0 d-flex align-items-center justify-content-between">
                </div>
            </div>
        </div>
    </div>
    <!-- Add Lecturer Preference Modal -->
        <div class="modal fade" id="addLecturerPreferenceModal" tabindex="-1" role="dialog" aria-labelledby="addLecturerPreferenceModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="card card-plain">
                            <div class="card-header pb-0 text-center">
                                <h3 class="font-weight-bolder text-primary text-gradient">Add Lecturer Preference</h3>
                                <p class="mb-0">Select a lecturer to add their preferred times.</p>
                            </div>
                            <div class="card-body pb-3">
                                <form role="form text-left" method="post" action="{{ route('lecturerpreferences.store') }}">
                                    @csrf
                                    <label>Lecturer</label>
                                    <div class="input-group mb-3">
                                        <select name="lecturer_id" required class="form-control" id="choices-button" aria-label="Lecturer" aria-describedby="lecturer-addon">
                                            <option selected>Select Lecturer</option>
                                            @foreach($lecturers as $lecturer)
                                                <option value="{{ $lecturer->user_id }}">{{ $lecturer->title }} {{ $lecturer->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <p class="mb-0">
                                        Select all the preferred times for the lecturer. 
                                        <br>
                                        <span class="text-danger text-sm">Note: </span>
                                        <span class="text-sm">
                                            If a time is not selected, it will be assumed that the lecturer is not available during that time.
                                        </span>
                                    </p>
                                    <div class="row">
                                        <div class="col">
                                            <label>Monday</label>
                                            <div class="input-group mb-3">
                                                <select name="monday[]" multiple class="form-control" id="choices-button" aria-label="Monday" aria-describedby="monday-addon">
                                                    <option value="1">07:00 - 10:00</option>
                                                    <option value="2">10:00 - 13:00</option>
                                                    <option value="3">13:00 - 16:00</option>
                                                    <option value="4">16:00 - 19:00</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label>Tuesday</label>
                                            <div class="input-group mb-3">
                                                <select name="tuesday[]" multiple class="form-control" id="choices-button" aria-label="Tuesday" aria-describedby="tuesday-addon">
                                                    <option value="1">07:00 - 10:00</option>
                                                    <option value="2">10:00 - 13:00</option>
                                                    <option value="3">13:00 - 16:00</option>
                                                    <option value="4">16:00 - 19:00</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label>Wednesday</label>
                                            <div class="input-group mb-3">
                                                <select name="wednesday[]" multiple class="form-control" id="choices-button" aria-label="Wednesday" aria-describedby="wednesday-addon">
                                                    <option value="1">07:00 - 10:00</option>
                                                    <option value="3">13:00 - 16:00</option>
                                                    <option value="4">16:00 - 19:00</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label>Thursday</label>
                                            <div class="input-group mb-3">
                                                <select name="thursday[]" multiple class="form-control" id="choices-button" aria-label="Thursday" aria-describedby="thursday-addon">
                                                    <option value="1">07:00 - 10:00</option>
                                                    <option value="2">10:00 - 13:00</option>
                                                    <option value="3">13:00 - 16:00</option>
                                                    <option value="4">16:00 - 19:00</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label>Friday</label>
                                            <div class="input-group mb-3">
                                                <select name="friday[]" multiple class="form-control" id="choices-button" aria-label="Friday" aria-describedby="friday-addon">
                                                    <option value="1">07:00 - 10:00</option>
                                                    <option value="2">10:00 - 13:00</option>
                                                    <option value="3">13:00 - 16:00</option>
                                                    <option value="4">16:00 - 19:00</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mb-0">
                                        <span class="text-danger text-sm">Note: </span>
                                        <span class="text-sm">
                                            If a time is not selected, it will be assumed that the lecturer is not available during that time.
                                        </span>
                                    </p>
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-primary btn-lg btn-rounded w-100 mt-4 mb-0">Add Preference</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center pt-0 px-sm-4 px-1">
                                <p class="mb-4 mx-auto"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- End Add Lecturer Preference Modal -->
    <!-- Add Unit Preference Modal -->
        <div class="modal fade" id="addUnitPreferenceModal" tabindex="-1" role="dialog" aria-labelledby="addUnitPreferenceModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="card card-plain">
                            <div class="card-header pb-0 text-center">
                                <h3 class="font-weight-bolder text-primary text-gradient">Add Unit Preference</h3>
                                <p class="mb-0">Select a unit to and click Proceed to add its preferred times.</p>
                            </div>
                            <div class="card-body pb-3">
                                <form role="form text-left" method="post" action="{{ route('unitPreferences.create') }}">
                                    @csrf
                                    <label>Unit</label>
                                    <div class="input-group mb-3">
                                        <select name="unit_id" required class="form-control" id="choices-button" aria-label="Unit" aria-describedby="unit-addon">
                                            <option selected disabled>Select Unit</option>
                                            @foreach($units as $unit)
                                                <option value="{{ $unit->unit_id }}">{{ $unit->code }} - {{ $unit->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-primary btn-lg btn-rounded w-100 mt-4 mb-0">Proceed</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center pt-0 px-sm-4 px-1">
                                <p class="mb-4 mx-auto"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- End Add Unit Preference Modal -->
@endsection
