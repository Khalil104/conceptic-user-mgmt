@extends('base')

@section('title', 'Notifications - Conceptic')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">
            <i class="bi bi-bell me-2"></i>Mes Notifications
        </h2>
        
        @if(isset($user) && $user->unreadNotifications()->count() > 0)
            <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-all"></i> Tout marquer comme lu
                </button>
            </form>
        @endif
    </div>

    @if($notifications->isEmpty())
        <div class="alert alert-info text-center py-5">
            <i class="bi bi-inbox display-4 d-block mb-3"></i>
            <h5>Aucune notification pour le moment</h5>
            <p class="mb-0">Vous serez notifié lors des changements importants sur votre compte.</p>
        </div>
    @else
        <div class="list-group">
            @foreach($notifications as $notification)
                <div class="list-group-item list-group-item-action {{ $notification->read_at ? 'opacity-75' : 'border-start border-4 border-primary' }}">
                    <div class="d-flex w-100 justify-content-between">
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-semibold">
                                {{ $notification->data['title'] ?? 'Notification' }}
                            </h6>
                            <p class="mb-1 text-muted">
                                {{ $notification->data['message'] }}
                            </p>
                        </div>
                        
                        @if(!$notification->read_at)
                            <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="ms-3">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-primary">
                                    Marquer lu
                                </button>
                            </form>
                        @endif
                    </div>
                    <small class="text-muted">
                        {{ $notification->created_at->diffForHumans() }}
                    </small>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $notifications->links() }}
        </div>
    @endif
</div>
@endsection