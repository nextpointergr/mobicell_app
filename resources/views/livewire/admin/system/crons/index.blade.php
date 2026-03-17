<div class="space-y-6">

    {{-- Scheduled Commands --}}
    <div class="card p-6">
        <h2 class="text-lg font-semibold mb-4">Scheduled Commands</h2>

        @forelse($scheduled as $line)
            <div class="text-sm font-mono bg-gray-100 p-2 rounded mb-2">
                {{ $line }}
            </div>
        @empty
            <p class="text-gray-500 text-sm">No scheduled commands found.</p>
        @endforelse
    </div>

    {{-- Queue Stats --}}
    <div class="card p-6">
        <h2 class="text-lg font-semibold mb-4">Queue Status</h2>

        <div class="grid grid-cols-2 gap-4">
            <div class="bg-blue-50 p-4 rounded">
                <p class="text-sm text-gray-600">Pending Jobs</p>
                <p class="text-xl font-bold">{{ $queueStats['pending'] }}</p>
            </div>

            <div class="bg-red-50 p-4 rounded">
                <p class="text-sm text-gray-600">Failed Jobs</p>
                <p class="text-xl font-bold">{{ $queueStats['failed'] }}</p>
            </div>
        </div>
    </div>

</div>
