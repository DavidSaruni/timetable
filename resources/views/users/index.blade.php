@extends('layouts.app', ['class' => 'g-sidenav-show bg-primary-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Users'])
    <div class="container-fluid py-4">
        <div class="card">
            <div class="pb-0 p-3">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="mb-0">Users Management</h5>
                    <a href="{{ route('users') }}" class="btn bg-gradient-primary btn-sm float-end mb-0">Refresh</a>
                </div>
                <div class="px-4" id="alert">
                </div>
                <div class="table-responsive card-body p-0">
                    <table class="table table-striped align-items-center mb-0" id="dt-basic">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Role</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="{{asset('assets/img/tim.png')}}" class="avatar avatar-sm me-3">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-xs">{{$user->title}} {{$user->name}}</h6>
                                                <p class="text-xs text-secondary mb-0">{{$user->email}}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($user->isDean())
                                            <span class="text-xs font-weight-bold">Dean</span>
                                            <p class="text-xs text-secondary mb-0">{{$user->deanOf->name}}</p>
                                        @elseif($user->isHeadOfDepartment())
                                            <span class="text-xs font-weight-bold">HOD - {{$user->headOfDepartmentOf->school->name}}</span>
                                            <p class="text-xs text-secondary mb-0">{{$user->headOfDepartmentOf->name}}</p>
                                        @elseif($user->isLecturer())
                                            <span class="text-xs font-weight-bold">Lecturer</span>
                                            <p class="text-xs text-secondary mb-0">Kabarak University</p>
                                        @elseif($user->isAdmin())
                                            <span class="text-xs font-weight-bold">System Admin</span>
                                            <p class="text-xs text-secondary mb-0">Kabarak University</p>
                                        @elseif($user->isUser())
                                            <span class="text-xs font-weight-bold">User</span>
                                            <p class="text-xs text-secondary mb-0">Kabarak University</p>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ date('d/m/Y', strtotime($user->created_at)) }}</span>
                                    </td>
                                </tr>   
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">No users found</p>
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
    </div>
@endsection

