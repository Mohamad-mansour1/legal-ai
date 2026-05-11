<script setup>
import { useForm, Link } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import InputError from '@/Components/Form/InputError.vue'
import TextInput from '@/Components/Form/TextInput.vue'
import SelectInput from '@/Components/Form/SelectInput.vue'
import TextareaInput from '@/Components/Form/TextareaInput.vue'

const { t } = useI18n()

defineProps({
    roles: Array
})

const form = useForm({
    name: '',
    email: '',
    password: '',
    role: '',
})

const submit = () => form.post('/users')
</script>

<template>
    <AuthenticatedLayout>
        <div class="max-w-4xl mx-auto">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-[#1F2933]">
                    {{ t('createUser') }}
                </h1>

                <p class="text-gray-500 mt-1">
                    {{ t('createUserSubtitle') }}
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow border border-[#E5DCCB] p-8">
                <form @submit.prevent="submit" class="space-y-6">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="font-semibold">{{ t('name') }}</label>
                            <TextInput v-model="form.name" :error="form.errors.name"/>
                            <InputError :message="form.errors.name" />
                        </div>

                        <div>
                            <label class="font-semibold">{{ t('email') }}</label>
                            <input v-model="form.email" type="email" class="w-full border rounded-xl p-3 mt-2">
                        </div>

                        <div>
                            <label class="font-semibold">{{ t('password') }}</label>
                            <input v-model="form.password" type="password" class="w-full border rounded-xl p-3 mt-2">
                        </div>

                        <div>
                            <label class="font-semibold">{{ t('role') }}</label>
                            <select v-model="form.role" class="w-full border rounded-xl p-3 mt-2">
                                <option value="">--</option>

                                <option
                                    v-for="role in roles"
                                    :key="role.id"
                                    :value="role.name"
                                >
                                    {{ t(role.name) }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-between pt-4">
                        <Link href="/users" class="px-5 py-3 rounded-xl border">
                            {{ t('cancel') }}
                        </Link>

                        <button class="bg-[#D4AF37] text-black px-6 py-3 rounded-xl font-bold shadow">
                            {{ t('saveUser') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>