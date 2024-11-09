@extends('layouts.public')

@section('content')
    <div class="main">
        {{-- @include('partials.hero') --}}
        <livewire:hero />
        @include('partials.why-us')
        @include('partials.how-it-works')
        @include('partials.footer')
    </div>
@endsection
