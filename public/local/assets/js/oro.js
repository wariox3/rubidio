function abrirVentana(url, Nombre, Alto, Ancho) {
    windowObjectReference2 = window.open(url, Nombre, "toolbar=0, width=" + Ancho + ", height=" + Alto + ",location=0,status=1,menubar=0,scrollbars=1,resizable=0");
    windowObjectReference2.focus();
}
jQuery(document).ready(function($){

    $(".table-oro").DataTable({
        "pageLength": 50,
         order: [[2,"desc"]],
        "pagingType": "full_numbers",
        "bLengthChange": false,
        "language": {
            "lengthMenu": "Mostrando _MENU_ registros por página",
            "zeroRecords": "No hay Registros :(",
            "info": "Total de registros _MAX_ ",
            "infoEmpty": "Información no disponible o no existen registros con esas características",
            "infoFiltered": "(Filtrado de _MAX_ total de registros)",
            "search": "Buscar",
            "paginate": {
                "first":    "Primero",
                "previous": 'Anterior',
                "next":     'Siguiente',
                "last":     'Último'
            },
            "aria": {
                "paginate": {
                    "first":    'First',
                    "previous": 'Previous',
                    "next":     'Next',
                    "last":     'Last'
                }
            }
        }
    });
});

