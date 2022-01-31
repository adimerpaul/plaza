$(document).ready(function(){
    //calculaCaja();
    //calculaDetalle();
    //calculototal();
    //totalpromo();
});  

//$('#fechadia').change(function(){ 
    //calculaCaja();
    //calculaDetalle();
    //calculototal();
    //totalpromo();
//});

//$('#vendedor').change(function(){
//    calculaCaja();
//    calculaDetalle();
 //   calculototal();
//})
$('#fechadia').change(function(){
    //     calculaCaja();
    //     calculaDetalle();
    //     calculototal();
        if($('#fechadia').val()>$('#fechadia2').val()){
            $('#consultadia').prop('disabled',true);
            $('#imprimir').prop('disabled',true);
            $('#imptodo').prop('disabled',true);
        }
        else
        {
            $('#consultadia').prop('disabled',false);
            $('#imprimir').prop('disabled',false);
            $('#imptodo').prop('disabled',false);  
        }
    });
    
    $('#fechadia2').change(function(){
        //     calculaCaja();
        //     calculaDetalle();
        //     calculototal();
            if($('#fechadia').val()>$('#fechadia2').val()){
                $('#consultadia').prop('disabled',true);
                $('#imprimir').prop('disabled',true);
                $('#imptodo').prop('disabled',true);
            }
            else
            {
                $('#consultadia').prop('disabled',false);
                $('#imprimir').prop('disabled',false);
                $('#imptodo').prop('disabled',false);  
            }
        });
    // $('#vendedor').change(function(){
    //     calculaCaja();
    //     calculaDetalle();
    //     calculototal();
    // })
    
    $('#consultadia').click(function (){
        calculaCaja();
        calculaDetalle();
        calculototal();
        totalpromo();
    })

function calculaCaja(){
    var fecha=$('#fechadia').val();
    var fecha2=$('#fechadia2').val();
    var id=$('#vendedor').val();
    var param={
        'fecha':fecha,
        'fecha2':fecha2,
        'id':id
    };
    var resFactura="";
    var resdetalle="";
    var total=0;
    var estadoVenta='';
    console.log(param);
    $.ajax({
        data:  param,
        url:   'ResumenDia/reportedia',
        type:  'post',
        beforeSend: function () {
            //$("#resultado").html("Procesando, espere por favor...");
            //$('#listaeliculas').html("procesando...");
        },
        success:  function (response){
            $('#tabfactura').html('');
            console.log(response);
            datos2=JSON.parse(response);
            console.log(param);
            datos2.forEach(row => {
                resFactura+="<tr>";
                resFactura+="<td>"+row.idVenta+"</td>";                
                resFactura+="<td>"+row.fechaVenta+"</td>";  
                if(row.estado=="ANULADO")              
                    resFactura+="<td>A</td>";
                else{
                    if(row.tipoVenta=="FACTURA")
                        resFactura+="<td>F</td>";
                    else
                        resFactura+="<td>R</td>";
                    
                }  
                resFactura+="<td>"+row.apellidoCl+"</td>";
                resFactura+="<td>"+row.total+"</td>";                
                resFactura+="</tr>";
                total=total+parseFloat(row.total);
            });
            resFactura+="<tr><th></th><th></th><th></th><th>Total</th><th>"+total+"</th></tr>";
            $('#tabfactura').html(resFactura);
            
        }
    })
};

function calculaDetalle(){
    var fecha=$('#fechadia').val();
    var fecha2=$('#fechadia2').val();
    var id=$('#vendedor').val();
    var param={
        'fecha':fecha,
        'fecha2':fecha2,
        'id':id
    };
    var resdetalle="";
    var total=0;
    $.ajax({
        data:  param,
        url:   'ResumenDia/detallePelicula',
        type:  'post',
        beforeSend: function () {
            //$("#resultado").html("Procesando, espere por favor...");
            //$('#listaeliculas').html("procesando...");
        },
        success:  function (response){
            $('#tabPelicula').html('');
            console.log(response);
            datos2=JSON.parse(response);
            console.log(param);

            datos2.forEach(row => {
                if (row.formato==1){
                    var forma="3D";
                }else{
                    var forma="2D";
                }
                resdetalle+="<tr>";
                resdetalle+="<td>"+row.nombre+" "+forma+"</td>";
                resdetalle+="<td>"+row.cantidadb+"</td>";                
                resdetalle+="<td>"+row.fecha+"</td>";                
                resdetalle+="<td>"+row.total+"</td>";                
                resdetalle+="</tr>";
                total=total+parseFloat(row.total);
            });
            resdetalle+="<tr><th></th><th></th><th>Total</th><th>"+total+"</th></tr>";
            $('#tabPelicula').html(resdetalle);
            
        }
    })
};

$('#imprimir').click(function(){
    var fecha=$('#fechadia').val();
    var fecha2=$('#fechadia2').val();
    var id=$('#vendedor').val();
    var param={
        'fecha':fecha,
        'fecha2':fecha2,
        'id':id
    };
    $.ajax({
        data:  param,
        url:   'ResumenDia/pruebaImpresion',
        type:  'post',
        beforeSend: function () {
            //$("#resultado").html("Procesando, espere por favor...");
        },
        success:  function (response){
            console.log(response);
            var myWindow = window.open("", "myWindow", "width=200,height=100");
            myWindow.document.write(response);
              myWindow.document.close();
              myWindow.focus();
              myWindow.print();
              myWindow.close();
        }}) 
        $.ajax({
            data:  param,
            url:   'ResumenDia/pruebaRecImpresion',
            type:  'post',
            beforeSend: function () {
                //$("#resultado").html("Procesando, espere por favor...");
            },
            success:  function (response){
                console.log(response);
                var myWindow = window.open("", "myWindow", "width=200,height=100");
                myWindow.document.write(response);
                  myWindow.document.close();
                  myWindow.focus();
                  myWindow.print();
                  myWindow.close();
            }})  
            $.ajax({
                data:  param,
                url:   'ResumenDia/pruebaFactImpresion',
                type:  'post',
                beforeSend: function () {
                    //$("#resultado").html("Procesando, espere por favor...");
                },
                success:  function (response){
                    console.log(response);
                    var myWindow = window.open("", "myWindow", "width=200,height=100");
                    myWindow.document.write(response);
                      myWindow.document.close();
                      myWindow.focus();
                      myWindow.print();
                      myWindow.close();
                }})     
});

$('#imptodo').click(function(){
    var fecha=$('#fechadia').val();
    var fecha2=$('#fechadia2').val();
    var param={
        'fecha':fecha,
        'fecha2':fecha2,
    };
    $.ajax({
        data:  param,
        url:   'ResumenDia/todopruebaImpresion',
        type:  'post',
        beforeSend: function () {
            //$("#resultado").html("Procesando, espere por favor...");
        },
        success:  function (response){
            console.log(response);
            var myWindow = window.open("", "myWindow", "width=200,height=100");
            myWindow.document.write(response);
              myWindow.document.close();
              myWindow.focus();
              myWindow.print();
              myWindow.close();
        }}) 
        $.ajax({
            data:  param,
            url:   'ResumenDia/todopruebaRecImpresion',
            type:  'post',
            beforeSend: function () {
                //$("#resultado").html("Procesando, espere por favor...");
            },
            success:  function (response){
                console.log(response);
                var myWindow = window.open("", "myWindow", "width=200,height=100");
                myWindow.document.write(response);
                  myWindow.document.close();
                  myWindow.focus();
                  myWindow.print();
                  myWindow.close();
            }})  
            $.ajax({
                data:  param,
                url:   'ResumenDia/todopruebaFactImpresion',
                type:  'post',
                beforeSend: function () {
                    //$("#resultado").html("Procesando, espere por favor...");
                },
                success:  function (response){
                    console.log(response);
                    var myWindow = window.open("", "myWindow", "width=200,height=100");
                    myWindow.document.write(response);
                      myWindow.document.close();
                      myWindow.focus();
                      myWindow.print();
                      myWindow.close();
                }})     
});

function calculototal(){
    var fecha=$('#fechadia').val();
    var fecha2=$('#fechadia2').val();
    var id=$('#vendedor').val();
    var param={
        'fecha':fecha,
        'fecha2':fecha2,
        'id':id
    };
    $.ajax({
        data:  param,
        url:   'ResumenDia/totalBol',
        type:  'post',
        beforeSend: function () {
            //$("#resultado").html("Procesando, espere por favor...");
        },
        success:  function (response){
            $('#totalrecibo').html('0');
            $('#totalfactura').html('0');
            console.log(response);
            datos2=JSON.parse(response);
            $('#totalrecibo').html(' '+datos2.trecibo+' Bs');
            $('#totalfactura').html(' '+datos2.tfactura+' Bs');
            
        }})
}

function totalpromo(){
    var fecha=$('#fechadia').val();
    var fecha2=$('#fechadia2').val();
    var param={
        'fecha':fecha,
        'fecha2':fecha2
    };
    $.ajax({
        data:  param,
        url:   'ResumenDia/totalpromo',
        type:  'post',
        beforeSend: function () {
            //$("#resultado").html("Procesando, espere por favor...");
        },
        success:  function (response){
            $('#promot').html('');
            console.log(response);
            datos2=JSON.parse(response);
            var total=0;
            datos2.forEach(row => {
                total+=parseFloat(row.ticket);
            });
            if(total>0)
            $('#promot').html('<b><label>Total Ticket Promo: </label></b> '+total);
            else
            $('#promot').html('');
            
        }})
}

function totalcortesia(){
    var fecha=$('#fechadia').val();
    var fecha2=$('#fechadia2').val();
    var param={
        'fecha':fecha,
        'fecha2':fecha2
    };
    $.ajax({
        data:  param,
        url:   'ResumenDia/totalCortesia',
        type:  'post',
        beforeSend: function () {
            //$("#resultado").html("Procesando, espere por favor...");
        },
        success:  function (response){
            $('#cortesiat').html('');
            console.log(response);
            datos2=JSON.parse(response);
            var total=0;
            datos2.forEach(row => {
                total+=parseInt(row.cortesia);
            });
            if(total>0)
            $('#cortesiat').html('<b><label>Total cortesia: </label></b> '+total);
            else
            $('#cortesiat').html('');
            
        }})
}