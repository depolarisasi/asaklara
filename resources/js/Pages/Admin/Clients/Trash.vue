<template>
  <AdminLayout title="Trash - Clients">
    <div class="space-y-6">
      <div class="flex items-center gap-4 mb-6">
        <Link :href="route('admin.clients.index')" class="p-2 rounded-xl text-admin-text-dim hover:bg-white/5 transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </Link>
        <div>
          <h2 class="text-xl font-bold font-heading">Sampah Client</h2>
          <p class="text-sm mt-1 text-admin-text-muted">{{ clients.length }} client terhapus</p>
        </div>
      </div>

      <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div v-for="client in clients" :key="client.id"
             class="rounded-2xl p-5 flex flex-col items-center text-center gap-4 bg-admin-card border border-admin-border opacity-70">
          <div class="w-full aspect-video rounded-xl bg-white/5 flex items-center justify-center p-4 overflow-hidden border border-white/5">
            <img :src="client.logo_url" :alt="client.name"
                 class="max-w-full max-h-full object-contain grayscale" />
          </div>
          <div class="flex-1 min-w-0 w-full">
            <p class="font-semibold truncate">{{ client.name }}</p>
            <p class="text-xs mt-1 text-admin-text-dim">Dihapus {{ client.deleted_at }}</p>
          </div>
          <div class="flex gap-2 w-full mt-2">
            <button @click="restore(client)"
                    class="flex-1 text-center py-2 rounded-lg text-xs bg-green-500/10 text-green-400 hover:bg-green-500/20 transition-colors">
              Pulihkan
            </button>
            <button @click="confirmForceDelete(client)"
                    class="flex-1 text-center py-2 rounded-lg text-xs text-red-400 hover:bg-red-400/10 transition-colors">
              Permanen
            </button>
          </div>
        </div>

        <div v-if="clients.length === 0" class="col-span-full py-16 text-center text-admin-text-muted">
          Sampah kosong.
        </div>
      </div>
    </div>

    <!-- Confirmation Modal -->
    <div v-if="forceDeleteTarget" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm">
      <div class="rounded-2xl p-6 max-w-sm w-full bg-admin-bg border border-white/10">
        <h3 class="font-bold text-lg mb-2 text-red-400">Hapus Permanen</h3>
        <p class="text-sm mb-6 text-admin-text-dim">Data <strong>{{ forceDeleteTarget.name }}</strong> akan hilang selamanya. Lanjutkan?</p>
        <div class="flex gap-3 justify-end">
          <button @click="forceDeleteTarget = null" class="px-4 py-2 rounded-xl text-sm bg-white/5 text-admin-text-dim hover:bg-white/10 transition-colors">Batal</button>
          <button @click="doForceDelete" class="px-4 py-2 rounded-xl text-sm font-medium bg-red-600 text-white hover:bg-red-700 transition-colors">Hapus Permanen</button>
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

const forceDeleteTarget = ref(null)

function confirmForceDelete(c) { forceDeleteTarget.value = c }

function restore(c) {
  router.patch(route('admin.clients.restore', c.id))
}

function doForceDelete() {
  router.delete(route('admin.clients.force-delete', forceDeleteTarget.value.id), {
    onSuccess: () => { forceDeleteTarget.value = null }
  })
}
</script>
