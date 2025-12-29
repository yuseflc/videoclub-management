<?php

namespace Dwes\ProyectoVideoclub\Util;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Psr\Log\LoggerInterface;

/**
 * LogFactory - Factoría para crear loggers de Monolog
 * 
 * Esta clase centraliza la configuración y creación de loggers para evitar
 * código duplicado en los constructores de diferentes clases.
 * 
 * Patrón de diseño: Factoría (Factory Pattern)
 * Ventajas:
 * - Código centralizado y reutilizable
 * - Cambios en la configuración de logs en un solo lugar
 * - Facilita el mantenimiento y las pruebas
 */
class LogFactory {
    
    // Ruta del archivo de logs (relativa al archivo factory)
    private static $logDir;
    
    /**
     * Inicializa la ruta del directorio de logs
     * Se debe llamar antes de crear loggers
     * 
     * @param string $logDir Ruta del directorio de logs (absoluta)
     */
    public static function setLogDir($logDir) {
        self::$logDir = $logDir;
    }
    
    /**
     * Crea y configura un Logger de Monolog
     * 
     * Encapsula toda la lógica de configuración de Monolog:
     * - Crea el directorio de logs si no existe
     * - Instancia el logger
     * - Añade el handler de escritura en archivo
     * 
     * @param string $loggerName Nombre del logger (para identificar en los logs)
     * @return LoggerInterface Logger configurado y listo para usar
     */
    public static function createLogger($loggerName = 'VideoclubLogger'): LoggerInterface {
        // Si no se ha inicializado el directorio, usamos la ruta por defecto
        if (self::$logDir === null) {
            self::$logDir = __DIR__ . '/../../logs';
        }
        
        // Creamos el directorio de logs si no existe
        if (!is_dir(self::$logDir)) {
            mkdir(self::$logDir, 0755, true);
        }
        
        // Instanciamos el logger
        $logger = new Logger($loggerName);
        
        // Añadimos el handler de stream para escribir en archivo
        // Nivel DEBUG incluye todos los mensajes desde debug en adelante
        $logger->pushHandler(
            new StreamHandler(
                self::$logDir . '/videoclub.log',
                Logger::DEBUG
            )
        );
        
        return $logger;
    }
}
