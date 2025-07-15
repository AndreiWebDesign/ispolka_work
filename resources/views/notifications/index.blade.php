@foreach ($notifications as $notification)
    @php
        $data = $notification->data;
        $invitation = \App\Models\ProjectInvitation::where('passport_id', $data['passport_id'])
            ->where('user_id', auth()->id())
            ->first();
    @endphp

    @if ($invitation)
        <div class="alert alert-info d-flex justify-content-between align-items-center">
            <div>
                <strong>{{ $data['message'] }}</strong><br>
                <small>{{ $notification->created_at->diffForHumans() }}</small>
            </div>

            <form action="{{ route('invitation.accept', $invitation) }}" method="POST" class="d-inline">
                @csrf
                <button class="btn btn-success btn-sm">Принять</button>
            </form>

            <form action="{{ route('invitation.decline', $invitation) }}" method="POST" class="d-inline ms-2">
                @csrf
                <button class="btn btn-outline-danger btn-sm">Отклонить</button>
            </form>
        </div>
    @endif
@endforeach
