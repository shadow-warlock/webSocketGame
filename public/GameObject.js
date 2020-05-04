
const minSize = 0.3;
class  GameObject {
    constructor(data) {
        Object.assign(this, data);
        this.color = {
            r: 123,
            g: 123,
            b: 123
        };
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
        ctx.fill();
        let img = new Image();   // Создает новый элемент img
        img.src = "/assets/img/stone.png";
        ctx.drawImage(img, this.coordinates.x-this.radius*Math.max(this.hp/this.maxHp, minSize), this.coordinates.y-this.radius*Math.max(this.hp/this.maxHp, minSize), this.radius*2*Math.max(this.hp/this.maxHp, minSize), this.radius*2*Math.max(this.hp/this.maxHp, minSize));

    }
}
