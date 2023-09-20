<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Stores from '@/Pages/Stores/index.vue';
</script>

<template>
    <AppLayout title="Stores">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Stores
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <Stores />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
