@extends('layouts.manager')

@section('title', __('Governorates'))
@section('page-title', __('Governorates Management'))

@section('content')
<div class="bg-white rounded-xl shadow-sm">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <p class="text-gray-500">{{ __('Manage governorates and their statistics') }}</p>
        <a href="{{ route('manager.governorates.create') }}" class="bg-brand-green text-white font-bold py-2.5 px-5 rounded-xl hover:opacity-90 transition-all flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            {{ __('Add Governorate') }}
        </a>
    </div>

    @if($governorates->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-right text-sm font-bold text-gray-600">{{ __('Name') }}</th>
                        <th class="px-6 py-4 text-center text-sm font-bold text-gray-600">{{ __('Districts') }}</th>
                        <th class="px-6 py-4 text-center text-sm font-bold text-gray-600">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($governorates as $governorate)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-bold text-gray-800">{{ $governorate->name }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="bg-blue-100 text-blue-700 text-sm font-bold px-3 py-1 rounded-lg">{{ $governorate->districts_count }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('manager.governorates.edit', $governorate) }}" class="bg-brand-green/10 text-brand-green p-2 rounded-lg hover:bg-brand-green hover:text-white transition-all" title="{{ __('Edit') }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('manager.governorates.destroy', $governorate) }}" onsubmit="return confirm('{{ __('Are you sure? All districts under this governorate must be deleted first.') }}')">
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
            {{ $governorates->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-600 mb-2">{{ __('No Governorates') }}</h3>
            <p class="text-gray-500 mb-4">{{ __('Start by adding your first governorate') }}</p>
            <a href="{{ route('manager.governorates.create') }}" class="bg-brand-green text-white font-bold py-3 px-8 rounded-xl hover:opacity-90 transition-all">
                {{ __('Add Governorate') }}
            </a>
        </div>
    @endif
</div>
@endsection
