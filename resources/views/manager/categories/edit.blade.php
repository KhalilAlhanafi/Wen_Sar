@extends('layouts.manager')

@section('title', __('Edit Category'))
@section('page-title', __('Edit Category'))

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm">
        <div class="p-6 border-b border-gray-100">
            <a href="{{ route('manager.categories.index') }}" class="text-gray-500 hover:text-brand-green flex items-center gap-2 mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                {{ __('Back to Categories') }}
            </a>
            <h2 class="text-xl font-bold text-gray-800">{{ __('Edit Category') }}</h2>
            <p class="text-gray-500">{{ __('Update category details') }}</p>
        </div>

        <form method="POST" action="{{ route('manager.categories.update', $category) }}" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Category Name -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Category Name') }} <span class="text-red-500">*</span></label>
                <input type="text" name="name" required 
                       class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-brand-green focus:outline-none transition-colors"
                       placeholder="{{ __('Example: Restaurants, Shops, Services...') }}"
                       value="{{ old('name', $category->name) }}">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Parent Category -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Parent Category') }}</label>
                <select name="parent_id" 
                        class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-brand-green focus:outline-none transition-colors bg-white">
                    <option value="">{{ __('None - Main Category') }}</option>
                    @foreach($parentCategories as $parent)
                        <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                            {{ $parent->name }}
                        </option>
                    @endforeach
                </select>
                <p class="text-sm text-gray-500 mt-2">{{ __('Select a parent to convert this to a subcategory, or clear to make it a main category.') }}</p>
                @error('parent_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Info Box -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <h4 class="font-bold text-blue-800 text-sm">{{ __('Note') }}</h4>
                        <p class="text-blue-600 text-sm">{{ __('If this category has subcategories, you cannot convert it to a subcategory. Move or delete subcategories first.') }}</p>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex gap-3 pt-4">
                <button type="submit" class="flex-1 bg-brand-green text-white font-bold py-3 rounded-xl hover:opacity-90 transition-all">
                    {{ __('Update Category') }}
                </button>
                <a href="{{ route('manager.categories.index') }}" class="px-6 py-3 border-2 border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-50 transition-all">
                    {{ __('Cancel') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
