@extends('layouts.app', ['class' => 'g-sidenav-show bg-primary-100'])

@section('breadcrumb')
    <li class="breadcrumb-item text-sm text-white"><a class="opacity-5 text-white" href="{{ route('buildings') }}">Locations</a></li>
@endsection

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => $fullDayLocation->name])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-xl-6 col-sm-6 mb-xl-0 mb-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Capacity</p>
                                    <h5 class="font-weight-bolder">
                                        {{$fullDayLocation->cohorts}}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                    <i class="fa fa-users text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-sm-6 mb-xl-0 mb-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Schools</p>
                                    <h5 class="font-weight-bolder">
                                        {{$fullDayLocation->schools->count()}}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                    <i class="fa fa-school text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
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
                        @forelse($fullDayLocation->schools as $school)
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
                                    <form action="{{ route('schoolFullDayLocation.destroy') }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" name="school_id" value="{{ $school->school_id }}">
                                        <input type="hidden" name="full_day_location_id" value="{{ $fullDayLocation->full_day_location_id }}">
                                        <button class="btn btn-link btn-danger btn-rounded btn-xs icon-move-left my-auto">
                                            <i class="fa fa-ban" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @empty
                            <hr class="horizontal dark mt-0 mb-3">
                            <li class="list-group text-center">
                                <h6 class="mb-1 text-dark text-xs">No Schools Allocated</p>
                            </li>
                            <hr class="horizontal dark mt-0 mb-3">
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
        <!-- Add School Location Modal -->
            <div class="modal fade" id="addSchool" tabindex="-1" role="dialog" aria-labelledby="addSchoolTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-left">
                                    <h3 class="font-weight-bold text-primary text-gradient">Allocate Location To School</h3>
                                </div>
                                <div class="card-body pb-3">
                                    <form role="form text-left" method="post" action="{{ route('schoolFullDayLocation.store') }}">
                                        @csrf
                                        <input type="hidden" required name="full_day_location_id" value="{{ $fullDayLocation->full_day_location_id }}">
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
        <!-- Add School Location Modal -->
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.2/jquery.js" integrity="sha512-NMtENEqUQ8zHZWjwLg6/1FmcTWwRS2T5f487CCbQB3pQwouZfbrQfylryimT3XvQnpE7ctEKoZgQOAkWkCW/vg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
@endsection
