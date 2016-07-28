@extends('app')

@section('content')
<h5 style="position:fixed;right:0;bottom:0; display:block;" class="whiteText">Just look at that trendy background with white text</h5>
<div class="container">
	<div class="row vertical-center">
		<div class="col-md-5 col-md-offset-1 whiteText">
					<h1>Gif it to me.</h1>
					<a href="{{ url('/auth/register') }}"><span class="btn btn-default"><i class="glyphicon glyphicon-plus"></i> Sign up</span></a>
					<a href="{{ url('/auth/login') }}"><span class="btn btn-default"><i class="glyphicon glyphicon-log-in"></i> Sign in</span></a>

		</div>
		<div class="col-md-3 whiteText">
			<img src="{{ $gifURL }}"/>
		</div>
	</div>
</div>
@endsection
