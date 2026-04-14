<template>
  <AdminLayout title="Contact Submissions" :unread-count="unread_count">
    <div class="space-y-6">
      <div class="flex items-center justify-between">
        <div>
          <h2 class="text-xl font-bold" style="font-family: 'Space Grotesk', sans-serif">Pesan Masuk</h2>
          <p class="text-sm mt-1" style="color: #6b7280">
            {{ submissions.length }} total •
            <span style="color: #b8960c">{{ unread_count }} belum dibaca</span>
          </p>
        </div>
      </div>

      <div class="rounded-2xl overflow-hidden" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07)">
        <div v-if="submissions.length === 0" class="px-6 py-16 text-center" style="color: #6b7280">
          Belum ada pesan masuk.
        </div>
        <div v-else>
          <div v-for="sub in submissions" :key="sub.id"
               class="flex items-start gap-4 px-6 py-4 cursor-pointer transition-colors hover:bg-white/5"
               style="border-bottom: 1px solid rgba(255,255,255,0.04)"
               @click="openSubmission(sub)">
            <div class="w-2 h-2 rounded-full mt-2 flex-shrink-0"
                 :style="{ background: sub.is_read ? '#374151' : '#b8960c' }"></div>
            <div class="flex-1 min-w-0">
              <div class="flex items-center gap-3 mb-1">
                <span :class="['font-medium text-sm', !sub.is_read ? '' : '']"
                      :style="!sub.is_read ? 'color: #e8e4d5' : 'color: #9ca3af'">
                  {{ sub.name }}
                </span>
                <span class="text-xs" style="color: #6b7280">{{ sub.email }}</span>
                <span v-if="!sub.is_read" class="text-xs px-1.5 py-0.5 rounded-full font-semibold"
                      style="background: rgba(184,150,12,0.2); color: #b8960c">Baru</span>
              </div>
              <p class="text-sm font-medium truncate" :style="!sub.is_read ? 'color: #e8e4d5' : 'color: #9ca3af'">
                {{ sub.subject }}
              </p>
              <p class="text-xs mt-0.5 truncate" style="color: #6b7280">{{ sub.message }}</p>
            </div>
            <div class="flex items-center gap-3 flex-shrink-0">
              <span class="text-xs" style="color: #6b7280">
                {{ new Date(sub.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) }}
              </span>
              <button @click.stop="confirmDelete(sub)" class="p-1 rounded" style="color: #f87171">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Detail Modal -->
    <div v-if="selectedSub" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background: rgba(0,0,0,0.7)">
      <div class="rounded-2xl max-w-xl w-full" style="background: #0f1220; border: 1px solid rgba(255,255,255,0.1)">
        <div class="flex items-center justify-between px-6 py-4" style="border-bottom: 1px solid rgba(255,255,255,0.08)">
          <h3 class="font-bold">{{ selectedSub.subject }}</h3>
          <button @click="selectedSub = null" style="color: #6b7280">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
          </button>
        </div>
        <div class="p-6 space-y-4">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <p class="text-xs mb-1" style="color: #6b7280">Dari</p>
              <p class="text-sm font-medium">{{ selectedSub.name }}</p>
              <p class="text-xs" style="color: #9ca3af">{{ selectedSub.email }}</p>
            </div>
            <div>
              <p class="text-xs mb-1" style="color: #6b7280">Waktu</p>
              <p class="text-sm">{{ new Date(selectedSub.created_at).toLocaleString('id-ID') }}</p>
            </div>
          </div>
          <div>
            <p class="text-xs mb-2" style="color: #6b7280">Pesan</p>
            <div class="p-4 rounded-xl text-sm leading-relaxed whitespace-pre-wrap" style="background: rgba(255,255,255,0.03); color: #e8e4d5">
              {{ selectedSub.message }}
            </div>
          </div>
          <div class="flex gap-3 justify-end pt-2">
            <a :href="`mailto:${selectedSub.email}?subject=Re: ${selectedSub.subject}`"
               class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm" style="background: rgba(184,150,12,0.15); color: #b8960c">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
              Balas via Email
            </a>
            <button @click="selectedSub = null" class="px-4 py-2 rounded-xl text-sm" style="background: rgba(255,255,255,0.05); color: #9ca3af">
              Tutup
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Delete Modal -->
    <div v-if="deleteTarget" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background: rgba(0,0,0,0.7)">
      <div class="rounded-2xl p-6 max-w-sm w-full" style="background: #0f1220; border: 1px solid rgba(255,255,255,0.1)">
        <h3 class="font-bold text-lg mb-2">Hapus Pesan</h3>
        <p class="text-sm mb-6" style="color: #9ca3af">Hapus pesan dari <strong>{{ deleteTarget.name }}</strong>?</p>
        <div class="flex gap-3 justify-end">
          <button @click="deleteTarget = null" class="px-4 py-2 rounded-xl text-sm" style="background: rgba(255,255,255,0.05); color: #9ca3af">Batal</button>
          <button @click="doDelete" class="px-4 py-2 rounded-xl text-sm font-medium" style="background: #dc2626; color: white">Hapus</button>
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
