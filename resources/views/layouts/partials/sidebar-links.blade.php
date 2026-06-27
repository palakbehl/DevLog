@php
    $links = [
        [
            'name' => 'Dashboard',
            'url' => url('/dashboard'),
            'active' => request()->is('dashboard'),
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>'
        ],
        [
            'name' => 'Posts',
            'url' => url('/posts'),
            'active' => request()->is('posts*'),
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 4a2 2 0 00-2 2v3m2-3a2 2 0 012 2v3m0 0a2 2 0 01-2 2h-2m-4-7a1 1 0 11-2 0 1 1 0 012 0zM9 9h1m-1 4h1m-4-4h.01M5 13h.01"/></svg>'
        ],
        [
            'name' => 'Projects',
            'url' => url('/projects'),
            'active' => request()->is('projects*'),
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>'
        ],
        [
            'name' => 'Profile',
            'url' => url('/profile'),
            'active' => request()->is('profile*'),
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>'
        ]
    ];
@endphp

<div class="space-y-1">
    @foreach($links as $link)
        <a href="{{ $link['url'] }}" 
           class="group flex items-center px-4 py-2.5 text-sm font-semibold rounded-lg transition-all duration-200 {{ $link['active'] ? 'bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400' : 'text-gray-600 dark:text-zinc-400 hover:bg-gray-50 dark:hover:bg-zinc-800/50 hover:text-gray-900 dark:hover:text-zinc-100' }}">
            <span class="mr-3 shrink-0 {{ $link['active'] ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-400 group-hover:text-gray-500 dark:text-zinc-500 dark:group-hover:text-zinc-300' }}">
                {!! $link['icon'] !!}
            </span>
            {{ $link['name'] }}
        </a>
    @endforeach

    <hr class="my-4 border-gray-200 dark:border-zinc-800">

    <!-- Logout Link -->
    <form method="POST" action="{{ route('logout') }}" id="sidebar-logout-form" class="hidden">
        @csrf
    </form>
    <a href="#" 
       onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();"
       class="group flex items-center px-4 py-2.5 text-sm font-semibold rounded-lg text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/20 transition-all duration-200 cursor-pointer">
        <span class="mr-3 shrink-0 text-red-500 dark:text-red-400 group-hover:text-red-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
        </span>
        Log Out
    </a>
</div>
