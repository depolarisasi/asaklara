<template>
  <AdminLayout title="Portfolio" :unread-count="0">
    <div class="space-y-6">
      <!-- Header -->
      <div class="flex items-center justify-between">
        <div>
          <h2 class="text-xl font-bold font-heading">Portfolio</h2>
          <p class="text-sm mt-1 text-admin-text-muted">{{ portfolios.length }} total project</p>
        </div>
        <div class="flex items-center gap-2">
          <Link :href="route('admin.portfolio.trash')"
                class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm transition-colors hover:bg-white/10 text-admin-text-muted border border-admin-border-muted">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            Sampah
          </Link>
          <Link :href="route('admin.portfolio.create')"
                class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium transition-opacity hover:opacity-90 bg-asak-gold text-white">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Portfolio
          </Link>
        </div>
      </div>

      <!-- Table -->
      <div class="rounded-2xl overflow-hidden bg-admin-card border border-admin-border">
        <div v-if="portfolios.length === 0" class="px-6 py-16 text-center text-admin-text-muted">
          <p class="text-lg mb-2">Belum ada portfolio.</p>
          <Link :href="route('admin.portfolio.create')" class="text-sm hover:underline text-asak-gold">Tambah yang pertama →</Link>
        </div>
        <table v-else class="w-full">
          <thead>
            <tr class="border-b border-admin-border">
              <th class="text-left px-6 py-4 text-xs font-semibold uppercase tracking-wider text-admin-text-muted">Project</th>
              <th class="text-left px-6 py-4 text-xs font-semibold uppercase tracking-wider hidden md:table-cell text-admin-text-muted">Kategori</th>
              <th class="text-left px-6 py-4 text-xs font-semibold uppercase tracking-wider hidden lg:table-cell text-admin-text-muted">Client</th>
              <th class="text-left px-6 py-4 text-xs font-semibold uppercase tracking-wider hidden lg:table-cell text-admin-text-muted">Tahun</th>
              <th class="text-left px-6 py-4 text-xs font-semibold uppercase tracking-wider text-admin-text-muted">Status</th>
              <th class="text-right px-6 py-4 text-xs font-semibold uppercase tracking-wider text-admin-text-muted">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in portfolios" :key="item.id"
                class="transition-colors hover:bg-white/5 border-b border-admin-border-muted">
              <td class="px-6 py-4">
                <div class="flex items-center gap-3">
                  <img :src="item.image || `https://picsum.photos/seed/${item.slug}/60/60`"
                       class="w-10 h-10 rounded-lg object-cover flex-shrink-0" />
                  <div>
                    <p class="font-medium text-sm">{{ item.title }}</p>
                    <p class="text-xs mt-0.5 text-admin-text-muted">{{ item.slug }}</p>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 hidden md:table-cell">
                <span class="text-xs px-2 py-1 rounded-full bg-asak-gold-muted text-asak-gold">
                  {{ item.category }}
                </span>
              </td>
              <td class="px-6 py-4 hidden lg:table-cell text-sm text-admin-text-dim">{{ item.client }}</td>
              <td class="px-6 py-4 hidden lg:table-cell text-sm text-admin-text-dim">{{ item.year }}</td>
              <td class="px-6 py-4">
                <span class="text-xs px-2 py-1 rounded-full"
                      :class="item.active ? 'bg-green-500/15 text-green-300' : 'bg-gray-500/15 text-admin-text-dim'">
                  {{ item.active ? 'Aktif' : 'Draft' }}
                </span>
              </td>
              <td class="px-6 py-4 text-right">
                <div class="flex items-center justify-end gap-2">
                  <Link :href="route('admin.portfolio.edit', item.id)"
                        class="p-2 rounded-lg text-xs transition-colors hover:bg-white/10 text-admin-text-dim">
                    Edit
                  </Link>
                  <button @click="confirmDelete(item)"
                          class="p-2 rounded-lg text-xs transition-colors hover:bg-red-900/30 text-red-400">
                    Hapus
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Delete Modal -->
    <div v-if="deleteTarget" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm">
      <div class="rounded-2xl p-6 max-w-sm w-full bg-admin-bg border border-white/10">
        <h3 class="font-bold text-lg mb-2">Hapus Portfolio</h3>
        <p class="text-sm mb-6 text-admin-text-dim">Yakin ingin menghapus <strong>{{ deleteTarget.title }}</strong>? Tindakan ini tidak bisa dibatalkan.</p>
        <div class="flex gap-3 justify-end">
          <button @click="deleteTarget = null" class="px-4 py-2 rounded-xl text-sm bg-white/5 text-admin-text-dim hover:bg-white/10 transition-colors">
            Batal
          </button>
          <form :action="route('admin.portfolio.destroy', deleteTarget.id)" method="POST" @submit.prevent="doDelete">
            <button type="submit" class="px-4 py-2 rounded-xl text-sm font-medium bg-red-600 text-white hover:bg-red-700 transition-colors">
              Ya, Hapus
            </button>
          </form>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
  portfolios: Array,
})

const deleteTarget = ref(null)
function confirmDelete(item) { deleteTarget.value = item }
function doDelete() {
  router.delete(route('admin.portfolio.destroy', deleteTarget.value.id), {
    onSuccess: () => { deleteTarget.value = null }
  })
}
</script>
