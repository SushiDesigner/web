<x-auth-layout :title="__('Account Disabled')" width="email-w">
    @if ($ban->is_termination || $ban->is_poison_ban)
        <h2>{{ __('Account Deleted') }}</h2>
    @elseif ($ban->is_warning)
        <h2>{{ __('Warning') }}</h2>
    @else
        <h2>{{ __('Banned for :duration', ['duration' => $ban->duration]) }}</h2>
    @endif

    <p class="mb-2">
        {!! __('Our content monitors have determined that your behavior at :project has been in violation of our <a href=":link">Terms of Service</a>.', ['project' => config('app.name'), 'link' => route('document', 'tos')]) !!}
    </p>

    <p class="mb-2">
        {!! __('Reviewed: <b>:time</b>', ['time' => e($ban->reviewed)]) !!}
    </p>

    <p class="mb-2">
        {!! __('Moderator Note: <b>:note</b>', ['note' => e($ban->moderator_note)]) !!}
    </p>

    @if (!is_null($ban->offensive_item))
        <div class="card card-body py-2 px-2 mb-2">
            <b>{{ __('Offensive Item:') }}</b>

            <div class="py-2 px-3 offensive-item">
                @parsedown($ban->offensive_item)
            </div>
        </div>
    @endisset

    <p class="mb-2">
        @if ($ban->expired)
            {!! __('You may re-activate your account by agreeing to our <a href=":link">Terms of Service</a>.', ['link' => route('document', 'tos')]) !!}
        @else
            @if ($ban->is_termination)
                {{ __('Your account has been terminated.') }}
            @elseif ($ban->is_poison_ban)
                {{ __('Your account has been terminated, and account creation has been disabled.') }}
            @else
                {{ __('Your account has been disabled for :duration. You may reactivate it after :reactivation.', ['duration' => e($ban->duration), 'reactivation' => e($ban->reactivation_date)]) }}
            @endif
        @endif
    </p>

    @if (!$ban->expired && $ban->is_appealable)
        <p class="mb-2">
            {!! __('If you wish to appeal, please send an email to <a href=":mailto">:email</a>.', ['email' => getInboxAddress(), 'mailto' => 'mailto:' . getInboxAddress()]) !!}
        </p>
    @endif

    <div class="d-flex align-items-center flex-column mt-3">
        @if ($ban->expired)
            <div class="form-check mb-2">
                <input id="agreed" name="agreed" class="form-check-input" type="checkbox">
                <label class="form-check-label" for="agreed">{{ __('I agree') }}</label>
            </div>

            <form method="post" action="{{ route('account.unban') }}">
                @csrf

                <button class="btn btn-primary disabled mb-2" type="submit" id="reactivate">{{ __('Reactivate My Account') }}</a>
            </form>
        @endif

        <form method="post" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-outline-secondary" type="submit">{{ __('Logout') }}</a>
        </form>
    </div>
</x-auth-layout>
