@forelse($calls as $call)
    <tr class="hover:bg-white/[0.02] transition-colors group">
        <td class="p-5 font-bold text-white">{{ $call->caller }}</td>
        <td class="p-5 text-slate-300">{{ $call->recipient }}</td>
        <td class="p-5 text-slate-300">{{ $call->duration }}</td>
        <td class="p-5 text-slate-400">{{ $call->created_at->format('M d, Y h:i A') }}</td>
        <td class="p-5">
            @if(strtolower($call->status) === 'answered')
                <span class="px-2.5 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 font-semibold text-[10px]">{{ $call->status }}</span>
            @elseif(strtolower($call->status) === 'no answer' || strtolower($call->status) === 'failed')
                <span class="px-2.5 py-1 rounded-full bg-red-500/10 border border-red-500/30 text-red-400 font-semibold text-[10px]">{{ $call->status }}</span>
            @else
                <span class="px-2.5 py-1 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-400 font-semibold text-[10px]">{{ $call->status }}</span>
            @endif

            @if(!empty($call->transcript))
                <button onclick="toggleTranscript('transcript-{{ $call->id }}')" class="ml-2 px-2.5 py-1 rounded-full bg-blue-500/10 border border-blue-500/30 text-blue-400 hover:bg-blue-500/20 font-semibold text-[10px] transition">
                    View Transcript
                </button>
            @endif
        </td>
    </tr>
    @if(!empty($call->transcript))
    <tr id="transcript-{{ $call->id }}" class="hidden bg-white/[0.01]">
        <td colspan="5" class="p-5 border-t border-dashed border-white/10">
            <div class="p-4 bg-[#070d1f] rounded-xl border border-white/5">
                <h4 class="text-xs font-bold text-blue-400 mb-2">Speech-to-Text Transcript</h4>
                <div class="text-xs leading-relaxed space-y-2 mt-1">
                    @foreach(explode("\n", str_replace('\n', "\n", $call->transcript)) as $line)
                        @if(strpos($line, ':') !== false)
                            @php
                                [$speaker, $text] = explode(':', $line, 2);
                            @endphp
                            <div class="flex items-start gap-2">
                                <span class="font-bold text-blue-400 bg-blue-500/10 px-2 py-0.5 rounded text-[10px] whitespace-nowrap">{{ trim($speaker) }}</span>
                                <span class="text-slate-300">{{ trim($text) }}</span>
                            </div>
                        @else
                            <div class="italic text-slate-400">{{ trim($line) }}</div>
                        @endif
                    @endforeach
                </div>
            </div>
        </td>
    </tr>
    @endif
@empty
    <tr>
        <td colspan="5" class="p-10 text-center text-slate-500">
            Belum ada riwayat panggilan.
        </td>
    </tr>
@endforelse
