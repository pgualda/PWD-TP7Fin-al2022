<?php
$Titulo = " Gestion de Roles";
include_once("../../util/estructura/header.php");
$datos = data_submitted();

$obj= new CTRLRol();
$lista = $obj->buscar(null);

?>
<h3>ABM - Roles</h3>
<div class="row float-left">
    <div class="col-md-12 float-left">
      <?php 
      if(isset($datos) && isset($datos['idrol']) && $datos['rodescripcion']!=null) {
        echo $datos['idrol'];
      }
     ?>
    </div>
</div>


<div class="row float-right">

    <div class="col-md-12 float-right">
        <a class="btn btn-success" role="button" href="editar.php?accion=nuevo&idrol=-1">Nuevo</a>

    </div>
</div>


<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
            <th scope="col">Acciones</th>
        </tr>
        </thead>
        <tbody>

<?php
 if( count($lista)>0){
    foreach ($lista as $objTabla) {
        echo '<tr><td>'.$objTabla->getidrol().'</td>';
        echo '<td>'.$objTabla->getrodescripcion().'</td>';
        echo '<td><a class="btn btn-info" role="button" href="editar.php?accion=editar&idrol='.$objTabla->getidrol().'">editar </a>';
        echo '<a class="btn btn-primary" role="button" href="editar.php?accion=borrar&idrol='.$objTabla->getidrol().'">borrar</a></td></tr>';
	}
}

?>
        </tbody>
    </table>
</div>



<?php

include_once("../../util/estructura/footer.php");
?>