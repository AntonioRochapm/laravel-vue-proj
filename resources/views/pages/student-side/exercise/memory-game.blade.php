@extends('master.main')

@section('content')
    @component('components.student-side.exercises.memory-game', ['memoryGames' => $memoryGames])
    @endcomponent
@endsection
