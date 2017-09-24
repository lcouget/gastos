@if($errors->any())
	<div class="row">
		<div class="alert alert-error alert-dismissible" >
		    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		    {{ $errors->first() }}
		</div>
	</div>
@endif
@foreach (['danger', 'warning', 'success', 'info'] as $msg)
	@if(Session::has('alert-' . $msg))
		<div class="row">
			<div class="alert alert-{{$msg}} alert-dismissible" >
			    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			    {{ Session::get('alert-' . $msg) }}
			</div>
		</div>
	@endif
@endforeach




