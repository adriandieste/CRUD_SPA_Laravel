<script setup lang="ts">
import { computed, ref } from 'vue'
import { Head, Link, router, usePage } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { useTranslation } from '@/composables/useTranslation'
import Swal from 'sweetalert2'

interface Alumno {
    id: number
    nombre: string
    email: string
    telefono: string | null
    fecha_nacimiento: string | null
    created_at: string
}

interface Proyecto {
    id: number
    nombre: string
}

const page = usePage()
const { t } = useTranslation()

const props = defineProps<{
    proyecto: Proyecto
    alumnos: {
        data: Alumno[]
        current_page: number
        last_page: number
        per_page: number
        total: number
    }
}>()

const showForm = ref(false)
const editingId = ref<number | null>(null)

const formData = ref({
    nombre: '',
    email: '',
    telefono: '',
    fecha_nacimiento: '',
})

const errors = ref<Record<string, string>>({})

const submit = () => {
    errors.value = {}

    if (editingId.value) {
        router.put(
            `/proyectos/${props.proyecto.id}/alumnos/${editingId.value}`,
            formData.value,
            {
                onError: (err) => {
                    errors.value = err as Record<string, string>
                },
                onSuccess: () => {
                    resetForm()
                    Swal.fire({
                        title: t('common.success'),
                        text: t('alumnos.updated_success'),
                        icon: 'success',
                        timer: 2000,
                    })
                },
            }
        )
    } else {
        router.post(`/proyectos/${props.proyecto.id}/alumnos`, formData.value, {
            onError: (err) => {
                errors.value = err as Record<string, string>
            },
            onSuccess: () => {
                resetForm()
                Swal.fire({
                    title: t('common.success'),
                    text: t('alumnos.created_success'),
                    icon: 'success',
                    timer: 2000,
                })
            },
        })
    }
}

const startEdit = (alumno: Alumno) => {
    editingId.value = alumno.id
    formData.value = {
        nombre: alumno.nombre,
        email: alumno.email,
        telefono: alumno.telefono || '',
        fecha_nacimiento: alumno.fecha_nacimiento || '',
    }
    showForm.value = true
}

const deleteAlumno = (id: number) => {
    Swal.fire({
        title: t('common.confirm_delete'),
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: t('common.yes'),
        cancelButtonText: t('common.no'),
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(`/proyectos/${props.proyecto.id}/alumnos/${id}`, {
                onSuccess: () => {
                    Swal.fire({
                        title: t('common.success'),
                        text: t('alumnos.deleted_success'),
                        icon: 'success',
                        timer: 2000,
                    })
                },
            })
        }
    })
}

const resetForm = () => {
    formData.value = {
        nombre: '',
        email: '',
        telefono: '',
        fecha_nacimiento: '',
    }
    editingId.value = null
    showForm.value = false
    errors.value = {}
}
</script>

<template>
    <Head :title="`${proyecto.nombre} - ${t('alumnos.title')}`" />

    <AppLayout>
        <div class="space-y-6 py-12">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold">{{ proyecto.nombre }}</h1>
                    <p class="text-gray-600 dark:text-gray-400">{{ t('alumnos.title') }}</p>
                </div>
                <div class="flex gap-2">
                    <Link
                        :href="`/proyectos`"
                        class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700"
                    >
                        {{ t('common.back') }}
                    </Link>
                    <button
                        v-if="!showForm"
                        @click="showForm = true"
                        class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
                    >
                        {{ t('alumnos.add') }}
                    </button>
                </div>
            </div>

            <!-- Form -->
            <div v-if="showForm" class="rounded-lg border border-gray-200 bg-white p-6 dark:border-gray-700 dark:bg-gray-800">
                <h2 class="mb-4 text-xl font-semibold">{{ editingId ? t('common.edit') : t('alumnos.add') }}</h2>
                <form @submit.prevent="submit" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-900 dark:text-white">
                            {{ t('alumnos.name') }} *
                        </label>
                        <input
                            v-model="formData.nombre"
                            type="text"
                            class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                            :placeholder="t('alumnos.name')"
                        />
                        <p v-if="errors.nombre" class="mt-1 text-sm text-red-600">{{ errors.nombre }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-900 dark:text-white">
                            {{ t('alumnos.email') }} *
                        </label>
                        <input
                            v-model="formData.email"
                            type="email"
                            class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                            :placeholder="t('alumnos.email')"
                        />
                        <p v-if="errors.email" class="mt-1 text-sm text-red-600">{{ errors.email }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-900 dark:text-white">
                            {{ t('alumnos.phone') }}
                        </label>
                        <input
                            v-model="formData.telefono"
                            type="tel"
                            class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                            :placeholder="t('alumnos.phone')"
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-900 dark:text-white">
                            {{ t('alumnos.birthdate') }}
                        </label>
                        <input
                            v-model="formData.fecha_nacimiento"
                            type="date"
                            class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                        />
                    </div>

                    <div class="flex gap-2">
                        <button
                            type="submit"
                            class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
                        >
                            {{ t('common.save') }}
                        </button>
                        <button
                            type="button"
                            @click="resetForm"
                            class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                        >
                            {{ t('common.cancel') }}
                        </button>
                    </div>
                </form>
            </div>

            <!-- Table -->
            <div class="rounded-lg border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800">
                <table class="w-full">
                    <thead class="border-b border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-900">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-900 dark:text-white">
                                {{ t('alumnos.name') }}
                            </th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-900 dark:text-white">
                                {{ t('alumnos.email') }}
                            </th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-900 dark:text-white">
                                {{ t('alumnos.phone') }}
                            </th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-900 dark:text-white">
                                {{ t('common.actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="alumno in alumnos.data"
                            :key="alumno.id"
                            class="border-b border-gray-200 hover:bg-gray-50 dark:border-gray-700 dark:hover:bg-gray-700"
                        >
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ alumno.nombre }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ alumno.email }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ alumno.telefono || '-' }}</td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex gap-2">
                                    <button
                                        @click="startEdit(alumno)"
                                        class="text-blue-600 hover:text-blue-800 dark:text-blue-400"
                                    >
                                        {{ t('common.edit') }}
                                    </button>
                                    <button
                                        @click="deleteAlumno(alumno.id)"
                                        class="text-red-600 hover:text-red-800 dark:text-red-400"
                                    >
                                        {{ t('common.delete') }}
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="!alumnos.data.length">
                            <td :colspan="4" class="px-6 py-8 text-center text-gray-600 dark:text-gray-400">
                                {{ t('alumnos.no_students') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div v-if="alumnos.last_page > 1" class="flex items-center justify-center gap-2">
                <Link
                    v-for="page in alumnos.last_page"
                    :key="page"
                    :href="`/proyectos/${proyecto.id}/alumnos?page=${page}`"
                    :class="[
                        'rounded px-3 py-2 text-sm',
                        page === alumnos.current_page
                            ? 'bg-blue-600 text-white'
                            : 'border border-gray-300 bg-white text-gray-900 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-white',
                    ]"
                >
                    {{ page }}
                </Link>
            </div>
        </div>
    </AppLayout>
</template>
