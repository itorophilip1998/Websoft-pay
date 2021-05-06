@extends('beautymail::templates.widgets') 
@section('content')   
<!-- header -->
    @include('beautymail::templates.widgets.newfeatureStart') 
    <h2 style="text-align: center !important;color:rgb(31, 189, 176)" >
        <span class="h1"><strong>Websoft</strong></span>-<span class="h2"><strong>Pay</strong></span>
    </h2>   
    <!-- content -->    
		<h4 class="secondary" style="color: rgb(83, 82, 82) !important;"><strong>{{ $data['name']}}</strong></h4>
		<p style="text-justify: auto;text-align: justify;">{{ $data['content'] }}</p>  
		<h2 style="font-size:19px;color:rgb(31, 189, 176)" >
            {{ $data['code'] }} 
        </h2>
       
            <div style="text-align: center;">
                <a href="{{ $data['link'] }}" 
                style="border: 1px solid rgb(31, 189, 176);color:white;text-decoration: none;
                background-color:rgb(31, 189, 176);padding:7px 10px 7px 10px;
                border-radius:4px;font-size: 18px;
                margin-bottom: 4px; width: 50%;">
                 Verify</a>
            </div>
            <br>
		<p style="text-justify: auto;text-align: justify;padding-top: 10px;">
            The above code is your verification code, 
            copy and paste to very your account or 
            click the button to automatically verify your account.</p>
     @include('beautymail::templates.widgets.newfeatureEnd')  
@stop