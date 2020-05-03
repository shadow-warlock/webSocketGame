let users = [];
let player = null;
let canvas;
let topCanvas;
let time = 0;

function onPlayerCreate() {
    document.addEventListener('keydown', (event) => {
        press(event, true);
    });
    document.addEventListener('keyup', (event) => {
        press(event, false);
    });
    canvas.addEventListener('mousedown', attack);
    setInterval(() => {
        player.work();
    }, 50);
}

function press(event, type) {
    const keyName = event.code;
    if (keyName === "KeyW") {
        player.vertical = (type ? -1 : 0);
    }
    if (keyName === "KeyS") {
        player.vertical = (type ? 1 : 0);
    }
    if (keyName === "KeyD") {
        player.horizontal = (type ? 1 : 0);
    }
    if (keyName === "KeyA") {
        player.horizontal = type ? -1 : 0;
    }
}


function attack(event) {
    if (event.button === 0) {
        let x = event.clientX + document.body.scrollLeft +
            document.documentElement.scrollLeft;
        let y = event.clientY + document.body.scrollTop +
            document.documentElement.scrollTop;
        x -= canvas.offsetLeft;
        y -= canvas.offsetTop;
        player.attack(x, y);
    }
}
