@if (is_null($user))
    <i class="text-muted">{{ __('Nobody') }}</i>
@else
    <div class="d-flex align-items-center">
        <x-user.headshot :user="$user" width="20px" class="me-2" />
        <a href="{{ route('users.profile', $user->id) }}">{{ $user->username }}</a>
    </div>
@endif
