<script setup lang="ts">
import { ref } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { useTranslation } from '@/composables/useTranslation'
import Swal from 'sweetalert2'
import { Plus, Edit2, Trash2, X } from 'lucide-vue-next'

interface Proyecto {
    id: number
    nombre: string
    descripcion: string | null
    alumnos: Array<{ id: number }>
}

const { t } = useTranslation()

const props = defineProps<{
    proyectos: Proyecto[]
}>()

const showForm = ref(false)
const editingId = ref<number | null>(null)
const formData = ref({
    nombre: '',
    descripcion: '',
})
const errors = ref<Record<string, string>>({})

const submit = () => {
    errors.value = {}

    if (editingId.value) {
        router.put(
            `/proyectos/${editingId.value}`,
            formData.value,
            {
                onError: (err) => {
                    errors.value = err as Record<string, string>
                },
                onSuccess: () => {
                    resetForm()
                    Swal.fire({
                        title: t('common.success'),
                        text: t('proyectos.updated_success'),
                        icon: 'success',
                        timer: 2000,
                    })
                },
            }
        )
    } else {
        router.post(`/proyectos`, formData.value, {
            onError: (err) => {
                errors.value = err as Record<string, string>
            },
            onSuccess: () => {
                resetForm()
                Swal.fire({
                    title: t('common.success'),
                    text: t('proyectos.created_success'),
                    icon: 'success',
                    timer: 2000,
                })
            },
        })
    }
}

const startEdit = (proyecto: Proyecto) => {
    editingId.value = proyecto.id
    formData.value = {
        nombre: proyecto.nombre,
        descripcion: proyecto.descripcion || '',
    }
    showForm.value = true
}

const deleteProyecto = (id: number) => {
    Swal.fire({
        title: t('common.confirm_delete'),
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: t('common.yes'),
        cancelButtonText: t('common.no'),
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(`/proyectos/${id}`, {
                onSuccess: () => {
                    Swal.fire({
                        title: t('common.success'),
                        text: t('proyectos.deleted_success'),
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
        descripcion: '',
    }
    editingId.value = null
    showForm.value = false
    errors.value = {}
}
</script>

<template>
    <Head :title="t('proyectos.title')" />

    <AppLayout>
        <div class="space-y-6 py-12">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ t('proyectos.title') }}</h1>
                    <p class="text-gray-600 dark:text-gray-400">{{ t('dashboard.proyectos') }}</p>
                </div>
                <button
                    v-if="!showForm"
                    @click="showForm = true"
                    class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700"
                >
                    <Plus class="h-4 w-4" />
                    {{ t('proyectos.add') }}
                </button>
            </div>

            <!-- Form -->
            <div v-if="showForm" class="rounded-lg border border-gray-200 bg-white p-6 dark:border-gray-700 dark:bg-gray-800">
                <h2 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">
                    {{ editingId ? t('common.edit') : t('proyectos.add') }}
                </h2>
                <form @submit.prevent="submit" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-900 dark:text-white">
                            {{ t('proyectos.name') }} *
                        </label>
                        <input
                            v-model="formData.nombre"
                            type="text"
                            class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                            :placeholder="t('proyectos.name')"
                        />
                        <p v-if="errors.nombre" class="mt-1 text-sm text-red-600">{{ errors.nombre }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-900 dark:text-white">
                            {{ t('proyectos.description') }}
                        </label>
                        <textarea
                            v-model="formData.descripcion"
                            class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                            :placeholder="t('proyectos.description')"
                            rows="4"
                        />
                        <p v-if="errors.descripcion" class="mt-1 text-sm text-red-600">{{ errors.descripcion }}</p>
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

            <!-- Projects Grid -->
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                <div
                    v-for="proyecto in proyectos"
                    :key="proyecto.id"
                    class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm hover:shadow-md dark:border-gray-700 dark:bg-gray-800"
                >
                    <div class="mb-4 flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ proyecto.nombre }}</h3>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ proyecto.descripcion }}</p>
                        </div>
                        <div class="flex gap-2">
                            <button
                                @click="startEdit(proyecto)"
                                class="rounded-md px-2 py-1 text-gray-400 hover:bg-gray-100 hover:text-green-600 dark:hover:bg-gray-700 dark:hover:text-green-400"
                                title="Editar"
                            >
                                <Edit2 class="h-4 w-4" />
                            </button>
                            <button
                                @click="deleteProyecto(proyecto.id)"
                                class="rounded-md px-2 py-1 text-gray-400 hover:bg-gray-100 hover:text-red-600 dark:hover:bg-gray-700 dark:hover:text-red-400"
                                title="Eliminar"
                            >
                                <Trash2 class="h-4 w-4" />
                            </button>
                        </div>
                    </div>

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

