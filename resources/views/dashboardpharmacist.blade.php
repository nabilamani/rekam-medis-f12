<style>
    /* Sembunyikan panah di layar kecil */
    @media (max-width: 767px) {
        .fa-arrow-right {
            display: none !important;
        }
    }
</style>
<x-layouts.app>
    <div
        class="flex w-full flex-1 flex-col rounded-2xl px-8 py-6 bg-gradient-to-br from-blue-100 via-blue-100 to-blue-200 dark:from-slate-900 dark:via-slate-900 dark:to-slate-900 shadow-xl">

        <div class="flex justify-between items-start">
            {{-- Breadcrumbs kiri --}}
            <x-bread-crumbs />

            {{-- Logo kanan --}}
            <img src="{{ asset('/assets/img/redesignf21m.png') }}" alt="Logo"
                class="w-18 sm:w-25 !important h-auto object-contain" />
        </div>

        {{-- Title --}}
        <h2 class="font-semibold text-center md:text-start text-xl text-gray-800 dark:text-gray-200 leading-tight mb-2">
            {{ __('dashboard.welcome') }}
            <span class="text-rose-600 dark:text-fuchsia-300 font-bold">
                Apt. {{ Auth::user()->name }}
            </span>!
        </h2>

        {{-- / Title --}}

        <p class="text-sm text-rose-600 dark:text-rose-300">
            Jika tampilan terlihat berantakan, silakan lakukan <strong>zoom out</strong> pada browser Anda (Ctrl +
            Scroll atau Ctrl + -).
        </p>
    </div>
    <div class="container">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 my-4">

            <!-- Statistik Hari Ini -->
            <div class="bg-white dark:bg-gray-900 rounded shadow p-6">
                <div class="flex justify-between items-center bg-gray-100 dark:bg-gray-700 rounded px-3 py-2 mb-3">
                    <i class="fas fa-chart-line text-xl text-blue-500"></i>
                    <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-100 text-right">Statistik Hari Ini
                    </h4>
                </div>
                <ul class="text-gray-800 dark:text-gray-100 text-sm space-y-1">
                    <li class="flex justify-between">
                        <span>Total Resep Hari Ini</span>
                        <strong>{{ $totalPrescriptionsToday }}</strong>
                    </li>
                    <li class="flex justify-between">
                        <span>Total Jenis Obat</span>
                        <strong>{{ $totalMedicines }}</strong>
                    </li>
                </ul>
            </div>

            <!-- Obat Stok Rendah -->
            <div class="bg-white dark:bg-gray-900 rounded shadow p-6">
                <div class="flex justify-between items-center bg-gray-100 dark:bg-gray-700 rounded px-3 py-2 mb-3">
                    <i class="fas fa-exclamation-triangle text-xl text-red-500"></i>
                    <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-100 text-right">Obat Stok Rendah</h4>
                </div>
                @if ($lowStockMedicines->isEmpty())
                    <p class="text-sm text-gray-600 dark:text-gray-300">Semua stok obat cukup.</p>
                @else
                    <ul class="list-disc list-inside text-sm text-red-600 dark:text-red-400 space-y-1">
                        @foreach ($lowStockMedicines as $medicine)
                            <li class="flex justify-between">
                                <span>{{ $medicine->name }}</span>
                                <strong>Stok: {{ $medicine->stock }}</strong>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

        </div>


        {{-- Tabel Resep Hari Ini --}}
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow p-6 overflow-x-auto">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-100 mb-4">📋 Daftar Resep Obat Hari Ini</h3>

            @if (count($todayPrescriptions) === 0)
                <div
                    class="flex flex-col items-center justify-center p-6 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 rounded-xl text-yellow-800 dark:text-yellow-300 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mb-3 text-yellow-400 dark:text-yellow-300"
                        viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M12 22c5.421 0 10-4.579 10-10S17.421 2 12 2 2 6.579 2 12s4.579 10 10 10zm0-1.5A8.5 8.5 0 1 1 12 3.5a8.5 8.5 0 0 1 0 17zm0-6a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm1-6.25c0-.414-.336-.75-.75-.75h-1.5a.75.75 0 0 0 0 1.5h.75v3.25a.75.75 0 0 0 1.5 0V8.25z" />
                    </svg>
                    <p class="text-lg font-semibold">Belum ada resep yang dicatat hari ini</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Silakan input resep terlebih dahulu untuk
                        menampilkan data di sini.</p>
                </div>
            @else
                <table class="min-w-full text-sm text-left border border-gray-200 dark:border-gray-700">
                    <thead class="bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-gray-200">
                        <tr>
                            <th class="px-4 py-2 border">Pasien</th>
                            <th class="px-4 py-2 border">Obat</th>
                            <th class="px-4 py-2 border">Aturan Pakai</th>
                            <th class="px-4 py-2 border">Sesudah Makan?</th>
                            <th class="px-4 py-2 border">Catatan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-slate-800 text-gray-700 dark:text-gray-100">
                        @foreach ($todayPrescriptions as $prescription)
                            <tr
                                class="border-t border-gray-200 dark:border-gray-600 hover:bg-blue-50 dark:hover:bg-slate-700 transition">
                                <td class="px-4 py-2 border">{{ $prescription['patient_name'] }}</td>
                                <td class="px-4 py-2 border">{{ $prescription['medicine_name'] }}</td>
                                <td class="px-4 py-2 border">{{ $prescription['rule_of_use'] }}</td>
                                <td class="px-4 py-2 border">
                                    <span
                                        class="{{ $prescription['aftermeal'] ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                        {{ $prescription['aftermeal'] ? 'Ya' : 'Tidak' }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 border">{{ $prescription['notes'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

    </div>

</x-layouts.app>
