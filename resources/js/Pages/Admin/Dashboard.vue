<template>
  <AdminLayout title="Dashboard" :unread-count="stats.unread">
    <div class="space-y-6">
      <!-- Stats Grid -->
      <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
        <div v-for="card in statCards" :key="card.label"
             class="p-5 rounded-2xl bg-admin-card border border-admin-border transition-transform hover:-translate-y-1 duration-300">
          <p class="text-2xl font-bold mb-1 font-heading text-asak-gold">
            {{ card.value }}
          </p>
          <p class="text-sm text-admin-text-muted">{{ card.label }}</p>
        </div>
      </div>

      <!-- Recent Submissions -->
      <div class="rounded-2xl overflow-hidden bg-admin-card border border-admin-border">
        <div class="flex items-center justify-between px-6 py-4 border-b border-white/5">
          <h2 class="font-semibold font-heading">Recent Submissions</h2>
          <Link :href="route('admin.submissions.index')" class="text-sm hover:underline text-asak-gold">View all →</Link>
        </div>
        <div v-if="recent_submissions.length === 0" class="px-6 py-10 text-center text-admin-text-muted">
          Belum ada pesan masuk.
        </div>
        <div v-else>
          <div v-for="sub in recent_submissions" :key="sub.id"
               class="flex items-start gap-4 px-6 py-4 transition-colors hover:bg-white/5 border-b border-white/5 last:border-0">
            <div class="w-2 h-2 rounded-full mt-2 flex-shrink-0"
                 :class="sub.is_read ? 'bg-gray-600' : 'bg-asak-gold'"></div>
            <div class="flex-1 min-w-0">
              <div class="flex items-center gap-2 mb-1">
                <span class="font-medium text-sm text-admin-text">{{ sub.name }}</span>
                <span class="text-xs text-admin-text-muted">{{ sub.email }}</span>
              </div>
              <p class="text-sm truncate text-admin-text-dim">{{ sub.subject }}</p>
            </div>
            <span class="text-xs flex-shrink-0 text-admin-text-dim">
              {{ new Date(sub.created_at).toLocaleDateString('id-ID') }}
            </span>
          </div>
        </div>
      </div>

      <!-- Quick Links -->
      <div class="grid md:grid-cols-3 gap-4">
        <Link v-for="link in quickLinks" :key="link.label" :href="link.href"
              class="p-5 rounded-2xl flex items-center gap-4 transition-all hover:border-yellow-700/50 group bg-admin-card border border-admin-border">
          <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 transition-colors bg-asak-gold/15">
            <span class="text-xl">{{ link.icon }}</span>
          </div>
          <div>
            <p class="font-medium text-sm text-admin-text group-hover:text-asak-gold transition-colors">{{ link.label }}</p>
            <p class="text-xs mt-0.5 text-admin-text-muted">{{ link.desc }}</p>
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
