<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once("auten.php"); // Asegúrate de que este archivo contiene la inclusión de la clase BD

$bd = new BD;

// Abrimos la conexión a la base de datos
$bd->open();

$result = $bd->Execute("SELECT * FROM landin_x_libro ", 'assoc');
?>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Lista de registrados </h3>
                </div>
                <div class="box-body">

                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Número</th>
                                <th>Email</th>
                                <!-- <th>Condición Laboral</th> -->
                                <th>Fecha de Registro</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($result)) : ?>
                                <?php foreach ($result as $row) : ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                                        <td><?php echo htmlspecialchars($row['nombres']); ?></td>
                                        <td><?php echo htmlspecialchars($row['numero']); ?></td>
                                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                                        <td><?php echo htmlspecialchars($row['fecha_de_registro']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="5">No se encontraron registros.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>


                </div>
                <div class="box-footer">

                </div>
            </div><!-- /.box -->
        </div><!--/.col (right) -->
    </div>
</section><!-- /.content -->



<?php

$bd->close();
?>