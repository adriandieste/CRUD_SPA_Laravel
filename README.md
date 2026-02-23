# CRUD SPA Laravel + Vue.js

Una aplicación web moderna construida con **Laravel 11**, **Vue 3** e **Inertia.js** que implementa un sistema CRUD completo para gestionar proyectos y alumnos con autenticación, traducciones multiidioma y una interfaz intuitiva.

## 🎯 Características Principales

- ✅ **Autenticación completa** con Laravel Fortify (Registro, Login, Logout, 2FA)
- ✅ **Gestión CRUD de Alumnos** con validación en tiempo real
- ✅ **Gestión de Proyectos** asociados a usuarios
- ✅ **Traducciones multiidioma** (Español, Inglés, Francés)
- ✅ **Selector de idioma persistente** en el header
- ✅ **Confirmaciones de seguridad** con SweetAlert2
- ✅ **Interfaz responsiva** con Tailwind CSS
- ✅ **Paginación** de datos
- ✅ **Mensajes de éxito/error** con notificaciones Toast

## 📋 Requisitos Previos

Asegúrate de tener instalado lo siguiente:

- **PHP 8.2** o superior
- **Node.js** 18+ y npm
- **Composer**
- **SQLite** o MySQL
- **Git**

## 🚀 Instalación

### 1. Clonar el repositorio

```bash
git clone https://github.com/tu-usuario/crud-spa-laravel.git
cd crud-spa-laravel
```

### 2. Instalar dependencias de PHP

```bash
composer install
```

### 3. Instalar dependencias de Node.js

```bash
npm install
```

### 4. Configurar variables de entorno

```bash
cp .env.example .env
php artisan key:generate
```

Edita el archivo `.env` con tu configuración de base de datos:

```
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database.sqlite
```

O para MySQL:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=crud_spa_laravel
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Ejecutar migraciones

```bash
php artisan migrate:fresh --seed
```

Este comando creará las tablas necesarias e insertará datos de prueba.

### 6. Servir la aplicación

En dos terminales diferentes, ejecuta:

**Terminal 1 - Servidor de desarrollador de Vite:**
```bash
npm run dev
```

**Terminal 2 - Servidor PHP:**
```bash
php artisan serve
```

La aplicación estará disponible en `http://localhost:8000`

**O ejecutar ambos simultáneamente:**
```bash
npm run local
```

## 📝 Datos de Prueba

Al ejecutar las migraciones con seed, se crean automáticamente:

- **Usuario de prueba:**
  - Email: `test@example.com`
  - Contraseña: `password`

- **Proyecto de prueba** con 10 alumnos ficticios

## 🏗️ Estructura del Proyecto

### Backend (Laravel)

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── ProyectoController.php    # Controlador de proyectos
│   │   └── AlumnoController.php      # Controlador de alumnos
│   └── Middleware/
├── Models/
│   ├── User.php
│   ├── Proyecto.php
│   └── Alumno.php
├── Policies/
│   └── ProyectoPolicy.php             # Autorización
└── Providers/

database/
├── migrations/
├── factories/
└── seeders/

routes/
├── web.php                            # Rutas principales
└── settings.php                       # Rutas de autenticación
```

### Frontend (Vue 3)

```
resources/js/
├── app.ts                             # Entry point
├── pages/
│   ├── Welcome.vue                    # Página de inicio
│   ├── Dashboard.vue                  # Dashboard principal
│   ├── Proyectos/
│   │   └── Index.vue                  # Lista de proyectos
│   └── Alumnos/
│       └── Index.vue                  # CRUD de alumnos
├── layouts/
│   ├── AppLayout.vue                  # Layout principal
│   ├── AuthLayout.vue                 # Layout de autenticación
│   └── app/
│       └── AppSidebarLayout.vue       # Layout con sidebar
├── components/
│   ├── LanguageSwitcher.vue           # Selector de idioma
│   ├── AppHeader.vue                  # Header
│   └── ...otros componentes
├── composables/
│   ├── useTranslation.ts              # Gestión de traducciones
│   ├── useAppearance.ts               # Tema oscuro/claro
│   └── ...otros composables
├── i18n/
│   ├── es.json                        # Traducciones al español
│   ├── en.json                        # Traducciones al inglés
│   └── fr.json                        # Traducciones al francés
├── routes/                            # Rutas generadas por Wayfinder
└── wayfinder/
```

## 🔐 Funcionalidades de Seguridad

- **Autorización basada en Policies**: Solo los propietarios de proyectos pueden ver sus alumnos
- **Validación de formularios**: En backend y frontend
- **Protección CSRF**: Incluida en todos los formularios
- **Middleware de autenticación**: Rutas protegidas
- **Contraseñas hasheadas**: Con bcrypt

## 🌐 Traducciones

### Idiomas soportados:

- 🇪🇸 **Español** (por defecto)
- 🇬🇧 **Inglés**
- 🇫🇷 **Francés**

Las traducciones se almacenan en `resources/js/i18n/` con archivos JSON por idioma.

El idioma se **persiste** en localStorage, permitiendo que el usuario mantenga su preferencia entre sesiones.

### Uso en componentes:

```vue
<script setup>
import { useTranslation } from '@/composables/useTranslation'
const { t, currentLocale, setLocale } = useTranslation()
</script>

<template>
  <h1>{{ t('dashboard.welcome') }}</h1>
  <p>Idioma actual: {{ currentLocale }}</p>
</template>
```

## 📊 Base de Datos

### Tablas principales:

#### Users
```sql
- id (PK)
- name
- email (UNIQUE)
- password
- email_verified_at
- two_factor_secret
- two_factor_recovery_codes
- remember_token
- timestamps
```

#### Proyectos
```sql
- id (PK)
- nombre
- descripcion
- user_id (FK -> users)
- timestamps
```

#### Alumnos
```sql
- id (PK)
- nombre
- email (UNIQUE)
- telefono
- fecha_nacimiento
- proyecto_id (FK -> proyectos)
- timestamps
```

### Relaciones:

- Un `User` tiene muchos `Proyecto`s
- Un `Proyecto` tiene muchos `Alumno`s

## 🔌 API Endpoints

### Proyectos
- `GET /proyectos` - Listar todos los proyectos del usuario
- `GET /proyectos/{id}` - Ver detalles de un proyecto

### Alumnos
- `GET /proyectos/{proyecto}/alumnos` - Listar alumnos de un proyecto
- `POST /proyectos/{proyecto}/alumnos` - Crear nuevo alumno
- `PUT /proyectos/{proyecto}/alumnos/{alumno}` - Actualizar alumno
- `DELETE /proyectos/{proyecto}/alumnos/{alumno}` - Eliminar alumno

## 🎨 Tecnologías Utilizadas

### Backend
- **Laravel 11** - Framework PHP
- **Laravel Fortify** - Autenticación
- **Inertia.js** - Comunicación frontend-backend

### Frontend
- **Vue 3** - Framework JavaScript
- **TypeScript** - Tipado estático
- **Tailwind CSS** - Estilos
- **Vite** - Build tool
- **vue-i18n** - Internacionalización (aunque usamos una solución customizada)
- **SweetAlert2** - Confirmaciones y alertas

### Desarrollo
- **ESLint** - Linter
- **Prettier** - Formateador de código
- **PHPUnit** - Testing de PHP
- **Pest** - Testing moderno de PHP

## 📦 Dependencias principales

```json
{
  "dependencies": {
    "@inertiajs/vue3": "^2.3.7",
    "@vueuse/core": "^12.8.2",
    "laravel-vite-plugin": "^2.0.0",
    "lucide-vue-next": "^0.468.0",
    "reka-ui": "^2.6.1",
    "tailwindcss": "^4.1.1",
    "tailwind-merge": "^3.2.0",
    "vue": "^3.5.13",
    "sweetalert2": "^11.x.x",
    "vue-i18n": "^9.x.x"
  }
}
```

## 🧪 Testing

### Ejecutar tests PHP:

```bash
php artisan test
```

### Ejecutar tests específicos:

```bash
php artisan test --filter=AlumnoTest
```

📝 **Commits Importantes**

La práctica requiere mínimo **un commit diario** reflejando el trabajo de clase. Ejemplo:

```bash
git add .
git commit -m "feat: agregar CRUD de alumnos"
git push origin master
```

Mensajes de commit usados en este proyecto:
- ✅ `feat: implementar base de datos con modelos Proyecto y Alumno`
- ✅ `feat: crear controllers ProyectoController y AlumnoController`
- ✅ `feat: agregar factories, seeders y authorization policies`
- ✅ `feat: implementar composable de traducciones multiidioma (ES/EN/FR)`
- ✅ `feat: crear páginas Vue para Proyectos y CRUD de Alumnos`
- ✅ `feat: agregar LanguageSwitcher component`
- ✅ `feat: mejorar Dashboard con estadísticas y tablas`
- ✅ `feat: reemplazar Welcome.vue con diseño moderno sin Laravel starter kit`
- ✅ `feat: mejorar Login y Register con diseño responsive`
- ✅ `fix: arreglar acceso a alumnos y funcionalidad CRUD`

## 🚀 Deployment

### Compilar para producción:

```bash
npm run build
```

### Build SSR (Server-Side Rendering):

```bash
npm run build:ssr
```

## 📄 Licencia

Este proyecto está bajo licencia MIT.

## 👥 Autor

Desarrollado como práctica educativa de Laravel y Vue.js

## 🤝 Contribuciones

Las contribuciones son bienvenidas. Por favor:

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## ❓ Soporte

Para problemas y preguntas, abre un issue en el repositorio.

---

**¡Disfruta desarrollando tu aplicación CRUD SPA!** 🚀
