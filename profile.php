<?php 
    $title ="Dashboard - "; 
    include "head.php";
    include "sidebar.php";

    //mysqli_query($con, "SET NAMES 'utf8'");
    $TicketRegistrado=mysqli_query($con, "select * from ticket where status_id=8");
    $TicketAsginado=mysqli_query($con, "select * from ticket where status_id=2");
    $TicketenProceso=mysqli_query($con, "select * from ticket where status_id=3");
    $TicketFinalizados=mysqli_query($con, "select * from ticket where status_id=5");
    $ProjectData=mysqli_query($con, "select * from project");
    $CategoryData=mysqli_query($con, "select * from category");
    $UserData=mysqli_query($con, "select * from user order by created_at desc");
    //$Asesor_Asignado==mysqli_query($con, "select * from ticket where asigned_id = 4");
?>

     
    <div class="right_col" role="main"> <!-- page content -->
        <div class="">
            <div class="page-title">
                <div class="row top_tiles">
                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a href="Tickets_Registrados.php">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-ticket"></i></div>
                          <div class="count">                             
                                <?php echo mysqli_num_rows($TicketRegistrado) ?>          
                          </div>
                          <h3>Tickets Registrados</h3>
                        </div> 
                        </a>                       
                    </div>
                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                      <a href="Tickets_Asignados.php">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-list"></i></div>
                          <div class="count"><?php echo mysqli_num_rows($TicketAsginado) ?></div>
                          <h3>Tickets Asignados</h3>
                        </div>
                      </a> 
                    </div>
                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                      <a href="Tickets_en_proceso.php">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-pencil"></i></div>
                          <div class="count"><?php echo mysqli_num_rows($TicketenProceso) ?></div>
                          <h3>Tickets En Proceso</h3>
                        </div>
                      </a>
                    </div>
                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                      <a href="cerrados.php">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-calendar-check-o"></i></div>
                          <div class="count"><?php echo mysqli_num_rows($TicketFinalizados) ?></div>
                          <h3>Tickets Finalizados</h3>
                        </div>
                      </a>
                    </div>
                </div>
                <!-- content -->
                
                <br><br>
                <div class="row">
                    <div class="col-md-4">
                        <div class="image view view-first">
                            <img class="thumb-image" style="width: 100%; display: block;" src="images/profiles/<?php echo $profile_pic; ?>" alt="image" />
                        </div>
                        <span class="btn btn-my-button btn-file">
                            <form method="post" id="formulario" enctype="multipart/form-data">
                                <input type="hidden" name="mod_id" id="mod_id">
                            Cambiar Imagen de perfil: <input type="file" name="file">
                            </form>
                        </span>
                        <div id="respuesta"></div>
                    </div>
                    <div class="col-md-8 col-xs-12 col-sm-12">
                        <?php include "lib/alerts.php";
                            profile(); //llamada a la funcion de alertas
                        ?>    
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Informacion personal</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <!--<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                                    </li> -->
                                </ul>
                            <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <br />
                                <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="action/upd_profile.php" method="post">
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nombre
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" name="name" id="first-name" class="form-control col-md-7 col-xs-12" value="<?php echo $name; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Correo electronico 
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="last-name" name="email" class="form-control col-md-7 col-xs-12" value="<?php echo $email; ?>">
                                        </div>
                                    </div>

                                    <br><br><br>
                                    <h2 style="padding-left: 50px">Cambiar Contrase??a</h2>
                            
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Contrase??a antigua
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="birthday" name="password" class="date-picker form-control col-md-7 col-xs-12" type="text" placeholder="**********">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nueva contrase??a 
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="birthday" name="new_password" class="date-picker form-control col-md-7 col-xs-12" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Confirmar contrase??a nueva
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                      <input id="birthday" name="confirm_new_password" class="date-picker form-control col-md-7 col-xs-12" type="text">
                                        </div>
                                    </div>
                                    <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                            <button type="submit" name="token" class="btn btn-success">Actualizar Datos</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /page content -->



<?php include "footer.php" ?>
<script>
    $(function(){
        $("input[name='file']").on("change", function(){
            var formData = new FormData($("#formulario")[0]);
            var ruta = "action/upload-profile.php";
            $.ajax({
                url: ruta,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(datos)
                {
                    $("#respuesta").html(datos);
                }
            });
        });
    });
</script>