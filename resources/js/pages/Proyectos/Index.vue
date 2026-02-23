<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { useTranslation } from '@/composables/useTranslation'

interface Proyecto {
    id: number
    nombre: string
    descripcion: string | null
    alumnos: Array<{ id: number }>
}

const { t } = useTranslation()

defineProps<{
    proyectos: Proyecto[]
}>()
</script>

<template>
    <Head :title="t('proyectos.title')" />

    <AppLayout>
        <div class="space-y-6 py-12">
            <div>
                <h1 class="text-3xl font-bold">{{ t('proyectos.title') }}</h1>
                <p class="text-gray-600 dark:text-gray-400">{{ t('dashboard.proyectos') }}</p>
            </div>

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                <div
                    v-for="proyecto in proyectos"
                    :key="proyecto.id"
                    class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm hover:shadow-md dark:border-gray-700 dark:bg-gray-800"
                >
                    <h3 class="mb-2 text-xl font-semibold text-gray-900 dark:text-white">{{ proyecto.nombre }}</h3>
                    <p class="mb-4 text-sm text-gray-600 dark:text-gray-400">{{ proyecto.descripcion }}</p>
                    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                        <p>{{ t('proyectos.students_count') }}: {{ proyecto.alumnos.length }}</p>
                    </div>
                    <Link
                        :href="`/proyectos/${proyecto.id}/alumnos`"
                        class="inline-block rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
                    >
                        {{ t('alumnos.title') }}
                    </Link>
                </div>

                <div
                    v-if="!proyectos.length"
                    class="col-span-full rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 p-12 text-center dark:border-gray-600 dark:bg-gray-800"
                >
                    <p class="text-gray-600 dark:text-gray-400">{{ t('proyectos.no_projects') }}</p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
