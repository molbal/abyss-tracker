@php
    /** @var array $room */
    /** @var int $i */
@endphp

<li class="bookmark">
    <span class="bookmark-label mb-0 pb-3 d-block">
        <h5 class="d-flex justify-content-between align-items-start mb-0">
            <span>Room {{$i+1}}</span>
            <small class='text-sm'>Took {{\App\Http\Controllers\TimeHelper::formatSecondsToMMSS($room['RoomDurationSeconds'])}}</small>
        </h5>
        <div>
            @forelse($room['Spawn'] as $npc)
                <x-telemetry.spawn :npc="\App\Models\Models\Partners\NPC::make($npc['Name'])" :count="$npc['Count']" />
            @empty
                No spawns in this room.
            @endforelse
        </div>
    </span>
</li>
