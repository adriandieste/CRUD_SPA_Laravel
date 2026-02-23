<script setup lang="ts">
import { Form, Head, Link } from '@inertiajs/vue3'
import { useTranslation } from '@/composables/useTranslation'
import InputError from '@/components/InputError.vue'
import TextLink from '@/components/TextLink.vue'
import { Button } from '@/components/ui/button'
import { Checkbox } from '@/components/ui/checkbox'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Spinner } from '@/components/ui/spinner'
import AuthBase from '@/layouts/AuthLayout.vue'
import { register, home } from '@/routes'
import { store } from '@/routes/login'
import { request } from '@/routes/password'

const { t } = useTranslation()

defineProps<{
    status?: string
    canResetPassword: boolean
    canRegister: boolean
}>()
</script>

<template>
    <AuthBase :title="t('nav.login')" :description="t('forms.required')">
        <Head :title="t('nav.login')" />

        <div v-if="status" class="mb-4 rounded-lg bg-green-50 p-4 text-sm font-medium text-green-700 dark:bg-green-900 dark:text-green-200">
            {{ status }}
        </div>

        <Form
            v-bind="store.form()"
            :reset-on-success="['password']"
            v-slot="{ errors, processing }"
            class="space-y-6"
        >
            <div class="space-y-4">
                <div class="space-y-2">
                    <Label for="email" class="text-gray-700 dark:text-gray-300">{{ t('alumnos.email') }}</Label>
                    <Input
                        id="email"
                        type="email"
                        name="email"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="email"
                        :placeholder="`${t('alumnos.email')}`"
                        class="w-full border-gray-300 px-4 py-2 dark:border-gray-600"
                    />
                    <InputError :message="errors.email" />
                </div>

                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <Label for="password" class="text-gray-700 dark:text-gray-300">
                            {{ t('common.password') || 'Contraseña' }}
                        </Label>
                        <TextLink
                            v-if="canResetPassword"
                            :href="request()"
                            class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400"
                            :tabindex="5"
                        >
                            {{ t('password.forgot') || '¿Olvidaste tu contraseña?' }}
                        </TextLink>
                    </div>
                    <Input
                        id="password"
                        type="password"
                        name="password"
                        required
                        :tabindex="2"
                        autocomplete="current-password"
                        :placeholder="`${t('common.password') || 'Contraseña'}`"
                        class="w-full border-gray-300 px-4 py-2 dark:border-gray-600"
                    />
                    <InputError :message="errors.password" />
                </div>

                <div class="flex items-center">
                    <Label for="remember" class="flex cursor-pointer items-center space-x-3">
                        <Checkbox id="remember" name="remember" :tabindex="3" />
                        <span class="text-sm text-gray-700 dark:text-gray-300">{{ t('common.remember') || 'Recuérdame' }}</span>
                    </Label>
                </div>
            </div>

            <Button
                type="submit"
                class="w-full bg-blue-600 py-2 font-semibold text-white hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600"
                :tabindex="4"
                :disabled="processing"
            >
                <Spinner v-if="processing" class="mr-2" />
                {{ t('nav.login') }}
            </Button>

            <div v-if="canRegister" class="border-t border-gray-200 pt-4 text-center text-sm dark:border-gray-700">
                {{ t('common.no_account') || '¿No tienes cuenta?' }}
                <TextLink :href="register()" class="font-semibold text-blue-600 hover:text-blue-700 dark:text-blue-400" :tabindex="5">
                    {{ t('nav.register') }}
                </TextLink>
            </div>

            <div class="text-center text-xs text-gray-500 dark:text-gray-400">
                {{ t('common.or') || 'O' }}
                <Link href="/" class="text-blue-600 hover:text-blue-700 dark:text-blue-400">
                    {{ t('nav.home') || 'Volver a inicio' }}
                </Link>
            </div>
        </Form>
    </AuthBase>
</template>

