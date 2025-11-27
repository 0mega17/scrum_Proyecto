// CUANDO SE ABRE LA MODAL → CARGAR FICHAS DEL INSTRUCTOR
let btnCrear = document.querySelector("#mostrarCalificacionesAprendices");
let selectFichas = document.querySelector("#selectFichaModal");
let selectTrabajo = document.querySelector("#selectTrabajoModal");
let tabla = document.querySelector("#tablaAprendices");

// ABRIR MODAL Y CARGAR FICHAS
btnCrear.addEventListener("click", async () => {
    const IDinstructor = btnCrear.dataset.id;

    const formDataID = new FormData();
    formDataID.append("IDinstructor", IDinstructor);

    const request = await fetch("../CONTROLLER/listarFichas.php", {
        method: "POST",
        body: formDataID
    });

    const fichas = await request.json();
    console.log(fichas);

    let opciones = [];

    if (fichas.length == 0) {
        opciones.push("<option disabled selected>Sin fichas</option>");
    } else {
        opciones.push("<option selected disabled>Seleccione...</option>");
        fichas.forEach(f => {
            opciones.push(`<option value="${f.id}">${f.codigo} - ${f.nombre}</option>`);
        });
    }

    selectFichas.innerHTML = opciones.join("");

    let modal = new bootstrap.Modal(document.getElementById("modalCalificaciones"));
    modal.show();
});


// ---------------------------------------
// 1. CUANDO SELECCIONO UNA FICHA → CARGAR TRABAJOS
// ---------------------------------------
selectFichas.addEventListener("change", async () => {
    let idFicha = selectFichas.value;

    const formData = new FormData();
    formData.append("idFicha", idFicha);

    const request = await fetch("../CONTROLLER/listarTrabajos.php", {
        method: "POST",
        body: formData
    });

    const raw = await request.text();
    console.log("RAW TRABAJOS ⇒", raw);

    let trabajos = [];
    try {
        trabajos = JSON.parse(raw);
    } catch (e) {
        console.error("ERROR PARSEANDO JSON:", e);
        return;
    }

    let opciones = [];

    if (trabajos.length == 0) {
        opciones.push("<option disabled selected>Sin trabajos</option>");
    } else {
        opciones.push("<option selected disabled>Seleccione...</option>");
        trabajos.forEach(t => {
            opciones.push(`<option value="${t.id}">${t.nombre_trabajo}</option>`);
        });
    }

    selectTrabajo.innerHTML = opciones.join("");
    tabla.innerHTML = ""; // limpiar tabla
});


// ---------------------------------------
// 2. CUANDO SELECCIONO UN TRABAJO → CARGAR APRENDICES + CALIFICACIONES
// ---------------------------------------
selectTrabajo.addEventListener("change", async () => {
  let idFicha = selectFichas.value;
  let idTrabajo = selectTrabajo.value;

  const formData = new FormData();
  formData.append("idFicha", idFicha);
  formData.append("idTrabajo", idTrabajo);

  const request = await fetch("../CONTROLLER/listaraprendices.php", {
    method: "POST",
    body: formData,
  });

  const raw = await request.text();
  console.log("RAW APRENDICES ⇒", raw);

  if (!raw.trim().startsWith("[")) {
    console.error("PHP NO devolvió JSON válido");
    return;
  }

  let aprendices = JSON.parse(raw);

  let filas = [];

  // SI NO HAY CALIFICACIONES → MOSTRAR AVISO
  if (aprendices.length === 0) {
    tabla.innerHTML = `
      <tr>
        <td colspan="4" class="text-center p-3">
          <div class="alert alert-warning mb-0" role="alert">
            No hay calificaciones disponibles para este trabajo.
          </div>
        </td>
      </tr>`;
    return;
  }

  aprendices.forEach((a) => {
    filas.push(`
      <tr>
        <td>${a.nombre_aprendiz}</td>
        <td>${a.comentario ?? "Sin comentario"}</td>
        <td>${a.calificacion ?? "Sin calificar"}</td>
        <td>${a.fecha_calificacion ?? "—"}</td>
      </tr>
    `);
  });

  tabla.innerHTML = filas.join("");
});

