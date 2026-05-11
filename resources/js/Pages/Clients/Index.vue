<script setup>
import { computed, ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const { t } = useI18n()

const props = defineProps({
    clients: Array
})

const search = ref('')

const filteredClients = computed(() => {
    return props.clients.filter(client =>
        client.name.toLowerCase().includes(search.value.toLowerCase())
    )
})
</script>

<template>
    <AuthenticatedLayout>

        <div class="flex justify-between items-center mb-8">

            <div>
                <h1 class="text-3xl font-bold text-[#1F2933]">
                    {{ t('clients') }}
                </h1>

                <p class="text-gray-500 mt-1">
                    Manage law office clients
                </p>
            </div>

            <Link
                href="/clients/create"
                class="bg-[#D4AF37] hover:bg-[#c39f2f] text-black px-5 py-3 rounded-xl font-bold shadow"
            >
                + {{ t('addClient') }}
            </Link>

        </div>

        <div class="bg-white rounded-2xl shadow border border-[#E5DCCB] overflow-hidden">

            <div class="p-5 border-b">

                <input
                    v-model="search"
                    type="text"
                    placeholder="Search client..."
                    class="w-full border rounded-xl p-3"
                >

            </div>

            <table class="w-full">

                <thead class="bg-[#F8F5EF]">

                    <tr>

                        <th class="p-4 text-start">
                            Name
                        </th>

                        <th class="p-4 text-start">
                            Phone
                        </th>

                        <th class="p-4 text-start">
                            Email
                        </th>

                        <th class="p-4 text-start">
                            Actions
                        </th>

                    </tr>

                </thead>

                <tbody>

                    <tr
                        v-for="client in filteredClients"
                        :key="client.id"
                        class="border-t hover:bg-gray-50 transition"
                    >

                        <td class="p-4 font-semibold">
                            {{ client.name }}
                        </td>

                        <td class="p-4">
                            {{ client.phone }}
                        </td>

                        <td class="p-4">
                            {{ client.email }}
                        </td>

                        <td class="p-4">

                            <div class="flex gap-2">

                                <Link
                                    :href="`/clients/${client.id}/edit`"
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