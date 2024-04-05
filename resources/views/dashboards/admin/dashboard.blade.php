@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Dashboard'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Schools</p>
                                    <h5 class="font-weight-bolder">
                                        {{$schools}}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                    <i class="fa fa-school text-lg opacity-10" aria-hidden="true"></i>
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
                                        {{$programs}}
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
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Users</p>
                                    <h5 class="font-weight-bolder">
                                        {{$users}}
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
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Buildings</p>
                                    <h5 class="font-weight-bolder">
                                        {{$buildings}}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                    <i class="ni ni-building text-lg opacity-10" aria-hidden="true"></i>
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
                            <h6 class="mb-2">Latest Schools</h6>
                            <a href="{{ route('schools') }}" class="btn btn-primary btn-sm mb-3">Schools</a>
                        </div>
                        <div class="table-responsive card-body p-0">
                            <table class="table table-striped align-items-center mb-0"  id="dt-basic2">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">School</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Dean</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($latest_schools as $school)
                                        <tr>
                                            <td class="ps-4">
                                                <div>
                                                    <h6 class="text-sm mb-0">{{$school->name}}</h6>
                                                    <p class="text-xs font-weight-bold mb-0">{{$school->slug}}</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <h6 class="text-sm mb-0">{{$school->dean->title}} {{$school->dean->name}}</h6>
                                                    <p class="text-xs font-weight-bold mb-0">{{$school->dean->email}}</p>
                                                </div>
                                            </td>
                                            <td class="align-middle text-sm">
                                                <a href="/schools/{{$school->school_id}}" class="btn btn-primary font-weight-bold btn-xs view">
                                                    <i class="fas fa-eye" aria-hidden="true"> View</i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">No Schools added yet</td>
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
                                <a href="{{ route('buildings') }}" class="btn btn-primary btn-xs mb-2">All Buildings</a>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <ul class="list-group">
                                @forelse($latest_buildings as $building)
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
                                            <a class="btn btn-link btn-primary btn-rounded btn-xs icon-move-right my-auto" href="/buildings/{{$building->building_id}}">
                                                <i class="fa fa-caret-right" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </li>
                                @empty
                                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                        <div class="d-flex align-items-center">
                                            <p class="text-xs">No buildings added yet</p>
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
                                <a href="{{ route('buildings') }}" class="btn btn-primary btn-xs mb-2">All Locations</a>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <ul class="list-group">
                                @forelse($latest_locations as $location)
                                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                        <div class="d-flex align-items-center">
                                            <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                                <i class="fa fa-thumbtack text-white opacity-10"></i>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1 text-dark text-sm">{{$location->name}}</h6>
                                                <span class="text-xs">{{$location->capacity}} Cohorts Per Day</span>
                                            </div>
                                        </div>
                                        <div class="d-flex">
                                            <a class="btn btn-link btn-primary btn-rounded btn-xs icon-move-right my-auto" href="/fulldaylocations/{{$location->full_day_location_id}}">
                                                <i class="fa fa-caret-right" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </li>
                                @empty
                                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                        <div class="d-flex align-items-center">
                                            <div class="icon icon-shape icon-sm me-3 bg-gradient-primary shadow text-center">
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
        @if($programs > 0)
        <div class="mt-4">
            <div class="card ">
                <div class="card-header pb-0 p-3">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-2">Programs</h6>
                        <a href="/programs" class="btn btn-primary btn-sm mb-3">All Programs</a>
                    </div>
                </div>
                <div class="table-responsive card-body">
                    <table class="table align-items-center table-striped"  id="dt-basic3">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Program</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">School</th>                                    
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Duration</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Units</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latest_programs as $program)
                                <tr>
                                    <td>
                                        <div class="ps-3">
                                            <h6 class="text-sm mb-0">{{ $program->name }}</h6>
                                            <p class="text-xs font-weight-bold mb-0">{{ $program->code }}</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="ps-3">
                                            <h6 class="text-sm mb-0">{{ $program->school->name }}</h6>
                                            <p class="text-xs font-weight-bold mb-0">{{ $program->school->slug }}</p>
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
        @endif
        @include('layouts.footers.auth.footer')
    </div>
@endsection