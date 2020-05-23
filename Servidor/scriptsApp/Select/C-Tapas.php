<?php
$hostname ="bimlwt6nabnfzacy9sgn-mysql.services.clever-cloud.com";
$database ="bimlwt6nabnfzacy9sgn";
$username ="uxqi36i7rez3yxs2";
$password ="Cgh6yIaCCX03eDOFX3Ha";

$json = array();

class Respuesta{
    public $tapasAcumuladas;
    public $tapasRestantes;
    public $mensaje;
    public $fallo;
}

$res = new Respuesta();
//if( isset($_POST["usId"]) ){

    $usId = $_POST["usId"];

    $conexion = mysqli_connect($hostname,$username,$password,$database);
    if($conexion -> connect_error)
    {
        die("Coneccion fallida" .$conexion->connect_error);
    }
    

    $consulta = "SELECT cc.cadena 
                FROM usuario_detalles usd 
                INNER JOIN usuarios u ON usd.id_usuario = u.id 
                INNER JOIN cadenas cc ON usd.id_cadena = cc.id 
                INNER JOIN maquinas m ON cc.id_maquina = m.id_maquina 
                WHERE u.id = {$usId} and cc.status = 0";

    $resultado = mysqli_query($conexion,$consulta);

    if( $resultado ){
        $bandera = false;
        $acumulador = 0;
        $valor = 0;
        while($us = mysqli_fetch_array($resultado) ){
            $valor = intval(divideCadena($us[0]));
            $acumulador += $valor;
            $res -> fallo = false;
            $bandera = true;
        }
        
        if( $bandera ){
            $res -> mensaje = "Se pudo traer las categogiras";
            $bandera2 = true;
            $dato = 0;
            while( $bandera2 ){
                $dato = $acumulador - 1000;
                if( $dato <= 0 ){
                    $res -> tapasAcumuladas = $dato * (-1);
                    $res -> tapasRestantes = 1000 + $dato;
                    $bandera2 = false;
                }else
                    $acumulador = $dato;
                
            }
        }else{
            $res -> mensaje = "No se pudo traer las categorias";
            $res -> fallo = true;
        }  
    }else{
        $res -> mensaje = "El usuario NO existe";
        $res -> fallo = true;
    }

    mysqli_close($conexion);
    echo json_encode($res);

    function divideCadena($cadena){
        $lista = explode("T", $cadena);
        return $lista[0];
    }

/*}else{
	echo "llego vacio";	
}*/
?>