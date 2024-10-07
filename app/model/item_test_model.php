<?php
// Definición del espacio de nombres para evitar conflictos con otras clases en el proyecto
namespace App\Model;

// Importación de dependencias necesarias
use App\Lib\Database;  // Clase que maneja la conexión a la base de datos
use App\Config\ConfigGlobal;  // Clase de configuración global de la aplicación
use App\Config\InitModel;  // Clase base que contiene funcionalidades comunes para los modelos

/**
 * Clase ItemTestModel que extiende de InitModel.
 * Este modelo representa la tabla 'item_test' en la base de datos.
 */
class ItemTestModel extends InitModel {
    // Propiedades privadas del modelo
    private $db;  // Objeto para la conexión a la base de datos
    private $table = 'item_test';  // Nombre de la tabla en la base de datos
    private $column = array("id_test", "item");  // Columnas de la tabla para inserción
    private $column_select = array("id", "id_test", "item");  // Columnas para selección de datos
    private $column_update = array("id_test", "item");  // Columnas permitidas para la actualización de registros
    private $column_filter = array("id_test", "item");  // Columnas que se pueden usar para filtrar datos
    private $url;  // Variable que guarda la URL del servidor

    /**
     * Constructor de la clase ItemTestModel
     * Inicializa la configuración del modelo y establece la conexión a la base de datos.
     */
    public function __CONSTRUCT() {
        // Instancia de la clase de configuración global para obtener la URL del servidor
        $CONFIG_G = new ConfigGlobal();
        // Asigna la URL del servidor obtenida de la configuración global
        $this->url = $CONFIG_G->getServer();

        // Llama al constructor de la clase InitModel con los parámetros específicos de la tabla 'item_test'
        parent::__construct(array(
            "table"             =>  $this->table,  // Nombre de la tabla
            "column"            =>  $this->column,  // Columnas para inserción de datos
            "column_select"     =>  $this->column_select,  // Columnas para seleccionar datos
            "column_update"     =>  $this->column_update,  // Columnas permitidas para actualizar
            "column_filter"     =>  $this->column_filter,  // Columnas utilizadas para el filtrado
            "column_status"     =>  null  // En este caso no se maneja una columna de estado
        ));

        // Inicializa la conexión a la base de datos utilizando la clase Database
        $this->db = Database::StartUp();
    }
}
?>
