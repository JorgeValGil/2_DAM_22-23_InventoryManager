<?php

namespace db;

/**
 * Clase conexión a base de datos
 */
class Db {

    private static $dbInstance = null;

    /**
     * Contructor
     */
    private function __construct() {
        
    }

    private function __clone() {
        
    }

    /**
     * Crea o obtiene una instancia del conector a la base de datos
     * @return type
     */
    public static function getInstance() {

        if (self::$dbInstance == null) {

            try {
                $data = self::config(__DIR__ . "/../../config/configuracion.xml", __DIR__ . "/../../config/configuracion.xsd");
                $servidor = $data[0];
                $bd = $data[1];
                $nombre = $data[2];
                $password = $data[3];
                self::$dbInstance = new \PDO("mysql:dbname=" . $bd . ";host=" . $servidor, $nombre, $password);
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
        return self::$dbInstance;
    }

    /**
     * Obtiene los datos de la conexión a la base de datos desde un archivo XML
     * @param type $fichero_config_BBDD archivo XML
     * @param type $esquema archivo XSD
     * @return array datos de conexión
     * @throws InvalidArgumentException
     */
    private function config($fichero_config_BBDD, $esquema) {
        $config = new \DOMDocument();
        $config->load($fichero_config_BBDD);
        $res = $config->schemaValidate($esquema);
        if ($res === FALSE) {
            throw new InvalidArgumentException("Revise el fichero de configuración");
        }
        $datos = simplexml_load_file($fichero_config_BBDD);
        $array = [
            "" . $datos->xpath('//servidor')[0],
            "" . $datos->xpath('//bd')[0],
            "" . $datos->xpath('//nombre')[0],
            "" . $datos->xpath('//password')[0]
        ];

        return $array;
    }

}
