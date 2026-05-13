<script setup>
import { useForm, Link, router } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import InputError from '@/Components/Form/InputError.vue'
import TextInput from '@/Components/Form/TextInput.vue'
import SelectInput from '@/Components/Form/SelectInput.vue'
import TextareaInput from '@/Components/Form/TextareaInput.vue'

const { t, locale } = useI18n()

const props = defineProps({
    legalCase: Object,
    clients: Array,
    stages: Array,
    users: Array,
    lawyers: Array,
    trainees: Array,
})

const form = useForm({
    client_id: props.legalCase.client_id,
    case_stage_id: Number(props.legalCase.case_stage_id),
    title: props.legalCase.title,
    case_number: props.legalCase.case_number,
    court: props.legalCase.court,
    hearing_date: props.legalCase.hearing_date,
    description: props.legalCase.description,
    notes: props.legalCase.notes,
    assigned_lawyer_id: props.legalCase.assigned_lawyer_id,
    assigned_trainee_id: props.legalCase.assigned_trainee_id,
})

const documentForm = useForm({
    title: '',
    file: null,
})

const hearingForm = useForm({
    title: '',
    court: '',
    hearing_date: '',
    result: '',
    notes: '',
})

const taskForm = useForm({
    title: '',
    description: '',
    assigned_to: '',
    priority: 'medium',
    status: 'pending',
    due_date: '',
})

const submit = () => form.put(`/legal-cases/${props.legalCase.id}`)

const uploadDocument = () => {
    documentForm.post(`/legal-cases/${props.legalCase.id}/documents`, {
        forceFormData: true,
        onSuccess: () => documentForm.reset(),
    })
}

const deleteDocument = (id) => {
    if (confirm('Delete this document?')) {
        router.delete(`/case-documents/${id}`)
    }
}

const uploadHearing = () => {
    hearingForm.post(`/legal-cases/${props.legalCase.id}/hearings`, {
        onSuccess: () => hearingForm.reset(),
    })
}

const deleteHearing = (id) => {
    if (confirm('Delete this hearing?')) {
        router.delete(`/hearings/${id}`)
    }
}

const addTask = () => {
    taskForm.post(`/legal-cases/${props.legalCase.id}/tasks`, {
        onSuccess: () => taskForm.reset(),
    })
}

const deleteTask = (id) => {
    if (confirm('Delete this task?')) {
        router.delete(`/tasks/${id}`)
    }
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="max-w-6xl mx-auto">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-[#1F2933]">
                    {{ t('editCase') }}
                </h1>

                <p class="text-gray-500 mt-1">
                    {{ t('caseSubtitleEdit') }}
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow border border-[#E5DCCB] p-8 mb-8">
                <form @submit.prevent="submit" class="space-y-6">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="font-semibold">{{ t('client') }}</label>

                            <SelectInput v-model="form.client_id" :error="form.errors.client_id">
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

                        <div>
                            <label class="font-semibold">{{ t('assignedLawyer') }}</label>

                            <SelectInput
                                v-model="form.assigned_lawyer_id"
                                :error="form.errors.assigned_lawyer_id"
                            >
                                <option value="">--</option>

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

                        <div>
                            <label class="font-semibold">{{ t('assignedTrainee') }}</label>

                            <SelectInput
                                v-model="form.assigned_trainee_id"
                                :error="form.errors.assigned_trainee_id"
                            >
                                <option value="">--</option>

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

                        <div>
                            <label class="font-semibold">{{ t('caseTitle') }}</label>

                            <TextInput v-model="form.title" :error="form.errors.title" />
                            <InputError :message="form.errors.title" />
                        </div>

                        <div>
                            <label class="font-semibold">{{ t('caseNumber') }}</label>

                            <TextInput v-model="form.case_number" :error="form.errors.case_number" />
                            <InputError :message="form.errors.case_number" />
                        </div>

                        <div>
                            <label class="font-semibold">{{ t('court') }}</label>

                            <TextInput v-model="form.court" :error="form.errors.court" />
                            <InputError :message="form.errors.court" />
                        </div>

                        <div>
                            <label class="font-semibold">{{ t('status') }}</label>

                            <SelectInput v-model="form.case_stage_id" :error="form.errors.case_stage_id">
                                <option value="">--</option>

                                <option
                                    v-for="stage in stages"
                                    :key="stage.id"
                                    :value="Number(stage.id)"
                                >
                                    {{ locale === 'ar' ? stage.name_ar : stage.name_en }}
                                </option>
                            </SelectInput>

                            <InputError :message="form.errors.case_stage_id" />
                        </div>

                        <div>
                            <label class="font-semibold">{{ t('hearingDate') }}</label>

                            <TextInput
                                v-model="form.hearing_date"
                                type="date"
                                :error="form.errors.hearing_date"
                            />

                            <InputError :message="form.errors.hearing_date" />
                        </div>
                    </div>

                    <div>
                        <label class="font-semibold">{{ t('description') }}</label>

                        <TextareaInput
                            v-model="form.description"
                            :error="form.errors.description"
                            :rows="4"
                        />

                        <InputError :message="form.errors.description" />
                    </div>

                    <div>
                        <label class="font-semibold">{{ t('notes') }}</label>

                        <TextareaInput
                            v-model="form.notes"
                            :error="form.errors.notes"
                            :rows="4"
                        />

                        <InputError :message="form.errors.notes" />
                    </div>

                    <div class="flex justify-between pt-4">
                        <Link href="/legal-cases" class="px-5 py-3 rounded-xl border">
                            {{ t('cancel') }}
                        </Link>

                        <button
                            :disabled="form.processing"
                            class="bg-[#D4AF37] text-black px-6 py-3 rounded-xl font-bold shadow disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <span v-if="form.processing">{{ t('saving') }}</span>
                            <span v-else>{{ t('updateCase') }}</span>
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-2xl shadow border border-[#E5DCCB] p-8 mb-8">
                <h2 class="text-xl font-bold text-[#1F2933] mb-4">
                    {{ t('uploadDocument') }}
                </h2>

                <form @submit.prevent="uploadDocument" class="grid grid-cols-3 gap-4 items-end">
                    <div>
                        <label class="font-semibold">{{ t('documentTitle') }}</label>

                        <TextInput
                            v-model="documentForm.title"
                            :error="documentForm.errors.title"
                        />

                        <InputError :message="documentForm.errors.title" />
                    </div>

                    <div>
                        <label class="font-semibold">{{ t('file') }}</label>

                        <input
                            type="file"
                            class="w-full border rounded-xl p-3 mt-2"
                            :class="documentForm.errors.file ? 'border-red-500' : 'border-gray-300'"
                            @change="documentForm.file = $event.target.files[0]"
                        >

                        <InputError :message="documentForm.errors.file" />
                    </div>

                    <button
                        :disabled="documentForm.processing"
                        class="bg-[#1F2933] text-white px-6 py-3 rounded-xl font-bold disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <span v-if="documentForm.processing">{{ t('uploading') }}</span>
                        <span v-else>{{ t('upload') }}</span>
                    </button>
                </form>
            </div>

            <div class="bg-white rounded-2xl shadow border border-[#E5DCCB] p-8">
                <h2 class="text-xl font-bold text-[#1F2933] mb-4">
                    {{ t('documents') }}
                </h2>

                <div
                    v-for="document in legalCase.documents"
                    :key="document.id"
                    class="border rounded-xl p-4 mb-3 flex justify-between items-center"
                >
                    <div>
                        <div class="font-bold">{{ document.title }}</div>
                        <div class="text-sm text-gray-500">{{ document.file_name }}</div>
                    </div>

                    <div class="flex gap-2">
                        <a
                            :href="`/storage/${document.file_path}`"
                            target="_blank"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg"
                        >
                            {{ t('openFile') }}
                        </a>

                        <button
                            @click="deleteDocument(document.id)"
                            class="bg-red-600 text-white px-4 py-2 rounded-lg"
                        >
                            {{ t('delete') }}
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow border border-[#E5DCCB] p-8 mt-8">
                <h2 class="text-xl font-bold text-[#1F2933] mb-6">
                    {{ t('hearings') }}
                </h2>

                <form @submit.prevent="uploadHearing" class="grid grid-cols-2 gap-6 mb-8">
                    <div>
                        <label class="font-semibold">{{ t('hearingTitle') }}</label>
                        <TextInput v-model="hearingForm.title" :error="hearingForm.errors.title" />
                        <InputError :message="hearingForm.errors.title" />
                    </div>

                    <div>
                        <label class="font-semibold">{{ t('court') }}</label>
                        <TextInput v-model="hearingForm.court" :error="hearingForm.errors.court" />
                        <InputError :message="hearingForm.errors.court" />
                    </div>

                    <div>
                        <label class="font-semibold">{{ t('hearingDate') }}</label>
                        <TextInput
                            v-model="hearingForm.hearing_date"
                            type="datetime-local"
                            :error="hearingForm.errors.hearing_date"
                        />
                        <InputError :message="hearingForm.errors.hearing_date" />
                    </div>

                    <div>
                        <label class="font-semibold">{{ t('result') }}</label>
                        <TextInput v-model="hearingForm.result" :error="hearingForm.errors.result" />
                        <InputError :message="hearingForm.errors.result" />
                    </div>

                    <div class="col-span-2">
                        <label class="font-semibold">{{ t('notes') }}</label>
                        <TextareaInput
                            v-model="hearingForm.notes"
                            :error="hearingForm.errors.notes"
                            :rows="3"
                        />
                        <InputError :message="hearingForm.errors.notes" />
                    </div>

                    <div class="col-span-2 flex justify-end">
                        <button
                            :disabled="hearingForm.processing"
                            class="bg-[#D4AF37] text-black px-6 py-3 rounded-xl font-bold shadow disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <span v-if="hearingForm.processing">{{ t('saving') }}</span>
                            <span v-else>{{ t('addHearing') }}</span>
                        </button>
                    </div>
                </form>

                <div
                    v-for="hearing in legalCase.hearings"
                    :key="hearing.id"
                    class="border rounded-xl p-5 mb-4"
                >
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="font-bold text-lg text-[#1F2933]">
                                {{ hearing.title }}
                            </div>

                            <div class="text-sm text-gray-500 mt-1">
                                {{ hearing.court || '-' }}
                            </div>

                            <div class="text-sm text-gray-500 mt-1">
                                {{ new Date(hearing.hearing_date).toLocaleString() }}
                            </div>

                            <div v-if="hearing.result" class="text-sm mt-3">
                                <span class="font-bold">{{ t('result') }}:</span>
                                {{ hearing.result }}
                            </div>

                            <div v-if="hearing.notes" class="text-sm mt-2">
                                <span class="font-bold">{{ t('notes') }}:</span>
                                {{ hearing.notes }}
                            </div>
                        </div>

                        <button
                            @click="deleteHearing(hearing.id)"
                            class="bg-red-600 text-white px-4 py-2 rounded-lg"
                        >
                            {{ t('delete') }}
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow border border-[#E5DCCB] p-8 mt-8">
                <h2 class="text-xl font-bold text-[#1F2933] mb-6">
                    {{ t('tasks') }}
                </h2>

                <form @submit.prevent="addTask" class="grid grid-cols-2 gap-6 mb-8">
                    <div>
                        <label class="font-semibold">{{ t('taskTitle') }}</label>
                        <TextInput v-model="taskForm.title" :error="taskForm.errors.title" />
                        <InputError :message="taskForm.errors.title" />
                    </div>

                    <div>
                        <label class="font-semibold">{{ t('assignedTo') }}</label>

                        <SelectInput
                            v-model="taskForm.assigned_to"
                            :error="taskForm.errors.assigned_to"
                        >
                            <option value="">--</option>

                            <option
                                v-for="user in users"
                                :key="user.id"
                                :value="user.id"
                            >
                                {{ user.name }}
                            </option>
                        </SelectInput>

                        <InputError :message="taskForm.errors.assigned_to" />
                    </div>

                    <div>
                        <label class="font-semibold">{{ t('priority') }}</label>

                        <SelectInput
                            v-model="taskForm.priority"
                            :error="taskForm.errors.priority"
                        >
                            <option value="low">{{ t('low') }}</option>
                            <option value="medium">{{ t('medium') }}</option>
                            <option value="high">{{ t('high') }}</option>
                        </SelectInput>

                        <InputError :message="taskForm.errors.priority" />
                    </div>

                    <div>
                        <label class="font-semibold">{{ t('dueDate') }}</label>

                        <TextInput
                            v-model="taskForm.due_date"
                            type="datetime-local"
                            :error="taskForm.errors.due_date"
                        />

                        <InputError :message="taskForm.errors.due_date" />
                    </div>

                    <div class="col-span-2">
                        <label class="font-semibold">{{ t('description') }}</label>

                        <TextareaInput
                            v-model="taskForm.description"
                            :error="taskForm.errors.description"
                            :rows="3"
                        />

                        <InputError :message="taskForm.errors.description" />
                    </div>

                    <div class="col-span-2 flex justify-end">
                        <button
                            :disabled="taskForm.processing"
                            class="bg-[#D4AF37] text-black px-6 py-3 rounded-xl font-bold shadow disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <span v-if="taskForm.processing">{{ t('saving') }}</span>
                            <span v-else>{{ t('addTask') }}</span>
                        </button>
                    </div>
                </form>

                <div
                    v-for="task in legalCase.tasks"
                    :key="task.id"
                    class="border rounded-xl p-5 mb-4 flex justify-between items-start"
                >
                    <div>
                        <div class="font-bold text-lg text-[#1F2933]">
                            {{ task.title }}
                        </div>

                        <div class="text-sm text-gray-500 mt-1">
                            {{ t('assignedTo') }}:
                            {{ task.assigned_user?.name || '-' }}
                        </div>

                        <div class="text-sm text-gray-500 mt-1">
                            {{ t('dueDate') }}:
                            {{ task.due_date ? new Date(task.due_date).toLocaleString() : '-' }}
                        </div>

                        <div class="flex gap-2 mt-3">
                            <span class="px-3 py-1 rounded-full bg-[#F8F5EF] text-sm font-bold">
                                {{ t(task.priority) }}
                            </span>

                            <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-sm font-bold">
                                {{ t(task.status) }}
                            </span>
                        </div>

                        <div v-if="task.description" class="text-sm mt-3">
                            {{ task.description }}
                        </div>
                    </div>

                    <button
                        @click="deleteTask(task.id)"
                        class="bg-red-600 text-white px-4 py-2 rounded-lg"
                    >
                        {{ t('delete') }}
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow border border-[#E5DCCB] p-8 mt-8">
                <h2 class="text-xl font-bold text-[#1F2933] mb-6">
                    {{ t('activityTimeline') }}
                </h2>

                <div
                    v-for="log in legalCase.activity_logs"
                    :key="log.id"
                    class="border-s-4 border-[#D4AF37] ps-5 mb-6 relative"
                >
                    <div class="absolute w-4 h-4 bg-[#D4AF37] rounded-full -start-[10px] top-1" />

                    <div class="flex justify-between items-start">
                        <div>
                            <div class="font-bold text-[#1F2933]">
                                {{ t(log.description) }}
                            </div>

                            <div class="text-sm text-gray-500 mt-1">
                                {{ t('by') }}:
                                {{ log.user?.name || t('system') }}
                            </div>
                        </div>

                        <div class="text-sm text-gray-400">
                            {{ new Date(log.created_at).toLocaleString() }}
                        </div>
                    </div>

                    <div
                        v-if="log.old_values || log.new_values"
                        class="mt-3 bg-[#F8F5EF] rounded-xl p-4 text-sm"
                    >
                        <div v-if="log.old_values">
                            <span class="font-bold text-red-700">
                                {{ t('old') }}:
                            </span>

                            {{ locale === 'ar'
                                ? log.old_values.stage_ar
                                : log.old_values.stage_en
                            }}
                        </div>

                        <div v-if="log.new_values" class="mt-2">
                            <span class="font-bold text-green-700">
                                {{ t('new') }}:
                            </span>

                            {{ locale === 'ar'
                                ? log.new_values.stage_ar
                                : log.new_values.stage_en
                            }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>