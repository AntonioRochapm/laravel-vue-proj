@extends('master.main')
@section('content')
    @component('components.student-side.exercises.flashcards', ['flashcards'=>$flashcards])
    @endcomponent
@endsection
@yield('scripts')


