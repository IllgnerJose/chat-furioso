<script setup>
import { useForm} from '@inertiajs/vue3';
import { computed, ref } from 'vue';
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
    <section class="flex flex-col" id="scroller">
        <ul class="p-4 flex flex-col gap-5">
            <WhenVisible data="messages">
                <template #fallback>
                    <div>Loading...</div>
                </template>
                <li v-for="message in messages" :key="message.id">
                <span v-if="message.who === user.name || message.who === 'Eu'" class="flex justify-end">
                    Eu -- {{ message.message }}
                </span>
                    <span v-else-if="message.who !== user.name">
                    {{ message.who }} -- {{ message.message }}
                </span>
                </li>
            </WhenVisible>
        </ul>

        <form class="flex flex gap-5 p-4 sticky bg-zinc-900" @submit.prevent="submit" id="anchor">
            <input
                type="text"
                v-model="form.message"
                class="bg-slate-50 border border-slate-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
            />
            <button
                type="submit"
                class="rounded-md cursor-pointer bg-[#104370] hover:bg-[#11324f] text-white py-2 px-3"
                :disabled="form.processing">
                Salvar
            </button>
        </form>
    </section>
</template>

<style scoped>
    #scroller * {
        overflow-anchor: none;
    }

    #anchor {
        overflow-anchor: auto;
        height: 100%;
    }
</style>
