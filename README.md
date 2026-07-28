# Sistema de Gestión de Roles y Usuarios

Proyecto Laravel con autenticación Fortify, CRUD de Roles y Usuarios, y medidas de seguridad implementadas.

## Requisitos

- PHP 8.3+
- Composer
- MariaDB / MySQL
- Node.js (para Tailwind CSS v4)
- Laragon (recomendado)

## Instalación

1. Clonar o copiar el proyecto en `C:\laragon\www\evalweb2b_jhonnyvallejos`

2. Instalar dependencias de PHP:
   ```bash
   composer install
   ```

3. Configurar el archivo `.env` con la conexión a MariaDB:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=db_evalweb2b
   DB_USERNAME=root
   DB_PASSWORD=root
   ```

4. Generar la clave de la aplicación:
   ```bash
   php artisan key:generate
   ```

5. Crear la base de datos en MariaDB:
   ```sql
   CREATE DATABASE IF NOT EXISTS db_evalweb2b CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

6. Ejecutar las migraciones:
   ```bash
   php artisan migrate
   ```

7. Poblar la base de datos con datos de prueba:
   ```bash
   php artisan db:seed
   ```
   Esto crea dos roles (Administrador y Vendedor) y un usuario de prueba:
   - **Email:** test@example.com
   - **Contraseña:** password

8. Instalar dependencias frontend y compilar:
   ```bash
   npm install
   npm run build
   ```

9. Iniciar el servidor:
   ```bash
   php artisan serve
   ```

10. Acceder a `http://localhost:8000`

## Credenciales de Prueba

| Email | Contraseña | Rol |
|---|---|---|
| test@example.com | password | Administrador |

## Estructura del Proyecto

### Migraciones
- `database/migrations/2026_06_23_155427_create_roles_table.php` - Tabla de roles
- `database/migrations/2026_06_23_155428_add_role_id_to_users_table.php` - Agrega role_id a users
- Migraciones estándar de Laravel (users, cache, jobs, etc.)

### Modelos
- `app/Models/Role.php` - Modelo con relación `hasMany` a Users
- `app/Models/User.php` - Modelo con relación `belongsTo` a Role

### Controladores
- `app/Http/Controllers/RoleController.php` - CRUD completo de roles
- `app/Http/Controllers/UserController.php` - CRUD completo de usuarios
- `app/Http/Controllers/DashboardController.php` - Dashboard

### Vistas Blade
- `resources/views/layouts/guest.blade.php` - Layout para páginas públicas
- `resources/views/layouts/app.blade.php` - Layout para páginas autenticadas
- `resources/views/auth/*.blade.php` - Vistas de autenticación
- `resources/views/roles/*.blade.php` - CRUD de roles (index, form)
- `resources/views/users/*.blade.php` - CRUD de usuarios (index, form)
- `resources/views/dashboard.blade.php` - Dashboard

### Middleware
- `app/Http/Middleware/SecurityHeaders.php` - Cabeceras de seguridad (CSP, X-Frame-Options, X-Content-Type-Options, Referrer-Policy)

## Bitácora de Seguridad

### 1. Prevención de Inyección SQL
Todas las consultas utilizan Eloquent ORM o Query Builder con parámetros enlazados. No existe concatenación de la entrada del usuario ni uso inseguro de `DB::raw`.

**Archivos relevantes:**
- `app/Http/Controllers/RoleController.php` - Uso de Eloquent con `where` parametrizado
- `app/Http/Controllers/UserController.php` - Uso de Eloquent con `where` parametrizado
- `app/Http/Requests/SaveRoleRequest.php` - Validación con `Rule::unique`
- `app/Http/Requests/SaveUserRequest.php` - Validación con `Rule::unique`

### 2. Prevención de XSS
Todas las salidas en Blade utilizan la sintaxis `{{ }}` que automáticamente escapa el contenido. No se utiliza `{!! !!}` con datos provenientes del usuario. El buscador refleja la entrada del usuario de forma segura.

**Archivos relevantes:**
- Todas las vistas en `resources/views/` usan `{{ }}` exclusivamente
- El campo de búsqueda muestra el texto ingresado con `{{ $search }}`

### 3. Autenticación y CSRF
- Login/logout funcional mediante Laravel Fortify
- `@csrf` en todos los formularios
- Middleware `throttle:5,1` configurado en Fortify para la ruta de login (5 intentos por minuto)
- Todas las rutas del CRUD protegidas con middleware `auth`

**Configuración:**
- `config/fortify.php` - Configuración de Fortify
- `app/Providers/FortifyServiceProvider.php` - Rate limiting configurado

### 4. Autorización por Roles
Se implementó un Gate `admin` que verifica si el usuario tiene el rol "Administrador".

**Archivos relevantes:**
- `app/Providers/AppServiceProvider.php` - Definición del Gate `admin`
- `app/Http/Controllers/RoleController.php` - `$this->authorize('admin')` en destroy
- `app/Http/Controllers/UserController.php` - `$this->authorize('admin')` en destroy
- `resources/views/roles/index.blade.php` - `@can('admin')` oculta botón de eliminar
- `resources/views/users/index.blade.php` - `@can('admin')` oculta botón de eliminar

### 5. Cabeceras de Seguridad
Middleware `SecurityHeaders` que agrega las siguientes cabeceras HTTP:

| Cabecera | Valor |
|---|---|
| Content-Security-Policy | `default-src 'self'; script-src 'self' 'nonce-{nonce}'; style-src 'self' 'unsafe-inline'; img-src 'self' data:; font-src 'self'; connect-src 'self'; form-action 'self'` |
| X-Frame-Options | `DENY` |
| X-Content-Type-Options | `nosniff` |
| Referrer-Policy | `strict-origin-when-cross-origin` |

**Archivo relevante:**
- `app/Http/Middleware/SecurityHeaders.php`
- Registrado en `bootstrap/app.php` en el grupo `web`

### 6. Validación de Datos
Se utilizan Form Request para validar la entrada de datos:

- `app/Http/Requests/SaveRoleRequest.php` - Validación para roles
- `app/Http/Requests/SaveUserRequest.php` - Validación para usuarios

### 7. Seguridad Adicional
- Contraseñas almacenadas con hash (bcrypt) mediante `'password' => 'hashed'` en el modelo User
- Protección CSRF en todos los formularios
- `MassAssignment` protegido mediante `$fillable` en los modelos
- Rutas protegidas por middleware `auth`
