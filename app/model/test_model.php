<?php
// Definición del espacio de nombres para evitar conflictos en el proyecto
namespace App\Model;

// Importación de dependencias necesarias
use App\Lib\Database;  // Clase que maneja la conexión a la base de datos
use App\Config\ConfigGlobal;  // Clase de configuración global de la aplicación
use App\Config\InitModel;  // Clase base que contiene funcionalidades comunes para los modelos

/**
 * Clase TestModel que extiende de InitModel.
 * Esta clase representa el modelo para interactuar con la tabla 'test' en la base de datos.
 */
class TestModel extends InitModel {
    // Propiedades privadas del modelo
    private $db;  // Objeto de la base de datos para ejecutar consultas
    private $table = 'test';  // Nombre de la tabla en la base de datos
    private $column = array("email", "clave", "nombre", "cedula", "ocupacion", "empresa");  // Columnas de la tabla para inserción
    private $column_select = array("id", "email", "clave", "nombre", "cedula", "ocupacion", "empresa");  // Columnas seleccionadas para las consultas
    private $column_update = array("nombre", "cedula", "ocupacion", "empresa");  // Columnas permitidas para actualizar registros
    private $column_filter = array("nombre", "email", "cedula", "ocupacion");  // Columnas que se pueden usar para filtrar datos
    private $url;  // URL del servidor obtenida de la configuración global

    /**
     * Constructor de la clase TestModel
     * Se inicializan las propiedades necesarias y se configura el modelo con los parámetros correspondientes.
     */
    public function __CONSTRUCT() {
        // Crea una instancia de ConfigGlobal para obtener la configuración global de la aplicación
        $CONFIG_G = new ConfigGlobal();
        // Asigna la URL del servidor desde la configuración global
        $this->url = $CONFIG_G->getServer();
        
        // Llama al constructor de la clase InitModel con los parámetros necesarios
        parent::__construct(array(
            "table"             =>  $this->table,  // Nombre de la tabla
            "column"            =>  $this->column,  // Columnas para inserción
            "column_select"     =>  $this->column_select,  // Columnas para selección
            "column_update"     =>  $this->column_update,  // Columnas permitidas para actualización
            "column_filter"     =>  $this->column_filter,  // Columnas para filtrar
            "column_status"     =>  array(  // Configuración para gestionar el estado del registro
                "name"      =>  "status",  // Nombre de la columna que representa el estado del registro
                "deleted"   =>  0  // Valor que indica que el registro no está eliminado
            )
        ));

        // Inicializa la conexión a la base de datos usando la clase Database
        $this->db = Database::StartUp();
    }

    /**
     * Método comentado para realizar una consulta SELECT.
     * Este método, si se descomenta, recibe un array de datos y ejecuta una consulta para obtener un registro específico por su ID.
     */
    // public function test($data){
    //     try {
    //         // Consulta SQL que selecciona todos los campos de la tabla 'test' donde el id coincide
    //         $sql = "SELECT * FROM $this->table WHERE id = ".$data['id'];  
    //         // Prepara la consulta SQL
    //         $stm = $this->db->prepare($sql);
    //         // Ejecuta la consulta
    //         $stm->execute();

    //         // Devuelve el resultado de la consulta
    //         return $stm->fetch();
    //     } catch(Exception $e){
    //         // En caso de error, devuelve el error capturado
    //         return $e;
    //     }
    // }

    /**
     * Método comentado para realizar una inserción en la tabla 'test'.
     * Este método, si se descomenta, inserta un nuevo registro en la tabla con los datos proporcionados.
     */
    // public function testInsert($data){
    //     try{
    //         // Consulta SQL para insertar un nuevo registro en la tabla 'test' con los valores correspondientes
    //         $sql= "INSERT INTO $this->table(email, clave, nombre, cedula, ocupacion, empresa, rif, direccion, id_estado, id_subzona, ciudad, telefono, celular, fecha_nacimiento, status) 
    //         VALUE(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            
    //         // Ejecuta la consulta preparada con los valores del array $data
    //         $this->db->prepare($sql)->execute(array(
    //             $data['email'],  // Correo electrónico
    //             $data['clave'],  // Clave o contraseña
    //             $data['nombre'],  // Nombre del usuario
    //             $data['cedula'],  // Cédula del usuario
    //             $data['ocupacion'],  // Ocupación del usuario
    //             $data['empresa'],  // Empresa asociada al usuario
    //             $data['rif'],  // RIF (registro de información fiscal)
    //             $data['direccion'],  // Dirección del usuario
    //             $data['id_estado'],  // Estado o provincia
    //             $data['id_subzona'],  // Subzona geográfica
    //             $data['ciudad'],  // Ciudad
    //             $data['telefono'],  // Número de teléfono
    //             $data['celular'],  // Número de celular
    //             $data['fecha_nacimiento'],  // Fecha de nacimiento
    //             1,  // Estado del registro (activo)
    //         ));

    //         // Obtiene el ID del último registro insertado en la base de datos
    //         $id = $this->db->lastInsertId();
    //         // Asigna el ID generado a la variable $data
    //         $data = $id;

    //         // Devuelve el ID del nuevo registro
    //         return $data;
    //     }catch(Exception $e){
    //         // En caso de error, devuelve el error capturado
    //         return $e;
    //     }
    // }

}
?>
