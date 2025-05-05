<script setup>
import { WhenVisible } from '@inertiajs/vue3';

const props = defineProps({
    comments: Array,
    game: Object,
});

const emit = defineEmits(['update:comments']);

const updateComments = (newComment) => {
    emit('update:comments', newComment);
};

Echo.private(`comments.game.${props.game.id}`).listen("CommentReceived", (e) => {
    const newComment = {
        "id": e.id,
        "comment": e.comment,
        "comment_round_time": e.commentRoundTime,
    };
    updateComments(newComment);
});
</script>

<template>
    <div class="flex flex-col max-h-full" id="scroller">
        <ul class="
        p-4
        flex
        flex-col
        [&::-webkit-scrollbar]:w-2
        [&::-webkit-scrollbar-track]:rounded-full
        [&::-webkit-scrollbar-track]:bg-gray-100
        [&::-webkit-scrollbar-thumb]:rounded-full
        [&::-webkit-scrollbar-thumb]:bg-gray-300
        dark:[&::-webkit-scrollbar-track]:bg-neutral-700
        dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500
        overflow-y-scroll
        gap-5">
            <WhenVisible data="messages">
                <template #fallback>
                    <div>Loading...</div>
                </template>
                <li v-for="comment in comments" :key="comment.id" class="p-5 flex flex-col gap-2 border border-sidebar-border/70 dark:border-sidebar-border rounded-xl">
                    <div>
                        <div class="font-bold">COMENTÁRIOS <span>{{comment.comment_round_time}}</span></div>
                    </div>
                    <div>
                        <span>{{comment.comment}}</span>
                    </div>
                </li>
            </WhenVisible>
        </ul>
    </div>
</template>

<style scoped>

</style>
