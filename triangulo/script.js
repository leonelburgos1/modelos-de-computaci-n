function calcular() {
    let a = parseFloat(document.getElementById("lado1").value);
    let b = parseFloat(document.getElementById("lado2").value);
    let c = parseFloat(document.getElementById("lado3").value);

    if (a <= 0 || b <= 0 || c <= 0 || isNaN(a) || isNaN(b) || isNaN(c)) {
        alert("Todos los lados deben ser mayores a 0");
        return;
    }

    if (a + b <= c || a + c <= b || b + c <= a) {
        alert("Los valores ingresados NO forman un triángulo válido.");
        document.getElementById("tipo").innerHTML = "";
        document.getElementById("area").innerHTML = "";
        return;
    }

    let tipo = "";

    if (a === b && b === c) {
        tipo = "Triángulo Equilátero";
    } else if (a === b || a === c || b === c) {
        tipo = "Triángulo Isósceles";
    } else {
        tipo = "Triángulo Escaleno";
    }

    let s = (a + b + c) / 2;
    let area = Math.sqrt(s * (s - a) * (s - b) * (s - c));

    document.getElementById("tipo").innerHTML = "Tipo: " + tipo;
    document.getElementById("area").innerHTML = "Área: " + area.toFixed(2);

    dibujarTriangulo(a, b, c);
}

function dibujarTriangulo(a, b, c) {
    const canvas = document.getElementById("canvasTriangulo");
    const ctx = canvas.getContext("2d");

    ctx.clearRect(0, 0, canvas.width, canvas.height);

    const escala = 40;

    const x1 = 100;
    const y1 = 260;

    const x2 = x1 + a * escala;
    const y2 = y1;

    const cosC = (a*a + b*b - c*c) / (2 * a * b);
    const anguloC = Math.acos(cosC);

    const x3 = x1 + b * escala * Math.cos(anguloC);
    const y3 = y1 - b * escala * Math.sin(anguloC);

    ctx.beginPath();
    ctx.moveTo(x1, y1);
    ctx.lineTo(x2, y2);
    ctx.lineTo(x3, y3);
    ctx.closePath();

    ctx.fillStyle = "rgba(37,99,235,0.2)";
    ctx.fill();

    ctx.strokeStyle = "#2563eb";
    ctx.lineWidth = 3;
    ctx.stroke();
}
