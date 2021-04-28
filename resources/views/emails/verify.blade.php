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
		<h2 style="font-size:20px;" ><strong>{{ $data['code'] }}</strong></h2>
		<p>The above code is your verification code, copy and paste to very your your account</p> 
	@include('beautymail::templates.widgets.newfeatureEnd') 
@stop