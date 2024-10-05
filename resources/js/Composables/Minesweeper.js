import { ref, watchEffect } from 'vue';

let board;
let updates = [];
const mine_count = ref(0);

const init = (new_board) => {
    board = new_board;

    watchEffect(() => {
        mine_count.value = board.data.mine_count - countFlags();
    });
};

const countFlags = () => {
    let flags = 0;
    for (let x = 0; x < board.data.rows.length; x++) {
        for (let y = 0; y < board.data.rows[x].cells.length; y++) {
            let cell = board.data.rows[x].cells[y];
            if (cell.is_flag) {
                flags++;
            }
        }
    }
    return flags;
};

const revealAround = (cell) => {
    for (let x = -1; x <= 1; x++) {
        for (let y = -1; y <= 1; y++) {
            if (cell.y + y > 29) continue;
            if (cell.y + y < 0) continue;
            reveal(board.data.rows[cell.y + y].cells[cell.x + x]);
        }
    }
};

const queueUpdate = (cell) => {
    updates.push({
        id: cell.id,
        is_flag: cell.is_flag,
        is_revealed: cell.is_revealed,
    });
};

const sendUpdates = () => {
    axios.put(route('board.update', board.data), { updates: updates }).then((response) => {
        if (response.data.state !== board.state) {
            board.data.state = response.data.state;
        }
    });
    updates = [];
};

const reveal = (cell, initial = false) => {
    if (typeof cell === 'undefined') return;
    if (cell.is_flag) return;

    if (!cell.is_revealed) {
        cell.is_revealed = true;

        if (cell.value === '0') {
            revealAround(cell);
        }
    }
    queueUpdate(cell);

    if (initial) {
        sendUpdates();
    }

    return [];
};

const countFlagsAround = (cell) => {
    let count = 0;
    for (let x = -1; x <= 1; x++) {
        for (let y = -1; y <= 1; y++) {
            if (cell.y + y > 29) continue;
            if (cell.y + y < 0) continue;
            let test_cell = board.data.rows[cell.y + y].cells[cell.x + x];
            if (typeof test_cell !== 'undefined') {
                if (test_cell.is_flag) {
                    count++;
                }
            }
        }
    }

    return count;
};

const flag = (cell) => {
    if (cell.is_revealed) {
        if (countFlagsAround(cell) == cell.value) {
            revealAround(cell);
            sendUpdates();
        }
        return;
    }

    cell.is_flag = !cell.is_flag;

    queueUpdate(cell);
    sendUpdates();
};

export { init, reveal, flag, mine_count };
