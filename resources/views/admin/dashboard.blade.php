
<x-admin-layout>
    <div class="container-fluid">
        <h3>Dashboard</h3>
        
        <main class="pt-24 pb-12 px-4 md:px-container-padding md:ml-[260px] max-w-7xl mx-auto flex flex-col gap-6">
            <div class="flex justify-between items-end mb-2">
                <div>
                    <h2 class="font-headline-lg text-headline-lg text-on-surface">
                        Overview
                    </h2>
                    <p class="font-body-md text-body-md text-on-surface-variant mt-1">
                        Here's what's happening today.
                    </p>
                </div>
                <div class="font-label-md text-label-md text-primary bg-primary/10 px-3 py-1.5 rounded-md flex items-center gap-1 cursor-pointer hover:bg-primary/20 transition-colors">
                    <span class="material-symbols-outlined" style="font-size: 16px">calendar_today</span>
                    Today
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter">
                <div class="bg-surface-container-lowest p-5 rounded-xl ambient-shadow ambient-shadow-hover transition-all duration-300 border border-outline-variant/10 flex flex-col justify-between h-32 relative overflow-hidden group">
                    <div class="flex justify-between items-start">
                        <span class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">New Orders</span>
                        <div class="bg-blue-50 text-secondary p-2 rounded-lg">
                            <span class="material-symbols-outlined" style="font-size: 20px">local_laundry_service</span>
                        </div>
                    </div>
                    <div class="flex items-end justify-between">
                        <p class="font-headline-lg text-headline-lg font-bold text-on-surface mt-2">
                            {{ $newOrdersCount }}
                        </p>
                        <span class="font-body-sm text-body-sm text-emerald-600 flex items-center gap-0.5 bg-emerald-50 px-1.5 py-0.5 rounded">
                            <span class="material-symbols-outlined" style="font-size: 14px">trending_up</span>
                            12%
                        </span>
                    </div>
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-secondary-container to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </div>

                <div class="bg-surface-container-lowest p-5 rounded-xl ambient-shadow ambient-shadow-hover transition-all duration-300 border border-outline-variant/10 flex flex-col justify-between h-32 relative overflow-hidden group">
                    <div class="flex justify-between items-start">
                        <span class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">In Process</span>
                        <div class="bg-amber-50 text-amber-600 p-2 rounded-lg">
                            <span class="material-symbols-outlined" style="font-size: 20px">wash</span>
                        </div>
                    </div>
                    <div class="flex items-end justify-between">
                        <p class="font-headline-lg text-headline-lg font-bold text-on-surface mt-2">
                            {{ $inProcessCount }}
                        </p>
                        <span class="font-body-sm text-body-sm text-on-surface-variant">Washing/Ironing</span>
                    </div>
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-amber-400 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </div>

                <div class="bg-surface-container-lowest p-5 rounded-xl ambient-shadow ambient-shadow-hover transition-all duration-300 border border-outline-variant/10 flex flex-col justify-between h-32 relative overflow-hidden group">
                    <div class="flex justify-between items-start">
                        <span class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Ready for Delivery</span>
                        <div class="bg-emerald-50 text-emerald-600 p-2 rounded-lg">
                            <span class="material-symbols-outlined" style="font-size: 20px">check_circle</span>
                        </div>
                    </div>
                    <div class="flex items-end justify-between">
                        <p class="font-headline-lg text-headline-lg font-bold text-on-surface mt-2">
                            {{ $readyCount }}
                        </p>
                        <span class="font-body-sm text-body-sm text-on-surface-variant">Awaiting drivers</span>
                    </div>
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </div>

                <div class="bg-surface-container-lowest p-5 rounded-xl ambient-shadow ambient-shadow-hover transition-all duration-300 border border-outline-variant/10 flex flex-col justify-between h-32 relative overflow-hidden group">
                    <div class="flex justify-between items-start">
                        <span class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Revenue (Daily)</span>
                        <div class="bg-primary/10 text-primary p-2 rounded-lg">
                            <span class="material-symbols-outlined" style="font-size: 20px">payments</span>
                        </div>
                    </div>
                    <div class="flex items-end justify-between">
                       <p class="font-headline-lg text-headline-lg font-bold text-on-surface mt-2">
                            Rp {{ number_format($todayRevenue, 0, ',', '.') }}
                        </p>
                        <span class="font-body-sm text-body-sm text-emerald-600 flex items-center gap-0.5 bg-emerald-50 px-1.5 py-0.5 rounded">
                            <span class="material-symbols-outlined" style="font-size: 14px">trending_up</span>
                            4.5%
                        </span>
                    </div>
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-primary to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-gutter">
                <div class="lg:col-span-2 bg-surface-container-lowest p-6 rounded-xl ambient-shadow border border-outline-variant/10 flex flex-col">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="font-headline-sm text-headline-sm text-on-surface">Revenue Growth</h3>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">Monthly breakdown</p>
                        </div>
                        <button class="text-on-surface-variant hover:bg-surface-container-low p-1.5 rounded-md transition-colors">
                            <span class="material-symbols-outlined">more_vert</span>
                        </button>
                    </div>
                    <div class="flex-1 flex items-end gap-2 sm:gap-4 h-48 mt-auto pt-4 relative border-b border-outline-variant/30">
                        <div class="absolute left-0 top-0 h-full flex flex-col justify-between text-[10px] text-outline pr-2 pb-6 w-8 text-right bg-surface-container-lowest/80 backdrop-blur z-10">
                            <span>$5k</span><span>$4k</span><span>$3k</span><span>$2k</span><span>$1k</span>
                        </div>
                        <div class="flex-1 h-full flex items-end gap-2 ml-8 pb-6">
                            <div class="flex-1 flex flex-col justify-end items-center group cursor-pointer relative">
                                <div class="w-full bg-secondary-fixed/50 hover:bg-primary transition-colors rounded-t-sm" style="height: 40%"></div>
                                <span class="absolute -bottom-6 text-[10px] text-on-surface-variant font-medium">Mon</span>
                            </div>
                            <div class="flex-1 flex flex-col justify-end items-center group cursor-pointer relative">
                                <div class="w-full bg-secondary-fixed/50 hover:bg-primary transition-colors rounded-t-sm" style="height: 65%"></div>
                                <span class="absolute -bottom-6 text-[10px] text-on-surface-variant font-medium">Tue</span>
                            </div>
                            <div class="flex-1 flex flex-col justify-end items-center group cursor-pointer relative">
                                <div class="w-full bg-secondary-fixed/50 hover:bg-primary transition-colors rounded-t-sm" style="height: 50%"></div>
                                <span class="absolute -bottom-6 text-[10px] text-on-surface-variant font-medium">Wed</span>
                            </div>
                            <div class="flex-1 flex flex-col justify-end items-center group cursor-pointer relative">
                                <div class="w-full bg-secondary-fixed/50 hover:bg-primary transition-colors rounded-t-sm" style="height: 80%"></div>
                                <span class="absolute -bottom-6 text-[10px] text-on-surface-variant font-medium">Thu</span>
                            </div>
                            <div class="flex-1 flex flex-col justify-end items-center group cursor-pointer relative">
                                <div class="w-full bg-primary hover:bg-primary-container transition-colors rounded-t-sm shadow-[0_0_10px_rgba(30,64,175,0.3)]" style="height: 95%"></div>
                                <span class="absolute -bottom-6 text-[10px] text-primary font-bold">Fri</span>
                            </div>
                            <div class="flex-1 flex flex-col justify-end items-center group cursor-pointer relative">
                                <div class="w-full bg-secondary-fixed/50 hover:bg-primary transition-colors rounded-t-sm" style="height: 60%"></div>
                                <span class="absolute -bottom-6 text-[10px] text-on-surface-variant font-medium">Sat</span>
                            </div>
                            <div class="flex-1 flex flex-col justify-end items-center group cursor-pointer relative">
                                <div class="w-full bg-secondary-fixed/50 hover:bg-primary transition-colors rounded-t-sm" style="height: 30%"></div>
                                <span class="absolute -bottom-6 text-[10px] text-on-surface-variant font-medium">Sun</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-surface-container-lowest p-6 rounded-xl ambient-shadow border border-outline-variant/10 flex flex-col h-full max-h-[400px]">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-headline-sm text-headline-sm text-on-surface">Recent Activity</h3>
                    </div>
                    <div class="flex-1 overflow-y-auto pr-2 space-y-6 scrollbar-hide" style="scrollbar-width: none">
                        @forelse($recentActivities as $activity)
                            <div class="flex gap-4 relative">
                                @if(!$loop->last)
                                    <div class="absolute left-[11px] top-6 w-[2px] h-full bg-outline-variant/20 -z-10"></div>
                                @endif
                                
                                <div class="w-6 h-6 rounded-full bg-primary/10 border-2 border-surface-container-lowest flex items-center justify-center shrink-0 mt-0.5">
                                    <span class="material-symbols-outlined text-primary" style="font-size: 12px">local_laundry_service</span>
                                </div>
                                <div>
                                    <p class="font-body-sm text-body-sm text-on-surface">
                                        Pesanan masuk dari <span class="font-semibold">{{ $activity->nama_pelanggan }}</span> sebesar <span class="font-semibold">Rp {{ number_format($activity->total_harga, 0, ',', '.') }}</span>
                                    </p>
                                    <span class="font-label-md text-label-md text-outline block mt-0.5">
                                        Status: {{ $activity->status }} • {{ $activity->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-6 text-on-surface-variant font-body-sm">
                                Belum ada aktivitas pesanan hari ini.
                            </div>
                        @endforelse
                    </div>
                    <button class="w-full mt-4 py-2 font-label-md text-label-md text-primary bg-surface-container-low hover:bg-secondary-fixed transition-colors rounded-lg">
                        View All Activity
                    </button>
                </div>
            </div>
        </main>
    </div>
</x-admin-layout>