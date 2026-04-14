@extends('layouts.manager')

@section('title', __('Add Manager'))
@section('page-title', __('Create New Manager Account'))

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm">
        <div class="p-6 border-b border-gray-100">
            <p class="text-gray-500">{{ __('Create a new manager account with secure dual-password authentication.') }}</p>
        </div>

        <form method="POST" action="{{ route('manager.managers.store') }}" class="p-6 space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-bold text-gray-700 mb-2">{{ __('Full Name') }} <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-brand-green focus:ring-2 focus:ring-brand-green/20 outline-none transition-all"
                    placeholder="{{ __('Enter full name') }}">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Username -->
            <div>
                <label for="username" class="block text-sm font-bold text-gray-700 mb-2">{{ __('Username') }} <span class="text-red-500">*</span></label>
                <input type="text" id="username" name="username" value="{{ old('username') }}" required
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-brand-green focus:ring-2 focus:ring-brand-green/20 outline-none transition-all font-mono"
                    placeholder="{{ __('Enter username (letters, numbers, underscore)') }}"
                    pattern="[a-zA-Z0-9_]+">
                <p class="text-xs text-gray-500 mt-1">{{ __('Only letters, numbers, and underscores allowed. Cannot be changed later.') }}</p>
                @error('username')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password 1 -->
            <div class="bg-blue-50 rounded-xl p-4 border border-blue-100">
                <h4 class="font-bold text-blue-800 mb-3">{{ __('First Password') }}</h4>
                
                <div class="mb-4">
                    <label for="password_1" class="block text-sm font-bold text-gray-700 mb-2">{{ __('Password') }} <span class="text-red-500">*</span></label>
                    <input type="password" id="password_1" name="password_1" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-brand-green focus:ring-2 focus:ring-brand-green/20 outline-none transition-all"
                        placeholder="{{ __('Enter first password') }}">
                    <p class="text-xs text-gray-500 mt-1">{{ __('Min 12 characters, must include uppercase, lowercase, number, and symbol.') }}</p>
                    @error('password_1')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_1_confirmation" class="block text-sm font-bold text-gray-700 mb-2">{{ __('Confirm Password') }} <span class="text-red-500">*</span></label>
                    <input type="password" id="password_1_confirmation" name="password_1_confirmation" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-brand-green focus:ring-2 focus:ring-brand-green/20 outline-none transition-all"
                        placeholder="{{ __('Confirm first password') }}">
                </div>
            </div>

            <!-- Password 2 -->
            <div class="bg-green-50 rounded-xl p-4 border border-green-100">
                <h4 class="font-bold text-green-800 mb-3">{{ __('Second Password') }}</h4>
                
                <div class="mb-4">
                    <label for="password_2" class="block text-sm font-bold text-gray-700 mb-2">{{ __('Password') }} <span class="text-red-500">*</span></label>
                    <input type="password" id="password_2" name="password_2" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-brand-green focus:ring-2 focus:ring-brand-green/20 outline-none transition-all"
                        placeholder="{{ __('Enter second password') }}">
                    <p class="text-xs text-gray-500 mt-1">{{ __('Min 12 characters, must include uppercase, lowercase, number, and symbol. Must be different from first password.') }}</p>
                    @error('password_2')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_2_confirmation" class="block text-sm font-bold text-gray-700 mb-2">{{ __('Confirm Password') }} <span class="text-red-500">*</span></label>
                    <input type="password" id="password_2_confirmation" name="password_2_confirmation" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-brand-green focus:ring-2 focus:ring-brand-green/20 outline-none transition-all"
                        placeholder="{{ __('Confirm second password') }}">
                </div>
            </div>

            <!-- Active Status -->
            <div class="flex items-center gap-3">
                <input type="checkbox" id="is_active" name="is_active" value="1" checked
                    class="w-5 h-5 text-brand-green rounded border-gray-300 focus:ring-brand-green">
                <label for="is_active" class="text-gray-700 font-medium">{{ __('Active (can login immediately)') }}</label>
            </div>

            <!-- Security Notice -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <div class="text-sm text-yellow-800">
                        <p class="font-bold mb-1">{{ __('Security Notice') }}</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li>{{ __('Both passwords must be different for security') }}</li>
                            <li>{{ __('Passwords must be at least 12 characters with mixed case, numbers, and symbols') }}</li>
                            <li>{{ __('This action will be logged for security audit') }}</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                <a href="{{ route('manager.managers.index') }}" class="px-6 py-3 text-gray-600 font-bold hover:text-gray-800 transition-colors">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" class="bg-brand-green text-white font-bold py-3 px-8 rounded-xl hover:opacity-90 transition-all">
                    {{ __('Create Manager') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
