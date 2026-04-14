<template>
  <AdminLayout title="Settings">
    <div class="max-w-3xl space-y-6">
      <div>
        <h2 class="text-xl font-bold" style="font-family: 'Space Grotesk', sans-serif">Pengaturan Website</h2>
        <p class="text-sm mt-1" style="color: #6b7280">Kelola konten dan konfigurasi website ASAK Agency.</p>
      </div>

      <form @submit.prevent="submit" class="space-y-6">

        <!-- Hero Section -->
        <div class="rounded-2xl overflow-hidden" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07)">
          <div class="px-6 py-4" style="border-bottom: 1px solid rgba(255,255,255,0.07)">
            <h3 class="font-semibold" style="font-family: 'Space Grotesk', sans-serif">Hero Section</h3>
            <p class="text-xs mt-0.5" style="color: #6b7280">Teks utama yang tampil di homepage</p>
          </div>
          <div class="p-6 space-y-4">
            <SettingField label="Badge Text" v-model="form['hero.badge_text']" placeholder="The Anti-Chaos Agency" />
            <SettingField label="Headline" v-model="form['hero.headline']" placeholder="Done Right." />
            <SettingField label="Headline Accent" v-model="form['hero.headline_accent']" placeholder="Done On Time." />
            <SettingField label="Sub-Headline" v-model="form['hero.subheadline']" :multiline="true"
                          placeholder="We are the anti-chaos agency..." />
            <div class="grid sm:grid-cols-2 gap-4">
              <SettingField label="CTA Tombol Utama" v-model="form['hero.cta_primary']" placeholder="Start a Project" />
              <SettingField label="CTA Tombol Kedua" v-model="form['hero.cta_secondary']" placeholder="View Our Work" />
            </div>
          </div>
        </div>

        <!-- Stats -->
        <div class="rounded-2xl overflow-hidden" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07)">
          <div class="px-6 py-4" style="border-bottom: 1px solid rgba(255,255,255,0.07)">
            <h3 class="font-semibold" style="font-family: 'Space Grotesk', sans-serif">Statistik</h3>
          </div>
          <div class="p-6 grid sm:grid-cols-2 gap-4">
            <SettingField label="Projects Completed" v-model="form['stats.projects']" placeholder="150+" />
            <SettingField label="Happy Clients" v-model="form['stats.clients']" placeholder="50+" />
            <SettingField label="Years Experience" v-model="form['stats.experience']" placeholder="5+" />
            <SettingField label="Awards Won" v-model="form['stats.awards']" placeholder="15+" />
          </div>
        </div>

        <!-- About -->
        <div class="rounded-2xl overflow-hidden" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07)">
          <div class="px-6 py-4" style="border-bottom: 1px solid rgba(255,255,255,0.07)">
            <h3 class="font-semibold" style="font-family: 'Space Grotesk', sans-serif">Halaman About</h3>
          </div>
          <div class="p-6 space-y-4">
            <SettingField label="Hero Title" v-model="form['about.hero_title']" placeholder="The Anti-Chaos Agency" />
            <SettingField label="Hero Subtitle" v-model="form['about.hero_subtitle']" :multiline="true"
                          placeholder="Born from the high-volume demands..." />
            <SettingField label="Philosophy Quote" v-model="form['about.philosophy']" placeholder='"Asak" Means Mature. Ready.' />
            <SettingField label="Story Paragraph 1" v-model="form['about.story_text_1']" :multiline="true" />
            <SettingField label="Story Paragraph 2" v-model="form['about.story_text_2']" :multiline="true" />
            <SettingField label="Story Paragraph 3" v-model="form['about.story_text_3']" :multiline="true" />
          </div>
        </div>

        <!-- Contact Info -->
        <div class="rounded-2xl overflow-hidden" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07)">
          <div class="px-6 py-4" style="border-bottom: 1px solid rgba(255,255,255,0.07)">
            <h3 class="font-semibold" style="font-family: 'Space Grotesk', sans-serif">Informasi Kontak</h3>
          </div>
          <div class="p-6 space-y-4">
            <SettingField label="Email" v-model="form['contact.email']" type="email" placeholder="hello@asak.agency" />
            <SettingField label="Website" v-model="form['contact.website']" placeholder="www.asak.agency" />
            <SettingField label="Alamat" v-model="form['contact.address']" placeholder="Jakarta, Indonesia" />
            <SettingField label="Response Time" v-model="form['contact.response_time']" placeholder="Zero-Delay Protocol Active" />
          </div>
        </div>

        <!-- Social Links -->
        <div class="rounded-2xl overflow-hidden" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07)">
          <div class="px-6 py-4" style="border-bottom: 1px solid rgba(255,255,255,0.07)">
            <h3 class="font-semibold" style="font-family: 'Space Grotesk', sans-serif">Social Media</h3>
          </div>
          <div class="p-6 space-y-4">
            <SettingField label="Instagram URL" v-model="form['social.instagram']" type="url" placeholder="https://instagram.com/..." />
            <SettingField label="Twitter / X URL" v-model="form['social.twitter']" type="url" placeholder="https://twitter.com/..." />
            <SettingField label="LinkedIn URL" v-model="form['social.linkedin']" type="url" placeholder="https://linkedin.com/company/..." />
          </div>
        </div>

        <div class="flex items-center gap-3 pb-6">
          <button type="submit" :disabled="isSubmitting"
                  class="flex items-center gap-2 px-8 py-3 rounded-xl font-semibold text-sm transition-opacity hover:opacity-90 disabled:opacity-50"
                  style="background: #b8960c; color: white">
            <svg v-if="isSubmitting" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
            Simpan Semua Perubahan
          </button>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { router } from '@inertiajs/vue3'
import { ref, defineComponent, h } from 'vue'

const props = defineProps({
  hero: Object,
  about: Object,
  stats: Object,
  contact: Object,
  social: Object,
})

// Flatten all setting groups into one form object
const form = ref({
  'hero.badge_text': props.hero?.['hero.badge_text'] ?? '',
  'hero.headline': props.hero?.['hero.headline'] ?? '',
  'hero.headline_accent': props.hero?.['hero.headline_accent'] ?? '',
  'hero.subheadline': props.hero?.['hero.subheadline'] ?? '',
  'hero.cta_primary': props.hero?.['hero.cta_primary'] ?? '',
  'hero.cta_secondary': props.hero?.['hero.cta_secondary'] ?? '',
  'stats.projects': props.stats?.['stats.projects'] ?? '',
  'stats.clients': props.stats?.['stats.clients'] ?? '',
  'stats.experience': props.stats?.['stats.experience'] ?? '',
  'stats.awards': props.stats?.['stats.awards'] ?? '',
  'about.hero_title': props.about?.['about.hero_title'] ?? '',
  'about.hero_subtitle': props.about?.['about.hero_subtitle'] ?? '',
  'about.philosophy': props.about?.['about.philosophy'] ?? '',
  'about.story_text_1': props.about?.['about.story_text_1'] ?? '',
  'about.story_text_2': props.about?.['about.story_text_2'] ?? '',
  'about.story_text_3': props.about?.['about.story_text_3'] ?? '',
  'contact.email': props.contact?.['contact.email'] ?? '',
  'contact.website': props.contact?.['contact.website'] ?? '',
  'contact.address': props.contact?.['contact.address'] ?? '',
  'contact.response_time': props.contact?.['contact.response_time'] ?? '',
  'social.instagram': props.social?.['social.instagram'] ?? '',
  'social.twitter': props.social?.['social.twitter'] ?? '',
  'social.linkedin': props.social?.['social.linkedin'] ?? '',
})

const isSubmitting = ref(false)

function submit() {
  isSubmitting.value = true
  // Regroup into nested structure expected by controller
  const payload = {
    hero: {
      badge_text: form.value['hero.badge_text'],
      headline: form.value['hero.headline'],
      headline_accent: form.value['hero.headline_accent'],
      subheadline: form.value['hero.subheadline'],
      cta_primary: form.value['hero.cta_primary'],
      cta_secondary: form.value['hero.cta_secondary'],
    },
    stats: {
      projects: form.value['stats.projects'],
      clients: form.value['stats.clients'],
      experience: form.value['stats.experience'],
      awards: form.value['stats.awards'],
    },
    about: {
      hero_title: form.value['about.hero_title'],
      hero_subtitle: form.value['about.hero_subtitle'],
      philosophy: form.value['about.philosophy'],
      story_text_1: form.value['about.story_text_1'],
      story_text_2: form.value['about.story_text_2'],
      story_text_3: form.value['about.story_text_3'],
    },
    contact: {
      email: form.value['contact.email'],
      website: form.value['contact.website'],
      address: form.value['contact.address'],
      response_time: form.value['contact.response_time'],
    },
    social: {
      instagram: form.value['social.instagram'],
      twitter: form.value['social.twitter'],
      linkedin: form.value['social.linkedin'],
    },
  }
  router.post(route('admin.settings.update'), payload, {
    onFinish: () => { isSubmitting.value = false },
  })
}

// Inline reusable field component
const SettingField = defineComponent({
  props: {
    label: String,
    modelValue: String,
    placeholder: String,
    type: { type: String, default: 'text' },
    multiline: { type: Boolean, default: false },
  },
  emits: ['update:modelValue'],
  setup(props, { emit }) {
    const inputStyle = 'background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #e8e4d5'
    return () => h('div', [
      h('label', { style: 'display:block; font-size:0.75rem; margin-bottom:4px; color:#9ca3af' }, props.label),
      props.multiline
        ? h('textarea', {
            value: props.modelValue,
            onInput: e => emit('update:modelValue', e.target.value),
            rows: 3,
            placeholder: props.placeholder,
            style: inputStyle,
            class: 'w-full rounded-lg px-3 py-2 text-sm resize-none',
          })
        : h('input', {
            type: props.type,
            value: props.modelValue,
            onInput: e => emit('update:modelValue', e.target.value),
            placeholder: props.placeholder,
            style: inputStyle,
            class: 'w-full rounded-lg h-10 px-3 text-sm',
          })
    ])
  }
})
</script>
