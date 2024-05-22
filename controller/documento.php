<?php
    /* llamada a las clases necesarias */
    require_once("../config/conexion.php");
    require_once("../models/Documento.php");
    $documento = new Documento();

    $key="mi_key_secret";
    $cipher="aes-256-cbc";
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));

    /*TODO: opciones del controlador */
    switch($_GET["op"]){
        /* manejo de json para poder listar en el datatable, formato de json segun documentacion */
        case "listar":
            $iv_dec = substr(base64_decode($_POST["tick_id"]), 0, openssl_cipher_iv_length($cipher));
            $cifradoSinIV = substr(base64_decode($_POST["tick_id"]), openssl_cipher_iv_length($cipher));
            $decifrado = openssl_decrypt($cifradoSinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);

            $datos=$documento->get_documento_x_ticket($decifrado);
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = '<a href="../../public/document/'.$_POST["tick_id"].'/'.$row["doc_nom"].'" target="_blank">'.$row["doc_nom"].'</a>';
                /* TODO: Formato HTML para abrir el documento o descargarlo en una nueva ventana */
                $sub_array[] = '<a type="button" href="../../public/document/'.$_POST["tick_id"].'/'.$row["doc_nom"].'" target="_blank" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></a>';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
        break;
    }
?>
