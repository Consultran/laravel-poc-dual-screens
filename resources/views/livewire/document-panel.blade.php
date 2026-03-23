<div class="min-h-[calc(100vh-7rem)]">
    @if ($workOrder)
        {{-- Header --}}
        <div class="bg-white border-b border-gray-200 px-6 py-4">
            <div class="flex items-center gap-3">
                <h1 class="text-xl font-bold text-gray-900">{{ $workOrder->order_number }}</h1>
                <span class="text-gray-400">&middot;</span>
                <span class="text-gray-600">{{ $workOrder->customer_name }}</span>
            </div>
            <p class="text-sm text-gray-400 mt-1">{{ $documents->count() }} document{{ $documents->count() !== 1 ? 's' : '' }}</p>
        </div>

        {{-- Document List --}}
        <div class="p-6">
            <div class="max-w-2xl space-y-3">
                @foreach ($documents as $doc)
                    @php
                        $typeColors = [
                            'certificate' => 'bg-green-100 text-green-700',
                            'registration' => 'bg-blue-100 text-blue-700',
                            'inspection' => 'bg-orange-100 text-orange-700',
                            'application' => 'bg-purple-100 text-purple-700',
                            'filing' => 'bg-indigo-100 text-indigo-700',
                            'contract' => 'bg-pink-100 text-pink-700',
                            'title' => 'bg-cyan-100 text-cyan-700',
                            'report' => 'bg-amber-100 text-amber-700',
                            'receipt' => 'bg-gray-100 text-gray-700',
                            'letter' => 'bg-rose-100 text-rose-700',
                        ];
                    @endphp
                    <div class="bg-white rounded-lg border border-gray-200 p-4 flex items-center gap-4 hover:shadow-sm transition-shadow">
                        {{-- File icon --}}
                        <div class="flex-shrink-0 w-10 h-10 bg-red-50 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>

                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-900">{{ $doc->title }}</p>
                            <p class="text-sm text-gray-400 truncate">{{ $doc->filename }}</p>
                        </div>

                        <span class="text-xs px-2 py-1 rounded-full flex-shrink-0 {{ $typeColors[$doc->document_type] ?? 'bg-gray-100 text-gray-600' }}">
                            {{ ucfirst($doc->document_type) }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        {{-- Empty state --}}
        <div class="flex items-center justify-center h-[calc(100vh-7rem)] text-gray-400">
            <div class="text-center">
                <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                </svg>
                <p class="mt-3 text-lg font-medium text-gray-500">No work order selected</p>
                <p class="mt-1 text-sm">Select a work order in the <strong>Work Orders</strong> tab to view its documents here.</p>
            </div>
        </div>
    @endif

    {{-- Sync status --}}
    <div wire:ignore class="fixed bottom-0 left-0 right-0 bg-gray-100 text-center py-1 text-xs text-gray-500 border-t">
        Last synced: <span id="last-synced">waiting for selection...</span>
    </div>

    @script
    <script>
        const tabId = crypto.randomUUID();
        const channel = new BroadcastChannel('workorder-sync');

        // Listen for work order selections from other tabs
        channel.addEventListener('message', (event) => {
            if (event.data.tabId === tabId) return;
            if (event.data.event === 'work-order-selected') {
                $wire.selectWorkOrder(event.data.workOrderId);
                document.getElementById('last-synced').textContent =
                    'Synced @ ' + new Date().toLocaleTimeString();
            }
        });
    </script>
    @endscript
</div>
