const tableBody = document.getElementById("tableBodyDesarrolladores");

async function listarDesarrolladores() {

    const inputBuscar = document.getElementById("buscarInput");
    const textoBuscar = inputBuscar ? inputBuscar.value : "";

    let url = "./API/crud_desarrolladores.php";

    if (textoBuscar) {
        url += `?buscar=${textoBuscar}`;
    }

    const response = await fetch(url);
    const desarrolladores = await response.json();

    tableBody.innerHTML = "";

    if (desarrolladores.length === 0) {
        tableBody.innerHTML = "<tr><td colspan='4'>No hay resultados</td></tr>";
        return;
    }

    desarrolladores.forEach(dev => {

        tableBody.innerHTML += `
        <tr>
            <td>${dev.nombre}</td>
            <td>${dev.pais}</td>
            <td>${dev.anio_fundacion}</td>
            <td>
                <button onclick="cargarEdicion(${dev.id_desarrollador})" class="btn btn-warning btn-sm">Editar</button>
                <button onclick="eliminarDesarrollador(${dev.id_desarrollador})" class="btn btn-danger btn-sm">Eliminar</button>
            </td>
        </tr>
        `;

    });
}

async function cargarEdicion(id) {

    const response = await fetch(`./API/crud_desarrolladores.php?id=${id}`);
    const dev = await response.json();

    document.getElementById("nombre").value = dev.nombre;
    document.getElementById("pais").value = dev.pais;
    document.getElementById("anio").value = dev.anio_fundacion;

    document.getElementById("formDesarrollador").setAttribute("data-editando", id);

    const btn = document.getElementById("btnGuardar");

    btn.textContent = "Actualizar";
    btn.classList.remove("btn-azul");
    btn.classList.add("btn-success");
}

async function guardarDesarrollador(event) {

    event.preventDefault();

    const nombre = document.getElementById("nombre").value;
    const pais = document.getElementById("pais").value;
    const anio = document.getElementById("anio").value;

    const form = document.getElementById("formDesarrollador");
    const idEditando = form.getAttribute("data-editando");

    if (idEditando) {

        await fetch("./API/crud_desarrolladores.php", {

            method: "PUT",
            headers: { "Content-Type": "application/json" },

            body: JSON.stringify({
                id: idEditando,
                nombre: nombre,
                pais: pais,
                anio: anio
            })

        });

        form.removeAttribute("data-editando");

        const btn = document.getElementById("btnGuardar");

        btn.textContent = "+";
        btn.classList.remove("btn-success");
        btn.classList.add("btn-azul");

    } else {

        await fetch("./API/crud_desarrolladores.php", {

            method: "POST",
            headers: { "Content-Type": "application/json" },

            body: JSON.stringify({
                nombre: nombre,
                pais: pais,
                anio: anio
            })

        });

    }

    listarDesarrolladores();
    form.reset();

}

async function eliminarDesarrollador(id) {

    const confirmar = confirm("¿Seguro que quieres eliminar este desarrollador?");

    if (!confirmar) return;

    await fetch("./API/crud_desarrolladores.php", {

        method: "DELETE",
        headers: { "Content-Type": "application/json" },

        body: JSON.stringify({ id })

    });

    listarDesarrolladores();

}

document.addEventListener("DOMContentLoaded", () => {

    listarDesarrolladores();

    const buscador = document.getElementById("buscarInput");

    if (buscador) {
        buscador.addEventListener("keyup", listarDesarrolladores);
    }

});