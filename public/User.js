class  User {
    constructor(data) {
        Object.assign(this, data);
        this.color = {
            r: 123,
            g: 12,
            b: 14
        };
    }

    drawRIP(ctx){
        let img = new Image();   // Создает новый элемент img
        img.src = "/assets/img/RIP2.png";
        ctx.drawImage(img, this.coordinates.x-this.radius, this.coordinates.y-this.radius, this.radius*2, this.radius*2);

    }

    draw(ctx){
        if(this.hp === 0){
            this.drawRIP(ctx);
            return;
        }
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
        ctx.beginPath();
        ctx.arc(this.coordinates.x, this.coordinates.y, this.meleeRadius, 0, 2 * Math.PI);
        ctx.closePath();
        ctx.stroke();

        ctx.beginPath();
        ctx.font = "15px Arial";
        ctx.fillStyle = "black";
        ctx.fillText(this.login, this.coordinates.x - 25, this.coordinates.y - 35);
        ctx.fill();
        ctx.beginPath();
        ctx.strokeStyle = "red";
        ctx.lineWidth = 10;
        ctx.moveTo(this.coordinates.x - 25, this.coordinates.y - 30);
        ctx.lineTo(this.coordinates.x - 25 + (50/this.maxHp*this.hp), this.coordinates.y - 30);
        ctx.stroke();

    }
}
