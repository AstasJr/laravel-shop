@extends('layouts.auth')

@section('title', 'Reset password')

@section('content')
    <x-forms.auth-forms
        title="Reset password"
        action="{{ route('password.update') }}"
        method="POST"
    >
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <x-forms.text-input
            name="email"
            type="email"
            placeholder="E-mail"
            required="true"
            value="{{ request('email') }}"
            :isError="$errors->has('email')">
        </x-forms.text-input>

        @error('email')
        <x-forms.error>
            {{ $message }}
        </x-forms.error>
        @enderror

        <x-forms.text-input
            name="password"
            type="password"
            placeholder="New password"
            required="true"
            :isError="$errors->has('password')">
        </x-forms.text-input>

        @error('password')
            <x-forms.error>
                {{ $message }}
            </x-forms.error>
        @enderror

        <x-forms.text-input
            name="password_confirmation"
            type="password"
            placeholder="Confirm new password"
            required="true"
            :isError="$errors->has('password-confirmation')">
        </x-forms.text-input>

        @error('password-confirmation')
            <x-forms.error>
                {{ $message }}
            </x-forms.error>
        @enderror

        <x-forms.primary-button>
            Update password
        </x-forms.primary-button>

        <x-slot:buttons></x-slot:buttons>
    </x-forms.auth-forms>
@endsection
