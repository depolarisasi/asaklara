<template>
  <AdminLayout title="Dashboard" :unread-count="stats.unread">
    <div class="space-y-6">
      <!-- Stats Grid -->
      <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
        <div v-for="card in statCards" :key="card.label"
             class="p-5 rounded-2xl" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07)">
          <p class="text-2xl font-bold mb-1" style="font-family: 'Space Grotesk', sans-serif; color: #b8960c">
            {{ card.value }}
          </p>
          <p class="text-sm" style="color: #6b7280">{{ card.label }}</p>
        </div>
      </div>

      <!-- Recent Submissions -->
      <div class="rounded-2xl overflow-hidden" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07)">
        <div class="flex items-center justify-between px-6 py-4" style="border-bottom: 1px solid rgba(255,255,255,0.07)">
          <h2 class="font-semibold" style="font-family: 'Space Grotesk', sans-serif">Recent Submissions</h2>
          <Link :href="route('admin.submissions.index')" class="text-sm hover:underline" style="color: #b8960c">View all →</Link>
        </div>
        <div v-if="recent_submissions.length === 0" class="px-6 py-10 text-center" style="color: #6b7280">
          Belum ada pesan masuk.
        </div>
        <div v-else>
          <div v-for="sub in recent_submissions" :key="sub.id"
               class="flex items-start gap-4 px-6 py-4 transition-colors hover:bg-white/5"
               style="border-bottom: 1px solid rgba(255,255,255,0.04)">
            <div class="w-2 h-2 rounded-full mt-2 flex-shrink-0"
                 :style="{ background: sub.is_read ? '#374151' : '#b8960c' }"></div>
            <div class="flex-1 min-w-0">
              <div class="flex items-center gap-2 mb-1">
                <span class="font-medium text-sm">{{ sub.name }}</span>
                <span class="text-xs" style="color: #6b7280">{{ sub.email }}</span>
              </div>
              <p class="text-sm truncate" style="color: #9ca3af">{{ sub.subject }}</p>
            </div>
            <span class="text-xs flex-shrink-0" style="color: #6b7280">
              {{ new Date(sub.created_at).toLocaleDateString('id-ID') }}
            </span>
          </div>
        </div>
      </div>

      <!-- Quick Links -->
      <div class="grid md:grid-cols-3 gap-4">
        <Link v-for="link in quickLinks" :key="link.label" :href="link.href"
              class="p-5 rounded-2xl flex items-center gap-4 transition-all hover:border-yellow-700/50 group"
              style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07)">
          <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 transition-colors"
               style="background: rgba(184,150,12,0.15)">
            <span class="text-xl">{{ link.icon }}</span>
          </div>
          <div>
            <p class="font-medium text-sm">{{ link.label }}</p>
            <p class="text-xs mt-0.5" style="color: #6b7280">{{ link.desc }}</p>
          </div>
        </Link>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps({
  stats: Object,
  recent_submissions: Array,
})

const statCards = computed(() => [
  { label: 'Total Portfolio', value: props.stats.portfolios },
  { label: 'Services', value: props.stats.services },
  { label: 'Team Members', value: props.stats.team_members },
  { label: 'Total Pesan', value: props.stats.submissions },
  { label: 'Pesan Belum Dibaca', value: props.stats.unread },
])

const quickLinks = [
  { label: 'Tambah Portfolio', desc: 'Upload project baru', icon: '🖼️', href: route('admin.portfolio.create') },
  { label: 'Kelola Tim', desc: 'Update anggota tim', icon: '👥', href: route('admin.team.index') },
  { label: 'Pengaturan', desc: 'Edit konten website', icon: '⚙️', href: route('admin.settings.index') },
]
</script>
