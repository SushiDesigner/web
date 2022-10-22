<x-app-layout :title="__('Modify User Permissions')">
    <div class="container">
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible shadow-sm fade show">
                {!! session()->get('success') !!}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible shadow-sm fade show">
                {!! session()->get('error') !!}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
            </div>
        @endif

        <div class="rounded-2 bg-lightish px-3 py-2 mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">{{ __('Admin') }}</a></li>
                    <li class="breadcrumb-item">{{ __('Superadmin Tools') }}</li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Modify User Permissions') }}</li>
                </ol>
            </nav>
        </div>

        <h1 class="fw-bold">{{ __('Modify User Permissions') }}</h1>
        <p>{{ __('A superadmin only utility that allows modification of user permissions. Note that superadmins have every permission by default, and that modifying any permission for them will be rendered moot.') }}
        <div class="border-bottom my-3"></div>

        <div class="card">
            <div class="card-header">{{ __('Permissions') }}</div>
            <div class="card-body">
                <form method="post" action="{{ route('admin.permissions') }}">
                    @csrf

                    @if (!isset($user))
                        <div class="mb-3">
                            <label for="username" class="form-label">{{ __('Username') }}</label>
                            <input type="text" @class(['form-control', 'is-invalid' => $errors->has('username')]) id="username" name="username">

                            @error ('username')
                                <div class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <button class="btn btn-primary" type="submit"><i class="fa-solid fa-disc-drive me-1"></i>{{ __('Load User Permissions') }}</button>
                    @else
                        <div class="mb-3">
                            <span class="h4">{!! __('Viewing <a href=":link"><b>:username</b></a>\'s Permissions', ['username' => e($user->username), 'link' => route('users.profile', $user->id)]) !!}</span> <a href="{{ route('admin.permissions') }}">{{ __('(back)') }}</a>

                            @if ($user->isSuperAdmin())
                                <br>
                                <span class="text-danger d-inline-block mt-1">{{ __('This user is a superadmin.') }}</span>
                            @endif
                        </div>

                        <input type="hidden" name="user" value="{{ $user->id }}">

                        <div class="accordion mb-3">
                            @foreach ($rolesets as $roleset)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading{{ $roleset->basename }}">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $roleset->basename }}" aria-expanded="false" aria-controls="collapse{{ $roleset->basename }}">
                                            {{ $roleset->basename }}
                                        </button>
                                    </h2>

                                    <div id="collapse{{ $roleset->basename }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $roleset->basename }}" data-bs-parent="#accordion{{ $roleset->basename }}">
                                        <div class="accordion-body">
                                            @foreach ($roleset->roles as $rolename => $role)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="{{ $rolename }}" name="permission__{{ $roleset->name }};{{ $rolename }}" @checked($user->may($roleset->name, $role, true))>
                                                    <label class="form-check-label d-block text-truncate" for="{{ $rolename }}">{{ $rolename }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button class="btn btn-success text-light me-1" type="submit">{{ __('Update Permissions') }}</button>
                        <a href="#" class="btn btn-secondary text-light" onclick="document.getElementById('reset').submit()" role="button">{{ __('Reset To Default') }}</a>
                    @endif
                </form>

                @isset ($user)
                    <form method="post" action="{{ route('admin.permissions') }}" id="reset">
                        @csrf
                        <input type="hidden" value="{{ $user->id }}" name="reset_for">
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
