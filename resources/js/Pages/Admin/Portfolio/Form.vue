<template>
  <AdminLayout :title="portfolio ? 'Edit Portfolio' : 'Tambah Portfolio'">
    <div class="max-w-3xl">
      <div class="flex items-center gap-4 mb-6">
        <Link :href="route('admin.portfolio.index')" class="p-2 rounded-xl transition-colors hover:bg-white/5 text-admin-text-dim">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </Link>
        <h2 class="text-xl font-bold font-heading">
          {{ portfolio ? 'Edit Portfolio' : 'Tambah Portfolio Baru' }}
        </h2>
      </div>

      <form @submit.prevent="submit" class="space-y-6">

        <!-- Image Upload -->
        <div class="rounded-2xl p-6 bg-admin-card border border-admin-border">
          <h3 class="font-semibold mb-4 text-sm">Gambar Project</h3>
          <div class="flex items-start gap-6">
            <div class="w-32 h-24 rounded-xl overflow-hidden flex-shrink-0 bg-white/5 flex items-center justify-center">
              <img v-if="imagePreview || portfolio?.image_url" :src="imagePreview || portfolio?.image_url"
                   class="w-full h-full object-cover" />
              <svg v-else class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
              </svg>
            </div>
            <div class="flex-1 space-y-3">
              <div>
                <label class="block text-xs mb-1 text-admin-text-dim">Upload dari komputer</label>
                <input type="file" accept="image/*" @change="handleImage"
                       class="text-sm w-full text-admin-text-dim" />
                <p v-if="form.errors.image" class="mt-1 text-xs text-red-400">{{ form.errors.image }}</p>
              </div>
              <div>
                <label class="block text-xs mb-1 text-admin-text-dim">Atau URL gambar</label>
                <input v-model="form.image_url" type="url" placeholder="https://..."
                       class="w-full rounded-lg h-9 px-3 text-sm bg-white/5 border border-white/10 text-admin-text placeholder:text-admin-text-dim focus:outline-none focus:border-asak-gold/50 transition-colors" />
                <p v-if="form.errors.image_url" class="mt-1 text-xs text-red-400">{{ form.errors.image_url }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Main Info -->
        <div class="rounded-2xl p-6 space-y-4 bg-admin-card border border-admin-border">
          <h3 class="font-semibold mb-2 text-sm">Informasi Project</h3>

          <div class="grid sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-xs mb-1 text-admin-text-dim">Judul *</label>
              <input v-model="form.title" type="text" placeholder="TechFlow Rebrand"
                     class="w-full rounded-lg h-10 px-3 text-sm bg-white/5 text-admin-text placeholder:text-admin-text-dim focus:outline-none transition-colors"
                     :class="form.errors.title ? 'border border-red-500' : 'border border-white/10 focus:border-asak-gold/50'" />
              <p v-if="form.errors.title" class="mt-1 text-xs text-red-400">{{ form.errors.title }}</p>
            </div>
            <div>
              <label class="block text-xs mb-1 text-admin-text-dim">Slug (auto dari judul)</label>
              <input v-model="form.slug" type="text" placeholder="techflow-rebrand"
                     class="w-full rounded-lg h-10 px-3 text-sm bg-white/5 border border-white/10 text-admin-text focus:outline-none focus:border-asak-gold/50 transition-colors" />
              <p v-if="form.errors.slug" class="mt-1 text-xs text-red-400">{{ form.errors.slug }}</p>
            </div>
          </div>

          <div>
            <label class="block text-xs mb-1 text-admin-text-dim">Deskripsi *</label>
            <textarea v-model="form.description" rows="4" placeholder="Deskripsi project..."
                      class="w-full rounded-lg px-3 py-2 text-sm resize-none bg-white/5 text-admin-text placeholder:text-admin-text-dim focus:outline-none transition-colors"
                      :class="form.errors.description ? 'border border-red-500' : 'border border-white/10 focus:border-asak-gold/50'"></textarea>
            <p v-if="form.errors.description" class="mt-1 text-xs text-red-400">{{ form.errors.description }}</p>
          </div>

          <div class="grid sm:grid-cols-3 gap-4">
            <div>
              <label class="block text-xs mb-1 text-admin-text-dim">Client *</label>
              <input v-model="form.client" type="text" placeholder="TechFlow Inc."
                     class="w-full rounded-lg h-10 px-3 text-sm bg-white/5 text-admin-text placeholder:text-admin-text-dim focus:outline-none transition-colors"
                     :class="form.errors.client ? 'border border-red-500' : 'border border-white/10 focus:border-asak-gold/50'" />
              <p v-if="form.errors.client" class="mt-1 text-xs text-red-400">{{ form.errors.client }}</p>
            </div>
            <div>
              <label class="block text-xs mb-1 text-admin-text-dim">Tahun *</label>
              <input v-model="form.year" type="text" placeholder="2024"
                     class="w-full rounded-lg h-10 px-3 text-sm bg-white/5 text-admin-text placeholder:text-admin-text-dim focus:outline-none transition-colors"
                     :class="form.errors.year ? 'border border-red-500' : 'border border-white/10 focus:border-asak-gold/50'" />
              <p v-if="form.errors.year" class="mt-1 text-xs text-red-400">{{ form.errors.year }}</p>
            </div>
            <div>
              <label class="block text-xs mb-1 text-admin-text-dim">Order</label>
              <input v-model="form.order" type="number" min="0"
                     class="w-full rounded-lg h-10 px-3 text-sm bg-white/5 border border-white/10 text-admin-text focus:outline-none focus:border-asak-gold/50 transition-colors" />
            </div>
          </div>

          <div>
            <label class="block text-xs mb-1 text-admin-text-dim">Kategori *</label>
            <select v-model="form.category"
                    class="w-full rounded-lg h-10 px-3 text-sm bg-admin-bg text-admin-text focus:outline-none transition-colors"
                    :class="form.errors.category ? 'border border-red-500' : 'border border-white/10 focus:border-asak-gold/50'">
              <option value="" class="bg-admin-bg">Pilih kategori...</option>
              <option v-for="cat in categories" :key="cat" :value="cat" class="bg-admin-bg">{{ cat }}</option>
            </select>
            <p v-if="form.errors.category" class="mt-1 text-xs text-red-400">{{ form.errors.category }}</p>
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
          <button type="submit" :disabled="form.processing"
                  class="flex items-center gap-2 px-6 py-2.5 rounded-xl text-sm font-medium transition-opacity hover:opacity-90 disabled:opacity-50 bg-asak-gold text-white">
            <svg v-if="form.processing" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
            </svg>
            {{ portfolio ? 'Update Portfolio' : 'Simpan Portfolio' }}
          </button>
          <Link :href="route('admin.portfolio.index')" class="px-6 py-2.5 rounded-xl text-sm bg-white/5 text-admin-text-dim hover:bg-white/10 transition-colors">
            Batal
          </Link>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, useForm } from '@inertiajs/vue3'
import { ref, watch } from 'vue'

const props = defineProps({
  portfolio: Object,
  categories: Array,
})

const imagePreview = ref(null)

const form = useForm({
  title:       props.portfolio?.title ?? '',
  slug:        props.portfolio?.slug ?? '',
  description: props.portfolio?.description ?? '',
  client:      props.portfolio?.client ?? '',
  year:        String(props.portfolio?.year ?? new Date().getFullYear()),
  category:    props.portfolio?.category ?? '',
  image_url:   props.portfolio?.image?.startsWith?.('http') ? props.portfolio.image : '',
  active:      props.portfolio?.active ?? true,
  featured:    props.portfolio?.featured ?? false,
  order:       props.portfolio?.order ?? 0,
  image:       null,
})

// Auto-slug dari title (hanya saat create)
watch(() => form.title, (val) => {
  if (!props.portfolio) {
    form.slug = val.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '')
  }
})

function handleImage(e) {
  const file = e.target.files[0]
  if (!file) return
  form.image = file
  imagePreview.value = URL.createObjectURL(file)
}

function submit() {
  const options = { forceFormData: true }

  if (props.portfolio) {
    form.transform(data => ({
      ...data,
      active:   data.active   ? '1' : '0',
      featured: data.featured ? '1' : '0',
      image:    data.image ?? undefined,
      _method:  'PUT',
    })).post(route('admin.portfolio.update', props.portfolio.id), options)
  } else {
    form.transform(data => ({
      ...data,
      active:   data.active   ? '1' : '0',
      featured: data.featured ? '1' : '0',
      image:    data.image ?? undefined,
    })).post(route('admin.portfolio.store'), options)
  }
}
</script>
