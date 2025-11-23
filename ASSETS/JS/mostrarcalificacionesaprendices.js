// CUANDO SE ABRE LA MODAL → CARGAR FICHAS DEL INSTRUCTOR
let btnCrear = document.querySelector("#mostrarCalificacionesAprendices");
let selectFichas = document.querySelector("#selectFichaModal");
let tabla = document.querySelector("#tablaAprendices");

// ABRIR MODAL Y CARGAR FICHAS
btnCrear.addEventListener("click", async () => {
  const IDinstructor = btnCrear.dataset.id;

  const formDataID = new FormData();
  formDataID.append("IDinstructor", IDinstructor);

  // OJO: ruta adaptada a tu estructura
  const request = await fetch("../CONTROLLER/listarFichas.php", {
    method: "POST",
    body: formDataID,
  });

  const fichas = await request.json();
  console.log(fichas);

  let opciones = [];

  if (fichas.length == 0) {
    opciones.push("<option disabled selected>Sin fichas</option>");
  } else {
    opciones.push("<option selected disabled>Seleccione...</option>");
    fichas.forEach((f) => {
      opciones.push(
        `<option value="${f.id}">${f.codigo} - ${f.nombre}</option>`
      );
    });
  }

  selectFichas.innerHTML = opciones.join("");

  // abrir modal
  let modal = new bootstrap.Modal(
    document.getElementById("modalCalificaciones")
  );
  modal.show();
});

// ------------------------------
// 2. CARGAR APRENDICES CUANDO SE SELECCIONA UNA FICHA
// ------------------------------
selectFichas.addEventListener("change", async () => {
  let idFicha = selectFichas.value;

  const formData = new FormData();
  formData.append("idFicha", idFicha);

  const request = await fetch("../CONTROLLER/listaraprendices.php", {
    method: "POST",
    body: formData,
  });

  const aprendices = await request.json();
  console.log("Aprendices:", aprendices);

  let filas = [];

  aprendices.forEach((a) => {
    let color =
      a.estado_entrega === "Calificado"
        ? "text-success fw-bold"
        : "";

    filas.push(`
            <tr>
                <td>${a.nombre_aprendiz}</td>
                <td class="${color}">${a.calificacion ?? "Sin calificar"}</td>
            </tr>
        `);
  });

  tabla.innerHTML = filas.join("");
});
