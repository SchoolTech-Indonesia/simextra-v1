@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Selamat Datang {{ Auth::user()->name }}</h1>
</div>

@endsection
