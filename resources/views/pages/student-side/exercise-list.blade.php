@extends('master.main')

@section('content')

    @component('components.student-side.exercise-list', ['exercises'=>$exercises])
    @endcomponent

@endsection
