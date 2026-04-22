<template>
  <AdminLayout :title="service ? 'Edit Layanan' : 'Tambah Layanan'">
    <div class="max-w-3xl">
      <div class="flex items-center gap-4 mb-6">
        <Link :href="route('admin.services.index')" class="p-2 rounded-xl text-admin-text-dim hover:bg-white/5 transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </Link>
        <h2 class="text-xl font-bold font-heading">
          {{ service ? 'Edit Layanan' : 'Tambah Layanan Baru' }}
        </h2>
      </div>

      <form @submit.prevent="submit" class="space-y-5">
        <!-- Image -->
        <div class="rounded-2xl p-6 bg-admin-card border border-admin-border">
          <h3 class="font-semibold mb-4 text-sm">Gambar Layanan</h3>
          <div class="flex items-start gap-6">
            <div class="w-24 h-24 rounded-xl overflow-hidden flex-shrink-0 flex items-center justify-center bg-white/5">
              <img v-if="imagePreview || service?.image_url" :src="imagePreview || service?.image_url" class="w-full h-full object-cover" />
              <svg v-else class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
              </svg>
            </div>
            <div class="flex-1 space-y-2">
              <input type="file" accept="image/*" @change="handleImage" class="text-sm text-admin-text-dim" />
              <p v-if="form.errors.image" class="text-xs text-red-400">{{ form.errors.image }}</p>
              <input v-model="form.image_url" type="url" placeholder="atau URL gambar..."
                     class="w-full rounded-lg h-9 px-3 text-sm bg-white/5 border border-white/10 text-admin-text placeholder:text-admin-text-dim focus:outline-none focus:border-asak-gold/50 transition-colors" />
              <p v-if="form.errors.image_url" class="text-xs text-red-400">{{ form.errors.image_url }}</p>
            </div>
          </div>
        </div>

        <!-- Info -->
        <div class="rounded-2xl p-6 space-y-4 bg-admin-card border border-admin-border">
          <h3 class="font-semibold mb-2 text-sm">Informasi Layanan</h3>

          <div>
            <label class="block text-xs mb-1 text-admin-text-dim">Nama Layanan *</label>
            <input v-model="form.title" type="text" placeholder="Brand Engineering"
                   class="w-full rounded-lg h-10 px-3 text-sm bg-white/5 text-admin-text placeholder:text-admin-text-dim focus:outline-none transition-colors"
                   :class="form.errors.title ? 'border border-red-500' : 'border border-white/10 focus:border-asak-gold/50'" />
            <p v-if="form.errors.title" class="mt-1 text-xs text-red-400">{{ form.errors.title }}</p>
          </div>

          <div>
            <label class="block text-xs mb-1 text-admin-text-dim">Deskripsi *</label>
            <textarea v-model="form.description" rows="4"
                      class="w-full rounded-lg px-3 py-2 text-sm resize-none bg-white/5 text-admin-text placeholder:text-admin-text-dim focus:outline-none transition-colors"
                      :class="form.errors.description ? 'border border-red-500' : 'border border-white/10 focus:border-asak-gold/50'"></textarea>
            <p v-if="form.errors.description" class="mt-1 text-xs text-red-400">{{ form.errors.description }}</p>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-xs mb-1 text-admin-text-dim">Order</label>
              <input v-model="form.order" type="number" min="0"
                     class="w-full rounded-lg h-10 px-3 text-sm bg-white/5 border border-white/10 text-admin-text placeholder:text-admin-text-dim focus:outline-none focus:border-asak-gold/50 transition-colors" />
            </div>
            <div class="flex items-end pb-2">
              <label class="flex items-center gap-2 cursor-pointer">
                <input v-model="form.active" type="checkbox" />
                <span class="text-sm">Aktif</span>
              </label>
            </div>
          </div>
        </div>

        <!-- Features -->
        <div class="rounded-2xl p-6 space-y-3 bg-admin-card border border-admin-border">
          <div class="flex items-center justify-between mb-2">
            <h3 class="font-semibold text-sm">Fitur Layanan</h3>
            <button type="button" @click="addFeature"
                    class="text-xs px-3 py-1.5 rounded-lg bg-asak-gold/15 text-asak-gold hover:bg-asak-gold/20 transition-colors">
              + Tambah Fitur
            </button>
          </div>

          <div v-for="(feature, i) in form.features" :key="i" class="flex items-center gap-2">
            <input v-model="form.features[i]" type="text" :placeholder="`Fitur ${i + 1}`"
                   class="flex-1 rounded-lg h-9 px-3 text-sm bg-white/5 border border-white/10 text-admin-text placeholder:text-admin-text-dim focus:outline-none focus:border-asak-gold/50 transition-colors" />
            <button type="button" @click="removeFeature(i)"
                    class="p-1.5 rounded-lg transition-colors hover:bg-red-900/30 text-red-400">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
          </div>

          <p v-if="form.features.length === 0" class="text-sm text-admin-text-muted">
            Belum ada fitur. Klik "+ Tambah Fitur" untuk menambahkan.
          </p>
        </div>

        <div class="flex gap-3">
          <button type="submit" :disabled="form.processing"
                  class="flex items-center gap-2 px-6 py-2.5 rounded-xl text-sm font-medium disabled:opacity-50 bg-asak-gold text-white hover:bg-asak-gold-hover transition-colors">
            <svg v-if="form.processing" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
            </svg>
            {{ service ? 'Update Layanan' : 'Simpan Layanan' }}
          </button>
          <Link :href="route('admin.services.index')" class="px-6 py-2.5 rounded-xl text-sm bg-white/5 text-admin-text-dim hover:bg-white/10 transition-colors">
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
import { ref } from 'vue'

const props = defineProps({ service: Object })

const imagePreview = ref(null)

const form = useForm({
  title:       props.service?.title ?? '',
  description: props.service?.description ?? '',
  image_url:   props.service?.image?.startsWith?.('http') ? props.service.image : '',
  order:       props.service?.order ?? 0,
  active:      props.service?.active ?? true,
  features:    props.service?.features?.map(f => f.feature) ?? [''],
  image:       null,
})

function addFeature() { form.features.push('') }
function removeFeature(i) { form.features.splice(i, 1) }

function handleImage(e) {
  const file = e.target.files[0]
  if (!file) return
  form.image = file
  imagePreview.value = URL.createObjectURL(file)
}

function submit() {
  const options = { forceFormData: true }

  if (props.service) {
    form.transform(data => ({
      ...data,
      active:   data.active ? '1' : '0',
      features: data.features.filter(f => f.trim()),
      image:    data.image ?? undefined,
      _method:  'PUT',
    })).post(route('admin.services.update', props.service.id), options)
  } else {
    form.transform(data => ({
      ...data,
      active:   data.active ? '1' : '0',
      features: data.features.filter(f => f.trim()),
      image:    data.image ?? undefined,
    })).post(route('admin.services.store'), options)
  }
}
</script>
