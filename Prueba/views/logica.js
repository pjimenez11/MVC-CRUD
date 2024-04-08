$(document).ready(function () {
    $("#submit-student-btn").click(function (event) {
        event.preventDefault();

        var formData = {
            id: $("#cedula").val(),
            firstName: $("#first_name").val(),
            lastName: $("#last_name").val(),
            address: $("#address").val(),
            phone: $("#phone").val(),
        };

        $.ajax({
            url: "http://localhost/Quinto/MVC/Server.php/students",
            type: "POST",
            data: JSON.stringify(formData),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (response) {
                console.log("Student added successfully:", response);
                loadStudents();
                cleanFields();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("Error adding student:", errorThrown);
            },
        });
    });
})