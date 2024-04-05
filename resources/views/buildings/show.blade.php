@extends('layouts.app', ['class' => 'g-sidenav-show bg-primary-100'])

@section('breadcrumb')
    <li class="breadcrumb-item text-sm text-white"><a class="opacity-5 text-white" href="{{ route('buildings') }}">Buildings</a></li>
@endsection

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => $building->name])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Laboratories</p>
                                    <h5 class="font-weight-bolder">
                                        {{$building->labs->count()}}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                    <i class="ni ni-atom text-lg opacity-10" aria-hidden="true"></i>
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
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Lecture Rooms</p>
                                    <h5 class="font-weight-bolder">
                                        {{$building->lectureRooms->count()}}
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
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Schools</p>
                                    <h5 class="font-weight-bolder">
                                        {{$building->schools->count()}}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                    <i class="fa fa-school text-lg opacity-10" aria-hidden="true"></i>
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
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Sessions</p>
                                    <h5 class="font-weight-bolder">
                                        103
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                    <i class="fa fa-hourglass-half text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-7 mb-lg-0 mb-4 d-flex align-items-center">
                <div class="col-12">
                    <div class="card p-2 mb-4">
                        <div class="card-header d-flex justify-content-between">
                            <h6 class="mb-2">Laboratories</h6>
                            <a href="javascript:;" class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#addLab">Add Lab</a>
                        </div>
                        <div class="table-responsive card-body p-0">
                            <table class="table table-striped align-items-center mb-0"  id="dt-basic5">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Lab</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Type</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Capacity</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($labs as $lab)
                                        <tr>
                                            <td class="w-30">
                                                <p class="text-sm px-3 font-weight-bold mb-0">{{$lab->lab_name}}</p>
                                            </td>
                                            <td class="align-middle text-xs">
                                                <p class="text-xs font-weight-bold mb-0">{{$lab->labtype->type}}</p>
                                            </td>
                                            <td class="align-middle text-xs">
                                                <p class="text-xs font-weight-bold mb-0">{{$lab->lab_capacity}}</p>
                                            </td>
                                            <td class="align-middle text-sm">
                                                <a href="javascript:;" class="btn btn-secondary font-weight-bold btn-xs edit" data-id="1">
                                                    <i class="fas fa-edit" aria-hidden="true"></i>
                                                </a>
                                                <a href="javascript:;" class="btn btn-primary font-weight-bold btn-xs delete" data-id="1">
                                                    <i class="fas fa-trash" aria-hidden="true"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">No labs found! <a href="" data-bs-toggle="modal" data-bs-target="#addLab">Add Lab</a>
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
            <div class="col-md-5 mb-lg-0 mb-4 d-flex align-items-center">
                <div class="col-12">
                    <div class="card p-2">
                        <div class="card-header pb-0">
                            <div class="d-flex justify-content-between">
                                <h6 class="mb-2">Lecture Rooms</h6>
                                <a href="javascript:;" class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#addLectureRoom">Add Room</a>
                            </div>
                        </div>
                        <div class="table-responsive card-body p-0">
                            <table class="table table-striped align-items-center mb-0"  id="dt-basic51">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Room</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Capacity</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($lectureRooms as $lectureRoom)
                                        <tr>
                                            <td class="">
                                                <p class="text-sm px-3 font-weight-bold mb-0">{{$lectureRoom->lecture_room_name}}</p>
                                            </td>
                                            <td class="align-middle text-sm">
                                                <p class="text-sm px-3 font-weight-bold mb-0">{{$lectureRoom->lecture_room_capacity}}</p>
                                            </td>
                                            <td class="align-middle text-sm w-20">
                                                <a href="javascript:;" class="btn btn-secondary font-weight-bold btn-xs edit" data-id="1">
                                                    <i class="fas fa-edit" aria-hidden="true"></i>
                                                </a>
                                                <a href="javascript:;" class="btn btn-primary font-weight-bold btn-xs delete" data-id="1">
                                                    <i class="fas fa-trash" aria-hidden="true"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">No lecture rooms found! <a href="" data-bs-toggle="modal" data-bs-target="#addLectureRoom">Add Room</a>
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
        </div>
        <div class="mt-4">
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-0">Schools</h6>
                        @if($schools->count() > 0)
                            <a href="javascript:;" class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#addSchool">Add School</a>
                        @endif
                    </div>
                </div>
                <div class="card-body p-3">
                    <ul class="list-group">
                        @forelse($building->schools as $school)
                            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex align-items-center">
                                    <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                        <i class="ni ni-building text-white opacity-10"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-1 text-dark text-sm">{{$school->slug}}</h6>
                                        <span class="text-xs">{{$school->name}}</span>
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

                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
        <!-- Add Lab Modal -->
            <div class="modal fade" id="addLab" tabindex="-1" role="dialog" aria-labelledby="addLabTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-left">
                                    <h3 class="font-weight-bold text-primary text-gradient">Add Lab</h3>
                                </div>
                                <div class="card-body pb-3">
                                    <form role="form text-left" method="post" action="{{ route('lab.store') }}">
                                        @csrf
                                        <input type="hidden" required name="building_id" value="{{ $building->building_id }}">
                                        <label>Lab Name</label>
                                        <div class="input-group mb-3">
                                            <input name="name" required type="text" class="form-control" placeholder="Name" aria-label="Name" aria-describedby="name-addon">
                                        </div>  
                                        <label>Lab Type</label>
                                        <div class="input-group mb-3">
                                            <select name="lab_type" required class="form-control" idaria-label="LabType" aria-describedby="labtype-addon">
                                                <option selected>Select Lab Type</option>
                                                @foreach($labtypes as $labtype)
                                                    <option value="{{ $labtype->labtype_id }}">{{ $labtype->type }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label>Capacity</label>
                                        <div class="input-group mb-3">
                                            <input name="lab_capacity" required type="number" class="form-control" placeholder="Capacity" aria-label="Capacity" aria-describedby="capacity-addon" min="1" step="1">
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
        <!-- Add Lab Modal -->
        <!-- Add Lecture Room Modal -->
            <div class="modal fade" id="addLectureRoom" tabindex="-1" role="dialog" aria-labelledby="addLectureRoomTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-left">
                                    <h3 class="font-weight-bold text-primary text-gradient">Add Lecture Room</h3>
                                </div>
                                <div class="card-body pb-3">
                                    <form role="form text-left" method="post" action="{{ route('lectureroom.store') }}">
                                        @csrf
                                        <input type="hidden" required name="building_id" value="{{ $building->building_id }}">
                                        <label>Room Name</label>
                                        <div class="input-group mb-3">
                                            <input name="lecture_room_name" required type="text" class="form-control" placeholder="Room Name e.g 'L5'" aria-label="Name" aria-describedby="name-addon">
                                        </div>  
                                        <label>Capacity</label>
                                        <div class="input-group mb-3">
                                            <input name="lecture_room_capacity" required type="number" class="form-control" placeholder="Capacity" aria-label="Capacity" aria-describedby="capacity-addon" min="1" step="1">
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
        <!-- Add Lecture Room Modal -->
        <!-- Add School Building Modal -->
            <div class="modal fade" id="addSchool" tabindex="-1" role="dialog" aria-labelledby="addSchoolTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-left">
                                    <h3 class="font-weight-bold text-primary text-gradient">Allocate To School</h3>
                                </div>
                                <div class="card-body pb-3">
                                    <form role="form text-left" method="post" action="{{ route('schoolbuilding.store') }}">
                                        @csrf
                                        <input type="hidden" required name="building_id" value="{{ $building->building_id }}">
                                        <label>School</label>
                                        <div class="input-group mb-3">
                                            <select name="school_id" required class="form-control" idaria-label="LabType" aria-describedby="school_id-addon">
                                                <option selected>Select School</option>
                                                @foreach($schools as $school)
                                                    <option value="{{ $school->school_id }}">{{ $school->name }}</option>
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
                $('#deleteBuilding').modal('show');
                var id = $(this).data('id');
                getRow(id);
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
                    $('#edit_type').val(response.slug);
                    $('#edit_description').val(response.name);
                    $('.catname').html(response.name);
                }
            });
        } 
    </script>
@endsection
