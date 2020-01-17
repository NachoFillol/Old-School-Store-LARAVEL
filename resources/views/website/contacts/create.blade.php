@extends('website.layouts.website')

@section('title')
Contactanos
@endsection

@section('content')
<div class="content-wrap">

    <div class="form-contactUs">

        @include('website.contacts.form', [
        'method' => 'post',
        'url' => '/contact'])

    </div>

</div>

@endsection
