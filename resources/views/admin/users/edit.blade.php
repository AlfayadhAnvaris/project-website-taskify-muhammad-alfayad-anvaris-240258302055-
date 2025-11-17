@extends('components.layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="max-w-lg mx-auto bg-gray-800 border border-gray-700 rounded-xl p-6 text-white">
    <h1 class="text-xl font-bold mb-4">Edit User</h1>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block text-sm text-gray-400 mb-1">Nama</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                   class="w-full bg-gray-900 border border-gray-700 rounded-lg p-2 text-white">
        </div>

        <div>
            <label for="email" class="block text-sm text-gray-400 mb-1">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                   class="w-full bg-gray-900 border border-gray-700 rounded-lg p-2 text-white">
        </div>

        <div>
            <label for="password" class="block text-sm text-gray-400 mb-1">Password (Opsional)</label>
            <input type="password" name="password" id="password"
                   class="w-full bg-gray-900 border border-gray-700 rounded-lg p-2 text-white">
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.users') }}" class="bg-gray-700 hover:bg-gray-600 text-gray-300 px-4 py-2 rounded-lg">
                Batal
            </a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
