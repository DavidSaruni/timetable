@extends('layouts.app', ['class' => 'g-sidenav-show bg-primary-100'])
@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Labtypes'])
    <div class="container-fluid py-4">
        <div class="card">
            <div class="pb-0 p-3">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="mb-0">Lab-Type Management</h5>
                    <button type="button" class="btn bg-gradient-primary btn-sm float-end mb-0" data-bs-toggle="modal" data-bs-target="#createLabtype">Create Lab-type</button>
                </div>
                <div class="table-responsive card-body p-0">
                    <table class="table table-striped align-items-center mb-0" id="dt-basic">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Labtype</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Labaratories</th>
                                <th class=""></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($labtypes as $labtype)
                                <tr>
                                    <td class="ps-4">
                                        <h6 class="mb-0 text-xs">{{$labtype->type}}</h6>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-xs font-weight-bold mb-0">{{$labtype->labs->count()}}</p>
                                    </td>
                                    <td>
                                        <a href="/labtypes/{{$labtype->labtype_id}}" class="btn btn-success btn-xs font-weight-bold text-xs mb-0" data-original-title="View Labtype">
                                            View
                                        </a>
                                        <a href="" class="btn btn-secondary btn-xs font-weight-bold text-xs mb-0 edit" data-id="{{$labtype->labtype_id}}">
                                            Edit
                                        </a>
                                        <a class="btn btn-primary btn-xs font-weight-bold text-xs mb-0 delete" data-id="{{$labtype->labtype_id}}">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">No labtypes found! <a href="" data-bs-toggle="modal" data-bs-target="#createLabtype">Create Labtype</a>
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
        <!-- Create Labtype Modal -->
            <div class="modal fade" id="createLabtype" tabindex="-1" role="dialog" aria-labelledby="createLabtypeTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-left">
                                    <h3 class="font-weight-bold text-primary text-gradient">New Lab Type</h3>
                                    <p class="mb-0">Enter type below</p>
                                </div>
                                <div class="card-body pb-3">
                                    <form role="form text-left" method="post" action="{{ route('labtype.store') }}">
                                        @csrf
                                        <label>Lab Type</label>
                                        <div class="input-group mb-3">
                                            <input name="type" required type="text" class="form-control" placeholder="Lab Type" aria-label="Name" aria-describedby="name-addon">
                                        </div> 
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-gradient-primary btn-lg btn-rounded w-100 mt-4 mb-0">Create Lab Type</button>
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
        <!-- End Create Labtype Modal -->
        <!-- Edit labtype Modal -->
            <div class="modal fade" id="editLabType" tabindex="-1" role="dialog" aria-labelledby="editLabType" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-left">
                                    <h3 class="font-weight-bolder text-primary text-gradient">Update Lab Type</h3>
                                    <p class="mb-0">Edit the information below to update the lab type</p>
                                </div>
                                <div class="card-body pb-3">
                                    <form role="form text-left" method="post" action="{{ route('labtype.update') }}" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" class="labtype_id" name="labtype_id">
                                        <label>Lab Type</label>
                                        <div class="input-group mb-3">
                                            <input name="type" required type="text" class="form-control" placeholder="Title" aria-label="Title" aria-describedby="title-addon" id="edit_type">
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
        <!-- End Edit labtype Modal -->
        <!-- Delete labtype Modal -->
            <div class="modal fade" id="deleteLabtype" tabindex="-1" role="dialog" aria-labelledby="deleteLabtypeTitle" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Deleting...</h4>
                            <span class="close" style="cursor: pointer" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa-solid fa-circle-xmark"></i>
                            </span>
                        </div>
                        <form class="form-horizontal" method="POST" action="/labtypeDelete">
                            @csrf
                            @method("DELETE")
                            <div class="modal-body">
                                <input type="hidden" class="sid" name="labtype_id">
                                <div class="text-center">
                                    <h2 class="bold catname"></h2>
                                    <p>
                                        Are you sure you want to delete this labtype?
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
        <!-- Delete labtype Modal -->
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
                $('#editLabType').modal('show');
                var id = $(this).data('id');
                getRow(id);
            });
    
            $(document).on('click', '.delete', function(e){
                e.preventDefault();
                $('#deleteLabtype').modal('show');
                var id = $(this).data('id');
                getRow(id);
            });    
        });
        function getRow(id){
            $.ajax({
                type: 'GET',
                url: '{{URL::to('labtypeRow')}}',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    $('.labtype_id').val(response.labtype_id);
                    $('#edit_type').val(response.type);
                    $('.catname').html(response.type);
                }
            });
        } 
    </script>
@endsection
