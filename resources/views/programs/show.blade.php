@extends('layouts.app', ['class' => 'g-sidenav-show bg-primary-100'])

@section('breadcrumb')
    @if (auth()->user()->role == 'ADMIN')
        <li class="breadcrumb-item text-sm text-white"><a class="opacity-5 text-white" href="{{ route('schools') }}">Schools</a></li>
        <li class="breadcrumb-item text-sm text-white"><a class="opacity-5 text-white" href="/schools/{{$program->school->school_id}}">{{ $program->school->slug }}</a></li>
    @endif
@endsection

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => $program->name])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Cohorts</p>
                                    <h5 class="font-weight-bolder">
                                        {{$program->cohorts->count()}}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                    <i class="ni ni-chart-pie-35 text-lg opacity-10" aria-hidden="true"></i>
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
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Students</p>
                                    <h5 class="font-weight-bolder">
                                        {{$program->students()}}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                    <i class="fa fa-users text-lg opacity-10" aria-hidden="true"></i>
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
                                        {{$program->lecturers()->count()}}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                    <i class="ni ni-badge text-lg opacity-10" aria-hidden="true"></i>
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
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Units</p>
                                    <h5 class="font-weight-bolder">
                                        {{$program->units()->count()}}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                    <i class="ni ni-books text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <div class="card ">
                <div class="pb-0 p-3">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="mb-0">Cohorts</h6>
                    </div>
                    <div class="px-4" id="alert">
                    </div>
                    <div class="table-responsive card-body p-0">
                        <table class="table table-striped align-items-center mb-0" id="dt-basic{{$program->semesters}}">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Cohort</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Units</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Stats</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($program->cohorts as $cohort)
                                    <tr>
                                        <td>
                                            <div class="ps-3">
                                                <h6 class="text-sm mb-0">{{ $cohort->name }}</h6>
                                                <p class="text-xs font-weight-bold mb-0">{{ $cohort->code }}</p>
                                            </div>
                                        </td>
                                        <td>
                                            @forelse($cohort->units() as $unit)
                                                <span class="badge badge-sm bg-gradient-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="{{$unit->name}}" data-container="body" data-animation="true">{{ $unit->code }}</span>
                                                <br>
                                            @empty
                                                <span class="badge badge-sm bg-gradient-primary">No Units</span>
                                            @endforelse
                                        </td>
                                        <td>
                                            <div>
                                                <h6 class="text-sm mb-0">Students: {{ $cohort->student_count }}</h6>
                                                <h6 class="text-sm mb-0">Lecturers: {{ $cohort->lecturers()->count() }}</h6>
                                                <h6 class="text-sm mb-0">Units: {{ $cohort->units()->count() }}</h6>
                                                <h6 class="text-sm mb-0">Groups: 
                                                    @if($cohort->groups->count() < 2)
                                                        No groupings
                                                    @else
                                                        {{ $cohort->groups->count() }}
                                                    @endif
                                                </h6>
                                            </div>
                                        </td>
                                        <td>
                                            @if($cohort->status == "INSESSION")
                                                <span class="badge badge-sm bg-gradient-success">In Session</span>
                                            @elseif($cohort->status == "NOTINSESSION")
                                                <span class="badge badge-sm bg-gradient-danger">Not In Session</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="" class="btn btn-success btn-xs edit" data-id="{{$cohort->cohort_id}}">
                                                <i class="fa fa-spin fa-gear" aria-hidden="true"></i> Update
                                            </a>
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
        
        @include('layouts.footers.auth.footer')

        
        <!-- Update Cohort Modal -->
        <div class="modal fade" id="updateCohort" tabindex="-1" role="dialog" aria-labelledby="updateCohort" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="card card-plain">
                            <div class="card-header pb-0 text-left">
                                <h3 class="font-weight-bolder text-primary text-gradient">Update <span class="catname font-weight-bolder"></span> Cohort</h3>
                                <p class="mb-0">Edit the information below to update the cohort</p>
                            </div>
                            <div class="card-body pb-3">
                                <form role="form text-left" method="post" action="{{ route('cohort.update') }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" class="cohort_id" name="cohort_id">
                                    <label>Student Count</label>
                                    <div class="mb-3">
                                        <input type="number" class="form-control student_count" name="student_count" placeholder="Student Count" required min="0" step="1">
                                    </div>
                                    <label>Status</label>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" name="status" id="customRadio1" checked required value="INSESSION">
                                        <label class="custom-control-label" for="customRadio1">In Session</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="customRadio2" required value="NOTINSESSION">
                                        <label class="custom-control-label" for="customRadio2">Not In Session</label>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-primary btn-lg btn-rounded w-100 mt-4 mb-0">Update</button>
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
    <!-- End Update Cohort Modal -->
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
                $('#updateCohort').modal('show');
                var id = $(this).data('id');
                getRow(id);
            });  
        });
        function getRow(id){
            $.ajax({
                type: 'GET',
                url: '{{URL::to('cohortRow')}}',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    console.log(response);
                    $('.cohort_id').val(response.cohort_id);
                    $('.student_count').val(response.student_count);
                    $('.catname').html(response.code);
                }
            });
        } 
    </script>
@endsection
