@extends('layouts.app', ['class' => 'g-sidenav-show bg-primary-100'])
@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Buildings'])
    <div class="container-fluid py-4">
        <div class="card">
            <div class="pb-0 p-3">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="mb-0">Building Management</h5>
                    <button type="button" class="btn bg-gradient-primary btn-sm float-end mb-0" data-bs-toggle="modal" data-bs-target="#createBuilding">Create Building</button>
                </div>
                <div class="table-responsive card-body p-0">
                    <table class="table table-striped align-items-center mb-0" id="dt-basic">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Building</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Lecture Rooms</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Labaratories</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Schools</th>
                                <th class=""></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($buildings as $building)
                                <tr>
                                    <td class="ps-4">
                                        <h6 class="mb-0 text-xs">{{$building->name}}</h6>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-xs font-weight-bold mb-0">{{$building->lectureRooms->count()}}</p>
                                    </td>
                                    <td class="align-middle text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{$building->labs->count()}}</p>
                                    </td>
                                    <td class="align-middle text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{$building->schoolBuildings->count()}}</p>
                                    </td>
                                    <td>
                                        <a href="/buildings/{{$building->building_id}}" class="btn btn-success btn-xs font-weight-bold text-xs mb-0" data-original-title="View Building">
                                            View
                                        </a>
                                        <a href="" class="btn btn-secondary btn-xs font-weight-bold text-xs mb-0 edit" data-id="{{$building->building_id}}">
                                            Edit
                                        </a>
                                        <a class="btn btn-primary btn-xs font-weight-bold text-xs mb-0 delete" data-id="{{$building->building_id}}">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">No buildings found! <a href="" data-bs-toggle="modal" data-bs-target="#createBuilding">Create Building</a>
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
        <div class="card mt-4">
            <div class="pb-0 p-3">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="mb-0">Full Day Session Locations</h5>
                    <button type="button" class="btn bg-gradient-primary btn-sm float-end mb-0" data-bs-toggle="modal" data-bs-target="#createLocation">Create Location</button>
                </div>
                <div class="table-responsive card-body p-0">
                    <table class="table table-striped align-items-center mb-0" id="dt-basic5">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Location</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Capacity</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Days Available</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Schools</th>
                                <th class=""></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($fullDayLocations as $location)
                                <tr>
                                    <td class="ps-4">
                                        <h6 class="mb-0 text-xs">{{$location->name}}</h6>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-xs font-weight-bold mb-0">{{$location->cohorts}} Per Day</p>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-xs font-weight-bold mb-0">
                                            @php
                                                $days = $location->days;
                                                // as of now $days = ["Monday","Tuesday","Wednesday","Thursday","Friday"], convert it to Monday, Tuesday, Wednesday, Thursday, Friday
                                                $days = json_decode($days);
                                                $days = implode(", ", $days);
                                            @endphp
                                            {{$days}}
                                        </p>
                                    </td>
                                    <td class="align-middle text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{$location->schoolFullDayLocations->count()}}</p>
                                    </td>
                                    <td>
                                        <a href="/fulldaylocations/{{$location->full_day_location_id}}" class="btn btn-success btn-xs font-weight-bold text-xs mb-0" data-original-title="View Location">
                                            View
                                        </a>
                                        <a href="" class="btn btn-secondary btn-xs font-weight-bold text-xs mb-0 edit2" data-id="{{$location->full_day_location_id}}">
                                            Edit
                                        </a>
                                        <a class="btn btn-primary btn-xs font-weight-bold text-xs mb-0 delete2" data-id="{{$location->full_day_location_id}}">
                                            Delete
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
        @include('layouts.footers.auth.footer')
        <!-- Create Building Modal -->
            <div class="modal fade" id="createBuilding" tabindex="-1" role="dialog" aria-labelledby="createBuildingTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-left">
                                    <h3 class="font-weight-bolder text-primary text-gradient">Create Building</h3>
                                    <p class="mb-0">Enter building details below</p>
                                </div>
                                <div class="card-body pb-3">
                                    <form role="form text-left" method="post" action="{{ route('building.store') }}">
                                        @csrf
                                        <label>Building Name <span class="text-danger">*</span></label>
                                        <div class="input-group mb-3">
                                            <input name="name" required type="text" class="form-control" placeholder="Name" aria-label="Name" aria-describedby="name-addon">
                                        </div> 
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-gradient-primary btn-lg btn-rounded w-100 mt-4 mb-0">Create Building</button>
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
        <!-- End Create Building Modal -->
        <!-- Edit Building Modal -->
            <div class="modal fade" id="editBuilding" tabindex="-1" role="dialog" aria-labelledby="createBuildingTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-left">
                                    <h3 class="font-weight-bolder text-primary text-gradient">Update Building</h3>
                                    <p class="mb-0">Enter building details below</p>
                                </div>
                                <div class="card-body pb-3">
                                    <form role="form text-left" method="post" action="{{ route('building.update') }}">
                                        @csrf
                                        <input type="hidden" name="building_id" class="sid">
                                        <label>Building Name <span class="text-danger">*</span></label>
                                        <div class="input-group mb-3">
                                            <input name="name" required type="text" class="form-control" placeholder="Name" aria-label="Name" aria-describedby="name-addon" id="editName">
                                        </div> 
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-gradient-primary btn-lg btn-rounded w-100 mt-4 mb-0">Update Building</button>
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
        <!-- End Edit Building Modal -->
        <!-- Delete building Modal -->
            <div class="modal fade" id="deleteBuilding" tabindex="-1" role="dialog" aria-labelledby="deleteBuildingTitle" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Deleting...</h4>
                            <span class="close" style="cursor: pointer" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa-solid fa-circle-xmark"></i>
                            </span>
                        </div>
                        <form class="form-horizontal" method="POST" action="/buildingDelete">
                            @csrf
                            @method("DELETE")
                            <div class="modal-body">
                                <input type="hidden" class="sid" name="building_id">
                                <div class="text-center">
                                    <h2 class="bold catname"></h2>
                                    <p>
                                        Are you sure you want to delete this building?
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
        <!-- Delete building Modal -->
        <!-- Create Location Modal -->
            <div class="modal fade" id="createLocation" tabindex="-1" role="dialog" aria-labelledby="createLocationTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-left">
                                    <h3 class="font-weight-bolder text-primary text-gradient">Create Location</h3>
                                    <p class="mb-0">Enter location details below</p>
                                </div>
                                <div class="card-body pb-3">
                                    <form role="form text-left" method="post" action="{{ route('fulldaylocation.update') }}">
                                        @csrf
                                        <label>Location Name <span class="text-danger">*</span></label>
                                        <div class="input-group mb-3">
                                            <input name="name" required type="text" class="form-control" placeholder="Name" aria-label="Name" aria-describedby="name-addon">
                                        </div> 
                                        <label>Capacity <span class="text-danger">*</span></label>
                                        <p class="text-sm">Enter the number of cohorts this location can hold per day</p>
                                        <div class="input-group mb-3">
                                            <input name="cohorts" required type="number" class="form-control" placeholder="Cohorts" aria-label="Cohorts" aria-describedby="cohorts-addon" min="1" step="1">
                                        </div>
                                        <label>Days Available <span class="text-danger">*</span></label>
                                        <p class="text-sm">Select the days this location is available</p>
                                        <div class="row flex flex-row d-flex justify-content-center">
                                            <div class="col-md-4 flex flex-column">
                                                <input type="checkbox" name="days[]" value="Monday" id="monday">
                                                <label for="monday">Monday</label>
                                            </div>
                                            <div class="col-md-4 flex flex-column">
                                                <input type="checkbox" name="days[]" value="Tuesday" id="tuesday">
                                                <label for="tuesday">Tuesday</label>
                                            </div>
                                            <div class="col-md-4 flex flex-column">
                                                <input type="checkbox" name="days[]" value="Wednesday" id="wednesday">
                                                <label for="wednesday">Wednesday</label>
                                            </div>
                                            <div class="col-md-4 flex flex-column">
                                                <input type="checkbox" name="days[]" value="Thursday" id="thursday">
                                                <label for="thursday">Thursday</label>
                                            </div>
                                            <div class="col-md-4 flex flex-column">
                                                <input type="checkbox" name="days[]" value="Friday" id="friday">
                                                <label for="friday">Friday</label>
                                            </div>
                                        </div>
                                        <hr/>
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-gradient-primary btn-lg btn-rounded w-100 mt-4 mb-0">Create Location</button>
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
        <!-- End Create Location Modal -->
        <!-- Edit Location Modal -->
        <div class="modal fade" id="editLocation" tabindex="-1" role="dialog" aria-labelledby="createLocationTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-left">
                                    <h3 class="font-weight-bolder text-primary text-gradient">Edit Location</h3>
                                    <p class="mb-0">Enter location details below</p>
                                </div>
                                <div class="card-body pb-3">
                                    <form role="form text-left" method="post" action="{{ route('fulldaylocation.update') }}">
                                        @csrf
                                        <input type="hidden" name="full_day_location_id" class="lid">
                                        <label>Location Name <span class="text-danger">*</span></label>
                                        <div class="input-group mb-3">
                                            <input name="name" required type="text" class="form-control" placeholder="Name" aria-label="Name" aria-describedby="name-addon" id="edit_Name">
                                        </div> 
                                        <label>Capacity <span class="text-danger">*</span></label>
                                        <p class="text-sm">Enter the number of cohorts this location can hold per day</p>
                                        <div class="input-group mb-3">
                                            <input name="cohorts" required type="number" class="form-control" placeholder="Cohorts" aria-label="Cohorts" aria-describedby="cohorts-addon" min="1" step="1" id="editCohorts">
                                        </div>
                                        <label>Days Available <span class="text-danger">*</span></label>
                                        <p class="text-sm">Select the days this location is available</p>
                                        <div class="row flex flex-row d-flex justify-content-center">
                                            <div class="col-md-4 flex flex-column">
                                                <input type="checkbox" name="days[]" value="Monday" id="editmonday">
                                                <label for="monday">Monday</label>
                                            </div>
                                            <div class="col-md-4 flex flex-column">
                                                <input type="checkbox" name="days[]" value="Tuesday" id="edittuesday">
                                                <label for="tuesday">Tuesday</label>
                                            </div>
                                            <div class="col-md-4 flex flex-column">
                                                <input type="checkbox" name="days[]" value="Wednesday" id="editwednesday">
                                                <label for="wednesday">Wednesday</label>
                                            </div>
                                            <div class="col-md-4 flex flex-column">
                                                <input type="checkbox" name="days[]" value="Thursday" id="editthursday">
                                                <label for="thursday">Thursday</label>
                                            </div>
                                            <div class="col-md-4 flex flex-column">
                                                <input type="checkbox" name="days[]" value="Friday" id="editfriday">
                                                <label for="friday">Friday</label>
                                            </div>
                                        </div>
                                        <hr/>
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-gradient-primary btn-lg btn-rounded w-100 mt-4 mb-0">Update Location</button>
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
        <!-- End Edit Location Modal -->
        <!-- Delete Location Modal -->
            <div class="modal fade" id="deleteLocation" tabindex="-1" role="dialog" aria-labelledby="deleteLocationTitle" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Deleting...</h4>
                            <span class="close" style="cursor: pointer" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa-solid fa-circle-xmark"></i>
                            </span>
                        </div>
                        <form class="form-horizontal" method="POST" action="/fulldaylocationDelete">
                            @csrf
                            @method("DELETE")
                            <div class="modal-body">
                                <input type="hidden" class="sid" name="fullDayLocation_id">
                                <div class="text-center">
                                    <h2 class="bold catname"></h2>
                                    <p>
                                        Are you sure you want to delete this Location?
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
        <!-- Delete Location Modal -->
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
                $('#editBuilding').modal('show');
                var id = $(this).data('id');
                getRow(id);
            });

            $(document).on('click', '.edit2', function(e){
                e.preventDefault();
                $('#editLocation').modal('show');
                var id = $(this).data('id');
                console.log('yessir');
                getLRow(id);
            });
    
            $(document).on('click', '.delete', function(e){
                e.preventDefault();
                $('#deleteBuilding').modal('show');
                var id = $(this).data('id');
                getRow(id);
            }); 
            
            $(document).on('click', '.delete2', function(e){
                e.preventDefault();
                $('#deleteLocation').modal('show');
                var id = $(this).data('id');
                getLRow(id);
            });
        });
        function getRow(id){
            $.ajax({
                type: 'GET',
                url: '{{URL::to('buildingRow')}}',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    $('.sid').val(response.building_id);
                    $('#editName').val(response.name);
                    $('.catname').html(response.name);
                }
            });
        } 

        function getLRow(id){
            $.ajax({
                type: 'GET',
                url: '{{URL::to('schoolFullDayLocationRow')}}',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    console.log('clicked');
                    console.log(response);
                    $('.lid').val(response.full_day_location_id);
                    $('#edit_Name').val(response.name);
                    $('#editCohorts').val(response.cohorts);
                    var days = response.days;
                    days = JSON.parse(days);
                    for(var i = 0; i < days.length; i++)
                    {
                        if(days[i] == "Monday")
                        {
                            $('#editmonday').prop('checked', true);
                        }
                        else if(days[i] == "Tuesday")
                        {
                            $('#edittuesday').prop('checked', true);
                        }
                        else if(days[i] == "Wednesday")
                        {
                            $('#editwednesday').prop('checked', true);
                        }
                        else if(days[i] == "Thursday")
                        {
                            $('#editthursday').prop('checked', true);
                        }
                        else if(days[i] == "Friday")
                        {
                            $('#editfriday').prop('checked', true);
                        }
                    }
                    $('.catname').html(response.name);
                }
            });
        }
    </script>
@endsection
