<template>
  <AdminLayout title="Clients">
    <div class="space-y-6">
      <div class="flex items-center justify-between">
        <div>
          <h2 class="text-xl font-bold font-heading">Clients</h2>
          <p class="text-sm mt-1 text-admin-text-muted">{{ clients.length }} partner/client</p>
        </div>
        <div class="flex items-center gap-2">
          <Link :href="route('admin.clients.trash')"
                class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm transition-colors hover:bg-white/10 text-admin-text-muted border border-admin-border-muted">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            Sampah
          </Link>
          <Link :href="route('admin.clients.create')"
                class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium bg-asak-gold text-white hover:bg-asak-gold-hover transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Client
          </Link>
        </div>
      </div>

      <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div v-for="client in clients" :key="client.id"
             class="rounded-2xl p-5 flex flex-col items-center text-center gap-4 bg-admin-card border border-admin-border">
          <div class="w-full aspect-video rounded-xl bg-white/5 flex items-center justify-center p-4 overflow-hidden border border-white/5">
            <img :src="client.logo_url" :alt="client.name"
                 class="max-w-full max-h-full object-contain" />
          </div>
          <div class="flex-1 min-w-0 w-full">
            <p class="font-semibold truncate">{{ client.name }}</p>
            <div class="flex items-center justify-center gap-2 mt-2">
                <span class="text-xs px-2 py-0.5 rounded-full"
                    :class="client.is_active ? 'bg-green-500/15 text-green-400' : 'bg-gray-500/15 text-admin-text-dim'">
                {{ client.is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
                <span class="text-xs text-admin-text-dim">Urutan: {{ client.sort_order }}</span>
            </div>
          </div>
          <div class="flex gap-2 w-full mt-2">
            <Link :href="route('admin.clients.edit', client.id)"
                  class="flex-1 text-center py-2 rounded-lg text-xs bg-white/5 text-admin-text-dim hover:bg-white/10 transition-colors">
              Edit
            </Link>
            <button @click="confirmDelete(client)"
                    class="flex-1 text-center py-2 rounded-lg text-xs text-red-400 hover:bg-red-400/10 transition-colors">
              Hapus
            </button>
          </div>
        </div>

        <div v-if="clients.length === 0" class="col-span-full py-16 text-center text-admin-text-muted">
          Belum ada data client.
        </div>
      </div>
    </div>

    <div v-if="deleteTarget" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm">
      <div class="rounded-2xl p-6 max-w-sm w-full bg-admin-bg border border-white/10">
        <h3 class="font-bold text-lg mb-2">Hapus Client</h3>
        <p class="text-sm mb-6 text-admin-text-dim">Yakin hapus <strong>{{ deleteTarget.name }}</strong>?</p>
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

const props = defineProps({ clients: Array })
const deleteTarget = ref(null)
function confirmDelete(c) { deleteTarget.value = c }
function doDelete() {
  router.delete(route('admin.clients.destroy', deleteTarget.value.id), {
    onSuccess: () => { deleteTarget.value = null }
  })
}
</script>
