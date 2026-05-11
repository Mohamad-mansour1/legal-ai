<script setup>
import { ref } from 'vue'
import { router, Link } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const { t, locale } = useI18n()

const props = defineProps({
    query: String,
    clients: Array,
    cases: Array,
    tasks: Array,
    hearings: Array,
})

const searching = ref(false)

const submitSearch = () => {
    searching.value = true

    router.get('/search', {
        q: search.value,
    }, {
        preserveState: true,
        replace: true,
        onFinish: () => {
            searching.value = false
        },
    })
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="space-y-8">

            <div>
                <h1 class="text-3xl font-bold text-[#1F2933]">
                    {{ t('globalSearch') }}
                </h1>

                <p class="text-gray-500 mt-1">
                    {{ t('globalSearchSubtitle') }}
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow border border-[#E5DCCB] p-6">
                <form
                    @submit.prevent="submitSearch"
                    class="flex gap-4"
                >
                    <input
                        v-model="search"
                        type="text"
                        :placeholder="t('searchPlaceholder')"
                        class="flex-1 border rounded-xl p-4"
                    >

                    <button
                        :disabled="searching"
                        class="bg-[#D4AF37] text-black px-8 py-4 rounded-xl font-bold shadow disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <span v-if="searching">
                            {{ t('searching') }}
                        </span>

                        <span v-else>
                            {{ t('search') }}
                        </span>
                    </button>
                </form>
            </div>

            <div
                v-if="!query"
                class="bg-white rounded-2xl shadow border border-[#E5DCCB] p-8 text-gray-500"
            >
                {{ t('startSearchMessage') }}
            </div>

            <template v-else>
                <!-- Clients -->
                <div class="bg-white rounded-2xl shadow border border-[#E5DCCB] p-6">
                    <h2 class="text-xl font-bold text-[#1F2933] mb-4">
                        {{ t('clients') }}
                    </h2>

                    <div
                        v-if="clients.length"
                        class="space-y-3"
                    >
                        <Link
                            v-for="client in clients"
                            :key="client.id"
                            :href="`/clients/${client.id}/edit`"
                            class="block border rounded-xl p-4 hover:bg-[#F8F5EF]"
                        >
                            <div class="font-bold text-[#1F2933]">
                                {{ client.name }}
                            </div>

                            <div class="text-sm text-gray-500 mt-1">
                                {{ client.phone || '-' }} — {{ client.email || '-' }}
                            </div>
                        </Link>
                    </div>

                    <div
                        v-else
                        class="text-gray-500"
                    >
                        {{ t('noResults') }}
                    </div>
                </div>

                <!-- Cases -->
                <div class="bg-white rounded-2xl shadow border border-[#E5DCCB] p-6">
                    <h2 class="text-xl font-bold text-[#1F2933] mb-4">
                        {{ t('legalCases') }}
                    </h2>

                    <div
                        v-if="cases.length"
                        class="space-y-3"
                    >
                        <Link
                            v-for="legalCase in cases"
                            :key="legalCase.id"
                            :href="`/legal-cases/${legalCase.id}/edit`"
                            class="block border rounded-xl p-4 hover:bg-[#F8F5EF]"
                        >
                            <div class="font-bold text-[#1F2933]">
                                {{ legalCase.title }}
                            </div>

                            <div class="text-sm text-gray-500 mt-1">
                                {{ legalCase.client?.name || '-' }}
                                —
                                {{
                                    locale === 'ar'
                                        ? legalCase.stage?.name_ar
                                        : legalCase.stage?.name_en
                                }}
                            </div>

                            <div class="text-sm text-gray-500 mt-1">
                                {{ legalCase.case_number || '-' }} — {{ legalCase.court || '-' }}
                            </div>
                        </Link>
                    </div>

                    <div
                        v-else
                        class="text-gray-500"
                    >
                        {{ t('noResults') }}
                    </div>
                </div>

                <!-- Tasks -->
                <div class="bg-white rounded-2xl shadow border border-[#E5DCCB] p-6">
                    <h2 class="text-xl font-bold text-[#1F2933] mb-4">
                        {{ t('tasks') }}
                    </h2>

                    <div
                        v-if="tasks.length"
                        class="space-y-3"
                    >
                        <Link
                            v-for="task in tasks"
                            :key="task.id"
                            :href="`/legal-cases/${task.legal_case_id}/edit`"
                            class="block border rounded-xl p-4 hover:bg-[#F8F5EF]"
                        >
                            <div class="font-bold text-[#1F2933]">
                                {{ task.title }}
                            </div>

                            <div class="text-sm text-gray-500 mt-1">
                                {{ task.legal_case?.title || '-' }}
                                —
                                {{ t('assignedTo') }}:
                                {{ task.assigned_user?.name || '-' }}
                            </div>

                            <div class="text-sm text-gray-500 mt-1">
                                {{ t(task.priority) }} — {{ t(task.status) }}
                            </div>
                        </Link>
                    </div>

                    <div
                        v-else
                        class="text-gray-500"
                    >
                        {{ t('noResults') }}
                    </div>
                </div>

                <!-- Hearings -->
                <div class="bg-white rounded-2xl shadow border border-[#E5DCCB] p-6">
                    <h2 class="text-xl font-bold text-[#1F2933] mb-4">
                        {{ t('hearings') }}
                    </h2>

                    <div
                        v-if="hearings.length"
                        class="space-y-3"
                    >
                        <Link
                            v-for="hearing in hearings"
                            :key="hearing.id"
                            :href="`/legal-cases/${hearing.legal_case_id}/edit`"
                            class="block border rounded-xl p-4 hover:bg-[#F8F5EF]"
                        >
                            <div class="font-bold text-[#1F2933]">
                                {{ hearing.title }}
                            </div>

                            <div class="text-sm text-gray-500 mt-1">
                                {{ hearing.legal_case?.title || '-' }}
                                —
                                {{ hearing.court || '-' }}
                            </div>

                            <div class="text-sm text-gray-500 mt-1">
                                {{ new Date(hearing.hearing_date).toLocaleString() }}
                            </div>
                        </Link>
                    </div>

                    <div
                        v-else
                        class="text-gray-500"
                    >
                        {{ t('noResults') }}
                    </div>
                </div>
            </template>

        </div>
    </AuthenticatedLayout>
</template>