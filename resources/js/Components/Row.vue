<script setup>

import Cell from "@/Components/Cell.vue";

const props = defineProps(['board', 'row']);

function revealAround(cell) {
    for (let x = -1; x <= 1; x++) {
        for (let y = -1; y <= 1; y++) {
            reveal(props.board[cell.y + y][cell.x + x]);
        }
    }
}

const reveal = (cell) => {
    if (typeof cell === "undefined") return;

    if (! cell.is_revealed) {
        cell.is_revealed = true;

        if (cell.value === 0) {
            revealAround(cell);
        }
    }
}

const countFlagsAround = (cell) => {
    let count = 0;
    for (let x = -1; x <= 1; x++) {
        for (let y = -1; y <= 1; y++) {
            let test_cell = props.board[cell.y + y][cell.x + x];
            if (typeof test_cell !== "undefined") {
                if (test_cell.is_flag) {
                    count++;
                }
            }
        }
    }

    return count;
}

const flag = (cell) => {
    if (cell.is_revealed ) {
        if (countFlagsAround(cell) === cell.value) {
            revealAround(cell);
        }
        return;
    }

    cell.is_flag = !cell.is_flag;
};
</script>

<template>
    <div class="flex flex-row">
        <Cell v-for="cell in row" :key="cell.index" :cell @reveal="reveal(cell)" @flag="flag(cell)" />
    </div>
</template>

<style scoped>

</style>
