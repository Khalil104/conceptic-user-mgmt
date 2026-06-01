@php
    $user = (new \App\Http\Controllers\Auth\AuthController())->getAuthenticatedUser(request());
    $unreadCount = $user ? $user->unreadNotifications()->count() : 0;
@endphp

<div class="relative inline-block">
    <a href="{{ route('notifications.index') }}" class="relative p-3 text-gray-700 hover:text-gray-900 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 00-9-5.197V8.5m.002 3.5L12 15l-1.998-3.5" 
            />
        </svg>
        @if($unreadCount> 0) 
            <span class="absolute -top- -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-[10px] font-bold text-white">
                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
            </span>
        @endif
    </a>
</div>