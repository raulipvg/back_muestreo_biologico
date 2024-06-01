# ENTREGA - SPRINT 4
# Backend sistema formularios

Backend para el sistema de formularios y planillas. Requiere de ``php ^8.0``. Además, cuenta con los paquetes ``MathPHP``, ``Socialite``, ``GoogleCloud\Storage`` y ``Tymon\JWTAuth``.

Se seleccionó ``Tymon\JWTAuth`` para manejar las autenticaciónes ya que no habrían problemas de CORS, ni problemas con las cookies como session y CSRF-TOKEN al estar en sitios distintos o distintos niveles de dominio.

#### IMPORTANTE

Hay que agregar `'middleware' => 'jwt.verify'` a las rutas para protejerlas con JWT. A medida que se vaya agregando el middleware probar con el frontend, enviando el token mediante el header `Authorization`.

Hasta el momento, se aplicó el middleware a los grupos de url:
- Formulario
- Clasificacion
- Persona

Falta tomar una desición para saber cómo manejar la actualización de los token de usuarios, luego que estos expiren en el backend y sigan almacenados en el frontend.

- Instalar
- Base de datos
- Variables de entorno
- Ejecutar


## Instalar

Basta con usar el comando

    composer install

y se instalará los paquetes y dependencias necesarias.


## Base de Datos

El motor de base de datos usado en el proyecto es ``PostgreSQL 15``. En el directorio ``DB`` se encuentra el archivo ``BD-formularios-202405171406-EntregaFinalFormularios1.tar`` que corresponde a un dumb de la base de datos.

Para restaurar el backup, es necesario crear la base de datos, y estando vacía realizar un *restore backup*.

Para restaurar correctamente la base de datos ya existente, es necesario eliminar el esquema ``public`` y luego realizar *restore backup*.

## Variables de entorno

Se recomienda duplicar el archivo ``.exv.example`` y renombrar el archivo duplicado a solo ``.env``, y realizar la siguientes modificaciones:

     6 | FRONTEND_URL=http://localhost:4200      <- URL del frontend
    ...
    12 | DB_CONNECTION=pgsql                     <- tipo de base de datos (pgsql)
    13 | DB_HOST=127.0.0.1                       <- host de la base de datos
    14 | DB_PORT=5432                            <- puerto de la base de datos
    15 | DB_DATABASE=formularios                 <- nombre de la base de datos
    16 | DB_USERNAME=postgres                    <- username de la base de datos
    17 | DB_PASSWORD=                            <- contraseña de la base de datos
    ...
    64 | GOOGLE_CLOUD_PROJECT_ID=                <- Id del proyecto de Google
    65 | GOOGLE_CLOUD_KEY_FILE=                  <- Ruta ABSOLUTA del archivo json de credencial de Google
    66 | GOOGLE_CLOUD_STORAGE_BUCKET=            <- Nombre del Bucket de Google Storage

La variable ``FRONTEND_URL`` corresponde a un ``origin``, por lo tanto, no debe tener algún caracter después del puerto (en caso que se especifique el puerto). Sólo el esquema (``http://``/``https://``), el dominio completo que puede incluir subdominios (``localhost``) y el puerto si se especifica(``:4200``).
Luego, se debe crear el secreto de JWT con el siguiente comando:

    php artisan jwt:secret

Que agregará la siguiente línea en .env, con un hash

    ...
    67 | JWT_SECRET= //hash//

## Ejecutar

Al igual que los proyectos de Laravel, sólo con el comando 

    php artisan serve

y se ejecutará en http://localhost:8000.

## Errores frecuentes

### HTTP 401

- Verificar los inicios de sesión. La API requiere de un inicio de sesión para que funcionen los endpoints, a excepción de los relacionados con el login.
- Verificar los permisos y uso de ``'middleware' => 'jwt.verify'`` en las rutas.
- Verificar que se incluya el header ``Authorization`` en la solicitud, y que este tenga un token válido.

### HTTP 500

- Verificar las variables de entorno relacionadas a Google
- Verificar los permisos de Google Cloud / Google Storage
- Verificar que la variable de entorno ``GOOGLE_CLOUD_KEY_FILE`` contenga la ruta absoluta al archivo ``.json`` con la key.