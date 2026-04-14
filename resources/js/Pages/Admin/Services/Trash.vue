<template>
  <AdminLayout title="Services — Sampah">
    <div class="space-y-6">
      <!-- Header -->
      <div>
        <div class="flex items-center gap-3 mb-1">
          <Link :href="route('admin.services.index')"
                class="text-sm transition-colors hover:opacity-80"
                style="color: #6b7280">
            ← Kembali ke Layanan
          </Link>
        </div>
        <h2 class="text-xl font-bold" style="font-family: 'Space Grotesk', sans-serif">
          🗑 Sampah Layanan
        </h2>
        <p class="text-sm mt-1" style="color: #6b7280">{{ services.length }} layanan terhapus</p>
      </div>

      <!-- Empty State -->
      <div v-if="services.length === 0"
           class="rounded-2xl py-16 text-center" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07); color: #6b7280">
        <svg class="w-12 h-12 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
        </svg>
        <p class="text-lg">Sampah kosong.</p>
      </div>

      <!-- List -->
      <div v-else class="space-y-4">
        <div v-for="svc in services" :key="svc.id"
             class="rounded-2xl p-5 flex items-start gap-4 opacity-70"
             style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07)">
          <img :src="svc.image_url || svc.image || `https://picsum.photos/seed/${svc.slug}/80/80`"
               class="w-16 h-16 rounded-xl object-cover flex-shrink-0 grayscale" />
          <div class="flex-1 min-w-0">
            <div class="flex items-center gap-2 mb-1">
              <p class="font-semibold" style="color: #9ca3af">{{ svc.title }}</p>
              <span class="text-xs px-2 py-0.5 rounded-full" style="background: rgba(107,114,128,0.15); color: #6b7280">
                Terhapus
              </span>
            </div>
            <p class="text-sm mb-1 line-clamp-2" style="color: #6b7280">{{ svc.description }}</p>
            <p class="text-xs" style="color: #4b5563">Dihapus {{ formatDate(svc.deleted_at) }}</p>
          </div>
          <div class="flex flex-col gap-1.5 flex-shrink-0">
            <button @click="confirmRestore(svc)"
                    class="px-3 py-1.5 rounded-lg text-xs font-medium"
                    style="background: rgba(34,197,94,0.1); color: #86efac">
              Restore
            </button>
            <button @click="confirmForceDelete(svc)"
                    class="px-3 py-1.5 rounded-lg text-xs"
                    style="color: #f87171">
              Hapus Perm.
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Restore Modal -->
    <div v-if="restoreTarget" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background: rgba(0,0,0,0.7)">
      <div class="rounded-2xl p-6 max-w-sm w-full" style="background: #0f1220; border: 1px solid rgba(255,255,255,0.1)">
        <h3 class="font-bold text-lg mb-2">Restore Layanan</h3>
        <p class="text-sm mb-6" style="color: #9ca3af">
          Kembalikan <strong>{{ restoreTarget.title }}</strong> ke daftar aktif?
        </p>
        <div class="flex gap-3 justify-end">
          <button @click="restoreTarget = null" class="px-4 py-2 rounded-xl text-sm" style="background: rgba(255,255,255,0.05); color: #9ca3af">Batal</button>
          <button @click="doRestore" class="px-4 py-2 rounded-xl text-sm font-medium" style="background: #16a34a; color: white">Ya, Restore</button>
        </div>
      </div>
    </div>

    <!-- Force Delete Modal -->
    <div v-if="forceDeleteTarget" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background: rgba(0,0,0,0.7)">
      <div class="rounded-2xl p-6 max-w-sm w-full" style="background: #0f1220; border: 1px solid rgba(255,255,255,0.1)">
        <h3 class="font-bold text-lg mb-2" style="color: #f87171">Hapus Permanen</h3>
        <p class="text-sm mb-6" style="color: #9ca3af">
          <strong>{{ forceDeleteTarget.title }}</strong> akan dihapus selamanya dan tidak bisa dipulihkan. Yakin?
        </p>
        <div class="flex gap-3 justify-end">
          <button @click="forceDeleteTarget = null" class="px-4 py-2 rounded-xl text-sm" style="background: rgba(255,255,255,0.05); color: #9ca3af">Batal</button>
          <button @click="doForceDelete" class="px-4 py-2 rounded-xl text-sm font-medium" style="background: #dc2626; color: white">Hapus Selamanya</button>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({ services: Array })

const restoreTarget = ref(null)
const forceDeleteTarget = ref(null)

function confirmRestore(s) { restoreTarget.value = s }
function confirmForceDelete(s) { forceDeleteTarget.value = s }

function doRestore() {
  router.patch(route('admin.services.restore', restoreTarget.value.id), {}, {
    onSuccess: () => { restoreTarget.value = null }
  })
}

function doForceDelete() {
  router.delete(route('admin.services.force-delete', forceDeleteTarget.value.id), {
    onSuccess: () => { forceDeleteTarget.value = null }
  })
}

function formatDate(dateStr) {
  if (!dateStr) return '-'
  return new Date(dateStr).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' })
}
</script>
