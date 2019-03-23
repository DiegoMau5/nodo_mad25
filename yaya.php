<?php
    //ENCABEZADO WEBHOOK

    include_once "../api-php/somosioticos_dialogflow.php"; //INCLUIMOS LA LIBRERIA
    //include_once "./bbdd/sql.php";
    credenciales('yaya_admin', 'yayaadmin'); // user and pass to access to atenea
    debug(); // Debug para el codigo PHP

    /********************* CONEXION BBDD******************/

    $mysqli = mysqli_connect("localhost","anailistlab","anailistlab7", "yaya");

    // Probamos conexion
    // prueba de conexion bbdd - bot
    if(!$mysqli) {

        echo "ERROR DE CONEXION CON LA BASE DE DATOS YAYA" . PHP_EOL;
        die(); // Matamos el proceso
    }

    $name_paciente = consultarPaciente();
    
    /*************************************************************
    ************* IDENTIFICACIÓN DE LOS INTENT ********************
    ***************************************************************
    ****************************************************************/
    if (intent_recibido("Default_Welcome_Intent")){
        //Recibimos info de la bbdd
        $text = "Hola $name_paciente ¿Qué tal?";
        enviar_texto($text);
    }

    // feedback dia malo
    if (intent_recibido("estado_mal")){
        $causa = obtener_variables()['causa'];
        $sensor=sensor();
        $text = "Te entiendo, hay dias que me he sentido así, pero los días no están para estar del mal humor.";
        if($sensor!=2){
            if($sensor['estado']==0){
                if(insertarCausa($causa) == 'true'){
                    enviar_texto($text);
                }
                else {
                    enviar_texto("Ha habido un error");
                }   
            }else{
                $text2 = "No te preocupes, todo irá mejorando, yo estoy aquí para lo que necesites. Por cierto recuerda que tienes encendida la " . $sensor['tipo'] . " de " . $sensor['zona'] . "¿Quieres apagarla?";
                if(insertarCausa($causa) == 'true'){
                    enviar_texto($text2);
                }
                else {
                    enviar_texto("Ha habido un error");
                }   
            
                
            }
        }else{
            enviar_texto($text . "Por cierto, hay mas de una luz encendida. ¿Quieres apagarlas?");
        }

        
    }
    
    if(intent_recibido("estado_mal_yes")){
        $res = apagarTodo();
        if($res=="true"){
            enviar_texto("Perfecto, todo apagado");
        }else{enviar_texto("Ha habido un error");}
    }
    /*************************************************************
    ************* FUNCIONES BBDD ********************
    ***************************************************************
    ****************************************************************/

    

    // Funciones con la bbdd 


    function consultarPaciente(){
        global $mysqli;

        $resultado = $mysqli->query("SELECT *
        FROM `paciente`
        WHERE `id`= 1
        ");

        $res = mysqli_fetch_assoc($resultado);
        $alumno = $res['name'];
        
        return $alumno;
    }

    function insertarCausa($causa){
        global $mysqli;
        $sql="INSERT INTO`feedback_va`(`id_paciente`,`conversation`,`date_conversation`)
        VALUES(1,'{$causa}',now())";

        if($mysqli->query($sql)===TRUE){
            return "true";
        }
        else{
            return "false";
        }  
    } 

    function sensor(){
        global $mysqli;
        $sql = "SELECT * FROM `paciente` as `p`
        inner join `sensor_luz` as `sl` on `p`.`id`= `sl`.`id_paciente`
        where `p`.`id`=1 and `sl`.`estado`=1;";
        if(mysqli_num_rows($mysqli->query($sql)) > 1){
            $res=2;
        }else{
            $resultado = $mysqli->query($sql);
            $res = mysqli_fetch_assoc($resultado);
        }        
        return $res;
    }

    function apagarTodo(){
        global $mysqli;
        $sql = "UPDATE `yaya`.`sensor_luz` SET `estado`=0 WHERE `estado`=1;";
        if($mysqli->query($sql)===TRUE){
            return "true";
        }
        else{
            return "false";
        }     
    }

?>