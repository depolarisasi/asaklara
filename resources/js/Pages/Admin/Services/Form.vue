<template>
  <AdminLayout :title="service ? 'Edit Layanan' : 'Tambah Layanan'">
    <div class="max-w-3xl">
      <div class="flex items-center gap-4 mb-6">
        <Link :href="route('admin.services.index')" class="p-2 rounded-xl hover:bg-white/5" style="color: #9ca3af">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </Link>
        <h2 class="text-xl font-bold" style="font-family: 'Space Grotesk', sans-serif">
          {{ service ? 'Edit Layanan' : 'Tambah Layanan Baru' }}
        </h2>
      </div>

      <form @submit.prevent="submit" class="space-y-5">
        <!-- Image -->
        <div class="rounded-2xl p-6" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07)">
          <h3 class="font-semibold mb-4 text-sm">Gambar Layanan</h3>
          <div class="flex items-start gap-6">
            <div class="w-24 h-24 rounded-xl overflow-hidden flex-shrink-0 flex items-center justify-center" style="background: rgba(255,255,255,0.05)">
              <img v-if="imagePreview || service?.image_url" :src="imagePreview || service?.image_url" class="w-full h-full object-cover" />
              <svg v-else class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #4b5563">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
              </svg>
            </div>
            <div class="flex-1 space-y-2">
              <input type="file" accept="image/*" @change="handleImage" class="text-sm" style="color: #9ca3af" />
              <input v-model="form.image_url" type="url" placeholder="atau URL gambar..."
                     class="w-full rounded-lg h-9 px-3 text-sm" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #e8e4d5" />
            </div>
          </div>
        </div>

        <!-- Info -->
        <div class="rounded-2xl p-6 space-y-4" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07)">
          <h3 class="font-semibold mb-2 text-sm">Informasi Layanan</h3>

          <div>
            <label class="block text-xs mb-1" style="color: #9ca3af">Nama Layanan *</label>
            <input v-model="form.title" type="text" required placeholder="Brand Engineering"
                   class="w-full rounded-lg h-10 px-3 text-sm" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #e8e4d5" />
          </div>

          <div>
            <label class="block text-xs mb-1" style="color: #9ca3af">Deskripsi *</label>
            <textarea v-model="form.description" rows="4" required
                      class="w-full rounded-lg px-3 py-2 text-sm resize-none" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #e8e4d5"></textarea>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-xs mb-1" style="color: #9ca3af">Order</label>
              <input v-model="form.order" type="number" min="0"
                     class="w-full rounded-lg h-10 px-3 text-sm" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #e8e4d5" />
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
        <div class="rounded-2xl p-6 space-y-3" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07)">
          <div class="flex items-center justify-between mb-2">
            <h3 class="font-semibold text-sm">Fitur Layanan</h3>
            <button type="button" @click="addFeature"
                    class="text-xs px-3 py-1.5 rounded-lg" style="background: rgba(184,150,12,0.15); color: #b8960c">
              + Tambah Fitur
            </button>
          </div>

          <div v-for="(feature, i) in form.features" :key="i" class="flex items-center gap-2">
            <input v-model="form.features[i]" type="text" :placeholder="`Fitur ${i + 1}`"
                   class="flex-1 rounded-lg h-9 px-3 text-sm" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #e8e4d5" />
            <button type="button" @click="removeFeature(i)"
                    class="p-1.5 rounded-lg transition-colors hover:bg-red-900/30" style="color: #f87171">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
          </div>

          <p v-if="form.features.length === 0" class="text-sm" style="color: #6b7280">
            Belum ada fitur. Klik "+ Tambah Fitur" untuk menambahkan.
          </p>
        </div>

        <div class="flex gap-3">
          <button type="submit" :disabled="isSubmitting"
                  class="px-6 py-2.5 rounded-xl text-sm font-medium disabled:opacity-50"
                  style="background: #b8960c; color: white">
            {{ service ? 'Update Layanan' : 'Simpan Layanan' }}
          </button>
          <Link :href="route('admin.services.index')" class="px-6 py-2.5 rounded-xl text-sm" style="background: rgba(255,255,255,0.05); color: #9ca3af">
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
import { ref } from 'vue'

const props = defineProps({ service: Object })

const isSubmitting = ref(false)
const imagePreview = ref(null)
const imageFile = ref(null)

const form = ref({
  title: props.service?.title ?? '',
  description: props.service?.description ?? '',
  image_url: props.service?.image?.startsWith?.('http') ? props.service.image : '',
  order: props.service?.order ?? 0,
  active: props.service?.active ?? true,
  features: props.service?.features?.map(f => f.feature) ?? [''],
})

function addFeature() { form.value.features.push('') }
function removeFeature(i) { form.value.features.splice(i, 1) }

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
  data.append('description', form.value.description)
  data.append('order', form.value.order)
  data.append('active', form.value.active ? '1' : '0')
  if (form.value.image_url) data.append('image_url', form.value.image_url)
  if (imageFile.value) data.append('image', imageFile.value)
  form.value.features.filter(f => f.trim()).forEach((f, i) => data.append(`features[${i}]`, f))

  const options = { onFinish: () => { isSubmitting.value = false }, forceFormData: true }

  if (props.service) {
    data.append('_method', 'PUT')
    router.post(route('admin.services.update', props.service.id), data, options)
  } else {
    router.post(route('admin.services.store'), data, options)
  }
}
</script>
