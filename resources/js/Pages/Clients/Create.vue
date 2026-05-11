<script setup>
import { useForm, Link } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import InputError from '@/Components/Form/InputError.vue'
import TextInput from '@/Components/Form/TextInput.vue'
import SelectInput from '@/Components/Form/SelectInput.vue'
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

                            <input
                                v-model="form.name"
                                class="w-full border rounded-xl p-3 mt-2"
                            >
                        </div>

                        <div>
                            <label class="font-semibold">
                                {{ t('phone') }}
                            </label>

                            <input
                                v-model="form.phone"
                                class="w-full border rounded-xl p-3 mt-2"
                            >
                        </div>

                        <div>
                            <label class="font-semibold">
                                {{ t('email') }}
                            </label>

                            <input
                                v-model="form.email"
                                type="email"
                                class="w-full border rounded-xl p-3 mt-2"
                            >
                        </div>

                        <div>
                            <label class="font-semibold">
                                {{ t('nationalId') }}
                            </label>

                            <input
                                v-model="form.national_id"
                                class="w-full border rounded-xl p-3 mt-2"
                            >
                        </div>

                    </div>

                    <div>
                        <label class="font-semibold">
                            {{ t('address') }}
                        </label>

                        <textarea
                            v-model="form.address"
                            rows="3"
                            class="w-full border rounded-xl p-3 mt-2"
                        />
                    </div>

                    <div>
                        <label class="font-semibold">
                            {{ t('notes') }}
                        </label>

                        <textarea
                            v-model="form.notes"
                            rows="4"
                            class="w-full border rounded-xl p-3 mt-2"
                        />
                    </div>

                    <div class="flex justify-between pt-4">

                        <Link
                            href="/clients"
                            class="px-5 py-3 rounded-xl border"
                        >
                            {{ t('cancel') }}
                        </Link>

                        <button
                            class="bg-[#D4AF37] text-black px-6 py-3 rounded-xl font-bold shadow"
                        >
                            {{ t('saveClient') }}
                        </button>

                    </div>

                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>