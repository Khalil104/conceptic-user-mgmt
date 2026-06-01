@extends('base')

@section('content')
    <div class="max-w-5-xl mx-auto px-4 py-8 ">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Mes Notifications</h1>
            @if (isset($user) && $user->unreadNotifications()->count() > 0)
                <form action="{{ route('notifications.mark-all-read')}}" method="POST">
                    @csrf
                    <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl transition">
                        Tout marquer comme lu
                    </button>
                </form>
            @endif
        </div>

        @if($notifications->isEmpty())
            <div class="bg-white rounded-2xl shadow p-16 text-center">
                <p class="text-gray-500 text-xl">Vous n'avez aucune notification pour le moment.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach ($notifications as $notification )
                    <div class="bg-white rounded-2xl shadow-sm p-6 {{  $notification->read_at ? 'opacity-75' : 'border-l-4 border-blue-500' }}">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h4 class="font-semibold text-lg text-gray-800">
                                    {{ $notification->data['title'] ?? 'Notification' }}
                                </h4>
                                <p class="text-gray-600 mt-2 leading-relaxed">
                                    {{ $notification->data['message'] }}
                                </p>
                            </div>

                            @if (!$notification->read_at)
                                <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="ml-4">
                                    @csrf
                                    <button type="submit" class="text-blue-600 hover:text-blue-700 font-medium text-sm whitespace-nowrap">
                                        Marquer comme lu
                                    </button>
                                </form>
                            @endif
                        </div>
                        
                        <p class="text-xs text-gray-400 mt-4">
                            {{ $notification->created_at->diffForHumans() }}
                        </p>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{$notifications->links() }}
            </div>
        @endif
    </div>
@endsection