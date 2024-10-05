<script setup>
import Modal from '@/Components/Modal.vue';
import { Link } from '@inertiajs/vue3';
import ConfettiExplosion from 'vue-confetti-explosion';

defineProps(['state']);
</script>

<template>
    <Modal :show="state === 'winner'">
        <div class="flex flex-col items-center">
            <h1 class="m-4 text-3xl">Congrats you won!</h1>
            <Link
                method="post"
                as="button"
                class="m-4 inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900"
                :href="route('board.store')"
            >
                Play Again!
            </Link>
        </div>
    </Modal>
    <div class="absolute left-1/2 top-1/4 z-[60] -translate-x-1/2 -translate-y-1/2 transform">
        <div class="relative align-middle">
            <ConfettiExplosion v-if="state === 'winner'" :stageHeight="2000" :particleSize="8" :force="0.3" />
        </div>
    </div>
</template>

<style scoped></style>
