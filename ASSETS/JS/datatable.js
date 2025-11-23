// Datable de todas las tablas

$(document).ready(function () {
  $("#tblGeneral").DataTable({
    autoWidth: false,
    ordering: false,
    searching: true,
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json",
    },
  });
});
