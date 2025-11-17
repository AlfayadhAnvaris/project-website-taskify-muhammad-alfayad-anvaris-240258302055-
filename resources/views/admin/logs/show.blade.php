@extends('components.layouts.admin')

@section('title', 'Detail Log Aktivitas')

@section('content')
<main class="main-content flex-1 p-6 min-h-screen text-white bg-gray-900">
    <div class="max-w-3xl mx-auto bg-gray-800/60 border border-gray-700 rounded-2xl shadow-lg p-6">
        <h1 class="text-2xl font-bold mb-4">Detail Log Aktivitas</h1>

        <div class="mb-2"><strong>Waktu:</strong> {{ $log->created_at->format('d M Y H:i') }}</div>
        <div class="mb-2"><strong>User:</strong> {{ $log->user->name ?? 'System' }}</div>
        <div class="mb-2"><strong>Aksi:</strong> {{ $log->action }}</div>
        <div class="mb-2"><strong>Deskripsi:</strong> {{ $log->description }}</div>

        <a href="{{ route('admin.logs.index') }}" class="mt-4 inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
            Kembali
        </a>
    </div>
</main>
@endsection
