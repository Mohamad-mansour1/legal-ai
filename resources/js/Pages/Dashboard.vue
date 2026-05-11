<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { useI18n } from 'vue-i18n'

const { t, locale } = useI18n()

defineProps({
    totalClients: Number,
    totalCases: Number,
    totalDocuments: Number,
    pendingTasks: Number,
    upcomingHearings: Array,
    recentCases: Array,
    recentActivities: Array,
})
</script>

<template>
    <AuthenticatedLayout>
        <div class="space-y-8">

            <!-- Header -->
            <div>
                <h1 class="text-3xl font-bold text-[#1F2933]">
                    {{ t('dashboard') }}
                </h1>

                <p class="text-gray-500 mt-1">
                    {{ t('dashboardSubtitle') }}
                </p>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-4 gap-6">

                <div class="bg-white rounded-2xl shadow border border-[#E5DCCB] p-6">
                    <div class="text-gray-500 text-sm">
                        {{ t('totalClients') }}
                    </div>

                    <div class="text-4xl font-bold text-[#1F2933] mt-2">
                        {{ totalClients }}
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow border border-[#E5DCCB] p-6">
                    <div class="text-gray-500 text-sm">
                        {{ t('totalCases') }}
                    </div>

                    <div class="text-4xl font-bold text-[#1F2933] mt-2">
                        {{ totalCases }}
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow border border-[#E5DCCB] p-6">
                    <div class="text-gray-500 text-sm">
                        {{ t('totalDocuments') }}
                    </div>

                    <div class="text-4xl font-bold text-[#1F2933] mt-2">
                        {{ totalDocuments }}
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow border border-[#E5DCCB] p-6">
                    <div class="text-gray-500 text-sm">
                        {{ t('pendingTasks') }}
                    </div>

                    <div class="text-4xl font-bold text-[#1F2933] mt-2">
                        {{ pendingTasks }}
                    </div>
                </div>

            </div>

            <div class="grid grid-cols-2 gap-6">

                <!-- Upcoming Hearings -->
                <div class="bg-white rounded-2xl shadow border border-[#E5DCCB] p-6">
                    <h2 class="text-xl font-bold text-[#1F2933] mb-5">
                        {{ t('upcomingHearings') }}
                    </h2>

                    <div
                        v-if="upcomingHearings.length"
                        class="space-y-4"
                    >
                        <div
                            v-for="hearing in upcomingHearings"
                            :key="hearing.id"
                            class="border rounded-xl p-4 bg-[#F8F5EF]"
                        >
                            <div class="font-bold text-[#1F2933]">
                                {{ hearing.title }}
                            </div>

                            <div class="text-sm text-gray-600 mt-1">
                                {{ hearing.legal_case?.title }}
                            </div>

                            <div class="text-sm text-gray-500 mt-1">
                                {{ hearing.legal_case?.client?.name }}
                            </div>

                            <div class="text-sm font-semibold text-[#1F2933] mt-2">
                                {{ new Date(hearing.hearing_date).toLocaleString() }}
                            </div>
                        </div>
                    </div>

                    <div
                        v-else
                        class="text-gray-500"
                    >
                        {{ t('noUpcomingHearings') }}
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded-2xl shadow border border-[#E5DCCB] p-6">
                    <h2 class="text-xl font-bold text-[#1F2933] mb-5">
                        {{ t('recentActivity') }}
                    </h2>

                    <div
                        v-if="recentActivities.length"
                        class="space-y-4"
                    >
                        <div
                            v-for="activity in recentActivities"
                            :key="activity.id"
                            class="border-s-4 border-[#D4AF37] ps-4"
                        >
                            <div class="font-bold text-[#1F2933]">
                                {{ t(activity.description) }}
                            </div>

                            <div class="text-sm text-gray-500 mt-1">
                                {{ activity.legal_case?.title || '-' }}
                            </div>

                            <div class="text-xs text-gray-400 mt-1">
                                {{ t('by') }}:
                                {{ activity.user?.name || t('system') }}
                                —
                                {{ new Date(activity.created_at).toLocaleString() }}
                            </div>
                        </div>
                    </div>

                    <div
                        v-else
                        class="text-gray-500"
                    >
                        {{ t('noRecentActivity') }}
                    </div>
                </div>

            </div>

            <!-- Recent Cases -->
            <div class="bg-white rounded-2xl shadow border border-[#E5DCCB] p-6">
                <h2 class="text-xl font-bold text-[#1F2933] mb-5">
                    {{ t('recentCases') }}
                </h2>

                <table class="w-full">
                    <thead class="bg-[#F8F5EF]">
                        <tr>
                            <th class="p-4 text-start">
                                {{ t('caseTitle') }}
                            </th>

                            <th class="p-4 text-start">
                                {{ t('client') }}
                            </th>

                            <th class="p-4 text-start">
                                {{ t('status') }}
                            </th>

                            <th class="p-4 text-start">
                                {{ t('assignedLawyer') }}
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="legalCase in recentCases"
                            :key="legalCase.id"
                            class="border-t"
                        >
                            <td class="p-4 font-semibold text-[#1F2933]">
                                {{ legalCase.title }}
                            </td>

                            <td class="p-4">
                                {{ legalCase.client?.name || '-' }}
                            </td>

                            <td class="p-4">
                                <span class="px-3 py-1 rounded-full bg-[#F8F5EF] text-sm font-bold">
                                    {{
                                        locale === 'ar'
                                            ? legalCase.stage?.name_ar
                                            : legalCase.stage?.name_en
                                    }}
                                </span>
                            </td>

                            <td class="p-4">
                                {{ legalCase.assigned_lawyer?.name || '-' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </AuthenticatedLayout>
</template>