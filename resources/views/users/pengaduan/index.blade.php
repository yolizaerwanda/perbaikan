<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            Selamat Datang di Pengaduan Online
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            {{-- Tombol Tambah Pengaduan --}}
            <div class="mb-4">
                <a href="{{ route('pengaduan.create') }}"
                    class="inline-block px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
                    Buat Pengaduan Baru
                </a>
            </div>
            <div class="mb-6">
                <h3 class="text-lg font-bold text-gray-700 dark:text-gray-100">Daftar Pengaduan Saya</h3>
                <hr class="mt-2 border-gray-300 dark:border-gray-600">
            </div>
            <!-- Tabel Pengaduan -->
            <div class="overflow-x-auto bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th
                                    class="w-1/6 px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                    Judul</th>
                                <th
                                    class="w-2/6 px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                    Isi</th>
                                <th
                                    class="w-1/5 px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                    Kategori</th>
                                <th
                                    class="w-1/12 px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                    Status</th>
                                <th
                                    class="w-1/12 px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                    Tanggal</th>
                                <th
                                    class="w-1/6 px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase dark:text-gray-300">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @forelse($pengaduans as $pengaduan)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900 truncate dark:text-gray-200">
                                        {{ $pengaduan->judul }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 truncate dark:text-gray-200">
                                        {{ $pengaduan->isi_pengaduan }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 truncate dark:text-gray-200">
                                        {{ $pengaduan->kategori->namaKategori ?? '_' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 truncate dark:text-gray-200">
                                        {{ ucfirst($pengaduan->status) }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                                        {{ $pengaduan->created_at->format('d-m-Y') }}</td>
                                    <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                        <div class="flex justify-center space-x-2">
                                            <!-- Tombol Edit -->
                                            <a href="{{ route('pengaduan.edit', $pengaduan->id) }}"
                                                class="inline-flex items-center px-3 py-1 text-sm font-semibold text-white transition bg-blue-600 rounded hover:bg-blue-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                                                </svg>
                                                Edit
                                            </a>

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('pengaduan.destroy', $pengaduan->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus pengaduan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-1 text-sm font-semibold text-white transition bg-red-600 rounded hover:bg-red-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4a1 1 0 011 1v2H9V4a1 1 0 011-1z" />
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-sm text-center text-gray-500 dark:text-gray-400">
                                        Belum ada pengaduan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
