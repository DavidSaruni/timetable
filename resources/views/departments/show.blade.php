@extends('layouts.app', ['class' => 'g-sidenav-show bg-primary-100'])

@section('breadcrumb')
    @if (auth()->user()->role == 'ADMIN')
        <li class="breadcrumb-item text-sm text-white"><a class="opacity-5 text-white" href="{{ route('schools') }}">Schools</a></li>
        <li class="breadcrumb-item text-sm text-white"><a class="opacity-5 text-white" href="/schools/{{ $department->school->school_id }}">{{ $department->school->slug }}</a></li>
    @endif
@endsection

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => $department->name])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Units</p>
                                    <h5 class="font-weight-bolder">
                                        {{$department->units->count()}}
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
                                        {{$department->programs()->count()}}
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
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Active Lecturers</p>
                                    <h5 class="font-weight-bolder">
                                        {{$department->activeLecturers()->count()}}/{{$department->school->lecturers->count()}}
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
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Cohorts</p>
                                    <h5 class="font-weight-bolder">
                                        {{$department->cohorts()->count()}}
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
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between mb-0">
                        <h5 class="mb-0">Units</h5>
                        <button type="button" class="btn bg-gradient-primary" data-bs-toggle="modal" data-bs-target="#addUnitModal">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <div class="table-responsive card-body mt-0">
                        <table class="table table-striped" id="dt-basic">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-uppercas text-secondary text-xxs font-weight-bolder opacity-7">
                                        Name
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Lecture Duration
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Lab Session
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Stats
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($units as $unit)
                                    <tr>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{$unit->name}}</p>
                                            <p class="text-xs text-secondary mb-0">{{$unit->code}}</p>
                                        </td>
                                        <td>
                                            @if($unit->is_full_day == true)
                                                <p class="text-xs text-secondary mb-0">Full Day</p>
                                            @else
                                                @if($unit->lecturer_hours > 0)
                                                    <p class="text-xs text-secondary mb-0">{{$unit->lecturer_hours}} hrs</p>
                                                @else
                                                    <p class="text-xs text-secondary mb-0">No Session</p>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if($unit->has_lab)
                                                @if($unit->lab_hours > 0)
                                                    <p class="text-xs font-weight-bold mb-0">{{$unit->labtype->type}}</p>
                                                    <p class="text-xs text-secondary mb-0">
                                                        {{$unit->lab_hours}} hrs
                                                        @if($unit->lab_alternative == true)
                                                            / fortnight
                                                        @else
                                                            / week
                                                        @endif
                                                    </p>
                                                @else
                                                    <p class="text-xs text-secondary mb-0">No Session</p>
                                                @endif
                                            @else
                                                <p class="text-xs text-secondary mb-0">No Session</p>
                                            @endif
                                        </td>
                                        <td>
                                            <p class="text-xs text-secondary mb-0">Lecturers: {{$unit->lecturers->count()}}</p>
                                            <p class="text-xs text-secondary mb-0">Cohorts: {{$unit->cohorts->count()}}</p>
                                        </td>

                                        <td>
                                        <a href="" class="btn btn-secondary btn-xs font-weight-bold text-xs mb-0 edit" data-id="{{$unit->unit_id}}" >
                                            Edit
                                        </a>
                                            <form class="d-inline" action="/units/{{$unit->unit_id}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer p-0"></div>
                </div>
            </div>
        </div>
        @if($department->units->count() > 0)
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between mb-0">
                            <h5 class="mb-0">Unit Assingments</h5>
                            <button type="button" class="btn bg-gradient-primary" data-bs-toggle="modal" data-bs-target="#addUnitAssignmentModal">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <div class="table-responsive card-body mt-0">
                            <table class="table table-striped" id="dt-basic5">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-uppercas text-secondary text-xxs font-weight-bolder opacity-7">
                                            Name
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Cohort
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Lecturer
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($unit_assingments as $unit)
                                        <tr>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{$unit->unit->name}}</p>
                                                <p class="text-xs text-secondary mb-0">{{$unit->unit->code}}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{$unit->cohort->name}}</p>
                                                <p class="text-xs text-secondary mb-0">{{$unit->cohort->program->name}}</p>
                                            </td>
                                            <td>
                                                @if($unit->unit->is_full_day == true)
                                                    <p class="text-xs text-secondary mb-0">Full Day. No Lecturer</p>
                                                @else
                                                    <p class="text-xs font-weight-bold mb-0">{{$unit->lecturer->title}} {{$unit->lecturer->name}}</p>
                                                    <p class="text-xs text-secondary mb-0">{{$unit->lecturer->email}}</p>
                                                @endif
                                            </td>
                                            <td>
                                                <form class="d-inline" action="{{ route('unitAssignment.delete')}}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="unit_assignment_id" value="{{$unit->unit_assingment_id}}">
                                                    <button type="submit" class="btn btn-link btn-sm">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer p-0"></div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    @include('layouts.footers.auth.footer')
    <!-- Create Unit Modal -->
        <div class="modal fade" id="addUnitModal" tabindex="-1" role="dialog" aria-labelledby="createUnitTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="card card-plain">
                            <div class="card-header pb-0 text-left">
                                <h3 class="font-weight-bolder text-primary text-gradient">Create New Unit</h3>
                                <p class="mb-0">Fill in the form below to create a new unit.</p>
                            </div>
                            <div class="card-body pb-3">
                                <form role="form text-left" method="post" action="{{ route('unit.store') }}">
                                    @csrf
                                    <label>Unit Name</label>
                                    <div class="input-group mb-3">
                                        <input name="name" required type="text" class="form-control" placeholder="Name" aria-label="Name" aria-describedby="name-addon">
                                    </div>
                                    <label>Unit Code</label>
                                    <div class="input-group mb-3">
                                        <input name="code" required type="text" class="form-control" placeholder="Code" aria-label="Code" aria-describedby="code-addon">
                                    </div>
                                    <input name="department_id" required type="hidden" value="{{$department->department_id}}">
                                    <div class="row">
                                        <div class="col-md-6 d-flex align-items-center">
                                            <div class="col-12 float-right text-end">
                                                <label>Does it have a Lab Session?</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 d-flex align-items-center">
                                            <div class="col-12">
                                                <div class="form-check mb-1">
                                                    <input class="form-check-input" type="radio" name="lab_alternative" id="lab_alternative1" value="false">
                                                    <label class="custom-control-label" for="customRadio1">Weekly Lab Sessions</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="lab_alternative" id="lab_alternative2" value="true">
                                                    <label class="custom-control-label" for="customRadio2">Once Every Two Weeks</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <label>Lab Type</label>
                                    <div class="input-group mb-3">
                                        <select name="labtype_id" class="form-control" id="labtype_id">
                                            <option selected disabled>Select Lab Type</option>

                                            @foreach($labtypes as $labtype)
                                                <option value="{{$labtype->labtype_id}}">{{$labtype->type}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label>Lab Session Length (in hours/week)</label>
                                    <div class="input-group mb-3">
                                        <input name="lab_hours" type="number" class="form-control" placeholder="Session Length" aria-label="Lecture Length" aria-describedby="period-length-addon" min="1" max="6" step="1">
                                    </div>
                                    <label>Lecture Session Length (in hours/week)</label>
                                    <div class="input-group mb-3">
                                        <input name="lecturer_hours" type="number" class="form-control" placeholder="Session Length" aria-label="Lecture Length" aria-describedby="period-length-addon" min="1" max="3" step="1">
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="fcustomCheck1" name="is_full_day" value="true">
                                        <label class="custom-control-label" for="customCheck1">Is it a Full Day Unit? (Like a ward round)</label>
                                      </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-primary btn-lg btn-rounded w-100 mt-4 mb-0">Create Unit</button>
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
    <!-- End Create Unit Modal -->
    <!-- Edit Unit Modal-->
        <div class="modal fade" id="editUnit" tabindex="-1" role="dialog" aria-labelledby="editUnit" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="card card-plain">
                            <div class="card-header pb-0 text-left">
                                <h3 class="font-weight-bolder text-primary text-gradient">Update Unit</h3>
                                <p class="mb-0">Edit the information below to update the unit</p>
                            </div>
                            <div class="card-body pb-3">
                                <form role="form text-left" method="post" action="{{ route('unit.update') }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" class="sid" name="unit_id">
                                    <label>Unit Name</label>
                                    <div class="input-group mb-3">
                                        <input name="name" required type="text" class="form-control" placeholder="Title" aria-label="Title" aria-describedby="title-addon" id="editName">
                                    </div>
                                    <label>Unit Code</label>
                                    <div class="input-group mb-3">
                                        <input name="code" required type="text" class="form-control" placeholder="Code" aria-label="Code" aria-describedby="code-addon" id="editCode">
                                    </div>
                                    <label>Has Lab Session?</label>
                                    <div id="edit_lab_alternative"></div>
                                    <input name="department_id" required type="hidden" value="{{$department->department_id}}">
                                    <label>Lab Type</label>
                                    <div id="edit_labtype"></div>
                                    <label>Lab Session Length (in hours/week)</label>
                                    <div class="input-group mb-3">
                                        <input name="lab_hours" type="number" class="form-control" placeholder="Session Length" aria-label="Lecture Length" aria-describedby="period-length-addon" min="1" max="6" step="1" id="editLabHours">
                                    </div>
                                    <label>Lecture Session Length (in hours/week)</label>
                                    <div class="input-group mb-3">
                                        <input name="lecturer_hours" type="number" class="form-control" placeholder="Session Length" aria-label="Lecture Length" aria-describedby="period-length-addon" min="1" max="3" step="1" id="editLectureHours">
                                    </div>
                                    <div id="edit_full_day"></div>
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
    <!-- End Edit Unit Modal-->
    <!-- Create Unit Assignment Modal -->
        <div class="modal fade" id="addUnitAssignmentModal" tabindex="-1" role="dialog" aria-labelledby="createUnitAssignmentTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="card card-plain">
                            <div class="card-header pb-0 text-left">
                                <h3 class="font-weight-bolder text-primary text-gradient">Assign Unit</h3>
                                <p class="mb-0">Fill in the form below to assign a unit to a lecturer and cohort.</p>
                            </div>
                            <div class="card-body pb-3">
                                <form role="form text-left" method="post" action="{{ route('unitAssignment.store') }}">
                                    @csrf
                                    <label>Unit</label>
                                    <div class="input-group mb-3">
                                        <select name="unit_id" required class="form-control" id="unit_id">
                                            <option selected disabled>Select Unit</option>
                                            @foreach($units as $unit)
                                                <option value="{{$unit->unit_id}}">{{$unit->name}} ({{$unit->code}})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label>Lecturer</label>
                                    <div class="input-group mb-3">
                                        <select name="lecturer_id" required class="form-control" id="lecturer_id" required>
                                            <option selected disabled>Select Lecturer</option>
                                            @foreach($department->school->lecturers as $lecturer)
                                                <option value="{{$lecturer->user_id}}">{{$lecturer->title}} {{$lecturer->name}} ({{$lecturer->email}})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label>Cohort</label>
                                    <div class="input-group mb-3">
                                        <select name="cohort_id" required class="form-control" id="cohort_id">
                                            <option selected disabled>Select Cohort</option>
                                            @foreach($department->school->cohorts as $cohort)
                                                <option value="{{$cohort->cohort_id}}">{{$cohort->program->name}} ({{$cohort->name}})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-primary btn-lg btn-rounded w-100 mt-4 mb-0">Assign Unit</button>
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
    <!-- End Unit Assignment Modal -->
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.2/jquery.js" integrity="sha512-NMtENEqUQ8zHZWjwLg6/1FmcTWwRS2T5f487CCbQB3pQwouZfbrQfylryimT3XvQnpE7ctEKoZgQOAkWkCW/vg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
        $(function(){
            $labtypes = jQuery.parseJSON('{!! $labtypes !!}');
            $(document).on('click', '.edit', function(e){
                e.preventDefault();
                $('#editUnit').modal('show');
                var id = $(this).data('id');
                getRow(id);
            });

            // $(document).on('click', '.delete', function(e){
            //     e.preventDefault();
            //     $('#deleteLabtype').modal('show');
            //     var id = $(this).data('id');
            //     getRow(id);
            // });
        });
        function getRow(id){
            $.ajax({
                type: 'GET',
                url: '{{URL::to('unitRow')}}',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    $('.sid').val(response.unit_id);
                    $('#editName').val(response.name);
                    $('#editCode').val(response.code);
                    $htnl1 = '<div class="input-group mb-3">';
                    $htnl1 += '<select name="labtype_id" class="form-control" id="editLabtype_id">';
                    if(response.labtype_id == null){
                        $htnl1 += '<option selected disabled>Select Lab Type</option>';
                        for (var i = 0; i < $labtypes.length; i++) {
                            $htnl1 += '<option value="'+$labtypes[i].labtype_id+'">'+$labtypes[i].type+'</option>';
                        }
                    }
                    else{
                        $htnl1 += '<option disabled>Select Lab Type</option>';
                        for (var i = 0; i < $labtypes.length; i++) {
                            if($labtypes[i].labtype_id == response.labtype_id){
                                $htnl1 += '<option selected value="'+$labtypes[i].labtype_id+'">'+$labtypes[i].type+'</option>';
                            }
                            else{
                                $htnl1 += '<option value="'+$labtypes[i].labtype_id+'">'+$labtypes[i].type+'</option>';
                            }
                        }
                    }
                    $htnl1 += '</select>';
                    $htnl1 += '</div>';
                    $('#edit_labtype').html($htnl1);
                    $html = '<div class="input-group mb-3">';
                    $html = '<select name="lab_alternative" class="form-control" id="editHasLab" required>';
                    if(response.has_lab != "1"){
                        $html += '<option selected value="">No Lab Session</option>';
                        $html += '<option value="false">Weekly Lab Sessions</option>';
                        $html += '<option value="true">Once Every Two Weeks</option>';
                    }
                    else{
                        if(response.lab_alternative == "1"){
                            $html += '<option value="">No Lab Session</option>';
                            $html += '<option value="false">Weekly Lab Sessions</option>';
                            $html += '<option selected value="true">Once Every Two Weeks</option>';
                        }
                        else{
                            $html += '<option selected value="">No Lab Session</option>';
                            $html += '<option selected value="false">Weekly Lab Sessions</option>';
                            $html += '<option value="true">Once Every Two Weeks</option>';
                        }
                    }
                    $html += '</select>';
                    $html += '</div>';
                    $('#edit_lab_alternative').html($html);
                    $('#editLabHours').val(response.lab_hours);
                    $('#editLectureHours').val(response.lecturer_hours);
                    $html2 = '<div class="form-check">';
                    if(response.is_full_day == "1"){
                        $html2 += '<input class="form-check-input" type="checkbox" id="editIsFullDay" name="is_full_day" value="true" checked>';
                    }
                    else{
                        $html2 += '<input class="form-check-input" type="checkbox" id="editIsFullDay" name="is_full_day" value="true">';
                    }
                    $html2 += '<label class="custom-control-label" for="customCheck1">Is it a Full Day Unit? (Like a ward round)</label>';
                    $html2 += '</div>';
                    $('#edit_full_day').html($html2);
                    $('.catname').html(response.name);
                }
            });
        }
    </script>
@endsection
