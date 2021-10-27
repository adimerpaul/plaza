<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require_once('tcpdf.php');
include "qrlib.php";
include "NumerosEnLetras.php";
require 'autoload.php';
include 'barcode.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\CapabilityProfile;
include "vendor/autoload.php"; // Incluimos la libreria

class VentaCtrl extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->load->model('Usuarios_model');
        $this->load->model('Temporal_model');
        $this->load->model('Boletos_model');

        $this->load->model('Ventas_model'); // This loads the library
        $this->load->model('Dosificaciones_model');
	}

    public function index()
    {
        if($this->session->userdata('login')==1){

            $user = $this->session->userdata('idUs');

            $temporal['temporal'] = $this->Temporal_model->listaTemporal();
            $dato=$this->Usuarios_model->validaIngreso($user);
                $this->load->view('templates/header', $dato);
                $this->load->view('panelventa',$temporal);
                $dato2['js']="<script src='".base_url()."assets/js/venta.js'></script>";
                $this->load->view('templates/footer',$dato2);
        }
        else redirect('');
    }

    public function horario(){
        $idpelicula=$_POST['idpel'];
        $fecha=$_POST['fecha1'];

        $consulta="SELECT p.idPelicula,nombre,formato, s.idSala, nroSala, f.idFuncion,
        time_format(horaInicio, '%H:%i') as horaIn,time_format(horaFin, '%H:%i') as horaF,
        capacidad,((select count(*) from boleto b1 where f.idFuncion=b1.idFuncion and devuelto='NO')*100)/capacidad as porcentaje
         FROM pelicula p inner join funcion f on p.idPelicula = f.idPelicula
         inner join sala s on s.idSala = f.idSala where fecha ='$fecha'
         and f.activa='ACTIVADO' 
         and  p.idPelicula = ".$idpelicula." order by horaIn asc,nroSala asc";
        $query=$this->db->query($consulta);
        $row=$query->row();
        $myObj=($query->result_array());
        echo json_encode($myObj);
    }

    public function horario2(){
        $idfuncion=$_POST['idfun'];

        $consulta="SELECT t.idTarifa,serie,precio FROM funcion f  inner join funciontarifa ft on f.idFuncion = ft.idFuncion inner join tarifa t on t.idTarifa = ft.idTarifa where f.idFuncion =".$idfuncion;
        $query=$this->db->query($consulta);
        $row=$query->row();
        $myObj=($query->result_array());
        echo json_encode($myObj);
    }

    public function relleno(){
	    $query=$this->db->query("SELECT * FROM temporal WHERE idUser='".$_SESSION['idUs']."'");
        $t="";
	    foreach ($query->result() as $row){
	        $t=$t."<tr>
                            <th scope='row'>1</th>
                            <td>$row->fechaFuncion $row->horaFuncion</td>
                            <td>$row->titulo</td>
                            <td class='costo'>$row->costo</td>
                            <td><a class='btn btn-outline-danger btn-sm' href='".base_url()."VentaCtrl/deleteTemporal/$row->idTemporal'><i class='far fa-trash-alt'></i></a></td>                                                        
                        </tr>";
        }
        echo $t;
    }

    public function listafuncion(){
        $fecha=$_POST['fecha1'];
        $consulta="SELECT DISTINCT p.idPelicula,nombre,formato,
        (select count(*) from pelicula p1,funcion f1,boleto b1
        where p1.idPelicula=f1.idPelicula and b1.idFuncion=f1.idFuncion
        and date(b1.fechaFuncion)='$fecha' and f1.idPelicula=f.idPelicula and devuelto='NO') as totalp  
        from pelicula p inner join funcion f on p.idPelicula = f.idPelicula 
        where fecha ='$fecha' and activa='ACTIVADO'" ;

        $query=$this->db->query($consulta);
        $row=$query->row();
        $myObj=($query->result_array());
        echo json_encode($myObj);
    }

    public function datos(){
        $tabla=$_POST['tabla'];
        $where=$_POST['where'];
        $dato=$_POST['dato'];
        $query=$this->db->query("SELECT * FROM $tabla WHERE $where='$dato'");
        $myObj=($query->result_array());
        echo json_encode($myObj);
    }

    public function datos2(){
        $tabla=$_POST['tabla'];
        $where=$_POST['where'];
        $dato=$_POST['dato'];
        $query=$this->db->query("SELECT * FROM $tabla WHERE $where='$dato' ORDER BY fila,columna DESC ");
        $myObj=($query->result_array());
        echo json_encode($myObj);
    }

    public function boletoFuncion()
    {
        $idfuncion = $_POST['idfun'];
        $consulta="SELECT 
        (Select count(*) from boleto b1 where b1.idFuncion=$idfuncion and b1.devuelto='NO') as vendido,
        (Select count(*) from temporal where idFuncion=$idfuncion) as temp,
        (Select count(*) from boleto b1 where b1.idFuncion=$idfuncion and b1.devuelto='SI') as devuelto,
        (select capacidad from sala s, funcion f where idFuncion=$idfuncion and s.idSala = f.idSala) as ctotal 
        FROM dual";
                $query=$this->db->query($consulta);
                $row=$query->row();
                $myObj=($query->result_array());
                echo json_encode($myObj);

    }

    public function datosBoleto(){
        $idfuncion = $_POST['dato'];
        //$query=$this->db->query("SELECT * FROM boleto WHERE idFuncion="+$idfuncion);

        $consulta=" SELECT a.idAsiento,s.idSala,columna,fila,letra,activo, ";
        $consulta=$consulta."IF(((select count(*) from boleto b  where a.idAsiento = b.idAsiento and b.idFuncion= f.idFuncion) > 0 OR";
        $consulta=$consulta." (select count(*) from temporal tm where a.idAsiento = tm.idAsiento and tm.idFuncion= f.idFuncion) > 0), true, false) as asignado, f.nroFuncion ";
        $consulta=$consulta."FROM sala s, funcion f, asiento a ";
        $consulta=$consulta."where s.idSala = f.idSala and s.idSala = a.idSala and f.idFuncion = ".$idfuncion." ORDER BY fila,columna DESC";
        $consulta2="select count(*) from temporal b where a.idAsiento = b.idAsiento and b.idFuncion= f.idFuncion";
        $query=$this->db->query($consulta);
        $row=$query->row();
        $myObj=($query->result_array());
        echo json_encode($myObj);
    }

    public function insertTemporal(){
        $idAsiento=$_POST['idasiento'];
        $idfuncion=$_POST['idfuncion'];
        $idtarifa=$_POST['idtarifa'];
        $numeroFuncion=$_POST['numerofuncion'];
        $numeroSala=$_POST['numerosala'];
        $serieTarifa=$_POST['serietarifa'];
        $codSala=$_POST['codigosala'];
        $fechaFuncion=$_POST['fechafun'];
        $idUser=$this->session->userdata('idUs');
        $precio=$_POST['precio'];
        $columna=$_POST["columna"];
        $fila=$_POST["fila"];
        $titulo=$_POST["titulo"];
        $horaFuncion=$_POST["horafun"];
        if($this->verifTemporal($idfuncion,$idAsiento))
            echo 1;
        else{
        $insertar=" INSERT INTO temporal (idAsiento, idFuncion, numeroFuncion, numeroSala, serieTarifa, codSala, fechaFuncion, idUser, fila, columna, costo, titulo, horaFuncion, idTarifa) VALUES ";
        $insertar=$insertar." (".$idAsiento.",".$idfuncion.",".$numeroFuncion.",".$numeroSala.",'".$serieTarifa."',".$codSala.",'".$fechaFuncion."',".$idUser.",".$fila.",".$columna.",".$precio.",'".$titulo."','".$horaFuncion."','".$idtarifa."')";
        $this->db->query($insertar);
            echo 0;
        }
    }

    public function verifTemporal($idf,$ida)
    {
        $verif=$this->db->query("SELECT * FROM temporal where idAsiento=$ida and idFuncion=$idf");
        if ($verif->num_rows()>=1)
            return true;
        else {
            $verif2=$this->db->query("SELECT * FROM boleto where idAsiento=$ida and idFuncion=$idf");
            if($verif2->num_rows()>=1)
                return true;
                else
                return false;
                }

    }

    public function deleteTemporal($id){
        $this->Temporal_model->deleteTemp($id);
        header("Location: ".base_url()."VentaCtrl");
    }

    public function deleteTempAll(){
        $idUser=$this->session->userdata('idUs');
        $this->Temporal_model->deleteAll($idUser);


     header("Location: ".base_url()."VentaCtrl");
    }

    public function pruebadeleteTempAll(){
        $idUser=$this->session->userdata('idUs');
        $this->Temporal_model->deleteAll($idUser);
        echo "ok";
    }

    public function registrarVenta(){
        $cinit=$_POST['cinit'];
        $nombre=strtoupper($_POST['nombre']);
        $apellido=strtoupper($_POST['apellido']);
        $email=$_POST['email'];
        $telefono=$_POST['telefono'];
        $cliente= [
            'cinit'=> $cinit,
            'nombreCl'=> $nombre,
            'apellidoCl'=> $apellido,
            'email'=> $email,
            'telefono'=> $telefono
        ];
        $this->db->insert("cliente",$cliente);
        echo $this->db->insert_id();
        //eturn "aaa";
    }

    public function updatecliente(){
        $idcliente=$_POST['id'];
        $nombre=strtoupper($_POST['nombre']);
        $apellido=strtoupper($_POST['apellido']);
        $email=$_POST['email'];
        $telefono=$_POST['telefono'];
        $cliente= [
            'nombreCl'=> $nombre,
            'apellidoCl'=> $apellido,
            'email'=> $email,
            'telefono'=> $telefono
        ];
        $this->db->where('idCliente',$idcliente);
        $this->db->update("cliente",$cliente);
        echo true;
    }

    public function verdatoventa(){

        $idventa=$_POST['idventa'];

        $query=$this->db->query("SELECT * FROM venta v, cliente c, usuario u
        WHERE idVenta=$idventa and v.idCliente=c.idCliente and u.idUsuario=v.idUsuario
        ");
        $row=$query->row();
        $myObj=($query->result_array()[0]);

        echo json_encode($myObj);

    }


    public function generaqr($idventa){

        $cadena='';
        $query=$this->db->query("SELECT * FROM venta v
        INNER JOIn cliente c ON c.idCliente=v.idCliente
        WHERE v.idVenta=$idventa
        ");

        $row=$query->result()[0];
        $cadena=$row->idVenta.'|'.$row->cinit.'|'.$row->apellidoCl.' '.$row->nombreCl;
        $query2=$this->db->query("SELECT * FROM boleto b 
        INNER JOIn usuario u ON b.idUsuario=u.idUsuario
        INNER JOIn funcion f ON f.idFuncion=b.idFuncion
        INNER JOIn pelicula p ON p.idPelicula=f.idPelicula
        INNER JOIn sala s ON s.idSala=f.idSala
        INNER JOIn tarifa t ON t.idTarifa=b.idTarifa
        INNER JOIn asiento a ON a.idAsiento=b.idAsiento
        WHERE b.idVenta=$idventa and devuelto='NO'");
        $funcion='';
        foreach ($query2->result() as $res){
            if($funcion==$res->idFuncion)
            {

                $cadena.='|'.$res->letra.'-'.$res->columna;
            }
            else{
                $cadena.='|';
                $cadena.=$res->titulo.'|'.$res->fechaFuncion.'|'.$res->horaFuncion.'|';
                $cadena.=$res->letra.'-'.$res->columna;

            }
            $funcion=$res->idFuncion;
        }
        $generator = new barcode_generator();

        ($generator->output_image('png', 'qrl', $cadena,'bc'));
        //echo '';


    }

    public function cControl(){

        $nautorizacion=$_POST['numeroa'];
        $nroFact=$_POST["nroFact"];
        $cinit=$_POST["cinit"];
        $fecVenta=$_POST["fecha"];
        $monto=$_POST["total"];
        $kDosif=$_POST["llave"];

        //echo $nautorizacion.$nroFact.$cinit.$fecVenta.$monto.$kDosif;
       echo $this->Ventas_model->generate($nautorizacion,$nroFact,$cinit,$fecVenta,$monto,$kDosif);  // This calls the creation of ajax methods
       //echo "aa";
    }

    public function cControlprueba($nautorizacion,$nroFact,$cinit,$fecVenta,$monto,$kDosif){

       echo $this->Ventas_model->generate($nautorizacion,$nroFact,$cinit,$fecVenta,$monto,$kDosif);  // This calls the creation of ajax methods
    }

    public function regVenta(){
        $total=$_POST['total'];
        $codControl=$_POST['ccontrol'];
        $codqr=$_POST['codigoqr'];
        $tipo=$_POST['tipo'];
        $idu=$this->session->userdata('idUs');
        $idCl=$_POST['idCliente'];
        $idd=$_POST['iddosif'];
        $idcupon=$_POST['cupon'];
        $cupon='null';
        $cancelado=$_POST['cancelado'];
        $codigotarjeta=$this->hexToStr($_POST['codigotarjeta']);
        if($codigotarjeta!='' && strlen($codigotarjeta)>0) {$descuento=0.8; $tarjeta="SI";}
        else {$descuento=1; $tarjeta="NO";}
        $costo2=0;
        if(is_numeric($idcupon) && $idcupon != 0 && $idcupon !='')
        { $total=0;
          $cupon=$idcupon;
        }
        else $cupon='null';
        if($codControl!='' && $codqr!='' && $tipo=='RECIBO')
            $tipo='FACTURA';
        if($tipo=='FACTURA'){

            $this->Dosificaciones_model->updatenfactura($idd);
        $query=$this->db->query("SELECT idDosif,nroFactura from dosificacion where tipo='BOLETERIA' AND activo=1 ORDER BY idDosif DESC");
        $row=$query->row();
        $nroComprobante=$row->nroFactura;
        $anterior=$nroComprobante - 1;
        if($anterior>0){
            $query8=$this->db->query("SELECT * FROM venta where tipoVenta='FACTURA' and nroComprobante=$anterior and idDosif=$idd");
            $nfact=$query8->num_rows();
        }
        else $nfact=1;
        if($nfact >= 1){
            $query="INSERT INTO venta(
                total,
                codigoControl,
                codigoQR,
                nroComprobante,
                tipoVenta,
                idUsuario,
                idCliente,
                idDosif,
                idCupon,
                cancelado,
                tarjeta) VALUES (
                    '$total',
                    '$codControl',
                    '$codqr',
                    '$nroComprobante',
                    '$tipo',
                    '$idu',
                    '$idCl',
                    '$idd',
                    $cupon,
                    $cancelado,
                    '$tarjeta')";
        $this->db->query($query);
        if($this->db->affected_rows()==0){
            $idVenta=$this->Dosificaciones_model->errorenfactura($idd);
            }
        else
        $idVenta=$this->db->insert_id();
        }
        else{
            $idVenta=$this->Dosificaciones_model->errorenfactura($idd);

        }
       // $query.= ",'".$codControl."','".$codqr."',(SELECT nroFactura from dosificacion where tipo='BOLETERIA' AND activo=1)";

    }
        else{
            $query=$this->db->query("SELECT max(nroComprobante)+1 as numero from venta where tipoVenta='RECIBO'");
        $row=$query->row();
        $nroComprobante=$row->numero;
            $query="INSERT INTO venta(
                total,
                codigoControl,
                codigoQR,
                nroComprobante,
                tipoVenta,
                idUsuario,
                idCliente,
                idDosif,
                idCupon,
                cancelado,
                tarjeta) VALUES (
                    '$total',
                    '',
                    '',
                    '$nroComprobante',
                    '$tipo',
                    '$idu',
                    '$idCl',
                    '$idd',
                    $cupon,
                    $cancelado,
                    '$tarjeta')";
        $this->db->query($query);
        if($this->db->affected_rows()>0)
        $idVenta=$this->db->insert_id();
        else
        $idVenta=0;

        }
        if($idVenta!=0){
        $query=$this->db->query("SELECT * FROM `temporal` WHERE `idUser`='$idu'");
        // echo $idVenta;


        foreach($query->result() as $row){
            if(is_numeric($idcupon) && $idcupon != 0 && $idcupon !='')
                $costo2=0;
              else $costo2=$row->costo * $descuento;

            $numsala = $row->numeroSala;
            $codigosala = $row->codSala;
            $originalDate = $row->fechaFuncion;
            $fechafuncion = date("Ymd", strtotime($originalDate));
            $nfuncion = $row->numeroFuncion;
            $serietarifa = $row->serieTarifa;
            $query2=$this->db->query("SELECT count(*) + 1 as num FROM boleto WHERE idFuncion='$row->idFuncion'");
            $numboleto=$query2->row()->num;
            $numboc="$numsala$codigosala$fechafuncion$nfuncion$serietarifa-$numboleto";
            $this->db->query("INSERT INTO `boleto` (
             `numboc`,
              `numero`,
              `idFuncion`, 
              `idUsuario`, 
              `idAsiento`, 
              `numeroFuncion`, 
              `numeroSala`, 
              `serieTarifa`, 
              `codigoSala`, 
              `fechaFuncion`, 
              `horaFuncion`, 
              `fila`, 
              `columna`, 
              `costo`, 
              `titulo`, 
              `idVenta`,
              `idCupon`,
              `tipoCompra`,
              `idTarifa`,
              `tarjeta`) VALUES (
                  '$numboc', 
                  '$numboleto',
                  '$row->idFuncion', 
                  '$idu', 
                  '$row->idAsiento', 
                  '$nfuncion', 
                  '$numsala', 
                  '$serietarifa', 
                  '$codigosala', 
                  '$originalDate', 
                  '$row->horaFuncion', 
                  '$row->fila', 
                  '$row->columna', 
                  '$costo2', 
                  '$row->titulo', 
                  '$idVenta',
                  $cupon,
                  '$tipo',
                  '$row->idTarifa',
                  '$tarjeta');");
        };
        //header("Location inde.php");

        $idUser=$this->session->userdata('idUs');
        $this->Temporal_model->deleteAll($idUser);
        $conn = mysqli_connect("165.227.143.191", "myuser", "ORRKWKtehUul1p4z", "tarjetaplaza");
        // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $result = $conn->query("SELECT * from cliente where codigo='$codigotarjeta'");
                if ($result->num_rows > 0) {

                    while($row = $result->fetch_assoc()) {
        //                echo $row["nombre"];
        //                return json_encode($row);
                        $conn->query("UPDATE cliente SET saldo=saldo-$total where codigo='$codigotarjeta'");
                        $conn->query("INSERT INTO historial SET fecha='".date('Y-m-d')."',lugar='BOLETERIA',monto='$total',numero='$idVenta',cliente_id='".$row["id"]."'");
                    }
                    // output data of each row

                } else {
                    echo "0";
                }
                $conn->close();
    }
        echo $idVenta;

    }


    function imprimirfactura($idventa){
        $fecha=date('d/m/Y');
        $total=0;
        $hora=date("H:i:s");
        $query=$this->db->query("SELECT * FROM venta v 
INNER JOIn cliente c ON v.idCliente=c.idCliente 
INNER JOIn usuario u ON v.idUsuario=u.idUsuario
INNER JOIn dosificacion d ON d.idDosif=v.idDosif
WHERE idVenta='$idventa'");
        $row=$query->row();
        $nombre=$row->nombreCl;

        $apellido=$row->apellidoCl;
        $ci=$row->cinit;
        $nrocomprobante=$row->nroComprobante;

        $nroautorizacion=$row->nroAutorizacion;
        $vendero=$row->user;
        $codigocontrol=$row->codigoControl;
        $fechahasta=$row->fechaHasta;
        $leyenda=$row->leyenda;
        $fecha=$row->fechaVenta;
        $qr=$row->codigoQR;

        $cancelado=$row->cancelado;
        $cadena = "
        <style>.textoimp{ font-size: small; text-align: center;} 
        .textor{ font-size: small; text-align: right;}
        .margen{padding: 0px 15px 0px 15px} 
        .textmed{ font-size: small; text-align: left;}
        table{border: 1px solid #000; text-align:center; align:center; } 
        th,td{font-size: x-small;}
        hr{border: 1px dashed ;}</style>

        <div class='textoimp margen'>
        <span>MULTISALAS S.R.L.</span><br>
        <span>CASA MATRIZ</span><br>
        <span>Av. Tacna y Jaen - Oruro - Bolivia</span><br>
        <span>Tel: 591-25281290</span><br>
        <span>ORURO - BOLIVIA</span><br>
        <hr>
        <span>FACTURA</span><br>
        <span>NIT: 329448023</span><br>
        <span>Nro FACTURA:$nrocomprobante</span><br>
        <span>Nro AUTORIZACION: $nroautorizacion</span><br>
        <hr>
        ";
        $cadena.="<div class='textmed'>Fecha: $fecha<br>
        Señor(es): $nombre $apellido <br>
        NIT/CI: $ci <br>
        <hr>
       CANT &nbsp;&nbsp;&nbsp;DESCRIPCION &nbsp;&nbsp;&nbsp;P.U. &nbsp;&nbsp;&nbsp;IMP. <br>";


        $query=$this->db->query("SELECT b.idFuncion, p.nombre,p.formato,b.costo as precio,COUNT(*) as cantidad  
FROM boleto b 
INNER JOIN funcion f ON f.idFuncion=b.idFuncion
INNER JOIN tarifa t ON t.idTarifa=b.idTarifa 
INNER JOIN pelicula p ON p.idPelicula=f.idPelicula 
WHERE idVenta='$idventa'
GROUP BY b.idFuncion,p.nombre,p.formato,t.precio");
        foreach ($query->result() as $row){
            $nombrepelicula=$row->nombre;
            $formato=$row->formato;
            $precio=$row->precio;
            $cantidad=$row->cantidad;
            $subtotal=$cantidad*$precio;
            if ($formato==1){
                $for="3D";
            }else{
                $for="2D";
            }
            $cadena.=("$nombrepelicula <br>");
            $cadena.=( "$cantidad  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;formato: $for         &nbsp;&nbsp;&nbsp;$precio     &nbsp;&nbsp;&nbsp;$subtotal   <br>");
            $total=$total+$subtotal;
        }
        $total=number_format($total,2);
        $d = explode('.',$total);
        $entero=$d[0];
        $decimal=$d[1];
        $cadena.=("</div>");

        $cadena.=("<div class='textor'>SUBTOTAL: $total Bs.<br>");
        //$cadena.=("DESC:   0.00 Bs.<br>");
        $cadena.=("TOTAL: $total Bs.</div>");


        $cadena.="<div class='textmed'>SON: ".NumerosEnLetras::convertir($entero)." $decimal/100 Bolivianos 
<hr>
Cod. de Control: $codigocontrol <br> 
Fecha Lim. de Emision: ". date("d/m/Y", strtotime($fechahasta)) ."<br></div>";


//        $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
//        $PNG_WEB_DIR = 'temp/';
//        $filename = $PNG_TEMP_DIR.'test.png';
//        $errorCorrectionLevel = 'L';
//        $matrixPointSize = 2;
//        QRcode::png($qr, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
//        QRcode::png('PHP QR Code :)', $filename, $errorCorrectionLevel, $matrixPointSize, 2);
        //$cadena.='<img  id="img" src="temp/test.png" /> <br>';
        $barcode = new \Com\Tecnick\Barcode\Barcode();

        $bobj = $barcode->getBarcodeObj(
            'QRCODE',                     // Tipo de Barcode o Qr
            $qr,          // Datos
            -5,                             // Width
            -5,                             // Height
            'black',                        // Color del codigo
            array(-2, -2, -2, -2)           // Padding
        )->setBackgroundColor('white'); // Color de fondo

        $imageData = $bobj->getPngData(); // Obtenemos el resultado en formato PNG

        file_put_contents('qrcode.png', $imageData); // Guardamos el resultado
    $cadena.='<small class="textoimp"><img width="125px" src="'.base_url().'qrcode.png"></small><br>';
$cadena.="<small> ESTA FACTURA CONTRIBUYE AL DESARROLLO DEL PAIS. EL USO ILICITO DE ESTA SERA SANCIONADO DE ACUERDO A LEY <br>
</small>";
$cadena.="<div class='textoimp'> <span>$leyenda</span></div>";
$cadena.="<div class='textmed'> <span> PUNTO: ".gethostname()."</span></div>";
$cadena.="<div class='textmed'> <span> USUARIO: $vendero</span></div>";
$cadena.="<div class='textmed'> <span> NUMERO: $idventa</span></div>";
if(($cancelado-$total)<0)
$salida=0;
else $salida=$cancelado-$total;
        $cadena.="<div class='textmed'> <span> VUELTO: ".($salida)."</span></div></div>";

        echo $cadena;


    }

    function reimprimirfactura($idventa){
        $fecha=date('d/m/Y');
        $total=0;
        $hora=date("H:i:s");
        $query=$this->db->query("SELECT * FROM venta v 
INNER JOIn cliente c ON v.idCliente=c.idCliente 
INNER JOIn usuario u ON v.idUsuario=u.idUsuario
INNER JOIn dosificacion d ON d.idDosif=v.idDosif
WHERE idVenta='$idventa'");
        $row=$query->row();
        $nombre=$row->nombreCl;

        $apellido=$row->apellidoCl;
        $ci=$row->cinit;
        $nrocomprobante=$row->nroComprobante;

        $nroautorizacion=$row->nroAutorizacion;
        $vendero=$row->user;
        $codigocontrol=$row->codigoControl;
        $fechahasta=$row->fechaHasta;
        $leyenda=$row->leyenda;
        $fecha=$row->fechaVenta;
        $qr=$row->codigoQR;

        $cancelado=$row->cancelado;
        $cadena = "
        <style>.textoimp{ font-size: small; text-align: center;} 
        .textor{ font-size: small; text-align: right;}
        .margen{padding: 0px 15px 0px 15px} 
        .textmed{ font-size: small; text-align: left;}
        table{border: 1px solid #000; text-align:center; align:center; } 
        th,td{font-size: x-small;}
        hr{border: 1px dashed ;}</style>

        <div class='textoimp margen'>
        <span>MULTISALAS S.R.L.</span><br>
        <span>CASA MATRIZ</span><br>
        <span>Av. Tacna y Jaen - Oruro - Bolivia</span><br>
        <span>Tel: 591-25281290</span><br>
        <span>ORURO - BOLIVIA</span><br>
        <hr>
        <span>FACTURA</span><br>
        <span>NIT: 329448023</span><br>
        <span>Nro FACTURA:$nrocomprobante</span><br>
        <span>Nro AUTORIZACION: $nroautorizacion</span><br>
        <hr>
        ";
        $cadena.="<div class='textmed'>Fecha: $fecha<br>
        Señor(es): $nombre $apellido <br>
        NIT/CI: $ci <br>
        <hr>
       CANT &nbsp;&nbsp;&nbsp;DESCRIPCION &nbsp;&nbsp;&nbsp;P.U. &nbsp;&nbsp;&nbsp;IMP. <br>";


        $query=$this->db->query("SELECT b.idFuncion, p.nombre,p.formato,b.costo as precio,COUNT(*) as cantidad 
FROM boleto b 
INNER JOIN funcion f ON f.idFuncion=b.idFuncion
INNER JOIN tarifa t ON t.idTarifa=b.idTarifa 
INNER JOIN pelicula p ON p.idPelicula=f.idPelicula 
WHERE idVenta='$idventa'
GROUP BY b.idFuncion,p.nombre,p.formato,t.precio");
        foreach ($query->result() as $row){
            $nombrepelicula=$row->nombre;
            $formato=$row->formato;
            $precio=$row->precio;
            $cantidad=$row->cantidad;
            $subtotal=$cantidad*$precio;
            if ($formato==1){
                $for="3D";
            }else{
                $for="2D";
            }
            $cadena.=("$nombrepelicula <br>");
            $cadena.=( "$cantidad  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;formato: $for         &nbsp;&nbsp;&nbsp;$precio     &nbsp;&nbsp;&nbsp;$subtotal   <br>");
            $total=$total+$subtotal;
        }



        $total=number_format($total,2);
        $d = explode('.',$total);
        $entero=$d[0];
        $decimal=$d[1];
        $cadena.=("</div>");

        $cadena.=("<div class='textor'>SUBTOTAL: $total Bs.<br>");
        //$cadena.=("DESC:   0.00 Bs.<br>");
        $cadena.=("TOTAL: $total Bs.</div>");


        $cadena.="<div class='textmed'>SON: ".NumerosEnLetras::convertir($entero)." $decimal/100 Bolivianos 
<hr>
Cod. de Control: $codigocontrol <br> 
Fecha Lim. de Emision: ". substr($fechahasta,0,10) ."<br></div>";


//        $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
//        $PNG_WEB_DIR = 'temp/';
//        $filename = $PNG_TEMP_DIR.'test.png';
//        $errorCorrectionLevel = 'L';
//        $matrixPointSize = 2;
//        QRcode::png($qr, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
//        QRcode::png('PHP QR Code :)', $filename, $errorCorrectionLevel, $matrixPointSize, 2);
        //$cadena.='<img  id="img" src="temp/test.png" /> <br>';
    $cadena.="<small class='textoimp'><img width='125px' src='".base_url()."barcode.php?s=qrl&d=$qr'></small><br>";

$cadena.="<small> ESTA FACTURA CONTRIBUYE AL DESARROLLO DEL PAIS. EL USO ILICITO DE ESTA SERA SANCIONADO DE ACUERDO A LEY <br>
</small>";
$cadena.="<div class='textoimp'> <span>$leyenda</span></div>";
$cadena.="<div class='textmed'> <span> PUNTO: ".gethostname()."</span></div>";
$cadena.="<div class='textmed'> <span> USUARIO: $vendero</span></div>";
$cadena.="<div class='textmed'> <span> NUMERO: $idventa</span></div>";
if(($cancelado-$total)<0)
$salida=0;
else $salida=$cancelado-$total;
        $cadena.="<div class='textmed'> <span> VUELTO: ".($salida)."</span></div></div>";

        echo $cadena;
        exit;


    }

    public function listaVenta(){
        if($this->session->userdata('login')==1){

            $user = $this->session->userdata('idUs');
            $dato=$this->Usuarios_model->validaIngreso($user);
            if( empty($_POST['fecini']) || empty($_POST['fecfin']))
                {
                    $venta['fecinicio'] = date('Y-m-d');
                    $venta['fecfinal']= date('Y-m-d'); }

            else {
            $venta['fecinicio'] = $_POST['fecini'];
            $venta['fecfinal']=$_POST['fecfin'];}
            $this->load->view('templates/header', $dato);
                $this->load->view('listadoventa',$venta);
                $dato2['js']="<script src='".base_url()."assets/js/listaventa.js'></script>";
                $this->load->view('templates/footer',$dato2);
        }
        else redirect('');

    }

    public function listaDev(){
        if($this->session->userdata('login')==1){

            $user = $this->session->userdata('idUs');
            $dato=$this->Usuarios_model->validaIngreso($user);
            $this->load->view('templates/header', $dato);
                $this->load->view('listadodevolucion');
                $dato2['js']="<script></script>";
                $this->load->view('templates/footer',$dato2);
        }
        else redirect('');

    }

public function printF($idventa){

    $fecha=date('d/m/Y');
    $total=0;
    $hora=date("H:i:s");
    $query=$this->db->query("SELECT * FROM venta v 
INNER JOIn cliente c ON v.idCliente=c.idCliente 
INNER JOIn usuario u ON v.idUsuario=u.idUsuario
INNER JOIn dosificacion d ON d.idDosif=v.idDosif
WHERE idVenta='$idventa'");
    $row=$query->row();
    $nombre=$row->nombreCl;

    $apellido=$row->apellidoCl;
    $ci=$row->cinit;
    $nrocomprobante=$row->nroComprobante;

    $nroautorizacion=$row->nroAutorizacion;
    $vendero=$row->user;
    $codigocontrol=$row->codigoControl;
    $fechahasta=$row->fechaHasta;
    $leyenda=$row->leyenda;
    $fecha=$row->fechaVenta;
    $qr=$row->codigoQR;


    $nombre_impresora = "POS";


    $connector = new WindowsPrintConnector($nombre_impresora);
    $printer = new Printer($connector);

    /* Initialize */
    $printer -> initialize();

    /* Text */
//$printer -> text("Hello world\n");
//$printer -> cut();
    // set some text to print

    $ca = "MULTISALAS S.R.L.
Av. Tacna y Jaen - Oruro -Bolivia
 Tel: 591-25281290
ORURO - BOLIVIA
CAZA MATRIZ
-------------------------------
FACTURA
NIT: 329448023
NRO FACTURA:$nrocomprobante
NRO AUTORIZACION: $nroautorizacion
-----------------------------------------------
";
    $printer -> setJustification(Printer::JUSTIFY_CENTER);
    $printer->text($ca);


    $printer -> setJustification(Printer::JUSTIFY_LEFT);
    $html = "Fecha: ".$fecha."
Señor(es): $nombre $apellido
NIT/CI: $ci ";
    $printer -> text($html."\n");

    $query=$this->db->query("SELECT b.idFuncion, p.nombre,p.formato,t.precio,COUNT(*) as cantidad 
FROM boleto b 
INNER JOIN funcion f ON f.idFuncion=b.idFuncion
INNER JOIN tarifa t ON t.idTarifa=b.idTarifa 
INNER JOIN pelicula p ON p.idPelicula=f.idPelicula 
WHERE idVenta='$idventa'
GROUP BY b.idFuncion,p.nombre,p.formato,t.precio");
    $printer->setJustification(Printer::JUSTIFY_LEFT);
    $printer->text("CANT       DESCRIPCION       P.U.     IMP.\n");
    $printer->text("---------------------------------------------"."\n");
    foreach ($query->result() as $row){
        $nombrepelicula=$row->nombre;
        $formato=$row->formato;
        $precio=$row->precio;
        $cantidad=$row->cantidad;
        $subtotal=$cantidad*$precio;
        if ($formato==1){
            $for="3D";
        }else{
            $for="2D";
        }
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("$nombrepelicula \n");
        $printer->text( "    $cantidad  formato: $for         $precio     $subtotal   \n");
        $total=$total+$subtotal;

    }
    $total=number_format($total,2);
    $d = explode('.',$total);
    $entero=$d[0];
    $decimal=$d[1];
    $printer->text("-----------------------------------"."\n");
    $printer->setJustification(Printer::JUSTIFY_RIGHT);
    $printer->text("SUBTOTAL: $total Bs.\n");
    $printer->text("DESC:   0.00 Bs.\n");
    $printer->text("TOTAL: $total Bs.\n");

    $printer->setJustification(Printer::JUSTIFY_LEFT);

    $html="SON: ".NumerosEnLetras::convertir($entero)." $decimal/100 Bs.
------------------------------------------
Cod. de Control: $codigocontrol 
Fecha Lim. de Emision: ". substr($fechahasta,0,10);

    $printer -> text($html."\n");

    $printer -> setJustification(Printer::JUSTIFY_CENTER);
    $testStr = $qr;
    $models = array(
        //Printer::QR_MODEL_1 => "QR Model 1",
        Printer::QR_MODEL_2 => "ESTA FACTURA CONTRIBUYE AL DESARROLLO DEL PAIS. EL USO ILICITO DE ESTA SERA SANCIONADO DE ACUERDO A LEY"
        //Printer::QR_MICRO => "Micro QR code\n(not supported on all printers)"
    );
    foreach ($models as $model => $name) {
        $printer -> qrCode($testStr, Printer::QR_ECLEVEL_L, 4, $model);
        $printer -> text("$name\n");
        $printer -> feed();
    }
    $printer->setJustification(Printer::JUSTIFY_LEFT);
    $printer->text($leyenda."\n");
    $printer->text("PUNTO: ".gethostname()." \n");
    $printer->text("USUARIO: $vendero \n");
    $printer->text("NUMERO: $idventa \n");

    $printer -> cut();

$query=$this->db->query("SELECT * FROM venta v 
INNER JOIn usuario u ON v.idUsuario=u.idUsuario
INNER JOIn boleto b ON b.idVenta=v.idVenta
INNER JOIn funcion f ON f.idFuncion=b.idFuncion
INNER JOIn pelicula p ON p.idPelicula=f.idPelicula
INNER JOIn sala s ON s.idSala=f.idSala
INNER JOIn tarifa t ON t.idTarifa=b.idTarifa
INNER JOIn asiento a ON a.idAsiento=b.idAsiento
WHERE v.idVenta='$idventa'");
    foreach ($query->result() as $row) {

        if ($row->formato == 1) {
            $for = "3D";
        } else {
            $for = "2D";
        }

        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer -> selectPrintMode(Printer::MODE_DOUBLE_HEIGHT);
        $printer->text("\n"."MULTIPLAZA S.R.L." . "\n");
        $printer -> selectPrintMode(Printer::MODE_FONT_B);
        $printer->text("NIT:329448023" . "\n");
        $printer->text("-----------------------------------" . "\n");
        $printer -> selectPrintMode(Printer::MODE_DOUBLE_HEIGHT);
        $printer->text($row->titulo . "\n");
        $printer->text($row->nombreSala . "\n");
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer -> selectPrintMode(Printer::MODE_DOUBLE_HEIGHT);
        $printer->text("Fecha:".$row->fechaFuncion ."Hora: ".substr( $row->horaFuncion,0,5) . "  Bs. $row->precio\n");

        $printer->text("Butaca:".$row->letra."-".$row->columna."\n");
        $printer->text("-----------------------------------" . "\n");
        $printer->text("Cod:".$row->numboc . "\n");
        $printer->text("Trans: ".$idventa."\n");
        $printer->text("Usuario: ".$row->user."\n");
        $printer -> cut();
        $html = '
<b>Fecha:</b> ' . $row->fechaFuncion . '<br>
<b>Hora:</b> ' . $row->horaFuncion . '     <b>Bs.:</b> ' . $row->precio . '.- <br>
<b>Butaca:</b> ' . $row->letra . '-' . $row->columna . '
------------------------------------
Cód.:' . $row->numboc . ' <br>
Trans:' . $idventa . '<br>
Usuario:' . $row->user . '<br>
';

/*pdf->writeHTML($html, false, false, false, false, ''); //Salida PDF
$pdf->Output('reporte.pdf', 'I'); */


    }

    /* Pulse */
    //$printer -> pulse();

    /* Always close the printer! On some PrintConnectors, no actual
     * data is sent until the printer is closed. */
    $printer -> close();
    header("Location: ".base_url()."VentaCtrl");
    //header();
}

public function printR($idventa){

        $fecha=date('d/m/Y');
        $total=0;
        $hora=date("H:i:s");
        $query=$this->db->query("SELECT * FROM venta v 
INNER JOIn cliente c ON v.idCliente=c.idCliente 
INNER JOIn usuario u ON v.idUsuario=u.idUsuario
INNER JOIn dosificacion d ON d.idDosif=v.idDosif
WHERE idVenta='$idventa'");
        $row=$query->row();
        $nombre=$row->nombreCl;
        $fechaVenta=$row->fechaVenta;

        $apellido=$row->apellidoCl;
        $ci=$row->cinit;
        $nrocomprobante=$row->nroComprobante;

        $nroautorizacion=$row->nroAutorizacion;
        $vendero=$row->user;
        $codigocontrol=$row->codigoControl;
        $fechahasta=$row->fechaHasta;
        $leyenda=$row->leyenda;
        $qr=$row->codigoQR;


        $nombre_impresora = "POS";


        $connector = new WindowsPrintConnector($nombre_impresora);
        $printer = new Printer($connector);

        /* Initialize */
        $printer -> initialize();

        /* Text */
//$printer -> text("Hello world\n");
//$printer -> cut();
        // set some text to print
/*
        $ca = "MULTI CINES PLAZA SRL.
Av. Tacna y Jaen - Oruro -Bolvia
SUCURSAL N: 0
Tel: 591-25281290
ORDEN CANCELADA
";
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer->text($ca);


        $printer -> setJustification(Printer::JUSTIFY_LEFT);
        $html = "Fecha: ".date('d/m/Y')." Hora:". $hora."
Señor(es): $nombre $apellido
NIT/CI: $ci ";

        $html = "
Fecha: ".$fechaVenta."
Nombre Cliente: $nombre $apellido
NIT Cliente: $ci ";


        $printer -> text($html."\n");

        $query=$this->db->query("SELECT b.idFuncion, p.nombre,p.formato,t.precio,COUNT(*) as cantidad,(select v2.idCupon FROM venta v2 WHERE v2.idVenta='$idventa') as idCupon
FROM boleto b
INNER JOIN funcion f ON f.idFuncion=b.idFuncion
INNER JOIN tarifa t ON t.idTarifa=b.idTarifa
INNER JOIN pelicula p ON p.idPelicula=f.idPelicula
WHERE idVenta='$idventa'
GROUP BY b.idFuncion,p.nombre,p.formato,t.precio");

        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("CANT    DESCRIPCION      P.U    IMP.\n");
        $printer->text("-----------------------------------"."\n");
        foreach ($query->result() as $row){
            $idcupon=$row->idCupon;
            $nombrepelicula=$row->nombre;
            $formato=$row->formato;
            $precio=$row->precio;
            $cantidad=$row->cantidad;
            echo $idcupon;
            if ($idcupon!=null){
                $precio=0;
                $subtotal=$cantidad*$precio;
            }else{
                $subtotal=$cantidad*$precio;
            }
            if ($formato==1){
                $for="3D";
            }else{
                $for="2D";
            }
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("$nombrepelicula \n");
            $printer->text( "    $cantidad  formato: $for         $precio     $subtotal   \n");
            $total=$total+$subtotal;

        }
        $total=number_format($total,2);
        $d = explode('.',$total);
        $entero=$d[0];
        $decimal=$d[1];
        $printer->text("-----------------------------------"."\n");
        $printer->setJustification(Printer::JUSTIFY_RIGHT);
        $printer->text("SUBTOTAL: $total Bs.\n");
        $printer->text("DESC:   0.00 Bs.\n");
        $printer->text("TOTAL: $total Bs.\n");

        $printer->setJustification(Printer::JUSTIFY_LEFT);

        $html="SON: ".NumerosEnLetras::convertir($entero)." $decimal/100 Bs.
------------------------------------------
";

        $printer -> text($html."\n");
        $printer->setJustification(Printer::JUSTIFY_LEFT);
  //      $printer->text($leyenda."\n");
        $printer->text("PUNTO: ".gethostname()." \n");
        $printer->text("USUARIO: $vendero \n");
        $printer->text("NUMERO: $idventa \n");

        $printer -> cut();
*/
        /*IMPRESION DE BOLETOS*/
        $query=$this->db->query("SELECT * FROM venta v 
INNER JOIn usuario u ON v.idUsuario=u.idUsuario
INNER JOIn boleto b ON b.idVenta=v.idVenta
INNER JOIn funcion f ON f.idFuncion=b.idFuncion
INNER JOIn pelicula p ON p.idPelicula=f.idPelicula
INNER JOIn sala s ON s.idSala=f.idSala
INNER JOIn tarifa t ON t.idTarifa=b.idTarifa
INNER JOIn asiento a ON a.idAsiento=b.idAsiento
WHERE v.idVenta='$idventa'");
$contador=0;
        foreach ($query->result() as $row) {

            if ($row->formato == 1) {
                $for = "3D";
            } else {
                $for = "2D";
            }

            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer -> selectPrintMode(Printer::MODE_DOUBLE_HEIGHT);
            $printer->text("\n"."MULTISALAS S.R.L." . "\n");
            $printer -> selectPrintMode(Printer::MODE_FONT_B);
            $printer->text("NIT:329448023" . "\n");
            $printer->text("-----------------------------------" . "\n");
            $printer -> selectPrintMode(Printer::MODE_DOUBLE_HEIGHT);
            $printer->text($row->titulo . "\n");
            $printer->text($row->nombreSala . "\n");
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer -> selectPrintMode(Printer::MODE_DOUBLE_HEIGHT);
            $printer->text("Fecha:".$row->fechaFuncion . "  Bs. $row->precio\n");

            $printer->text("Butaca:".$row->letra."-".$row->columna. " Hora: ".substr( $row->horaFuncion,0,5). "\n");
            $printer->text("-----------------------------------" . "\n");
            $printer -> selectPrintMode(Printer::MODE_FONT_B);
            $printer->text("Cod:".$row->numboc . "\n");
            $printer->text("Trans: ".$idventa."\n");
            $printer->text("Usuario: ".$row->nombreUser."\n");
            $printer -> cut();
            if($row->promo=='on')
            {
                $contador++;
                if($contador==2)
                {
                    $contador=0;
                    $printer->setJustification(Printer::JUSTIFY_CENTER);
                    $printer -> selectPrintMode(Printer::MODE_DOUBLE_HEIGHT);
                    $printer->text("\n"."MULTISALAS S.R.L." . "\n");
                    $printer -> selectPrintMode(Printer::MODE_FONT_B);
                    $printer->text("NIT:329448023" . "\n");
                    $printer->text("-----------------------------------" . "\n");
                    $printer -> selectPrintMode(Printer::MODE_DOUBLE_HEIGHT);
                    $printer->text("COMBO DUO \n");
                    $printer -> selectPrintMode(Printer::MODE_FONT_B);
                    $printer->text("-----------------------------------" . "\n");
                    $printer->text("Reclame su combo duo \n");
                    $printer -> selectPrintMode(Printer::MODE_DOUBLE_HEIGHT);
                    $printer->text("1 PIPOCA + 2 REFRESCOS " . "\n");
                    $printer -> selectPrintMode(Printer::MODE_FONT_B);
                    $printer->text("-----------------------------------" . "\n");
                    $printer->setJustification(Printer::JUSTIFY_LEFT);
                    $printer->text("Cod:".$row->numboc . "\n");
                    $printer->text("Trans: ".$idventa."\n");
                    $printer->text("Usuario: ".$row->nombreUser."\n");
                    $printer -> cut();
                }
            }
            $html = '
<b>Fecha:</b> ' . $row->fechaFuncion . '<br>
<b>Hora:</b> ' . $row->horaFuncion . '     <b>Bs.:</b> ' . $row->precio . '.- <br>
<b>Butaca:</b> ' . $row->letra . '-' . $row->columna . '
------------------------------------
Cód.:' . $row->numboc . ' <br>
Trans:' . $idventa . '<br>
Usuario:' . $row->user . '<br>
';

            /*pdf->writeHTML($html, false, false, false, false, ''); //Salida PDF
            $pdf->Output('reporte.pdf', 'I'); */


        }

        /* Pulse */
        //$printer -> pulse();

        /* Always close the printer! On some PrintConnectors, no actual
         * data is sent until the printer is closed. */
        $printer -> close();
        header("Location: ".base_url()."VentaCtrl");
        //header();
    }
    public function imprimirboletos($idventa){
        $query=$this->db->query("SELECT * FROM boleto WHERE idVenta='$idventa'");
        echo json_encode($query->result_array());
    }
public function impBoleto($idboleto){
    $query=$this->db->query("SELECT * FROM boleto b 
    INNER JOIn usuario u ON b.idUsuario=u.idUsuario
    INNER JOIn funcion f ON f.idFuncion=b.idFuncion
    INNER JOIn pelicula p ON p.idPelicula=f.idPelicula
    INNER JOIn sala s ON s.idSala=f.idSala
    INNER JOIn tarifa t ON t.idTarifa=b.idTarifa
    INNER JOIn asiento a ON a.idAsiento=b.idAsiento
    WHERE b.idBoleto='$idboleto'");
            $row=$query->result()[0];

                if ($row->formato == 1) {
                    $for = "3D";
                } else {
                    $for = "2D";
                }
                $cadBoleto="<div align='center' style='padding: 0px 15px 0px 15px;'>";
                $cadBoleto.="MULTISALAS S.R.L. <br>"  ;
                $cadBoleto.="<small >NIT:329448023</small>";
                $cadBoleto.="<hr>";
                $cadBoleto.="<div style='font-size: 22px'>$row->titulo<br> $row->nombreSala </div>";
                $cadBoleto.=" <div>Fecha:&nbsp; <span style='font-size: 22px;'>$row->fechaFuncion</span> &nbsp;&nbsp;&nbsp; Bs.&nbsp; $row->costo</div>";
                $cadBoleto.="<div style='font-size: 17px'>Butaca:<span style='font-size:22px;'>$row->letra - $row->columna</span> Hora: <span style='font-size:22px;'>".substr( $row->horaFuncion,0,5). "</span></div>";
                $cadBoleto.="<hr>";
                $cadBoleto.="<div style='font-size: 12px' align='left'>Cod:&nbsp;".$row->numboc . "<br>
                            Trans:&nbsp; ".$row->idVenta."<br>
                            Usuario: &nbsp;".$row->nombreUser."<br></div></div>";
                echo $cadBoleto;

}
function tienepromo($idboleto){
	    $query=$this->db->query("SELECT * FROM boleto b,tarifa t WHERE idBoleto='$idboleto' and b.idTarifa=t.idTarifa");
	    echo json_encode($query->result_array()[0]);
}

public function impPromo($idventa){
    $query=$this->db->query("SELECT * FROM venta v, usuario u  
    WHERE idVenta='$idventa' and v.idUsuario=u.idUsuario");
            $row=$query->result()[0];
            $promo="<style>.margen{padding: 0px 15px 0px 15px;}
            .textoimp{ font-size: 15px; text-align: center;} 
            .textp{ font-size: small; text-align: center;} 
            .textpeq{ font-size: small; text-align: left;}
            table{border: 1px solid #000; text-align:center; align:center; } 
            th,td{font-size: x-small;}
            hr{border: 1px dashed ;}</style>
            <div class='textoimp margen'>
            <div>";
            $promo.="MULTISALAS S.R.L.<br>";
            $promo.="<div class='textp'>NIT:329448023</div>";
            $promo.="<hr>";
            $promo.="COMBO DUO";
            $promo.="<hr>";
            $promo.="<div class='textp'>Reclame su combo duo <div>";
            $promo.="1 PIPOCA + 2 REFRESCOS <br>";
            $promo.="<hr>";
            $promo.="<div class='textpeq'>
                     Trans: ".$idventa."<br>
                     Fecha: $row->fechaVenta <br>
                     Usuario: $row->user <br></div><div>";
            echo $promo;

}

public function impAniv($id){
           $fecha=date('d/m/Y');
            $hora=date("H:i:s");
            $aniv="<style>.margen{padding: 0px 15px 0px 15px;}
            .textoimp{ font-size: 15px; text-align: center;} 
            .textp{ font-size: small; text-align: center;} 
            .textpeq{ font-size: small; text-align: left;}
            table{border: 1px solid #000; text-align:center; align:center; } 
            th,td{font-size: x-small;}
            hr{border: 1px dashed ;}</style>
            ";
            $aniv.="<div class='textoimp margen'>
            <span>MULTISALAS S.R.L.</span><br>
            <span>SUCURSAL No 1</span><br>
            <span>ORURO - BOLIVIA</span><br>
            <hr>
            ";
            $aniv.="<div class='textpeq'>Fecha: $fecha - $hora - Id:$id</div> <br><hr>";

        $aniv.="<div class='textpeq'>Nombre Completo:................</div><br>";
        $aniv.="<div class='textpeq'>CI:................</div><br>";
        $aniv.="<div class='textpeq'>Telf/Cel:................</div><br>";

           $aniv.="<hr></div>";
            echo $aniv;

}


public function impAniv2($id){
            $query1=$this->db->query("SELECT count(*) as total from boleto b, venta v  where b.idVenta=v.idVenta and v.idVenta=$id");
            $row=$query1->result()[0]->total;
               $fecha=date('d/m/Y');
            $hora=date("H:i:s");
            $aniv="<style>.margen{padding: 0px 15px 0px 15px;}
            .textoimp{ font-size: 15px; text-align: center;} 
            .textp{ font-size: small; text-align: center;} 
            .textpeq{ font-size: small; text-align: left;}
            .textmed{ font-size: 15px; text-align: left;}
            table{border: 1px solid #000; text-align:center; align:center; } 
            th,td{font-size: x-small;}
            hr{border: 1px dashed ;}</style>
            ";
            $aniv.="<div class='textoimp margen'>
            <span>MULTISALAS S.R.L.</span><br>
            <span>SUCURSAL No 1</span><br>
            <span>ORURO - BOLIVIA</span><br>
            <hr>
            ";
            $aniv.="<div class='textpeq'>Fecha: $fecha - $hora - Id:$id</div> <br><hr>";

        $aniv.="<div class='textpeq'>RECLAMA TU COMBO</div><br>";
        $aniv.="<div class='textmed'>Cantidad: $row </div><br>";


           $aniv.="<hr></div>";
            echo $aniv;

}
public function qr(){
    $filename = 'temp/qr.png';
    $errorCorrectionLevel = 'L';
    $matrixPointSize = 4;
    QRcode::png('PHP QR Code :)', $filename, $errorCorrectionLevel, $matrixPointSize, 2);
}

public function devolucion(){
    $idventa=$_POST['idventa'];
    $motivo=$_POST['motivo'];
    $total=$_POST['total'];
    $user = $this->session->userdata('idUs');
    $this->Ventas_model->devolVenta($idventa);
    $this->Boletos_model->devolBoleto($idventa);
    $this->db->query("INSERT INTO devolucion (idVenta,idUsuario,monto,motivo,tipo) values ('$idventa','$user','$total','$motivo','BOLETERIA')");
    echo $this->db->insert_id();
}


public function devolucionfuncion($id){

    $user = $this->session->userdata('idUs');
    //$this->Ventas_model->devolVenta($idventa);
    //$this->Boletos_model->devolBoleto($idventa);
    //$this->db->query("INSERT INTO devolucion (idVenta,idUsuario) values ('$idventa','$user')");
}

public function listaBoletos(){
    $idventa=$_POST['idventa'];
    $query=$this->db->query("SELECT * FROM boleto
    WHERE idVenta='$idventa'");
    $row=$query->row();
    $myObj=($query->result_array());

    echo json_encode($myObj);
}

public function paneldevol($id="")
{
    if($this->session->userdata('login')==1){
        $user = $this->session->userdata('idUs');
        $dato=$this->Usuarios_model->validaIngreso($user);
        $this->load->view('templates/header', $dato);

        $this->load->view('paneldevolucion');

        $dato2['js']="<script src='".base_url()."assets/js/progdevolucion.js'></script>";

        $this->load->view('templates/footer',$dato2);
    }
    else redirect('');
}
public function programacion1(){

    //header('Content-Type: application/json');

    $query=$this->db->query("SELECT (CASE
WHEN s.idSala='1' THEN '#01579b'
WHEN s.idSala='2' THEN '#006064'
WHEN s.idSala='3' THEN '#1b5e20'
WHEN s.idSala='4' THEN '#ff5722'
WHEN s.idSala='5' THEN '#795548'
WHEN s.idSala='6' THEN '#e65100'
WHEN s.idSala='7' THEN '#827717'

END)as 'color'
,  idFuncion as id
, CONCAT(fecha,' ',horaInicio) as 'start'
,CONCAT(fecha,' ',horaFin) as 'end'
, CONCAT(p.nombre)  as 'title'
, s.idSala
, p.idPelicula
,fecha
,horaInicio
,subtitulada
,numerada
,idTarifa
,nroSala
,nroFuncion
,nombre
,formato
,(SELECT count(*) from boleto b where b.idFuncion = f.idFuncion and devuelto = 'NO') as vendido
,(SELECT count(*) from boleto b where b.idFuncion = f.idFuncion and devuelto = 'SI') as devuelto
FROM funcion f INNER JOIN sala s ON s.idSala=f.idSala INNER JOIN pelicula p ON p.idPelicula=f.idPelicula

AND fecha>=date_add(NOW(), INTERVAL -1 DAY)");
    $arr = array();
    foreach ($query->result() as $row){
        $arr[] = $row;
       }
    echo json_encode($arr);
    exit;

}
public function programacion2($idsala){

    //header('Content-Type: application/json');

    $query=$this->db->query("SELECT (CASE
WHEN s.idSala='1' THEN '#01579b'
WHEN s.idSala='2' THEN '#006064'
WHEN s.idSala='3' THEN '#1b5e20'
WHEN s.idSala='4' THEN '#ff5722'
WHEN s.idSala='5' THEN '#795548'
WHEN s.idSala='6' THEN '#e65100'
WHEN s.idSala='7' THEN '#827717'

END)as 'color'
,  idFuncion as id
, CONCAT(fecha,' ',horaInicio) as 'start'
,CONCAT(fecha,' ',horaFin) as 'end'
, CONCAT(p.nombre)  as 'title'
, s.idSala
, p.idPelicula
,fecha
,horaInicio
,subtitulada
,numerada
,idTarifa
,nroSala
,nroFuncion
,nombre
,formato
,(SELECT count(*) from boleto b where b.idFuncion = f.idFuncion and devuelto = 'NO') as vendido
,(SELECT count(*) from boleto b where b.idFuncion = f.idFuncion and devuelto = 'SI') as devuelto
FROM funcion f INNER JOIN sala s ON s.idSala=f.idSala INNER JOIN pelicula p ON p.idPelicula=f.idPelicula
WHERE
s.idSala='$idsala'");
    $arr = array();
    foreach ($query->result() as $row){
        $arr[] = $row;
    }
    echo json_encode($arr);
    exit;

}

public function validaCuponreg(){

    $idcupon=$_POST['idcupon'];
    $query=$this->db->query("SELECT * FROM boleto b, subcupon c WHERE b.idCupon=c.idsubcupon and c.idsubcupon='$idcupon'");
    $row=$query->row();
    $myObj=($query->result_array());

    echo json_encode($myObj);

}

public function validaCupon(){

    $idcupon=$_POST['idcupon'];
    $query=$this->db->query("SELECT * FROM  cupon c, subCupon s WHERE  c.idCupon=s.idcupon and s.idsubcupon='$idcupon' and date(fechaFin) >= CURDATE()");
    $row=$query->row();
    $myObj=($query->result_array());
    echo json_encode($myObj);

}

public function UpDosificacion(){
    $verifica=$this->db->query("SELECT * FROM dosificacion WHERE tipo='BOLETERIA' and activo=1 and fechaHasta < curdate()");
    $row=$verifica->row();
    if ($verifica->num_rows() == 1){
        $verifica2=$this->db->query("SELECT * FROM dosificacion where tipo='BOLETERIA' and activo=0 and fechaDesde <= curdate() and fechaHasta >= curdate()");
        if($verifica2->num_rows()==1){
        $this->db->query("UPDATE dosificacion set activo=0 where fechaHasta < curdate() and tipo='BOLETERIA'");
        $this->db->query("UPDATE dosificacion set activo=1 where fechaDesde <= curdate() and fechaHasta >= curdate() and tipo='BOLETERIA'");
        echo true; }
        else
        echo false;
        echo true;
    }
    else echo false;

}

public function verifDosifcacion(){
    $fecha=$_POST['fdosif'];
    $query=$this->db->query("SELECT * FROM dosificacion WHERE tipo='BOLETERIA' and activo=1 and fechaHasta >= '$fecha'");
    $row=$query->row();
    if ($query->num_rows() == 1) echo true;
    else echo false;
}

public function totalventa(){
    $fecha=$_POST['fecha'];
    $query=$this->db->query("SELECT count(*) as totalv FROM boleto b WHERE date(fechaFuncion)='$fecha' AND devuelto='NO'");
    $row=$query->row();
    $myObj=($query->result_array());

    echo json_encode($myObj);
}

public function datotarifa($id){
    $query=$this->db->query("SELECT * FROM tarifa WHERE idTarifa = $id");
    $row=$query->row();
    $myObj=($query->result_array());
    echo json_encode($myObj);
}

public function valtarjeta()
{
        $codigo=$this->hexToStr($_POST['codigo']);
        //return $codigo;
        $conn = mysqli_connect("165.227.143.191", "myuser", "ORRKWKtehUul1p4z", "tarjetaplaza");
// Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $result = $conn->query("SELECT * from cliente where codigo='$codigo'");
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
//                echo $row["nombre"];
                echo json_encode( $row);
            }
        } else {
            echo "0";
        }
        $conn->close();
}
function hexToStr($hex){
    $string='';
    for ($i=0; $i < strlen($hex)-1; $i+=2){
        $string .= chr(hexdec($hex[$i].$hex[$i+1]));
    }
    return $string;
}
}