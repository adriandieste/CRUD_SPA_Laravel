<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import { useTranslation } from '@/composables/useTranslation'
import LanguageSwitcher from '@/components/LanguageSwitcher.vue'
import { ClipboardList, Users, LogIn, UserPlus, ArrowRight } from 'lucide-vue-next'

const { t } = useTranslation()

defineProps<{
    canRegister: boolean
}>()
</script>

<template>
    <Head title="CRUD SPA - Laravel & Vue.js" />

    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900">
        <!-- Language Switcher -->
        <div class="absolute right-6 top-6">
            <LanguageSwitcher />
        </div>

        <!-- Navigation -->
        <nav class="border-b border-slate-700 bg-black/20 backdrop-blur-sm">
            <div class="mx-auto max-w-5xl px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="rounded-lg bg-blue-600 p-2">
                            <ClipboardList class="h-6 w-6 text-white" />
                        </div>
                        <h1 class="text-2xl font-bold text-white">{{ t('proyectos.title') }} & {{ t('alumnos.title') }}</h1>
                    </div>
                    <div class="flex gap-3">
                        <Link
                            href="/login"
                            class="inline-flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-semibold text-white hover:bg-white/10 transition"
                        >
                            <LogIn class="h-4 w-4" />
                            {{ t('nav.login') }}
                        </Link>
                        <Link
                            v-if="canRegister"
                            href="/register"
                            class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition"
                        >
                            <UserPlus class="h-4 w-4" />
                            {{ t('nav.register') }}
                        </Link>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="mx-auto max-w-5xl px-6 py-20">
            <div class="text-center">
                <h2 class="text-5xl font-bold text-white mb-4">
                    {{ t('hero.title') }}
                </h2>
                <p class="text-xl text-slate-300 mb-8">
                    {{ t('hero.subtitle') }}
                </p>
                <Link
                    href="/register"
                    class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-8 py-3 text-lg font-semibold text-white hover:bg-blue-700 transition"
                >
                    {{ t('hero.cta') }}
                    <ArrowRight class="h-5 w-5" />
                </Link>
            </div>

            <!-- Features Grid -->
            <div class="mt-24 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                <!-- Proyectos Feature -->
                <div class="rounded-lg border border-slate-700 bg-slate-800/50 p-8 backdrop-blur-sm hover:border-blue-500 hover:bg-slate-800/80 transition">
                    <div class="rounded-lg bg-blue-600/20 p-3 w-fit mb-4">
                        <ClipboardList class="h-8 w-8 text-blue-400" />
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">
                        {{ t('dashboard.proyectos') }}
                    </h3>
                    <p class="text-slate-300 mb-4">
                        Gestiona tus proyectos de forma intuitiva
                    </p>
                    <div class="flex items-center text-blue-400">
                        <span class="text-sm">{{ t('common.actions') }}</span>
                        <ArrowRight class="h-4 w-4 ml-2" />
                    </div>
                </div>

                <!-- Alumnos Feature -->
                <div class="rounded-lg border border-slate-700 bg-slate-800/50 p-8 backdrop-blur-sm hover:border-green-500 hover:bg-slate-800/80 transition">
                    <div class="rounded-lg bg-green-600/20 p-3 w-fit mb-4">
                        <Users class="h-8 w-8 text-green-400" />
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">
                        {{ t('alumnos.title') }}
                    </h3>
                    <p class="text-slate-300 mb-4">
                        Administra información de alumnos fácilmente
                    </p>
                    <div class="flex items-center text-green-400">
                        <span class="text-sm">{{ t('common.actions') }}</span>
                        <ArrowRight class="h-4 w-4 ml-2" />
                    </div>
                </div>

                <!-- CRUD Feature -->
                <div class="rounded-lg border border-slate-700 bg-slate-800/50 p-8 backdrop-blur-sm hover:border-purple-500 hover:bg-slate-800/80 transition">
                    <div class="rounded-lg bg-purple-600/20 p-3 w-fit mb-4">
                        <ClipboardList class="h-8 w-8 text-purple-400" />
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">
                        CRUD Completo
                    </h3>
                    <p class="text-slate-300 mb-4">
                        Crear, editar, ver y eliminar con facilidad
                    </p>
                    <div class="flex items-center text-purple-400">
                        <span class="text-sm">Operaciones Completas</span>
                        <ArrowRight class="h-4 w-4 ml-2" />
                    </div>
                </div>

                <!-- Multiidioma Feature -->
                <div class="rounded-lg border border-slate-700 bg-slate-800/50 p-8 backdrop-blur-sm hover:border-yellow-500 hover:bg-slate-800/80 transition">
                    <div class="rounded-lg bg-yellow-600/20 p-3 w-fit mb-4">
                        <span class="text-2xl">🌐</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">
                        {{ t('common.language') }}
                    </h3>
                    <p class="text-slate-300 mb-4">
                        Soporta Español, Inglés y Francés
                    </p>
                    <div class="flex items-center text-yellow-400">
                        <span class="text-sm">3 Idiomas</span>
                        <ArrowRight class="h-4 w-4 ml-2" />
                    </div>
                </div>

                <!-- Seguridad Feature -->
                <div class="rounded-lg border border-slate-700 bg-slate-800/50 p-8 backdrop-blur-sm hover:border-red-500 hover:bg-slate-800/80 transition">
                    <div class="rounded-lg bg-red-600/20 p-3 w-fit mb-4">
                        <span class="text-2xl">🔒</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">
                        Seguridad
                    </h3>
                    <p class="text-slate-300 mb-4">
                        Autenticación segura y autorización
                    </p>
                    <div class="flex items-center text-red-400">
                        <span class="text-sm">{{ t('common.password') }}</span>
                        <ArrowRight class="h-4 w-4 ml-2" />
                    </div>
                </div>

                <!-- Performance Feature -->
                <div class="rounded-lg border border-slate-700 bg-slate-800/50 p-8 backdrop-blur-sm hover:border-cyan-500 hover:bg-slate-800/80 transition">
                    <div class="rounded-lg bg-cyan-600/20 p-3 w-fit mb-4">
                        <span class="text-2xl">⚡</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">
                        Performance
                    </h3>
                    <p class="text-slate-300 mb-4">
                        Construido con Laravel 11 y Vue 3
                    </p>
                    <div class="flex items-center text-cyan-400">
                        <span class="text-sm">Lightning Fast</span>
                        <ArrowRight class="h-4 w-4 ml-2" />
                    </div>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="mt-24 rounded-lg border border-slate-700 bg-gradient-to-r from-blue-600/20 to-purple-600/20 p-12 text-center">
                <h3 class="text-3xl font-bold text-white mb-4">
                    {{ t('common.welcome') }} a la Aplicación CRUD
                </h3>
                <p class="text-lg text-slate-300 mb-8">
                    Comienza a gestionar tus proyectos y alumnos hoy mismo
                </p>
                <div class="flex gap-4 justify-center">
                    <Link
                        v-if="canRegister"
                        href="/register"
                        class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-8 py-3 text-lg font-semibold text-white hover:bg-blue-700 transition"
                    >
                        {{ t('nav.register') }}
                    </Link>
                    <Link
                        href="/login"
                        class="inline-flex items-center gap-2 rounded-lg border border-slate-600 px-8 py-3 text-lg font-semibold text-white hover:border-slate-400 hover:bg-slate-800/50 transition"
                    >
                        {{ t('nav.login') }}
                    </Link>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="border-t border-slate-700 bg-black/40 py-8 mt-24">
            <div class="mx-auto max-w-5xl px-6 text-center text-slate-400">
                <p>CRUD SPA builded with Laravel 11 & Vue 3</p>
            </div>
        </div>
    </div>
</template>
