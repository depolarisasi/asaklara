<template>
  <AdminLayout :title="client ? 'Edit Client' : 'Tambah Client'">
    <div class="max-w-lg">
      <div class="flex items-center gap-4 mb-6">
        <Link :href="route('admin.clients.index')" class="p-2 rounded-xl text-admin-text-dim hover:bg-white/5 transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </Link>
        <h2 class="text-xl font-bold font-heading">
          {{ client ? 'Edit Client' : 'Tambah Client' }}
        </h2>
      </div>

      <form @submit.prevent="submit" class="space-y-5">
        <div class="rounded-2xl p-6 space-y-4 bg-admin-card border border-admin-border">

          <!-- Logo -->
          <div class="flex items-center gap-4">
            <div class="w-20 h-20 rounded-xl bg-white/5 flex items-center justify-center p-2 border border-white/10 overflow-hidden shrink-0">
                <img :src="imagePreview || client?.logo_url || 'https://ui-avatars.com/api/?name=New&size=80&background=b8960c&color=fff'"
                     class="max-w-full max-h-full object-contain" />
            </div>
            <div class="flex-1">
              <label class="block text-xs mb-2 text-admin-text-dim">Logo (upload atau URL)</label>
              <input type="file" accept="image/*" @change="handleImage" class="text-sm w-full text-admin-text-dim" />
              <p v-if="form.errors.image" class="mt-1 text-xs text-red-400">{{ form.errors.image }}</p>
              <input v-model="form.image_url" type="url" placeholder="https://..."
                     class="w-full rounded-lg h-9 px-3 text-sm mt-2 bg-white/5 border border-white/10 text-admin-text placeholder:text-admin-text-dim focus:outline-none focus:border-asak-gold/50 transition-colors" />
              <p v-if="form.errors.image_url" class="mt-1 text-xs text-red-400">{{ form.errors.image_url }}</p>
            </div>
          </div>

          <div>
            <label class="block text-xs mb-1 text-admin-text-dim">Nama Client *</label>
            <input v-model="form.name" type="text" placeholder="Microsoft Corp"
                   class="w-full rounded-lg h-10 px-3 text-sm bg-white/5 text-admin-text placeholder:text-admin-text-dim focus:outline-none transition-colors"
                   :class="form.errors.name ? 'border border-red-500' : 'border border-white/10 focus:border-asak-gold/50'" />
            <p v-if="form.errors.name" class="mt-1 text-xs text-red-400">{{ form.errors.name }}</p>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-xs mb-1 text-admin-text-dim">Urutan</label>
              <input v-model="form.sort_order" type="number" min="0"
                     class="w-full rounded-lg h-10 px-3 text-sm bg-white/5 border border-white/10 text-admin-text placeholder:text-admin-text-dim focus:outline-none focus:border-asak-gold/50 transition-colors" />
            </div>
            <div class="flex items-end pb-2">
              <label class="flex items-center gap-2 cursor-pointer">
                <input v-model="form.is_active" type="checkbox" />
                <span class="text-sm">Aktif</span>
              </label>
            </div>
          </div>
        </div>

        <div class="flex gap-3">
          <button type="submit" :disabled="form.processing"
                  class="flex items-center gap-2 px-6 py-2.5 rounded-xl text-sm font-medium disabled:opacity-50 bg-asak-gold text-white hover:bg-asak-gold-hover transition-colors">
            <svg v-if="form.processing" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
            </svg>
            {{ client ? 'Update' : 'Simpan' }}
          </button>
          <Link :href="route('admin.clients.index')" class="px-6 py-2.5 rounded-xl text-sm bg-white/5 text-admin-text-dim hover:bg-white/10 transition-colors">
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

const props = defineProps({ client: Object })

const imagePreview = ref(null)

const form = useForm({
  name:       props.client?.name ?? '',
  image_url:  props.client?.image_url ?? '',
  sort_order: props.client?.sort_order ?? 0,
  is_active:  props.client?.is_active ?? true,
  image:      null,
})

function handleImage(e) {
  const file = e.target.files[0]
  if (!file) return
  form.image = file
  imagePreview.value = URL.createObjectURL(file)
}

function submit() {
  const options = { forceFormData: true }

  if (props.client) {
    form.transform(data => ({
      ...data,
      is_active: data.is_active ? '1' : '0',
      image:     data.image ?? undefined,
      _method:   'PUT',
    })).post(route('admin.clients.update', props.client.id), options)
  } else {
    form.transform(data => ({
      ...data,
      is_active: data.is_active ? '1' : '0',
      image:     data.image ?? undefined,
    })).post(route('admin.clients.store'), options)
  }
}
</script>
