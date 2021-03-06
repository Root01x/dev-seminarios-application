<?php

session_start();

if ($_SESSION['rol'] != 1) {
    # code...

    header("location: ../");
}



 include "../conection.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"?>
	<title>LISTA DE TRANSACCIONES</title>
</head>
<body>
 <?php include "includes/header.php"?>
	<section id="container">
		
        <h1><i class="fas fa-list-alt"></i> Lista de Transacciones</h1>

        <a href="Nueva_transaccion.php" class="btn_new">Nueva Transaccion</a>
<!--
    <form action="buscar_transaccion.php" method="get" class="form_search">
        <input type="text" name="busqueda" id="busqueda" placeholder="No. Transaccion">
        <button type ="submit" class="btn_search"><i class="fas fa-search"></i></button>
    </form>
    
    <div>
        <h5>Buscar por Fecha</h5>
        <form action="buscar_transaccion.php" method="get" class="form_search_date">
            <label for="">De: </label>
            <input type="date" name="fecha_de" id="fecha_de" required>
            <label for="">A</label>
            <input type="date" name="fecha_a" id="fecha_a" required>
            <button type="submit" class="btn_view"><i class="fas-search"></i></button>
        </form>
    </div>-->

        <table>
            <tr>
                <th>NO.</th>
                <th>Fecha / Hora</th>
                <th>Cliente</th>
                <th>Encargado</th>
                <th>Estado</th>
                <th class="textright">Valor Total</th>
                <th class="textright">Acciones</th>

                
            </tr>

            <?php

            //PAGINADO CCODIGO
           $sql_registre = mysqli_query($conection,"SELECT COUNT(*) AS total_registro FROM factura WHERE status !=10");
           $result_registre = mysqli_fetch_array($sql_registre);
           $total_resgistros = $result_registre['total_registro'];
           $por_pagina = 4;

           if (empty($_GET['pagina'])) {
               $pagina =1;
               # code...
           }
           else {
               $pagina = $_GET['pagina'];
           }

           $desde = ($pagina - 1) * $por_pagina;
           $total_paginas = ceil($total_resgistros / $por_pagina);


           $query = mysqli_query($conection,"SELECT f.nofactura,f.fecha,f.totaltFactura,f.codcliente,f.status,
                                                    u.nombre as encargado,
                                                    cl.nombre as cliente
                                            FROM factura f
                                            INNER JOIN usuario u
                                            ON f.usuario = u.idusuario
                                            INNER JOIN cliente cl
                                            ON f.codcliente = cl.idcliente
                                            WHERE f.status != 10
                                            ORDER BY f.fecha DESC LIMIT $desde,$por_pagina");
           $result = mysqli_num_rows($query);
           mysqli_close($conection);
           if ($result > 0) {
               while ($data = mysqli_fetch_array($query)) {

                    if ($data["status"] == 1) {
                        $estado = '<span class="pagada">Pagada</span>';
                        # code...
                    }else {
                        $estado = '<span class="anulada">Anulada</span>';
                    }
           ?>
            <tr id="row_<?php echo $data["nofactura"];?>">
                <td><?php echo $data["nofactura"];?></td>
                <td><?php echo $data["fecha"];?></td>
                <td><?php echo $data["cliente"];?></td>
                <td><?php echo $data["encargado"];?></td>
                <td class="estado"><?php echo $estado;?></td>
                <td class="textright totalfactura"><span></span><?php echo '$ '.$data["totaltFactura"]; ?></td>
               
                <td>
                    <div class="div_acciones">
                    <!--   
                    <div>
                            <button class="btn_view view_factura" type="button" cl="<?php echo $data["concliente"];?>"f="<?php echo $data['nofactura'];?>"><i class="fas fa-eye"></i></button>

                        </div>
                -->

                    <?php 
                        if($data["status"]==1)
                        {

                        
                    ?>
                    <div class="div_factura">
                            <button class="btn_anular anular_factura" fac="<?php echo $data["nofactura"]; ?>"><i class="fas fa-ban"></i></button>
                    </div>
                    <?php 
                        }else{
                            
                    ?>
                    <div class="div_factura">
                        <button type="button" class="btn_anular inactive"><i class="fas fa-ban"></i></button>

                    </div>

                    <?php } ?>
                    </div>
                </td>

                


            </tr>

                <?php
                   # code...
               }
               # code...
           }


            ?>
            <table>
               
            </table>
         
           
        </table>


        <div class="paginador">
                    <ul>
                        <?php
                            if ($pagina != 1) {
                              
                            ?>  
                            <li><a href="?pagina=<?php echo 1;?>">|<</a></li>
                            <li><a href="?pagina=<?php echo $pagina-1;?>"><<</a></li>

                            <?php
                                # code...
                            }
                        
                        
                        ?>
                    

                    <?php 
                    
                    for ($i=1; $i <= $total_paginas; $i++) { 

                        if ($i == $pagina) {
                            
                            echo '<li class="pageSelected">'.$i.'</li>';
                            # code...
                        }
                        else {

                            echo '<li><a href="?pagina='.$i.'">'.$i.'</a></li>';
                        # code...
                        }


                    }
                    if ($pagina!=$total_paginas) {
   
                    
                    ?>
                     
                    <li><a href="?pagina=<?php echo $pagina+1;?>">>></a></li>
                    <li><a href="?pagina=<?php echo $total_paginas;?>">>|</a></li>
                        <?php 
                            }
                        
                        ?>
                    </ul>

                </div>
	</section>
<?php include "includes/footer.php"?>
</body>
</html>