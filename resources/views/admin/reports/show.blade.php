@extends('layouts.admin')

@section('content')
<div class="container mx-auto py-6 max-w-2xl">
    <h1 class="text-2xl font-bold mb-4">Detail Laporan</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white p-6 rounded shadow-md mb-6">
        <p><strong>User:</strong> {{ $report->user->name }}</p>
        <p><strong>Judul:</strong> {{ $report->title }}</p>
        <p><strong>Kategori:</strong> {{ $report->category }}</p>
        <p><strong>Isi:</strong> {{ $report->content }}</p>
        <p><strong>Status:</strong> {{ $report->status ?? 'pending' }}</p>
        @if($report->attachment)
            <p><strong>Lampiran:</strong> <a href="{{ asset('storage/' . $report->attachment) }}" target="_blank" class="text-blue-500 hover:underline">Lihat File</a></p>
        @endif
        @if($report->admin_note)
            <p><strong>Catatan Admin:</strong> {{ $report->admin_note }}</p>
        @endif
    </div>

    @if($report->status !== 'approved' && $report->status !== 'rejected')
        <div class="bg-white p-6 rounded shadow-md">
            <form action="{{ route('admin.reports.approve', $report->id) }}" method="POST" class="mb-4">
                @csrf
                <div class="mb-2">
                    <label for="note_approve" class="block font-medium mb-1">Catatan Persetujuan (Opsional)</label>
                    <textarea name="note" id="note_approve" rows="2" class="w-full border px-3 py-2 rounded"></textarea>
                </div>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Setujui</button>
            </form>

            <form action="{{ route('admin.reports.reject', $report->id) }}" method="POST">
                @csrf
                <div class="mb-2">
                    <label for="note_reject" class="block font-medium mb-1">Catatan Penolakan (Opsional)</label>
                    <textarea name="note" id="note_reject" rows="2" class="w-full border px-3 py-2 rounded"></textarea>
                </div>
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Tolak</button>
            </form>
        </div>
    @else
        <p class="text-gray-500 mt-4">Laporan sudah <strong>{{ $report->status }}</strong>.</p>
    @endif

    <a href="{{ route('admin.reports.index') }}" class="inline-block mt-4 px-4 py-2 border rounded hover:bg-gray-100">Kembali</a>
</div>
@endsection
