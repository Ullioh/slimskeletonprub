<?php
// Definición del espacio de nombres para evitar conflictos con otras clases en el proyecto
namespace App\Config;

// Importación de las clases necesarias
use App\Lib\Validate;  // Clase Validate utilizada para validar el token
use App\Lib\Response;  // Clase Response utilizada para generar respuestas HTTP

/**
 * Clase Middleware
 * Define el middleware que protege las rutas mediante validación de tokens de autorización.
 */
class Middleware {

    /**
     * Método onlyUser
     * Middleware que verifica si el usuario está autenticado con un token válido.
     * Si el token es válido, el middleware permite continuar con la ejecución de la solicitud.
     * Si el token no es válido, se devuelve una respuesta de error.
     *
     * @param $req  Petición HTTP (request)
     * @param $res  Respuesta HTTP (response)
     * @param $next Función para continuar la ejecución de la ruta si el token es válido
     * @return $res Respuesta HTTP final, ya sea con un error o con la ejecución normal de la ruta
     */
    public function onlyUser($req, $res, $next) {
        // Se crea una instancia de la clase Validate para validar el token
        $validate = new Validate();
        
        // Se crea una instancia de la clase Response para gestionar la respuesta HTTP
        $respuesta = new Response();
        
        // Obtiene el valor del token del encabezado 'Authorization' en la petición
        $token = $req->getHeader('Authorization');
        
        // Decodifica y valida el token para comprobar si tiene autorización como "user"
        $decode = $validate->getAuthorization($token, array("user"));
        
        // Si el token no es válido o no tiene la autorización necesaria
        if ($decode == false) {
            // Se establece la respuesta de error utilizando la clase Response
            $respuesta->setResponse(false, $validate->code, $validate->message);
            
            // Se devuelve una respuesta con un estado de error y un contenido JSON con el mensaje de error
            return $res
                ->withHeader('Content-type', 'application/json')  // Establece el tipo de contenido como JSON
                ->withStatus($validate->code)                     // Establece el código de estado HTTP (p.ej., 401 Unauthorized)
                ->write(
                    json_encode($respuesta)  // Convierte la respuesta en formato JSON
                );
        } else {
            // Si el token es válido, se almacena la información del usuario en la petición
            $req = $req->withAttribute('user', $decode);  // Se añade el atributo 'user' a la petición con la información decodificada del token
            
            // Llama a la función $next para continuar con la ejecución de la solicitud
            $res = $next($req, $res);
            
            // Devuelve la respuesta final
            return $res;
        }
    }
}
?>
