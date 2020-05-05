class  GameDroppedObject extends GameObject{
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
        ctx.drawImage(makeImage(this.name), this.coordinates.x-this.radius, this.coordinates.y-this.radius, this.radius*2, this.radius*2);
        ctx.fillText(this.quantity, this.coordinates.x - this.radius, this.coordinates.y - this.radius + 10);
    }
}
