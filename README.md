INSTALACIÓN
	Para instalar la aplicación en nuestro servidor, basta con subir los archivos que se encuentran en la carpeta “fogones” al directorio raíz del servidor e importar la base de datos que se encuentra en el directorio bd al servidor mysql.
	Deberemos crear un usuario y asignarle los privilegios necesarios para la base de datos “fogones”, como mínimo SELECT, INSERT, UPDATE, DELETE.
Una vez hecho esto, procederemos a la modificación de los archivos de configuración.

CONFIGURACIÓN
	Los archivos de configuración de la aplicación se encuentran dentro de la carpeta config. En ellos se configuran los datos del servidor de la aplicación y los datos de conexión con la base de datos.

	Archivo app.php:

	APP_URL introduciremos la dirección web principal de la aplicación, donde estará nuestro archivo principal, index.php.
	APP_NAME contiene el nombre de la aplicación. Normalmente no se deberá de cambiar. Sólo se utiliza para indicar el nombre de la aplicación en la pestaña de título del navegador.
	APP_SESSION_NAME es el nombre de la sesión. Normalmente permanecerá fijo, a no ser que por alguna razón externa necesitemos cambiarlo por otro.
	Luego establece la zona horaria, por defecto Europe/Madrid, que podremos cambiar si estamos en cualquier otra zona horaria, al igual que las configuraciones locales de idioma y conjunto de caracteres, que por defecto son utf-8 español de España.

	Archivo server.php:

	DB_SERVER la dirección del servidor de base de datos,
	DB_NAME el nombre de la base de datos,
	DB_USER el logiN
	DB_PASS el password que utilizaremos para conectar con nuestro servidor de la base de datos.

	Este usuario ha de tener los privilegios necesarios en el servidor para que la aplicación pueda interactuar con ella.

	Las credenciales para el primer acceso a la aplicación son 
		usuario: Admin 
		password: Admin_1234.

	Una vez logueado, tendrá que acceder al panel de control, ir a la sección usuarios, dar de alta un usuario nuevo con sus datos y asignarle todos los roles en el listado de usuarios del panel de control. Seguidamente, por seguridad, el usuario Admin deberá ser eliminado.

