@extends('vendor.installer.layouts.master')

@section('template_title')
    {{ trans('installer_messages.environment.wizard.templateTitle') }}
@endsection

@section('title')
    <i class="fa fa-magic fa-fw" aria-hidden="true"></i>
    {!! trans('installer_messages.environment.wizard.title') !!}
@endsection

@section('container')
	<h4 class="mt-0 mb-5 text-[26px] font-golos">{{__('Setup')}}</h4>

    <div class="tabs tabs-full">

        <input class="peer/tab1 absolute w-0 h-0 invisible" id="tab1" type="radio" name="tabs" class="tab-input" checked />
        <label for="tab1" class="inline-flex px-3 py-1 mx-3 font-medium cursor-pointer rounded-md transition-colors peer-checked/tab1:bg-black peer-checked/tab1:bg-opacity-5">
            {{ trans('installer_messages.environment.wizard.tabs.environment') }}
        </label>

        <input class="peer/tab2 absolute w-0 h-0 invisible" id="tab2" type="radio" name="tabs" class="tab-input" />
        <label for="tab2" class="inline-flex px-3 py-1 mx-3 font-medium cursor-pointer rounded-md transition-colors peer-checked/tab2:bg-black peer-checked/tab2:bg-opacity-5">
            {{ trans('installer_messages.environment.wizard.tabs.database') }}
        </label>


		<hr class="w-auto -mx-10 mt-6 mb-10 opacity-50">

        <form
		class="
		text-start text-[15px]
		[&_label]:block [&_label]:opacity-70 [&_label]:mt-6 [&_label]:mb-1 [&_label]:text-[14px] [&_label]:font-medium
		[&_input:not([type=radio])]:block [&_input:not([type=radio])]:w-full [&_input:not([type=radio])]:h-10 [&_input:not([type=radio])]:px-4 [&_input:not([type=radio])]:rounded-xl [&_input:not([type=radio])]:border [&_input:not([type=radio])]:border-solid [&_input:not([type=radio])]:bg-transparent
		[&_select]:block [&_select]:w-full [&_select]:h-10 [&_select]:px-4 [&_select]:rounded-xl [&_select]:border [&_select]:border-solid [&_select]:bg-transparent
		peer-checked/tab1:[&_#tab1content]:block
		peer-checked/tab2:[&_#tab2content]:block
		peer-checked/tab3:[&_#tab3content]:block"
		method="post"
		action="{{ route('LaravelInstaller::environmentSaveWizard') }}">
            <div class="hidden" id="tab1content">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group {{ $errors->has('app_name') ? ' has-error ' : '' }}">
                    <label for="app_name">
                        {{ trans('installer_messages.environment.wizard.form.app_name_label') }}
                    </label>
                    <input type="text" name="app_name" id="app_name" value="" placeholder="{{ trans('installer_messages.environment.wizard.form.app_name_placeholder') }}" />
                    @if ($errors->has('app_name'))
                        <span class="block px-2 py-1 rounded-md mt-1 bg-red-100 text-red-600 text-sm">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('app_name') }}
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('app_url') ? ' has-error ' : '' }}">
                    <label for="app_url">
                        {{ trans('installer_messages.environment.wizard.form.app_url_label') }}
                    </label>

                    <input type="url" name="app_url" id="app_url" value="{{url('/')}}" placeholder="{{ trans('installer_messages.environment.wizard.form.app_url_placeholder') }}" />
                    @if ($errors->has('app_url'))
                        <span class="block px-2 py-1 rounded-md mt-1 bg-red-100 text-red-600 text-sm">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('app_url') }}
                        </span>
                    @endif
                    <p class="p-2 rounded-lg bg-orange-100 text-orange-500 text-sm mt-2">
                        {{__('Please do not enter / at the end of the url. For Example; https://liquid-themes.com')}}
                    </p>
                </div>

				<details class="mt-9 mb-32 open:mb-4">
					<summary class="list-none flex items-center gap-4 cursor-pointer text-[15px]">
						<span class="inline-flex grow items-center">
							<span class="inline-block w-full h-px bg-black bg-opacity-5"></span>
						</span>
						<span class="inline-flex items-center gap-1 font-medium">
							Advanced Options
							<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path d="M6 9l6 6l6 -6"></path> </svg>
						</span>
						<span class="inline-flex grow items-center">
							<span class="inline-block w-full h-px bg-black bg-opacity-5"></span>
						</span>
					</summary>
					<div class="form-group {{ $errors->has('environment') ? ' has-error ' : '' }}">
						<label for="environment">
							{{ trans('installer_messages.environment.wizard.form.app_environment_label') }}
						</label>
						<select name="environment" id="environment" onchange='checkEnvironment(this.value);'>
							<option value="production" selected>{{ trans('installer_messages.environment.wizard.form.app_environment_label_production') }}</option>
							<option value="local">{{ trans('installer_messages.environment.wizard.form.app_environment_label_local') }}</option>
							<option value="development">{{ trans('installer_messages.environment.wizard.form.app_environment_label_developement') }}</option>
							<option value="qa">{{ trans('installer_messages.environment.wizard.form.app_environment_label_qa') }}</option>
							<option value="other">{{ trans('installer_messages.environment.wizard.form.app_environment_label_other') }}</option>
						</select>
						<div id="environment_text_input" class="mt-2" style="display: none;">
							<input type="text" name="environment_custom" id="environment_custom" placeholder="{{ trans('installer_messages.environment.wizard.form.app_environment_placeholder_other') }}"/>
						</div>
						@if ($errors->has('environment'))
							<span class="block px-2 py-1 rounded-md mt-1 bg-red-100 text-red-600 text-sm">
								<i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
								{{ $errors->first('environment') }}
							</span>
						@endif
					</div>

					<div class="form-group {{ $errors->has('app_debug') ? ' has-error ' : '' }}">
						<label class="!mb-2" for="app_debug">
							{{ trans('installer_messages.environment.wizard.form.app_debug_label') }}
						</label>
						<div class="flex items-center gap-3">
							<label class="!mt-0" for="app_debug_true">
								<input type="radio" name="app_debug" id="app_debug_true" value=true />
								{{ trans('installer_messages.environment.wizard.form.app_debug_label_true') }}
							</label>
							<label class="!mt-0" for="app_debug_false">
								<input type="radio" name="app_debug" id="app_debug_false" value=false checked />
								{{ trans('installer_messages.environment.wizard.form.app_debug_label_false') }}
							</label>
						</div>
						@if ($errors->has('app_debug'))
							<span class="block px-2 py-1 rounded-md mt-1 bg-red-100 text-red-600 text-sm">
								<i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
								{{ $errors->first('app_debug') }}
							</span>
						@endif
					</div>

					<div class="form-group {{ $errors->has('app_log_level') ? ' has-error ' : '' }}">
						<label for="app_log_level">
							{{ trans('installer_messages.environment.wizard.form.app_log_level_label') }}
						</label>
						<select name="app_log_level" id="app_log_level">
							<option value="debug" selected>{{ trans('installer_messages.environment.wizard.form.app_log_level_label_debug') }}</option>
							<option value="info">{{ trans('installer_messages.environment.wizard.form.app_log_level_label_info') }}</option>
							<option value="notice">{{ trans('installer_messages.environment.wizard.form.app_log_level_label_notice') }}</option>
							<option value="warning">{{ trans('installer_messages.environment.wizard.form.app_log_level_label_warning') }}</option>
							<option value="error">{{ trans('installer_messages.environment.wizard.form.app_log_level_label_error') }}</option>
							<option value="critical">{{ trans('installer_messages.environment.wizard.form.app_log_level_label_critical') }}</option>
							<option value="alert">{{ trans('installer_messages.environment.wizard.form.app_log_level_label_alert') }}</option>
							<option value="emergency">{{ trans('installer_messages.environment.wizard.form.app_log_level_label_emergency') }}</option>
						</select>
						@if ($errors->has('app_log_level'))
							<span class="block px-2 py-1 rounded-md mt-1 bg-red-100 text-red-600 text-sm">
								<i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
								{{ $errors->first('app_log_level') }}
							</span>
						@endif
					</div>
				</details>

                <div class="mt-6 text-center">
                    <button class="flex w-full items-center justify-center p-2 gap-2 rounded-xl shadow-[0_4px_10px_rgba(0,0,0,0.05)] transition-all duration-300 font-medium hover:bg-black hover:text-white hover:scale-105" onclick="showDatabaseSettings();return false">
                        {{ trans('installer_messages.environment.wizard.form.buttons.setup_database') }}
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path d="M9 6l6 6l-6 6"></path> </svg>
                    </button>
                </div>
            </div>
            <div class="hidden" id="tab2content">

                <div class="form-group {{ $errors->has('database_connection') ? ' has-error ' : '' }}">
                    <label for="database_connection">
                        {{ trans('installer_messages.environment.wizard.form.db_connection_label') }}
                    </label>
                    <select name="database_connection" id="database_connection">
                        <option value="mysql" selected>{{ trans('installer_messages.environment.wizard.form.db_connection_label_mysql') }}</option>
                        <option value="sqlite">{{ trans('installer_messages.environment.wizard.form.db_connection_label_sqlite') }}</option>
                        <option value="pgsql">{{ trans('installer_messages.environment.wizard.form.db_connection_label_pgsql') }}</option>
                        <option value="sqlsrv">{{ trans('installer_messages.environment.wizard.form.db_connection_label_sqlsrv') }}</option>
                    </select>
                    @if ($errors->has('database_connection'))
                        <span class="block px-2 py-1 rounded-md mt-1 bg-red-100 text-red-600 text-sm">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('database_connection') }}
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('database_hostname') ? ' has-error ' : '' }}">
                    <label for="database_hostname">
                        {{ trans('installer_messages.environment.wizard.form.db_host_label') }}
                    </label>
                    <input type="text" name="database_hostname" id="database_hostname" value="127.0.0.1" placeholder="{{ trans('installer_messages.environment.wizard.form.db_host_placeholder') }}" />
                    @if ($errors->has('database_hostname'))
                        <span class="block px-2 py-1 rounded-md mt-1 bg-red-100 text-red-600 text-sm">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('database_hostname') }}
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('database_port') ? ' has-error ' : '' }}">
                    <label for="database_port">
                        {{ trans('installer_messages.environment.wizard.form.db_port_label') }}
                    </label>
                    <input type="number" name="database_port" id="database_port" value="3306" placeholder="{{ trans('installer_messages.environment.wizard.form.db_port_placeholder') }}" />
                    @if ($errors->has('database_port'))
                        <span class="block px-2 py-1 rounded-md mt-1 bg-red-100 text-red-600 text-sm">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('database_port') }}
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('database_name') ? ' has-error ' : '' }}">
                    <label for="database_name">
                        {{ trans('installer_messages.environment.wizard.form.db_name_label') }}
                    </label>
                    <input type="text" name="database_name" id="database_name" value="" placeholder="{{ trans('installer_messages.environment.wizard.form.db_name_placeholder') }}" />
                    @if ($errors->has('database_name'))
                        <span class="block px-2 py-1 rounded-md mt-1 bg-red-100 text-red-600 text-sm">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('database_name') }}
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('database_username') ? ' has-error ' : '' }}">
                    <label for="database_username">
                        {{ trans('installer_messages.environment.wizard.form.db_username_label') }}
                    </label>
                    <input type="text" name="database_username" id="database_username" value="" placeholder="{{ trans('installer_messages.environment.wizard.form.db_username_placeholder') }}" />
                    @if ($errors->has('database_username'))
                        <span class="block px-2 py-1 rounded-md mt-1 bg-red-100 text-red-600 text-sm">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('database_username') }}
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('database_password') ? ' has-error ' : '' }}">
                    <label for="database_password">
                        {{ trans('installer_messages.environment.wizard.form.db_password_label') }}
                    </label>
                    <input type="password" name="database_password" id="database_password" value="" placeholder="{{ trans('installer_messages.environment.wizard.form.db_password_placeholder') }}" />
                    @if ($errors->has('database_password'))
                        <span class="block px-2 py-1 rounded-md mt-1 bg-red-100 text-red-600 text-sm">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('database_password') }}
                        </span>
                    @endif
                </div>

                <div class="mt-6 text-center">
                    <button class="flex w-full items-center justify-center p-2 gap-2 rounded-xl shadow-[0_4px_10px_rgba(0,0,0,0.05)] transition-all duration-300 font-medium hover:bg-black hover:text-white hover:scale-105" type="submit">
                        {{ trans('installer_messages.environment.wizard.form.buttons.install') }}
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path d="M9 6l6 6l-6 6"></path> </svg>
                    </button>
                </div>
            </div>
        </form>

    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        function checkEnvironment(val) {
            var element=document.getElementById('environment_text_input');
            if(val=='other') {
                element.style.display='block';
            } else {
                element.style.display='none';
            }
        }
        function showDatabaseSettings() {
            document.getElementById('tab2').checked = true;
        }
        function showApplicationSettings() {
            document.getElementById('tab3').checked = true;
        }
    </script>
@endsection
