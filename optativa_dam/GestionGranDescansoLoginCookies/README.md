# Actividad: Cookies y Sesiones en el Sistema de Gestión Hotelera (SGH)

**Fecha de entrega:** Lunes, 10 de noviembre de 2025

## 📌 Descripción General

Esta actividad consiste en la mejora del proyecto `SGH — El Gran Descanso`, una aplicación web para la gestión de habitaciones de hotel desarrollada previamente. En esta nueva fase, se implementan dos características fundamentales para mejorar la experiencia del usuario:

1.  **Gestión de Sesiones**: Se crea una sesión de usuario que persiste desde el inicio de sesión hasta que el usuario decide cerrarla explícitamente.
2.  **Uso de Cookies**: Se implementa una cookie que permite al usuario seleccionar y guardar su preferencia de color de interfaz (modo claro/oscuro). Esta preferencia se recuerda incluso después de recargar la página o cerrar y volver a abrir el navegador.

La base de este trabajo es la tarea anterior llamada **"GranDescanso"**, a la cual se le añaden estas nuevas funcionalidades para convertirla en un sistema más robusto y personalizable.

---

## 🛠️ Instrucciones de la Actividad

### Objetivos
- Modificar el proyecto `SGH` existente para:
    - Crear una sesión de usuario que dure hasta que se desloguee.
    - Implementar una cookie que permita al usuario elegir un color de fondo (modo claro u oscuro) y que se mantenga tras recargar la página.

### Entrega
- Se debe subir el código finalizado al repositorio de GitHub con el nombre: `SGH_ApellidosNombre`.

---

## 🖼️ Capturas de Pantalla y Explicación

### Captura 1: Interfaz Principal en Modo Claro

![Interfaz principal en modo claro](./captura2.png)

*En esta captura se observa la interfaz principal del sistema (`MainView.php`) con un diseño en modo claro (fondo azul). El usuario ya ha iniciado sesión, como lo indica el botón "Cerrar Sesión". Además, se puede ver el botón "Modo Oscuro", que permite cambiar el tema de la interfaz. La tabla muestra las habitaciones registradas en la base de datos.*

---

### Captura 2: Pantalla de Inicio de Sesión

![Pantalla de inicio de sesión](./captura3.png)

*Esta captura muestra la pantalla de login (`LoginView.php`). El usuario debe introducir sus credenciales para acceder al sistema. Se proporcionan credenciales de prueba para usuarios administradores y estándar. Nótese que también en esta pantalla se incluye el botón "Modo Oscuro", lo que significa que la preferencia de color se aplica incluso antes de iniciar sesión, gracias a la cookie.*

---

### Captura 3: Interfaz Principal en Modo Oscuro

![Interfaz principal en modo oscuro](./captura4.png)

*En esta captura se muestra la misma interfaz principal, pero ahora en modo oscuro (fondo oscuro). El botón de cambio de tema ahora dice "Modo Claro", indicando que el usuario puede alternar entre ambos modos. Esta funcionalidad se logra mediante el uso de una cookie que guarda la preferencia del usuario.*

---

## 💡 Funcionalidades Implementadas

| Funcionalidad          | Tecnología Utilizada | Descripción                                                                 |
|------------------------|----------------------|-----------------------------------------------------------------------------|
| **Sesión de Usuario**  | `session_start()`    | Al iniciar sesión, se inicia una sesión PHP que se mantiene activa hasta que el usuario hace clic en "Cerrar Sesión". |
| **Cookie de Tema**     | `setcookie()`        | Cuando el usuario cambia el tema, se establece una cookie que guarda su elección. Al recargar la página, el sistema lee esta cookie y aplica el tema correspondiente. |

---

## ✅ Requisitos Técnicos

- El sistema debe estar construido en PHP.
- Debe utilizar una base de datos MySQL (como se indica en las capturas, con mensajes de conexión exitosa).
- Las sesiones deben ser manejadas correctamente, asegurando que solo los usuarios autenticados puedan acceder a las vistas protegidas.
- Las cookies deben tener una vida útil suficiente para persistir entre recargas y reinicios del navegador.

---

## 📂 Estructura del Proyecto (Recomendada)

Qwen3-Max
3:42 PM
Perfecto, aquí tienes el archivo .md actualizado con la estructura de carpetas que me proporcionaste. He modificado la sección "Estructura del Proyecto" para reflejar exactamente tu árbol de archivos.

markdown


1
2
3
4
5
6
7
8
9
10
11
12
13
14
15
16
17
18
19
20
21
22
23
24
25
26
27
28
29
30
31
32
33
34
35
36
37
38
39
40
41
42
43
44
45
46
47
48
49
50
51
52
53
54
55
56
57
58
59
60
61
62
63
64
65
66
67
68
69
70
71
72
73
74
75
76
77
78
79
80
81
⌄
⌄
⌄
⌄
⌄
⌄
⌄
⌄
⌄
⌄
⌄
⌄
⌄
⌄
# Actividad: Cookies y Sesiones en el Sistema de Gestión Hotelera (SGH)

**Fecha de entrega:** Lunes, 10 de noviembre de 2025

## 📌 Descripción General

Esta actividad consiste en la mejora del proyecto `SGH — El Gran Descanso`, una aplicación web para la gestión de habitaciones de hotel desarrollada previamente. En esta nueva fase, se implementan dos características fundamentales para mejorar la experiencia del usuario:

1.  **Gestión de Sesiones**: Se crea una sesión de usuario que persiste desde el inicio de sesión hasta que el usuario decide cerrarla explícitamente.
2.  **Uso de Cookies**: Se implementa una cookie que permite al usuario seleccionar y guardar su preferencia de color de interfaz (modo claro/oscuro). Esta preferencia se recuerda incluso después de recargar la página o cerrar y volver a abrir el navegador.

La base de este trabajo es la tarea anterior llamada **"GranDescanso"**, a la cual se le añaden estas nuevas funcionalidades para convertirla en un sistema más robusto y personalizable.

---

## 🛠️ Instrucciones de la Actividad

### Objetivos
- Modificar el proyecto `SGH` existente para:
    - Crear una sesión de usuario que dure hasta que se desloguee.
    - Implementar una cookie que permita al usuario elegir un color de fondo (modo claro u oscuro) y que se mantenga tras recargar la página.

### Entrega
- Se debe subir el código finalizado al repositorio de GitHub con el nombre: `SGH_ApellidosNombre`.

---

## 🖼️ Capturas de Pantalla y Explicación

### Captura 1: Instrucciones de la Actividad

![Instrucciones de la actividad](./captura1.png)

*Esta captura muestra la descripción oficial de la actividad, donde se detallan los objetivos principales: la creación de sesiones y cookies para mejorar la usabilidad del sistema.*

---

### Captura 2: Interfaz Principal en Modo Claro

![Interfaz principal en modo claro](./captura2.png)

*En esta captura se observa la interfaz principal del sistema (`MainView.php`) con un diseño en modo claro (fondo azul). El usuario ya ha iniciado sesión, como lo indica el botón "Cerrar Sesión". Además, se puede ver el botón "Modo Oscuro", que permite cambiar el tema de la interfaz. La tabla muestra las habitaciones registradas en la base de datos.*

---

### Captura 3: Pantalla de Inicio de Sesión

![Pantalla de inicio de sesión](./captura3.png)

*Esta captura muestra la pantalla de login (`LoginView.php`). El usuario debe introducir sus credenciales para acceder al sistema. Se proporcionan credenciales de prueba para usuarios administradores y estándar. Nótese que también en esta pantalla se incluye el botón "Modo Oscuro", lo que significa que la preferencia de color se aplica incluso antes de iniciar sesión, gracias a la cookie.*

---

### Captura 4: Interfaz Principal en Modo Oscuro

![Interfaz principal en modo oscuro](<img width="1920" height="992" alt="image" src="https://github.com/user-attachments/assets/59c786af-4d1f-48ba-a494-d4a5eff4287a" />
)


*En esta captura se muestra la misma interfaz principal, pero ahora en modo oscuro (fondo oscuro). El botón de cambio de tema ahora dice "Modo Claro", indicando que el usuario puede alternar entre ambos modos. Esta funcionalidad se logra mediante el uso de una cookie que guarda la preferencia del usuario.*

---

## 💡 Funcionalidades Implementadas

| Funcionalidad          | Tecnología Utilizada | Descripción                                                                 |
|------------------------|----------------------|-----------------------------------------------------------------------------|
| **Sesión de Usuario**  | `session_start()`    | Al iniciar sesión, se inicia una sesión PHP que se mantiene activa hasta que el usuario hace clic en "Cerrar Sesión". |
| **Cookie de Tema**     | `setcookie()`        | Cuando el usuario cambia el tema, se establece una cookie que guarda su elección. Al recargar la página, el sistema lee esta cookie y aplica el tema correspondiente. |

---

## ✅ Requisitos Técnicos

- El sistema debe estar construido en PHP.
- Debe utilizar una base de datos MySQL (como se indica en las capturas, con mensajes de conexión exitosa).
- Las sesiones deben ser manejadas correctamente, asegurando que solo los usuarios autenticados puedan acceder a las vistas protegidas.
- Las cookies deben tener una vida útil suficiente para persistir entre recargas y reinicios del navegador.

---

## 🚀 Conclusión

Con esta actividad, se ha logrado transformar el sistema `SGH — El Gran Descanso` en una aplicación más dinámica y personalizable. La adición de sesiones y cookies no solo mejora la seguridad y la experiencia del usuario, sino que también demuestra el dominio de conceptos clave en el desarrollo web con PHP. Este proyecto sirve como una excelente base para futuras mejoras, como la gestión de roles, reservas o reportes.
