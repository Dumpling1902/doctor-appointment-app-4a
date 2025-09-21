# Conexión con la base de datos

Se configuró el archivo .env para conectar la aplicación con MySQL, ajustando los datos de conexión como el nombre de la base, el usuario y la contraseña. Luego se ejecutaron las migraciones con php artisan migrate y se verificó la correcta creación de las tablas conectándose directamente a MySQL.

# Idioma de la aplicación

En el archivo config/app.php se cambió el idioma por defecto a español ('locale' => 'es'). Esto se comprobó al cargar la aplicación y notar que todos los mensajes del sistema aparecían en español.

# Zona horaria

En el mismo archivo se ajustó la zona horaria a 'timezone' => 'America/Merida'. La verificación se realizó mostrando fechas y horas dentro de la app, asegurando que coincidieran con la zona horaria correcta.

# Foto de perfil

Se reemplazó la imagen de perfil ubicada en la carpeta public/images y se actualizó la vista correspondiente para mostrar la nueva foto. Esto se comprobó accediendo al perfil del usuario y verificando que la imagen mostrada era la actualizada.

# Nuevo Layout

Se creó un layout principal en la carpeta resources/views/layouts. Este archivo organiza la estructura de la página y permite reutilizar el encabezado, el sidebar y el contenido, lo que evitó repetir código en cada vista. Para verificar su funcionamiento se ejecutó el comando php artisan serve.

# Integración de Flowbite

Se instaló Flowbite con el comando npm install flowbite --save. Posteriormente se configuró en tailwind.config.js para que sus componentes funcionaran junto con Tailwind. Para comprobarlo se probaron botones y menús de navegación de Flowbite, confirmando que estaban activos al ejecutar npm run dev.

# Uso de Slots e Includes

Se organizaron partes del diseño en componentes Blade. Con los slots se probó enviar contenido dinámico dentro de los layouts, mientras que con los includes se dividieron secciones como el menú y la barra de navegación, logrando un diseño más modular y reutilizable.