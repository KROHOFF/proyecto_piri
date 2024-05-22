<?php
    session_start();

    class Conectar{
        protected $dbh;

        protected function Conexion(){
            try {
				/*Locahost*/
                //$conectar = $this->dbh = new PDO("mysql:local=localhost;dbname=registro_ticket","root","");

                /*Produccion*/
                $conectar = $this->dbh = new PDO("mysql:host=localhost;dbname=proyecto_piri","root","root");

				return $conectar;
			} catch (Exception $e) {
				print "¡Error BD!: " . $e->getMessage() . "<br/>";
				die();
			}
        }

        public function set_names(){
			return $this->dbh->query("SET NAMES 'utf8'");
        }

        public static function ruta(){
            //Ruta Proyecto Local
			return "http://localhost:8888/soporte/";

            //Ruta Produccion

            // return "http://virtuanet.cl/soporte/";
		}
    }
?>