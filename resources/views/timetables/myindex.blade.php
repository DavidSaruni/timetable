@extends('layouts.app', ['class' => 'g-sidenav-show bg-primary-100'])
@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'My Timetables'])
    <div class="container-fluid py-4">
        <div class="card">
            <div class="pb-0 p-3">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="mb-0">Timetable Instances</h5>
                    @if (auth()->user()->role == 'ADMIN')
                        @if($schools->count() > 0)
                            <button type="button" class="btn bg-gradient-primary btn-sm float-end mb-0" data-bs-toggle="modal" data-bs-target="#createTimetable">Generate New Timetable</button>
                        @else
                            <button disabled class="btn bg-gradient-primary btn-sm float-end mb-0" href="">Generate New Timetable</button disabled>
                        @endif
                    @endif
                </div>
                <div class="px-4" id="alert">
                </div>
                <div class="table-responsive card-body p-0">
                    <table class="table table-striped align-items-center mb-0" id="dt-basic">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Generated</th>
                                <th class="text-center align-middle">
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($instances as $instance)
                                @if($instance->myTimetable(auth()->user()->user_id) != null)
                                    @if($instance->status == 'Done')
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <img src="{{asset('assets/img/logo.png')}}" class="avatar avatar-sm me-3">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-xs">{{$instance->name}}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{$instance->created_at}}</p>
                                                <p class="text-xs font-weight-bold mb-0">{{ $instance->created_at->diffForHumans() }}</p>
                                            </td>
                                            <td class="align-middle">
                                                <form method="POST" action="{{ route('individualPDF') }}">
                                                    @csrf
                                                    <input type="hidden" name="lecturer_id" value="{{ auth()->user()->user_id }}">
                                                    <input type="hidden" name="table" value="{{ $instance->table_prefix }}">
                                                    <input type="hidden" name="instance_name" value="{{ $instance->name }}">
                                                    <input type="hidden" name="gen" value="{{ $instance->created_at }}">
                                                    <input type="hidden" name="instance_id" value="{{ $instance->timetable_instance_id }}">                                            
                                                    <button type="submit" class="btn btn-success btn-xs font-weight-bold text-xs mb-0">
                                                        <i class="fa fa-print"></i> Print Timetable
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @else
                                        @continue
                                    @endif
                                @else
                                    @continue
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer px-3 border-0 d-flex align-items-center justify-content-between">
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
        
        <!-- Create Timetable Modal -->
            <div class="modal fade" id="createTimetable" tabindex="-1" role="dialog" aria-labelledby="createTimetableTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-left">
                                    <h3 class="font-weight-bolder text-primary text-gradient">Create Timetable</h3>
                                    <p class="mb-0">Enter Timetable details below</p>
                                </div>
                                <div class="card-body pb-3">
                                    <form role="form text-left" method="post" action="{{ route('timetable.store') }}">
                                        @csrf
                                        <label>Timetable Name</label>
                                        <div class="input-group mb-3">
                                            <input name="name" required type="text" class="form-control" placeholder="Name" aria-label="Name" aria-describedby="name-addon">
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-gradient-primary btn-lg btn-rounded w-100 mt-4 mb-0">Generate</button>
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
        <!-- End Create Timetable Modal -->
        <!-- Delete Timetable Modal -->
            <div class="modal fade" id="deleteTimetable" tabindex="-1" role="dialog" aria-labelledby="deleteTimetableTitle" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Deleting...</h4>
                            <span class="close" style="cursor: pointer" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa-solid fa-circle-xmark"></i>
                            </span>
                        </div>
                        <form class="form-horizontal" method="POST" action="/TimetableDelete">
                            @csrf
                            @method("DELETE")
                            <div class="modal-body">
                                <input type="hidden" class="sid" name="timetable_instance_id">
                                <div class="text-center">
                                    <h2 class="bold catname"></h2>
                                    <p>
                                        Are you sure you want to delete this Timetable?
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
        <!-- Delete Timetable Modal -->
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.2/jquery.js" integrity="sha512-NMtENEqUQ8zHZWjwLg6/1FmcTWwRS2T5f487CCbQB3pQwouZfbrQfylryimT3XvQnpE7ctEKoZgQOAkWkCW/vg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
        setTimeout(function() {
            window.location.reload();
        }, 60000);
        $(function(){
            $(document).on('click', '.edit', function(e){
                e.preventDefault();
                $('#edit').modal('show');
                var id = $(this).data('id');
                getRow(id);
            });
    
            $(document).on('click', '.delete', function(e){
                e.preventDefault();
                $('#deleteTimetable').modal('show');
                var id = $(this).data('id');
                getRow(id);
            });    
        });
        function getRow(id){
            $.ajax({
                type: 'GET',
                url: '{{URL::to('timetableRow')}}',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    $('.sid').val(response.timetable_instance_id);
                    $('#edit_type').val(response.name);
                    $('#edit_description').val(response.name);
                    $('.catname').html(response.name);
                }
            });
        }
    </script>
@endsection
