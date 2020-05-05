
const minSize = 0.3;
let images = {};

function makeImage(name) {
    if(!images[name]){
        let img = new Image();   // Создает новый элемент img
        // console.log(this.name)
        img.src = "/assets/img/"+name+".png";
        images[name] = img;
    }
    return images[name];
}

class  GameObject {
    constructor(data) {
        Object.assign(this, data);
        this.color = {
            r: 123,
            g: 123,
            b: 123
        };
    }
}
