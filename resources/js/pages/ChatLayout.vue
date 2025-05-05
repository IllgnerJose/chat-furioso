<script setup lang="ts">
import Chat from '@/pages/chat/Chat.vue';
import Dashboard from './Dashboard.vue';
import Score from '@/pages/chat/Score.vue';
import Comments from '@/pages/chat/Comments.vue';
import { ref } from 'vue'

const props = defineProps({
    messages: Object,
    comments: Object,
    game: Object,
});

const updateMessages = (newMessage) => {
    props.messages.push(newMessage);
};

const updateComments = (newComment) => {
    props.comments.unshift(newComment);
};

const startGame = (newGameStatus) => {
    props.game.round_start = newGameStatus.roundStart;
    props.game.game_rounds = newGameStatus.gameRounds;
    props.game.status = newGameStatus.gameStatus;
};

const winGame = (newGameStatus) => {
    props.game.team_1_score = newGameStatus.team1Score;
    props.game.team_2_score = newGameStatus.team2Score;
    props.game.game_rounds = newGameStatus.gameRounds;
    props.game.round_start = newGameStatus.roundStart;
};

Echo.private(`game.win.${props.game.id}`).listen("GameWon", (e) => {
    winGame(e)
});

const chatPanel = ref(true);
const commentPanel = ref(false);

const activeCommentPanel = () => {
    commentPanel.value = true;
    chatPanel.value = false;
}

const activeChatPanel = () => {
    chatPanel.value = true;
    commentPanel.value = false;
}
</script>

<template>
    <Dashboard>
        <div class="flex h-screen flex-col gap-4 rounded-xl p-4">
            <div class="grid gap-4 md:grid-cols-1">
                <Score
                    :game="game"
                    @start:game="startGame"
                />
            </div>
            <div class="flex justify-between">
                <button :class="{'border-b border-white': chatPanel}"  class="cursor-pointer w-1/2 p-2" @click="activeChatPanel()">CHAT</button>
                <button :class="{'border-b border-white': commentPanel}" class="cursor-pointer w-1/2" @click="activeCommentPanel()">ROUND A ROUND</button>
            </div>
            <div class="h-full overflow-hidden">
                <Chat
                    v-if="chatPanel"
                    :messages="messages"
                    :game="game"
                    @update:messages="updateMessages"
                />
                <Comments
                    v-if="commentPanel"
                    :comments="comments"
                    :game="game"
                    @update:comments="updateComments"
                />
            </div>
        </div>
    </Dashboard>
</template>
