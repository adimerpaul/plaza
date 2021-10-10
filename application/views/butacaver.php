<div class="col-sm-11 col-md-10">
    <h3>TIPOS BUTACAS</h3>
    <br>
    <div class="card ">
    <div class="card-header text-white bg-warning" >
        BUTACAS
    </div>
    <div class="card-body">     <br>   
        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>

        <?php foreach($butaca as $row): ?>
        <tr>
            <td><?php echo $row['idButaca']; ?></td>
            <td><?php echo $row['nombreBut']; ?></td>
            <td><?php echo $row['descripcionBut']; ?></td>
            <td>                
                    <a class="btn btn-outline-warning  btn-sm" data-toggle="modal" data-target="#exampleModal" data-idbutaca="<?php echo $row['idButaca']?>"> Modificar</a>
                    <a class="btn btn-outline-danger eli  btn-sm" href="<?=base_url()?>ButacaCtrl/delete/<?=$row['idButaca']?>"> Eliminar</a>
                   
            </td>
        </tr>
    <?php endforeach; ?>
            </tbody>
        </table>
        <script>
                var eli=document.getElementsByClassName('eli');
                for(var i=0;i<eli.length;i++){
                    eli[i].addEventListener('click',function(e){
                        //alert('asd');
                        if(!confirm('seguro de eliminar')){
                            e.preventDefault();
                        }  
                    });
                }
        
        </script>
    </div>
</div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modificar Butaca</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="POST" action="<?php echo base_url();?>ButacaCtrl/update" >
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="nombre">Nombre Butaca:</label>   
      <input type="hidden" id="idbutaca" name="idbutaca" >
      <input type="text" class="form-control" id="nombre" name="nombre" required>  
    </div>
    <div class="form-group col-md-6">
      <label for="descripcion">Detalle: </label>
      <textarea class="form-control" rows="5" cols="" id="descripcion" name="descripcion"></textarea>
    </div>
  </div>
  <div class="form-row">
  <div class="form-group col-md-6">
      <label for="nomfant">Activo:</label>   
      <input id="activo" name="activo" type="checkbox" checked data-on-color="warning" data-on="activo">
    </div>

  </div>

  <input type="submit" class="btn btn-success" value="Registrar">
  <a type="button" class="btn btn-warning" href="<?php echo base_url();?>ButacaCtrl/butacaver">Cancelar</a>
</form>
      </div>
      <div class="modal-footer">

      </div>
    </div>
  </div>
</div>

