<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Buat Pengaduan Baru
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white shadow sm:rounded-lg">
                <form action="{{ route('pengaduan.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Judul</label>
                        <input type="text" name="judul" class="w-full mt-1 form-input" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Isi Pengaduan</label>
                        <textarea name="isi_pengaduan" class="w-full mt-1 form-textarea" rows="4" required></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Kategori</label>
                        <select name="kategori_id" class="w-full mt-1 form-select" required>
                            @foreach ($pengaduans as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->namaKategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <input type="text" name="status" class="w-full mt-1 bg-gray-100 cursor-not-allowed form-input"
                            value="menunggu" readonly>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                        <input type="date" name="tanggal_pengaduan" class="w-full mt-1 form-input"
                            value="{{ now()->format('Y-m-d') }}" readonly>
                    </div>

                    <div>
                        <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
                            Simpan
                        </button>
                        <a href="{{ route('pengaduan.index') }}" class="ml-2 text-gray-600 hover:underline">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
