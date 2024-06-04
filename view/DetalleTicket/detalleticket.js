function init(){

}

function actualizarContenido() {
    const url = window.location.href;
    const params = new URLSearchParams(new URL(url).search);
    const tick_id = params.get("ID");
    const decoded_id = decodeURIComponent(tick_id);
    const id = decoded_id.replace(/\s/g, '+');

    // Hacer la solicitud Ajax para obtener el contenido actualizado
    $.post("../../controller/ticket.php?op=listardetalle", { tick_id: id }, function (data) {
        $('#lbldetalle').html(data);
    });

    // También puedes hacer otras solicitudes Ajax para actualizar más contenido si es necesario
}

$(document).ready(function(){

    const url=window.location.href;
    const params = new URLSearchParams(new URL(url).search);
    const tick_id = params.get("ID");
    const decoded_id  = decodeURIComponent(tick_id);
    const id = decoded_id.replace(/\s/g, '+');

    /* TODO: Mostramos informacion de detalle de ticket */
    $.post("../../controller/ticket.php?op=listardetalle", { tick_id : id }, function (data) {
        $('#lbldetalle').html(data);
    });

    /* TODO: Mostramos informacion del ticket en inputs */
    $.post("../../controller/ticket.php?op=mostrar", { tick_id : id }, function (data) {

        console.log('la data es: '+data);
        data = JSON.parse(data);


        $('#lblestado').html(data.tick_estado);
        $('#lblnomusuario').html(data.usu_nom +' '+data.usu_ape);
        $('#lblfechcrea').html(data.fech_crea);
        $('#lblnomidticket').html("Detalle Ticket - "+data.tick_id);
        $('#cat_nom').val(data.cat_nom);
        $('#tick_titulo').val(data.tick_titulo);
        $('#tickd_descripusu').summernote ('code',data.tick_descrip);
        $('#prio_nom').val(data.prio_nom);
        $('#tick_telf').val(data.tick_telf);

        if (data.tick_estado_texto == "Cerrado"){
            /* TODO: Ocultamos panel de detalle */
            $('#pnldetalle').hide();
        }
    });

    /* TODO: Inicializamos summernotejs */
    $('#tickd_descrip').summernote({
        height: 150,
        lang: "es-ES",
        popover: {
            image: [],
            link: [],
            air:[]
        },
        callbacks: {
            onImageUpload: function(image) {
                myimagetreat(image[0]);
            },
            onPaste: function (e) {
            }
        },
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
        ]
    });

    /* TODO: Inicializamos summernotejs */
    $('#tickd_descripusu').summernote({
        height: 150,
        lang: "es-ES",
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
        ]
    });

    $('#tickd_descripusu').summernote('disable');

    /* TODO: Listamos documentos en caso hubieran */
    tabla=$('#documentos_data').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        "searching": true,
        lengthChange: false,
        colReorder: true,
        buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
                ],
        "ajax":{
            url: '../../controller/documento.php?op=listar',
            type : "post",
            data : {tick_id:tick_id},
            dataType : "json",
            error: function(e){
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "responsive": true,
        "bInfo":true,
        "iDisplayLength": 10,
        "autoWidth": false,
        "language": {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    }).DataTable();


});

$(document).on("click","#btnenviar", function(){
    const url=window.location.href;
    const params = new URLSearchParams(new URL(url).search);
    const tick_id = params.get("ID");
    const decoded_id  = decodeURIComponent(tick_id);
    const id = decoded_id.replace(/\s/g, '+');
    var usu_id = $('#user_idx').val();
    var tickd_descrip = $('#tickd_descrip').val();

    /* TODO:Validamos si el summernote esta vacio antes de guardar */
    if ($('#tickd_descrip').summernote('isEmpty')){
        swal("Advertencia!", "Falta Descripción", "warning");
    }else{
        var formData = new FormData();
        formData.append('tick_id',id);
        formData.append('usu_id',usu_id);
        formData.append('tickd_descrip',tickd_descrip);
        var totalfiles = $('#fileElem').val().length;
        /* TODO:Agregamos los documentos adjuntos en caso hubiera */
        for (var i = 0; i < totalfiles; i++) {
            formData.append("files[]", $('#fileElem')[0].files[i]);
        }

        /* TODO:Insertar detalle */
        $.ajax({
            url: "../../controller/ticket.php?op=insertdetalle",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data){
                actualizarContenido();
                /* TODO: Limpiar inputfile */
                $('#fileElem').val('');
                $('#tickd_descrip').summernote('reset');
                swal("Correcto!", "Registrado Correctamente", "success");
            }
        });
    }
});

$(document).on("click", "#btncerrarticket", function () {
    /* TODO: Preguntamos antes de cerrar el ticket */
    swal({
        title: "HelpDesk",
        text: "Esta seguro de Cerrar el Ticket?",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-warning",
        confirmButtonText: "Si",
        cancelButtonText: "No",
        closeOnConfirm: false
    }, function (isConfirm) {
        if (isConfirm) {
            const url = window.location.href;
            const params = new URLSearchParams(new URL(url).search);
            const tick_id = params.get("ID");
            const decoded_id = decodeURIComponent(tick_id);
            const id = decoded_id.replace(/\s/g, '+');

            var usu_id = $('#user_idx').val();
            /* TODO: Actualizamos el ticket  */
            $.post("../../controller/ticket.php?op=update", { tick_id: id, usu_id: usu_id }, function (data) {

            });

            /* TODO:Alerta de ticket cerrado via email */
            $.post("../../controller/email.php?op=ticket_cerrado", { tick_id: id }, function (data) {
            });

            /* TODO: Alerta de confirmación */
            swal({
                title: "HelpDesk!",
                text: "Ticket Cerrado correctamente.",
                type: "success",
                confirmButtonClass: "btn-success"
            });
            // Recargar la página
            location.reload();
        }
    });
});
