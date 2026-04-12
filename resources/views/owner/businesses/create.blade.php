@extends('layouts.app')

@section('content')
<div class="bg-brand-white min-h-screen pb-12">
    <div class="bg-brand-green py-12 shadow-inner relative overflow-hidden">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-3xl font-bold text-white mb-2">إضافة منشأة جديدة</h1>
            <p class="text-brand-white/70 font-bold">أدخل بيانات منشأتك لتظهر لآلاف الزوار يومياً</p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 py-12 sm:px-6 lg:px-8">
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-50 p-8 md:p-12">
            <form action="{{ route('owner.businesses.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-8">
                    <!-- Basic Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                             <label class="block text-sm font-bold text-gray-700 mb-2">اسم المنشأة</label>
                             <input type="text" name="name" required class="w-full border-gray-100 rounded-2xl py-4 px-6 focus:ring-2 focus:ring-brand-green bg-gray-50 text-gray-800 font-bold" placeholder="مثال: مطعم زيتون، صالون الفخامة...">
                        </div>

                        <div class="md:col-span-2">
                             <label class="block text-sm font-bold text-gray-700 mb-2">الوصف</label>
                             <textarea name="description" rows="4" class="w-full border-gray-100 rounded-2xl py-4 px-6 focus:ring-2 focus:ring-brand-green bg-gray-50 text-gray-800" placeholder="تحدث عن منشأتك والخدمات التي تقدمها..."></textarea>
                        </div>
                    </div>

                    <!-- Location & Category -->
                    <div x-data="{ 
                            districtId: '', 
                            subAreas: [],
                            async updateSubAreas() {
                                if(!this.districtId) return;
                                const response = await fetch(`/api/districts/${this.districtId}/sub-areas`);
                                this.subAreas = await response.json();
                            }
                         }" 
                         class="grid grid-cols-1 md:grid-cols-2 gap-6 p-8 bg-brand-white rounded-3xl border border-gray-50">
                        
                        <div>
                             <label class="block text-sm font-bold text-gray-700 mb-2">المنطقة</label>
                             <select name="district_id" x-model="districtId" @change="updateSubAreas" required class="w-full border-white rounded-2xl py-4 px-6 focus:ring-2 focus:ring-brand-green bg-white shadow-sm text-gray-800 font-bold">
                                 <option value="">اختر المنطقة...</option>
                                 @foreach($governorates->first()->districts as $district)
                                     <option value="{{ $district->id }}">{{ $district->name }}</option>
                                 @endforeach
                             </select>
                        </div>

                        <div>
                             <label class="block text-sm font-bold text-gray-700 mb-2">الحي / المنطقة الفرعية (اختياري)</label>
                             <select name="sub_area_id" class="w-full border-white rounded-2xl py-4 px-6 focus:ring-2 focus:ring-brand-green bg-white shadow-sm text-gray-800 font-bold">
                                 <option value="">اختر الحي...</option>
                                 <template x-for="area in subAreas" :key="area.id">
                                     <option :value="area.id" x-text="area.name"></option>
                                 </template>
                             </select>
                        </div>

                        <div class="md:col-span-2">
                             <label class="block text-sm font-bold text-gray-700 mb-2">التصنيف الرئيسي</label>
                             <select name="category_id" required class="w-full border-white rounded-2xl py-4 px-6 focus:ring-2 focus:ring-brand-green bg-white shadow-sm text-gray-800 font-bold">
                                 <option value="">اختر التصنيف...</option>
                                 @foreach($categories as $category)
                                     <option value="{{ $category->id }}">{{ $category->name }}</option>
                                 @endforeach
                             </select>
                        </div>
                    </div>

                    <!-- Contact -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                             <label class="block text-sm font-bold text-gray-700 mb-2">رقم الهاتف</label>
                             <input type="text" name="phone" dir="ltr" class="w-full border-gray-100 rounded-2xl py-4 px-6 focus:ring-2 focus:ring-brand-green bg-gray-50 text-gray-800 font-bold" placeholder="011-xxxxxxx">
                        </div>
                        <div>
                             <label class="block text-sm font-bold text-gray-700 mb-2">العنوان</label>
                             <input type="text" name="address" class="w-full border-gray-100 rounded-2xl py-4 px-6 focus:ring-2 focus:ring-brand-green bg-gray-50 text-gray-800 font-bold" placeholder="الشارع، المبنى، الطابق...">
                        </div>
                    </div>

                    <!-- Images -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-8 bg-brand-white rounded-3xl border border-gray-50">
                        <div class="md:col-span-2">
                             <label class="block text-sm font-bold text-gray-700 mb-2">صورة الشعار (اختياري)</label>
                             <input type="file" name="logo" accept="image/*" id="logoInput" class="w-full border-gray-100 rounded-2xl py-4 px-6 focus:ring-2 focus:ring-brand-green bg-gray-50 text-gray-800 font-bold">
                             <div id="logoPreview" class="mt-4 relative hidden">
                                 <img src="" alt="Logo Preview" class="w-32 h-32 object-cover rounded-xl border-2 border-gray-200">
                                 <button type="button" onclick="removeLogo()" class="absolute -top-2 -right-2 bg-red-500 text-white w-8 h-8 rounded-full flex items-center justify-center hover:bg-red-600 transition">×</button>
                             </div>
                        </div>
                        <div class="md:col-span-2">
                             <label class="block text-sm font-bold text-gray-700 mb-2">صور إضافية للمحل/المطعم (اختياري)</label>
                             <input type="file" name="images[]" accept="image/*" multiple id="imagesInput" class="w-full border-gray-100 rounded-2xl py-4 px-6 focus:ring-2 focus:ring-brand-green bg-gray-50 text-gray-800 font-bold">
                             <p class="text-xs text-gray-400 mt-2">💡 يمكنك اختيار عدة صور في نفس الوقت (اضغط Ctrl أو Shift للاختيار المتعدد)</p>
                             <div id="imagePreviews" class="mt-4 grid grid-cols-4 gap-4"></div>
                        </div>
                    </div>

                    <script>
                        document.getElementById('logoInput').addEventListener('change', function(e) {
                            const file = e.target.files[0];
                            if (file) {
                                const preview = document.getElementById('logoPreview');
                                const img = preview.querySelector('img');
                                img.src = URL.createObjectURL(file);
                                preview.classList.remove('hidden');
                            }
                        });

                        function removeLogo() {
                            const preview = document.getElementById('logoPreview');
                            const input = document.getElementById('logoInput');
                            preview.classList.add('hidden');
                            input.value = '';
                        }

                        document.getElementById('imagesInput').addEventListener('change', function(e) {
                            const files = e.target.files;
                            const container = document.getElementById('imagePreviews');
                            
                            for (let file of files) {
                                const div = document.createElement('div');
                                div.className = 'relative group';
                                div.innerHTML = `
                                    <img src="${URL.createObjectURL(file)}" class="w-full h-24 object-cover rounded-xl border-2 border-gray-200 group-hover:border-brand-green transition">
                                    <button type="button" onclick="this.parentElement.remove()" class="absolute -top-2 -right-2 bg-red-500 text-white w-6 h-6 rounded-full flex items-center justify-center hover:bg-red-600 transition text-sm">×</button>
                                `;
                                container.appendChild(div);
                            }
                        });
                    </script>

                    <!-- Social Links -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-8 bg-brand-white rounded-3xl border border-gray-50">
                        <div>
                             <label class="block text-sm font-bold text-gray-700 mb-2">فيسبوك (اختياري)</label>
                             <input type="url" name="facebook" dir="ltr" class="w-full border-gray-100 rounded-2xl py-4 px-6 focus:ring-2 focus:ring-brand-green bg-gray-50 text-gray-800 font-bold" placeholder="https://facebook.com/...">
                        </div>
                        <div>
                             <label class="block text-sm font-bold text-gray-700 mb-2">إنستغرام (اختياري)</label>
                             <input type="url" name="instagram" dir="ltr" class="w-full border-gray-100 rounded-2xl py-4 px-6 focus:ring-2 focus:ring-brand-green bg-gray-50 text-gray-800 font-bold" placeholder="https://instagram.com/...">
                        </div>
                    </div>

                    <div class="pt-8">
                        <button type="submit" class="w-full bg-brand-green text-white font-bold py-5 rounded-2xl hover:opacity-90 transition-all shadow-xl shadow-brand-green/20 text-lg">
                            إضافة المنشأة الآن
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
