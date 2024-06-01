<div class="titu"><div class="contiene_ ">
<?php
    if( $detalles['en_vivo']==1){ /* valido si esta activo el boton */ ?> 
        <!-- 
        <div class="medium-12 columns ">
          <div class="medium-4 columns "><p>Fecha de inicio<?php echo $detalles['horario_inicio']; ?></p></div>
          <div class="medium-4 columns "><p class="color1">HORARIO EN VIVO</p></div>
          <div class="medium-4 columns "><p>Fecha final<?php echo $detalles['horario_final']; ?></p></div>
        </div>
        -->
        
        <div class="table-scroll ">
          <table class="unstriped "> 
            <thead>
              <tr class="cabezera_tabla ">
                <th colspan="3">Fecha de inicio: <?php echo $detalles['horario_inicio']; ?></th>
                <th colspan="2" class="color2 ">HORARIO EN VIVO</th>
                <th colspan="3">Fecha fin: <?php echo $detalles['horario_final']; ?></th>
              </tr>
              <tr>
                <th >HORA</th>
              <?php if(!empty($detalles['horario_lunes']) ){ ?> 
                  <th>LUNES</th>
                <?php } ?>

              <?php if(!empty($detalles['horario_martes'])) { ?> 
                  <th >MARTES</th>
                <?php } ?>

              <?php if(!empty($detalles['horario_miercoles']) ){ ?> 
                  <th >MIERCOLES</th>
                <?php } ?>

              <?php if(!empty($detalles['horario_jueves']) ){ ?> 
                  <th >JUEVES</th>
                <?php } ?>

              <?php if(!empty($detalles['horario_viernes']) ){ ?> 
                  <th >VIERNES</th>
                <?php } ?>

              <?php if(!empty($detalles['horario_sabado']) ){ ?> 
                  <th >SABADO</th>
                <?php } ?>

              <?php if(!empty($detalles['horario_domingo']) ){ ?> 
                  <th >DOMINGO</th>
                <?php } ?>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><?php echo $detalles['horario_hora']; ?> </td>
                
            <?php if(!empty($detalles['horario_lunes']) ){ ?> 
                <td><?php echo $detalles['horario_lunes']; ?> </td>
              <?php } ?>

            <?php if(!empty($detalles['horario_martes']) ){ ?> 
                <td><?php echo $detalles['horario_martes']; ?> </td>
              <?php } ?>

            <?php if(!empty($detalles['horario_miercoles']) ){ ?> 
                <td><?php echo $detalles['horario_miercoles']; ?> </td>
              <?php } ?>

            <?php if(!empty($detalles['horario_jueves']) ){ ?> 
                <td><?php echo $detalles['horario_jueves']; ?> </td>
              <?php } ?>
              
            <?php if(!empty($detalles['horario_viernes']) ){ ?> 
                <td><?php echo $detalles['horario_viernes']; ?> </td>
              <?php } ?>

            <?php if( !empty($detalles['horario_sabado']) ){ ?> 
                <td><?php echo $detalles['horario_sabado']; ?> </td>
              <?php } ?>

            <?php if( !empty($detalles['horario_domingo']) ){ ?> 
                <td><?php echo $detalles['horario_domingo']; ?> </td>
              <?php } ?>
                
              </tr>
            </tbody>
          </table>
        </div>
        
<?php } ?> 
    </div></div>