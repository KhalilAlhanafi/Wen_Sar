@extends('layouts.manager')

@section('title', __('Edit District'))
@section('page-title', __('Edit District'))

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm">
        <div class="p-6 border-b border-gray-100">
            <a href="{{ route('manager.districts.index') }}" class="text-gray-500 hover:text-brand-green flex items-center gap-2 mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                {{ __('Back to Districts') }}
            </a>
        </div>

        <form method="POST" action="{{ route('manager.districts.update', $district) }}" class="p-6">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('District Name') }} <span class="text-red-500">*</span></label>
                <input type="text" name="name" required value="{{ old('name', $district->name) }}"
                       class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-brand-green focus:outline-none transition-colors"
                       placeholder="{{ __('Enter district name') }}">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Governorate') }} <span class="text-red-500">*</span></label>
                <select name="governorate_id" required
                        class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-brand-green focus:outline-none transition-colors bg-white">
                    @foreach($governorates as $gov)
                        <option value="{{ $gov->id }}" {{ (old('governorate_id', $district->governorate_id) == $gov->id) ? 'selected' : '' }}>{{ $gov->name }}</option>
                    @endforeach
                </select>
                @error('governorate_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit" class="flex-1 bg-brand-green text-white font-bold py-3.5 rounded-xl hover:opacity-90 transition-all">
                    {{ __('Update District') }}
                </button>
                <a href="{{ route('manager.districts.index') }}" class="flex-1 bg-gray-100 text-gray-700 font-bold py-3.5 rounded-xl hover:bg-gray-200 transition-all text-center">
                    {{ __('Cancel') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
