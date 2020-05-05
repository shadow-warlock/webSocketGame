class  GameDamagedObject extends GameObject{
    constructor(data) {
        super(data);
    }

    draw(ctx){
        let color = "rgb(" +
            this.color.r + ", " +
            this.color.g + ", " +
            this.color.b +
            ")";
        ctx.fillStyle = color;
        ctx.strokeStyle = color;
        ctx.lineWidth = 1;
        ctx.beginPath();
        ctx.arc(this.coordinates.x, this.coordinates.y, this.radius, 0, 2 * Math.PI);
        ctx.closePath();
        ctx.stroke();
        ctx.drawImage(makeImage(this.name), this.coordinates.x-this.radius*Math.max(this.hp/this.maxHp, minSize), this.coordinates.y-this.radius*Math.max(this.hp/this.maxHp, minSize), this.radius*2*Math.max(this.hp/this.maxHp, minSize), this.radius*2*Math.max(this.hp/this.maxHp, minSize));

    }
}
