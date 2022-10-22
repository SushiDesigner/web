<x-app-layout :title="__('Invite Keys')">
    <div class="container">
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible shadow-sm fade show">
                {{ session()->get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible shadow-sm fade show">
                {{ session()->get('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between">
            <h2 class="mb-0">{{ __('Invite Keys') }}</h2>
            @if (config('tadah.users_create_invite_keys'))
                <div class="d-flex align-items-center">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#keyPurchaseModal" @class(['btn btn-success text-light', 'disabled' => $disabled])><i class="fa-solid fa-plus me-1"></i>{{ __('New Invite Key') }}</button>
                </div>
            @endif
        </div>

        <div class="border-bottom my-3"></div>

        <p class="mt-3">
            {{ __(':maximum keys can be created every :cooldown days. Creating a key costs :amount :currency.', ['cooldown' => config('tadah.user_maximum_keys_in_window'), 'maximum' => config('tadah.user_maximum_keys_in_window'), 'amount' => config('tadah.user_invite_key_cost'), 'currency' => config('tadah.currency_name')]) }}

            @if (config('tadah.discord_required'))
                {{ __('You also need a Discord account.') }}
            @endif
        </p>

        <div class="card">
            <div class="card-header">
                {{ __('Keys') }}
            </div>
            <div class="card-body">
                @if ($keys->total() == 0)
                    {{ __('You have not created any keys yet.') }}
                @else
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col" width="60%">{{ __('Key') }}</th>
                                    <th scope="col">{{ __('Created') }}</th>
                                    <th scope="col">{{ __('Last Used') }}</th>
                                    <th scope="col">{{ __('Valid') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($keys as $key)
                                    <tr>
                                        <td width="60%"><code>{{ $key->token }}</code></td>
                                        <td>{{ $key->created_at->format('m/d/y') }}</td>
                                        <td>{{ $key->updated_at->format('m/d/y') }}</td>
                                        <td>{!! $key->isValid() ? __('<span class="fw-bold text-success">Valid</span>') : __('<span class="text-muted">Used</span>') !!}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
           </div>
        </div>

        @if (config('tadah.users_create_invite_keys'))
            <div class="modal fade" id="keyPurchaseModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="row text-center justify-content-center">
                                <div class="justify-content-center">
                                    <i class="fa-regular text-warning fa-triangle-exclamation fa-5x my-4"></i>
                                    <p class="mb-0">{!! __('Are you sure you want to create an invite key? This costs <b>:amount :currency.</b>', ['amount' => e(number_format(config('tadah.user_invite_key_cost'))), 'currency' => e(config('tadah.currency_name'))]) !!}</p>
                                    <p class="text-danger mt-3 mb-0">{!! __('<b>Remember:</b> You will be held accountable for who you invite and what they do.') !!}</p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <form method="POST" action="{{ route('invites') }}">
                                @csrf
                                <button class="btn btn-success text-light" type="submit">{{ __('Purchase') }}</button>
                            </form>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="d-flex justify-content-center">
            {{ $keys->links() }}
        </div>
    </div>
</x-app-layout>
