<template>
  <AdminLayout :title="portfolio ? 'Edit Portfolio' : 'Tambah Portfolio'">
    <div class="max-w-3xl">
      <div class="flex items-center gap-4 mb-6">
        <Link :href="route('admin.portfolio.index')" class="p-2 rounded-xl transition-colors hover:bg-white/5" style="color: #9ca3af">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </Link>
        <h2 class="text-xl font-bold" style="font-family: 'Space Grotesk', sans-serif">
          {{ portfolio ? 'Edit Portfolio' : 'Tambah Portfolio Baru' }}
        </h2>
      </div>

      <form @submit.prevent="submit" enctype="multipart/form-data" class="space-y-6">
        <!-- Image Upload -->
        <div class="rounded-2xl p-6" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07)">
          <h3 class="font-semibold mb-4 text-sm">Gambar Project</h3>
          <div class="flex items-start gap-6">
            <div class="w-32 h-24 rounded-xl overflow-hidden flex-shrink-0 bg-white/5 flex items-center justify-center">
              <img v-if="imagePreview || portfolio?.image_url" :src="imagePreview || portfolio?.image_url"
                   class="w-full h-full object-cover" />
              <svg v-else class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #4b5563">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
              </svg>
            </div>
            <div class="flex-1 space-y-3">
              <div>
                <label class="block text-xs mb-1" style="color: #9ca3af">Upload dari komputer</label>
                <input type="file" accept="image/*" @change="handleImage" ref="imageInput"
                       class="text-sm w-full" style="color: #9ca3af" />
              </div>
              <div>
                <label class="block text-xs mb-1" style="color: #9ca3af">Atau URL gambar</label>
                <input v-model="form.image_url" type="url" placeholder="https://..."
                       class="w-full rounded-lg h-9 px-3 text-sm" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #e8e4d5" />
              </div>
            </div>
          </div>
        </div>

        <!-- Main Info -->
        <div class="rounded-2xl p-6 space-y-4" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07)">
          <h3 class="font-semibold mb-4 text-sm">Informasi Project</h3>

          <div class="grid sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-xs mb-1" style="color: #9ca3af">Judul *</label>
              <input v-model="form.title" type="text" required placeholder="TechFlow Rebrand"
                     class="w-full rounded-lg h-10 px-3 text-sm" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #e8e4d5" />
            </div>
            <div>
              <label class="block text-xs mb-1" style="color: #9ca3af">Slug (auto dari judul)</label>
              <input v-model="form.slug" type="text" placeholder="techflow-rebrand"
                     class="w-full rounded-lg h-10 px-3 text-sm" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #e8e4d5" />
            </div>
          </div>

          <div>
            <label class="block text-xs mb-1" style="color: #9ca3af">Deskripsi *</label>
            <textarea v-model="form.description" rows="4" required
                      placeholder="Deskripsi project..."
                      class="w-full rounded-lg px-3 py-2 text-sm resize-none" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #e8e4d5"></textarea>
          </div>

          <div class="grid sm:grid-cols-3 gap-4">
            <div>
              <label class="block text-xs mb-1" style="color: #9ca3af">Client *</label>
              <input v-model="form.client" type="text" required placeholder="TechFlow Inc."
                     class="w-full rounded-lg h-10 px-3 text-sm" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #e8e4d5" />
            </div>
            <div>
              <label class="block text-xs mb-1" style="color: #9ca3af">Tahun *</label>
              <input v-model="form.year" type="text" required placeholder="2024"
                     class="w-full rounded-lg h-10 px-3 text-sm" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #e8e4d5" />
            </div>
            <div>
              <label class="block text-xs mb-1" style="color: #9ca3af">Order</label>
              <input v-model="form.order" type="number" min="0"
                     class="w-full rounded-lg h-10 px-3 text-sm" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #e8e4d5" />
            </div>
          </div>

          <div>
            <label class="block text-xs mb-1" style="color: #9ca3af">Kategori *</label>
            <select v-model="form.category" required
                    class="w-full rounded-lg h-10 px-3 text-sm" style="background: #0f1220; border: 1px solid rgba(255,255,255,0.1); color: #e8e4d5">
              <option value="">Pilih kategori...</option>
              <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
            </select>
          </div>

          <div class="flex items-center gap-6 pt-2">
            <label class="flex items-center gap-2 cursor-pointer">
              <input v-model="form.active" type="checkbox" class="rounded" />
              <span class="text-sm">Aktif (tampil di website)</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
              <input v-model="form.featured" type="checkbox" class="rounded" />
              <span class="text-sm">Featured (tampil di homepage)</span>
            </label>
          </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center gap-3">
          <button type="submit" :disabled="isSubmitting"
                  class="flex items-center gap-2 px-6 py-2.5 rounded-xl text-sm font-medium transition-opacity hover:opacity-90 disabled:opacity-50"
                  style="background: #b8960c; color: white">
            <svg v-if="isSubmitting" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
            {{ portfolio ? 'Update Portfolio' : 'Simpan Portfolio' }}
          </button>
          <Link :href="route('admin.portfolio.index')" class="px-6 py-2.5 rounded-xl text-sm" style="background: rgba(255,255,255,0.05); color: #9ca3af">
            Batal
          </Link>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import { ref, watch } from 'vue'

const props = defineProps({
  portfolio: Object,
  categories: Array,
})

const isSubmitting = ref(false)
const imagePreview = ref(null)
const imageFile = ref(null)
const imageInput = ref(null)

const form = ref({
  title: props.portfolio?.title ?? '',
  slug: props.portfolio?.slug ?? '',
  description: props.portfolio?.description ?? '',
  client: props.portfolio?.client ?? '',
  year: props.portfolio?.year ?? new Date().getFullYear().toString(),
  category: props.portfolio?.category ?? '',
  image_url: props.portfolio?.image?.startsWith('http') ? props.portfolio.image : '',
  active: props.portfolio?.active ?? true,
  featured: props.portfolio?.featured ?? false,
  order: props.portfolio?.order ?? 0,
})

// Auto-slug from title
watch(() => form.value.title, (val) => {
  if (!props.portfolio) {
    form.value.slug = val.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '')
  }
})

function handleImage(e) {
  const file = e.target.files[0]
  if (!file) return
  imageFile.value = file
  imagePreview.value = URL.createObjectURL(file)
}

function submit() {
  isSubmitting.value = true
  const data = new FormData()
  data.append('title', form.value.title)
  data.append('slug', form.value.slug)
  data.append('description', form.value.description)
  data.append('client', form.value.client)
  data.append('year', form.value.year)
  data.append('category', form.value.category)
  data.append('order', form.value.order)
  data.append('active', form.value.active ? '1' : '0')
  data.append('featured', form.value.featured ? '1' : '0')
  if (form.value.image_url) data.append('image_url', form.value.image_url)
  if (imageFile.value) data.append('image', imageFile.value)

  const options = {
    onFinish: () => { isSubmitting.value = false },
    forceFormData: true,
  }

  if (props.portfolio) {
    data.append('_method', 'PUT')
    router.post(route('admin.portfolio.update', props.portfolio.id), data, options)
  } else {
    router.post(route('admin.portfolio.store'), data, options)
  }
}
</script>
