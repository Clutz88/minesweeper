<script setup>

import Cell from "@/Components/Cell.vue";

const props = defineProps(['board', 'row']);

function revealAround(cell) {
    let updates = [];
    for (let x = -1; x <= 1; x++) {
        for (let y = -1; y <= 1; y++) {
            if (cell.y + y > 29) continue;
            if (cell.y + y < 0) continue;

            updates.push(
                reveal(
                    props.board.data.rows[cell.y + y].cells[cell.x + x]
                )
            );
        }
    }
    return updates;
}

function sendUpdates(updates) {
    axios.put(route('board.update', props.board.data), { updates: updates })
}

const reveal = (cell, initial = false) => {
    if (typeof cell === "undefined") return;
    if (cell.is_flag) return;

    if (! cell.is_revealed) {
        cell.is_revealed = true;

        if (cell.value === "0") {
            let updates = revealAround(cell);
            if (initial) {
                return sendUpdates(updates);
            }
            return updates;
        }
    }

    if (initial) {
        sendUpdates([cell])
    } else {
        return cell;
    }
    return [];
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
            sendUpdates(revealAround(cell));
        }
        return;
    }

    cell.is_flag = !cell.is_flag;
    sendUpdates([cell])
};
</script>

<template>
    <div class="flex flex-row">
        <Cell v-for="cell in row.cells" :key="cell.index" :cell @reveal="reveal(cell, true)" @flag="flag(cell)" />
    </div>
</template>

<style scoped>

</style>
