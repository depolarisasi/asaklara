<template>
  <AdminLayout :title="member ? 'Edit Anggota Tim' : 'Tambah Anggota Tim'">
    <div class="max-w-lg">
      <div class="flex items-center gap-4 mb-6">
        <Link :href="route('admin.team.index')" class="p-2 rounded-xl hover:bg-white/5" style="color: #9ca3af">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </Link>
        <h2 class="text-xl font-bold" style="font-family: 'Space Grotesk', sans-serif">
          {{ member ? 'Edit Anggota Tim' : 'Tambah Anggota Tim' }}
        </h2>
      </div>

      <form @submit.prevent="submit" class="space-y-5">
        <div class="rounded-2xl p-6 space-y-4" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07)">

          <!-- Foto -->
          <div class="flex items-center gap-4">
            <img :src="imagePreview || member?.image_url || 'https://ui-avatars.com/api/?name=New&size=80&background=b8960c&color=fff'"
                 class="w-20 h-20 rounded-full object-cover flex-shrink-0" />
            <div class="flex-1">
              <label class="block text-xs mb-2" style="color: #9ca3af">Foto (upload atau URL)</label>
              <input type="file" accept="image/*" @change="handleImage" class="text-sm w-full" style="color: #9ca3af" />
              <input v-model="form.image_url" type="url" placeholder="https://..."
                     class="w-full rounded-lg h-9 px-3 text-sm mt-2" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #e8e4d5" />
            </div>
          </div>

          <div>
            <label class="block text-xs mb-1" style="color: #9ca3af">Nama *</label>
            <input v-model="form.name" type="text" required placeholder="Juliana Silva"
                   class="w-full rounded-lg h-10 px-3 text-sm" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #e8e4d5" />
          </div>

          <div>
            <label class="block text-xs mb-1" style="color: #9ca3af">Jabatan *</label>
            <input v-model="form.role" type="text" required placeholder="Chief Executive Officer (CEO)"
                   class="w-full rounded-lg h-10 px-3 text-sm" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #e8e4d5" />
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

        <div class="flex gap-3">
          <button type="submit" :disabled="isSubmitting"
                  class="px-6 py-2.5 rounded-xl text-sm font-medium disabled:opacity-50"
                  style="background: #b8960c; color: white">
            {{ member ? 'Update' : 'Simpan' }}
          </button>
          <Link :href="route('admin.team.index')" class="px-6 py-2.5 rounded-xl text-sm" style="background: rgba(255,255,255,0.05); color: #9ca3af">
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

const props = defineProps({ member: Object })

const isSubmitting = ref(false)
const imagePreview = ref(null)
const imageFile = ref(null)

const form = ref({
  name: props.member?.name ?? '',
  role: props.member?.role ?? '',
  image_url: props.member?.image?.startsWith('http') ? props.member.image : '',
  order: props.member?.order ?? 0,
  active: props.member?.active ?? true,
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
  Object.entries(form.value).forEach(([k, v]) => { if (v !== null && v !== undefined) data.append(k, v) })
  if (imageFile.value) data.append('image', imageFile.value)

  const options = { onFinish: () => { isSubmitting.value = false }, forceFormData: true }

  if (props.member) {
    data.append('_method', 'PUT')
    router.post(route('admin.team.update', props.member.id), data, options)
  } else {
    router.post(route('admin.team.store'), data, options)
  }
}
</script>
