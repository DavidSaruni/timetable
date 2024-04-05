@extends('layouts.app', ['class' => 'g-sidenav-show bg-primary-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => $school->name])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Departments</p>
                                    <h5 class="font-weight-bolder">
                                        {{$school->departments->count()}}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                    <i class="ni ni-books text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Programs</p>
                                    <h5 class="font-weight-bolder">
                                        {{$school->programs->count()}}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Lecturers</p>
                                    <h5 class="font-weight-bolder">
                                        {{$school->lecturers->count()}}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                    <i class="fa fa-users text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Cohorts</p>
                                    <h5 class="font-weight-bolder">
                                        {{$school->cohorts->count()}}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                    <i class="ni ni-chart-pie-35 text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-8 mb-lg-0 mb-4 d-flex align-items-center">
                <div class="col-12">
                    <div class="card p-2">
                        <div class="card-header d-flex justify-content-between">
                            <h6 class="mb-2">Departments</h6>
                            @if($hods->count() > 0)
                                <a href="javascript:;" class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#addDepartment">Add Department</a>
                            @else
                                <button class="btn btn-primary btn-sm mb-3" disabled>Add Department</button>
                            @endif
                        </div>
                        <div class="table-responsive card-body p-0">
                            <table class="table table-striped align-items-center mb-0"  id="dt-basic3">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Department</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">HOD</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($school->departments as $department)
                                        <tr>
                                            <td class="w-30">
                                                <p class="text-sm px-3 font-weight-bold mb-0">{{$department->name}}</p>
                                            </td>
                                            <td>
                                                <div>
                                                    <h6 class="text-sm mb-0">{{ $department->hod->title}} {{ $department->hod->name}}</h6>
                                                    <p class="text-xs font-weight-bold mb-0">{{ $department->hod->email}}</p>
                                                </div>
                                            </td>
                                            <td class="align-middle text-sm">
                                                <a href="/departments/{{$department->department_id}}" class="btn btn-success font-weight-bold btn-xs view" data-id="1">
                                                    <i class="fas fa-eye" aria-hidden="true"></i>
                                                </a>
                                                <a href="javascript:;" class="btn btn-primary font-weight-bold btn-xs delete" data-id="1">
                                                    <i class="fas fa-trash" aria-hidden="true"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="text-center">
                                            <td colspan="3">
                                                No Departments Found <a href="javascript:;" class="" data-bs-toggle="modal" data-bs-target="#addDepartment">Create One?</a>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer px-3 border-0 d-flex align-items-center justify-content-between">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4  d-flex align-items-center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="d-flex justify-content-between">
                                <h6 class="mb-0">Buildings</h6>
                                @if($buildings->count() > 0)
                                    @if($school->buildings->count() > 0)
                                        <a href="javascript:;" class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#addBuilding">Add Building</a>
                                    @else
                                        <a href="javascript:;" class="btn btn-primary btn-sm mb-0" data-bs-toggle="modal" data-bs-target="#addBuilding">Add Building</a>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <ul class="list-group">
                                @forelse($school->buildings as $building)
                                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                        <div class="d-flex align-items-center">
                                            <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                                <i class="ni ni-building text-white opacity-10"></i>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1 text-dark text-sm">{{$building->name}}</h6>
                                                <span class="text-xs">{{$building->lectureRooms->count()}} Lecture Rooms, {{$building->labs->count()}} Labs</span>
                                            </div>
                                        </div>
                                        <div class="d-flex">
                                            <form action="{{ route('schoolbuilding.destroy') }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <input type="hidden" name="school_id" value="{{ $school->school_id }}">
                                                <input type="hidden" name="building_id" value="{{ $building->building_id }}">
                                                <button class="btn btn-link btn-danger btn-rounded btn-xs icon-move-left my-auto">
                                                    <i class="fa fa-ban" aria-hidden="true"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </li>
                                @empty
                                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                        <div class="d-flex align-items-center">
                                            <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                                <i class="ni ni-building text-white opacity-10"></i>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1 text-dark text-sm">No Buildings</h6>
                                            </div>
                                        </div>
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                    <div class="card mt-4">
                        <div class="card-header pb-0">
                            <div class="d-flex justify-content-between">
                                <h6 class="mb-0">Full Day Locations</h6>
                                @if($fullDayLocations->count() > 0)
                                    @if($school->fullDayLocations->count() > 0)
                                        <a href="javascript:;" class="btn btn-success btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#addLocation">Add</a>
                                    @else
                                        <a href="javascript:;" class="btn btn-success btn-sm mb-0" data-bs-toggle="modal" data-bs-target="#addLocation">Add</a>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <ul class="list-group">
                                @forelse($school->fullDayLocations as $location)
                                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                        <div class="d-flex align-items-center">
                                            <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                                <i class="fa fa-thumbtack text-white opacity-10"></i>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1 text-dark text-sm">{{$location->name}}</h6>
                                                <span class="text-xs">{{$location->cohorts}} Cohorts Per Day</span>
                                            </div>
                                        </div>
                                        <div class="d-flex">
                                            <form action="{{ route('schoolFullDayLocation.destroy') }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <input type="hidden" name="school_id" value="{{ $school->school_id }}">
                                                <input type="hidden" name="full_day_location_id" value="{{ $location->full_day_location_id }}">
                                                <button class="btn btn-link btn-danger btn-rounded btn-xs icon-move-left my-auto">
                                                    <i class="fa fa-ban" aria-hidden="true"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </li>
                                @empty
                                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                        <div class="d-flex align-items-center">
                                            <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                                <i class="fas fa-map-pin text-white opacity-10"></i>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1 text-dark text-sm">No Location</h6>
                                            </div>
                                        </div>
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <div class="card ">
                <div class="card-header pb-0 p-3">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-2">Programs</h6>
                        <a href="javascript:;" class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#addProgram">Add Program</a>
                    </div>
                </div>
                <div class="table-responsive card-body">
                    <table class="table align-items-center table-striped"  id="dt-basic2">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Program</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Duration</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Units</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($school->programs as $program)
                                <tr>
                                    <td>
                                        <div class="ps-3">
                                            <h6 class="text-sm mb-0">{{ $program->name }}</h6>
                                            <p class="text-xs font-weight-bold mb-0">{{ $program->code }}</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <h6 class="text-sm mb-0">{{ $program->academic_years }} Academic Years</h6>
                                            <p class="text-xs font-weight-bold mb-0">{{ $program->semesters }} Semesters per year</p>
                                        </div>
                                    </td>
                                    <td class="align-middle text-sm">
                                        {{ $program->units()->count()}}
                                    </td><td class="align-middle text-sm">
                                        <div class="d-flex align-items-center">
                                            <div class="row">
                                                <div class="col-auto pr-1">
                                                    <a href="/programs/{{$program->program_id}}" class="btn btn-success btn-xs view" data-id="1">
                                                        <i class="fas fa-eye" aria-hidden="true"></i> View
                                                    </a>
                                                </div>
                                                <div class="col-auto pl-0">
                                                    <form action="{{ route('program.destroy') }}" method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <input type="hidden" name="program_id" value="{{ $program->program_id }}">
                                                        <button class="btn btn-link btn-primary btn-xs icon-move-left my-auto">
                                                            <i class="fa fa-trash" aria-hidden="true"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="4">
                                        No Programs Found <a href="javascript:;" class="" data-bs-toggle="modal" data-bs-target="#addProgram">Create One?</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer p-0">
                </div>
            </div>
        </div>
        <div class="mt-4">
            <div class="card ">
                <div class="pb-0 p-3">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="mb-0">Lecturers</h6>
                        @if($lecturers->count() > 0)
                            <a href="javascript:;" class="btn bg-gradient-primary btn-sm float-end mb-0" data-bs-toggle="modal" data-bs-target="#addLecturer">Add Lecturer(s)</a>
                        @else
                            <button href="javascript:;" class="btn bg-gradient-primary btn-sm float-end mb-0" disabled>Add Lecturer(s)</button>
                        @endif
                    </div>
                    <div class="px-4" id="alert">
                    </div>
                    <div class="table-responsive card-body p-0">
                        <table class="table table-striped align-items-center mb-0" id="dt-basic5">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Lecturer</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Role</th>
                                    <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Units</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($school->schoolLecturers as $lecturer)
                                    <tr>
                                        <td>
                                            <div class="ps-3">
                                                <h6 class="text-sm mb-0">{{ $lecturer->lecturer->title }} {{ $lecturer->lecturer->name }}</h6>
                                                <p class="text-xs font-weight-bold mb-0">{{ $lecturer->lecturer->email }}</p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="">
                                                @if($lecturer->lecturer->role == 'DEAN') 
                                                    <h6 class="text-sm mb-0">
                                                        {{ $lecturer->lecturer->deanOf->name }}
                                                    </h6>
                                                    <span class="badge bg-primary">
                                                        {{ $lecturer->lecturer->role}}
                                                    </span>
                                                @elseif($lecturer->lecturer->role == 'HEAD OF DEPARTMENT') 
                                                    <h6 class="text-sm mb-0">
                                                        {{ $lecturer->lecturer->headOfDepartmentOf->name }}
                                                    </h6>
                                                    <span class="badge bg-info">
                                                        Head Of Department
                                                    </span>
                                                @else
                                                    <h6 class="text-sm mb-0">
                                                        {{$school->name}}
                                                    </h6>
                                                    <span class="badge bg-success">
                                                        Lecturer
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            @forelse($lecturer->lecturer->unitsAssigned as $unit)
                                                <span class="badge badge-sm bg-gradient-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="{{$unit->name}}" data-container="body" data-animation="true">{{ $unit->code }}</span>
                                            @empty
                                                <span class="badge badge-sm bg-gradient-primary">No Units</span>
                                            @endforelse
                                        </td>
                                        <td class="align-middle text-sm">
                                            @if($lecturer->lecturer->role == 'LECTURER')
                                                <form action="{{ route('schoollecturer.destroy') }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <input type="hidden" name="school_lecturer_id" value="{{ $lecturer->school_lecturer_id }}">
                                                    <button class="btn btn-link btn-danger btn-rounded btn-xs icon-move-right my-auto">
                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <p class="text-sm mb-0 text-danger">Cannot Delete</p>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="text-center">
                                        <td colspan="4">
                                            No Lecturer Found <a href="javascript:;" class="" data-bs-toggle="modal" data-bs-target="#addLecturer">Add One?</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer p-0">
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
        <!-- Add School Building Modal -->
            <div class="modal fade" id="addBuilding" tabindex="-1" role="dialog" aria-labelledby="addBuildingTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-left">
                                    <h3 class="font-weight-bold text-primary text-gradient">Add Building</h3>
                                </div>
                                <div class="card-body pb-3">
                                    <form role="form text-left" method="post" action="{{ route('schoolbuilding.store') }}">
                                        @csrf
                                        <input type="hidden" required name="school_id" value="{{ $school->school_id }}">
                                        <label>Building</label>
                                        <div class="input-group mb-3">
                                            <select name="building_id" required class="form-control" aria-label="LabType" aria-describedby="building_id-addon">
                                                <option selected>Select Building</option>
                                                @foreach($buildings as $building)
                                                    <option value="{{ $building->building_id }}">{{ $building->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-gradient-primary btn-lg btn-rounded w-100 mt-4 mb-0">Add</button>
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
        <!-- Add School Building Modal -->
        <!-- Add School Location Modal -->
            <div class="modal fade" id="addLocation" tabindex="-1" role="dialog" aria-labelledby="addLocationTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-left">
                                    <h3 class="font-weight-bold text-primary text-gradient">Add Location</h3>
                                </div>
                                <div class="card-body pb-3">
                                    <form role="form text-left" method="post" action="{{ route('schoolFullDayLocation.store') }}">
                                        @csrf
                                        <input type="hidden" required name="school_id" value="{{ $school->school_id }}">
                                        <label>Location</label>
                                        <div class="input-group mb-3">
                                            <select name="full_day_location_id" required class="form-control" aria-label="LabType" aria-describedby="full_day_location_id-addon">
                                                <option selected>Select Location</option>
                                                @foreach($fullDayLocations as $location)
                                                    <option value="{{ $location->full_day_location_id }}">{{ $location->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-gradient-primary btn-lg btn-rounded w-100 mt-4 mb-0">Add</button>
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
        <!-- Add School Location Modal -->
        <!-- Add Department -->
            <div class="modal fade" id="addDepartment" tabindex="-1" role="dialog" aria-labelledby="addDepartmentTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-left">
                                    <h3 class="font-weight-bold text-primary text-gradient">Add Department</h3>
                                </div>
                                <div class="card-body pb-3">
                                    <form role="form text-left" method="post" action="{{ route('department.store') }}">
                                        @csrf
                                        <input type="hidden" required name="school_id" value="{{ $school->school_id }}">
                                        <label>Department Name</label>
                                        <div class="input-group mb-3">
                                            <input type="text" required name="name" class="form-control" placeholder="Department Name" aria-label="Department Name" aria-describedby="name-addon">
                                        </div>
                                        <label>Head of Department</label>
                                        <div class="input-group mb-3">
                                            <select name="hod_id" required class="form-control" idaria-label="hod_id" aria-describedby="hod_id-addon">
                                                <option selected>Select HOD</option>
                                                @foreach($hods as $hod)
                                                    <option value="{{ $hod->user_id }}">{{ $hod->title }} {{ $hod->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-gradient-primary btn-lg btn-rounded w-100 mt-4 mb-0">Create</button>
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
        <!-- Add Department -->
        <!-- Add Program -->
            <div class="modal fade" id="addProgram" tabindex="-1" role="dialog" aria-labelledby="addProgramTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-left">
                                    <h3 class="font-weight-bold text-primary text-gradient">Add Program</h3>
                                </div>
                                <div class="card-body pb-3">
                                    <form role="form text-left" method="post" action="{{ route('program.store') }}">
                                        @csrf
                                        <input type="hidden" required name="school_id" value="{{ $school->school_id }}">
                                        <label>Program Name</label>
                                        <div class="input-group mb-3">
                                            <input type="text" required name="name" class="form-control" placeholder="Program Name" aria-label="Program Name" aria-describedby="name-addon">
                                        </div>
                                        <label>Pogram Code</label>
                                        <div class="input-group mb-3">
                                            <input type="text" required name="code" class="form-control" placeholder="Program Code" aria-label="Program Code" aria-describedby="code-addon">
                                        </div>
                                        <label>No. of Academic Years</label>
                                        <div class="input-group mb-3">
                                            <input type="number" required name="academic_years" class="form-control" placeholder="No. of Academic Years" aria-label="No. of Academic Years" aria-describedby="academic_years-addon" min="1" max="5" step="1">
                                        </div>
                                        <label>No. of Semesters per Academic Year</label>
                                        <div class="input-group mb-3">
                                            <input type="number" required name="semesters" class="form-control" placeholder="No. of Semesters per Academic Year" aria-label="No. of Semesters per Academic Year" aria-describedby="semesters-addon" min="1" max="3" step="1">
                                        </div>
                                        <label>Maximum Group Size</label>
                                        <div class="input-group mb-3">
                                            <input type="number" required name="max_group_size" class="form-control" placeholder="Maximum Group Size" aria-label="Maximum Group Size" aria-describedby="max_group_size-addon" min="1" step="1">
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-gradient-primary btn-lg btn-rounded w-100 mt-4 mb-0">Create</button>
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
        <!-- Add Program -->
        <!-- Add School Lecturer Modal -->
            <div class="modal fade" id="addLecturer" tabindex="-1" role="dialog" aria-labelledby="addLecturerTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-left">
                                    <h3 class="font-weight-bold text-primary text-gradient">Add Lecturer(s)</h3>
                                </div>
                                <div class="card-body pb-3">
                                    <form role="form text-left" method="post" action="{{ route('schoollecturer.store') }}">
                                        @csrf
                                        <input type="hidden" required name="school_id" value="{{ $school->school_id }}">
                                        <label>Lecturer</label>
                                        <div class="input-group mb-3">
                                            <select name="lecturer_ids[]" required multiple class="form-control" idaria-label="Lecturer" aria-describedby="lecturer_id-addon">
                                                @foreach($lecturers as $lecturer)
                                                    <option value="{{ $lecturer->user_id }}">{{ $lecturer->title }} {{ $lecturer->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-gradient-primary btn-lg btn-rounded w-100 mt-4 mb-0">Add</button>
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
        <!-- Add School Lecturer Modal -->
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.2/jquery.js" integrity="sha512-NMtENEqUQ8zHZWjwLg6/1FmcTWwRS2T5f487CCbQB3pQwouZfbrQfylryimT3XvQnpE7ctEKoZgQOAkWkCW/vg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
        $(function(){
            $(document).on('click', '.edit', function(e){
                e.preventDefault();
                $('#edit').modal('show');
                var id = $(this).data('id');
                getRow(id);
            });
    
            $(document).on('click', '.delete', function(e){
                e.preventDefault();
                $('#deleteSchool').modal('show');
                var id = $(this).data('id');
                getRow(id);
            });    
        });
        function getRow(id){
            $.ajax({
                type: 'GET',
                url: '{{URL::to('schoolRow')}}',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    $('.sid').val(response.school_id);
                    $('#edit_type').val(response.slug);
                    $('#edit_description').val(response.name);
                    $('.catname').html(response.name);
                }
            });
        } 
    </script>
@endsection
