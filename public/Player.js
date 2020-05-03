class  Player extends User{
    constructor(data, socket) {
        super(data);
        this.socket = socket;
        this.horizontal = 0;
        this.vertical = 0;
        this.cooldown = 0;
        this.cooldownMax = 2000;
    }

    work(){
        if(this.horizontal !== 0 || this.vertical !== 0) {
            ws.send(JSON.stringify({type: "move", data: {horizontal: this.horizontal, vertical: this.vertical}}));
        }
        if(this.cooldown > 0){
            this.cooldown = this.cooldown - 50 > 0 ? this.cooldown - 50 : 0
        }
    }

    update(data){
        for(let key in data){
            this[key] = data[key];
        }
    }

    attack(x, y){
        if(this.cooldown <= 0){
            this.cooldown = this.cooldownMax;
        }
    }

    draw(ctx) {
        super.draw(ctx);
        ctx.fillStyle = "rgb(" +
            this.color.r + ", " +
            this.color.g + ", " +
            this.color.b +
            ")";
        ctx.beginPath();
        ctx.arc(this.coordinates.x, this.coordinates.y, 40, 0, 2 * Math.PI * (this.cooldown/this.cooldownMax));
        ctx.fill();
    }
}
