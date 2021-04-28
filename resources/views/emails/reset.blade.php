@extends('beautymail::templates.widgets') 
@section('content')   
<!-- header -->
    @include('beautymail::templates.widgets.newfeatureStart') 
    <h2 >
        <span class="h1"><strong>Websoft</strong></span>-<span class="h2"><strong>Pay</strong></span>
    </h2>
    @include('beautymail::templates.widgets.newfeatureEnd')  

    <!-- content -->
    @include('beautymail::templates.widgets.articleStart')    
		<h4 class="secondary"><strong>Hello {{ $data['name']}}</strong></h4>
		<p>{{ $data['content'] }}</p> 
	@include('beautymail::templates.widgets.articleEnd')

<!-- footer -->
	@include('beautymail::templates.widgets.newfeatureStart') 
		<a href="{{ $data['link'] }}">Reset Password</a>
		<p>Click the link above to reset your password or copy these code to your browser <a href="{{ $data['link'] }}">{{ $data['link'] }}</a> </p> 
	@include('beautymail::templates.widgets.newfeatureEnd') 
@stop