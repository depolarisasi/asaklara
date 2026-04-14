<template>
  <AdminLayout title="Portfolio — Sampah">
    <div class="space-y-6">
      <!-- Header -->
      <div class="flex items-center justify-between">
        <div>
          <div class="flex items-center gap-3 mb-1">
            <Link :href="route('admin.portfolio.index')"
                  class="text-sm transition-colors hover:opacity-80"
                  style="color: #6b7280">
              ← Kembali ke Portfolio
            </Link>
          </div>
          <h2 class="text-xl font-bold" style="font-family: 'Space Grotesk', sans-serif">
            🗑 Sampah Portfolio
          </h2>
          <p class="text-sm mt-1" style="color: #6b7280">{{ portfolios.length }} item terhapus</p>
        </div>
      </div>

      <!-- Table -->
      <div class="rounded-2xl overflow-hidden" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07)">
        <div v-if="portfolios.length === 0" class="px-6 py-16 text-center" style="color: #6b7280">
          <svg class="w-12 h-12 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
          </svg>
          <p class="text-lg">Sampah kosong.</p>
        </div>

        <table v-else class="w-full">
          <thead>
            <tr style="border-bottom: 1px solid rgba(255,255,255,0.07)">
              <th class="text-left px-6 py-4 text-xs font-semibold uppercase tracking-wider" style="color: #6b7280">Project</th>
              <th class="text-left px-6 py-4 text-xs font-semibold uppercase tracking-wider hidden md:table-cell" style="color: #6b7280">Kategori</th>
              <th class="text-left px-6 py-4 text-xs font-semibold uppercase tracking-wider hidden lg:table-cell" style="color: #6b7280">Dihapus</th>
              <th class="text-right px-6 py-4 text-xs font-semibold uppercase tracking-wider" style="color: #6b7280">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in portfolios" :key="item.id"
                class="transition-colors hover:bg-white/5"
                style="border-bottom: 1px solid rgba(255,255,255,0.04)">
              <td class="px-6 py-4">
                <div class="flex items-center gap-3">
                  <img :src="item.image || `https://picsum.photos/seed/${item.slug}/60/60`"
                       class="w-10 h-10 rounded-lg object-cover flex-shrink-0 opacity-50" />
                  <div>
                    <p class="font-medium text-sm" style="color: #9ca3af">{{ item.title }}</p>
                    <p class="text-xs mt-0.5" style="color: #4b5563">{{ item.slug }}</p>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 hidden md:table-cell">
                <span class="text-xs px-2 py-1 rounded-full" style="background: rgba(107,114,128,0.15); color: #6b7280">
                  {{ item.category }}
                </span>
              </td>
              <td class="px-6 py-4 hidden lg:table-cell text-xs" style="color: #4b5563">
                {{ formatDate(item.deleted_at) }}
              </td>
              <td class="px-6 py-4 text-right">
                <div class="flex items-center justify-end gap-2">
                  <button @click="confirmRestore(item)"
                          class="px-3 py-1.5 rounded-lg text-xs transition-colors hover:bg-white/10"
                          style="color: #86efac">
                    Restore
                  </button>
                  <button @click="confirmForceDelete(item)"
                          class="px-3 py-1.5 rounded-lg text-xs transition-colors hover:bg-red-900/30"
                          style="color: #f87171">
                    Hapus Permanen
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Restore Modal -->
    <div v-if="restoreTarget" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background: rgba(0,0,0,0.7)">
      <div class="rounded-2xl p-6 max-w-sm w-full" style="background: #0f1220; border: 1px solid rgba(255,255,255,0.1)">
        <h3 class="font-bold text-lg mb-2">Restore Portfolio</h3>
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

const props = defineProps({ portfolios: Array })

const restoreTarget = ref(null)
const forceDeleteTarget = ref(null)

function confirmRestore(item) { restoreTarget.value = item }
function confirmForceDelete(item) { forceDeleteTarget.value = item }

function doRestore() {
  router.patch(route('admin.portfolio.restore', restoreTarget.value.id), {}, {
    onSuccess: () => { restoreTarget.value = null }
  })
}

function doForceDelete() {
  router.delete(route('admin.portfolio.force-delete', forceDeleteTarget.value.id), {
    onSuccess: () => { forceDeleteTarget.value = null }
  })
}

function formatDate(dateStr) {
  if (!dateStr) return '-'
  return new Date(dateStr).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' })
}
</script>
