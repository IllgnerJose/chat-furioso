<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import Chat from '@/pages/chat/Chat.vue';
import Timer from '@/pages/chat/Timer.vue';

const props = defineProps({
    messages: Object,
    game: Object,
});

const updateMessages = (newMessage) => {
    props.messages.push(newMessage);
};

const startGame = (newGameStatus) => {
    props.game.game_start = newGameStatus.gameStart;
    props.game.game_rounds = newGameStatus.gameRounds;
    props.game.status = newGameStatus.gameStatus;
};

const winGame = (newGameStatus) => {
    props.game.team_1_score = newGameStatus.team1Score;
    props.game.team_2_score = newGameStatus.team2Score;
    props.game.game_rounds = newGameStatus.gameRounds;
};

Echo.private(`game.win.${props.game.id}`).listen("GameWon", (e) => {
    winGame(e)
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
            <div class="grid gap-4 md:grid-cols-1">
                <div class="relative aspect-10/1 overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border flex justify-between items-center p-3 ">
                    <div class="flex gap-3 items-center justify-start w-[35%] font-bold">
                        <img :src="`/storage/img/${game.team_1_logo}`" alt="Game Image" class="h-13 rounded-lg">
                        <h1>{{game.team_1}}</h1>
                    </div>
                    <div class="flex flex-col gap-1 items-center justify-end w-[30%] px-3">
                        <div class="flex gap-2">
                            <h1 class="text-amber-400 font-bold text-5xl">{{game.team_1_score}}</h1>
                            <div class="flex flex-col items-center justify-center">
                                <Timer
                                    :startDate="game.game_start"
                                    :rounds="game.game_rounds"
                                    :gameId="game.id"
                                    @start:game="startGame"
                                />
                                <span class="text-xs">Round {{game.game_rounds}}</span>
                            </div>
                            <h1 class="text-sky-400 font-bold text-5xl">{{game.team_2_score}}</h1>
                        </div>
                    </div>
                    <div class="flex gap-3 items-center justify-end w-[35%] font-bold">
                        <h1>{{game.team_2}}</h1>
                        <img :src="`/storage/img/${game.team_2_logo}`" alt="Game Image" class="h-13 rounded-lg">
                    </div>
                </div>
            </div>
            <div
                class="
                    relative w-full h-1/2
                    flex flex-col rounded-xl
                    border border-sidebar-border/70
                    dark:border-sidebar-border overflow-auto
                    [&::-webkit-scrollbar]:w-2
                    [&::-webkit-scrollbar-track]:rounded-full
                    [&::-webkit-scrollbar-track]:bg-gray-100
                    [&::-webkit-scrollbar-thumb]:rounded-full
                    [&::-webkit-scrollbar-thumb]:bg-gray-300
                    dark:[&::-webkit-scrollbar-track]:bg-neutral-700
                    dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500
                ">
                <Chat
                    :messages="messages"
                    :game="game"
                    @update:messages="updateMessages"
                />
            </div>
        </div>
    </AppLayout>
</template>
