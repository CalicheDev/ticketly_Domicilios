<!-- Codigo ingresado por Carlos Bejarano-->
<?php
    $id_soporte =mysqli_query($con, "select * from ticket");
    $projects =mysqli_query($con, "select * from project");
    $priorities =mysqli_query($con, "select * from priority");
    $statuses =mysqli_query($con, "select * from status");
    $kinds =mysqli_query($con, "select * from kind");
    $asesores = mysqli_query($con, "select * from asesor");
    $categories =mysqli_query($con, "select * from category");
    $causas = mysqli_query($con, "select * from causas_soporte");
    $client = mysqli_query($con, "select * from clientes");
    $atenciones=mysqli_query($con, "select * from atencion");

?>
    <!-- Main content -->
        <section class="content">
            <div class="row"> 
                <div class="col-md-12">                        

                        <!-- Modal Detalle-->
    <div class="modal fade bs-example-modal-lg-udp" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel"> Realizar atención al Ticket</h4>
                </div>
                <div class="nav-tabs-custom"><!-- Custom Tabs -->
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_1" data-toggle="tab">Detalle</a></li>
                        <li><a href="#tab_2" data-toggle="tab">Atenciones</a></li>
                    </ul>

                <div class="modal-body">
                    <!--<form class="form-horizontal form-label-left input_mask" method="post" id="upd" name="upd" enctype="multipart/form-data"> -->
                    <div class="tab-content">
                     <div class="tab-pane active" id="tab_1">
                        <form class="form-horizontal" method="post" action="action/updatencion_3.php" enctype="multipart/form-data">
                        <div id="result2"></div>
                        <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>

                        <input type="hidden" name="mod_id" id="mod_id">

                        <div class="form-row">
                            <div class="form-group col-md-4">                              
                              <label>Asunto <span class="required">*</span></label>  
                              <input class="form-control" readonly="" type="text" name="title" value="<?php echo $reg['title']?>">
                            </div>
                            <div class="form-group col-md-4">
                              <label >Estado <span class="required">*</span></label>                                
                                    <select  class="form-control" name="status_id" required id="mod_status_id">
                                        <option selected="" value="">-- Selecciona --</option>
                                      <?php foreach($statuses as $p):?>
                                        <option value="<?php echo $p['id']; ?>"><?php echo $p['status_name']; ?></option>
                                      <?php endforeach; ?>
                                    </select>                                
                            </div>
                            <div class="form-group col-md-4">
                              <label for="archivo">Ajunto <span class="required"></span></label>
                              <input type="file" class="form-control" name="archivo" id="archivo" multiple="">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Asesor <span class="required">*</span></label>                                
                                    <select class="form-control" name="asigned_id" required id="mod_asigned_id">
                                        <option selected="" value="">-- Selecciona --</option>
                                      <?php foreach($asesores as $p):?>
                                        <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                                      <?php endforeach; ?>
                                    </select>                                
                            </div>
                            <div class="form-group col-md-8">
                                <label>Causa del soporte <span class="required">*</span></label>                                
                                    <select class="form-control" name="id_causa_sop" >
                                        <option selected="" value="">-- Selecciona --</option>
                                          <?php foreach($causas as $p):?>
                                            <option value="<?php echo $p['id_causa_sop']; ?>"><?php echo $p['causas_soporte']; ?></option>
                                          <?php endforeach; ?>
                                    </select>                                
                            </div>
                            <div class="form-group col-md-12">
                                <label>Solución: <span class="required">*</span></label>                            
                                  <textarea name="detalle_atencion" class="form-control col-md-7 col-xs-12"  id="mod_detalle_atencion" placeholder="Detalle de la atención:"></textarea>                            
                            </div>                            
                      </div>                                        
                        <div class="form-group">
                            <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                              <button id="upd_data" type="submit" class="btn btn-success">Guardar</button>
                              <button type="reset" class="btn btn-danger" > Borrar </button>
                              <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </form>
                     </div> <!--End tab_1 -->
                     <div class="tab-pane" id="tab_2"><!-- /.tab-pane -->
                        <div class="row">
                            <div class="table-responsive">
                                <?php
                                //$mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                                //mysqli_set_charset($mysqli, "utf8");
                                mysqli_set_charset($con, "utf8");
                                  //$id = MysqlQuery::RequestGet('id');
                                  //$sql = Mysql::consulta("SELECT * FROM atencion WHERE id_ticket= '$id'");
                                  //$reg=mysqli_fetch_array($sql, MYSQLI_ASSOC);                                

                                $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
                                $regpagina = 15;
                                $inicio = ($pagina > 1) ? (($pagina * $regpagina) - $regpagina) : 0;
                                
                                
                                if(isset($_GET['atencion'])){
                                    if($_GET['atencion']=="all"){
                                        $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM atencion LIMIT $inicio, $regpagina";
                                    }elseif($_GET['atencion']=="pending"){
                                        $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM atencion WHERE id_ticket= '$reg2' LIMIT $inicio, $regpagina";
                                    }elseif($_GET['atencion']=="process"){
                                        $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM atencion WHERE status_id='2' LIMIT $inicio, $regpagina";
                                    }elseif($_GET['atencion']=="resolved"){
                                        $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM atencion WHERE status_id='5' LIMIT $inicio, $regpagina";
                                    }else{
                                        $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM atencion LIMIT $inicio, $regpagina";
                                    }
                                }else{
                                    $consulta="SELECT * FROM atencion WHERE id_ticket= '$id' order by fecha_atencion desc";
                                }


                                $selticket=mysqli_query($con,$consulta);

                                $totalregistros = mysqli_query($con,"SELECT FOUND_ROWS()");
                                $totalregistros = mysqli_fetch_array($totalregistros, MYSQLI_ASSOC);
                        
                                $numeropaginas = ceil($totalregistros["FOUND_ROWS()"]/$regpagina);

                                if(mysqli_num_rows($selticket)>0):
                            ?>
                            <table class="table table-striped jambo_table bulk_action">
                                <thead>
                                    <tr class="headings">
                                        <th class="column-title">Soluciòn</th>
                                        <th class="text-center">Fecha Atenciòn</th>
                                        <th class="text-center">Asesor</th>                                        
                                        <th class="text-center">Estado</th>                                        
                                        <th class="text-center">Generar pdf</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        //$ct=$inicio+1;
                                        while ($row=mysqli_fetch_array($selticket, MYSQLI_ASSOC)):
                                            $ct=$row['id_ticket'];
                                            $created_at=date('d/m/Y', strtotime($row['fecha_atencion']));
                                            $description=$row['description'];
                                            $asigned_id=$row['asigned_id'];
                                            $status_id=$row['status_id'];
                                            //$title=$row['title'];
                                            //$project_id=$row['project_id'];
                                            //$priority_id=$row['priority_id'];                                            
                                            //$kind_id=$row['kind_id'];
                                            //$cliente_id=$row['cliente_id'];
                                            //$category_id=$row['category_id'];                                            
                                            //$profile_pic=$row['profile_pic'];

                                            $sql = mysqli_query($con, "select * from ticket where id=$ct");
                                            if($c=mysqli_fetch_array($sql)) {
                                                $name_title=$c['title'];
                                            }

                                            /*$sql = mysqli_query($con, "select * from kind where id=$kind_id");
                                            if($c=mysqli_fetch_array($sql)) {
                                                $name_kind=$c['kind_name'];
                                            }*/

                                            /*$sql = mysqli_query($con, "select * from project where id=$project_id");
                                            if($c=mysqli_fetch_array($sql)) {
                                                $name_project=$c['proyect_name'];
                                            }*/

                                            /*$sql = mysqli_query($con, "select * from priority where id=$priority_id");
                                            if($c=mysqli_fetch_array($sql)) {
                                                $name_priority=$c['priority_name'];
                                            }*/

                                            $sql = mysqli_query($con, "select * from status where id=$status_id");
                                            if($c=mysqli_fetch_array($sql)) {
                                                $name_status=$c['status_name'];
                                            }

                                            $sql = mysqli_query($con, "select * from asesor where id=$asigned_id");
                                            if($c=mysqli_fetch_array($sql)) {
                                                $name_asigned=$c['name'];
                                            }

                                            $sql = mysqli_query($con, "select * from clientes where id_cliente=$cliente_id");
                                            if($c=mysqli_fetch_array($sql)) {
                                                $name_cliente=$c['name_Empresa'];
                                            } 
                                    ?>
                                    <input type="hidden" value="<?php echo $id;?>" id="id<?php echo $id;?>">                                  
                                    <input type="hidden" value="<?php echo $description;?>" id="description<?php echo $id;?>">

                                    <!-- me obtiene los datos -->
                                    <input type="hidden" value="<?php echo $kind_id;?>" id="kind_id<?php echo $id;?>">
                                    <input type="hidden" value="<?php echo $cliente_id;?>" id="cliente_id<?php echo $id;?>">
                                    <input type="hidden" value="<?php echo $project_id;?>" id="project_id<?php echo $id;?>">
                                    <input type="hidden" value="<?php echo $category_id;?>" id="category_id<?php echo $id;?>">
                                    <input type="hidden" value="<?php echo $priority_id;?>" id="priority_id<?php echo $id;?>">
                                    <input type="hidden" value="<?php echo $status_id;?>" id="status_id<?php echo $id;?>">
                                    <input type="hidden" value="<?php echo $asigned_id;?>" id="asigned_id<?php echo $id;?>">
                                    <!--<input type="hidden" value="<?php echo $profile_pic;?>" id="profile_pic?php echo $id;?>">-->
                                    <tr class="even pointer">
                                        <!--<td class="text-center"><?php echo $ct; ?></td> -->
                                        <td class="text-left"><?php echo $description;?></td>
                                        <td class="text-center"><?php echo $created_at;?></td>
                                        <td class="text-center"><?php echo $name_asigned; ?></td>
                                        <td class="text-center"><?php echo $name_status; ?></td>
                                        <!--<td class="text-center"><?php echo $name_priority; ?></td>
                                        <td class="text-center"><?php echo $name_project; ?></td> -->
                                        <td class="text-center">
                                            <a href="./lib/pdf.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-success" target="_blank"><i class="fa fa-print" aria-hidden="true"></i></a>

                                            <!--<a href="ticketedit-view.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></a>

                                            <form action="" method="POST" style="display: inline-block;">
                                                <input type="hidden" name="id_del" value="<?php echo $row['id']; ?>">
                                                <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                            </form> -->
                                        </td>
                                    </tr>
                                    <?php
                                        $ct++;
                                        endwhile; 
                                    ?>
                                </tbody>
                            </table>
                            <?php else: ?>
                                <h2 class="text-center">No hay atenciones registrados en el sistema para este ticket </h2>
                            <?php endif; ?>
                            </div> <!-- End table Responsive -->
                            <!-- form search -->                                                                          
                        </div>  
                     </div><!--End tab_2 -->                        
                    </div><!-- /.tab-content -->
                </div> <!--End Modal body-->
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div> -->

            </div><!--End Tabs custom -->
        </div>
    </div> <!-- /Modal -->



                        
                    </div><!-- nav-tabs-custom -->
                </div> <!-- /.col -->               
            </div>            
        </section><!-- /.content -->


    