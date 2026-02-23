<script setup lang="ts">
import { Form, Head, Link } from '@inertiajs/vue3'
import { useTranslation } from '@/composables/useTranslation'
import InputError from '@/components/InputError.vue'
import TextLink from '@/components/TextLink.vue'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Spinner } from '@/components/ui/spinner'
import AuthBase from '@/layouts/AuthLayout.vue'
import { login } from '@/routes'
import { store } from '@/routes/register'

const { t } = useTranslation()

defineProps<{
    canLogin: boolean
}>()
</script>

<template>
    <AuthBase :title="t('nav.register')" :description="t('forms.required')">
        <Head :title="t('nav.register')" />

        <Form
            v-bind="store.form()"
            :reset-on-success="['password', 'password_confirmation']"
            v-slot="{ errors, processing }"
            class="space-y-6"
        >
            <div class="space-y-4">
                <div class="space-y-2">
                    <Label for="name" class="text-gray-700 dark:text-gray-300">{{ t('forms.name') }}</Label>
                    <Input
                        id="name"
                        type="text"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="name"
                        name="name"
                        :placeholder="t('forms.name')"
                        class="w-full border-gray-300 px-4 py-2 dark:border-gray-600"
                    />
                    <InputError :message="errors.name" />
                </div>

                <div class="space-y-2">
                    <Label for="email" class="text-gray-700 dark:text-gray-300">{{ t('alumnos.email') }}</Label>
                    <Input
                        id="email"
                        type="email"
                        required
                        :tabindex="2"
                        autocomplete="email"
                        name="email"
                        :placeholder="t('alumnos.email')"
                        class="w-full border-gray-300 px-4 py-2 dark:border-gray-600"
                    />
                    <InputError :message="errors.email" />
                </div>

                <div class="space-y-2">
                    <Label for="password" class="text-gray-700 dark:text-gray-300">
                        {{ t('common.password') || 'Contraseña' }}
                    </Label>
                    <Input
                        id="password"
                        type="password"
                        required
                        :tabindex="3"
                        autocomplete="new-password"
                        name="password"
                        :placeholder="`${t('common.password') || 'Contraseña'}`"
                        class="w-full border-gray-300 px-4 py-2 dark:border-gray-600"
                    />
                    <InputError :message="errors.password" />
                </div>

                <div class="space-y-2">
                    <Label for="password_confirmation" class="text-gray-700 dark:text-gray-300">
                        {{ t('forms.confirm_password') || 'Confirmar Contraseña' }}
                    </Label>
                    <Input
                        id="password_confirmation"
                        type="password"
                        required
                        :tabindex="4"
                        autocomplete="new-password"
                        name="password_confirmation"
                        :placeholder="`${t('forms.confirm_password') || 'Confirmar Contraseña'}`"
                        class="w-full border-gray-300 px-4 py-2 dark:border-gray-600"
                    />
                    <InputError :message="errors.password_confirmation" />
                </div>
            </div>

            <div class="space-y-2 text-xs text-gray-600 dark:text-gray-400">
                <p>{{ t('forms.password_requirements') || 'La contraseña debe contener:' }}</p>
                <ul class="list-inside list-disc space-y-1">
                    <li>{{ t('forms.min_8_chars') || 'Mínimo 8 caracteres' }}</li>
                    <li>{{ t('forms.uppercase_lowercase') || 'Mayúsculas y minúsculas' }}</li>
                    <li>{{ t('forms.number_special') || 'Números y caracteres especiales' }}</li>
                </ul>
            </div>

            <Button
                type="submit"
                class="w-full bg-blue-600 py-2 font-semibold text-white hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600"
                tabindex="5"
                :disabled="processing"
                data-test="register-user-button"
            >
                <Spinner v-if="processing" class="mr-2" />
                {{ t('nav.register') }}
            </Button>

            <div v-if="canLogin" class="border-t border-gray-200 pt-4 text-center text-sm dark:border-gray-700">
                {{ t('common.have_account') || '¿Ya tienes cuenta?' }}
                <TextLink
                    :href="login()"
                    class="font-semibold text-blue-600 hover:text-blue-700 dark:text-blue-400"
                    :tabindex="6"
                >
                    {{ t('nav.login') }}
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
