<?php

    include "../config/config.php";//Contiene funcion que conecta a la base de datos
    
    $action = (isset($_REQUEST['action']) && $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
    if (isset($_GET['id'])){
        $id_del=intval($_GET['id']);
        $query=mysqli_query($con, "SELECT * from atencion where id='".$id_del."'");
        $count=mysqli_num_rows($query);

            if ($delete1=mysqli_query($con,"DELETE FROM atencion WHERE id='".$id_del."'")){
?>
            <div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Aviso!</strong> Datos eliminados exitosamente.
            </div>
        <?php 
            }else {
        ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
                </div>
    <?php
            } //end else
        } //end if
    ?>

<?php
    if($action == 'ajax'){
        // escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
         $aColumns = array('id');//Columnas de busqueda
         $sTable = "ticket";
         $sWhere = "";
        if ( $_GET['q'] != "" )
        {
            $sWhere = "WHERE (";
            for ( $i=0 ; $i<count($aColumns) ; $i++ )
            {
                $sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
            }
            $sWhere = substr_replace( $sWhere, "", -3 );
            $sWhere .= ')';
        }
        $sWhere.=" order by created_at desc";
        include 'pagination.php'; //include pagination file
        //pagination variables
        $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
        $per_page = 10; //how much records you want to show
        $adjacents  = 4; //gap between pages after number of adjacents
        $offset = ($page - 1) * $per_page;
        //Count the total number of row in your table*/
        $count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
        $row= mysqli_fetch_array($count_query);
        $numrows = $row['numrows'];
        $total_pages = ceil($numrows/$per_page);
        $reload = './expences.php';
        //main query to fetch the data
        $sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
        $query = mysqli_query($con, $sql);
        //loop through fetched data
        if ($numrows>0){
            
            ?>
            <table class="table table-striped jambo_table bulk_action">
                <thead>
                    <tr class="headings">
                        <th class="column-title">Numero Ticket</th>
                        <th class="column-title">Atenci??n </th>
                        <!--<th class="column-title">Proyecto </th>-->
                        <th class="column-title">Prioridad </th>
                        <th class="column-title">Estado </th>
                        <th class="column-title">Asesor </th>
                        <th>Fecha Atenci??n</th>
                        <!--<th class="column-title">Archivo </th>-->
                        <th class="column-title no-link last"><span class="nobr"></span></th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                        while ($r=mysqli_fetch_array($query)) {
                            $id=$r['id'];
                            $created_at=date('d/m/Y', strtotime($r['created_at']));
                            $description=$r['description'];
                            $title=$r['title'];
                            $project_id=$r['project_id'];
                            $priority_id=$r['priority_id'];
                            $status_id=$r['status_id'];
                            $kind_id=$r['kind_id'];
                            $cliente_id=$r['cliente_id'];
                            $category_id=$r['category_id'];
                            $asigned_id=$r['asigned_id'];
                            $profile_pic=$r['profile_pic'];

                            $sql = mysqli_query($con, "select * from project where id=$project_id");
                            if($c=mysqli_fetch_array($sql)) {
                                $name_project=$c['proyect_name'];
                            }

                            $sql = mysqli_query($con, "select * from priority where id=$priority_id");
                            if($c=mysqli_fetch_array($sql)) {
                                $name_priority=$c['priority_name'];
                            }

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

                        //$ruta = '../images/multimedia/'.$id;
                            //$path = '../images/multimedia/'.$id.'/<?php echo $profile_pic;


                ?>

                    <input type="hidden" value="<?php echo $id;?>" id="id<?php echo $id;?>">
                    <input type="hidden" value="<?php echo $title;?>" id="title<?php echo $id;?>">
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
                        <td><?php echo $id;?></td>
                        <td><?php echo $title;?></td>
                        <td><?php echo $name_project; ?></td>
                        <td><?php echo $name_priority; ?></td>
                        <td><?php echo $name_status;?></td>
                        <td><?php echo $name_asigned;?></td>
                        <td><?php echo $created_at;?></td>
                        <!--<td><img class="thumb-image" title='Ver' style="width: 10%; display: block;" src="images/multimedia/<?php echo $profile_pic; ?>" alt="image" ></td>-->
                        <!--<td><a href= "#" style="color: #87CEEB" onClick= "mostrarVentanaImagen('images/multimedia/<?php echo $profile_pic; ?>','Contenido Multimedia',false,true);return false" >Ver Imagen/Archivo</a></td>-->
                        <!--<td><a href= "#" style="color: #87CEEB" onClick= "mostrarVentanaImagen(\"$path\",'Contenido Multimedia',false,true);return false" >Ver Imagen/Archivo</a></td>-->

                        <td ><span class="pull-right">
                        <!--<a href="#" class='btn btn-default' title='Adjuntar' data-toggle="modal" data-target=".bs-example-modal-lg-img"><i class="glyphicon glyphicon-edit"></i></a>     -->
                        <!--<img class="thumb-image" title='Ver' style="width: 14%; display: active;" src="images/multimedia/<?php echo $profile_pic; ?>" alt="image" />-->
                        <!--<a class="thumb-image" title='Ver' style="width: 14%; display: active;" onClick= "mostrarVentanaImagen('images/multimedia/<?php echo $profile_pic; ?>','Contenido Multimedia',false,true);return false" alt="image" >Abrir imagen</a>-->
                        
                        <a href="#" class='btn btn-default' title='Ver Detalle' onclick="obtener_datos('<?php echo $id;?>');"  data-toggle="modal" data-target=".bs-example-modal-lg-udp"><i class="glyphicon glyphicon-edit"></i></a>
                        <!--<a href="#" class='btn btn-default' title='Borrar producto' onclick="eliminar('<?php echo $id; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></span></td>-->
                    </tr>
                <?php
            } //en while
                ?>
                <tr>
                    <td colspan=9><span class="pull-right">
                        <!--<td colspan=7><span class="pull-right">-->
                        <?php echo paginate($reload, $page, $total_pages, $adjacents);?>
                    </span></td>
                </tr>
              </table>
            </div>
            <?php
        }else{
           ?> 
            <div class="alert alert-warning alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Aviso!</strong> No hay datos para mostrar!
            </div>
        <?php    
        }
    }
?>