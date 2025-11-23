// Datable de todas las tablas

$(document).ready(function () {
  $("#tblGeneral").DataTable({
    responsive: true,
    scrollY: 300,
    ordering: false,
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json",
    },
  });
});
