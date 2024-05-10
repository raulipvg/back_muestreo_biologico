# ENTREGA - SPRINT 4
# Backend sistema formularios

Backend para el sistema de formularios y planillas. Requiere de ``php ^8.0``. Además, cuenta con los paquetes ``MathPHP``, ``Socialite`` y ``GoogleCloud\Storage``.
Hay que considerar que tanto la API como el Frontend deben estar en el mismo nivel de dominio.

- Instalar
- Variables de entorno
- Ejecutar


## Instalar

Basta con usar el comando

    composer install

y se instalará los paquetes y dependencias necesarias.

## Variables de entorno

Se recomienda duplicar el archivo ``.exv.example`` y renombrar el archivo duplicado a solo ``.env``, y realizar la siguientes modificaciones:

     7 | FRONTEND_URL= http://localhost:4200     <- URL del frontend
     8 | SESSION_DOMAIN=localhost                <- Solo el dominio, sin puertos ni protocolo
     9 | SANCTUM_STATEFUL_DOMAINS=localhost:4200 <- Sólo el domino y el puerto (si especifica)
    ...
    15 | DB_CONNECTION=pgsql                     <- tipo de base de datos (pgsql)
    16 | DB_HOST=127.0.0.1                       <- host de la base de datos
    17 | DB_PORT=5432                            <- puerto de la base de datos
    18 | DB_DATABASE=formularios                 <- nombre de la base de datos
    19 | DB_USERNAME=postgres                    <- username de la base de datos
    20 | DB_PASSWORD=                            <- contraseña de la base de datos
    ...
    66 | GOOGLE_CLIENT_ID=                       <- Id del cliente de Google
    67 | GOOGLE_CLIENT_SECRET=                   <- Secreto del cliente de Google 
    69 | GOOGLE_REDIRECT_URI=                    <- URL del callback para Google
    ...
    74 | GOOGLE_CLOUD_PROJECT_ID=                <- Id del proyecto de Google
    75 | GOOGLE_CLOUD_KEY_FILE=                  <- Ruta del archivo json de credencial de Google
    76 | GOOGLE_CLOUD_STORAGE_BUCKET=            <- Nombre del Bucket de Google Storage

La variable ``FRONTEND_URL`` corresponde a un ``origin``, por lo tanto, no debe tener algún caracter después del puerto (en caso que se especifique el puerto).

La variable ``SESSION_DOMAIN`` debe ser solo un ``top-level domain``. Si se generan conflictos con la API (respuestas 401), verificar esta variable.

Recordar que la variable ``GOOGLE_REDIRECT_URI`` debe ser el mismo valor ingresado en la App de Google Cloud, en el cliente de ``OAuth``. Este es necesario que sea el componente del frontend que envíe los datos a la API para iniciar sesión.

Para ambiente de desarrollo, se puede dejar ``FRONTEND_URL`` con el valor ``*``, quitar los valores de ``SESSION_DOMAIN`` y ``SANCTUM_STATEFUL_DOMAINS``, además de modificar el archivo ``config/cors.php`` como en la siguiente línea

    32 | 'supports_credentials' => false,


## Ejecutar

Al igual que los proyectos de Laravel, sólo con el comando 

    php artisan serve

y se ejecutará en http://localhost:8000. 