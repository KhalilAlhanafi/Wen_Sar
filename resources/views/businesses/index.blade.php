@extends('layouts.app')

@section('content')
<div class="bg-brand-white min-h-screen pb-12">
    <!-- Search Bar Section -->
    <div class="bg-brand-green py-8 shadow-inner overflow-hidden relative">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/leaf.png')]"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <h1 class="text-white text-2xl font-bold mb-6 flex items-center gap-3">
                <svg class="w-6 h-6 border-2 border-white/20 rounded-full p-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                نتائج البحث عن: <span class="text-orange-400">"{{ request('query') }}"</span>
            </h1>
            <form action="{{ route('business.search') }}" method="GET" class="flex flex-col md:flex-row gap-4 bg-white/10 p-2 rounded-2xl backdrop-blur-sm">
                <div class="flex-1">
                    <input type="text" name="query" value="{{ request('query') }}" placeholder="ماذا تبحث؟" class="w-full border-0 rounded-xl py-3.5 px-6 focus:ring-0 text-gray-800 placeholder-gray-400">
                </div>
                <div class="md:w-64">
                    <select name="district_id" class="w-full border-0 rounded-xl py-3.5 px-4 focus:ring-0 text-gray-800">
                        <option value="">كل المناطق في دمشق</option>
                        @foreach($districts as $district)
                            <option value="{{ $district->id }}" {{ request('district_id') == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-orange-500 text-white font-bold py-3.5 px-10 rounded-xl hover:bg-orange-600 transition shadow-lg active:scale-95">
                    تحديث
                </button>
            </form>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filters -->
            <div class="w-full lg:w-1/4">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-24">
                    <h3 class="font-bold text-gray-800 mb-6 flex items-center">
                        <svg class="w-5 h-5 ml-2 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        تصفية النتائج
                    </h3>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-600 mb-3">التصنيفات</label>
                            <div class="space-y-2 max-h-80 overflow-y-auto pr-2 custom-scrollbar">
                                @foreach($categories as $category)
                                <label class="flex items-center group cursor-pointer p-1 rounded hover:bg-gray-50 transition-colors">
                                    <input type="checkbox" class="rounded text-brand-green focus:ring-brand-green w-4 h-4 border-gray-300">
                                    <span class="mr-3 text-sm text-gray-600 group-hover:text-gray-900 transition-colors">{{ $category->name }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Results List -->
            <div class="w-full lg:w-3/4">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800">
                        النتائج <span class="text-gray-400 font-normal">({{ $businesses->count() }})</span>
                    </h2>
                    <select class="bg-transparent border-none text-sm font-bold text-brand-green focus:ring-0 cursor-pointer">
                        <option>الأكثر صلة</option>
                        <option>الأعلى تقييماً</option>
                        <option>الأحدث</option>
                    </select>
                </div>

                <div class="grid grid-cols-1 gap-6">
                    @forelse($businesses as $business)
                    <div class="bg-white p-4 rounded-2xl shadow-sm hover:shadow-md transition-all border border-gray-100 flex flex-col md:flex-row gap-6 group">
                        <div class="w-full md:w-64 h-48 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0 relative">
                            @if($business->images && count($business->images) > 0)
                                <img src="{{ asset('storage/' . $business->images[0]) }}" alt="{{ $business->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @elseif($business->logo)
                                <img src="{{ asset('storage/' . $business->logo) }}" alt="{{ $business->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                                <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?q=80&w=1974&auto=format&fit=crop" alt="{{ $business->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @endif
                            @if($business->is_featured)
                                <div class="absolute top-2 right-2 bg-orange-500 text-white text-[10px] font-bold px-2 py-0.5 rounded shadow">مميز</div>
                            @endif
                        </div>
                        <div class="flex-1 flex flex-col justify-between py-2">
                            <div>
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-xl font-bold text-gray-800 group-hover:text-brand-green transition-colors">
                                        {{ $business->name }}
                                    </h3>
                                    <div class="flex items-center bg-yellow-50 px-2 py-1 rounded-lg">
                                        <span class="text-sm font-bold text-yellow-700 ml-1">4.5</span>
                                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                    </div>
                                </div>
                                <div class="flex items-center text-gray-500 text-xs gap-4 mb-4 font-bold">
                                    <div class="flex items-center bg-brand-green/5 text-brand-green px-2 py-1 rounded">
                                        <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                        {{ $business->subArea?->name ?? 'غير محدد' }}
                                    </div>
                                    <div class="flex items-center text-gray-400">
                                        <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                        {{ $business->category->name }}
                                    </div>
                                </div>
                                <p class="text-gray-500 text-sm line-clamp-2 leading-relaxed">
                                    {{ Str::limit($business->description, 150) }}
                                </p>
                            </div>
                            <div class="flex justify-between items-center mt-4 pt-4 border-t border-gray-50">
                                <div class="flex items-center gap-4">
                                    <span class="text-xs text-brand-green font-bold flex items-center uppercase tracking-wide">
                                        <span class="w-2 h-2 bg-brand-green rounded-full ml-2 animate-pulse"></span>
                                        مفتوح الآن
                                    </span>
                                    <span class="text-xs text-gray-400 font-medium">
                                        {{ $business->views_count }} مشاهدة
                                    </span>
                                </div>
                                <a href="{{ route('business.show', $business->id) }}" class="text-brand-green font-bold text-sm bg-gray-50 border border-gray-100 px-6 py-2.5 rounded-xl hover:bg-brand-green hover:text-white hover:shadow-lg hover:shadow-brand-green/20 transition-all duration-300">
                                    عرض التفاصيل
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-20 bg-white rounded-2xl shadow-sm border border-dashed border-gray-200">
                        <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-400">عذراً، لم نجد نتائج تطابق بحثك</h3>
                        <p class="text-gray-400 mt-2">جرب البحث بكلمات مختلفة أو في منطقة أخرى</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
