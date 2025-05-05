<script setup lang="ts">
    import Game from '@/pages/chat/Game.vue';
    import Dashboard from './Dashboard.vue';
    defineProps({
        nextGames: Object,
        inProgressGames: Object,
        finishedGames: Object,
    });

    const isEmpty = (games) => {
        return games.length == 0;
    }
</script>

<template>
    <Dashboard>
        <div class="flex h-screen flex-col gap-4 rounded-xl p-4">
            <div v-if="!isEmpty(inProgressGames)" class="flex flex-col gap-3">
                <h1 class="text-xl font-bold">Jogos Em Andamento</h1>
                <Game :games="inProgressGames"/>
            </div>

            <div v-if="!isEmpty(nextGames)" class="flex flex-col gap-3">
                <h1 class="text-xl font-bold">Próximos Jogos</h1>
                <Game :games="nextGames"/>
            </div>

            <div v-if="!isEmpty(finishedGames)" class="flex flex-col gap-3">
                <h1 class="text-xl font-bold">Jogos Finalizados</h1>
                <Game :games="finishedGames"/>
            </div>
        </div>
    </Dashboard>
</template>

<style scoped>

</style>
