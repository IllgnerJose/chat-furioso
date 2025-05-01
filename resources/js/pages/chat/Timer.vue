<script setup>

import { ref, onMounted, watch } from 'vue';

const emit = defineEmits(['start:game']);

const startGame = (newGameStatus) => {
    emit('start:game', newGameStatus);
};

const countdown = ref('2:00');

const props = defineProps({
    startDate: String,
    rounds: Number,
    gameId: Number,
})

Echo.private(`game.start.${props.gameId}`).listen("GameStarted", (e) => {
    startGame(e)
});

let interval;

const startCountdown = () => {
    const start = new Date(props.startDate);

    if (interval) {
        clearInterval(interval);
    }

    interval = setInterval(() => {
        const secondsPerRound = 120 * props.rounds;
        const diff = Date.now() - start.getTime();
        const sec = Math.floor(diff / 1000) + (secondsPerRound - 120);
        const secCountdown = (secondsPerRound - sec);
        const min = Math.floor(secCountdown / 60);

        if (min < 0) {
            countdown.value = "0:0";
        } else {
            countdown.value = `${min}:${secCountdown % 60}`;
        }
    }, 1000);
};

onMounted(() => {
    startCountdown();
});

watch(() => [props.startDate, props.rounds], () => {
    startCountdown();
});
</script>

<template>
    <span class="text-xl font-bold">{{ countdown }}</span>
</template>

<style scoped>

</style>
