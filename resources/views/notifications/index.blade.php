@extends('layouts.app')

@section('content')

<h3><i class="fas fa-bell me-2"></i>Mes notifications (rappels)</h3>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(auth()->user()->unreadNotifications->count() > 0)
    <form method="POST" action="{{ route('notifications.read-all') }}" class="mb-3 d-inline">
        @csrf
        <button type="submit" class="btn btn-outline-secondary btn-sm">Tout marquer comme lu</button>
    </form>
@endif

<div class="list-group">
    @forelse($notifications as $notification)
        @php $data = $notification->data; @endphp
        <div class="list-group-item {{ $notification->read_at ? '' : 'list-group-item-primary' }}">
            <div class="d-flex w-100 justify-content-between align-items-start">
                <div class="flex-grow-1">
                    <h6 class="mb-1">{{ $data['message'] ?? 'Rappel relance' }}</h6>
                    <p class="mb-1 small text-muted">
                        <strong>Date rappel :</strong> {{ isset($data['date_relance']) ? \Carbon\Carbon::parse($data['date_relance'])->format('d/m/Y') : '' }}
                        @if(!empty($data['motif_relance']))
                            &nbsp;|&nbsp; <strong>Motif :</strong> {{ $data['motif_relance'] }}
                        @endif
                    </p>
                    @if(!empty($data['commentaire']))
                        <p class="mb-0">{{ $data['commentaire'] }}</p>
                    @endif
                </div>
                @if(!$notification->read_at)
                    <form method="POST" action="{{ route('notifications.read', $notification->id) }}" class="ms-2">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-primary">Lu</button>
                    </form>
                @endif
            </div>
            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
        </div>
    @empty
        <p class="text-muted">Aucune notification.</p>
    @endforelse
</div>

<div class="mt-3">
    {{ $notifications->links() }}
</div>

@endsection
