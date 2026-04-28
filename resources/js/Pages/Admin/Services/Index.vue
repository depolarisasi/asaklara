<template>
  <AdminLayout title="Services">
    <div class="space-y-6">
      <div class="flex items-center justify-between">
        <div>
          <h2 class="text-xl font-bold font-heading">Layanan</h2>
          <p class="text-sm mt-1 text-admin-text-muted">{{ services.length }} layanan</p>
        </div>
        <div class="flex items-center gap-2">
          <Link :href="route('admin.services.trash')"
                class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm transition-colors hover:bg-white/10 text-admin-text-muted border border-admin-border-muted">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            Sampah
          </Link>
          <Link :href="route('admin.services.create')"
                class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium bg-asak-gold text-white hover:bg-asak-gold-hover transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Layanan
          </Link>
        </div>
      </div>

      <div class="space-y-4">
        <div v-for="svc in services" :key="svc.id"
             class="rounded-2xl p-5 flex items-start gap-4 bg-admin-card border border-admin-border">
          <img :src="svc.image_url"
               class="w-16 h-16 rounded-xl object-cover flex-shrink-0" />
          <div class="flex-1 min-w-0">
            <div class="flex items-center gap-2 mb-1">
              <p class="font-semibold">{{ svc.title }}</p>
              <span class="text-xs px-2 py-0.5 rounded-full"
                    :class="svc.active ? 'bg-green-500/15 text-green-400' : 'bg-gray-500/15 text-admin-text-dim'">
                {{ svc.active ? 'Aktif' : 'Draft' }}
              </span>
            </div>
            <p class="text-sm mb-2 line-clamp-2 text-admin-text-dim">{{ svc.description }}</p>
            <div class="flex flex-wrap gap-1">
              <span v-for="f in (svc.features || []).slice(0, 4)" :key="f.id"
                    class="text-xs px-2 py-0.5 rounded bg-white/5 text-admin-text-muted">
                {{ f.feature }}
              </span>
              <span v-if="(svc.features || []).length > 4" class="text-xs px-2 py-0.5 rounded text-admin-text-muted">
                +{{ svc.features.length - 4 }} lainnya
              </span>
            </div>
          </div>
          <div class="flex flex-col gap-1">
            <Link :href="route('admin.services.edit', svc.id)"
                  class="px-3 py-1.5 rounded-lg text-xs bg-white/5 text-admin-text-dim hover:bg-white/10 transition-colors">
              Edit
            </Link>
            <button @click="confirmDelete(svc)" class="px-3 py-1.5 rounded-lg text-xs text-red-400 hover:bg-red-400/10 transition-colors">Hapus</button>
          </div>
        </div>

        <div v-if="services.length === 0" class="py-16 text-center rounded-2xl bg-admin-card border border-admin-border text-admin-text-muted">
          Belum ada layanan.
        </div>
      </div>

      <!-- Process Steps -->
      <div class="rounded-2xl overflow-hidden bg-admin-card border border-admin-border">
        <div class="px-6 py-4 border-b border-white/5">
          <h3 class="font-semibold font-heading">Process Steps</h3>
        </div>
        <div class="p-6 grid md:grid-cols-2 lg:grid-cols-4 gap-4">
          <div v-for="step in process_steps" :key="step.id"
               class="p-4 rounded-xl bg-white/5 border border-white/5">
            <span class="text-3xl font-bold opacity-30 text-asak-gold">{{ step.step_number }}</span>
            <p class="font-semibold text-sm mt-2 text-admin-text">{{ step.title }}</p>
            <p class="text-xs mt-1 line-clamp-2 text-admin-text-dim">{{ step.description }}</p>
          </div>
        </div>
      </div>
    </div>

    <div v-if="deleteTarget" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm">
      <div class="rounded-2xl p-6 max-w-sm w-full bg-admin-bg border border-white/10">
        <h3 class="font-bold text-lg mb-2">Hapus Layanan</h3>
        <p class="text-sm mb-6 text-admin-text-dim">Yakin hapus <strong>{{ deleteTarget.title }}</strong>?</p>
        <div class="flex gap-3 justify-end">
          <button @click="deleteTarget = null" class="px-4 py-2 rounded-xl text-sm bg-white/5 text-admin-text-dim hover:bg-white/10 transition-colors">Batal</button>
          <button @click="doDelete" class="px-4 py-2 rounded-xl text-sm font-medium bg-red-600 text-white hover:bg-red-700 transition-colors">Hapus</button>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({ services: Array, process_steps: Array })
const deleteTarget = ref(null)
function confirmDelete(s) { deleteTarget.value = s }
function doDelete() {
  router.delete(route('admin.services.destroy', deleteTarget.value.id), {
    onSuccess: () => { deleteTarget.value = null }
  })
}
</script>
