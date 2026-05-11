<script setup>
import { computed, ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const { t } = useI18n()

const props = defineProps({
    cases: Array
})

const search = ref('')

const filteredCases = computed(() => {
    return props.cases.filter(item => {
        const title = item.title?.toLowerCase() || ''
        const client = item.client?.name?.toLowerCase() || ''
        const court = item.court?.toLowerCase() || ''

        return (
            title.includes(search.value.toLowerCase()) ||
            client.includes(search.value.toLowerCase()) ||
            court.includes(search.value.toLowerCase())
        )
    })
})
</script>

<template>
    <AuthenticatedLayout>
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-[#1F2933]">
                    {{ t('legalCases') }}
                </h1>

                <p class="text-gray-500 mt-1">
                    Manage legal cases, courts, clients, and case status
                </p>
            </div>

            <Link
                href="/legal-cases/create"
                class="bg-[#D4AF37] hover:bg-[#c39f2f] text-black px-5 py-3 rounded-xl font-bold shadow"
            >
                + {{ t('addCase') }}
            </Link>
        </div>

        <div class="bg-white rounded-2xl shadow border border-[#E5DCCB] overflow-hidden">
            <div class="p-5 border-b">
                <input
                    v-model="search"
                    type="text"
                    placeholder="Search by case, client, or court..."
                    class="w-full border rounded-xl p-3"
                >
            </div>

            <table class="w-full">
                <thead class="bg-[#F8F5EF]">
                    <tr>
                        <th class="p-4 text-start">Case Title</th>
                        <th class="p-4 text-start">Client</th>
                        <th class="p-4 text-start">Court</th>
                        <th class="p-4 text-start">Status</th>
                        <th class="p-4 text-start">Hearing Date</th>
                        <th class="p-4 text-start">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <tr
                        v-for="legalCase in filteredCases"
                        :key="legalCase.id"
                        class="border-t hover:bg-gray-50 transition"
                    >
                        <td class="p-4 font-semibold text-[#1F2933]">
                            {{ legalCase.title }}
                        </td>

                        <td class="p-4">
                            {{ legalCase.client?.name }}
                        </td>

                        <td class="p-4">
                            {{ legalCase.court || '-' }}
                        </td>

                        <td class="p-4">
                            <span
                                class="px-3 py-1 rounded-full text-sm font-bold bg-[#F8F5EF] text-[#1F2933]"
                            >
                                {{
                                    $i18n.locale === 'ar'
                                    ? legalCase.stage?.name_ar
                                    : legalCase.stage?.name_en
                                }}
                            </span>
                            
                        </td>

                        <td class="p-4">
                            {{ legalCase.hearing_date || '-' }}
                        </td>

                        <td class="p-4">
                            <div class="flex gap-2">
                                <Link
                                    :href="`/legal-cases/${legalCase.id}/edit`"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-lg"
                                >
                                    Edit
                                </Link>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AuthenticatedLayout>
</template>