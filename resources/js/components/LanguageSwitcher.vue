<script setup lang="ts">
import { useTranslation, type SupportedLocale } from '@/composables/useTranslation'

const { currentLocale, setLocale, t } = useTranslation()

const languages: { code: SupportedLocale; name: string }[] = [
    { code: 'es', name: 'Español' },
    { code: 'en', name: 'English' },
    { code: 'fr', name: 'Français' },
]

const changeLanguage = (locale: SupportedLocale) => {
    setLocale(locale)
}
</script>

<template>
    <div class="flex items-center gap-2">
        <label :for="'language-select'" class="text-sm font-medium">{{ t('common.language') }}:</label>
        <select
            id="language-select"
            :value="currentLocale"
            @change="(e) => changeLanguage((e.target as HTMLSelectElement).value as SupportedLocale)"
            class="rounded-lg border border-gray-300 bg-white px-3 py-1 text-sm text-gray-900 hover:border-gray-400 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
        >
            <option v-for="lang in languages" :key="lang.code" :value="lang.code">
                {{ lang.name }}
            </option>
        </select>
    </div>
</template>
