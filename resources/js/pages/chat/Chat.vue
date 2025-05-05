<script setup>
import { useForm} from '@inertiajs/vue3';
import { computed, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3'
import axios from "axios";
import { WhenVisible } from '@inertiajs/vue3';

const page = usePage()
const user = computed(() => page.props.auth.user)

const props = defineProps({
    messages: Array,
    game: Object,
});

const emit = defineEmits(['update:messages']);

const updateMessages = (newMessage) => {
    emit('update:messages', newMessage);
};

Echo.private(`messages.game.${props.game.id}`).listen("MessageReceived", (e) => {
    if (!props.messages.find((m) => m.id === e.id)) {
        updateMessages(e)
    }
});

const form = useForm({
    message:null,
    id: null,
    game_id: props.game.id,
});

function submit(){
    const randomId = crypto.randomUUID();

    const msg = {
        id: randomId,
        message: form.message,
        game_id: form.game_id,
        who: "Eu",
    }
    updateMessages(msg);

    form.id = randomId;

    axios.post(route('message.store', form));
    form.reset();
}
</script>

<template>
    <div class="flex flex-col gap-3 max-h-full">
        <ul
            class="
            flex
            flex-col-reverse
            gap-5
            [&::-webkit-scrollbar]:w-2
            [&::-webkit-scrollbar-track]:rounded-full
            [&::-webkit-scrollbar-track]:bg-gray-100
            [&::-webkit-scrollbar-thumb]:rounded-full
            [&::-webkit-scrollbar-thumb]:bg-gray-300
            dark:[&::-webkit-scrollbar-track]:bg-neutral-700
            dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500
            overflow-y-scroll"
            id="scroller"
        >
            <WhenVisible data="messages">
                <template #fallback>
                    <div>Loading...</div>
                </template>
                <li v-for="message in [...messages].reverse()" :key="message.id">
                    <div v-if="message.who === user.name || message.who === 'Eu'" class="flex justify-end items-start hover:bg-zinc-900 gap-3 p-3">
                        <div class="flex flex-col justify-end items-end">
                            <span>
                                Eu
                            </span>
                            <span>
                                {{ message.message }}
                            </span>
                        </div>
                        <div>
                            <div class="w-10 h-10 bg-amber-300 rounded-full"></div>
                        </div>
                    </div>
                    <div v-else-if="message.who !== user.name" class="flex justify-start items-start hover:bg-zinc-900 gap-3 p-3">
                        <div>
                            <div class="w-10 h-10 bg-white rounded-full"></div>
                        </div>
                        <div class="flex flex-col justify-end items-start">
                            <span>
                                {{ message.who }}
                            </span>
                            <span>
                                {{ message.message }}
                            </span>
                        </div>
                    </div>
                </li>
                <div id="anchor"></div>
            </WhenVisible>
        </ul>
        <form class="sticky bottom-0 bg-zinc-900" @submit.prevent="submit">
            <input
                type="text"
                v-model="form.message"
                class="bg-slate-50 border border-slate-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                placeholder="Mensagem.."
            />
        </form>
    </div>
</template>

<style scoped>
    #scroller * {
        overflow-anchor: none;
    }

    #anchor {
        overflow-anchor: auto;
        height: 1px;
    }
</style>
