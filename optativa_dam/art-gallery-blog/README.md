# ArtGram - Proyecto PHP MVC

Este proyecto es una red social tipo Instagram construida desde cero utilizando una arquitectura **MVC (Modelo-Vista-Controlador)** sin frameworks externos.

## Estructura del Proyecto

El proyecto sigue una estructura profesional para separar la lógica de la presentación:

```
/art-gallery-blog
│
├── /app                # Lógica de la aplicación
│   ├── /core           # Núcleo del framework (Router, Database, Controller)
│   ├── /controllers    # Controladores (Manejan las peticiones del usuario)
│   ├── /models         # Modelos (Acceso a datos y lógica de negocio)
│   └── /views          # Vistas (Plantillas HTML/PHP)
│
├── /public             # Carpeta pública (Único punto de acceso del navegador)
│   ├── index.php       # Entry Point (Inicia la app y el router)
│   ├── css/            # Estilos
│   ├── js/             # Scripts del frontend (AJAX)
│   └── uploads/        # Imágenes subidas por usuarios
│
└── /data               # "Base de datos" (Archivos JSON)
```

## Conceptos Clave Implementados

### 1. Enrutamiento (Router)
En lugar de archivos sueltos (`login.php`, `profile.php`), todas las peticiones entran por `public/index.php`.
El **Router** (`app/core/Router.php`) analiza la URL (ej. `/profile/admin`) y decide qué Controlador ejecutar.

### 2. Controladores (Controllers)
Intermediarios entre el usuario, los datos y la vista.
*   **AuthController**: Maneja Login, Registro y Logout.
*   **PostController**: Maneja el Feed, Crear Posts, Likes y Comentarios.
*   **ProfileController**: Muestra el perfil del usuario.

### 3. Modelos (Models)
Clases que encapsulan los datos (POO).
*   **User**: `login()`, `register()`, `findByUsername()`.
*   **Post**: `getAll()`, `create()`, `toggleLike()`.
*   **Database**: Clase Singleton que gestiona la conexión a los datos.
    *   *Nota*: Debido a limitaciones del entorno portable, usa JSON simulando una DB SQL.

### 4. Vistas (Views)
Archivos HTML limpios que reciben datos del controlador para mostrarlos.

## Credenciales de Prueba

*   **Admin**: `admin` / `admin123` (Puede borrar cualquier post)
*   **Demo**: `demo` / `demo123`

## Instalación

1.  Asegúrate de que la carpeta `data` y `public/uploads` tengan permisos de escritura.
2.  Ejecuta el servidor apuntando a la carpeta `public`:
    ```bash
    php -S localhost:8000 -t public
    ```
3.  Visita `http://localhost:8000/seed` para restaurar los datos de prueba.

