let board;
let updates = [];

const init = (new_board) => {
    board = new_board;
}

const revealAround = (cell) => {
    for (let x = -1; x <= 1; x++) {
        for (let y = -1; y <= 1; y++) {
            if (cell.y + y > 29) continue;
            if (cell.y + y < 0) continue;
            reveal(board.data.rows[cell.y + y].cells[cell.x + x])
        }
    }
}

const sendUpdates = () => {
    axios.put(route('board.update', board.data), { updates: updates });
    updates = [];
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
    updates.push(cell);

    if (initial) {
        sendUpdates();
    }
    if (cell.is_mine) {
        board.data.state = 'over';
    }
    return [];
}

const countFlagsAround = (cell) => {
    let count = 0;
    for (let x = -1; x <= 1; x++) {
        for (let y = -1; y <= 1; y++) {
            if (cell.y + y > 29) continue;
            if (cell.y + y < 0) continue;
            let test_cell = board.data.rows[cell.y + y].cells[cell.x + x];
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
            revealAround(cell);
            sendUpdates();
        }
        return;
    }

    cell.is_flag = !cell.is_flag;
    updates.push(cell);
    sendUpdates()
};

export { init, reveal, flag };
