# Cambios y mejoras Ticotiempos

## 3 de septiembre de 2025

### Restricción automática por fecha (número del día)
- Se eliminó la restricción absoluta que impedía jugar el número igual al día actual.
- Ahora solo se restringe si el monto es mayor al monto editable configurado en el sorteo.
- El backend valida que solo se bloquee la jugada si el número es igual al día actual **y** el monto supera el monto editable.
- El frontend muestra el mensaje de bloqueo solo si ambas condiciones se cumplen.

### Documentación de apertura/cierre de sorteos
- Se agregaron instrucciones para abrir sorteos manualmente usando Tinker y comandos Artisan.
- Se documentó cómo abrir todos los sorteos cerrados desde la base de datos.
- Se validó y documentó la automatización de apertura/cierre de sorteos en el scheduler de Laravel.
- Se recomendó configurar el cron para ejecutar el scheduler cada minuto.

### Cambios eliminados de INSTALACION.md
- Se movió la sección "Apertura manual de sorteos" y los comandos de apertura/cierre a este archivo de cambios.
- INSTALACION.md ahora solo contiene la guía de instalación y configuración básica.

---

## Resumen de cambios realizados en el backend
- Validación de jugadas para que el número del día solo se bloquee si el monto supera el monto editable.
- Eliminación de la restricción absoluta para el número del día.
- Ajuste en la lógica de visualización y validación de sorteos abiertos.
- Mejoras en la documentación y procedimientos de apertura/cierre manual y automatizada.

---

## Recomendaciones
- Revisar este archivo para conocer los cambios y mejoras aplicadas al sistema.
- Mantener INSTALACION.md solo para instalación y configuración inicial.
- Usar este archivo para registrar futuras modificaciones y actualizaciones importantes.
