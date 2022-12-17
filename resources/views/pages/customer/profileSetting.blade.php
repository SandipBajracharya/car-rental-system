@extends('layouts.mainLayout')

@section('page-specific-css')
    <link rel="stylesheet" href="{{asset('dropify/css/dropify.css')}}">
@endsection

@section('main-content')
    @php
        // dd($inputs);
        $breadcrumb_arr = ['Home' => '/', 'Profile Setting' => '/c/profile-setting'];
    @endphp
    @include('include.main.innerHeader', ['breadcrumb_arr' => $breadcrumb_arr])

    {{-- password dialog  --}}
    <div class="modal fade modal-confirmation" id="passwordChangeModal" tabindex="-1" aria-labelledby="passwordChangeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Change your password</h1>
                    <button type="button" class="btn btn-red btn-sm" type="button" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ic-close"></i>
                    </button>
                </div>
                <div class="modal-body p-24 pt-8">
                    <form action="{{route('password.change')}}" method="POST">
                        @csrf
                        <div class="mb-16">
                            <label class="form-label">Old Password</label>
                            <input class="form-control form-control-lg @error('old_password') is-invalid @enderror" type="password" name="old_password" placeholder="" />
                            
                            @error('old_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-16">
                            <label class="form-label">New Password</label>
                            <input class="form-control form-control-lg @error('password') is-invalid @enderror" type="password" name="password" placeholder="" />
                            
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-16">
                            <label class="form-label">Confirm New Password</label>
                            <input class="form-control form-control-lg" type="password" name="password_confirmation" placeholder="" />
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <section class="settings py-md-88 py-64 bg-gray50">
        <div class="container">
            <div class="row gap-24-row">
                <div class="col-xl-3 col-lg-4">
                    <div class="sticker">
                        <h4 class="mb-24">Settings</h4>
                        <div class="sidebar-sticky gap-16-vertical d-none d-lg-flex"><a class="side-nav-link p active"
                                href="#link-1" aria-selected="true">Personal Information<i
                                    class="ic-chevron-right"></i></a><a class="side-nav-link p" href="#link-2"
                                aria-selected="false">Account Information</a><a class="side-nav-link p" href="#link-3"
                                aria-selected="false">Privacy & data</a></div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8">
                    <form action="{{route('userProfile.update')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <h5 class="mb-32" id="link-1">Personal Information</h5>
                        <small class="mb-12">Photo</small>
                        <div class="align-center mb-32">
                            @if (!empty($user->social_id))
                                @if (!empty($user->image))
                                   <img class="avatar-initial-xxxl mr-32" src="{{$user->image}}" alt="profile pic">
                                @else
                                    <div class="avatar-initial-xxxl mr-32">{{$user->initials}}</div>
                                @endif
                            @else
                                @if (!empty($user->image))
                                    <img class="avatar-initial-xxxl mr-32" src="/images/profilePictures/{{$user->image}}" alt="profile pic">
                                @else
                                    <div class="avatar-initial-xxxl mr-32">{{$user->initials}}</div>
                                @endif
                            @endif
                            <div>
                                @if (empty($user->social_id))
                                    {{-- <label type="button" class="btn btn-gray" for="dp-btn">Change Photo</label> --}}
                                    <input id="dp-btn" type="file" name="image">
                                @endif
                            </div>
                        </div>
                        <small class="mb-12">Gender</small>
                        <div class="align-center gap-32 mb-32">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="male" name="gender" value="m" {{!empty($user->gender) && $user->gender == 'm'? 'checked' : ''}} />
                                <label class="form-check-label" for="male">Male</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="female" name="gender" value="f" {{!empty($user->gender) && $user->gender == 'f'? 'checked' : ''}} />
                                <label class="form-check-label" for="female">Female</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="other" name="gender" value="o" {{!empty($user->gender) && $user->gender == 'o'? 'checked' : ''}} />
                                <label class="form-check-label" for="other">Other</label>
                            </div>
                        </div>
                        <small>FullName </small>
                        <input class="form-control form-control-lg mb-32" name="name" placeholder="" value="{{$user->first_name . ' '. $user->last_name}}" />
                        <small>Date of Birth </small>
                        <input class="form-control form-control-lg mb-48" name="dob" placeholder="" value="{{isset($user->profile->dob)? $user->profile->dob : ''}}" type="date"/>
                        
                        <h5 class="mb-32" id="link-2">Account Information</h5>
                        <small>Email Address </small>
                        <input class="form-control form-control-lg mb-32" placeholder="" value="{{$user->email}}" disabled="disabled" />
                        <div class="align-end gap-32 mb-48">
                            <div>
                                <small>Password</small>
                                <input class="form-control" type="password" value="*************" disabled="disabled">
                            </div>
                            <button type="button" class="btn btn-gray" id="pw-change" data-bs-target="#passwordChangeModal" data-bs-toggle="modal">Change</button>
                        </div>
                        <h5 class="mb-32" id="link-3">Privacy & Data</h5>
                        <div class="row align-center gap-24-row mb-32">
                            <div class="col-lg-4 col-md-5">
                                <small>Document Type</small>
                                <select class="form-control form-control-lg mb-32" name="document_type" id="document_type">
                                    <option value="" {{!isset($user)? 'selected' :''}}>Select document type</option>
                                    {{-- <option value="Citizenship" {{isset($user) && isset($user->profile->document_type) && $user->profile->document_type == 'Citizenship'? 'selected' : ''}}>Citizenship</option> --}}
                                    <option value="Driving license" {{isset($user) && isset($user->profile->document_type) && $user->profile->document_type == 'Driving license'? 'selected' : ''}}>Driving license</option>
                                    {{-- <option value="Voters card" {{isset($user) && isset($user->profile->document_type) && $user->profile->document_type == 'Voters card'? 'selected' : ''}}>Voters card</option> --}}
                                </select>
                                <small>Document number</small>
                                <input class="form-control form-control-lg mb-32" name="document_number" type="text" placeholder="Enter your document number" value="{{isset($user) && isset($user->profile->document_number)? $user->profile->document_number : ''}}">
                                <div class="mb-8">
                                    <small class="mb-12">Document Image</small>
                                    <input class="dropify" name="document_image" type="file" data-default-file="{{isset($user) && isset($user->profile->document_image)? '/images/userDocument/'.$user->profile->document_image : ''}}">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('page-specific-script')
    <script src="{{asset('dropify/js/dropify.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('.dropify').dropify();
        });
    </script>

    @if (count($errors) > 0)
        <script>
            $("#pw-change").click();
        </script>
    @endif
@endsection