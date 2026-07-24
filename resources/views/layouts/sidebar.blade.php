<aside class="w-72 bg-white/[0.04] backdrop-blur-3xl border-r border-white/10 flex flex-col justify-between p-6 z-20 shrink-0 hidden md:flex shadow-2xl overflow-y-auto">
    <div class="space-y-6">
        {{-- LOGO BRAND --}}
        <div class="flex items-center gap-3 px-2">
            <img src="{{ asset('images/VetenAplikasi.png') }}" alt="VetenCall Logo" class="h-9 w-auto object-contain">
            <span class="text-xl font-bold tracking-tight text-white">VetenCall</span>
        </div>

        <nav class="space-y-4">
            {{-- TOP MAIN MENU --}}
            <div class="space-y-1">
                <a href="{{ route('dashboard') }}" 
                   class="block px-4 py-2.5 rounded-xl font-medium text-xs transition {{ request()->routeIs('dashboard') ? 'bg-[#2f6bfd]/20 border border-blue-500/30 text-white shadow-lg shadow-blue-600/10' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                    Dashboard
                </a>

                <a href="{{ route('quick.blast') }}" 
                   class="block px-4 py-2.5 rounded-xl font-medium text-xs transition {{ request()->routeIs('quick.blast') ? 'bg-[#2f6bfd]/20 border border-blue-500/30 text-white shadow-lg shadow-blue-600/10' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                    Quick Blast
                </a>

                <a href="{{ route('blast.history') }}" 
                   class="block px-4 py-2.5 rounded-xl font-medium text-xs transition {{ request()->routeIs('blast.history') ? 'bg-[#2f6bfd]/20 border border-blue-500/30 text-white shadow-lg shadow-blue-600/10' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                    Blast History
                </a>
            </div>

            {{-- GARIS PEMISAH --}}
            <div class="border-t border-white/10 pt-3">
                {{-- CATEGORY: WHATSAPP --}}
                <div class="space-y-1">
                    <p class="px-4 text-[9px] font-bold uppercase tracking-wider text-slate-400 mb-1">WhatsApp</p>

                    <a href="{{ route('phonebook') }}" 
                       class="block px-4 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('phonebook') ? 'bg-[#2f6bfd]/20 text-white' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        Phonebook
                    </a>

                    <a href="{{ route('campaigns') }}" 
                       class="block px-4 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('campaigns') ? 'bg-[#2f6bfd]/20 text-white' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        Campaigns
                    </a>

                    <a href="{{ route('wa.groups') }}" 
                       class="block px-4 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('wa.groups') ? 'bg-[#2f6bfd]/20 text-white' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        WA Groups
                    </a>

                    <a href="{{ route('wa.connect') }}" 
                       class="block px-4 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('wa.connect') ? 'bg-[#2f6bfd]/20 text-white' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        Connect Device
                    </a>
                </div>
            </div>

            {{-- GARIS PEMISAH --}}
            <div class="border-t border-white/10 pt-3">
                {{-- CATEGORY: SMS --}}
                <div class="space-y-1">
                    <p class="px-4 text-[9px] font-bold uppercase tracking-wider text-slate-400 mb-1">SMS</p>

                    <a href="{{ route('sms.phonebook') }}" 
                       class="block px-4 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('sms.phonebook') ? 'bg-[#2f6bfd]/20 text-white' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        Phonebook
                    </a>

                    <a href="{{ route('sms.campaigns') }}" 
                       class="block px-4 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('sms.campaigns') ? 'bg-[#2f6bfd]/20 text-white' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        Campaigns
                    </a>

                    <a href="{{ route('sms.autoresponder') }}" 
                       class="block px-4 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('sms.autoresponder') ? 'bg-[#2f6bfd]/20 text-white' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        Auto Responder
                    </a>

                    <a href="{{ route('sms.connect') }}" 
                       class="block px-4 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('sms.connect') ? 'bg-[#2f6bfd]/20 text-white' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        Connect Device
                    </a>
                </div>
            </div>

            {{-- GARIS PEMISAH --}}
            <div class="border-t border-white/10 pt-3">
                {{-- CATEGORY: WEBRTC --}}
                <div class="space-y-1">
                    <p class="px-4 text-[9px] font-bold uppercase tracking-wider text-slate-400 mb-1">WebRTC</p>

                    <a href="{{ route('webrtc.phone') }}" 
                       class="block px-4 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('webrtc.phone') ? 'bg-[#2f6bfd]/20 text-white' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        Text to Speech
                    </a>

                    <a href="{{ route('webrtc.history') }}" 
                       class="block px-4 py-2 rounded-xl font-medium text-xs transition {{ request()->routeIs('webrtc.history') ? 'bg-[#2f6bfd]/20 text-white' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        History Call
                    </a>
                </div>
            </div>

            {{-- GARIS PEMISAH --}}
            <div class="border-t border-white/10 pt-3">
                {{-- SYSTEM SETTINGS --}}
                <a href="{{ route('gateways.settings') }}" 
                   class="block px-4 py-2.5 rounded-xl font-medium text-xs transition {{ request()->routeIs('gateways.settings') ? 'bg-[#2f6bfd]/20 border border-blue-500/30 text-white' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                    Settings
                </a>
            </div>
        </nav>
    </div>

    {{-- LOG OUT --}}
    <div class="space-y-1.5 pt-4 border-t border-white/10">
        <form action="#" method="POST">
            @csrf
            <button type="submit" class="w-full text-left px-4 py-2.5 rounded-xl text-red-400 hover:text-red-300 hover:bg-red-500/10 font-medium text-xs transition">
                Log Out
            </button>
        </form>
    </div>
</aside>