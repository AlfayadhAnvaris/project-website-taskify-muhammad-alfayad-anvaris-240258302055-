@extends('components.layouts.app')

@section('title', 'Buat Laporan')

@section('content')
<main class="p-6 bg-gray-900 text-white min-h-screen">

    <x-toast />

    <div class="max-w-3xl mx-auto bg-gray-800/70 p-6 rounded-xl border border-gray-700">
        <h1 class="text-2xl font-bold mb-5">Buat Laporan Baru</h1>

        <form action="{{ route('user.reports.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="text-sm text-gray-300">Judul Laporan</label>
                <input type="text" name="title"
                    class="w-full mt-1 bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white"
                    required>
            </div>

            <div class="mb-4">
                <label class="text-sm text-gray-300">Kategori</label>
                <select name="category"
                    class="w-full mt-1 bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white">
                    <option value="progress">Progress</option>
                    <option value="kritik_saran">Kritik & Saran</option>
                    <option value="masalah">Masalah</option>
                    <option value="lainnya">Lainnya</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="text-sm text-gray-300">Isi Laporan</label>
                <textarea name="content" rows="6"
                    class="w-full mt-1 bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white"
                    required></textarea>
            </div>

            <div class="mb-4">
                <label class="text-sm text-gray-300">Lampiran (Opsional)</label>
                <input type="file" name="attachment"
                    class="mt-1 text-gray-300">
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('user.reports.index') }}"
                    class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg">
                    Batal
                </a>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-500 rounded-lg">
                    Kirim Laporan
                </button>
            </div>
        </form>
    </div>

</main>
@endsection
