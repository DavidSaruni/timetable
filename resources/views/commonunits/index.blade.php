@extends('layouts.app', ['class' => 'g-sidenav-show bg-primary-100'])
@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Common Units'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="pb-0 p-3">
                        <div class="card-header d-flex justify-content-between">
                            <h5 class="mb-0">Common Units Management</h5>
                            <button type="button" class="btn bg-gradient-primary btn-sm float-end mb-0" data-bs-toggle="modal" data-bs-target="#addUnitModal">Create Common Unit</button>
                        </div>
                        <div class="px-4" id="alert">
                            </div>
                        <div class="table-responsive card-body p-0">
                            <table class="table table-striped align-items-center mb-0" id="dt-basic">
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
                                    @forelse($commonUnits as $unit)
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
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No Units Found</td>
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
        </div>

        @if($commonUnits->count() > 0)
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
                                        <label>Department</label>
                                        <div class="input-group mb-3">
                                            <select name="department_id" class="form-control" id="department_id">
                                                <option selected disabled>Select Department</option>
                                                @foreach($departments as $department)
                                                    <option value="{{$department->department_id}}">{{$department->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label>Lab Session</label>
                                        <div class="input-group mb-3">
                                            <select name="lab_alternative" class="form-control" id="lab_alternative">
                                                <option selected disabled>Select Lab Session</option>
                                                <option value="false">Weekly Lab Sessions</option>
                                                <option value="true">Once Every Two Weeks</option>
                                            </select>
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
                                        <input type="hidden" name="is_common" value="true">
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
        <!-- Create Unit Assignment Modal -->
            <div class="modal fade" id="addUnitAssignmentModal" tabindex="-1" role="dialog" aria-labelledby="createUnitAssignmentTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-left">
                                    <h3 class="font-weight-bolder text-primary text-gradient">Assign Unit</h3>
                                    <p class="mb-0">Fill in the form below to assign a unit to a lecturer and the cohorts.</p>
                                </div>
                                <div class="card-body pb-3">
                                    <form role="form text-left" method="post" action="{{ route('commonUnitAssingment.store') }}">
                                        @csrf
                                        <label>Unit</label>
                                        <div class="input-group mb-3">
                                            <select name="unit_id" required class="form-control" id="unit_id">
                                                <option selected disabled>Select Unit</option>
                                                @foreach($commonUnits as $unit)
                                                    <option value="{{$unit->unit_id}}">{{$unit->name}} ({{$unit->code}})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label>Lecturer</label>
                                        <div class="input-group mb-3">
                                            <select name="lecturer_id" required class="form-control" id="lecturer_id" required>
                                                <option selected disabled>Select Lecturer</option>
                                                @foreach($lecturers as $lecturer)
                                                    <option value="{{$lecturer->user_id}}">{{$lecturer->title}} {{$lecturer->name}} ({{$lecturer->email}})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label>Cohort</label>
                                        <div class="input-group mb-3">
                                            <select name="cohort_id[]" required class="form-control" id="cohort_id" multiple>
                                                @foreach($cohorts as $cohort)
                                                    <option value="{{$cohort->cohort_id}}">{{$cohort->program->name}} ({{$cohort->name}})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label>Group size(How many students in a group?)</label>
                                        <div class="input-group mb-3">
                                            <input name="group_size" required type="number" class="form-control" placeholder="Group Size" aria-label="Group Size" aria-describedby="group-size-addon" min="1">
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
        <!-- Edit School Modal -->
        <div class="modal fade" id="editSchool" tabindex="-1" role="dialog" aria-labelledby="editSchoolTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-left">
                                    <h3 class="font-weight-bolder text-primary text-gradient">Update School</h3>
                                    <p class="mb-0">Enter school details below</p>
                                </div>
                                <div class="card-body pb-3">
                                    <form role="form text-left" method="post" action="{{ route('school.update') }}">
                                        @csrf
                                        <input type="hidden" class="sid" name="school_id">
                                        <label>School Name</label>
                                        <div class="input-group mb-3">
                                            <input name="name" required type="text" class="form-control" placeholder="Name" aria-label="Name" aria-describedby="name-addon" id="editName">
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn bg-gradient-primary btn-lg btn-rounded w-100 mt-4 mb-0">Update School</button>
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
        <!-- End Edit School Modal -->
        <!-- Delete school Modal -->
            <div class="modal fade" id="deleteSchool" tabindex="-1" role="dialog" aria-labelledby="deleteSchoolTitle" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Deleting...</h4>
                            <span class="close" style="cursor: pointer" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa-solid fa-circle-xmark"></i>
                            </span>
                        </div>
                        <form class="form-horizontal" method="POST" action="/schoolDelete">
                            @csrf
                            @method("DELETE")
                            <div class="modal-body">
                                <input type="hidden" class="sid" name="school_id">
                                <div class="text-center">
                                    <h2 class="bold catname"></h2>
                                    <p>
                                        Are you sure you want to delete this school?
                                        <br>
                                        <span class="text-danger">This action cannot be reversed!</span>
                                    </p>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between pb-0">
                                <button type="button" class="btn btn-sm btn-default btn-flat pull-left" data-bs-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>
                                <button type="submit" class="btn btn-sm btn-primary btn-flat" name="delete"><i class="fa fa-trash"></i> Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <!-- Delete school Modal -->

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
                $('#editSchool').modal('show');
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
                    $('#editName').val(response.name);
                    $('.catname').html(response.name);
                }
            });
        }
        // Get the input element
        const endTimeInput = document.getElementById('end_time_input');
        const startTimeInput = document.getElementById('start_time_input');
        // Function to handle the input event
        endTimeInput.addEventListener('input', function() {
          // Check if the input value is valid (format: "HH:MM")
          if (/^([01]\d|2[0-3]):[0-5]\d$/.test(this.value)) {
            // Update the input value with only the selected hour
            const selectedHour = this.value.split(':')[0];
            this.value = selectedHour + ':00';
          } else {
            // If the input is not valid, clear the input
            this.value = '';
          }
        });
        startTimeInput.addEventListener('input', function() {
          // Check if the input value is valid (format: "HH:MM")
          if (/^([01]\d|2[0-3]):[0-5]\d$/.test(this.value)) {
            // Update the input value with only the selected hour
            const selectedHour = this.value.split(':')[0];
            this.value = selectedHour + ':00';
          } else {
            // If the input is not valid, clear the input
            this.value = '';
          }
        });
    </script>
@endsection
