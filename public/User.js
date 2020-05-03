class  User {
    constructor(data) {
        Object.assign(this, data);
    }

    draw(ctx){
        ctx.fillStyle = "rgb(" +
            this.color.r + ", " +
            this.color.g + ", " +
            this.color.b +
            ")";
        ctx.beginPath();
        ctx.arc(this.coordinates.x, this.coordinates.y, 20, 0, 2 * Math.PI);
        ctx.closePath();
        ctx.fill();
        ctx.strokeStyle = "rgb(" +
            this.color.r + ", " +
            this.color.g + ", " +
            this.color.b +
            ")";
        ctx.beginPath();
        ctx.arc(this.coordinates.x, this.coordinates.y, 40, 0, 2 * Math.PI);
        ctx.closePath();
        ctx.stroke();
        ctx.font = "15px Arial";
        ctx.fillStyle = "black";
        ctx.fillText(this.login, this.coordinates.x - 25, this.coordinates.y - 25);

    }
}
