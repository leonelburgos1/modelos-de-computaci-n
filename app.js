const tableBody = document.getElementById("tableBody");

async function listarJuegos() {
    const response = await fetch("./API/crud.php");
    const juegos = await response.json();

    tableBody.innerHTML = "";

    juegos.forEach(juego => {
        tableBody.innerHTML += `
        <tr>
            <td>${juego.nombre}</td>
            <td>${juego.tamaño}</td>
            <td>${juego.categoria}</td>
            <td>${juego.creador}</td>
            <td>
                <button onclick="cargarEdicion(${juego.id})" class="btn btn-warning btn-sm">Editar</button>
                <button onclick="eliminarJuego(${juego.id})" class="btn btn-danger btn-sm">Eliminar</button>
            </td>
        </tr>
        `;
    });
}

async function cargarEdicion(id) {
    const response = await fetch(`./API/crud.php?id=${id}`);
    const juego = await response.json();

    document.getElementById("nombre").value = juego.nombre;
    document.getElementById("tamaño").value = juego["tamaño"];
    document.getElementById("categoria").value = juego.categoria;
    document.getElementById("creador").value = juego.creador;

    document.getElementById("formJuego").setAttribute("data-editando", id);

    // Cambiar botón a actualizar
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
    const creador = document.getElementById("creador").value;

    const form = document.getElementById("formJuego");
    const idEditando = form.getAttribute("data-editando");

    if (idEditando) {
        console.log("Actualizando ID:", idEditando);
        //PUT (Actualizar)
        await fetch("./API/crud.php", {
            method: "PUT",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                id: idEditando,
                nombre: nombre,
                tamaño: tamaño,
                categoria: categoria,
                creador: creador
            })
        });

        form.removeAttribute("data-editando");

        // Volver botón a modo agregar
        const btn = document.getElementById("btnGuardar");
        btn.textContent = "+";
        btn.classList.remove("btn-success");
        btn.classList.add("btn-azul");

    } else {

        //  POST (Agregar)
        await fetch("./API/crud.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                nombre: nombre,
                tamaño: tamaño,
                categoria: categoria,
                creador: creador
            })
        });
    }

    listarJuegos();
    form.reset();
}

async function eliminarJuego(id) {
    await fetch("./API/crud.php", {
        method: "DELETE",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id })
    });

    listarJuegos();
}

document.addEventListener("DOMContentLoaded", listarJuegos);