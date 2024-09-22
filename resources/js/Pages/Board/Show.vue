<script setup>

import Row from "@/Components/Row.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import {init, reveal, flag} from "@/Composables/Minesweeper.js"
import {onMounted} from "vue";

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
    </GuestLayout>
</template>

<style scoped>

</style>
