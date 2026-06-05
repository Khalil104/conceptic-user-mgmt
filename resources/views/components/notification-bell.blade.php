@php
    $authController = new \App\Http\Controllers\Auth\AuthController();
    $user = $authController->getAuthenticatedUser(request());
    $unreadCount = $user ? $user->unreadNotifications()->count() : 0;
@endphp

<div class="position-relative d-inline-block">
    <a href="{{ route('notifications.index') }}" class="btn btn-link text-dark p-2 position-relative">
        <i class="bi bi-bell fs-4"></i>
        
        @if($unreadCount > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
            </span>
        @endif
    </a>
</div>