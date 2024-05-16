@extends('layout')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@section('content')
    <p>To add pet fill and submit <a href="{{ route('pet.add.form') }}">this</a> form.</p>
    <hr>
    <p>To see detailed information about pet to go endpoint /pet/{id}. For example <a href="/pet/1">/pet/1</a></p>
    <p>From there you will be able to edit data or delete pet.</p>
    <hr>
@endsection
