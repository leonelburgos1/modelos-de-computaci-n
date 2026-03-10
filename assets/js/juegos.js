const tableBody = document.getElementById("tableBody");

async function listarJuegos() {

    const inputBuscar = document.getElementById("buscarInput");
    const textoBuscar = inputBuscar ? inputBuscar.value : "";

    let url = "./API/crud_juegos.php";

    if (textoBuscar) {
        url += `?buscar=${textoBuscar}`;
    }

    const response = await fetch(url);
    const juegos = await response.json();

    tableBody.innerHTML = "";

    if (juegos.length === 0) {
        tableBody.innerHTML = "<tr><td colspan='5'>No hay resultados</td></tr>";
        return;
    }

    juegos.forEach(juego => {
        tableBody.innerHTML += `
        <tr>
            <td>${juego.nombre}</td>
            <td>${juego["tamaño"]}</td>
            <td>${juego.categoria}</td>
            <td>${juego.desarrollador ?? "Sin desarrollador"}</td>
            <td>
                <button onclick="cargarEdicion(${juego.id})" class="btn btn-warning btn-sm">Editar</button>
                <button onclick="eliminarJuego(${juego.id})" class="btn btn-danger btn-sm">Eliminar</button>
            </td>
        </tr>
        `;
    });
}

async function cargarEdicion(id) {

    const response = await fetch(`./API/crud_juegos.php?id=${id}`);
    const juego = await response.json();

    document.getElementById("nombre").value = juego.nombre;
    document.getElementById("tamaño").value = juego["tamaño"];
    document.getElementById("categoria").value = juego.categoria;

    // seleccionar el desarrollador correcto
    document.getElementById("desarrollador").value = juego.id_desarrollador;

    document.getElementById("formJuego").setAttribute("data-editando", id);

    const btn = document.getElementById("btnGuardar");

    btn.textContent = "Actualizar";
    btn.classList.remove("btn-azul");
    btn.classList.add("btn-success");
}

async function agregarJuego(event) {

    event.preventDefault();

    const nombre = document.getElementById("nombre").value;
    const tamaño = document.getElementById("tamaño").value;
    const categoria = document.getElementById("categoria").value;
    const desarrollador = document.getElementById("desarrollador").value;

    const form = document.getElementById("formJuego");
    const idEditando = form.getAttribute("data-editando");

    if (idEditando) {

        await fetch("./API/crud_juegos.php", {
            method: "PUT",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                id: idEditando,
                nombre: nombre,
                tamaño: tamaño,
                categoria: categoria,
                id_desarrollador: desarrollador
            })
        });

        form.removeAttribute("data-editando");

        const btn = document.getElementById("btnGuardar");

        btn.textContent = "+";
        btn.classList.remove("btn-success");
        btn.classList.add("btn-azul");

    } else {

        await fetch("./API/crud_juegos.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                nombre: nombre,
                tamaño: tamaño,
                categoria: categoria,
                id_desarrollador: desarrollador
            })
        });

    }

    listarJuegos();
    form.reset();
}

async function eliminarJuego(id) {

    const confirmar = confirm("¿Estás seguro de eliminar este juego?");

    if (!confirmar) return;

    await fetch("./API/crud_juegos.php", {
        method: "DELETE",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id })
    });

    listarJuegos();
}


// cargar desarrolladores en el select del formulario
async function cargarDesarrolladores(){

    const response = await fetch("./API/crud_desarrolladores.php");
    const desarrolladores = await response.json();

    const select = document.getElementById("desarrollador");

    select.innerHTML = '<option value="">Seleccione desarrollador</option>';

    desarrolladores.forEach(dev => {

        select.innerHTML += `
        <option value="${dev.id_desarrollador}">
            ${dev.nombre}
        </option>
        `;

    });
}


// funciones al cargar la página
document.addEventListener("DOMContentLoaded", () => {

    listarJuegos();
    cargarDesarrolladores();

    const buscador = document.getElementById("buscarInput");

    if (buscador) {
        buscador.addEventListener("keyup", listarJuegos);
    }

});