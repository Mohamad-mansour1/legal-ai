<script setup>
import { useForm, Link } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import InputError from '@/Components/Form/InputError.vue'
import TextInput from '@/Components/Form/TextInput.vue'
import TextareaInput from '@/Components/Form/TextareaInput.vue'

const { t } = useI18n()

const form = useForm({
    name: '',
    phone: '',
    email: '',
    national_id: '',
    address: '',
    notes: '',
})

const submit = () => form.post('/clients')
</script>

<template>
    <AuthenticatedLayout>
        <div class="max-w-4xl mx-auto">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-[#1F2933]">
                    {{ t('createClient') }}
                </h1>

                <p class="text-gray-500 mt-1">
                    {{ t('clientSubtitleCreate') }}
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow border border-[#E5DCCB] p-8">
                <form @submit.prevent="submit" class="space-y-6">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="font-semibold">
                                {{ t('name') }}
                            </label>

                            <TextInput
                                v-model="form.name"
                                :error="form.errors.name"
                            />

                            <InputError :message="form.errors.name" />
                        </div>

                        <div>
                            <label class="font-semibold">
                                {{ t('phone') }}
                            </label>

                            <TextInput
                                v-model="form.phone"
                                :error="form.errors.phone"
                            />

                            <InputError :message="form.errors.phone" />
                        </div>

                        <div>
                            <label class="font-semibold">
                                {{ t('email') }}
                            </label>

                            <TextInput
                                v-model="form.email"
                                type="email"
                                :error="form.errors.email"
                            />

                            <InputError :message="form.errors.email" />
                        </div>

                        <div>
                            <label class="font-semibold">
                                {{ t('nationalId') }}
                            </label>

                            <TextInput
                                v-model="form.national_id"
                                :error="form.errors.national_id"
                            />

                            <InputError :message="form.errors.national_id" />
                        </div>
                    </div>

                    <div>
                        <label class="font-semibold">
                            {{ t('address') }}
                        </label>

                        <TextareaInput
                            v-model="form.address"
                            :error="form.errors.address"
                            :rows="3"
                        />

                        <InputError :message="form.errors.address" />
                    </div>

                    <div>
                        <label class="font-semibold">
                            {{ t('notes') }}
                        </label>

                        <TextareaInput
                            v-model="form.notes"
                            :error="form.errors.notes"
                            :rows="4"
                        />

                        <InputError :message="form.errors.notes" />
                    </div>

                    <div class="flex justify-between pt-4">
                        <Link
                            href="/clients"
                            class="px-5 py-3 rounded-xl border"
                        >
                            {{ t('cancel') }}
                        </Link>

                        <button
                            :disabled="form.processing"
                            class="bg-[#D4AF37] text-black px-6 py-3 rounded-xl font-bold shadow disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <span v-if="form.processing">
                                {{ t('saving') }}
                            </span>

                            <span v-else>
                                {{ t('saveClient') }}
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>