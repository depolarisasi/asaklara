<template>
  <AdminLayout title="Team Members">
    <div class="space-y-6">
      <div class="flex items-center justify-between">
        <div>
          <h2 class="text-xl font-bold" style="font-family: 'Space Grotesk', sans-serif">Tim</h2>
          <p class="text-sm mt-1" style="color: #6b7280">{{ members.length }} anggota tim</p>
        </div>
        <div class="flex items-center gap-2">
          <Link :href="route('admin.team.trash')"
                class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm transition-colors hover:bg-white/10"
                style="color: #6b7280; border: 1px solid rgba(255,255,255,0.07)">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            Sampah
          </Link>
          <Link :href="route('admin.team.create')"
                class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium"
                style="background: #b8960c; color: white">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Anggota
          </Link>
        </div>
      </div>

      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div v-for="member in members" :key="member.id"
             class="rounded-2xl p-5 flex items-center gap-4" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07)">
          <img :src="member.image_url" :alt="member.name"
               class="w-16 h-16 rounded-full object-cover flex-shrink-0" />
          <div class="flex-1 min-w-0">
            <p class="font-semibold truncate">{{ member.name }}</p>
            <p class="text-sm mt-0.5 truncate" style="color: #9ca3af">{{ member.role }}</p>
            <span class="text-xs px-2 py-0.5 rounded-full mt-1 inline-block"
                  :style="member.active ? 'background: rgba(34,197,94,0.15); color: #86efac' : 'background: rgba(107,114,128,0.15); color: #9ca3af'">
              {{ member.active ? 'Aktif' : 'Nonaktif' }}
            </span>
          </div>
          <div class="flex flex-col gap-1">
            <Link :href="route('admin.team.edit', member.id)"
                  class="px-3 py-1.5 rounded-lg text-xs" style="background: rgba(255,255,255,0.05); color: #9ca3af">
              Edit
            </Link>
            <button @click="confirmDelete(member)"
                    class="px-3 py-1.5 rounded-lg text-xs" style="color: #f87171">
              Hapus
            </button>
          </div>
        </div>

        <div v-if="members.length === 0" class="col-span-full py-16 text-center" style="color: #6b7280">
          Belum ada anggota tim.
        </div>
      </div>
    </div>

    <div v-if="deleteTarget" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background: rgba(0,0,0,0.7)">
      <div class="rounded-2xl p-6 max-w-sm w-full" style="background: #0f1220; border: 1px solid rgba(255,255,255,0.1)">
        <h3 class="font-bold text-lg mb-2">Hapus Anggota Tim</h3>
        <p class="text-sm mb-6" style="color: #9ca3af">Yakin hapus <strong>{{ deleteTarget.name }}</strong>?</p>
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
import { Link, router } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({ members: Array })
const deleteTarget = ref(null)
function confirmDelete(m) { deleteTarget.value = m }
function doDelete() {
  router.delete(route('admin.team.destroy', deleteTarget.value.id), {
    onSuccess: () => { deleteTarget.value = null }
  })
}
</script>
