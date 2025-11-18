<div class="max-w-4xl mx-auto py-10 text-white">

    @if (session()->has('success'))
        <div class="bg-green-600/20 text-green-300 px-4 py-3 rounded-lg mb-4 border border-green-500/30">
            {{ session('success') }}
        </div>
    @endif

    <h1 class="text-3xl font-bold mb-6">Profile Saya</h1>

    <div class="grid md:grid-cols-3 gap-6">

        <!-- Avatar -->
        <div class="bg-gray-800 p-6 rounded-xl border border-gray-700">
            <h2 class="text-xl font-semibold mb-4">Foto Profil</h2>

            <div class="flex flex-col items-center gap-4">

                <img 
                    src="{{ $avatar ? asset('storage/avatars/' . $avatar) : '/default-avatar.png' }}"
                    class="w-32 h-32 rounded-full object-cover border border-gray-600"
                >

                <input type="file" wire:model="newAvatar" class="text-gray-300">

                <button 
                    wire:click="updateAvatar"
                    class="w-full bg-blue-600 hover:bg-blue-500 py-2 rounded-lg font-semibold"
                >
                    Update Foto
                </button>

                @error('newAvatar')
                    <p class="text-red-400 text-sm">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Profile Info -->
        <div class="md:col-span-2 bg-gray-800 p-6 rounded-xl border border-gray-700">
            <h2 class="text-xl font-semibold mb-4">Informasi Profil</h2>

            <div class="space-y-4">

                <div>
                    <label class="text-gray-300">Nama</label>
                    <input type="text" wire:model.defer="name"
                        class="w-full mt-1 bg-gray-900 border border-gray-700 rounded-lg px-4 py-2">
                    @error('name') <p class="text-red-400 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-gray-300">Email</label>
                    <input type="email" wire:model.defer="email"
                        class="w-full mt-1 bg-gray-900 border border-gray-700 rounded-lg px-4 py-2">
                    @error('email') <p class="text-red-400 text-sm">{{ $message }}</p> @enderror
                </div>

                <button 
                    wire:click="updateProfile"
                    class="w-full bg-green-600 hover:bg-green-500 py-2 rounded-lg font-semibold"
                >
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </div>


    <!-- Password Update -->
    <div class="bg-gray-800 mt-8 p-6 rounded-xl border border-gray-700">
        <h2 class="text-xl font-semibold mb-4">Ubah Password</h2>

        <div class="space-y-4">

            <div>
                <label class="text-gray-300">Password Lama</label>
                <input type="password" wire:model.defer="current_password"
                    class="w-full mt-1 bg-gray-900 border border-gray-700 rounded-lg px-4 py-2">
                @error('current_password') <p class="text-red-400 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-gray-300">Password Baru</label>
                    <input type="password" wire:model.defer="new_password"
                        class="w-full mt-1 bg-gray-900 border border-gray-700 rounded-lg px-4 py-2">
                    @error('new_password') <p class="text-red-400 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-gray-300">Konfirmasi Password</label>
                    <input type="password" wire:model.defer="confirm_password"
                        class="w-full mt-1 bg-gray-900 border border-gray-700 rounded-lg px-4 py-2">
                    @error('confirm_password') <p class="text-red-400 text-sm">{{ $message }}</p> @enderror
                </div>
            </div>

            <button 
                wire:click="updatePassword"
                class="w-full bg-purple-600 hover:bg-purple-500 py-2 rounded-lg font-semibold"
            >
                Update Password
            </button>
        </div>
    </div>

</div>
