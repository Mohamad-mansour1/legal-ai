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
    clients: Array,
    stages: Array,
    lawyers: Array,
    trainees: Array,
})

const form = useForm({
    client_id: '',
    title: '',
    case_number: '',
    court: '',
    case_stage_id: '',
    hearing_date: '',
    description: '',
    notes: '',
    assigned_lawyer_id: '',
    assigned_trainee_id: '',
})

const submit = () => form.post('/legal-cases')
</script>

<template>
    <AuthenticatedLayout>

        <div class="max-w-5xl mx-auto">

            <div class="mb-8">

                <h1 class="text-3xl font-bold text-[#1F2933]">
                    {{ t('createCase') }}
                </h1>

                <p class="text-gray-500 mt-1">
                    {{ t('caseSubtitleCreate') }}
                </p>

            </div>

            <div class="bg-white rounded-2xl shadow border border-[#E5DCCB] p-8">

                <form @submit.prevent="submit" class="space-y-6">

                    <div class="grid grid-cols-2 gap-6">

                        <div>
                            <label class="font-semibold">
                                {{ t('client') }}
                            </label>

                            <select
                                v-model="form.client_id"
                                class="w-full border rounded-xl p-3 mt-2"
                            >
                                <option value="">
                                    {{ t('selectClient') }}
                                </option>

                                <option
                                    v-for="client in clients"
                                    :key="client.id"
                                    :value="client.id"
                                >
                                    {{ client.name }}
                                </option>
                            </select>
                        </div>
                        <div>

                            <label class="font-semibold">
                                {{ t('assignedLawyer') }}
                            </label>

                            <select
                                v-model="form.assigned_lawyer_id"
                                class="w-full border rounded-xl p-3 mt-2"
                            >

                                <option value="">
                                    --
                                </option>

                                <option
                                    v-for="lawyer in lawyers"
                                    :key="lawyer.id"
                                    :value="lawyer.id"
                                >
                                    {{ lawyer.name }}
                                </option>

                            </select>

                        </div>

                        <div>

                            <label class="font-semibold">
                                {{ t('assignedTrainee') }}
                            </label>

                            <select
                                v-model="form.assigned_trainee_id"
                                class="w-full border rounded-xl p-3 mt-2"
                            >

                                <option value="">
                                    --
                                </option>

                                <option
                                    v-for="trainee in trainees"
                                    :key="trainee.id"
                                    :value="trainee.id"
                                >
                                    {{ trainee.name }}
                                </option>

                            </select>

                        </div>

                        <div>
                            <label class="font-semibold">
                                {{ t('caseTitle') }}
                            </label>

                            <input
                                v-model="form.title"
                                class="w-full border rounded-xl p-3 mt-2"
                            >
                        </div>

                        <div>
                            <label class="font-semibold">
                                {{ t('caseNumber') }}
                            </label>

                            <input
                                v-model="form.case_number"
                                class="w-full border rounded-xl p-3 mt-2"
                            >
                        </div>

                        <div>
                            <label class="font-semibold">
                                {{ t('court') }}
                            </label>

                            <input
                                v-model="form.court"
                                class="w-full border rounded-xl p-3 mt-2"
                            >
                        </div>

                        <div>

                            <label class="font-semibold">
                                {{ t('status') }}
                            </label>

                            <select
                                v-model="form.case_stage_id"
                                class="w-full border rounded-xl p-3 mt-2"
                            >

                                <option value="">
                                    --
                                </option>

                                <option
                                    v-for="stage in stages"
                                    :key="stage.id"
                                    :value="stage.id"
                                >
                                    {{ $i18n.locale === 'ar'
                                        ? stage.name_ar
                                        : stage.name_en
                                    }}
                                </option>

                            </select>

                        </div>

                        <div>
                            <label class="font-semibold">
                                {{ t('hearingDate') }}
                            </label>

                            <input
                                v-model="form.hearing_date"
                                type="date"
                                class="w-full border rounded-xl p-3 mt-2"
                            >
                        </div>

                    </div>

                    <div>
                        <label class="font-semibold">
                            {{ t('description') }}
                        </label>

                        <textarea
                            v-model="form.description"
                            rows="4"
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
                            href="/legal-cases"
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
                                {{ t('saveCase') }}
                            </span>
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </AuthenticatedLayout>
</template>