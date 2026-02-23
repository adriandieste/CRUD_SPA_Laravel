<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { useTranslation } from '@/composables/useTranslation'
import { type BreadcrumbItem } from '@/types'
import { Plus, Users, ClipboardList, Edit2, Trash2, Eye, ArrowRight } from 'lucide-vue-next'

const { t } = useTranslation()

defineProps<{
    proyectos: any[]
    alumnos: any[]
    stats: {
        total_proyectos: number
        total_alumnos: number
    }
}>()

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: t('dashboard.title'),
        href: '/dashboard',
    },
]
</script>

<template>
    <Head :title="t('dashboard.title')" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-8 p-6">
            <!-- Welcome Section -->
            <div>
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white">
                    {{ t('dashboard.welcome') }}, {{ $page.props.auth.user?.name }}!
                </h1>
                <p class="mt-2 text-lg text-gray-600 dark:text-gray-400">
                    {{ t('forms.required') }}
                </p>
            </div>

            <!-- Statistics Cards -->
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ t('dashboard.proyectos') }}</p>
                            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                                {{ stats.total_proyectos }}
                            </p>
                        </div>
                        <div class="rounded-full bg-blue-100 p-3 dark:bg-blue-900">
                            <ClipboardList class="h-6 w-6 text-blue-600 dark:text-blue-300" />
                        </div>
                    </div>
                </div>

                <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ t('alumnos.title') }}</p>
                            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                                {{ stats.total_alumnos }}
                            </p>
                        </div>
                        <div class="rounded-full bg-green-100 p-3 dark:bg-green-900">
                            <Users class="h-6 w-6 text-green-600 dark:text-green-300" />
                        </div>
                    </div>
                </div>

                <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ t('nav.profile') }}</p>
                            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                                {{ $page.props.auth.user?.name?.split(' ')[0] }}
                            </p>
                        </div>
                        <div class="rounded-full bg-purple-100 p-3 dark:bg-purple-900">
                            <Eye class="h-6 w-6 text-purple-600 dark:text-purple-300" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Proyectos Section -->
            <div>
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ t('dashboard.proyectos') }}
                        </h2>
                        <p class="mt-1 text-gray-600 dark:text-gray-400">
                            {{ t('proyectos.no_projects') }}
                        </p>
                    </div>
                    <Link
                        href="/proyectos"
                        class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600"
                    >
                        <Plus class="h-4 w-4" />
                        {{ t('proyectos.add') }}
                    </Link>
                </div>

                <div v-if="proyectos.length > 0" class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <Link
                        v-for="proyecto in proyectos"
                        :key="proyecto.id"
                        :href="`/proyectos/${proyecto.id}/alumnos`"
                        class="group rounded-lg border border-gray-200 bg-white p-6 shadow-sm transition hover:shadow-lg dark:border-gray-700 dark:bg-gray-800"
                    >
                        <div class="mb-4 flex items-start justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 group-hover:text-blue-600 dark:text-white">
                                    {{ proyecto.nombre }}
                                </h3>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ proyecto.descripcion }}
                                </p>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center justify-between">
                            <span class="inline-flex items-center gap-1 rounded-full bg-blue-100 px-3 py-1 text-sm font-medium text-blue-700 dark:bg-blue-900 dark:text-blue-300">
                                <Users class="h-4 w-4" />
                                {{ proyecto.alumnos_count }} {{ t('alumnos.title') }}
                            </span>
                            <ArrowRight class="h-4 w-4 text-gray-400 group-hover:text-blue-600" />
                        </div>
                    </Link>
                </div>

                <div v-else class="rounded-lg border border-gray-200 bg-gray-50 p-12 text-center dark:border-gray-700 dark:bg-gray-800">
                    <ClipboardList class="mx-auto h-12 w-12 text-gray-400" />
                    <p class="mt-4 text-gray-600 dark:text-gray-400">
                        {{ t('proyectos.no_projects') }}
                    </p>
                    <Link
                        href="/proyectos"
                        class="mt-4 inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600"
                    >
                        <Plus class="h-4 w-4" />
                        {{ t('proyectos.add') }}
                    </Link>
                </div>
            </div>

            <!-- Alumnos Recientes Section -->
            <div v-if="alumnos.length > 0">
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ t('alumnos.title') }} Recientes
                        </h2>
                        <p class="mt-1 text-gray-600 dark:text-gray-400">
                            Últimos alumnos agregados
                        </p>
                    </div>
                </div>

                <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                    <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ t('alumnos.name') }}
                                </th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ t('alumnos.email') }}
                                </th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ t('alumnos.phone') }}
                                </th>
                                <th class="px-6 py-3 text-right text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ t('common.actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-900">
                            <tr v-for="alumno in alumnos.slice(0, 5)" :key="alumno.id" class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                    {{ alumno.nombre }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                    {{ alumno.email }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                    {{ alumno.telefono }}
                                </td>
                                <td class="px-6 py-4 text-right text-sm">
                                    <div class="flex items-center justify-end gap-2">
                                        <button
                                            class="rounded-md px-3 py-1 text-gray-400 hover:bg-gray-100 hover:text-blue-600 dark:hover:bg-gray-700 dark:hover:text-blue-400"
                                            title="Ver detalles"
                                        >
                                            <Eye class="h-4 w-4" />
                                        </button>
                                        <button
                                            class="rounded-md px-3 py-1 text-gray-400 hover:bg-gray-100 hover:text-green-600 dark:hover:bg-gray-700 dark:hover:text-green-400"
                                            title="Editar"
                                        >
                                            <Edit2 class="h-4 w-4" />
                                        </button>
                                        <button
                                            class="rounded-md px-3 py-1 text-gray-400 hover:bg-gray-100 hover:text-red-600 dark:hover:bg-gray-700 dark:hover:text-red-400"
                                            title="Eliminar"
                                        >
                                            <Trash2 class="h-4 w-4" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 text-center">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Mostrando 5 de {{ alumnos.length }} alumnos (ver lista completa en Proyectos)
                    </p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

