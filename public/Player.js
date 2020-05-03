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
        // console.log("time = " + time + "; cooldown = " + this.cooldown + "; lastAttack = " + this.lastAttack);
    }
}
