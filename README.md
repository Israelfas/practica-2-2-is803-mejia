# Práctica 2.2 – DTO y contratos de intercambio JSON (IS-803)

**Estudiante:** Marcelo Israel Mejía Chamorro · 8.º nivel / A
**Proyecto de aula:** Correos – Productos Dañados
**Proceso:** Registrar pedido de un producto dañado
**Endpoint:** `POST /api/v1/pedidos` (consulta: `GET /api/v1/pedidos/{id}`)
**Cierre de la entrega:** domingo 15 de noviembre de 2026, 23:59

Este README cubre todo: instalar, ejecutar, probar, documentar y entregar.

## Qué se debe realizar

1. Crear el proyecto Laravel y copiar el módulo (pasos 2 y 3).
2. Migrar, cargar los datos de prueba y levantar el servidor (paso 4).
3. Ejecutar las pruebas automáticas (paso 5).
4. Ejecutar P1, P2 y P3 en Postman (paso 6).
5. Subir el código al repositorio (paso 7).
6. Pegar las capturas en el informe, ajustar la reflexión y exportarlo (paso 8).
7. Entregar en la plataforma (paso 9).

## Capturas que se deben tomar

Cada paso marcado con 📸 indica el momento de tomarla. Guárdalas con el nombre de la tabla.

| # | Archivo | Qué debe verse | Paso | ¿Obligatoria? |
| --- | --- | --- | --- | --- |
| 1 | `01-migracion-seeder.png` | Terminal con `migrate` y `db:seed` terminados sin error | 4 | Recomendada |
| 2 | `02-tests.png` | Terminal con las 3 pruebas en verde | 5 | Recomendada |
| 3 | `03-P1-201.png` | Postman: JSON enviado, estado `201 Created` y respuesta | 6 | **Sí** |
| 4 | `04-P2-422.png` | Postman: JSON sin `producto_id`, estado `422` y `errors` | 6 | **Sí** |
| 5 | `05-P3-422.png` | Postman: `"cantidad": "dos"`, estado `422` y `errors` | 6 | **Sí** |
| 6 | `06-no-persiste-404.png` | Postman: `GET /pedidos/2` con estado `404` | 6 | Recomendada |
| 7 | `07-repositorio.png` | GitHub con los archivos subidos y sin `.env` | 7 | Recomendada |

En las capturas de Postman deben verse a la vez la URL, el cuerpo enviado, el código de estado y la respuesta. No muestres contraseñas, tokens ni el contenido de `.env`.

---

## 1. Requisitos

- PHP 8.2 o superior (`php -v`)
- Composer (`composer -V`)
- Postman
- Git

## 2. Crear el proyecto Laravel

```bash
composer create-project laravel/laravel practica22
cd practica22
php artisan install:api
```

Si `install:api` pregunta si quieres ejecutar las migraciones pendientes, responde **yes**.

Laravel usa SQLite por defecto, así que no hay que configurar base de datos ni tocar el `.env`.

## 3. Copiar el módulo

Copia estas carpetas del zip dentro de `practica22`, aceptando reemplazar archivos:

| Del zip | Va en |
| --- | --- |
| `app/` | `practica22/app/` |
| `database/` | `practica22/database/` |
| `routes/api.php` | `practica22/routes/api.php` (reemplaza el existente) |
| `tests/` | `practica22/tests/` |

En PowerShell, estando dentro de `practica22` y con el zip descomprimido en Descargas:

```powershell
$m = "$HOME\Downloads\practica-2-2-mejia-marcelo"
Copy-Item "$m\app","$m\database","$m\routes","$m\tests" -Destination . -Recurse -Force
Copy-Item "$m\README.md","$m\Practica_2_2.postman_collection.json" -Destination . -Force
```

## 4. Base de datos y servidor

```bash
php artisan migrate
php artisan db:seed --class=Practica22Seeder
php artisan serve
```

El seeder crea 1 cliente (id 1) y 3 productos dañados (ids 1, 2 y 3), todos ficticios.
El servidor queda en `http://127.0.0.1:8000`. Déjalo abierto.

📸 **Captura 1:** la terminal con `migrate` y `db:seed` terminados.

## 5. Pruebas automáticas

En otra terminal, dentro de `practica22`:

```bash
php artisan test --filter=PedidoContratoTest
```

Deben pasar 3 pruebas (P1, P2 y P3).

📸 **Captura 2:** la terminal con las 3 pruebas en verde.

## 6. Pruebas en Postman (las 3 capturas obligatorias)

1. Postman → **Import** → selecciona `Practica_2_2.postman_collection.json`.
2. Ejecuta las peticiones en este orden y toma una captura de cada una donde se vean el cuerpo enviado, el código de estado y la respuesta:

| Caso | Petición | Resultado esperado |
| --- | --- | --- |
| P1 | `P1 - JSON válido (201)` | `201 Created`, JSON con `data` y `mensaje`, `total` 49.0 |
| P2 | `P2 - Falta producto_id (422)` | `422`, `errors.producto_id` |
| P3 | `P3 - cantidad con tipo incorrecto (422)` | `422`, `errors.cantidad` |

   📸 **Capturas 3, 4 y 5:** una por cada caso, justo después de pulsar **Send**.

3. Para demostrar que P2 y P3 no guardaron nada, ejecuta `Consultar pedido (200)` cambiando la URL a `/pedidos/2`: debe responder `404`. Solo existe el pedido 1, creado en P1.

   📸 **Captura 6:** la respuesta `404`.

Todas las peticiones ya llevan `Accept: application/json`. Sin ese encabezado Laravel responde HTML en lugar de JSON.

## 7. Subir el código

Repositorio propio (crea antes un repo vacío en GitHub, sin README):

```bash
git init -b main
git add .
git status          # confirma que .env NO aparece en la lista
git commit -m "Práctica 2.2: DTO y contrato JSON de pedidos"
git remote add origin https://github.com/TU_USUARIO/practica-2-2-is803.git
git push -u origin main
```

El `.gitignore` de Laravel ya excluye `.env` y `vendor/`. No subas contraseñas ni tokens.

📸 **Captura 7:** la página del repositorio con los archivos subidos.

Si el docente pide que esté en el repositorio del equipo, crea una rama con tu nombre (`git checkout -b practica-2-2-mejia`) y sube el proyecto en una carpeta propia, por ejemplo `practicas/2-2-mejia/`.

## 8. Completar el informe

En el documento "Práctica 2.2 – DTO y contratos de intercambio JSON":

1. Sección 4: reemplaza cada `[Insertar captura…]` por las capturas 3, 4 y 5. Las capturas 1, 2, 6 y 7 puedes añadirlas como evidencia adicional en esa misma sección.
2. Sección 7: pega el enlace del repositorio.
3. Sección 6: reescribe la reflexión con tus palabras.
4. Revisa que los JSON de ejemplo coincidan con lo que te devolvió Postman (la fecha y el id pueden variar).
5. Completa la fecha en el encabezado si el docente pide el formato de la guía (Estudiante / Curso / Fecha).
6. Exporta el informe a PDF.

### Contenido que debe tener el PDF completo

| Orden | Sección del PDF | De dónde sale | Capturas |
| --- | --- | --- | --- |
| 1 | Datos del estudiante, curso y fecha | Encabezado del informe | — |
| 2 | Proceso, actores y endpoint (Actividad 1) | Sección 1 | — |
| 3 | Contrato JSON de solicitud y respuesta con tablas (Actividad 2) | Sección 2 | — |
| 4 | Implementación en Laravel y códigos HTTP (Actividad 3) | Sección 3 | 1 |
| 5 | Pruebas P1, P2 y P3 con resultados (Actividad 4) | Sección 4 | 2, 3, 4, 5 y 6 |
| 6 | Campos ambiguos sin documentación | Sección 4 | — |
| 7 | Serialización, deserialización y diagrama | Sección 5 | — |
| 8 | Reflexión individual | Sección 6 | — |
| 9 | Instrucciones de ejecución y enlace al repositorio | Sección 7 | 7 |

Debajo de cada captura escribe una línea con lo que demuestra, por ejemplo: "P2: al faltar `producto_id` la API responde 422 y no crea el pedido".

## 9. Entrega

Antes de subir a la plataforma, verifica:

- [ ] Las 3 pruebas automáticas pasan
- [ ] 3 capturas de Postman (P1, P2, P3) pegadas en el informe
- [ ] Tablas del contrato de solicitud y de respuesta (sección 2)
- [ ] Explicación de serialización y deserialización (sección 5)
- [ ] Diagrama cliente web / móvil → API → servicio (sección 5)
- [ ] Reflexión individual en tus palabras (sección 6)
- [ ] Enlace al repositorio, sin `.env`
- [ ] Informe exportado y subido antes del domingo 15 de noviembre, 23:59

---

## Referencia rápida

### Estructura del módulo

| Archivo | Rol |
| --- | --- |
| `routes/api.php` | Rutas del endpoint |
| `app/Http/Requests/StorePedidoRequest.php` | Validación del contrato de solicitud |
| `app/DTOs/CrearPedidoDTO.php` | DTO de entrada (deserialización) |
| `app/Services/PedidoService.php` | Lógica: stock, total, transacción |
| `app/Http/Resources/PedidoResource.php` | Contrato de respuesta (serialización) |
| `app/Http/Controllers/Api/PedidoController.php` | Controlador |
| `app/Models/` | Modelos `Pedido` y `ProductoDanado` |
| `database/migrations/`, `database/seeders/` | Tablas y datos de prueba |
| `tests/Feature/PedidoContratoTest.php` | Pruebas P1, P2 y P3 |

### Códigos HTTP

| Código | Caso |
| --- | --- |
| 201 | Pedido registrado |
| 200 | Consulta de pedido |
| 404 | Pedido no encontrado |
| 409 | Stock insuficiente |
| 422 | Error de validación |

### Problemas comunes

| Síntoma | Solución |
| --- | --- |
| `404` en `/api/v1/pedidos` | Falta `php artisan install:api` o no se reemplazó `routes/api.php`. Revisa con `php artisan route:list` |
| Responde HTML en vez de JSON | Agrega el encabezado `Accept: application/json` |
| `422`: el cliente o producto no existe | No se ejecutó el seeder (paso 4) |
| `Class "App\DTOs\CrearPedidoDTO" not found` | La carpeta `app/DTOs` no se copió; si persiste, `composer dump-autoload` |
| `no such table: pedidos` | Falta `php artisan migrate` |
| `409 Stock insuficiente` tras varias pruebas | Reinicia los datos: `php artisan migrate:fresh` y vuelve a ejecutar el seeder |