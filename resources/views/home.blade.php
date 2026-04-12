@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="relative bg-brand-green overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <img src="https://images.unsplash.com/photo-1549136365-5c1a1795f57a?q=80&w=2070&auto=format&fit=crop" alt="Damascus" class="w-full h-full object-cover">
    </div>
    <div class="relative max-w-7xl mx-auto px-4 py-32 sm:px-6 lg:px-8 flex flex-col items-center text-center">
        <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 leading-tight">
            دليلك الشامل في <span class="text-orange-400">دمشق</span>
        </h1>
        <p class="text-xl text-brand-white/80 mb-10 max-w-2xl">
            ابحث عن المحال التجارية، المهن، المدارس، الأطباء وكل ما تحتاجه في دمشق وسوريا.
        </p>

        <!-- Search Box -->
        <div x-data="{ 
                districtId: '', 
                subAreas: [],
                async updateSubAreas() {
                    if(!this.districtId) return;
                    const response = await fetch(`/api/districts/${this.districtId}/sub-areas`);
                    this.subAreas = await response.json();
                }
            }" 
            class="w-full max-w-4xl bg-white p-4 rounded-2xl shadow-2xl grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            
            <form action="{{ route('business.search') }}" method="GET" class="md:contents">
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1 mr-1">المحافظة</label>
                    <select class="w-full border-gray-100 rounded-lg focus:ring-brand-green focus:border-brand-green text-sm bg-gray-50">
                        @foreach($governorates as $gov)
                            <option value="{{ $gov->id }}">{{ $gov->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1 mr-1">المنطقة</label>
                    <select name="district_id" x-model="districtId" @change="updateSubAreas" class="w-full border-gray-100 rounded-lg focus:ring-brand-green focus:border-brand-green text-sm bg-gray-50">
                        <option value="">اختر المنطقة...</option>
                        @if($governorates->first())
                            @foreach($governorates->first()->districts as $district)
                                <option value="{{ $district->id }}">{{ $district->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1 mr-1">التصنيف</label>
                    <select name="category_id" class="w-full border-gray-100 rounded-lg focus:ring-brand-green focus:border-brand-green text-sm bg-gray-50">
                        <option value="">ماذا تبحث؟</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-brand-green text-white font-bold py-3.5 px-6 rounded-xl hover:opacity-90 transition duration-300 shadow-lg">
                    ابحث الآن
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Categories Grid -->
<div class="max-w-7xl mx-auto px-4 py-16 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-10">
        <h2 class="text-3xl font-bold text-gray-800">تصفح حسب التصنيف</h2>
        <a href="#" class="text-brand-green hover:underline font-medium">عرض الكل</a>
    </div>
    
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-6">
        @foreach($categories as $cat)
        <a href="#" class="group bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-brand-green/20 transition-all text-center">
            <div class="w-16 h-16 bg-brand-green/5 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-brand-green transition-colors">
                <!-- Icon Placeholder -->
                <svg class="w-8 h-8 text-brand-green group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h3 class="font-bold text-gray-800 group-hover:text-brand-green transition-colors">{{ $cat->name }}</h3>
            <p class="text-xs text-gray-400 mt-1">{{ rand(50, 200) }} مكان</p>
        </a>
        @endforeach
    </div>
</div>

<!-- Featured Businesses -->
<div class="bg-gray-100 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-10">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">أماكن مميزة</h2>
                <p class="text-gray-500 mt-2">نخبة من أفضل المحال والخدمات في دمشق</p>
            </div>
            <a href="#" class="text-brand-green hover:underline font-medium">عرض المزيد</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredBusinesses as $business)
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-shadow border border-gray-100 group">
                <div class="h-48 bg-gray-200 relative">
                    @if($business->images && count($business->images) > 0)
                        <img src="{{ asset('storage/' . $business->images[0]) }}" alt="{{ $business->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @elseif($business->logo)
                        <img src="{{ asset('storage/' . $business->logo) }}" alt="{{ $business->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?q=80&w=1974&auto=format&fit=crop" alt="{{ $business->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @endif
                    <div class="absolute top-4 right-4 bg-orange-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                        مميز
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-start mb-2">
                        <span class="text-xs font-bold text-brand-green px-2 py-1 bg-brand-green/5 rounded">{{ $business->category->name }}</span>
                        <div class="flex items-center text-yellow-400">
                            <span class="text-xs font-bold text-gray-700 ml-1">4.8</span>
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2 truncate">{{ $business->name }}</h3>
                    <div class="flex items-center text-gray-500 text-sm mb-4">
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        {{ $business->subArea?->name ?? 'غير محدد' }}
                    </div>
                    <div class="flex justify-between items-center border-t border-gray-50 pt-4">
                        <div class="text-xs text-gray-400">
                            <span class="font-bold text-gray-600">{{ $business->views_count }}</span> مشاهدة
                        </div>
                        <a href="#" class="text-brand-green font-bold text-sm flex items-center group-hover:translate-x-[-4px] transition-transform">
                            التفاصيل
                            <svg class="w-4 h-4 mr-1 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
