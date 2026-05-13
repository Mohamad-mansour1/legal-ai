<script setup>
import { useForm, Link } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import InputError from '@/Components/Form/InputError.vue'
import TextInput from '@/Components/Form/TextInput.vue'
import SelectInput from '@/Components/Form/SelectInput.vue'

const { t } = useI18n()

const props = defineProps({
    user: Object,
    roles: Array,
    currentRole: String
})

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    password: '',
    role: props.currentRole,
})

const submit = () => form.put(`/users/${props.user.id}`)
</script>

<template>
    <AuthenticatedLayout>
        <div class="max-w-4xl mx-auto">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-[#1F2933]">
                    {{ t('editUser') }}
                </h1>

                <p class="text-gray-500 mt-1">
                    {{ t('editUserSubtitle') }}
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow border border-[#E5DCCB] p-8">
                <form @submit.prevent="submit" class="space-y-6">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="font-semibold">{{ t('name') }}</label>
                            <TextInput v-model="form.name" :error="form.errors.name" />
                            <InputError :message="form.errors.name" />
                        </div>

                        <div>
                            <label class="font-semibold">{{ t('email') }}</label>
                            <TextInput v-model="form.email" type="email" :error="form.errors.email" />
                            <InputError :message="form.errors.email" />
                        </div>

                        <div>
                            <label class="font-semibold">{{ t('password') }}</label>
                            <TextInput v-model="form.password" type="password" :error="form.errors.password" />
                            <InputError :message="form.errors.password" />

                            <p class="text-sm text-gray-500 mt-2">
                                {{ t('leavePasswordBlank') }}
                            </p>
                        </div>

                        <div>
                            <label class="font-semibold">{{ t('role') }}</label>
                            <SelectInput v-model="form.role" :error="form.errors.role">
                                <option value="">--</option>

                                <option
                                    v-for="role in roles"
                                    :key="role.id"
                                    :value="role.name"
                                >
                                    {{ t(role.name) }}
                                </option>
                            </SelectInput>
                            <InputError :message="form.errors.role" />
                        </div>
                    </div>

                    <div class="flex justify-between pt-4">
                        <Link href="/users" class="px-5 py-3 rounded-xl border">
                            {{ t('cancel') }}
                        </Link>

                        <button
                            :disabled="form.processing"
                            class="bg-[#D4AF37] text-black px-6 py-3 rounded-xl font-bold shadow disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <span v-if="form.processing">{{ t('saving') }}</span>
                            <span v-else>{{ t('updateUser') }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>