<script setup>
import Row from '@/Components/Row.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { init, reveal, flag, mine_count } from '@/Composables/Minesweeper.js';
import { onMounted, watchEffect } from 'vue';
import GameOver from '@/Components/Board/GameOver.vue';
import Winner from '@/Components/Board/Winner.vue';

const props = defineProps(['board']);

watchEffect(() => {
    init(props.board);
});

onMounted(() => {
    init(props.board);
});
</script>

<template>
    <GuestLayout>
        <div class="mx-auto w-12 bg-gray-500 py-3 text-center text-white">{{ mine_count }}</div>
        <div class="board flex flex-col">
            <Row
                v-for="row in board.data.rows"
                :key="row.id"
                :row
                :state="board.data.state"
                @reveal="(cell) => reveal(cell, true)"
                @flag="(cell) => flag(cell)"
            />
        </div>
        <GameOver :board-id="props.board.data.id" :state="props.board.data.state" />
        <Winner :state="props.board.data.state" />
    </GuestLayout>
</template>

<style scoped></style>
