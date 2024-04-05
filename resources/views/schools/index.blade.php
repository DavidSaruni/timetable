@extends('layouts.app', ['class' => 'g-sidenav-show bg-primary-100'])
@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Schools'])
    <div class="container-fluid py-4">
        <div class="card">
            <div class="pb-0 p-3">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="mb-0">Schools Management</h5>
                    @if($deans->count() > 0)
                        <button type="button" class="btn bg-gradient-primary btn-sm float-end mb-0" data-bs-toggle="modal" data-bs-target="#createSchool">Create School</button>
                    @else
                        <button type="button" class="btn bg-gradient-primary btn-sm float-end mb-0" disabled>Create School</button>
                    @endif
                </div>
                <div class="px-4" id="alert">
                    </div>
                <div class="table-responsive card-body p-0">
                    <table class="table table-striped align-items-center mb-0" id="dt-basic">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">School</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Dean</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Departments</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Programs</th>
                                <th class="text-center align-middle">
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($schools as $school)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="{{asset('assets/img/logo.png')}}" class="avatar avatar-sm me-3">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-xs">{{$school->name}}</h6>
                                                <p class="text-xs text-secondary mb-0">{{$school->slug}}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{$school->dean->title}} {{$school->dean->name}}</p>
                                        <p class="text-xs text-secondary mb-0">{{$school->dean->email}}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-xs font-weight-bold mb-0">{{$school->departments->count()}}</p>
                                    </td>
                                    <td class="align-middle text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{$school->programs->count()}}</p>
                                    </td>
                                    <td class="align-middle">
                                        <a href="/schools/{{$school->school_id}}" class="btn btn-success btn-xs font-weight-bold text-xs mb-0" data-original-title="View School">
                                            View
                                        </a>
                                        <a href="" class="btn btn-secondary btn-xs font-weight-bold text-xs mb-0 edit" data-id="{{$school->school_id}}">
                                            Edit
                                        </a>
                                        <a class="btn btn-primary btn-xs font-weight-bold text-xs mb-0 delete" data-id="{{$school->school_id}}">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">No schools found! <a href="" data-bs-toggle="modal" data-bs-target="#createSchool">Create School</a>
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
        @include('layouts.footers.auth.footer')
        <!-- Create School Modal -->
            <div class="modal fade" id="createSchool" tabindex="-1" role="dialog" aria-labelledby="createSchoolTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-left">
                                    <h3 class="font-weight-bolder text-primary text-gradient">Create School</h3>
                                    <p class="mb-0">Enter school details below</p>
                                </div>
                                <div class="card-body pb-3">
                                    <form role="form text-left" method="post" action="{{ route('school.store') }}">
                                        @csrf
                                        <label>School Name</label>
                                        <div class="input-group mb-3">
                                            <input name="name" required type="text" class="form-control" placeholder="Name" aria-label="Name" aria-describedby="name-addon">
                                        </div>  
                                        <label>Dean</label>
                                        <div class="input-group mb-3">
                                            <select name="dean_id" required class="form-select" id="single-select-field" data-placeholder="Select Dean" aria-label="Dean" aria-describedby="dean-addon">
                                                <option></option>
                                                @foreach($deans as $dean)
                                                    <option value="{{ $dean->user_id }}">{{ $dean->title }} {{ $dean->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label>Lecture Length (in hours)</label>
                                        <div class="input-group mb-3">
                                            <input name="period_length" required type="number" class="form-control" placeholder="Lecture Length" aria-label="Lecture Length" aria-describedby="period-length-addon" min="1" max="3" step="1">
                                        </div>
                                        <label>Lecture Start At: (eg. 07:00 AM)</label>
                                        <div class="input-group mb-3">
                                            <input id="start_time_input" name="start_time" required type="time" class="form-control" placeholder="Lecture Start Time" aria-label="Lecture Start Time" aria-describedby="start-time-addon" min="07:00" max="10:00" step="3600">
                                        </div>
                                        <label>Lectures End At: (eg. 05:00 PM)</label>
                                        <div class="input-group mb-3">
                                            <input id="end_time_input" name="end_time" required type="time" class="form-control" placeholder="Lecture End Time" aria-label="Lecture End Time" aria-describedby="end-time-addon" min="16:00" max="19:00" step="3600">
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-gradient-primary btn-lg btn-rounded w-100 mt-4 mb-0">Create School</button>
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
        <!-- End Create School Modal -->
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
