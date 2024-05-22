function init(){
    $("#usuario_form").on("submit",function(e){
        registrousuario(e);	
    });
}

/* TODO: Guardar datos de los input */
function registrousuario(e) {
    e.preventDefault();

    // Validar campos vacíos
    var nombre = $("#usu_nom").val();
    var apellido = $("#usu_ape").val();
    var correo = $("#usu_correo").val();
    var contraseña = $("#usu_pass").val();
    var telefono = $("#usu_telf").val();

    if (nombre === "" || apellido === "" || correo === "" || contraseña === "" || telefono === "") {
        // Mostrar alerta de campos vacíos
        swal({
            title: "Error",
            text: "Por favor, complete todos los campos.",
            type: "error",
            confirmButtonClass: "btn-danger"
        });
    } else {
        // Si no hay campos vacíos, continuar con el envío del formulario
        var formData = new FormData($("#usuario_form")[0]);
        $.ajax({
            url: "../../controller/usuario.php?op=registrousuario",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (datos) {
                $('#usuario_form')[0].reset();
                /* TODO: Mensaje de Confirmacion */
                swal({
                    title: "HelpDesk!",
                    text: "Completado.",
                    type: "success",
                    confirmButtonClass: "btn-success"
                });
            }
        });
    }
}

init();