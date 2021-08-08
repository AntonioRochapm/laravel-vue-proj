@extends('master.main')

@section('content')

    @component('components.teacher-side.teacher.teacher-list', ['teachers'=>$teachers]);
    @endcomponent


@endsection
