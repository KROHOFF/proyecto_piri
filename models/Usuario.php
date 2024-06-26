<?php

    class Usuario extends Conectar{

            /* TODO: Funcion de login y generacion de session */
            public function login() {
                $conectar = parent::conexion();
                parent::set_names();
                if (isset($_POST["enviar"])) {
                    $correo = $_POST["usu_correo"];
                    $pass = $_POST["usu_pass"];

                    // Verificar si los campos están vacíos
                    if (empty($correo) || empty($pass)) {
                        header("Location:" . Conectar::ruta() . "index.php?m=2");
                        exit();
                    }
                    // Preparar la consulta SQL
                    $sql_usuario = "SELECT * FROM tm_usuario WHERE usu_correo = ?";
                    $stmt = $conectar->prepare($sql_usuario);
                    $stmt->bindValue(1, $correo);

                    try {
                        $stmt->execute();
                        $result = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($result) {
                            // Obtener el valor del campo usu_rol_id
                            $usu_rol_id = $result['rol_id'];

                            // Verificar contraseña
                            $textocifrado = $result["usu_pass"];
                            $key = "mi_key_secret";
                            $cipher = "aes-256-cbc";
                            $iv_dec = substr(base64_decode($textocifrado), 0, openssl_cipher_iv_length($cipher));
                            $cifradoSinIV = substr(base64_decode($textocifrado), openssl_cipher_iv_length($cipher));
                            $decifrado = openssl_decrypt($cifradoSinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);

                            if ($decifrado == $pass) {
                                // Verificar si el usuario está activo
                                if ($result['est'] == 1) {
                                    $_SESSION["usu_id"] = $result["usu_id"];
                                    $_SESSION["usu_nom"] = $result["usu_nom"];
                                    $_SESSION["usu_ape"] = $result["usu_ape"];
                                    $_SESSION["rol_id"] = $result["rol_id"];
                                    header("Location:" . Conectar::ruta() . "view/Home/");
                                    exit();
                                } else {
                                    header("Location:" . Conectar::ruta() . "index.php?m=1");
                                    exit();
                                }
                            } else {
                                // Contraseña incorrecta
                                header("Location:" . Conectar::ruta() . "index.php?m=1");
                                exit();
                            }
                        } else {
                            // No se encontró el usuario
                            header("Location:" . Conectar::ruta() . "index.php?m=1");
                            exit();
                        }
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                }
            }



        public function nuevo_usuario($usu_nom, $usu_ape, $usu_correo, $usu_pass, $rol_id, $usu_telf){

        $key="mi_key_secret";
        $cipher="aes-256-cbc";
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
        $cifrado = openssl_encrypt($usu_pass, $cipher, $key, OPENSSL_RAW_DATA, $iv);
        $textoCifrado = base64_encode($iv . $cifrado);

        $conectar= parent::conexion();
        parent::set_names();
        $sql="INSERT INTO tm_usuario (usu_id, usu_nom, usu_ape, usu_correo, usu_pass, rol_id, usu_telf, fech_crea, fech_modi, fech_elim, est)
                VALUES (NULL,?,?,?,?,?,?,now(), NULL, NULL, '1');";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1, $usu_nom);
        $sql->bindValue(2, $usu_ape);
        $sql->bindValue(3, $usu_correo);
        $sql->bindValue(4, $textoCifrado);
        $sql->bindValue(5, $rol_id);
        $sql->bindValue(6, $usu_telf);
        $sql->execute();
        return $resultado=$sql->fetchAll();
        }

        public function insert_usuario($usu_nom,$usu_ape,$usu_correo,$usu_pass,$rol_id,$usu_telf){

            $key="mi_key_secret";
            $cipher="aes-256-cbc";
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
            $cifrado = openssl_encrypt($usu_pass, $cipher, $key, OPENSSL_RAW_DATA, $iv);
            $textoCifrado = base64_encode($iv . $cifrado);

            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO tm_usuario (usu_id, usu_nom, usu_ape, usu_correo, usu_pass, rol_id, usu_telf, fech_crea, fech_modi, fech_elim, est)
                    VALUES (NULL,?,?,?,?,?,?,now(), NULL, NULL, '1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_nom);
            $sql->bindValue(2, $usu_ape);
            $sql->bindValue(3, $usu_correo);
            $sql->bindValue(4, $textoCifrado);
            $sql->bindValue(5, $rol_id);
            $sql->bindValue(6, $usu_telf);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO:Update */
        public function update_usuario($usu_id,$usu_nom,$usu_ape,$usu_correo,$usu_pass,$rol_id,$usu_telf){

            $key="mi_key_secret";
            $cipher="aes-256-cbc";
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
            $cifrado = openssl_encrypt($usu_pass, $cipher, $key, OPENSSL_RAW_DATA, $iv);
            $textoCifrado = base64_encode($iv . $cifrado);

            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE tm_usuario set
                usu_nom = ?,
                usu_ape = ?,
                usu_correo = ?,
                usu_pass = ?,
                rol_id = ?,
                usu_telf = ?
                WHERE
                usu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_nom);
            $sql->bindValue(2, $usu_ape);
            $sql->bindValue(3, $usu_correo);
            $sql->bindValue(4, $textoCifrado);
            $sql->bindValue(5, $rol_id);
            $sql->bindValue(6, $usu_telf);
            $sql->bindValue(7, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO:Delete */
        public function delete_usuario($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_d_usuario_01(?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO:Todos los registros */
        public function get_usuario(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_l_usuario_01()";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO: Obtener registros de usuarios segun rol 2 */
        public function get_usuario_x_rol($rol_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM tm_usuario where est=1 and rol_id=2";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_usuario_x_rol_filtro(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM tm_usuario where est=1 and rol_id=2";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO:Registro x id */
        public function get_usuario_x_id($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_l_usuario_02(?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO: Total de registros segun usu_id */
        public function get_usuario_total_x_id($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT COUNT(*) as TOTAL FROM tm_ticket where usu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO: Total de Tickets Abiertos por usu_id */
        public function get_usuario_totalabierto_x_id($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT COUNT(*) as TOTAL FROM tm_ticket where usu_id = ? and tick_estado='Abierto'";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO: Total de Tickets Cerrado por usu_id */
        public function get_usuario_totalcerrado_x_id($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT COUNT(*) as TOTAL FROM tm_ticket where usu_id = ? and tick_estado='Cerrado'";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO: Total de Tickets por categoria segun usuario */
        public function get_usuario_grafico($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT tm_categoria.cat_nom as nom,COUNT(*) AS total
                FROM   tm_ticket  JOIN
                    tm_categoria ON tm_ticket.cat_id = tm_categoria.cat_id
                WHERE
                tm_ticket.est = 1
                and tm_ticket.usu_id = ?
                GROUP BY
                tm_categoria.cat_nom
                ORDER BY total DESC";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO: Actualizar contraseña del usuario */
        public function update_usuario_pass($usu_id,$usu_pass){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE tm_usuario
                SET
                    usu_pass = ?
                WHERE
                    usu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_pass);
            $sql->bindValue(2, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO:Registro x Correo */
        public function get_usuario_x_correo($usu_correo){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM tm_usuario WHERE usu_correo=?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_correo);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_cambiar_contra_recuperar($usu_correo){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE
                tm_usuario
                    SET
                usu_pass=CONCAT(SUBSTRING(MD5(RAND()),1,3),LPAD(FLOOR(RAND()*1000),3,'0'))
                    WHERE
                usu_correo=?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_correo);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function encriptar_nueva_contra($usu_id,$usu_pass){

            $key="mi_key_secret";
            $cipher="aes-256-cbc";
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
            $cifrado = openssl_encrypt($usu_pass, $cipher, $key, OPENSSL_RAW_DATA, $iv);
            $textoCifrado = base64_encode($iv . $cifrado);

            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE tm_usuario set
                usu_pass = ?
                WHERE
                usu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $textoCifrado);
            $sql->bindValue(2, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

}