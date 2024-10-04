<script setup>
import Cell from '@/Components/Cell.vue';

const props = defineProps(['board', 'row', 'state']);
const emit = defineEmits(['reveal', 'flag']);

const reveal = (cell) => {
    emit('reveal', cell);
};
const flag = (cell) => {
    emit('flag', cell);
};
</script>

<template>
    <div class="flex flex-row">
        <Cell
            v-for="cell in row.cells"
            :key="cell.index"
            :cell
            :state="state"
            @reveal="reveal(cell)"
            @flag="flag(cell)"
        />
    </div>
</template>

<style scoped></style>
