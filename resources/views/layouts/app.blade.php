<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Order Platform — Dual Screen POC</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">
    {{-- Nav Bar --}}
    <nav class="bg-indigo-700 text-white">
        <div class="flex items-center justify-between px-6 py-3">
            <div class="flex items-center gap-6">
                <span class="font-bold text-lg">WorkOrder<span class="font-light">Sync</span></span>
                <div class="flex gap-1">
                    <a href="/"
                       class="px-3 py-1.5 rounded text-sm transition-colors
                           {{ request()->is('/') ? 'bg-indigo-600 text-white' : 'text-indigo-200 hover:text-white hover:bg-indigo-600/50' }}">
                        Work Orders
                    </a>
                    <a href="/documents"
                       class="px-3 py-1.5 rounded text-sm transition-colors
                           {{ request()->is('documents') ? 'bg-indigo-600 text-white' : 'text-indigo-200 hover:text-white hover:bg-indigo-600/50' }}">
                        Documents
                    </a>
                </div>
            </div>
            <div class="text-xs text-indigo-300">
                Open each page in a separate tab &rarr; they stay linked
            </div>
        </div>
    </nav>

    {{ $slot }}
</body>
</html>
