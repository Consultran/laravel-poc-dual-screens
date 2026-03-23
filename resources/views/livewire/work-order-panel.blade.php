<div class="flex h-[calc(100vh-7rem)]">
    {{-- Left Panel: Work Order List --}}
    <div class="w-80 border-r border-gray-200 overflow-y-auto bg-white flex-shrink-0">
        <div class="p-3 border-b border-gray-200 bg-gray-50">
            <h2 class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Work Orders</h2>
        </div>
        <ul>
            @foreach ($workOrders as $wo)
                <li>
                    <button
                        wire:click="selectWorkOrder({{ $wo->id }})"
                        class="w-full text-left px-4 py-3 border-b border-gray-100 hover:bg-indigo-50 transition-colors
                            {{ $selectedWorkOrderId === $wo->id ? 'bg-indigo-50 border-l-4 border-l-indigo-600' : '' }}"
                    >
                        <div class="flex items-center justify-between">
                            <span class="font-mono text-sm font-semibold text-gray-800">{{ $wo->order_number }}</span>
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'in_progress' => 'bg-blue-100 text-blue-800',
                                    'completed' => 'bg-green-100 text-green-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                ];
                            @endphp
                            <span class="text-xs px-2 py-0.5 rounded-full {{ $statusColors[$wo->status] ?? 'bg-gray-100 text-gray-600' }}">
                                {{ str_replace('_', ' ', ucfirst($wo->status)) }}
                            </span>
                        </div>
                        <div class="text-sm text-gray-500 mt-1 truncate">{{ $wo->customer_name }}</div>
                    </button>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- Right Panel: Work Order Detail --}}
    <div class="flex-1 overflow-y-auto bg-gray-50 p-6">
        @if ($selectedWorkOrder)
            <div class="max-w-2xl">
                <div class="flex items-center gap-3 mb-1">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $selectedWorkOrder->order_number }}</h1>
                    @php $sc = $statusColors[$selectedWorkOrder->status] ?? 'bg-gray-100 text-gray-600'; @endphp
                    <span class="text-sm px-3 py-1 rounded-full {{ $sc }}">
                        {{ str_replace('_', ' ', ucfirst($selectedWorkOrder->status)) }}
                    </span>
                </div>
                <p class="text-lg text-gray-600 mb-6">{{ $selectedWorkOrder->customer_name }}</p>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 space-y-4">
                    <div>
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Description</label>
                        <p class="text-gray-700 mt-1">{{ $selectedWorkOrder->description }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Due Date</label>
                            <p class="text-gray-700 mt-1">{{ $selectedWorkOrder->due_date?->format('M j, Y') ?? 'No date set' }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Documents</label>
                            <p class="text-gray-700 mt-1">{{ $selectedWorkOrder->documents()->count() }} attached</p>
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Created</label>
                        <p class="text-gray-700 mt-1">{{ $selectedWorkOrder->created_at->format('M j, Y g:i A') }}</p>
                    </div>
                </div>
            </div>
        @else
            <div class="flex items-center justify-center h-full text-gray-400">
                <div class="text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="mt-2 text-sm">Select a work order to view details</p>
                </div>
            </div>
        @endif
    </div>

    @script
    <script>
        const tabId = crypto.randomUUID();
        const channel = new BroadcastChannel('workorder-sync');
        let isRefreshing = false;

        // After selecting a work order, broadcast to other tabs
        Livewire.hook('commit', ({ succeed }) => {
            succeed(() => {
                if (isRefreshing) {
                    isRefreshing = false;
                    return;
                }
                // Only broadcast if we have a selected work order
                const workOrderId = $wire.selectedWorkOrderId;
                if (workOrderId) {
                    channel.postMessage({
                        event: 'work-order-selected',
                        workOrderId: workOrderId,
                        tabId: tabId,
                        timestamp: Date.now(),
                    });
                }
            });
        });

        // Listen for selections from other tabs (e.g., another WO tab)
        channel.addEventListener('message', (event) => {
            if (event.data.tabId === tabId) return;
            if (event.data.event === 'work-order-selected') {
                isRefreshing = true;
                $wire.selectWorkOrder(event.data.workOrderId);
            }
        });
    </script>
    @endscript
</div>
