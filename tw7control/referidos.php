<?php

// Verifica si se está insertando
if ($_GET['task'] === 'insert') {

    error_reporting(E_ALL ^ E_NOTICE);
    require_once("auten.php"); // Asegúrate de que este archivo contiene la inclusión de la clase BD
    $bd = new BD;

    // Abrimos la conexión a la base de datos
    $bd->open();
    ?>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Insertar Datos</h3>

                    </div>
                    <div class="box-body">
                        <form id="registro" class="form-horizontal" onsubmit="return aceptar(event)">
                            <?php
                            // create_input("hidden", "id_cliente", $data_producto["id_cliente"], "", $table, "");
                            // // create_input("hidden", "urlfailed", basename($_SERVER['REQUEST_URI']), "", $table, "");
                            // // create_input("hidden", "urlgo", $link, "", $table, "");
                            // // create_input("hidden", "nompage", $_GET["page"], "", $table, "");
                            // // create_input("hidden", "nommodule", $_GET["module"], "", $table, "");
                            // // create_input("hidden", "nomparenttab", $_GET["parenttab"], "", $table, "");
                            ?>
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="especialidad" class="col-sm-2 control-label">Especialidad</label>
                                    <div class="col-sm-6">
                                        <?php crearselect("especialidad", "select * from especialidades", 'class="form-control"', $data_producto["especialidad"], ""); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="numero" class="col-sm-2 control-label">Numero: </label>
                                    <div class="col-sm-6">
                                        <?php create_input("text", "numero", $data_producto["numero"], "form-control", $table, "", $agregado); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nombres" class="col-sm-2 control-label">Nombres y Apellidos: </label>
                                    <div class="col-sm-6">
                                        <?php create_input("text", "nombres", $data_producto["nombres"], "form-control", $table, "", $agregado); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email" class="col-sm-2 control-label">Correo: </label>
                                    <div class="col-sm-6">
                                        <?php create_input("email", "email", $data_producto["email"], "form-control", $table, "", $agregado); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="ciudad" class="col-sm-2 control-label">Ciudad: </label>
                                    <div class="col-sm-6">
                                        <?php create_input("text", "ciudad", $data_producto["ciudad"], "form-control", $table, "", $agregado); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="condicion" class="col-sm-2 control-label">Condicion</label>
                                    <select name="condicion" id="condicion">
                                        <option value="" disabled selected>Seleccionar</option>
                                        <option value="nombrado">Nombrado</option>
                                        <option value="contratado">Contratado</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <button type="button" class="btn bg-green btn-flat" onclick="addToTable()">Añadir</button>
                                </div>

                                <table class="table table-bordered" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Especialidad</th>
                                            <th>Numero</th>
                                            <th>Nombres</th>
                                            <th>Email</th>
                                            <th>Ciudad</th>
                                            <th>Condición</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>



                                <?php
                                $id_cliente =  $_GET['id_cliente'];
                                ?>

                                <input type="hidden" name="task" value="registrar">
                                <input type="hidden" name="cliente" id="cliente" value="<?php echo $id_cliente ?>">


                            </div>

                            <div class="box-footer">
                                <div class="form-group">
                                    <div class="col-sm-10 pull-right">
                                        <input type="submit" class="btn bg-blue btn-flat" id="btnguardar" value="Guardar">
                                        <button type="button" class="btn bg-red btn-flat" onclick="redirectToURL()">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                            <script>
                                function aceptar() {
                                    var nam1 = document.getElementById("numero").value;

                                    if (nam1 != '') {
                                        alert("Registrando ... Click en Aceptar & espere unos segundos. ");
                                        document.getElementById("btnguardar").disabled = true;
                                    } else {
                                        alert("Recomendación: Ingrese numero)");
                                        return false; //el formulario no se envia		
                                    }

                                }

                                function redirectToURL() {
                                    window.location.href = "https://www.educaauge.com/tw7control/index.php?page=referidos&module=Referidos&parenttab=Campañas"; // Cambia esta URL a la que desees
                                }

                                let registros = [];

                                function addToTable() {
                                    const especialidad = document.querySelector('[name="especialidad"]').value;
                                    const numero = document.querySelector('[name="numero"]').value;
                                    const nombres = document.querySelector('[name="nombres"]').value;
                                    const email = document.querySelector('[name="email"]').value;
                                    const ciudad = document.querySelector('[name="ciudad"]').value;
                                    const condicion = document.querySelector('[name="condicion"]').value;

                                    const nuevoRegistro = {
                                        especialidad,
                                        numero,
                                        nombres,
                                        email,
                                        ciudad,
                                        condicion
                                    };
                                    registros.push(nuevoRegistro);

                                    const tableBody = document.getElementById('dataTable').getElementsByTagName('tbody')[0];
                                    const newRow = tableBody.insertRow();
                                    newRow.innerHTML = `
                                            <td>${especialidad}</td>
                                            <td>${numero}</td>
                                            <td>${nombres}</td>
                                            <td>${email}</td>
                                            <td>${ciudad}</td>
                                            <td>${condicion}</td>
                                            <td><button type="button" class="btn btn-danger" onclick="removeRow(this)">Eliminar</button></td>
                                            `;

                                    // Limpiar los campos del formulario
                                    document.querySelector('[name="especialidad"]').value = '';
                                    document.querySelector('[name="numero"]').value = '';
                                    document.querySelector('[name="nombres"]').value = '';
                                    document.querySelector('[name="email"]').value = '';
                                    document.querySelector('[name="ciudad"]').value = '';
                                    document.querySelector('[name="condicion"]').value = '';
                                }

                                function removeRow(button) {
                                    const row = button.parentElement.parentElement;
                                    const index = row.rowIndex - 1; // -1 because rowIndex is 1-based and we have a header row
                                    registros.splice(index, 1);
                                    row.remove();
                                }

                                function aceptar(event) {
                                    event.preventDefault();

                                    if (registros.length === 0) {
                                        alert("Debe añadir al menos un registro.");
                                        return false;
                                    }

                                    const cliente = document.getElementById('cliente').value;

                                    fetch('registrar_referido.php', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json'
                                            },
                                            body: JSON.stringify({
                                                cliente,
                                                registros
                                            })
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            alert('Datos guardados correctamente.');
                                            window.location.href = "https://www.educaauge.com/tw7control/index.php?page=referidos&module=Referidos&parenttab=Campañas";
                                        })
                                        .catch(error => {
                                            console.error('Error:', error);
                                            alert('Ocurrió un error al guardar los datos.');
                                        });

                                    return false;
                                }
                            </script>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php

    $bd->close();
    ?>


<?php



} else {

    error_reporting(E_ALL ^ E_NOTICE);
    require_once("auten.php"); // Asegúrate de que este archivo contiene la inclusión de la clase BD

    $bd = new BD;

    // Abrimos la conexión a la base de datos
    $bd->open();


    $result = $bd->Execute("SELECT dc.*, u.nomusuario FROM docentes_campaña dc JOIN usuario u ON dc.id_usuario = u.idusuario; ", 'assoc');
    
?>

    <section class="content">
        <div class="row">
            <!-- <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">Campaña Referidos 2024</h3>
                    </div>
                    <div class="box-body">
                    </div>
                </div>
            </div> -->

            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Lista de Docentes Asignados </h3>
                        <div class="grid-x grid-margin-x" style="display: flex;  align-items: center; justify-content: center;">
                            <!-- Buscador -->
                            <div class="cell small-12 medium-6" style="width:50%;">
                                <input type="text" id="searchInput" class="form-control" placeholder="Buscar por dni de cliente...">
                            </div>

                        </div>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Numero</th>
                                    <th>Especialidad</th>
                                    <th>DNI</th>
                                    <th>Cliente</th>
                                    <th>Email</th>
                                    <th>Celular</th>
                                    <th>Vendedora</th>
                                    <th>Condición</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($result)) : ?>
                                    <?php $id = 1; ?>
                                    <?php foreach ($result as $row) : ?>
                                        <tr>
                                            <td><?php echo $id++; ?></td>
                                            <td><?php echo htmlspecialchars($row['especialidad']); ?></td>
                                            <td><?php echo htmlspecialchars($row['dni']); ?></td>
                                            <td><?php echo htmlspecialchars($row['cliente']); ?></td>
                                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                                            <td><?php echo htmlspecialchars($row['celular']); ?></td>
                                            <td><?php echo htmlspecialchars($row['nomusuario']); ?></td>
                                            <td><?php echo htmlspecialchars($row['condicion']); ?></td>
                                            <td>
                                                <button type="button" class="btn btn-danger" onclick="showUpdateModal(<?php echo $row['id']; ?>)">Actualizar</button>
                                            </td>
                                            <td>
                                                <form action="index.php?page=referidos&module=Referidos&parenttab=Campañas" method="GET">
                                                    <input type="hidden" name="page" value="referidos">
                                                    <input type="hidden" name="module" value="Referidos">
                                                    <input type="hidden" name="parenttab" value="Campañas">
                                                    <input type="hidden" name="task" value="insert">
                                                    <input type="hidden" name="id_cliente" value="<?php echo $row['id']; ?>">
                                                    <button type="submit" class="btn btn-danger">Referido</button>
                                                </form>
                                                <!-- <a href="index.php?page=referidos&module=Referidos&parenttab=Campañas" style="color:red;" class="acciones-btn referido-btn"><i class="fa fa-file" style="padding-right:8px;"></i> Agregar</a> -->
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="8">No se encontraron registros.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                </div><!-- /.box -->
            </div><!--/.col (right) -->
        </div>
    </section>


    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Actualizar Referido</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="updateForm">
                        <input type="hidden" name="page" value="referidos">
                        <input type="hidden" name="module" value="Referidos">
                        <input type="hidden" name="parenttab" value="Campañas">
                        <input type="hidden" name="task" value="update">
                        <input type="hidden" name="id" id="update-id">

                        <div class="form-group">
                            <label for="condicion" class="col-form-label">Condición:</label>
                            <select class="form-control" name="condicion" id="update-condicion">
                                <option value="" disabled selected>Seleccionar</option>
                                <option value="referido">Referido</option>
                                <option value="contesto">Contesto</option>
                                <option value="no_contesto">No contesto</option>
                                <option value="pendiente de llamar">Pendiente de llamar</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="submitUpdate()">Actualizar</button>
                </div>
            </div>
        </div>
    </div>


<?php

}
?>

<?php

$bd->close();
?>

<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        var input = document.getElementById('searchInput');
        var filter = input.value.toLowerCase();
        var table = document.querySelector('.box-body table tbody');
        var rows = table.getElementsByTagName('tr');

        for (var i = 0; i < rows.length; i++) {
            var dni = rows[i].getElementsByTagName('td')[2];
            var cliente = rows[i].getElementsByTagName('td')[3];
            var especialidad = rows[i].getElementsByTagName('td')[1];

            if (dni || cliente || especialidad) {
                var dniText = dni.textContent || dni.innerText;
                var clienteText = cliente.textContent || cliente.innerText;
                var especialidadText = especialidad.textContent || especialidad.innerText;

                if (dniText.toLowerCase().indexOf(filter) > -1 ||
                    clienteText.toLowerCase().indexOf(filter) > -1 ||
                    especialidadText.toLowerCase().indexOf(filter) > -1) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        }
    });

    function showUpdateModal(id) {
        // Establecer el valor del ID en el formulario del modal
        document.getElementById('update-id').value = id;

        // Mostrar el modal
        $('#updateModal').modal('show');

        

    }

    function submitUpdate() {
        // Obtener los datos del formulario
        var formData = $('#updateForm').serialize();

    // Mostrar los datos del formulario en la consola
    console.log('Datos enviados:', formData);

        // Enviar el formulario usando AJAX
        $.ajax({
            type: 'POST',
            url: 'actualizar_referido.php', // Cambia esta URL si es necesario
            data: formData,
            success: function(response) {
                alert('Datos actualizados correctamente.');
                $('#updateModal').modal('hide');
                // Recargar la página o actualizar la tabla si es necesario
                window.location.href = "https://www.educaauge.com/tw7control/index.php?page=referidos&module=Referidos&parenttab=Campañas";
            },
            error: function(error) {
                console.error('Error:', error);
                alert('Ocurrió un error al actualizar los datos.');
            }
        });
    }
</script>