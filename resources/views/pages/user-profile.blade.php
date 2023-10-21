@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Your Profile'])
    <div class="card shadow-lg mx-4 card-profile-bottom">
        <div class="card-body p-3">
            <div class="row gx-4">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <img src="{{ $user->photo === null ? asset('assets/img/default.png') : url($user->photo) }}" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <p class="mb-0 font-weight-bold text-sm">
                            {{ $user->name }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="alert">
        @include('components.alert')
    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <form role="form" method="POST" action={{ route('profile.update') }} enctype="multipart/form-data">
                        @csrf
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Edit Profile</p>
                                <button type="submit" class="btn btn-primary btn-sm ms-auto">Save</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">User Information</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Name</label>
                                            <input  class="form-control" type="text" name="name" value="{{ old('name', $user->name) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Email address</label>
                                        <input class="form-control" type="email" name="email" value="{{ old('email', $user->email) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone" class="form-control-label">Phone</label>
                                        <input class="form-control" id="phone" type="text" name="lastname" value="{{ old('phone', $user->phone) }}">
                                    </div>
                                </div>
                            </div>
                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm">Contact Information</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Address</label>
                                        <input class="form-control" type="text" name="address"
                                            value="{{ old('address', $user->address) }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="subdistrict_id" class="h6">Kecamatan</label>
                                            <select required name="subdistrict_id" class="form-control"
                                                id="subdistrict_id">
                                                <option value="Kecamatan" disabled selected>Pilih Kecamatan</option>
                                                @foreach ($subdistricts as $subdistrict)
                                                <option value="{{ $subdistrict->id }}" {{ $user->subdistrict_id === $subdistrict->id ? 'selected': '' }}>
                                                    {{ $subdistrict->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                </div>
                            </div>
                            <hr class="horizontal dark">
                            @docter
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Your Docter Description</label>
                                        <textarea class="form-control"name="" id="" cols="30" rows="10">{{ $user->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                            @endDocter
                        </div>
                    </form>
                </div>
            </div>
            @docter
            <div class="col-md-4">

            </div>
            @endDocter
        @include('layouts.footers.auth.footer')
    </div>
@endsection
