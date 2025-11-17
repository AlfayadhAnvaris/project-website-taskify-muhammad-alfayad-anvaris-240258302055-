@extends('components.layouts.base')

@section('sidebar')
    @if(Auth::user()->role === 'admin')
        @include('components.layouts.sidebar-admin') {{-- Sidebar admin --}}
    @else
        @include('components.layouts.sidebar')       {{-- Sidebar user --}}
    @endif
@endsection


@section('content')
    {{ $slot }}
@endsection
