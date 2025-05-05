<script setup lang="ts">
import Timer from '@/pages/chat/Timer.vue';

const props = defineProps({
    game: Object,
});

const emit = defineEmits(['start:game']);

const startGame = (newGameStatus) => {
    emit('start:game', newGameStatus);
};
</script>

<template>
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
                    :startDate="game.round_start"
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
</template>

<style scoped>

</style>
