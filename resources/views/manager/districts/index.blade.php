@extends('layouts.manager')

@section('title', __('Districts'))
@section('page-title', __('Districts Management'))

@section('content')
<div class="space-y-6">
    <!-- Search Bar -->
    <div class="bg-white rounded-xl shadow-sm p-4">
        <form method="GET" action="{{ route('manager.districts.index') }}" class="flex gap-3">
            <div class="flex-1 relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Search by district or governorate name...') }}" class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:border-brand-green focus:ring-1 focus:ring-brand-green transition-all">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <button type="submit" class="bg-brand-green text-white font-bold py-2.5 px-6 rounded-xl hover:opacity-90 transition-all">
                {{ __('Search') }}
            </button>
            @if(request('search'))
            <a href="{{ route('manager.districts.index') }}" class="bg-gray-100 text-gray-600 font-bold py-2.5 px-4 rounded-xl hover:bg-gray-200 transition-all">
                {{ __('Clear') }}
            </a>
            @endif
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <p class="text-gray-500">{{ __('Manage districts and their locations') }}</p>
            <a href="{{ route('manager.districts.create') }}" class="bg-brand-green text-white font-bold py-2.5 px-5 rounded-xl hover:opacity-90 transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('Add District') }}
            </a>
        </div>

    @if($districts->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-right text-sm font-bold text-gray-600">{{ __('Name') }}</th>
                        <th class="px-6 py-4 text-right text-sm font-bold text-gray-600">{{ __('Governorate') }}</th>
                        <th class="px-6 py-4 text-center text-sm font-bold text-gray-600">{{ __('Sub Areas') }}</th>
                        <th class="px-6 py-4 text-center text-sm font-bold text-gray-600">{{ __('Businesses') }}</th>
                        <th class="px-6 py-4 text-center text-sm font-bold text-gray-600">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($districts as $district)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-bold text-gray-800">{{ $district->name }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-gray-600">{{ $district->governorate->name }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="bg-purple-100 text-purple-700 text-sm font-bold px-3 py-1 rounded-lg">{{ $district->sub_areas_count }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="bg-green-100 text-green-700 text-sm font-bold px-3 py-1 rounded-lg">{{ $district->businesses_count }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('manager.districts.edit', $district) }}" class="bg-brand-green/10 text-brand-green p-2 rounded-lg hover:bg-brand-green hover:text-white transition-all" title="{{ __('Edit') }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('manager.districts.destroy', $district) }}" onsubmit="return confirm('{{ __('Are you sure? Sub-areas and businesses must be moved or deleted first.') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-100 text-red-600 p-2 rounded-lg hover:bg-red-500 hover:text-white transition-all" title="{{ __('Delete') }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-100">
            {{ $districts->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-600 mb-2">{{ __('No Districts') }}</h3>
            <p class="text-gray-500 mb-4">{{ __('Start by adding your first district') }}</p>
            <a href="{{ route('manager.districts.create') }}" class="bg-brand-green text-white font-bold py-3 px-8 rounded-xl hover:opacity-90 transition-all">
                {{ __('Add District') }}
            </a>
        </div>
    @endif
    </div>
</div>
@endsection
