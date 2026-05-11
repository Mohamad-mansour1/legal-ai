<script setup>
import { computed, ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const { t } = useI18n()

const props = defineProps({
    users: Array
})

const search = ref('')

const filteredUsers = computed(() => {
    return props.users.filter(user => {
        const name = user.name?.toLowerCase() || ''
        const email = user.email?.toLowerCase() || ''
        const role = user.roles?.[0]?.name?.toLowerCase() || ''

        return (
            name.includes(search.value.toLowerCase()) ||
            email.includes(search.value.toLowerCase()) ||
            role.includes(search.value.toLowerCase())
        )
    })
})

const deleteUser = (id) => {
    if (confirm('Delete this user?')) {
        router.delete(`/users/${id}`)
    }
}

const roleLabel = (role) => {
    return role ? t(role) : '-'
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-[#1F2933]">
                    {{ t('staffManagement') }}
                </h1>

                <p class="text-gray-500 mt-1">
                    {{ t('userSubtitle') }}
                </p>
            </div>

            <Link
                href="/users/create"
                class="bg-[#D4AF37] hover:bg-[#c39f2f] text-black px-5 py-3 rounded-xl font-bold shadow"
            >
                + {{ t('addUser') }}
            </Link>
        </div>

        <div class="bg-white rounded-2xl shadow border border-[#E5DCCB] overflow-hidden">
            <div class="p-5 border-b">
                <input
                    v-model="search"
                    type="text"
                    :placeholder="t('searchUser')"
                    class="w-full border rounded-xl p-3"
                >
            </div>

            <table class="w-full">
                <thead class="bg-[#F8F5EF]">
                    <tr>
                        <th class="p-4 text-start">{{ t('name') }}</th>
                        <th class="p-4 text-start">{{ t('email') }}</th>
                        <th class="p-4 text-start">{{ t('role') }}</th>
                        <th class="p-4 text-start">{{ t('actions') }}</th>
                    </tr>
                </thead>

                <tbody>
                    <tr
                        v-for="user in filteredUsers"
                        :key="user.id"
                        class="border-t hover:bg-gray-50 transition"
                    >
                        <td class="p-4 font-semibold text-[#1F2933]">
                            {{ user.name }}
                        </td>

                        <td class="p-4">
                            {{ user.email }}
                        </td>

                        <td class="p-4">
                            <span class="px-3 py-1 rounded-full bg-[#F8F5EF] text-[#1F2933] font-bold text-sm">
                                {{ roleLabel(user.roles?.[0]?.name) }}
                            </span>
                        </td>

                        <td class="p-4">
                            <div class="flex gap-2">
                                <Link
                                    :href="`/users/${user.id}/edit`"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-lg"
                                >
                                    {{ t('edit') || 'Edit' }}
                                </Link>

                                <button
                                    @click="deleteUser(user.id)"
                                    class="bg-red-600 text-white px-4 py-2 rounded-lg"
                                >
                                    {{ t('delete') }}
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AuthenticatedLayout>
</template>