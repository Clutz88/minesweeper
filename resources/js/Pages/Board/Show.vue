<script setup>

import Row from "@/Components/Row.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import {init, reveal, flag} from "@/Composables/Minesweeper.js"
import {onMounted} from "vue";
import Modal from "@/Components/Modal.vue";
import {Link} from "@inertiajs/vue3";

const props = defineProps(['board']);

onMounted(() => {
    init(props.board);
})
</script>

<template>
    <GuestLayout>
        <div class="board flex flex-col">
            <Row
                v-for="row in board.data.rows"
                :key="row.id"
                :row
                @reveal="(cell) => reveal(cell, true)"
                @flag="(cell) => flag(cell)"
            />
        </div>
        <Modal :show="props.board.data.state === 'over'">
            <div class="flex flex-col items-center">
                <h1 class="text-3xl m-4">Game Over!</h1>
                <Link
                    method="post"
                    as="button"
                    class="m-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    :href="route('board.store')"
                >
                    New Game
                </Link>
            </div>
        </Modal>
    </GuestLayout>
</template>

<style scoped>

</style>
