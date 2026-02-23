<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { useTranslation } from '@/composables/useTranslation'
import LanguageSwitcher from '@/components/LanguageSwitcher.vue'
import { home } from '@/routes'

const { t } = useTranslation()

defineProps<{
    title?: string
    description?: string
}>()
</script>

<template>
    <div class="flex min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800">
        <!-- Left Side - Logo & Features -->
        <div class="hidden w-1/2 flex-col justify-between bg-gradient-to-br from-blue-600 to-indigo-700 p-12 text-white lg:flex">
            <div>
                <Link :href="home()" class="flex items-center gap-2 text-2xl font-bold">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-white bg-opacity-20">
                        📋
                    </div>
                    CRUD SPA
                </Link>
            </div>

            <div class="space-y-8">
                <div class="space-y-4">
                    <h2 class="text-3xl font-bold">Gestiona tus proyectos</h2>
                    <p class="text-lg text-blue-100">
                        Una plataforma moderna para administrar tus proyectos y alumnos de forma eficiente.
                    </p>
                </div>

                <div class="space-y-4">
                    <div class="flex gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white bg-opacity-20">
                            ✓
                        </div>
                        <div>
                            <h3 class="font-semibold">CRUD Completo</h3>
                            <p class="text-sm text-blue-100">Crea, lee, actualiza y elimina alumnos fácilmente</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white bg-opacity-20">
                            ✓
                        </div>
                        <div>
                            <h3 class="font-semibold">Multiidioma</h3>
                            <p class="text-sm text-blue-100">Soporta español, inglés y francés</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white bg-opacity-20">
                            ✓
                        </div>
                        <div>
                            <h3 class="font-semibold">Seguro</h3>
                            <p class="text-sm text-blue-100">Autenticación y validación de dos factores</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-sm text-blue-200">© 2026 CRUD SPA. Todos los derechos reservados.</div>
        </div>

        <!-- Right Side - Form -->
        <div class="flex w-full flex-col items-center justify-center px-6 py-12 lg:w-1/2">
            <div class="absolute right-6 top-6">
                <LanguageSwitcher />
            </div>

            <div class="w-full max-w-md">
                <!-- Logo Mobile -->
                <div class="mb-8 flex flex-col items-center gap-4 lg:hidden">
                    <Link :href="home()" class="flex items-center gap-2 text-2xl font-bold text-gray-900 dark:text-white">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-600">
                            📋
                        </div>
                        CRUD SPA
                    </Link>
                </div>

                <!-- Form Header -->
                <div class="mb-8 text-center">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ title }}</h1>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">{{ description }}</p>
                </div>

                <!-- Form -->
                <div class="rounded-xl bg-white p-8 shadow-lg dark:bg-gray-800">
                    <slot />
                </div>
            </div>
        </div>
    </div>
</template>

