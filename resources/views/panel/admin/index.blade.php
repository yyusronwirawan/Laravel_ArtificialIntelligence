@extends('panel.layout.app')
@section('title', 'Dashboard')
@section('content')
<div class="page-header">
	<div class="container-xl">
		<div class="row g-2 items-center justify-between max-md:flex-col max-md:items-start max-md:gap-4">
			<div class="col col-xs-12">
				<!-- Page pre-title -->
				<div class="page-pretitle">
					{{__('Dashboard')}}
				</div>
				<h2 class="page-title mb-2">
					{{__('Overview')}}
				</h2>
			</div>
			<!-- Page title actions -->
			<div class="col-auto">
				<div class="btn-list">
					<a href="{{ LaravelLocalization::localizeUrl( route('dashboard.user.openai.documents.all') ) }}" class="btn">
						{{__('My Documents')}}
					</a>
					<a href="{{ LaravelLocalization::localizeUrl( route('dashboard.user.openai.list') ) }}" class="btn btn-primary">
						<svg xmlns="http://www.w3.org/2000/svg" class="!me-2" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
						{{__('New')}}
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Page body -->
<div class="page-body pt-6">
	<div class="container-xl">
		@if($gatewayError == true)
		<div class="row">
			<div class="col-md-12 mb-3">
				<div class="bg-amber-100 text-amber-600 rounded-xl !p-3 !mt-2 dark:bg-amber-600/20 dark:text-amber-200">
					<svg class="inline !me-1" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path> <path d="M12 9h.01"></path> <path d="M11 12h1v4h1"></path> </svg>
					{{ __('Gateway is set to use sandbox. Please set mode to development!') }}<br><br>
					<ul>
						<li>
							{{__('To use live settings:')}}
							<ul>
								<li>{{__('Set mode to Production')}}</li>
								<li>{{__('Save gateway settings')}}</li>
								<li>{{__('Know that all defined products and prices will reset.')}}</li>
							</ul>
						</li>
						<li>
							{{__('To use sandbox settings:')}}
							<ul>
								<li>{{__('Set mode to Development')}}</li>
								<li>{{__('Save gateway settings')}}</li>
								<li>{{__('Know that all defined products and prices will reset.')}}</li>
							</ul>
						</li>
						<li>{{__('Beware of that order is important. First set mode then save gateway settings.')}}</li>
					</ul>
				</div>
			</div>
		</div>
		@endif
		<div class="row row-deck row-cards max-xl:[--tblr-gutter-y:1.5rem]">
			<div class="col-sm-6 col-xl-3">
				<div class="card card-sm">
					<div class="card-body">
						<div class="row align-items-center">
							<div class="col-auto">
								<span class="avatar bg-white dark:!bg-[rgba(255,255,255,0.05)]">
									<svg width="12" height="20" viewBox="0 0 12 20" fill="none" stroke="var(--lqd-heading-color)" xmlns="http://www.w3.org/2000/svg"> <path d="M10.7 6C10.501 5.43524 10.1374 4.94297 9.65627 4.58654C9.17509 4.23011 8.59825 4.02583 8 4H4C3.20435 4 2.44129 4.31607 1.87868 4.87868C1.31607 5.44129 1 6.20435 1 7C1 7.79565 1.31607 8.55871 1.87868 9.12132C2.44129 9.68393 3.20435 10 4 10H8C8.79565 10 9.55871 10.3161 10.1213 10.8787C10.6839 11.4413 11 12.2044 11 13C11 13.7956 10.6839 14.5587 10.1213 15.1213C9.55871 15.6839 8.79565 16 8 16H4C3.40175 15.9742 2.82491 15.7699 2.34373 15.4135C1.86255 15.057 1.49905 14.5648 1.3 14" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path d="M6 1V4M6 16V19" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>
								</span>
							</div>
							<div class="col">
								<p class="font-weight-medium mb-1">
									{{__('Total sales')}}
								</p>
								<h3 class="text-[20px] mb-0 flex items-center">
									${{ number_format(cache('total_sales')) }}
                                    {!! percentageChange(cache('sales_previous_week'), cache('sales_this_week')) !!}
                                </h3>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-xl-3">
				<div class="card card-sm">
					<div class="card-body">
						<div class="row align-items-center">
							<div class="col-auto">
								<span class="avatar bg-white dark:!bg-[rgba(255,255,255,0.05)]">
									<svg width="19" height="18" viewBox="0 0 19 18" fill="none" stroke="var(--lqd-heading-color)" xmlns="http://www.w3.org/2000/svg"> <path d="M1 17V15.2222C1 14.2792 1.37707 13.3749 2.04825 12.7081C2.71943 12.0413 3.62975 11.6667 4.57895 11.6667H8.15789C9.10709 11.6667 10.0174 12.0413 10.6886 12.7081C11.3598 13.3749 11.7368 14.2792 11.7368 15.2222V17M12.6316 8.11111H18M15.3158 5.44444V10.7778M9.94737 4.55556C9.94737 6.51923 8.34502 8.11111 6.36842 8.11111C4.39182 8.11111 2.78947 6.51923 2.78947 4.55556C2.78947 2.59188 4.39182 1 6.36842 1C8.34502 1 9.94737 2.59188 9.94737 4.55556Z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>
								</span>
							</div>
							<div class="col">
								<p class="font-weight-medium mb-1">
									{{__('New users')}}
								</p>
								<h3 class="text-[20px] mb-0 flex items-center">
                                    {{cache('users_this_week')}}
                                    {!! percentageChange(cache('users_previous_week'), cache('users_this_week')) !!}
                                </h3>
							</div>
						</div>
					</div>
				</div>

			</div>
			<div class="col-sm-6 col-xl-3">
				<div class="card card-sm">
					<div class="card-body">
						<div class="row align-items-center">
							<div class="col-auto">
								<span class="avatar bg-white dark:!bg-[rgba(255,255,255,0.05)]">
									<svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 24 24" stroke-width="1.5" stroke="var(--lqd-heading-color)" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none"/> <path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4" /> <line x1="13.5" y1="6.5" x2="17.5" y2="10.5" /> </svg>
								</span>
							</div>
							<div class="col">
								<p class="font-weight-medium mb-1">
									{{__('Words Generated')}}
								</p>
								<h3 class="text-[20px] mb-0 flex items-center">
                                    {{cache('words_this_week')}}
                                    {!! percentageChange(cache('words_previous_week'), cache('words_this_week')) !!}
								</h3>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-xl-3">
				<div class="card card-sm">
					<div class="card-body">
						<div class="row align-items-center">
							<div class="col-auto">
								<span class="avatar bg-white dark:!bg-[rgba(255,255,255,0.05)]">
									<svg width="20" height="19" viewBox="0 0 20 19" fill="none" stroke="var(--lqd-heading-color)" xmlns="http://www.w3.org/2000/svg"> <path d="M2.90625 4.5H3.90625C4.43668 4.5 4.94539 4.28929 5.32046 3.91421C5.69554 3.53914 5.90625 3.03043 5.90625 2.5C5.90625 2.23478 6.01161 1.98043 6.19914 1.79289C6.38668 1.60536 6.64103 1.5 6.90625 1.5H12.9062C13.1715 1.5 13.4258 1.60536 13.6134 1.79289C13.8009 1.98043 13.9062 2.23478 13.9062 2.5C13.9062 3.03043 14.117 3.53914 14.492 3.91421C14.8671 4.28929 15.3758 4.5 15.9062 4.5H16.9062C17.4367 4.5 17.9454 4.71071 18.3205 5.08579C18.6955 5.46086 18.9062 5.96957 18.9062 6.5V15.5C18.9062 16.0304 18.6955 16.5391 18.3205 16.9142C17.9454 17.2893 17.4367 17.5 16.9062 17.5H2.90625C2.37582 17.5 1.86711 17.2893 1.49204 16.9142C1.11696 16.5391 0.90625 16.0304 0.90625 15.5V6.5C0.90625 5.96957 1.11696 5.46086 1.49204 5.08579C1.86711 4.71071 2.37582 4.5 2.90625 4.5Z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path d="M9.90625 13.5C11.5631 13.5 12.9062 12.1569 12.9062 10.5C12.9062 8.84315 11.5631 7.5 9.90625 7.5C8.2494 7.5 6.90625 8.84315 6.90625 10.5C6.90625 12.1569 8.2494 13.5 9.90625 13.5Z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>
								</span>
							</div>
							<div class="col">
								<p class="font-weight-medium mb-1">
									{{__('Images Generated')}}
								</p>
								<h3 class="text-[20px] mb-0 flex items-center">
                                    {{cache('images_this_week')}}
                                    {!! percentageChange(cache('images_previous_week'), cache('images_this_week')) !!}
								</h3>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title text-heading">{{__('Revenue')}}</h3>
					</div>
					<div class="card-body">
						<p class="text-muted mb-1">{{__('Total Sales')}}</p>
						<!-- adding these 2 divs to add utility classnames from tailwind -->
						<div class="hidden text-[var(--tblr-green)] bg-[rgba(var(--tblr-green-rgb),0.15)] -scale-100"></div>
						<div class="hidden text-[var(--tblr-red)] bg-[rgba(var(--tblr-red-rgb),0.15)]"></div>
						<h3 class="flex items-center">
							${{ number_format(cache('total_sales')) }}
							<span class="inline-flex items-center leading-none !ms-2 text-[var(--tblr-green)] text-[10px] bg-[rgba(var(--tblr-green-rgb),0.15)] px-[5px] py-[3px] rounded-[3px]">
								<svg class="mr-1" width="7" height="4" viewBox="0 0 7 4" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
									<path d="M0 3.2768C0 3.32591 0.0245541 3.38116 0.061384 3.41799L0.368304 3.72491C0.405134 3.76174 0.46038 3.78629 0.509487 3.78629C0.558594 3.78629 0.61384 3.76174 0.65067 3.72491L3.06306 1.31252L5.47545 3.72491C5.51228 3.76174 5.56752 3.78629 5.61663 3.78629C5.67188 3.78629 5.72098 3.76174 5.75781 3.72491L6.06473 3.41799C6.10156 3.38116 6.12612 3.32591 6.12612 3.2768C6.12612 3.2277 6.10156 3.17245 6.06473 3.13562L3.20424 0.275129C3.16741 0.238299 3.11217 0.213745 3.06306 0.213745C3.01395 0.213745 2.95871 0.238299 2.92188 0.275129L0.061384 3.13562C0.0245541 3.17245 0 3.2277 0 3.2768Z"/>
								</svg>
								@if(cache('sales_previous_week') != 0 and cache('sales_this_week') != 0)
									@php($salesChange = number_format((1 - cache('sales_previous_week') / cache('sales_this_week')) * 100))
								@else
									@php($salesChange = 0 )
								@endif
								@php(print_r($salesChange))%
							</span>
						</h3>
						<div id="chart-daily-sales"></div>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title text-heading">{{__('Generated Content')}}</h3>
					</div>
					<div class="card-body w-full !grow-0 mt-auto">
						<div id="chart-daily-usages" class="[&_.apexcharts-legend-text]:ps-2 [&_.apexcharts-legend-text]:!pe-2 [&_.apexcharts-legend-text]:!m-0"></div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title text-heading">{{__('Top Countries')}}</h3>
					</div>
					<table class="table card-table table-vcenter">
						<thead>
							<tr>
								<th>{{__('Country')}}</th>
								<th>{{__('Users')}}</th>
								<th>{{__('Popularity')}}</th>
							</tr>
						</thead>
						<tbody>
							@foreach(json_decode(cache('top_countries')) as $top_countries)
							<tr>
								<td>{{$top_countries->country ?? 'Not Specified'}}</td>
								<td>{{$top_countries->total}}</td>
								<td class="w-50">
									<div class="progress progress-xs">
										<div class="progress-bar bg-primary" style="width: {{100*$top_countries->total/cache('total_users')}}%"></div>
									</div>
								</td>
							</tr>
							@endforeach

						</tbody>
					</table>
				</div>
			</div>

			<div class="col-md-6">
				<div class="card" style="height: 28rem">
					<div class="card-header">
						<h3 class="card-title text-heading">{{__('Activity')}}</h3>
					</div>
					<div class="card-table table-responsive grow">
						<table class="table table-vcenter">
							@foreach($activity as $entry)
							<tr>
								<td class="w-1 !pe-0">
									@if ($entry->user)
										{!! $entry->user->getAvatar() !!}
									@endif
								</td>
								<td>
									<div class="text-truncate">
										@if ($entry->user)
											<strong>{{$entry->user->fullName()}}</strong>
										@endif
										{{$entry->activity_type}}
										@if( isset( $entry->activity_title ))
										<strong>"{{$entry->activity_title}}"</strong>
										@endif
									</div>
									<div class="text-muted">{{$entry->created_at->diffForHumans()}}</div>
								</td>
								<td class="!text-end">
									@if(isset($entry->url))
									<a href="{{$entry->url}}" class="btn btn-sm btn-primary">Go</a>
									@endif
								</td>
							</tr>
							@endforeach
						</table>
						@if(count($activity) == 0)
						<div class="h-full flex flex-col items-center justify-center text-center overflow-hidden">
							<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-article-off icon-lg mb-2 opacity-40" width="100" height="100" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none"></path> <path d="M8 4h11a2 2 0 0 1 2 2v11m-1.172 2.821a1.993 1.993 0 0 1 -.828 .179h-14a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 1.156 -1.814"></path> <path d="M7 8h1m4 0h5"></path> <path d="M7 12h5m4 0h1"></path> <path d="M7 16h9"></path> <path d="M3 3l18 18"></path> </svg>
							<h3>{{__('No activity logged yet.')}}</h3>
						</div>
						@endif
					</div>
				</div>
			</div>

			<div class="col-md-12 col-lg-12">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title text-heading">{{__('Latest Transactions')}}</h3>
					</div>
					<div class="card-table table-responsive">
						<table class="table table-vcenter">
							<thead>
								<tr>
									<th>{{__('Method')}}</th>
									<th>{{__('Status')}}</th>
									<th>{{__('Info')}}</th>
									<th colspan="3">{{__('Plan')}} / {{__('Words')}} / {{__('Images')}}</th>
								</tr>
							</thead>
							@foreach($latestOrders as $order)
							<tr>
								<td>
									{{$order->payment_type}}
								</td>
								@if($order->status == 'Success')
								<td>
									<span class="badge bg-success">{{$order->status}}</span>
								</td>
								@else
								<td>
									<span class="badge bg-danger">{{$order->status}}</span>
								</td>
								@endif
								<td class="text-muted">
									<span class="text-[var(--lqd-heading-color)]">{{$order->user->fullName()}}</span>
									<br>
									<span class="opacity-70">{{$order->type}}</span>
								</td>
								<td class="w-1" colspan="3">
									<span class="text-primary font-medium">{{@$order->plan->name ?? 'Archived Plan'}}</span>
									/<span class="text-[var(--lqd-heading-color)] !ms-1">{{@$order->plan->total_words ?? '-'}}</span>
									/<span class="text-[var(--lqd-heading-color)] !ms-1">{{@$order->plan->total_images ?? '-'}}</span>
								</td>
							</tr>
							@endforeach

						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
	(() => {
		"use strict";

		var dailySalesChartOptions = {
			series: [{
				name: 'Sales',
				data: [
					@foreach(json_decode(cache('daily_sales')) as $dailySales) [{{strtotime($dailySales->days) * 1000}},{{$dailySales->sums}}],@endforeach
				]
			}],
			colors: ['var(--tblr-primary)'],
			chart: {
				id: 'area-datetime',
				type: 'area',
				height: 210,
				zoom: {
					enabled: false
				},
				toolbar: {
					show: false
				}
			},
			dataLabels: {
				enabled: false
			},
			grid: {
				show: false,
			},
			xaxis: {
				type: 'datetime',
				labels: {
					offsetY: 0,
					style: {
						colors: 'var(--lqd-faded-out)',
						fontSize: '10px',
						fontFamily: 'inherit',
						fontWeight: 500,
					},
				},
				axisBorder: {
					show: false,
				},
				axisTicks: {
					show: false,
				},
			},
			yaxis: {
				labels: {
					offsetX: -15,
					style: {
						colors: 'var(--lqd-faded-out)',
						fontSize: '10px',
						fontFamily: 'inherit',
						fontWeight: 500,
					},
				},
				axisBorder: {
					show: false,
				},
				axisTicks: {
					show: false,
				},
			},
			tooltip: {
				x: {
					format: 'dd MMM yyyy'
				}
			},
			stroke: {
				width: 2,
				colors: ['var(--tblr-primary)'],
				curve: 'smooth'
			},
			fill: {
				type: 'gradient',
				gradient: {
					shadeIntensity: 1,
					opacityFrom: 0.3,
					opacityTo: 0.6,
					stops: [0, 100],
					colorStops: [
						[
							{
								offset: 50,
								color: 'var(--tblr-primary)',
								opacity: 0.1
							},
							{
								offset: 150,
								color: '#6A22C5',
								opacity: 0
							},
						]
					]
				}
			},
		};

		var chart = new ApexCharts(document.querySelector("#chart-daily-sales"), dailySalesChartOptions);
		chart.render();

		var dailyUsageChartOptions = {
		series: [{
			name: 'Words',
			data: [@foreach(json_decode(cache('daily_usages')) as $dailySales) '{{(int)$dailySales->sumsWord}}',@endforeach]
		}, {
			name: 'Images',
			data: [@foreach(json_decode(cache('daily_usages')) as $dailySales) '{{(int)$dailySales->sumsImage}}',@endforeach]
		}],
		colors: ['var(--tblr-primary)', 'rgba(var(--tblr-primary-rgb),0.15)'],
		chart: {
			type: 'bar',
			height: 260,
			stacked: true,
			zoom: {
				enabled: false
			},
			toolbar: {
				show: false
			}
		},
		plotOptions: {
			bar: {
				horizontal: false,
				columnWidth: '23px',
				borderRadius: 5,
			},
		},
		dataLabels: {
			enabled: false
		},
		grid: {
			show: false
		},
		xaxis: {
			type: 'datetime',
			categories: [@foreach(json_decode(cache('daily_usages')) as $dailySales) '{{$dailySales->days}}',@endforeach],
			labels: {
				offsetY: 0,
				style: {
					colors: 'var(--lqd-faded-out)',
					fontSize: '10px',
					fontFamily: 'inherit',
					fontWeight: 500,
				},
			},
			axisBorder: {
				show: false,
			},
			axisTicks: {
				show: false,
			},
		},
		yaxis: {
			labels: {
				offsetX: -10,
				style: {
					colors: 'var(--lqd-faded-out)',
					fontSize: '10px',
					fontFamily: 'inherit',
					fontWeight: 500,
				},
			},
			axisBorder: {
				show: false,
			},
			axisTicks: {
				show: false,
			},
		},
		tooltip: {
			x: {
				format: 'dd MMM yyyy'
			}
		},
		stroke: {
			width: 5,
			colors: 'var(--tblr-body-bg)'
		},
		legend: {
			position: 'top',
			horizontalAlign: 'left',
			offsetY: 0,
			offsetX: -40,
			markers: {
				width: 8,
				height: 8,
				radius: 10,
			},
			itemMargin: {
				horizontal: 15,
			},
		},
		fill: {
			opacity: 1
		}
	};

	var chart = new ApexCharts(document.querySelector("#chart-daily-usages"), dailyUsageChartOptions);
	chart.render();

	})();
</script>

@endsection
