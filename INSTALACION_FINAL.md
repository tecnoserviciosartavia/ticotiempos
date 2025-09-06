# Comandos finales para instalación y optimización de Laravel

Ejecuta estos comandos después de instalar y configurar tu proyecto para asegurar que todo funcione correctamente:

```
php artisan config:cache
php artisan cache:clear
php artisan optimize:clear
php artisan schedule:list
php artisan start:balance
```

Estos comandos:
- Regeneran la caché de configuración.
- Limpian la caché de la aplicación.
- Limpian archivos de optimización.
- Muestran las tareas programadas.
- Inician el balance de usuarios (si tienes el comando definido).

**Recomendación:**
Ejecuta estos comandos cada vez que cambies variables en `.env`, configures nuevos servicios o actualices el código.
