<script setup>
    import { Link, usePage } from '@inertiajs/vue3'
    import { computed } from 'vue'
    import { useI18n } from 'vue-i18n'

    const page = usePage()
    const { t, locale } = useI18n()

    const isArabic = computed(() => locale.value === 'ar')

    const isActive = (url) => page.url.startsWith(url)

    const switchLang = () => {
        locale.value = locale.value === 'ar' ? 'en' : 'ar'
        localStorage.setItem('locale', locale.value)

        document.documentElement.dir = locale.value === 'ar' ? 'rtl' : 'ltr'
        document.documentElement.lang = locale.value
    }

    document.documentElement.dir = isArabic.value ? 'rtl' : 'ltr'
    document.documentElement.lang = locale.value
</script>

<template>
    <div
        class="min-h-screen bg-[#F5F1EA] flex"
        :dir="isArabic ? 'rtl' : 'ltr'"
    >
        <aside class="w-72 bg-[#1F2933] text-white min-h-screen p-6 flex flex-col shadow-xl">

            <div class="mb-10">
                <h1 class="text-2xl font-bold text-[#D4AF37]">
                    {{ t('appName') }}
                </h1>

                <p class="text-sm text-gray-300 mt-1">
                    Law Firm Management
                </p>
            </div>

            <nav class="space-y-2 flex-1">

                <Link
                    href="/dashboard"
                    class="block p-3 rounded-lg transition"
                    :class="isActive('/dashboard') ? 'bg-[#D4AF37] text-black font-bold' : 'hover:bg-[#2E3A46]'"
                >
                    {{ t('dashboard') }}
                </Link>

                <Link
                    href="/users"
                    class="block p-3 rounded-lg transition"
                    :class="isActive('/users') ? 'bg-[#D4AF37] text-black font-bold' : 'hover:bg-[#2E3A46]'"
                >
                    {{ t('users') }}
                </Link>

                <Link
                    href="/clients"
                    class="block p-3 rounded-lg transition"
                    :class="isActive('/clients') ? 'bg-[#D4AF37] text-black font-bold' : 'hover:bg-[#2E3A46]'"
                >
                    {{ t('clients') }}
                </Link>

                <Link
                    href="/legal-cases"
                    class="block p-3 rounded-lg transition"
                    :class="isActive('/legal-cases') ? 'bg-[#D4AF37] text-black font-bold' : 'hover:bg-[#2E3A46]'"
                >
                    {{ t('legalCases') }}
                </Link>

                <Link
                    href="/search"
                    class="block p-3 rounded-lg transition"
                    :class="isActive('/search') ? 'bg-[#D4AF37] text-black font-bold' : 'hover:bg-[#2E3A46]'"
                >
                    {{ t('globalSearch') }}
                </Link>

            </nav>

            <div class="border-t border-gray-600 pt-4 space-y-3">
                <button
                    @click="switchLang"
                    class="w-full bg-white text-black p-2 rounded-lg font-bold"
                >
                    {{ locale === 'ar' ? 'English' : 'العربية' }}
                </button>
                <div>

                    <p class="text-sm text-white font-bold">
                        {{ page.props.auth.user.name }}
                    </p>

                    <p class="text-xs text-[#D4AF37] mt-1 uppercase">
                        {{ page.props.auth.user.roles?.[0]?.replace('_', ' ') }}
                    </p>

                </div>

                <Link
                    href="/logout"
                    method="post"
                    as="button"
                    class="w-full text-start p-3 rounded-lg hover:bg-[#2E3A46]"
                >
                    {{ t('logout') }}
                </Link>
            </div>

        </aside>

        <main class="flex-1 p-8">
            <slot />
        </main>
    </div>
</template>