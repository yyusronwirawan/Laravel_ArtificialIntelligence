<footer class="footer footer-transparent max-lg:pb-24">
    <div class="container-xl">
        <div class="row text-center items-center flex-row-reverse">
            <div class="col-lg-auto lg:ms-auto">
                <p>{{__('Version')}}: {{$setting->script_version}}R</p>
            </div>
            <div class="col-12 col-lg-auto mt-3 mt-lg-0">
				<p>
					{{__('Copyright')}} &copy; <?php echo date("Y"); ?>
					<a href="{{route('index')}}" class="link-secondary">{{$setting->site_name}}</a>.
					{{__('All rights reserved.')}}</p>
            </div>
        </div>
    </div>
</footer>
