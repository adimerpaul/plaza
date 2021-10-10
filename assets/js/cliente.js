
$('#exampleModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var idcliente = button.data('idcliente') // Extract info from data-* attributes
    var parametros = {
        "idcliente" : idcliente,
    };
    $.ajax({
        data:  parametros,
        url:   'datos',
        type:  'post',
        beforeSend: function () {
            //$("#resultado").html("Procesando, espere por favor...");
        },
        success:  function (response) {
            console.log(response);
            var datos=JSON.parse(response);
            $('#idcliente').prop('value',datos.idCliente);
            $('#cinit').prop('value',datos.cinit);
            $('#nombre').prop('value',datos.nombreCl);
            $('#apellido').prop('value',datos.apellidoCl);
            $('#email').prop('value',datos.email);
            $('#fechanac').prop('value',datos.fechaNac);
            $('#telef').prop('value',datos.telefono);
            $('#direccion').prop('value',datos.direccion);
            $('#sexo').prop('value',datos.sexo);
            $('#tarjeta').prop('value',datos.codigoTarjeta);
            
        }
    });

})
function ltrim(stringToTrim) {

    return stringToTrim.replace(/^\s+/g,"");
   
   }


$('#cinit').keyup(function (){verifiCl();});

    function verifiCl(e){
        cadena=$('#cinit').val();
        console.log(cadena.charAt(0));
        if(cadena.charAt(0) == ' '){
            cadena=ltrim($('#cinit').prop('value'));
            $('#cinit').prop('value',cadena);
            }
    var cinit = $('#cinit').prop('value'); // Extract info from data-* attributes
    var parametros = {
                      "cinit" : cinit,
                     "mostrar" : 'codigo'
              };
              $.ajax({
                      data:  parametros,
                      url:   'ClienteCtrl/datocliente',
                      type:  'post',
                      beforeSend: function () {
                              //$("#resultado").html("Procesando, espere por favor...");
                      },
                      success:  function (response) {
                          console.log(response);
                          var datos=JSON.parse(response);
                          if (datos.cinit==''){
                            $('#cinit_error').html("");
                            $('#cinit_error').hide();
                            $('#btnCliente').prop('enabled', true);
                        }
                            else
                           {
                            $('#cinit_error').html("el cliente existe");
                            $('#cinit_error').show();
                            $('#btnCliente').prop('disabled', true);
                           
                          }                    
                      } 
              });      
  }
