let users = [];
let world = {};
let objects = [];
let player = null;
let canvas;
let topCanvas;
let inventoryCanvas;
let time = 0;

function draw() {
    let ctx = canvas.getContext('2d');
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.fillStyle = "rgb(80, 220, 100)";
    ctx.save();
    ctx.translate(-player.coordinates.x + canvas.width/2, -player.coordinates.y + canvas.height/2);
    ctx.fillRect(0,0, world.width, world.height);
    for (let i = 0; i < objects.length; i++) {
        objects[i].draw(ctx);
    }
    for (let i = 0; i < users.length; i++) {
        users[i].draw(ctx);
    }
    player.draw(ctx, time);
    ctx.restore();
}

function drawTop() {
    let topCtx = topCanvas.getContext('2d');
    topCtx.clearRect(0, 0, canvas.width, canvas.height);
    player.drawTop(topCtx, time);
}

function drawInventory() {
    let inventoryCtx = inventoryCanvas.getContext('2d');
    inventoryCtx.clearRect(0, 0, canvas.width, canvas.height);
    player.drawInventory(inventoryCtx, time);
}

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
        player.attack(x + player.coordinates.x - canvas.width/2, y + player.coordinates.y - canvas.height/2);
    }
}
