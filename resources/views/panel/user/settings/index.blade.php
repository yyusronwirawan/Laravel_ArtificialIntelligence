@extends('panel.layout.app')
@section('title', 'My Account')

@section('content')
    <div class="page-header">
        <div class="container-xl">
            <div class="row g-2 items-center">
                <div class="col">
					<a href="{{ LaravelLocalization::localizeUrl(route('dashboard.index')) }}" class="page-pretitle flex items-center">
						<svg class="!me-2 rtl:-scale-x-100" width="8" height="10" viewBox="0 0 6 10" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							<path d="M4.45536 9.45539C4.52679 9.45539 4.60714 9.41968 4.66071 9.36611L5.10714 8.91968C5.16071 8.86611 5.19643 8.78575 5.19643 8.71432C5.19643 8.64289 5.16071 8.56254 5.10714 8.50896L1.59821 5.00004L5.10714 1.49111C5.16071 1.43753 5.19643 1.35718 5.19643 1.28575C5.19643 1.20539 5.16071 1.13396 5.10714 1.08039L4.66071 0.633963C4.60714 0.580392 4.52679 0.544678 4.45536 0.544678C4.38393 0.544678 4.30357 0.580392 4.25 0.633963L0.0892856 4.79468C0.0357141 4.84825 0 4.92861 0 5.00004C0 5.07146 0.0357141 5.15182 0.0892856 5.20539L4.25 9.36611C4.30357 9.41968 4.38393 9.45539 4.45536 9.45539Z"/>
						</svg>
						{{__('Back to dashboard')}}
					</a>
                    <h2 class="page-title mb-2">
                        {{__('Hello')}} {{$user->fullName()}}.
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body pt-6">
        <div class="container-xl">
			<div class="row">
				<div class="col-md-5 mx-auto">
					<form id="user_edit_form" onsubmit="return userProfileSave();" action="" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-12 col-xl-12">

								<div class="row">
									<div class="col-12">
										<div class="mb-[20px]">
											<label class="form-label">{{__('Avatar')}}</label>
											<input type="file" class="form-control" id="avatar" name="avatar">
										</div>
									</div>

									<div class="col-12">
										<div class="mb-[20px]">
											<label class="form-label">{{__('Name')}}</label>
											<input type="text" class="form-control" id="name" name="name" value="{{$user->name}}">
										</div>
									</div>
									<div class="col-12">
										<div class="mb-[20px]">
											<label class="form-label">{{__('Surname')}}</label>
											<input type="text" class="form-control" id="surname" name="surname" value="{{$user->surname}}">
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-12">
										<div class="mb-[20px]">
											<label class="form-label">{{__('Phone')}}</label>
											<input type="text" name="phone" id="phone" class="form-control" data-mask="+000000000000" data-mask-visible="true" placeholder="+000000000000" autocomplete="off" value="{{$user->phone}}"/>
										</div>
									</div>
									<div class="col-12">
										<div class="mb-[20px]">
											<label class="form-label">{{__('Email')}}</label>
											<input type="email" class="form-control" value="{{$user->email}}" disabled>
										</div>
									</div>
								</div>
								<div class="mb-[20px]">
									<label class="form-label">{{__('Country')}}</label>
									<select type="text" class="form-select" name="country" id="country">
										@include('panel.admin.users.countries')
									</select>
								</div>

                                <div class="row">
                                    <h4>Change Password</h4>
                                    <div class="bg-blue-100 text-blue-600 rounded-xl !p-3 !mt-2 dark:bg-blue-600/20 dark:text-blue-200 mb-3">
                                        <svg class="inline !me-1" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path> <path d="M12 9h.01"></path> <path d="M11 12h1v4h1"></path> </svg>
                                        {{__('Please leave empty if you don’t want to change your password.')}}
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-[20px]">
                                            <label class="form-label">{{__('Old Password')}}</label>
                                            <input type="password" name="old_password" id="old_password" class="form-control"autocomplete="off"/>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-[20px]">
                                            <label class="form-label">{{__('New Password')}}</label>
                                            <input type="password" name="new_password" id="new_password" class="form-control"autocomplete="off"/>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-[20px]">
                                            <label class="form-label">{{__('Confirm Your New Password')}}</label>
                                            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" autocomplete="off"/>
                                        </div>
                                    </div>
                                </div>

                                @if(env('APP_STATUS') == 'Demo' and Auth::user()->type == 'admin')
                                    <a onclick="return toastr.info('Admin settings disabled on Demo version.')" class="btn btn-primary w-100">
                                        {{__('Save')}}
                                    </a>
                                @else
                                    <button form="user_edit_form" id="user_edit_button" class="btn btn-primary w-100">
                                        {{__('Save')}}
                                    </button>
                                @endif


							</div>
						</div>
					</form>
				</div>
			</div>
        </div>
    </div>
@endsection

@section('script')
    <script src="/assets/js/panel/user.js"></script>
@endsection
