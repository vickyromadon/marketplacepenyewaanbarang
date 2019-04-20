@extends('layouts.app')

@section('content')
	<div class="faq">
		<div class="container">
			<h2 class="head text-center">Faqs</h2>
			<dl class="faq-list">
				@foreach ($data as $faq)
					<dt class="faq-list_h">
						<h4 class="marker">Q?</h4>
						<h5 class="marker_head">{{ $faq->question }}</h5>
					</dt>
					<dd>
						<h4 class="marker1">A.</h4>
						<p class="m_13">{{ $faq->answer }}</p>
					</dd>
				@endforeach

				<div class="pull-right">
					{{ $data->links() }}
				</div>
          	</dl>
		</div>
	</div>
@endsection