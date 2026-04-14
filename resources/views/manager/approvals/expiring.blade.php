@extends('layouts.manager')

@section('title', __('Expiring Contracts'))
@section('page-title', __('Contracts Status'))

@section('content')
<!-- Expiring Soon Section -->
<div class="bg-white rounded-xl shadow-sm mb-6">
    <div class="p-6 border-b border-gray-100">
        <h3 class="font-bold text-gray-800 flex items-center gap-2">
            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ __('Expiring Soon (3 days or less)') }}
        </h3>
    </div>

    @if($expiringBusinesses->count() > 0)
        <div class="divide-y divide-gray-100">
            @foreach($expiringBusinesses as $business)
            @php
                $daysLeft = now()->diffInDays($business->contract_ends_at, false);
            @endphp
            <div class="p-6 hover:bg-gray-50 transition-colors {{ $daysLeft <= 1 ? 'bg-red-50/50' : '' }}">
                <div class="flex flex-col md:flex-row gap-4 items-start">
                    <div class="w-16 h-16 bg-gray-100 rounded-xl flex-shrink-0 overflow-hidden">
                        @if($business->logo)
                            <img src="{{ asset('storage/' . $business->logo) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <div class="flex-1">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-2">
                            <div>
                                <h4 class="font-bold text-gray-800">{{ $business->name }}</h4>
                                <p class="text-sm text-gray-500">{{ $business->category?->name ?? '-' }} • {{ $business->owner?->name ?? __('Unknown') }}</p>
                            </div>
                            <div class="text-right">
                                <span class="inline-block px-3 py-1 rounded-lg text-sm font-bold {{ $daysLeft <= 1 ? 'bg-red-500 text-white' : 'bg-orange-100 text-orange-600' }}">
                                    @if($daysLeft > 0)
                                        {{ $daysLeft }} {{ __('days left') }}
                                    @else
                                        {{ __('Expires today') }}
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div class="mt-3 flex flex-wrap gap-4 text-sm text-gray-600">
                            <span><span class="font-bold">{{ __('Approved') }}:</span> {{ $business->approved_at->format('Y-m-d') }}</span>
                            <span><span class="font-bold">{{ __('Ends') }}:</span> {{ $business->contract_ends_at->format('Y-m-d') }}</span>
                            <span><span class="font-bold">{{ __('By') }}:</span> {{ $business->approvedBy?->name ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('manager.businesses.show', $business) }}" class="bg-brand-green text-white px-4 py-2 rounded-lg text-sm font-bold hover:opacity-90">
                            {{ __('View') }}
                        </a>
                        <form method="POST" action="{{ route('manager.businesses.destroy', $business) }}" onsubmit="return confirm('{{ __('Delete this business?') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-red-600">
                                {{ __('Delete') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="p-4 border-t border-gray-100">
            {{ $expiringBusinesses->links() }}
        </div>
    @else
        <div class="text-center py-8">
            <p class="text-gray-500">{{ __('No contracts expiring soon') }}</p>
        </div>
    @endif
</div>

<!-- Expired Contracts Section -->
<div class="bg-white rounded-xl shadow-sm">
    <div class="p-6 border-b border-gray-100">
        <h3 class="font-bold text-gray-800 flex items-center gap-2">
            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ __('Expired Contracts') }}
        </h3>
    </div>

    @if($expiredBusinesses->count() > 0)
        <div class="divide-y divide-gray-100">
            @foreach($expiredBusinesses as $business)
            <div class="p-6 hover:bg-gray-50 transition-colors opacity-75">
                <div class="flex flex-col md:flex-row gap-4 items-start">
                    <div class="w-16 h-16 bg-gray-100 rounded-xl flex-shrink-0 overflow-hidden grayscale">
                        @if($business->logo)
                            <img src="{{ asset('storage/' . $business->logo) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <div class="flex-1">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-2">
                            <div>
                                <h4 class="font-bold text-gray-800">{{ $business->name }}</h4>
                                <p class="text-sm text-gray-500">{{ $business->category?->name ?? '-' }} • {{ $business->owner?->name ?? __('Unknown') }}</p>
                            </div>
                            <span class="inline-block px-3 py-1 rounded-lg text-sm font-bold bg-red-100 text-red-600">
                                {{ __('Expired') }}
                            </span>
                        </div>

                        <div class="mt-3 flex flex-wrap gap-4 text-sm text-gray-600">
                            <span><span class="font-bold">{{ __('Expired on') }}:</span> {{ $business->contract_ends_at->format('Y-m-d') }}</span>
                            <span><span class="font-bold">{{ __('Contract') }}:</span> {{ $business->contract_duration_days }} {{ __('days') }}</span>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('manager.businesses.show', $business) }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-gray-600">
                            {{ __('View') }}
                        </a>
                        <form method="POST" action="{{ route('manager.businesses.destroy', $business) }}" onsubmit="return confirm('{{ __('Delete this expired business?') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-red-600">
                                {{ __('Delete') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="p-4 border-t border-gray-100">
            {{ $expiredBusinesses->links() }}
        </div>
    @else
        <div class="text-center py-8">
            <p class="text-gray-500">{{ __('No expired contracts') }}</p>
        </div>
    @endif
</div>
@endsection
