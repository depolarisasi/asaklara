<template>
  <div class="min-h-screen bg-admin-bg text-admin-text font-sans">

    <!-- Sidebar -->
    <aside :class="['fixed inset-y-0 left-0 z-50 w-64 transition-transform duration-300 bg-admin-sidebar border-r border-admin-border', sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0']">

      <!-- Logo -->
      <div class="flex items-center gap-3 px-6 h-16 border-b border-admin-border">
        <div class="w-8 h-8 rounded-lg flex items-center justify-center font-bold text-white text-sm bg-asak-gold">A</div>
        <div>
          <span class="font-bold text-sm text-admin-text">asak</span><span class="font-bold text-sm text-asak-gold">digital</span>
          <p class="text-xs text-admin-text-muted">Admin Panel</p>
        </div>
      </div>

      <!-- Nav -->
      <nav class="p-4 space-y-1">
        <p class="text-xs font-semibold uppercase tracking-wider px-3 mb-3 text-gray-500">Main</p>

        <Link :href="route('admin.dashboard')" :class="navClass('admin.dashboard')">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
          Dashboard
        </Link>

        <p class="text-xs font-semibold uppercase tracking-wider px-3 mt-6 mb-3 text-gray-500">Content</p>

        <Link :href="route('admin.portfolio.index')" :class="navClass('admin.portfolio')">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
          Portfolio
        </Link>

        <Link :href="route('admin.services.index')" :class="navClass('admin.services')">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
          Services
        </Link>

        <Link :href="route('admin.team.index')" :class="navClass('admin.team')">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
          Team
        </Link>
        <Link :href="route('admin.clients.index')" :class="navClass('admin.clients')">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
          Clients
        </Link>

        <Link :href="route('admin.submissions.index')" :class="navClass('admin.submissions')">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
          Submissions
          <span v-if="unreadCount > 0" class="ml-auto text-xs px-2 py-0.5 rounded-full font-semibold bg-asak-gold text-white">
            {{ unreadCount }}
          </span>
        </Link>

        <p class="text-xs font-semibold uppercase tracking-wider px-3 mt-6 mb-3 text-gray-500">System</p>

        <Link :href="route('admin.settings.index')" :class="navClass('admin.settings')">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
          Settings
        </Link>
      </nav>

      <!-- Footer -->
      <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-admin-border">
        <div class="flex items-center gap-3 px-3 mb-3">
          <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white bg-asak-gold">
            {{ $page.props.auth.user?.name?.charAt(0)?.toUpperCase() ?? 'A' }}
          </div>
          <div class="flex-1 min-w-0">
            <p class="text-sm font-medium truncate">{{ $page.props.auth.user?.name }}</p>
            <p class="text-xs truncate text-admin-text-muted">{{ $page.props.auth.user?.email }}</p>
          </div>
        </div>
        <Link :href="route('home')" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-colors w-full text-left mb-1 text-admin-text-dim hover:bg-white/5">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
          View Site
        </Link>
        <form :action="route('logout')" method="POST" @submit.prevent="logout">
          <button type="submit" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-colors w-full text-left text-admin-text-dim hover:bg-white/5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            Logout
          </button>
        </form>
      </div>
    </aside>

    <!-- Overlay -->
    <div v-if="sidebarOpen" class="fixed inset-0 z-40 lg:hidden bg-black/50" @click="sidebarOpen = false"></div>

    <!-- Main Content -->
    <div class="lg:pl-64">
      <!-- Top Bar -->
      <header class="sticky top-0 z-30 h-16 flex items-center justify-between px-6 admin-glass">
        <div class="flex items-center gap-4">
          <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-lg hover:bg-white/5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
          </button>
          <h1 class="font-semibold text-sm font-heading">{{ title }}</h1>
        </div>
        <div class="flex items-center gap-2">
          <span class="text-xs px-2 py-1 rounded-full bg-asak-gold-muted text-asak-gold">
            Anti-Chaos CMS
          </span>
        </div>
      </header>

      <!-- Flash Messages -->
      <div v-if="flash.success || flash.error" class="px-6 pt-4">
        <div v-if="flash.success" class="p-4 rounded-xl text-sm mb-0 flex items-center gap-3 bg-green-500/10 border border-green-500/20 text-green-300">
          <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
          {{ flash.success }}
        </div>
        <div v-if="flash.error" class="p-4 rounded-xl text-sm flex items-center gap-3 bg-red-500/10 border border-red-500/20 text-red-300">
          <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
          {{ flash.error }}
        </div>
      </div>

      <!-- Page Content -->
      <main class="p-6">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Link, usePage, router } from '@inertiajs/vue3'

const props = defineProps({
  title: { type: String, default: 'Dashboard' },
  unreadCount: { type: Number, default: 0 },
})

const sidebarOpen = ref(false)
const page = usePage()
const flash = computed(() => page.props.flash || {})

function navClass(routeName) {
  const isActive = route().current(routeName + '.*') || route().current(routeName)
  return [
    'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all w-full',
    isActive
      ? 'font-medium bg-asak-gold/15 text-asak-gold'
      : 'text-admin-text-dim hover:bg-white/5',
  ].join(' ')
}

function logout() {
  router.post(route('logout'))
}
</script>
