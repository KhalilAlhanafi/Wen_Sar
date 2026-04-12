@extends('layouts.app')

@section('content')
<div class="bg-brand-white min-h-screen pb-12">
    <div class="bg-brand-green py-12 shadow-inner relative overflow-hidden">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-3xl font-bold text-white mb-2">تعديل بيانات المنشأة</h1>
            <p class="text-brand-white/70 font-bold">تحديث معلومات "{{ $business->name }}"</p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 py-12 sm:px-6 lg:px-8">
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-50 p-8 md:p-12">
            <form action="{{ route('owner.businesses.update', $business->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="space-y-8">
                    <!-- Basic Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                             <label class="block text-sm font-bold text-gray-700 mb-2">اسم المنشأة</label>
                             <input type="text" name="name" value="{{ $business->name }}" required class="w-full border-gray-100 rounded-2xl py-4 px-6 focus:ring-2 focus:ring-brand-green bg-gray-50 text-gray-800 font-bold">
                        </div>

                        <div class="md:col-span-2">
                             <label class="block text-sm font-bold text-gray-700 mb-2">الوصف</label>
                             <textarea name="description" rows="4" class="w-full border-gray-100 rounded-2xl py-4 px-6 focus:ring-2 focus:ring-brand-green bg-gray-50 text-gray-800">{{ $business->description }}</textarea>
                        </div>
                    </div>

                    <!-- Location & Category -->
                    <div x-data="{ 
                            districtId: '{{ $business->district_id }}', 
                            subAreaId: '{{ $business->sub_area_id ?? '' }}',
                            subAreas: [],
                            async updateSubAreas() {
                                if(!this.districtId) return;
                                const response = await fetch(`/api/districts/${this.districtId}/sub-areas`);
                                this.subAreas = await response.json();
                            }
                         }" 
                         x-init="updateSubAreas()"
                         class="grid grid-cols-1 md:grid-cols-2 gap-6 p-8 bg-brand-white rounded-3xl border border-gray-50">
                        
                        <div>
                             <label class="block text-sm font-bold text-gray-700 mb-2">المنطقة</label>
                             <select name="district_id" x-model="districtId" @change="updateSubAreas" required class="w-full border-white rounded-2xl py-4 px-6 focus:ring-2 focus:ring-brand-green bg-white shadow-sm text-gray-800 font-bold">
                                 @foreach($governorates->first()->districts as $district)
                                     <option value="{{ $district->id }}" {{ $business->district_id == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                                 @endforeach
                             </select>
                        </div>

                        <div>
                             <label class="block text-sm font-bold text-gray-700 mb-2">الحي / المنطقة الفرعية (اختياري)</label>
                             <select name="sub_area_id" x-model="subAreaId" class="w-full border-white rounded-2xl py-4 px-6 focus:ring-2 focus:ring-brand-green bg-white shadow-sm text-gray-800 font-bold">
                                 <option value="">اختر الحي...</option>
                                 <template x-for="area in subAreas" :key="area.id">
                                     <option :value="area.id" x-text="area.name"></option>
                                 </template>
                             </select>
                        </div>

                        <div class="md:col-span-2">
                             <label class="block text-sm font-bold text-gray-700 mb-2">التصنيف الرئيسي</label>
                             <select name="category_id" required class="w-full border-white rounded-2xl py-4 px-6 focus:ring-2 focus:ring-brand-green bg-white shadow-sm text-gray-800 font-bold">
                                 @foreach($categories as $category)
                                     <option value="{{ $category->id }}" {{ $business->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                 @endforeach
                             </select>
                        </div>
                    </div>

                    <!-- Contact -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                             <label class="block text-sm font-bold text-gray-700 mb-2">رقم الهاتف</label>
                             <input type="text" name="phone" value="{{ $business->phone }}" dir="ltr" class="w-full border-gray-100 rounded-2xl py-4 px-6 focus:ring-2 focus:ring-brand-green bg-gray-50 text-gray-800 font-bold">
                        </div>
                        <div>
                             <label class="block text-sm font-bold text-gray-700 mb-2">العنوان</label>
                             <input type="text" name="address" value="{{ $business->address ?? '' }}" class="w-full border-gray-100 rounded-2xl py-4 px-6 focus:ring-2 focus:ring-brand-green bg-gray-50 text-gray-800 font-bold" placeholder="الشارع، المبنى، الطابق...">
                        </div>
                    </div>

                    <!-- Images -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-8 bg-brand-white rounded-3xl border border-gray-50" data-storage-url="{{ asset('storage/') }}">
                        <div class="md:col-span-2">
                             <label class="block text-sm font-bold text-gray-700 mb-2">صورة الشعار (اختياري)</label>
                             <input type="file" name="logo" accept="image/*" id="logoInput" class="w-full border-gray-100 rounded-2xl py-4 px-6 focus:ring-2 focus:ring-brand-green bg-gray-50 text-gray-800 font-bold">
                             <input type="hidden" name="images_to_delete" id="imagesToDelete" value="">
                             <div id="logoPreview" class="mt-4 relative hidden">
                                 <img src="" alt="Logo Preview" class="w-32 h-32 object-cover rounded-xl border-2 border-gray-200">
                                 <button type="button" onclick="removeLogo()" class="absolute -top-2 -right-2 bg-red-500 text-white w-8 h-8 rounded-full flex items-center justify-center hover:bg-red-600 transition">×</button>
                             </div>
                             @if($business->logo)
                                 <div id="existingLogo" class="mt-4 relative">
                                     <img src="{{ asset('storage/' . $business->logo) }}" alt="Existing Logo" class="w-32 h-32 object-cover rounded-xl border-2 border-gray-200">
                                     <button type="button" onclick="deleteExistingLogo()" class="absolute -top-2 -right-2 bg-red-500 text-white w-8 h-8 rounded-full flex items-center justify-center hover:bg-red-600 transition">×</button>
                                 </div>
                             @endif
                        </div>
                        <div class="md:col-span-2">
                             <label class="block text-sm font-bold text-gray-700 mb-2">صور إضافية للمحل/المطعم (اختياري)</label>
                             <input type="file" name="images[]" accept="image/*" multiple id="imagesInput" class="w-full border-gray-100 rounded-2xl py-4 px-6 focus:ring-2 focus:ring-brand-green bg-gray-50 text-gray-800 font-bold">
                             <p class="text-xs text-gray-400 mt-2">💡 يمكنك اختيار عدة صور في نفس الوقت (اضغط Ctrl أو Shift للاختيار المتعدد)</p>
                             <div id="imagePreviews" class="mt-4 grid grid-cols-4 gap-4">
                                 @if($business->images && count($business->images) > 0)
                                     @foreach($business->images as $index => $image)
                                     <div class="relative group existing-image" data-path="{{ $image }}">
                                         <img src="{{ asset('storage/' . $image) }}" alt="Existing Image" class="w-full h-24 object-cover rounded-xl border-2 border-gray-200 group-hover:border-brand-green transition">
                                         <button type="button" onclick="deleteExistingImage(this)" class="absolute -top-2 -right-2 bg-red-500 text-white w-6 h-6 rounded-full flex items-center justify-center hover:bg-red-600 transition text-sm">×</button>
                                     </div>
                                     @endforeach
                                 @endif
                             </div>
                        </div>
                    </div>

                    <script>
                        const imagesSection = document.querySelector('[data-storage-url]');
                        const storageUrl = imagesSection ? imagesSection.dataset.storageUrl : '/storage/';

                        document.getElementById('logoInput').addEventListener('change', function(e) {
                            const file = e.target.files[0];
                            if (file) {
                                const preview = document.getElementById('logoPreview');
                                const img = preview.querySelector('img');
                                img.src = URL.createObjectURL(file);
                                preview.classList.remove('hidden');
                                const existing = document.getElementById('existingLogo');
                                if (existing) existing.remove();
                            }
                        });

                        function removeLogo() {
                            const preview = document.getElementById('logoPreview');
                            const input = document.getElementById('logoInput');
                            preview.classList.add('hidden');
                            input.value = '';
                        }

                        function deleteExistingLogo() {
                            document.getElementById('existingLogo').remove();
                        }

                        document.getElementById('imagesInput').addEventListener('change', function(e) {
                            const files = e.target.files;
                            const container = document.getElementById('imagePreviews');
                            
                            for (let file of files) {
                                const div = document.createElement('div');
                                div.className = 'relative group new-image';
                                const img = document.createElement('img');
                                img.src = URL.createObjectURL(file);
                                img.className = 'w-full h-24 object-cover rounded-xl border-2 border-gray-200 group-hover:border-brand-green transition';
                                const btn = document.createElement('button');
                                btn.type = 'button';
                                btn.textContent = '×';
                                btn.className = 'absolute -top-2 -right-2 bg-red-500 text-white w-6 h-6 rounded-full flex items-center justify-center hover:bg-red-600 transition text-sm';
                                btn.onclick = function() { div.remove(); };
                                div.appendChild(img);
                                div.appendChild(btn);
                                container.appendChild(div);
                            }
                        });

                        function deleteExistingImage(button) {
                            const container = button.parentElement;
                            const imagePath = container.dataset.path;
                            const imagesToDelete = document.getElementById('imagesToDelete');
                            const current = imagesToDelete.value ? JSON.parse(imagesToDelete.value) : [];
                            current.push(imagePath);
                            imagesToDelete.value = JSON.stringify(current);
                            container.remove();
                        }
                    </script>

                    <!-- Social Links -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-8 bg-brand-white rounded-3xl border border-gray-50">
                        <div>
                             <label class="block text-sm font-bold text-gray-700 mb-2">فيسبوك (اختياري)</label>
                             <input type="url" name="facebook" value="{{ $business->social_links['facebook'] ?? '' }}" dir="ltr" class="w-full border-gray-100 rounded-2xl py-4 px-6 focus:ring-2 focus:ring-brand-green bg-gray-50 text-gray-800 font-bold" placeholder="https://facebook.com/...">
                        </div>
                        <div>
                             <label class="block text-sm font-bold text-gray-700 mb-2">إنستغرام (اختياري)</label>
                             <input type="url" name="instagram" value="{{ $business->social_links['instagram'] ?? '' }}" dir="ltr" class="w-full border-gray-100 rounded-2xl py-4 px-6 focus:ring-2 focus:ring-brand-green bg-gray-50 text-gray-800 font-bold" placeholder="https://instagram.com/...">
                        </div>
                    </div>

                    <div class="pt-8 flex gap-4">
                        <button type="submit" class="flex-1 bg-brand-green text-white font-bold py-5 rounded-2xl hover:opacity-90 transition-all shadow-xl shadow-brand-green/20 text-lg">
                            تحديث البيانات
                        </button>
                        <a href="{{ route('owner.businesses.index') }}" class="py-5 px-8 rounded-2xl border border-gray-100 font-bold text-gray-400 hover:bg-gray-50 transition-colors">
                            إلغاء
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
