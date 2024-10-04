<script setup>
import Modal from '@/Components/Modal.vue';
import { Link } from '@inertiajs/vue3';

defineProps(['state', 'boardId']);
</script>

<template>
    <Modal :show="state === 'over'">
        <div class="flex flex-col items-center">
            <h1 class="m-4 text-3xl">Game Over!</h1>
            <Link
                method="post"
                as="button"
                class="m-4 inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900"
                :href="route('board.store')"
            >
                New Game
            </Link>
            <Link
                method="post"
                as="button"
                class="m-4 inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900"
                :href="route('board.reset', { board: boardId })"
            >
                Reset
            </Link>
        </div>
    </Modal>
</template>

<style scoped></style>
