<aside class="w-72 bg-white/[0.04] backdrop-blur-3xl border-r border-white/10 flex flex-col justify-between p-5 z-20 shrink-0 hidden md:flex shadow-2xl overflow-y-auto">
    <div class="space-y-5">
        {{-- LOGO BRAND --}}
        <div class="flex items-center gap-3 px-2 pt-1">
            <img src="{{ asset('images/VetenAplikasi.png') }}" alt="VetenCall Logo" class="h-8 w-auto object-contain drop-shadow-sm">
            <div>
                <span class="text-lg font-bold tracking-tight text-[#2f6bfd] block leading-none">VetenCall</span>
                <span class="text-[9px] uppercase tracking-widest text-slate-400 font-semibold mt-1 block">Omni-Channel Suite</span>
            </div>
        </div>

        {{-- USER & SIP MINI STATUS WIDGET --}}
        <div class="nm-card-sm p-3 rounded-2xl bg-white/[0.02] border border-black/5 dark:border-white/5 flex items-center justify-between">
            <a href="{{ route('profile.edit') }}" title="Buka Pengaturan Profil & Keamanan" class="flex items-center gap-2.5 min-w-0 flex-1 hover:opacity-80 transition group">
                <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-[#2f6bfd] to-indigo-600 flex items-center justify-center font-bold text-white text-xs shadow-md shadow-blue-500/20 shrink-0 group-hover:scale-105 transition-transform">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
                </div>
                <div class="min-w-0">
                    <div class="flex items-center gap-1.5">
                        <p class="text-xs font-bold text-slate-800 dark:text-white truncate leading-tight group-hover:text-[#2f6bfd] transition-colors">{{ auth()->user()->name ?? 'User' }}</p>
                    </div>
                    <div class="flex items-center gap-1.5 mt-1">
                        <span class="text-[10px] font-semibold px-1.5 py-0.5 rounded-md leading-none {{ auth()->user()->role_badge_class }}">{{ auth()->user()->role_label }}</span>
                        <span class="text-slate-300 dark:text-slate-600 text-[10px] leading-none">•</span>
                        <span class="text-[10px] text-slate-500 dark:text-slate-400 font-medium leading-none">Ext: <span class="font-mono text-emerald-500 font-bold">{{ auth()->user()->asterisk_exten ?? 'SIP' }}</span></span>
                    </div>
                </div>
            </a>
            <a href="{{ route('webrtc.phone') }}" title="Buka Softphone" class="p-1.5 rounded-lg text-slate-400 hover:text-[#2f6bfd] hover:bg-blue-500/10 transition shrink-0 ml-1">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
            </a>
        </div>

        <nav class="space-y-3">
            {{-- MAIN SHORTCUTS --}}
            <div class="space-y-1">
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center px-3.5 py-2.5 rounded-xl font-medium text-xs transition {{ request()->routeIs('dashboard') ? 'bg-[#2f6bfd] text-white shadow-lg shadow-blue-600/25 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">
                    <svg class="w-4 h-4 mr-2.5 shrink-0 opacity-80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>

                @if(auth()->user()->canAccess('quick_blast'))
                <a href="{{ route('quick.blast') }}" 
                   class="flex items-center px-3.5 py-2.5 rounded-xl font-medium text-xs transition {{ request()->routeIs('quick.blast') ? 'bg-[#2f6bfd] text-white shadow-lg shadow-blue-600/25 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">
                    <svg class="w-4 h-4 mr-2.5 shrink-0 opacity-80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    Quick Blast
                </a>
                @endif

                @if(auth()->user()->canAccess('blast_history'))
                <a href="{{ route('blast.history') }}" 
                   class="flex items-center px-3.5 py-2.5 rounded-xl font-medium text-xs transition {{ request()->routeIs('blast.history') ? 'bg-[#2f6bfd] text-white shadow-lg shadow-blue-600/25 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">
                    <svg class="w-4 h-4 mr-2.5 opacity-75" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Blast History
                </a>
                @endif
            </div>

            {{-- CATEGORY: WHATSAPP --}}
            <div class="border-t border-black/5 dark:border-white/10 pt-2">
                @php $isWaOpen = request()->routeIs('phonebook', 'campaigns', 'wa.groups', 'wa.connect', 'autoresponder*'); @endphp
                <div class="space-y-1">
                    <button type="button" onclick="toggleSidebarMenu(this)" class="w-full flex items-center justify-between px-3.5 py-1.5 hover:bg-black/5 dark:hover:bg-white/5 rounded-xl transition cursor-pointer">
                        <div class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-wider text-emerald-500">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            <span>WhatsApp</span>
                        </div>
                        <svg class="w-3.5 h-3.5 text-slate-400 dark:text-slate-400 transition-transform duration-300 accordion-icon {{ $isWaOpen ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                    </button>

                    <div class="sidebar-accordion accordion-content {{ $isWaOpen ? 'is-open' : '' }}" data-is-open="{{ $isWaOpen ? 'true' : 'false' }}">
                        <div class="overflow-hidden min-h-0">
                            <div class="space-y-0.5 pl-3 pt-1">
                                <a href="{{ route('phonebook') }}" class="flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('phonebook') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">
                                    <svg class="w-3.5 h-3.5 mr-2 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                    Phonebook
                                </a>
                                @if(auth()->user()->canAccess('campaigns'))
                                <a href="{{ route('campaigns') }}" class="flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('campaigns') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">
                                    <svg class="w-3.5 h-3.5 mr-2 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                                    Campaigns
                                </a>
                                @endif
                                @if(auth()->user()->canAccess('auto_responder'))
                                <a href="{{ route('autoresponder.index') }}" class="flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('autoresponder*') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">
                                    <svg class="w-3.5 h-3.5 mr-2 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    Auto Responder
                                </a>
                                @endif
                                <a href="{{ route('wa.groups') }}" class="flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('wa.groups') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">
                                    <svg class="w-3.5 h-3.5 mr-2 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    WA Groups
                                </a>
                                @if(auth()->user()->canAccess('connect_device'))
                                <a href="{{ route('wa.connect') }}" class="flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('wa.connect') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">
                                    <svg class="w-3.5 h-3.5 mr-2 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                    Connect Device
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CATEGORY: SMS --}}
            <div class="border-t border-black/5 dark:border-white/10 pt-2">
                @php $isSmsOpen = request()->routeIs('sms.phonebook', 'sms.campaigns', 'sms.connect'); @endphp
                <div class="space-y-1">
                    <button type="button" onclick="toggleSidebarMenu(this)" class="w-full flex items-center justify-between px-3.5 py-1.5 hover:bg-black/5 dark:hover:bg-white/5 rounded-xl transition cursor-pointer">
                        <div class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-wider text-cyan-500">
                            <span class="w-1.5 h-1.5 rounded-full bg-cyan-500"></span>
                            <span>SMS Gateway</span>
                        </div>
                        <svg class="w-3.5 h-3.5 text-slate-400 dark:text-slate-400 transition-transform duration-300 accordion-icon {{ $isSmsOpen ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                    </button>

                    <div class="sidebar-accordion accordion-content {{ $isSmsOpen ? 'is-open' : '' }}" data-is-open="{{ $isSmsOpen ? 'true' : 'false' }}">
                        <div class="overflow-hidden min-h-0">
                            <div class="space-y-0.5 pl-3 pt-1">
                                <a href="{{ route('sms.phonebook') }}" class="flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('sms.phonebook') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">
                                    <svg class="w-3.5 h-3.5 mr-2 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                    Phonebook
                                </a>
                                @if(auth()->user()->canAccess('campaigns'))
                                <a href="{{ route('sms.campaigns') }}" class="flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('sms.campaigns') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">
                                    <svg class="w-3.5 h-3.5 mr-2 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                                    SMS Campaigns
                                </a>
                                @endif
                                @if(auth()->user()->canAccess('sms_gateway_config'))
                                <a href="{{ route('sms.connect') }}" class="flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('sms.connect') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">
                                    <svg class="w-3.5 h-3.5 mr-2 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                    Connect SMS
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CATEGORY: WEBRTC & VOIP --}}
            <div class="border-t border-black/5 dark:border-white/10 pt-2">
                @php $isWebrtcOpen = request()->routeIs('webrtc.phone', 'webrtc.history', 'voip.users.index', 'tts.campaigns*', 'tts.phonebook*'); @endphp
                <div class="space-y-1">
                    <button type="button" onclick="toggleSidebarMenu(this)" class="w-full flex items-center justify-between px-3.5 py-1.5 hover:bg-black/5 dark:hover:bg-white/5 rounded-xl transition cursor-pointer">
                        <div class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-wider text-violet-500">
                            <span class="w-1.5 h-1.5 rounded-full bg-violet-500"></span>
                            <span>VoIP & WebRTC</span>
                        </div>
                        <svg class="w-3.5 h-3.5 text-slate-400 dark:text-slate-400 transition-transform duration-300 accordion-icon {{ $isWebrtcOpen ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                    </button>

                    <div class="sidebar-accordion accordion-content {{ $isWebrtcOpen ? 'is-open' : '' }}" data-is-open="{{ $isWebrtcOpen ? 'true' : 'false' }}">
                        <div class="overflow-hidden min-h-0">
                            <div class="space-y-0.5 pl-3 pt-1">
                                <a href="{{ route('webrtc.phone') }}" class="flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('webrtc.phone') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">
                                    <svg class="w-3.5 h-3.5 mr-2 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    Softphone Dialpad
                                </a>
                                <a href="{{ route('tts.phonebook') }}" class="flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('tts.phonebook*') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">
                                    <svg class="w-3.5 h-3.5 mr-2 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                    VoIP / TTS Phonebook
                                </a>
                                @if(auth()->user()->canAccess('tts_campaigns'))
                                <a href="{{ route('tts.campaigns') }}" class="flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('tts.campaigns*') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">
                                    <svg class="w-3.5 h-3.5 mr-2 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/></svg>
                                    TTS Voice Campaigns
                                </a>
                                @endif
                                <a href="{{ route('webrtc.history') }}" class="flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('webrtc.history') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">
                                    <svg class="w-3.5 h-3.5 mr-2 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Call History
                                </a>
                                @if(auth()->user()->canAccess('sip_user_config'))
                                <a href="{{ route('voip.users.index') }}" class="flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('voip.users.index') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">
                                    <svg class="w-3.5 h-3.5 mr-2 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    SIP Extension Users
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CATEGORY: CRM & MARKETING TOOLS --}}
            @if(auth()->user()->canAccess('crm_pipeline') || auth()->user()->canAccess('templates'))
            <div class="border-t border-black/5 dark:border-white/10 pt-2">
                @php $isCrmOpen = request()->routeIs('media.*', 'templates.*', 'links.*', 'blacklist', 'leads.*', 'pipeline'); @endphp
                <div class="space-y-1">
                    <button type="button" onclick="toggleSidebarMenu(this)" class="w-full flex items-center justify-between px-3.5 py-1.5 hover:bg-black/5 dark:hover:bg-white/5 rounded-xl transition cursor-pointer">
                        <div class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-wider text-amber-500">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                            <span>CRM & Marketing</span>
                        </div>
                        <svg class="w-3.5 h-3.5 text-slate-400 dark:text-slate-400 transition-transform duration-300 accordion-icon {{ $isCrmOpen ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                    </button>

                    <div class="sidebar-accordion accordion-content {{ $isCrmOpen ? 'is-open' : '' }}" data-is-open="{{ $isCrmOpen ? 'true' : 'false' }}">
                        <div class="overflow-hidden min-h-0">
                            <div class="space-y-0.5 pl-3 pt-1">
                                @if(auth()->user()->canAccess('crm_pipeline'))
                                <a href="{{ route('pipeline') }}" class="flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('pipeline') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">
                                    <svg class="w-3.5 h-3.5 mr-2 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/></svg>
                                    Sales Pipeline
                                </a>
                                <a href="{{ route('leads.index') }}" class="flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('leads.*') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">
                                    <svg class="w-3.5 h-3.5 mr-2 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                                    Lead Scoring
                                </a>
                                @endif
                                <a href="{{ route('templates.index') }}" class="flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('templates.*') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">
                                    <svg class="w-3.5 h-3.5 mr-2 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    Templates
                                </a>
                                @if(auth()->user()->canAccess('media_library'))
                                <a href="{{ route('media.index') }}" class="flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('media.*') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">
                                    <svg class="w-3.5 h-3.5 mr-2 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    Media Library
                                </a>
                                <a href="{{ route('links.index') }}" class="flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('links.*') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">
                                    <svg class="w-3.5 h-3.5 mr-2 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                    Link Tracker
                                </a>
                                <a href="{{ route('blacklist') }}" class="flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('blacklist') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">
                                    <svg class="w-3.5 h-3.5 mr-2 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                    Blacklist DNC
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </nav>
    </div>

    {{-- BOTTOM ACTIONS --}}
    <div class="space-y-1.5 pt-3 border-t border-black/5 dark:border-white/10">
        {{-- Theme Toggle --}}
        <button id="sidebar-theme-btn" onclick="toggleTheme()" class="w-full flex items-center px-3.5 py-2 rounded-xl text-slate-500 hover:text-slate-800 hover:bg-black/5 dark:text-slate-300 dark:hover:text-white dark:hover:bg-white/5 font-medium text-xs transition gap-2.5">
            <span id="theme-icon" class="flex items-center">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
            </span>
            <span id="theme-text">Dark Mode</span>
        </button>

        {{-- TEAM & ROLES MANAGEMENT (Owner Only) --}}
        @if(auth()->user()->canAccess('team_management'))
        <a href="{{ route('team.index') }}" 
           class="w-full flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('team.*') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-purple-600 dark:text-purple-400 hover:bg-purple-500/10' }}">
            <svg class="w-4 h-4 mr-2.5 shrink-0 opacity-90 {{ request()->routeIs('team.*') ? 'text-white' : 'text-purple-500' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            <span>Kelola Tim & Roles</span>
        </a>
        @endif

        {{-- PROFILE & SECURITY --}}
        <a href="{{ route('profile.edit') }}" 
           class="w-full flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('profile.edit') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-slate-500 hover:text-slate-800 hover:bg-black/5 dark:text-slate-300 dark:hover:text-white dark:hover:bg-white/5' }}">
            <svg class="w-4 h-4 mr-2.5 shrink-0 opacity-80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            Profile & Security
        </a>

        {{-- SYSTEM SETTINGS (Owner Only) --}}
        @if(auth()->user()->canAccess('connect_device'))
        <a href="{{ route('gateways.settings') }}" 
           class="w-full flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('gateways.settings') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-slate-500 hover:text-slate-800 hover:bg-black/5 dark:text-slate-300 dark:hover:text-white dark:hover:bg-white/5' }}">
            <svg class="w-4 h-4 mr-2.5 shrink-0 opacity-80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Gateways & Settings
        </a>
        @endif

        <form action="{{ route('logout') }}" method="POST" onsubmit="sessionStorage.removeItem('auth_active');">
            @csrf
            <button type="submit" class="w-full flex items-center text-left px-3.5 py-2 rounded-xl font-medium text-xs transition text-red-500 hover:text-red-600 hover:bg-red-500/10 dark:text-red-400">
                <svg class="w-4 h-4 mr-2.5 shrink-0 opacity-80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Log Out
            </button>
        </form>
    </div>
</aside>

{{-- MOBILE SIDEBAR BACKDROP --}}
<div id="mobile-sidebar-backdrop" onclick="toggleMobileMenu()" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40 hidden md:hidden transition-opacity duration-300"></div>

{{-- MOBILE SIDEBAR DRAWER --}}
<aside id="mobile-sidebar" class="fixed top-0 left-0 bottom-0 w-72 bg-white dark:bg-[#070d1f] border-r border-black/10 dark:border-white/10 flex flex-col justify-between p-5 z-50 md:hidden shadow-2xl overflow-y-auto transform -translate-x-full transition-transform duration-300 ease-in-out">
    <div class="space-y-5">
        {{-- MOBILE LOGO BRAND & CLOSE BUTTON --}}
        <div class="flex items-center justify-between px-2">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/VetenAplikasi.png') }}" alt="VetenCall Logo" class="h-8 w-auto object-contain">
                <div>
                    <span class="text-lg font-bold tracking-tight text-[#2f6bfd] block leading-none">VetenCall</span>
                    <span class="text-[9px] uppercase tracking-widest text-slate-400 font-semibold mt-1 block">Omni-Channel Suite</span>
                </div>
            </div>
            <button onclick="toggleMobileMenu()" class="text-slate-400 hover:text-slate-600 dark:hover:text-white p-1 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- USER & SIP MINI STATUS WIDGET --}}
        <div class="p-3 rounded-2xl bg-black/[0.03] dark:bg-white/[0.03] border border-black/5 dark:border-white/5 flex items-center justify-between">
            <div class="flex items-center gap-2.5 min-w-0">
                <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-[#2f6bfd] to-indigo-600 flex items-center justify-center font-bold text-white text-xs shadow-md shadow-blue-500/20 shrink-0">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-bold text-slate-800 dark:text-white truncate leading-tight">{{ auth()->user()->name ?? 'User' }}</p>
                    <div class="flex items-center gap-1.5 mt-1">
                        <span class="text-[10px] font-semibold px-1.5 py-0.5 rounded-md leading-none {{ auth()->user()->role_badge_class }}">{{ auth()->user()->role_label }}</span>
                        <span class="text-slate-300 dark:text-slate-600 text-[10px] leading-none">•</span>
                        <span class="text-[10px] text-slate-500 dark:text-slate-400 font-medium leading-none">Ext: <span class="font-mono text-emerald-500 font-bold">{{ auth()->user()->asterisk_exten ?? 'SIP' }}</span></span>
                    </div>
                </div>
            </div>
            <a href="{{ route('webrtc.phone') }}" title="Buka Softphone" class="p-1.5 rounded-lg text-slate-400 hover:text-[#2f6bfd] hover:bg-blue-500/10 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
            </a>
        </div>

        <nav class="space-y-3">
            {{-- TOP MAIN MENU --}}
            <div class="space-y-1">
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center px-3.5 py-2.5 rounded-xl font-medium text-xs transition {{ request()->routeIs('dashboard') ? 'bg-[#2f6bfd] text-white shadow-lg shadow-blue-600/25 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">
                    <svg class="w-4 h-4 mr-2.5 shrink-0 opacity-80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>

                @if(auth()->user()->canAccess('quick_blast'))
                <a href="{{ route('quick.blast') }}" 
                   class="flex items-center px-3.5 py-2.5 rounded-xl font-medium text-xs transition {{ request()->routeIs('quick.blast') ? 'bg-[#2f6bfd] text-white shadow-lg shadow-blue-600/25 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">
                    <svg class="w-4 h-4 mr-2.5 shrink-0 opacity-80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    Quick Blast
                </a>
                @endif

                @if(auth()->user()->canAccess('blast_history'))
                <a href="{{ route('blast.history') }}" 
                   class="flex items-center px-3.5 py-2.5 rounded-xl font-medium text-xs transition {{ request()->routeIs('blast.history') ? 'bg-[#2f6bfd] text-white shadow-lg shadow-blue-600/25 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">
                    <svg class="w-4 h-4 mr-2.5 opacity-75" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Blast History
                </a>
                @endif
            </div>

            {{-- WHATSAPP --}}
            <div class="border-t border-black/5 dark:border-white/10 pt-2">
                @php $isWaOpen = request()->routeIs('phonebook', 'campaigns', 'wa.groups', 'wa.connect', 'autoresponder*'); @endphp
                <div class="space-y-1">
                    <button type="button" onclick="toggleSidebarMenu(this)" class="w-full flex items-center justify-between px-3.5 py-1.5 hover:bg-black/5 dark:hover:bg-white/5 rounded-xl transition cursor-pointer">
                        <div class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-wider text-emerald-500">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            <span>WhatsApp</span>
                        </div>
                        <svg class="w-3.5 h-3.5 text-slate-400 dark:text-slate-400 transition-transform duration-300 accordion-icon {{ $isWaOpen ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                    </button>

                    <div class="sidebar-accordion accordion-content {{ $isWaOpen ? 'is-open' : '' }}">
                        <div class="overflow-hidden min-h-0">
                            <div class="space-y-0.5 pl-3 pt-1">
                                <a href="{{ route('phonebook') }}" class="flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('phonebook') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">Phonebook</a>
                                @if(auth()->user()->canAccess('campaigns'))
                                <a href="{{ route('campaigns') }}" class="flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('campaigns') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">Campaigns</a>
                                @endif
                                @if(auth()->user()->canAccess('auto_responder'))
                                <a href="{{ route('autoresponder.index') }}" class="flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('autoresponder*') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">Auto Responder</a>
                                @endif
                                <a href="{{ route('wa.groups') }}" class="flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('wa.groups') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">WA Groups</a>
                                @if(auth()->user()->canAccess('connect_device'))
                                <a href="{{ route('wa.connect') }}" class="flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('wa.connect') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">Connect Device</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SMS --}}
            <div class="border-t border-black/5 dark:border-white/10 pt-2">
                @php $isSmsOpen = request()->routeIs('sms.phonebook', 'sms.campaigns', 'sms.connect'); @endphp
                <div class="space-y-1">
                    <button type="button" onclick="toggleSidebarMenu(this)" class="w-full flex items-center justify-between px-3.5 py-1.5 hover:bg-black/5 dark:hover:bg-white/5 rounded-xl transition cursor-pointer">
                        <div class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-wider text-cyan-500">
                            <span class="w-1.5 h-1.5 rounded-full bg-cyan-500"></span>
                            <span>SMS Gateway</span>
                        </div>
                        <svg class="w-3.5 h-3.5 text-slate-400 dark:text-slate-400 transition-transform duration-300 accordion-icon {{ $isSmsOpen ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                    </button>

                    <div class="sidebar-accordion accordion-content {{ $isSmsOpen ? 'is-open' : '' }}">
                        <div class="overflow-hidden min-h-0">
                            <div class="space-y-0.5 pl-3 pt-1">
                                <a href="{{ route('sms.phonebook') }}" class="flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('sms.phonebook') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">Phonebook</a>
                                @if(auth()->user()->canAccess('campaigns'))
                                <a href="{{ route('sms.campaigns') }}" class="flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('sms.campaigns') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">SMS Campaigns</a>
                                @endif
                                @if(auth()->user()->canAccess('sms_gateway_config'))
                                <a href="{{ route('sms.connect') }}" class="flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('sms.connect') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">Connect SMS</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- WEBRTC --}}
            <div class="border-t border-black/5 dark:border-white/10 pt-2">
                @php $isWebrtcOpen = request()->routeIs('webrtc.phone', 'webrtc.history', 'voip.users.index', 'tts.campaigns*', 'tts.phonebook*'); @endphp
                <div class="space-y-1">
                    <button type="button" onclick="toggleSidebarMenu(this)" class="w-full flex items-center justify-between px-3.5 py-1.5 hover:bg-black/5 dark:hover:bg-white/5 rounded-xl transition cursor-pointer">
                        <div class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-wider text-violet-500">
                            <span class="w-1.5 h-1.5 rounded-full bg-violet-500"></span>
                            <span>VoIP & WebRTC</span>
                        </div>
                        <svg class="w-3.5 h-3.5 text-slate-400 dark:text-slate-400 transition-transform duration-300 accordion-icon {{ $isWebrtcOpen ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                    </button>

                    <div class="sidebar-accordion accordion-content {{ $isWebrtcOpen ? 'is-open' : '' }}">
                        <div class="overflow-hidden min-h-0">
                            <div class="space-y-0.5 pl-3 pt-1">
                                <a href="{{ route('webrtc.phone') }}" class="flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('webrtc.phone') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">Softphone Dialpad</a>
                                <a href="{{ route('tts.phonebook') }}" class="flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('tts.phonebook*') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">VoIP / TTS Phonebook</a>
                                @if(auth()->user()->canAccess('tts_campaigns'))
                                <a href="{{ route('tts.campaigns') }}" class="flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('tts.campaigns*') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">TTS Voice Campaigns</a>
                                @endif
                                <a href="{{ route('webrtc.history') }}" class="flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('webrtc.history') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">Call History</a>
                                @if(auth()->user()->canAccess('sip_user_config'))
                                <a href="{{ route('voip.users.index') }}" class="flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('voip.users.index') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">SIP Extension Users</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CRM & TOOLS --}}
            @if(auth()->user()->canAccess('crm_pipeline') || auth()->user()->canAccess('templates'))
            <div class="border-t border-black/5 dark:border-white/10 pt-2">
                @php $isCrmOpen = request()->routeIs('media.*', 'templates.*', 'links.*', 'blacklist', 'leads.*', 'pipeline'); @endphp
                <div class="space-y-1">
                    <button type="button" onclick="toggleSidebarMenu(this)" class="w-full flex items-center justify-between px-3.5 py-1.5 hover:bg-black/5 dark:hover:bg-white/5 rounded-xl transition cursor-pointer">
                        <div class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-wider text-amber-500">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                            <span>CRM & Marketing</span>
                        </div>
                        <svg class="w-3.5 h-3.5 text-slate-400 dark:text-slate-400 transition-transform duration-300 accordion-icon {{ $isCrmOpen ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                    </button>

                    <div class="sidebar-accordion accordion-content {{ $isCrmOpen ? 'is-open' : '' }}">
                        <div class="overflow-hidden min-h-0">
                            <div class="space-y-0.5 pl-3 pt-1">
                                @if(auth()->user()->canAccess('crm_pipeline'))
                                <a href="{{ route('pipeline') }}" class="flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('pipeline') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">Sales Pipeline</a>
                                <a href="{{ route('leads.index') }}" class="flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('leads.*') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">Lead Scoring</a>
                                @endif
                                <a href="{{ route('templates.index') }}" class="flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('templates.index') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">Templates</a>
                                @if(auth()->user()->canAccess('media_library'))
                                <a href="{{ route('media.index') }}" class="flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('media.index') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">Media Library</a>
                                <a href="{{ route('links.index') }}" class="flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('links.index') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">Link Tracker</a>
                                <a href="{{ route('blacklist') }}" class="flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('blacklist') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">Blacklist DNC</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </nav>
    </div>

    {{-- MOBILE BOTTOM ACTIONS --}}
    <div class="space-y-1.5 pt-3 border-t border-black/5 dark:border-white/10">
        <button onclick="toggleTheme()" class="w-full flex items-center px-3.5 py-2 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-black/5 dark:hover:bg-white/5 font-medium text-xs transition gap-2.5">
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
            <span>Toggle Theme</span>
        </button>

        @if(auth()->user()->canAccess('team_management'))
        <a href="{{ route('team.index') }}" class="w-full flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('team.*') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-purple-600 dark:text-purple-400 hover:bg-purple-500/10' }}">
            <svg class="w-4 h-4 mr-2.5 shrink-0 opacity-90 {{ request()->routeIs('team.*') ? 'text-white' : 'text-purple-500' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            <span>Kelola Tim & Roles</span>
        </a>
        @endif

        <a href="{{ route('profile.edit') }}" class="w-full flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('profile.edit') ? 'bg-[#2f6bfd] text-white shadow-md shadow-blue-600/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:bg-black/5 dark:hover:bg-white/5' }}">
            <svg class="w-4 h-4 mr-2.5 shrink-0 opacity-80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            Profile & Security
        </a>

        @if(auth()->user()->canAccess('connect_device'))
        <a href="{{ route('gateways.settings') }}" class="w-full flex items-center px-3.5 py-2 rounded-xl font-medium text-xs transition text-slate-600 dark:text-slate-300 hover:bg-black/5 dark:hover:bg-white/5">
            <svg class="w-4 h-4 mr-2.5 shrink-0 opacity-80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Gateways & Settings
        </a>
        @endif

        <form action="{{ route('logout') }}" method="POST" onsubmit="sessionStorage.removeItem('auth_active');">
            @csrf
            <button type="submit" class="w-full flex items-center text-left px-3.5 py-2 rounded-xl font-medium text-xs transition text-red-500 dark:text-red-400 hover:bg-red-500/10">
                <svg class="w-4 h-4 mr-2.5 shrink-0 opacity-80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Log Out
            </button>
        </form>
    </div>
</aside>

<style>
    .sidebar-accordion {
        display: grid;
        grid-template-rows: 0fr;
        transition: grid-template-rows 300ms ease-in-out;
    }
    .sidebar-accordion.is-open {
        grid-template-rows: 1fr;
    }
</style>
<script>
    function toggleSidebarMenu(button) {
        const content = button.nextElementSibling;
        const icon = button.querySelector('.accordion-icon');
        
        if (!content.classList.contains('is-open')) {
            content.classList.add('is-open');
            if (icon) icon.classList.add('rotate-180');
        } else {
            content.classList.remove('is-open');
            if (icon) icon.classList.remove('rotate-180');
        }
    }
</script>