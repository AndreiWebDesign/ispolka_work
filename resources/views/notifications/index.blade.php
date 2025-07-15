@foreach ($notifications as $notification)
    <div class="alert alert-info">
        <strong>{{ $notification->data['message'] }}</strong>
        @php $invitation = \App\Models\ProjectInvitation::where('project_id', $notification->data['project_id'])->where('user_id', auth()->id())->first(); @endphp

        @if($invitation && $invitation->status == 'pending')
            <form method="POST" action="{{ route('invitation.accept', $invitation) }}">
                @csrf
                <button type="submit">Принять</button>
            </form>
            <form method="POST" action="{{ route('invitation.decline', $invitation) }}">
                @csrf
                <button type="submit">Отклонить</button>
            </form>
        @endif
    </div>
@endforeach
