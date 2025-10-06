<?php
/* Configuración de la aplicación */
    /* URL de la aplicación */
    const APP_URL = "http://192.168.1.53/fogones/";
    /* NOMBRE de la APLICACIÓN */
    const APP_NAME = "Fogones Conectados";
    /* NOMBRE de la SESIÓN DE LA APLICACIÓN */
    const APP_SESSION_NAME = "FOGONES";
    /* ZONA HORARIA PREDETERMINADA*/
    date_default_timezone_set("Europe/Madrid");
    /* CONFIGURACIÓN DE FECHAS */
    setlocale(LC_TIME, 'es_ES.UTF-8', 'esp');