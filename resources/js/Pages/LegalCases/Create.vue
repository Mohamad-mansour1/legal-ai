<script setup>
import { useForm, Link } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

import InputError from '@/Components/Form/InputError.vue'
import TextInput from '@/Components/Form/TextInput.vue'
import SelectInput from '@/Components/Form/SelectInput.vue'
import TextareaInput from '@/Components/Form/TextareaInput.vue'

const { t, locale } = useI18n()

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

                        <!-- Client -->

                        <div>

                            <label class="font-semibold">
                                {{ t('client') }}
                            </label>

                            <SelectInput
                                v-model="form.client_id"
                                :error="form.errors.client_id"
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

                            </SelectInput>

                            <InputError :message="form.errors.client_id" />

                        </div>

                        <!-- Lawyer -->

                        <div>

                            <label class="font-semibold">
                                {{ t('assignedLawyer') }}
                            </label>

                            <SelectInput
                                v-model="form.assigned_lawyer_id"
                                :error="form.errors.assigned_lawyer_id"
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

                            </SelectInput>

                            <InputError :message="form.errors.assigned_lawyer_id" />

                        </div>

                        <!-- Trainee -->

                        <div>

                            <label class="font-semibold">
                                {{ t('assignedTrainee') }}
                            </label>

                            <SelectInput
                                v-model="form.assigned_trainee_id"
                                :error="form.errors.assigned_trainee_id"
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

                            </SelectInput>

                            <InputError :message="form.errors.assigned_trainee_id" />

                        </div>

                        <!-- Title -->

                        <div>

                            <label class="font-semibold">
                                {{ t('caseTitle') }}
                            </label>

                            <TextInput
                                v-model="form.title"
                                :error="form.errors.title"
                            />

                            <InputError :message="form.errors.title" />

                        </div>

                        <!-- Case Number -->

                        <div>

                            <label class="font-semibold">
                                {{ t('caseNumber') }}
                            </label>

                            <TextInput
                                v-model="form.case_number"
                                :error="form.errors.case_number"
                            />

                            <InputError :message="form.errors.case_number" />

                        </div>

                        <!-- Court -->

                        <div>

                            <label class="font-semibold">
                                {{ t('court') }}
                            </label>

                            <TextInput
                                v-model="form.court"
                                :error="form.errors.court"
                            />

                            <InputError :message="form.errors.court" />

                        </div>

                        <!-- Stage -->

                        <div>

                            <label class="font-semibold">
                                {{ t('status') }}
                            </label>

                            <SelectInput
                                v-model="form.case_stage_id"
                                :error="form.errors.case_stage_id"
                            >

                                <option value="">
                                    --
                                </option>

                                <option
                                    v-for="stage in stages"
                                    :key="stage.id"
                                    :value="Number(stage.id)"
                                >
                                    {{
                                        locale === 'ar'
                                            ? stage.name_ar
                                            : stage.name_en
                                    }}
                                </option>

                            </SelectInput>

                            <InputError :message="form.errors.case_stage_id" />

                        </div>

                        <!-- Hearing Date -->

                        <div>

                            <label class="font-semibold">
                                {{ t('hearingDate') }}
                            </label>

                            <TextInput
                                v-model="form.hearing_date"
                                type="date"
                                :error="form.errors.hearing_date"
                            />

                            <InputError :message="form.errors.hearing_date" />

                        </div>

                    </div>

                    <!-- Description -->

                    <div>

                        <label class="font-semibold">
                            {{ t('description') }}
                        </label>

                        <TextareaInput
                            v-model="form.description"
                            :error="form.errors.description"
                            :rows="4"
                        />

                        <InputError :message="form.errors.description" />

                    </div>

                    <!-- Notes -->

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

                    <!-- Buttons -->

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