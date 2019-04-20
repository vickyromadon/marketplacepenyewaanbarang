@extends('layouts.app')

@section('content')
	<div class="categories-section main-grid-border">
		<div class="container">
			<h2 class="head text-center">Kategori Utama</h2>
			<div class="category-list">
				<div id="parentVerticalTab">
					<ul class="resp-tabs-list hor_1">
						@foreach ($data as $category)
							<li>{{ $category->name }}</li>
						@endforeach
					</ul>
					<div class="resp-tabs-container hor_1">
						<div>
							<div class="category">
								<div class="category-img">
									<img src="{{ asset('images/categories/Musical Instrumental.jpg') }}">
								</div>
								<div class="category-info">
									<h4>{{ $data[0]->name }}</h4>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="sub-categories">
								<b>Deskripsi : </b>
								{{ $data[0]->description != null ? $data[0]->description : '-'}}
								<hr>
								<ul>
									@foreach ($data as $category)
										@foreach ($category->sub_categories as $sub_category)
											@if ( $sub_category->category_id == 1 )
												<li><a href="{{ route('member.category.index', ['id' => $sub_category->id]) }}">{{ $sub_category->name }}</a></li>
											@endif
										@endforeach
									@endforeach
									<div class="clearfix"></div>
								</ul>
							</div>
						</div>
						<div>
							<div class="category">
								<div class="category-img">
									<img src="{{ asset('images/categories/Electronics & Appliances.png') }}">
								</div>
								<div class="category-info">
									<h4>{{ $data[1]->name }}</h4>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="sub-categories">
								<b>Deskripsi : </b>
								{{ $data[1]->description != null ? $data[1]->description : '-'}}
								<hr>
								<ul>
									@foreach ($data as $category)
										@foreach ($category->sub_categories as $sub_category)
											@if ( $sub_category->category_id == 2 )
												<li><a href="{{ route('member.category.index', ['id' => $sub_category->id]) }}">{{ $sub_category->name }}</a></li>
											@endif
										@endforeach
									@endforeach
									<div class="clearfix"></div>
								</ul>
							</div>
						</div>
						<div>
							<div class="category">
								<div class="category-img">
									<img src="{{ asset('images/categories/Vehicles.jpg') }}">
								</div>
								<div class="category-info">
									<h4>{{ $data[2]->name }}</h4>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="sub-categories">
								<b>Deskripsi : </b>
								{{ $data[2]->description != null ? $data[2]->description : '-'}}
								<hr>
								<ul>
									@foreach ($data as $category)
										@foreach ($category->sub_categories as $sub_category)
											@if ( $sub_category->category_id == 3 )
												<li><a href="{{ route('member.category.index', ['id' => $sub_category->id]) }}">{{ $sub_category->name }}</a></li>
											@endif
										@endforeach
									@endforeach
									<div class="clearfix"></div>
								</ul>
							</div>
						</div>
						<div>
							<div class="category">
								<div class="category-img">
									<img src="{{ asset('images/categories/Bikes and Scooters.jpg') }}">
								</div>
								<div class="category-info">
									<h4>{{ $data[3]->name }}</h4>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="sub-categories">
								<b>Deskripsi : </b>
								{{ $data[3]->description != null ? $data[3]->description : '-'}}
								<hr>
								<ul>
									@foreach ($data as $category)
										@foreach ($category->sub_categories as $sub_category)
											@if ( $sub_category->category_id == 4 )
												<li><a href="{{ route('member.category.index', ['id' => $sub_category->id]) }}">{{ $sub_category->name }}</a></li>
											@endif
										@endforeach
									@endforeach
									<div class="clearfix"></div>
								</ul>
							</div>
						</div>
						<div>
							<div class="category">
								<div class="category-img">
									<img src="{{ asset('images/categories/Furniture.jpg') }}">
								</div>
								<div class="category-info">
									<h4>{{ $data[4]->name }}</h4>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="sub-categories">
								<b>Deskripsi : </b>
								{{ $data[4]->description != null ? $data[4]->description : '-'}}
								<hr>
								<ul>
									@foreach ($data as $category)
										@foreach ($category->sub_categories as $sub_category)
											@if ( $sub_category->category_id == 5 )
												<li><a href="{{ route('member.category.index', ['id' => $sub_category->id]) }}">{{ $sub_category->name }}</a></li>
											@endif
										@endforeach
									@endforeach
									<div class="clearfix"></div>
								</ul>
							</div>
						</div>
						<div>
							<div class="category">
								<div class="category-img">
									<img src="{{ asset('images/categories/Audio Visual Equipment.jpg') }}">
								</div>
								<div class="category-info">
									<h4>{{ $data[5]->name }}</h4>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="sub-categories">
								<b>Deskripsi : </b>
								{{ $data[5]->description != null ? $data[5]->description : '-'}}
								<hr>
								<ul>
									@foreach ($data as $category)
										@foreach ($category->sub_categories as $sub_category)
											@if ( $sub_category->category_id == 6 )
												<li><a href="{{ route('member.category.index', ['id' => $sub_category->id]) }}">{{ $sub_category->name }}</a></li>
											@endif
										@endforeach
									@endforeach
									<div class="clearfix"></div>
								</ul>
							</div>
						</div>
						<div>
							<div class="category">
								<div class="category-img">
									<img src="{{ asset('images/categories/Office Furniture.jpeg') }}">
								</div>
								<div class="category-info">
									<h4>{{ $data[6]->name }}</h4>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="sub-categories">
								<b>Deskripsi : </b>
								{{ $data[6]->description != null ? $data[6]->description : '-'}}
								<hr>
								<ul>
									@foreach ($data as $category)
										@foreach ($category->sub_categories as $sub_category)
											@if ( $sub_category->category_id == 7 )
												<li><a href="{{ route('member.category.index', ['id' => $sub_category->id]) }}">{{ $sub_category->name }}</a></li>
											@endif
										@endforeach
									@endforeach
									<div class="clearfix"></div>
								</ul>
							</div>
						</div>
						<div>
							<div class="category">
								<div class="category-img">
									<img src="{{ asset('images/categories/Costumes, Dresses and Accessories.jpg') }}">
								</div>
								<div class="category-info">
									<h4>{{ $data[7]->name }}</h4>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="sub-categories">
								<b>Deskripsi : </b>
								{{ $data[7]->description != null ? $data[7]->description : '-'}}
								<hr>
								<ul>
									@foreach ($data as $category)
										@foreach ($category->sub_categories as $sub_category)
											@if ( $sub_category->category_id == 8 )
												<li><a href="{{ route('member.category.index', ['id' => $sub_category->id]) }}">{{ $sub_category->name }}</a></li>
											@endif
										@endforeach
									@endforeach
									<div class="clearfix"></div>
								</ul>
							</div>
						</div>
						<div>
							<div class="category">
								<div class="category-img">
									<img src="{{ asset('images/categories/Baby Accessories and Toys.jpg') }}">
								</div>
								<div class="category-info">
									<h4>{{ $data[8]->name }}</h4>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="sub-categories">
								<b>Deskripsi : </b>
								{{ $data[8]->description != null ? $data[8]->description : '-'}}
								<hr>
								<ul>
									@foreach ($data as $category)
										@foreach ($category->sub_categories as $sub_category)
											@if ( $sub_category->category_id == 9 )
												<li><a href="{{ route('member.category.index', ['id' => $sub_category->id]) }}">{{ $sub_category->name }}</a></li>
											@endif
										@endforeach
									@endforeach
									<div class="clearfix"></div>
								</ul>
							</div>
						</div>
						<div>
							<div class="category">
								<div class="category-img">
									<img src="{{ asset('images/categories/Event and Wedding Supplies.jpg') }}">
								</div>
								<div class="category-info">
									<h4>{{ $data[9]->name }}</h4>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="sub-categories">
								<b>Deskripsi : </b>
								{{ $data[9]->description != null ? $data[9]->description : '-'}}
								<hr>
								<ul>
									@foreach ($data as $category)
										@foreach ($category->sub_categories as $sub_category)
											@if ( $sub_category->category_id == 10 )
												<li><a href="{{ route('member.category.index', ['id' => $sub_category->id]) }}">{{ $sub_category->name }}</a></li>
											@endif
										@endforeach
									@endforeach
									<div class="clearfix"></div>
								</ul>
							</div>
						</div>
						<div>
							<div class="category">
								<div class="category-img">
									<img src="{{ asset('images/categories/Adventure Gear.jpg') }}">
								</div>
								<div class="category-info">
									<h4>{{ $data[10]->name }}</h4>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="sub-categories">
								<b>Deskripsi : </b>
								{{ $data[10]->description != null ? $data[10]->description : '-'}}
								<hr>
								<ul>
									@foreach ($data as $category)
										@foreach ($category->sub_categories as $sub_category)
											@if ( $sub_category->category_id == 11 )
												<li><a href="{{ route('member.category.index', ['id' => $sub_category->id]) }}">{{ $sub_category->name }}</a></li>
											@endif
										@endforeach
									@endforeach
									<div class="clearfix"></div>
								</ul>
							</div>
						</div>
						<div>
							<div class="category">
								<div class="category-img">
									<img src="{{ asset('images/categories/Medical Supplies.png') }}">
								</div>
								<div class="category-info">
									<h4>{{ $data[11]->name }}</h4>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="sub-categories">
								<b>Deskripsi : </b>
								{{ $data[11]->description != null ? $data[11]->description : '-'}}
								<hr>
								<ul>
									@foreach ($data as $category)
										@foreach ($category->sub_categories as $sub_category)
											@if ( $sub_category->category_id == 12 )
												<li><a href="{{ route('member.category.index', ['id' => $sub_category->id]) }}">{{ $sub_category->name }}</a></li>
											@endif
										@endforeach
									@endforeach
									<div class="clearfix"></div>
								</ul>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('js')
	<!--Plug-in Initialisation-->
	<script type="text/javascript">
		$(document).ready(function() {
			//Vertical Tab
			$('#parentVerticalTab').easyResponsiveTabs({
				type: 'vertical', //Types: default, vertical, accordion
				width: 'auto', //auto or any width like 600px
				fit: true, // 100% fit in a container
				closed: 'accordion', // Start closed if in accordion view
				tabidentify: 'hor_1', // The tab groups identifier
				activate: function(event) { // Callback function if tab is switched
					var $tab = $(this);
					var $info = $('#nested-tabInfo2');
					var $name = $('span', $info);
					$name.text($tab.text());
					$info.show();
				}
			});
		});
	</script>

	<script>
		$(document).ready(function () {
		var mySelect = $('#first-disabled2');

			$('#special').on('click', function () {
			mySelect.find('option:selected').prop('disabled', true);
			mySelect.selectpicker('refresh');
			});

			$('#special2').on('click', function () {
			mySelect.find('option:disabled').prop('disabled', false);
			mySelect.selectpicker('refresh');
			});

			$('#basic2').selectpicker({
			liveSearch: true,
			maxOptions: 1
			});
		});
	</script>
@endsection