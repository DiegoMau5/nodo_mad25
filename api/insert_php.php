<?php
   
   //header('Content-Type: application/json;charset=utf-8');
   $request= $_GET['request'];
   $bombilla = $_GET['bombilla'];
   
   $mysqli = mysqli_connect("localhost","anailistlab","anailistlab7", "yaya");
   if(!$mysqli) {
        echo "ERROR DE CONEXION CON LA BASE DE DATOS Atenea_MDB_AWS" . PHP_EOL;
        return 1;
        die(); // Matamos el proceso
     }
    

   if($bombilla){
    $estado= consultarEstado($bombilla);
    
        if($estado==0){
            $sql2 = "UPDATE `yaya`.`sensor_luz` SET `estado`=1 WHERE `id`={$bombilla};";
             
            if($mysqli->query($sql2)===TRUE){
                
                return "true";
            }
            else{
                
                return "false";
            }     
        }else{
            $sql2 = "UPDATE `yaya`.`sensor_luz` SET `estado`=0 WHERE `id`={$bombilla};";  
            if($mysqli->query($sql2)===TRUE){
                return "true";
            }
            else{
                return "false";
            }     
        } 
     }else{
         
         $array = allSensors();
         echo $array;
         return $array;
     }
   

    function consultarEstado($bombilla){
        $sql = "SELECT estado from sensor_luz where id = {$bombilla};";
        global $mysqli;
        
        $resultado = $mysqli->query($sql);

        $res = mysqli_fetch_assoc($resultado);
        $respuesta = $res['estado'];
        
        return $respuesta;
    }

    function allSensors(){
        $cadena = "";
        $sql = "SELECT * from sensor_luz;";
        global $mysqli;
        
        $resultado = $mysqli->query($sql);
        while($r=mysqli_fetch_assoc($resultado)){
            
            $cadena .= $r["id"]. "-" . $r['estado'] . '|';
        }
        return $cadena;
    }
    

?>