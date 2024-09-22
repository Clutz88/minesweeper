<script setup>

import Cell from "@/Components/Cell.vue";

const props = defineProps(['board', 'row']);

function revealAround(cell, initial = false) {
    for (let x = -1; x <= 1; x++) {
        for (let y = -1; y <= 1; y++) {
            if (cell.y + y > 29) continue;
            if (cell.y + y < 0) continue;
            reveal(props.board.data.rows[cell.y + y].cells[cell.x + x]);
        }
    }

    if (initial) {
        updateEntireBoard();
    }
}

const reveal = (cell, initial = false) => {
    if (typeof cell === "undefined") return;
    if (cell.is_flag) return;

    if (! cell.is_revealed) {
        cell.is_revealed = true;

        if (cell.value === "0") {
            revealAround(cell);
        }
    }

    if (initial) {
        updateEntireBoard();
    }
}

const updateEntireBoard = () => {
    axios.put(route('board.update', props.board.data), {board: props.board.data})
}

const countFlagsAround = (cell) => {
    let count = 0;
    for (let x = -1; x <= 1; x++) {
        for (let y = -1; y <= 1; y++) {
            if (cell.y + y > 29) continue;
            if (cell.y + y < 0) continue;
            let test_cell = props.board.data.rows[cell.y + y].cells[cell.x + x];
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
        if (countFlagsAround(cell) == cell.value) {
            revealAround(cell, true);
        }
        return;
    }

    cell.is_flag = !cell.is_flag;
    axios.put(
        route('board.update', props.board.data),
        {
            "board": {
                "rows": [
                    {
                    "cells": [cell]
                    }
                ]
            }
        }
    );
};
</script>

<template>
    <div class="flex flex-row">
        <Cell v-for="cell in row.cells" :key="cell.index" :cell @reveal="reveal(cell, true)" @flag="flag(cell)" />
    </div>
</template>

<style scoped>

</style>
