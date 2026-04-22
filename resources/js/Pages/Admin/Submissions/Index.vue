<template>
  <AdminLayout title="Contact Submissions" :unread-count="unread_count">
    <div class="space-y-6">
      <div class="flex items-center justify-between">
        <div>
          <h2 class="text-xl font-bold font-heading">Pesan Masuk</h2>
          <p class="text-sm mt-1 text-admin-text-muted">
            {{ submissions.length }} total •
            <span class="text-asak-gold">{{ unread_count }} belum dibaca</span>
          </p>
        </div>
      </div>

      <div class="rounded-2xl overflow-hidden bg-admin-card border border-admin-border">
        <div v-if="submissions.length === 0" class="px-6 py-16 text-center text-admin-text-muted">
          Belum ada pesan masuk.
        </div>
        <div v-else>
          <div v-for="sub in submissions" :key="sub.id"
               class="flex items-start gap-4 px-6 py-4 cursor-pointer transition-colors hover:bg-white/5 border-b border-admin-border-muted"
               @click="openSubmission(sub)">
            <div class="w-2 h-2 rounded-full mt-2 flex-shrink-0"
                 :class="[sub.is_read ? 'bg-gray-600' : 'bg-asak-gold']"></div>
            <div class="flex-1 min-w-0">
              <div class="flex items-center gap-3 mb-1">
                <span :class="['font-medium text-sm', !sub.is_read ? 'text-admin-text' : 'text-admin-text-dim']">
                  {{ sub.name }}
                </span>
                <span class="text-xs text-admin-text-muted">{{ sub.email }}</span>
                <span v-if="!sub.is_read" class="text-xs px-1.5 py-0.5 rounded-full font-semibold bg-asak-gold-muted text-asak-gold">Baru</span>
              </div>
              <p :class="['text-sm font-medium truncate', !sub.is_read ? 'text-admin-text' : 'text-admin-text-dim']">
                {{ sub.subject }}
              </p>
              <p class="text-xs mt-0.5 truncate text-admin-text-muted">{{ sub.message }}</p>
            </div>
            <div class="flex items-center gap-3 flex-shrink-0">
              <span class="text-xs text-admin-text-muted">
                {{ new Date(sub.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) }}
              </span>
              <button @click.stop="confirmDelete(sub)" class="p-1 rounded text-red-400 hover:bg-red-400/10 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Detail Modal -->
    <div v-if="selectedSub" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm">
      <div class="rounded-2xl max-w-xl w-full bg-admin-bg border border-white/10">
        <div class="flex items-center justify-between px-6 py-4 border-b border-admin-border">
          <h3 class="font-bold">{{ selectedSub.subject }}</h3>
          <button @click="selectedSub = null" class="text-admin-text-muted hover:text-admin-text">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
          </button>
        </div>
        <div class="p-6 space-y-4">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <p class="text-xs mb-1 text-admin-text-muted">Dari</p>
              <p class="text-sm font-medium">{{ selectedSub.name }}</p>
              <p class="text-xs text-admin-text-dim">{{ selectedSub.email }}</p>
            </div>
            <div>
              <p class="text-xs mb-1 text-admin-text-muted">Waktu</p>
              <p class="text-sm">{{ new Date(selectedSub.created_at).toLocaleString('id-ID') }}</p>
            </div>
          </div>
          <div>
            <p class="text-xs mb-2 text-admin-text-muted">Pesan</p>
            <div class="p-4 rounded-xl text-sm leading-relaxed whitespace-pre-wrap bg-white/5 text-admin-text">
              {{ selectedSub.message }}
            </div>
          </div>
          <div class="flex gap-3 justify-end pt-2">
            <a :href="`mailto:${selectedSub.email}?subject=Re: ${selectedSub.subject}`"
               class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm bg-asak-gold-muted text-asak-gold hover:bg-asak-gold/20 transition-colors">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
              Balas via Email
            </a>
            <button @click="selectedSub = null" class="px-4 py-2 rounded-xl text-sm bg-white/5 text-admin-text-dim hover:bg-white/10 transition-colors">
              Tutup
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Delete Modal -->
    <div v-if="deleteTarget" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm">
      <div class="rounded-2xl p-6 max-w-sm w-full bg-admin-bg border border-white/10">
        <h3 class="font-bold text-lg mb-2">Hapus Pesan</h3>
        <p class="text-sm mb-6 text-admin-text-dim">Hapus pesan dari <strong>{{ deleteTarget.name }}</strong>?</p>
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
import { router } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
  submissions: Array,
  unread_count: Number,
})

const selectedSub = ref(null)
const deleteTarget = ref(null)

function openSubmission(sub) {
  selectedSub.value = sub
  if (!sub.is_read) {
    router.patch(route('admin.submissions.read', sub.id), {}, { preserveScroll: true })
    sub.is_read = true
  }
}

function confirmDelete(s) { deleteTarget.value = s }
function doDelete() {
  router.delete(route('admin.submissions.destroy', deleteTarget.value.id), {
    onSuccess: () => { deleteTarget.value = null }
  })
}
</script>
