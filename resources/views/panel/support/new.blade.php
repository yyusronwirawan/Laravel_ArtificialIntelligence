@extends('panel.layout.app')
@section('title', 'New Support Request')
@section('content')
    <div class="page-header">
        <div class="container-xl">
            <div class="row g-2 items-center">
                <div class="col">
					<div class="page-pretitle">
						{{__('Generate new support request. We will answer as soon as possible.')}}
					</div>
					<h2 class="page-title mb-2">
						{{__('Create New Support Request')}}
					</h2>
                </div>

            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body pt-6">
        <div class="container-xl">
			<div class="row">
				<div class="col-md-6 mx-auto">
					<form id="support_form" onsubmit="return sendSupportForm();" action="">

							<div class="row">
								<div class="col-md-6">
									<div class="mb-3">
										<div class="form-label">{{__('Support Category')}}</div>
										<select class="form-select" id="category" name="category" required>
											<option value="General Inquiry" selected>{{__('General Inquiry')}}</option>
											<option value="Technical Issue">{{__('Technical Issue')}}</option>
											<option value="Improvement Idea">{{__('Improvement Idea')}}</option>
											<option value="Feedback">{{__('Feedback')}}</option>
											<option value="Other">{{__('Other')}}</option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<div class="form-label">{{__('Support Priority')}}</div>
										<select class="form-select" id="priority" name="priority" required>
											<option value="Low" selected>{{__('Low')}}</option>
											<option value="Normal">{{__('Normal')}}</option>
											<option value="High">{{__('High')}}</option>
											<option value="Critical">{{__('Critical')}}</option>
										</select>
									</div>
								</div>

								<div class="col-md-12">
									<div class="mb-3">
										<label class="form-label">{{__('Subject')}}</label>
										<input type="text" class="form-control" id="subject" name="subject"  placeholder="{{__('Please enter subject of the support request')}}" required>
									</div>
								</div>

								<div class="col-md-12">
									<div class="mb-3">
										<label class="form-label">{{__('Message')}}</label>
										<textarea class="form-control" name="message" id="message" cols="30" rows="5"  placeholder="{{__('Please enter your message')}}" required></textarea>
									</div>
								</div>
							</div>

						<button form="support_form" id="support_button" class="btn btn-primary w-100 py-[0.75em]">
							{{__('Send')}}
						</button>
					</form>
				</div>
			</div>
        </div>
    </div>
@endsection
@section('script')
    <script src="/assets/js/panel/support.js"></script>
@endsection
