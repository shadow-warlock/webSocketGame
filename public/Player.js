let itemsOnLine = 5;

class  Player extends User{
    constructor(data, socket) {
        super(data);
        this.socket = socket;
        this.horizontal = 0;
        this.vertical = 0;
    }

    work(){
        if(this.horizontal !== 0 || this.vertical !== 0) {
            ws.send(JSON.stringify({type: "move", data: {horizontal: this.horizontal, vertical: this.vertical}}));
        }
    }

    update(data){
        for(let key in data){
            this[key] = data[key];
        }
    }

    attack(x, y){
        ws.send(JSON.stringify({type: "melee", data: {x: x, y: y}}));
    }

    use(x, y){
        let w = inventoryCanvas.clientWidth/itemsOnLine;
        let h = w;
        let position = parseInt(x/w)%itemsOnLine + parseInt((y-20)/h)*itemsOnLine;
        ws.send(JSON.stringify({type: "useItem", data: {"position": position}}));
    }

    draw(ctx, time) {
        super.draw(ctx);
        ctx.fillStyle = "rgb(" +
            this.color.r + ", " +
            this.color.g + ", " +
            this.color.b +
            ")";
        ctx.beginPath();
        let currentCooldown = time - this.lastAttack > this.cooldown ? this.cooldown : time - this.lastAttack;
        ctx.arc(this.coordinates.x, this.coordinates.y, this.meleeRadius, 0, 2 * Math.PI * (1-((currentCooldown))/this.cooldown));
        ctx.fill();
    }

    drawInventory(ctx, time) {
        let w = ctx.canvas.clientWidth/itemsOnLine;
        let h = w;
        ctx.font = parseInt(5 + 30/itemsOnLine) + "pt Arial";
        ctx.fillStyle = "black";
        for(let i = 0; i < this.inventory.length; i++){
            let x = i % itemsOnLine * w;
            let y = parseInt(i / itemsOnLine) * h + 20;
            ctx.drawImage(makeImage(this.inventory[i].name), x, y, w, h);
            ctx.fillText(this.inventory[i].quantity, x, y + parseInt(5 + 30/itemsOnLine));
        }

    }

    drawTop(ctx, time) {
        ctx.font = "15px Arial";
        ctx.fillStyle = "black";
        ctx.fillText(this.login + " " + this.hp, 25, 15);
        ctx.fillText("Квадрат: " + parseInt(this.coordinates.x/500, 10) + ":" + parseInt(this.coordinates.y/500, 10), 25, 30);
        ctx.beginPath();
        ctx.strokeStyle = "green";
        ctx.lineWidth = 10;
        ctx.moveTo(150, 25);
        ctx.lineTo(150 + (300/1000*this.exp), 25);
        ctx.stroke();
    }
}
