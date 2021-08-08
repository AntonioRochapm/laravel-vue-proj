@extends('master.main')

@section('content')

    @component('components.main.main-students', ['subjects'=>$subjects])
    @endcomponent

@endsection
