$(document).ready(function () {
    cargarDatosEnTabla();

    $("#btnGuardar").click(function (event) {
        event.preventDefault();
        var { cedula, nombre, apellido, direccion, telefono } = obtenerInputs();

        $.ajax({
            url: '../../controllers/estudianteController.php',
            type: 'POST',
            data: { cedula, nombre, apellido, direccion, telefono },
            success: function (response) {
                let { mensaje } = JSON.parse(response);
                mostrarNotificaciones("Guardado!", mensaje, "success");
                emptyInputs();
                cargarDatosEnTabla();
            },
            error: function (response) {
                let { error } = JSON.parse(response.responseText);
                mostrarNotificaciones("Error al añadir!", error, "error");
            }
        });
    })

    $("#btnEliminar").click(function (event) {
        event.preventDefault();
        var cedula = $("#cedula").val();
        $.ajax({
            url: '../../controllers/estudianteController.php?cedula=' + cedula,
            type: 'DELETE',
            success: function (response) {
                let { mensaje } = JSON.parse(response);
                mostrarNotificaciones("Eliminado!", mensaje, "success");
                emptyInputs();
                cargarDatosEnTabla();
            },
            error: function (response) {
                let { error } = JSON.parse(response.responseText);
                mostrarNotificaciones("Error al eliminar!", error, "error");
            }
        });
    })

    $("#btnEditar").click(function (event) {
        event.preventDefault();
        var { cedula, nombre, apellido, direccion, telefono } = obtenerInputs();
        $.ajax({
            url: `../../controllers/estudianteController.php?cedula=${cedula}&nombre=${nombre}&apellido=${apellido}&direccion=${direccion}&telefono=${telefono}`,
            type: 'PUT',
            success: function (response) {
                let { mensaje } = JSON.parse(response);
                mostrarNotificaciones("Editado!", mensaje, "success");
                emptyInputs();
                cargarDatosEnTabla();
            },
            error: function (response) {
                let { error } = JSON.parse(response.responseText);
                mostrarNotificaciones("Error al editar!", error, "error");
            }
        });
    })

});

function cargarDatosEnTabla() {
    $.ajax({
        url: '../../controllers/estudianteController.php',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            mostrarDatosEnTabla(response);
        },
        error: function (response) {
            let { error } = JSON.parse(response.responseText);
            mostrarNotificaciones("Error al cargar datos!", error, "error");
        }
    });
}

function mostrarDatosEnTabla(data) {
    var tabla = $("#tablaDatos tbody");
    tabla.empty();
    $.each(data, function (index, item) {
        tabla.append("<tr data-cedula='" + item.cedula + "' class='bg-gray-100 hover:bg-gray-200'><td class='px-4 py-2'>" + item.cedula + "</td><td class='px-4 py-2'>" + item.nombre + "</td><td class='px-4 py-2'>" + item.apellido + "</td><td class='px-4 py-2'>" + item.direccion + "</td><td class='px-4 py-2'>" + item.telefono + "</td></tr>");
    });
}

function obtenerInputs() {
    var cedula = $("#cedula").val();
    var nombre = $("#nombre").val();
    var apellido = $("#apellido").val();
    var direccion = $("#direccion").val();
    var telefono = $("#telefono").val();

    return { cedula, nombre, apellido, direccion, telefono };
}

function emptyInputs() {
    $("#cedula").val("");
    $("#nombre").val("");
    $("#apellido").val("");
    $("#direccion").val("");
    $("#telefono").val("");
}

function mostrarNotificaciones(title, text, icon) {
    Swal.fire({
        title: title,
        text: text,
        icon: icon
    });
}
