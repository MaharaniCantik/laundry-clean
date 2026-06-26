<x-admin-layout>
    <main
        class="flex-1 md:ml-sidebar-width mt-16 p-container-padding min-h-screen"
    >
        <!-- Page Header & Filters -->
        <div
            class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6 gap-4"
        >
            <div>
                <h2 class="font-headline-lg text-headline-lg text-on-surface">
                    Daftar Order
                </h2>
                <p
                    class="font-body-md text-body-md text-on-surface-variant mt-1"
                >
                    Manage and track all active laundry operations.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <div
                    class="flex items-center gap-2 bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-1.5"
                >
                    <span
                        class="material-symbols-outlined text-[18px] text-on-surface-variant"
                        >calendar_today</span
                    >
                    <div class="flex items-center gap-1">
                        <input
                            type="date"
                            class="bg-transparent border-none p-0 font-body-sm text-body-sm text-on-surface focus:ring-0 outline-none cursor-pointer"
                            aria-label="Start Date"
                        />
                        <span class="text-outline-variant">-</span>
                        <input
                            type="date"
                            class="bg-transparent border-none p-0 font-body-sm text-body-sm text-on-surface focus:ring-0 outline-none cursor-pointer"
                            aria-label="End Date"
                        />
                    </div>
                </div>
                <!-- Status Filter -->
                <select
                    class="bg-surface-container-lowest border border-outline-variant text-on-surface font-body-sm text-body-sm rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none cursor-pointer"
                >
                    <option value="all">All Statuses</option>
                    <option value="pending">Pending</option>
                    <option value="pickup">Pickup</option>
                    <option value="washing">Washing</option>
                    <option value="finished">Finished</option>
                    <option value="delivery">Delivery</option>
                </select>
                <!-- Service Type Filter -->
                <select
                    class="bg-surface-container-lowest border border-outline-variant text-on-surface font-body-sm text-body-sm rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none cursor-pointer"
                >
                    <option value="all">All Services</option>
                    <option value="kiloan">Kiloan</option>
                    <option value="satuan">Satuan</option>
                </select>
                <div class="flex items-center gap-2">
                    <button
                        class="inline-flex items-center gap-1.5 px-3 py-2 bg-surface-container-lowest border border-outline-variant text-on-surface font-label-md text-label-md rounded-lg hover:bg-surface-container-low transition-colors shadow-sm"
                    >
                        <span class="material-symbols-outlined text-[18px]"
                            >description</span
                        >
                        Excel
                    </button>
                    <button
                        class="inline-flex items-center gap-1.5 px-3 py-2 bg-surface-container-lowest border border-outline-variant text-on-surface font-label-md text-label-md rounded-lg hover:bg-surface-container-low transition-colors shadow-sm"
                    >
                        <span class="material-symbols-outlined text-[18px]"
                            >picture_as_pdf</span
                        >
                        PDF
                    </button>
                </div>
            </div>
        </div>
        <!-- Active Orders Table Card -->
        <div
            class="bg-surface-container-lowest rounded-xl shadow-[0_4px_24px_rgba(0,0,0,0.04)] border border-surface-variant/40 overflow-hidden"
        >
            <!-- Table Container for Horizontal Scroll -->
            <div class="w-full overflow-x-auto table-scrollbar">
                <table class="min-w-full text-left text-sm">
                    <thead class="bg-gray-50 text-xs uppercase font-semibold text-on-surface-variant">
                        <tr>
                            <th class="p-4">Customer</th>
                            <th class="p-4">Service & Durasi</th>
                            <th class="p-4">Address & Distance</th>
                            <th class="p-4">Weight & Payment</th>
                            <th class="p-4">Date & Instruksi Driver</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Total Harga</th>
                            <th class="p-4">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/10">
                        @forelse($allOrders as $order)
                        <tr class="hover:bg-surface-container-low/50 transition-colors group">
                            
                            <td class="py-4 px-4">
                                <div class="font-body-sm text-body-sm text-on-surface-variant mb-0.5">#{{ $order->id }}</div>
                                <div class="font-body-md text-body-md font-semibold text-on-surface">{{ $order->nama_pelanggan }}</div>
                                <div class="font-body-sm text-body-sm text-on-surface-variant flex items-center gap-1 mt-0.5">
                                    <span class="material-symbols-outlined text-[14px]">phone</span> 
                                    {{ $order->no_telp ?? 'No Phone' }}
                                </div>
                            </td>
                            
                            <td class="py-4 px-4">
                                <span class="inline-flex items-center px-2 py-1 rounded-md bg-surface-variant text-on-surface font-label-md text-label-md">
                                    {{ $order->jenis_layanan ?? 'Kiloan' }}
                                </span>
                                <div class="font-body-sm text-body-sm text-on-surface-variant mt-1">
                                    {{ $order->berat_laundry ?? 0 }} {{ $order->satuan ?? 'kg' }} - {{ ucfirst($order->tipe_durasi ?? 'Reguler') }}
                                </div>
                            </td>
                            
                            <td class="py-4 px-4 font-body-sm text-body-sm text-on-surface-variant truncate max-w-xs">
                                <div class="text-on-surface font-medium truncate max-w-[180px]" title="{{ $order->alamat_lengkap }}">
                                    {{ $order->alamat_lengkap ?? 'Ambil di Toko' }}
                                </div>
                                <div class="text-xs text-on-surface-variant mt-1">
                                    {{ $order->jarak_km ?? 0 }} km
                                </div>
                            </td>
                            
                            <td class="py-4 px-4">
                                <div class="font-body-sm text-body-sm text-on-surface font-medium">{{ $order->berat_laundry ?? 0 }} kg</div>
                                <span class="text-[10px] font-bold uppercase px-1.5 py-0.5 bg-surface-variant rounded text-on-surface-variant inline-block mt-1">
                                    {{ $order->metode_pembayaran ?? 'Cash' }}
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <div class="font-body-sm text-body-sm text-on-surface font-medium">{{$order->instruksi_driver ?? 'Tidak ada instruksi khusus' }}</div>
                                 <span class="text-[10px] font-bold uppercase px-1.5 py-0.5 bg-surface-variant rounded text-on-surface-variant inline-block mt-1">
                                    {{ $order->jadwal_pickup ?? 'Tidak ada jam' }}
                                </span>
                            </td>
                            
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-2">
                                    @if($order->status == 'Pending Penjemputan' || $order->status == 'Pending')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-surface-container-highest text-on-surface-variant font-label-md text-label-md border border-outline-variant/30">
                                            <span class="w-1.5 h-1.5 rounded-full bg-outline"></span> Pending
                                        </span>
                                    @elseif($order->status == 'Sedang Dijemput' || $order->status == 'Pickup')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-secondary-fixed text-on-secondary-fixed font-label-md text-label-md border border-secondary-fixed-dim/30">
                                            <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span> Pickup
                                        </span>
                                    @elseif($order->status == 'Sedang Diproses' || $order->status == 'Washing')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-primary-fixed text-on-primary-fixed font-label-md text-label-md border border-primary-fixed-dim/30">
                                            <span class="w-1.5 h-1.5 rounded-full bg-primary"></span> Washing
                                        </span>
                                    @elseif($order->status == 'Siap Diantar' || $order->status == 'Deliver')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-blue-100 text-blue-800 font-label-md text-label-md border border-blue-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Deliver
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 font-label-md text-label-md border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> {{ $order->status }}
                                        </span>
                                    @endif
                                    
                                    <span class="material-symbols-outlined text-[18px] text-[#25D366] icon-fill" title="WhatsApp Status">check_circle</span>
                                </div>
                            </td>
                            
                            <td class="py-4 px-4 font-body-md text-body-md text-on-surface font-bold">
                                Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                            </td>
                            
                            <td class="py-4 px-4 text-right">
                                <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    <div class="relative inline-flex items-center rounded-lg bg-surface-container border border-outline-variant px-3 py-1.5 hover:bg-surface-container-high transition-colors shadow-sm">
                                        <select name="status" onchange="this.form.submit()" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer font-label-md text-label-md">
                                            <option value="Pending Penjemputan" {{ $order->status == 'Pending Penjemputan' ? 'selected' : '' }}>To Pending</option>
                                            <option value="Sedang Dijemput" {{ $order->status == 'Sedang Dijemput' ? 'selected' : '' }}>To Pickup</option>
                                            <option value="Sedang Diproses" {{ $order->status == 'Sedang Diproses' ? 'selected' : '' }}>To Washing</option>
                                            <option value="Siap Diantar" {{ $order->status == 'Siap Diantar' ? 'selected' : '' }}>To Deliver</option>
                                            <option value="Selesai" {{ $order->status == 'Selesai' ? 'selected' : '' }}>To Complete</option>
                                        </select>
                                        
                                        <span class="font-label-md text-label-md text-on-surface flex items-center gap-1">
                                            @if($order->status == 'Pending Penjemputan' || $order->status == 'Pending') To Pickup
                                            @elseif($order->status == 'Sedang Dijemput' || $order->status == 'Pickup') To Washing
                                            @elseif($order->status == 'Sedang Diproses' || $order->status == 'Washing') To Deliver
                                            @else Next Step
                                            @endif
                                            <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                                        </span>
                                    </div>
                                </form>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center font-body-sm text-body-sm text-on-surface-variant/60 italic">
                                Tidak ada data orderan dalam periode ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination / Footer -->
            <div
                class="px-6 py-4 border-t border-surface-variant flex items-center justify-between bg-surface-container-lowest"
            >
                <span class="font-body-sm text-body-sm text-on-surface-variant"
                    >Showing 1 to 5 of 24 entries</span
                >
                <div class="flex gap-2">
                    <button
                        class="px-3 py-1 border border-outline-variant rounded-md text-on-surface font-label-md text-label-md hover:bg-surface-container-low disabled:opacity-50"
                        disabled=""
                    >
                        Prev
                    </button>
                    <button
                        class="px-3 py-1 bg-primary text-on-primary rounded-md font-label-md text-label-md hover:bg-primary-container"
                    >
                        1
                    </button>
                    <button
                        class="px-3 py-1 border border-outline-variant rounded-md text-on-surface font-label-md text-label-md hover:bg-surface-container-low"
                    >
                        2
                    </button>
                    <button
                        class="px-3 py-1 border border-outline-variant rounded-md text-on-surface font-label-md text-label-md hover:bg-surface-container-low"
                    >
                        Next
                    </button>
                </div>
            </div>
        </div>
    </main>
</x-admin-layout>
