import { ref, watch } from 'vue'

export type SupportedLocale = 'es' | 'en' | 'fr'

const currentLocale = ref<SupportedLocale>('es')
const translations = ref<Record<SupportedLocale, Record<string, any>>>({
    es: {},
    en: {},
    fr: {},
})

export const useTranslation = () => {
    const setLocale = (locale: SupportedLocale) => {
        currentLocale.value = locale
        localStorage.setItem('app-locale', locale)
    }

    const getLocale = (): SupportedLocale => {
        const stored = localStorage.getItem('app-locale') as SupportedLocale | null
        if (stored && ['es', 'en', 'fr'].includes(stored)) {
            return stored
        }
        return 'es'
    }

    const t = (key: string): string => {
        const keys = key.split('.')
        let value: any = translations.value[currentLocale.value]

        for (const k of keys) {
            value = value?.[k]
        }

        return value || key
    }

    const setTranslations = (locale: SupportedLocale, strings: Record<string, any>) => {
        translations.value[locale] = strings
    }

    const initializeLocale = () => {
        const saved = getLocale()
        currentLocale.value = saved
    }

    return {
        currentLocale,
        setLocale,
        getLocale,
        t,
        setTranslations,
        initializeLocale,
    }
}
