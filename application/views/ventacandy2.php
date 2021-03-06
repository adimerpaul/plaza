<!--<style>-->
<!--    .boton{-->
<!--        padding: 22px;-->
<!--    }-->
<!--</style>-->
<div class="col-sm-11 col-md-10" id="app">
<!--    <h3 class="page-title">-->
<!--        Candy  <small> ventas </small>-->
<!--    </h3>-->
<!--    <nav aria-label="breadcrumb">-->
<!--        <ol class="breadcrumb ">-->
<!--            <li class="breadcrumb-item"><a href=""> <i class="fas fa-home"></i> Home</a></li>-->
<!--            <li class="breadcrumb-item"><a href=""> <i class="fas fa-signal"></i> Ventas candy</a></li>-->
<!--            <li class="breadcrumb-item active" aria-current="page"> <i class="fa fa-ticket-alt" ></i> Venta</li>-->
<!--        </ol>-->
<!--    </nav>-->
    <div class="row">
        <div class="col-sm-7">
            <div class="card " >
                <div class="card-header text-white bg-info"> <i class="fa fa-coffee"></i> RUBROS</div>
                <div class="card-body" style="border:0px">
                    <div class="row" >
                        <div class="col-2 card-img-top bg-green" >
                            <div class="card">
                                <img class="bg-green" src="assets/imagenes/combo.png" alt="Card image" style="border:0px;display: block;margin-left: auto;margin-right: auto;width: 100%;height: 100px">
                                <div class="card-img-overlay" >
                                    <h6 style="text-align:center;color:white;background: rgba(0,0,0,0.6);font-weight: bold;font-size: 14px;width: 100%">Combos</h6>
                                </div>
                            </div>
                        </div>
                        <div :class="'col-2 card-img-top bg-'+r.colorFondo" v-for="r in rubros">
                            <div class="card">
                                <img :class="'bg-'+r.colorFondo" :src="'assets/imagenes/'+r.imagen" alt="Card image" style="border:0px;display: block;margin-left: auto;margin-right: auto;width: 100%;height: 100px">
                                <div class="card-img-overlay" >
                                    <h6 style="text-align:center;color:white;background: rgba(0,0,0,0.6);font-weight: bold;font-size: 10px;width: 100%">{{r.nombreRubro}}</h6>
                                </div>
                            </div>
                        </div>
<!--                        <div class='col-4 tile bg-green' id="combos" style="border: 1px solid red">-->
<!--                            <div class='tile-body'>-->
<!--                                <img src='--><?//=base_url()?><!--assets/imagenes/combo.png' alt='logo'>-->
<!--                            </div>-->
<!--                            <div class='tile-object'>-->
<!--                                <h4 style='background: 	rgba(128,128,128,0.8);font-weight: bold;'>Combos</h4>-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>
<!--                    --><?php
//                    $query=$this->db->query("SELECT * FROM rubro WHERE activo='on'");
//                    foreach ($query->result() as $row){
//                        echo " <div class='tile bg-$row->colorFondo rubro' id='$row->idRubro' >
//                                    <div class='tile-body'>
//                                        <img src='".base_url()."assets/imagenes/$row->imagen' alt='logo'>
//                                    </div>
//                                    <div class='tile-object'>
//                                        <h5 style='font-weight: bold;'>$row->nombreRubro</h5>
//                                    </div>
//                                </div>";
//                    }
//                    ?>
                </div>
            </div>
            <div class="card  mb-3" >
                <div class="card-header text-white bg-info"><i class="fa fa-cocktail"></i> Productos</div>
                <div class="card-body" id="productos">

                </div>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="card  mb-3" >
                <div class="card-header text-white bg-info d-flex justify-content-end">
                    <button class="btn-danger m-0 p-0 btn-sm" id="cancelar"> <i class="fa fa-trash"></i> Cancelar</button>
                    <button class="btn-success m-0 p-0 btn-sm" data-toggle="modal" data-target="#cliente" id="cerrarventa"> <i class="fa fa-check"></i> Cerrar venta</button>
                </div>
                <div class="card-body">
                    <h6 class="card-title"><b>Fecha </b> <?=date("Y-m-d H:i:s")?> </h6>
                    <table class="table">
                        <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Producto</th>
                            <th>Prec.</th>
                            <th>Subt.</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody id="temporal">
                        </tbody>
                        <tfoot class="table-dark">
                            <tr>
                                <th></th>
                                <th></th>
                                <th>TOTAL</th>
                                <th><b><h5 id="totaltemporal">0</h5></b></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="seleccion-producto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Detalle Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formulario">
                <div class="row">
                    <div class="col-sm-6">
                            <div class="form-group">
                                <label for="nombre">Nombre producto</label>
                                <input type="email" class="form-control" id="nombre" placeholder="Nombre Producto" disabled>
                            </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="precio">Precio unit.</label>
                                    <input type="number" class="form-control" id="precio" disabled>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="total">Total (BS.).</label>
                                    <input type="number" class="form-control" id="total" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cantidad">Cantidad</label> <br>
                            <button id="mini" class="btn-danger boton"> <i class="fa fa-minus"></i></button>
                            <input type="number"  style="width: 90px;font-size: 20px" id="cantidad" class="boton" value="1" placeholder="0" disabled>
                            <button id="maxi" class="btn-success boton" > <i class="fa fa-plus"></i></button>
                        </div>

                    </div>
                    <div class="col-sm-6">
                        <div id="seleccionados" class="form-control" style="height: 100%">

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="preferencias">Preferencias</label>
                            <div class="form-control" id="preferencias" >

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-trash"></i> Cancelar</button>
                    <button type="submit" class="btn btn-info"> <i class="fa fa-check"></i> Agregar al pedido</button>
                </div>
                </form>
            </div>


        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="cliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Datos Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formulariocliente">
                    <div class="form-group row">
                        <label for="cinit" class="col-sm-2 col-form-label">CI NIT Cliente</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="cinit" placeholder="CI NIT " required>
                        </div>
                        <div class="col-sm-4">
                            <input class="form-control" id="tipo" type="checkbox" checked data-toggle="toggle" data-on="F" data-off="O"  data-onstyle="primary" data-offstyle="success">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="apellidos" class="col-sm-3 col-form-label">Apellidos (razon social)</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control"  required id="apellidos" placeholder="Razon " style="text-transform: uppercase;">
                        </div>
                        <label for="nombres" class="col-sm-1 col-form-label">Nombres</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="nombres" placeholder="nombres " style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-4">
                            <label for="montocliente">Monto cobrado</label>
                            <input type="text" class="form-control" id="montocliente" required>
                        </div>
                        <div class="col-sm-4">
                            <label for="montoapagar">Monto a cancelar</label>
                            <input type="text" class="form-control" id="montoapagar" disabled>
                        </div>
                        <div class="col-sm-4">
                            <label for="cambio">Cambio</label>
                            <input type="text" class="form-control" id="cambio" >
                        </div>
                    </div>
                    <hr>
                    <label for="cupon">T Credito:</label>
        <input type="checkbox" id="credito" name="credito" ><br>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-trash"></i> Cancelar</button>
                        <button type="submit" class="btn btn-success" id='terminar'> <i class="fa fa-check"></i> Terminar venta</button>
                    </div>
                </form>
                <form id="formulariocodigo">
                <div class="form-group row">
                    <div class="col-3">
                        <label class="form-control" for="tarjeta">
                            Tarjeta
                        </label>
                        <input class="form-control" type="checkbox" value="" id="tarjeta" name="tarjeta" >

                    </div>
                    <div class="col-9">
                        <div id="booltarjeta" name="booltarjeta"  class="row"  >
                            <div class="col-sm-4">
                                <label for="codigo">Codigo</label>
                                <input type="text" class="form-control" id="codigo" name="codigo" >
                            </div>
                            <div class="col-sm-4">
                                <label for="saldo">Saldo</label>
                                <input type="text" class="form-control" id="saldo" name="saldo" disabled>
                            </div>
                            <div class="col-sm-4">
                                <label for="saldo">Nombre</label>
                                <input type="text" class="form-control" id="tnombre" name="tnombre" disabled>
                            </div>
                            <input style="display: none" type="submit">
                        </div>
                    </div>

                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?=base_url('assets/dist');?>/axios.min.js"></script>
<script src="<?=base_url('assets/vue');?>/vue.js"></script>
<script>
    var app = new Vue({
        el: '#app',
        data: {
            rubros:[],
            url:"<?=base_url()?>",
        },
        created(){
            this.myRubros()
        },
        methods:{
            myRubros(){
                axios.get('VentaCandyCtrl2/rubros').then(res=>{
                    this.rubros=res.data
                })
            }
        }
    })
</script>


