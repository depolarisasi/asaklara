<template>
  <AdminLayout title="Detail Pesan">
    <div class="max-w-2xl space-y-6">

      <!-- Back Button -->
      <div class="flex items-center gap-4">
        <Link :href="route('admin.submissions.index')"
              class="p-2 rounded-xl transition-colors hover:bg-white/5" style="color: #9ca3af">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
          </svg>
        </Link>
        <h2 class="text-xl font-bold" style="font-family: 'Space Grotesk', sans-serif">Detail Pesan</h2>
        <span v-if="!submission.is_read" class="text-xs px-2 py-0.5 rounded-full font-semibold"
              style="background: rgba(184,150,12,0.2); color: #b8960c">Baru</span>
      </div>

      <!-- Message Card -->
      <div class="rounded-2xl overflow-hidden" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07)">

        <!-- Header -->
        <div class="px-6 py-5" style="border-bottom: 1px solid rgba(255,255,255,0.07)">
          <h3 class="font-semibold text-lg mb-1">{{ submission.subject }}</h3>
          <p class="text-xs" style="color: #6b7280">
            {{ new Date(submission.created_at).toLocaleString('id-ID', { dateStyle: 'long', timeStyle: 'short' }) }}
          </p>
        </div>

        <!-- Sender Info -->
        <div class="px-6 py-5 grid sm:grid-cols-2 gap-6" style="border-bottom: 1px solid rgba(255,255,255,0.07)">
          <div>
            <p class="text-xs mb-1" style="color: #6b7280">Nama Pengirim</p>
            <p class="font-medium">{{ submission.name }}</p>
          </div>
          <div>
            <p class="text-xs mb-1" style="color: #6b7280">Email</p>
            <p class="font-medium">{{ submission.email }}</p>
          </div>
          <div v-if="submission.ip_address">
            <p class="text-xs mb-1" style="color: #6b7280">IP Address</p>
            <p class="text-sm" style="color: #9ca3af">{{ submission.ip_address }}</p>
          </div>
        </div>

        <!-- Message Body -->
        <div class="px-6 py-5">
          <p class="text-xs mb-3" style="color: #6b7280">Isi Pesan</p>
          <div class="p-4 rounded-xl text-sm leading-relaxed whitespace-pre-wrap"
               style="background: rgba(255,255,255,0.03); color: #e8e4d5; border: 1px solid rgba(255,255,255,0.05)">
            {{ submission.message }}
          </div>
        </div>

        <!-- Actions -->
        <div class="px-6 py-5 flex flex-wrap items-center gap-3" style="border-top: 1px solid rgba(255,255,255,0.07)">
          <a :href="`mailto:${submission.email}?subject=Re: ${submission.subject}`"
             class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-medium transition-opacity hover:opacity-90"
             style="background: rgba(184,150,12,0.15); color: #b8960c">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            Balas via Email
          </a>

          <button v-if="!submission.is_read" @click="markRead"
                  class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-medium transition-opacity hover:opacity-90"
                  style="background: rgba(255,255,255,0.05); color: #9ca3af">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Tandai Sudah Dibaca
          </button>

          <button @click="confirmDelete = true"
                  class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-medium ml-auto transition-opacity hover:opacity-90"
                  style="background: rgba(220,38,38,0.1); color: #f87171">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            Hapus Pesan
          </button>
        </div>
      </div>
    </div>

    <!-- Delete Confirm Modal -->
    <div v-if="confirmDelete" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background: rgba(0,0,0,0.7)">
      <div class="rounded-2xl p-6 max-w-sm w-full" style="background: #0f1220; border: 1px solid rgba(255,255,255,0.1)">
        <h3 class="font-bold text-lg mb-2">Hapus Pesan</h3>
        <p class="text-sm mb-6" style="color: #9ca3af">
          Hapus pesan dari <strong>{{ submission.name }}</strong>? Tindakan ini tidak bisa dibatalkan.
        </p>
        <div class="flex gap-3 justify-end">
          <button @click="confirmDelete = false" class="px-4 py-2 rounded-xl text-sm"
                  style="background: rgba(255,255,255,0.05); color: #9ca3af">Batal</button>
          <button @click="doDelete" class="px-4 py-2 rounded-xl text-sm font-medium"
                  style="background: #dc2626; color: white">Hapus</button>
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
  submission: Object,
})

const confirmDelete = ref(false)

function markRead() {
  router.patch(route('admin.submissions.read', props.submission.id), {}, { preserveScroll: true })
}

function doDelete() {
  router.delete(route('admin.submissions.destroy', props.submission.id))
}
</script>
