<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    games: Object,
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-screen flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div v-for="game in games" class="relative aspect-3/1 overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <Link :href="route('chat', game.id)" class="flex justify-between items-center p-3 cursor-pointer h-full">
                        <div class="flex gap-3 items-center justify-between w-35 font-bold">
                            <img :src="`/storage/img/${game.team_1_logo}`" alt="Game Image" class="h-13 rounded-lg">
                            <h1>{{game.team_1}}</h1>
                        </div>
                        <div class="flex gap-1 items-center justify-center w-30 p-4 text-4xl">
                            <h1 class="text-amber-400 font-bold">{{game.team_1_score}}</h1>
                            <span>-</span>
                            <h1 class="text-sky-400 font-bold">{{game.team_2_score}}</h1>
                        </div>
                        <div class="flex gap-3 items-center justify-between w-35 font-bold">
                            <h1>{{game.team_2}}</h1>
                            <img :src="`/storage/img/${game.team_2_logo}`" alt="Game Image" class="h-13 rounded-lg">
                        </div>
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
