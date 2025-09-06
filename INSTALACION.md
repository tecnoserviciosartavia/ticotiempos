## Comandos iniciales tras la instalación
Ejecuta estos comandos la primera vez que instales o clones el proyecto:

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan config:cache
php artisan cache:clear
php artisan optimize:clear
php artisan schedule:list
php artisan start:balance
```

Si tienes un archivo de base de datos:
```bash
mysql -u root -p ticotiempos < tiempos.sql
```

Estos comandos preparan el entorno, migran la base de datos y configuran la aplicación para el primer uso.
# Solución a errores de Composer por extensión DOM faltante

Si al ejecutar `composer update` aparece un error relacionado con la extensión `ext-dom` (por ejemplo, para PHPUnit), instala la extensión XML correspondiente a tu versión de PHP:

```bash
sudo apt-get install php8.4-xml
```

Luego verifica que esté activa:

```bash
php -m | grep dom
```

Después vuelve a ejecutar:

```bash
composer update
```

Esto resolverá el problema y permitirá actualizar los paquetes correctamente.
# Guía de instalación Ticotiempos
## Permisos de archivos y carpetas (Laravel y Node.js)
Para evitar errores de acceso al escribir logs y resultados:
```bash
sudo chown -R www-data:www-data /var/www/ticotiempos
sudo chmod 664 /var/www/ticotiempos/resultados_log.txt
sudo chmod -R 775 /var/www/ticotiempos/storage /var/www/ticotiempos/bootstrap/cache
```
Esto asegura que tanto Laravel como Node.js puedan escribir en los archivos necesarios.

---

## Configuración de zona horaria (Costa Rica)


1. **Configurar zona horaria en Laravel**
   - Editá el archivo `config/app.php` y asegurate que la línea sea:
     'timezone' => 'America/Costa_Rica',
     ```

   - Editá el archivo `php.ini` (puede estar en `/etc/php/8.x/cli/php.ini` y `/etc/php/8.x/apache2/php.ini`):
     ```ini
     date.timezone = America/Costa_Rica
     ```
   - Reiniciá Apache si modificás el archivo para web:
     ```bash
     sudo systemctl restart apache2
     ```

3. **Configurar zona horaria en el sistema operativo (opcional)**
   - Para Linux:
     ```bash
     sudo timedatectl set-timezone America/Costa_Rica
     ```
   - Verificá la zona horaria actual:
     ```bash
     timedatectl
     ```

**Recomendación:**
- Validá la hora con `php -r 'echo date("Y-m-d H:i:s");'` y con `date` en la terminal.
- Esto asegura que los sorteos y registros funcionen correctamente con la hora local de Costa Rica.

---

🛠️ 1. Requisitos previos
sudo apt update && sudo apt upgrade -y
sudo apt install apache2 php8.3 php8.3-mysql php8.3-cli php8.3-curl php8.3-mbstring php8.3-xml php8.3-zip unzip curl git mariadb-server composer -y
• Verificá que PHP esté en la versión correcta:
php -v
📁 2. Clonar tu proyecto Laravel
cd /var/www/
sudo git clone https://tu-repo/ticotiempos.git
________________________________________
🔐 3. Configurar permisos y dependencias
sudo chown -R www-data:www-data .
sudo chmod -R 775 storage bootstrap/cache
composer install
________________________________________
⚙️ 4. Configurar .env
cp .env.example .env
php artisan key:generate
Editá .env con tus credenciales de base de datos:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ticotiempos
DB_USERNAME=usuario
DB_PASSWORD=clave
________________________________________
🧱 5. Crear base de datos y migrar
sudo mysql -u root -p
CREATE DATABASE ticotiempos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
exit
php artisan migrate
Si tenés un archivo tiempos.sql:
🌐 6. Configurar Apache
sudo nano /etc/apache2/sites-available/ticotiempos.conf
Contenido del VirtualHost:
<VirtualHost *:80>
    ServerName ticotiempos.local
    DocumentRoot /var/www/ticotiempos/public

    <Directory /var/www/ticotiempos/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/ticotiempos_error.log
    CustomLog ${APACHE_LOG_DIR}/ticotiempos_access.log combined
</VirtualHost>
Activar el sitio:
sudo a2ensite ticotiempos.conf
sudo a2enmod rewrite
sudo systemctl restart apache2
________________________________________
🔒 7. Acceso local y seguridad
• Si solo querés acceso desde red local, podés restringir con:
<Directory /var/www/ticotiempos/public>
    Require ip 192.168.0.0/16
</Directory>
________________________________________
🧪 8. Validación y pruebas
• Verificá que el sitio cargue en http://ticotiempos.local
• Si usás VPN o red externa, asegurate de que el puerto 80 esté abierto y el DNS resuelva correctamente.
________________________________________
🧠 Extras útiles
• Restablecer contraseña manualmente:
php artisan tinker
>>> use App\Models\User;
>>> $u = User::find(1);
>>> $u->password = bcrypt('nueva_clave');
>>> $u->save();
• Ver errores en logs:
tail -f storage/logs/laravel.log

1. Editá el archivo `app/Http/Middleware/TrustProxies.php` y asegurate que la propiedad `$proxies` esté así:
    ```php
    protected $proxies = '*';
    ```
        Request::HEADER_X_FORWARDED_FOR |
        Request::HEADER_X_FORWARDED_PORT |
        Request::HEADER_X_FORWARDED_AWS_ELB;
    ```
3. Esto permite que Laravel detecte correctamente el esquema HTTPS y las IPs reales del cliente cuando está detrás de un proxy.

4. En la configuración de Apache, asegurate de reenviar los encabezados `X-Forwarded-*` al backend. Ejemplo de configuración en el VirtualHost:
    ```
    ProxyPreserveHost On
    ProxyPass / http://127.0.0.1:8000/
    ProxyPassReverse / http://127.0.0.1:8000/
    ```

5. Reiniciá Apache después de los cambios:
    ```
    sudo systemctl restart apache2
    ```
---

# Comandos finales para instalación y optimización de Laravel

Ejecuta estos comandos después de instalar y configurar tu proyecto para asegurar que todo funcione correctamente:
php artisan optimize:clear
php artisan schedule:list
php artisan start:balance
```

Estos comandos:
- Regeneran la caché de configuración.
- Limpian archivos de optimización.
- Muestran las tareas programadas.
- Inician el balance de usuarios (si tienes el comando definido).

Ejecuta estos comandos cada vez que cambies variables en `.env`, configures nuevos servicios o actualices el código.

---

## Comandos para iniciar y cerrar juegos

Para iniciar todos los juegos:
```
php artisan start:matches
```

Para cerrar todos los juegos:
```
php artisan close:matches
```

Si tienes los comandos personalizados:
```
php artisan start:gamens
php artisan close:gamens
```

Para iniciar el balance:
```
php artisan start:balance
```

**Recomendación:**
Ejecuta estos comandos después de reiniciar el sistema, al inicio del día o cuando necesites resetear el estado de los juegos.

---

## Cambios y mejoras documentados

### 2 de septiembre de 2025
- Se agregó validación en el backend para que no se pueda jugar el número igual al día actual (restricción automática por fecha) en el método `store` de `VentaController.php`.
- Si el usuario intenta jugar el número del día, se muestra un mensaje y no se permite la jugada.

---

## Verificar y configurar el crontab para la automatización

Para que los comandos programados (como la apertura automática de juegos) se ejecuten correctamente, asegurate de que el cron de Linux esté configurado para ejecutar el scheduler de Laravel cada minuto.

1. **Verificar el crontab actual**
   Ejecutá en la terminal:
   ```bash
   crontab -l
   ```
   Si ves una línea similar a la siguiente, el scheduler está activo:
   ```bash
   * * * * * cd /var/www/ticotiempos && php artisan schedule:run >> /dev/null 2>&1
   ```
   Si no aparece, agregalo con:
   ```bash
   crontab -e
   ```
   Y añadí la línea anterior.

2. **Recomendaciones**
   - Asegurate de que la ruta corresponda a la carpeta de tu proyecto.
   - El usuario que ejecuta el cron debe tener permisos sobre la carpeta y PHP.
   - Podés verificar la ejecución revisando los logs en `storage/logs/laravel.log`.

3. **Comando para ver tareas programadas**
   ```bash
   php artisan schedule:list
   ```
   Así podés confirmar que los comandos de apertura/cierre están programados.

---

## Migrar comandos directos al scheduler de Laravel

En vez de programar cada comando por separado en el crontab, se recomienda usar el scheduler de Laravel para centralizar la lógica y facilitar el mantenimiento.

### 1. Modificar el crontab

Reemplazá todas las líneas de comandos directos por una sola línea:
```bash
* * * * * cd /var/www/html/ticotiempos && php artisan schedule:run >> /dev/null 2>&1
```
Esto ejecuta el scheduler de Laravel cada minuto.

### 2. Registrar los comandos en el scheduler

Editá el archivo `app/Console/Kernel.php` y agregá en el método `schedule`:
```php
protected function schedule(Schedule $schedule)
{
    $schedule->command('start:gamens')->everyFiveMinutes();
    $schedule->command('close:gamens')->everyTenMinutes();
    $schedule->command('optimize:clear')->hourly();
    $schedule->command('start:balance')->dailyAt('06:00');
    // Otros comandos personalizados
}
```
Ajustá la frecuencia y horarios según tus necesidades.

### 3. Verificar la programación

Usá:
```bash
php artisan schedule:list
```
para ver los comandos programados y confirmar que todo está correcto.

**Ventajas:**
- Centraliza la lógica de automatización en Laravel.
- Más fácil de mantener y modificar.
- Permite usar condiciones y lógica adicional si lo necesitás.

---

## Apertura manual de sorteos

Si la automatización falla o necesitás abrir sorteos manualmente, podés hacerlo usando Tinker o los comandos Artisan.

### 1. Usar Tinker para abrir un sorteo manualmente

Ejecutá en la terminal:
```bash
php artisan tinker
```
Luego, ejecutá los siguientes comandos dentro de Tinker:
```php
use App\Models\Venta_cabecera;
$vc = Venta_cabecera::where('fecha', date('Y-m-d'))->where('hora', '16:30')->first();
$vc->estatus = 'abierto';
$vc->save();
```
Ajustá la hora y fecha según el sorteo que querés abrir.

### 2. Usar comandos Artisan personalizados

Si tenés comandos definidos para abrir/cerrar sorteos, podés ejecutarlos así:
```bash
php artisan start:gamens
php artisan close:gamens
php artisan start:matches
php artisan close:matches
php artisan start:balance
```
Estos comandos también pueden ejecutarse manualmente si la automatización no funciona.

### 3. Verificar el estado de los sorteos

Podés verificar los sorteos abiertos con:
```bash
php artisan tinker
>>> App\Models\Venta_cabecera::where('estatus', 'abierto')->get();
```

### Recomendaciones
- Si la automatización falla, revisá los logs en `storage/logs/laravel.log`.
- Asegurate de que el cron esté activo y el scheduler de Laravel esté ejecutándose.
- Si modificás el estado manualmente, verificá que los cambios se reflejen en la pantalla de ventas.

---

## Automatización y robustez en la carga de resultados desde JPS

Para asegurar que los resultados de sorteos se actualicen automáticamente y de forma robusta desde el API de JPS:

### 1. Mejorar el script `actualizar_resultados.js`
- Validá que el script maneje correctamente errores de red, formato y respuesta vacía.
- Agregá logs en consola y en archivo para registrar cada intento de actualización (éxito y error).
- Si el API no responde o el formato es incorrecto, el script debe notificarlo y no sobrescribir el archivo `resultados.txt` con datos inválidos.
- Ejemplo de ejecución manual:
  ```bash
  node actualizar_resultados.js
  tail -f resultados.txt
  ```

### 2. Validar los jobs de Laravel
- Los jobs `NutrirResultado`, `CalculateWinners` y `RecalculateWinners` leen `resultados.txt`.
- Asegurate que estos jobs manejen errores de lectura, formato y datos faltantes, registrando los problemas en `storage/logs/laravel.log`.
- Si el archivo no se actualiza o tiene datos inválidos, los jobs deben notificarlo en los logs y evitar actualizar resultados erróneos.

### 3. Documentar el flujo completo de actualización
- El flujo es:
  1. El script Node.js consulta el API de JPS y actualiza `resultados.txt`.
  2. Los jobs de Laravel leen el archivo y actualizan los resultados en la base de datos.
  3. Si hay errores, se registran en los logs y se puede ejecutar manualmente el script o los jobs.
- Para forzar la actualización manual:
  ```bash
  node actualizar_resultados.js
  php artisan queue:work --stop-when-empty
  ```

### 4. Recomendaciones de monitoreo y solución de problemas
- Revisá los logs de Laravel y del script Node.js para identificar problemas de automatización.
- Si la automatización falla, podés actualizar manualmente los resultados y ejecutar los jobs desde la terminal.
- Validá que la automatización funcione en todos los horarios y tipos de sorteo realizando pruebas periódicas.

---