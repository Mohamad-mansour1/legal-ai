<script setup>
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

import { useI18n } from 'vue-i18n'

const { t, locale } = useI18n()

const props = defineProps({
    events: Array,
})

const calendarOptions = {
    plugins: [
        dayGridPlugin,
        interactionPlugin,
    ],

    initialView: 'dayGridMonth',

    locale: locale.value,

    height: 'auto',
    
    events: props.events,

    eventClick(info) {
        window.location.href = info.event.url
    },
}
</script>

<template>
    <AuthenticatedLayout>

        <div class="space-y-8">

            <div>

                <h1 class="text-3xl font-bold text-[#1F2933]">
                    {{ t('calendar') }}
                </h1>

                <p class="text-gray-500 mt-1">
                    {{ t('calendarSubtitle') }}
                </p>

            </div>

            <div class="bg-white rounded-2xl shadow border border-[#E5DCCB] p-6">

                <FullCalendar :options="calendarOptions" />

            </div>

        </div>

    </AuthenticatedLayout>
</template>

<style>
.fc .fc-toolbar-title {
    font-size: 1.4rem;
    font-weight: bold;
    color: #1F2933;
}

.fc .fc-button {
    background: #D4AF37 !important;
    border: none !important;
    color: black !important;
    font-weight: bold;
}

.fc .fc-daygrid-event {
    background: #1F2933;
    border: none;
    padding: 4px;
}
</style>