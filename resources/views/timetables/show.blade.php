@extends('layouts.app', ['class' => 'g-sidenav-show bg-primary-100'])

@section('breadcrumb')
    <li class="breadcrumb-item text-sm text-white"><a class="opacity-5 text-white" href="{{ route('timetables') }}">Timetables</a></li>
@endsection

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => $instance->name])
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
                                        3
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                    <i class="ni ni-building text-lg opacity-10" aria-hidden="true"></i>
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
                                        3
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
                                        3
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
                                        3
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
        <div class="mt-4">
            <div class="card ">
                <div class="card-header pb-0 p-3">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-2">Cohorts</h6>
                    </div>
                </div>
                <div class="table-responsive card-body">
                    <table class="table align-items-center table-striped"  id="dt-basic3">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Cohort</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Program</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">School</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Stats</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($instance->groups() as $group)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="{{ asset('assets/img/tt.png') }}" class="avatar avatar-sm me-3" alt="spotify">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $group->cohort_name }}</h6>
                                                <p class="text-xs text-secondary mb-0">Group: {{ $group->group_name }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $group->group_name }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $group->group_name }}</p>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column align-items-left">
                                            <span class="text-xs font-weight-bold">{{ $group->student_count }} Students</span>
                                            <span class="text-xs font-weight-bold">{{ $instance->freeSessions($group->group_id)->count() }} Free Sessions</span>
                                            <span class="text-xs font-weight-bold">{{ $instance->assignedSessions($group->group_id)->count() }} Occupied Sessions</span>
                                            <span class="text-xs font-weight-bold">{{ $instance->unAssignedSessions($group->group_id)->count() }} Unassigned Sessions</span>
                                            <span class="text-xs font-weight-bold">{{ $instance->requiredSessions($group->group_id)->count() }} Required Sessions</span>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <form method="POST" action="{{ route('groupPDF') }}">
                                            @csrf
                                            <input type="hidden" name="group_id" value="{{ $group->group_id }}">
                                            <input type="hidden" name="table" value="{{ $instance->table_prefix }}">
                                            <input type="hidden" name="group_name" value="{{ $group->group_name }}">
                                            <input type="hidden" name="instance_name" value="{{ $instance->name }}">
                                            <input type="hidden" name="gen" value="{{ $instance->created_at }}">
                                            <input type="hidden" name="instance_id" value="{{ $instance->timetable_instance_id }}">                                            
                                            <button type="submit" class="btn btn-link text-secondary mb-0">
                                                <i class="fa fa-print"></i> Print Timetable
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer p-0">
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.2/jquery.js" integrity="sha512-NMtENEqUQ8zHZWjwLg6/1FmcTWwRS2T5f487CCbQB3pQwouZfbrQfylryimT3XvQnpE7ctEKoZgQOAkWkCW/vg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
@endsection
