# ENTREGA - SPRINT 4
# Backend sistema formularios

Backend para el sistema de formularios y planillas. Requiere de ``php ^8.0``. Además, cuenta con los paquetes ``MathPHP``, ``Socialite`` y ``GoogleCloud\Storage``.
Hay que considerar que tanto la API como el Frontend deben estar en el mismo nivel de dominio.

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

     6 | FRONTEND_URL= http://localhost:4200     <- URL del frontend
     7 | SESSION_DOMAIN=localhost                <- Solo el dominio, sin puertos ni protocolo
     8 | SANCTUM_STATEFUL_DOMAINS=localhost:4200 <- Sólo el domino y el puerto (si especifica)
    ...
    14 | DB_CONNECTION=pgsql                     <- tipo de base de datos (pgsql)
    15 | DB_HOST=127.0.0.1                       <- host de la base de datos
    16 | DB_PORT=5432                            <- puerto de la base de datos
    17 | DB_DATABASE=formularios                 <- nombre de la base de datos
    18 | DB_USERNAME=postgres                    <- username de la base de datos
    19 | DB_PASSWORD=                            <- contraseña de la base de datos
    ...
    66 | GOOGLE_CLIENT_ID=                       <- Id del cliente de Google
    67 | GOOGLE_CLIENT_SECRET=                   <- Secreto del cliente de Google 
    68 | GOOGLE_REDIRECT_URI=                    <- URL del callback para Google
    ...
    70 | GOOGLE_CLOUD_PROJECT_ID=                <- Id del proyecto de Google
    71 | GOOGLE_CLOUD_KEY_FILE=                  <- Ruta ABSOLUTA del archivo json de credencial de Google
    72 | GOOGLE_CLOUD_STORAGE_BUCKET=            <- Nombre del Bucket de Google Storage

La variable ``FRONTEND_URL`` corresponde a un ``origin``, por lo tanto, no debe tener algún caracter después del puerto (en caso que se especifique el puerto).

La variable ``SESSION_DOMAIN`` debe ser solo un ``top-level domain``. Si se generan conflictos con la API (respuestas 401), verificar esta variable.

Recordar que la variable ``GOOGLE_REDIRECT_URI`` debe ser el mismo valor ingresado en la App de Google Cloud, en el cliente de ``OAuth``. El valor es del componente de Angular que recibe la información de google y la envía al frontend. La ruta es ``(frontend URL)/google/callback``. El flujo de información es el siguiente:

    Frontend llama a la ruta de redirección a Google 
    -> El usuario se registra en Google 
    -> Google envía al frontend la información del inicio de sesión 
    -> frontend envía al backend para verificar y autenticar.
    -> backend veririca, autentica, si es exitoso envía los datos del usuario, sino envía HTTP 401
    -> frontend redirecciona, si fue exitoso en backend permite entrar, sino vuelve al login

## Ejecutar

Al igual que los proyectos de Laravel, sólo con el comando 

    php artisan serve

y se ejecutará en http://localhost:8000.

## Errores frecuentes

### HTTP 419:
- Relacionado con CORS, verificar las variables de entorno ``FRONTEND_URL``, ``SESSION DOMAIN``, ``SANCTUM_STATEFUL_DOMAIN``.

- Verificar en ``config/cors.php``:

        32 | 'supports_credentials' => true,

### HTTP 401

- Verificar los inicios de sesión. La API requiere de un inicio de sesión para que funcionen los endpoints, a excepción de los relacionados con el login.
- Verificar ``SESSION DOMAIN`` sea sólo el dominio (sin esquema, puertos ni decoradores) y ``SANCTUM_STATEFUL_DOMAIN`` sea el dominio y el puerto si se especifica.

### HTTP 500

- Verificar las variables de entorno relacionadas a Google
- Verificar los permisos de Google Cloud / Google Storage
- Verificar que la variable de entorno ``GOOGLE_CLOUD_KEY_FILE`` contenga la ruta absoluta al archivo ``.json`` con la key.