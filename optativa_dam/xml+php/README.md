# 📝 Lista de Tareas Simple

## ✅ Requisitos

### 📌 Mostrar Tareas
Al cargar la página, debe mostrar una lista desordenada (`<ul>`) con las tareas que ya existen.  

### ➕ Agregar Tarea
Debe haber un formulario con un campo de texto para que el usuario escriba una nueva tarea y un botón para enviarla.  

### 🔄 Manejar Datos
Cuando el formulario se envía, la nueva tarea se debe agregar a la lista existente y la página debe recargarse mostrando la lista actualizada.  

### 💾 Persistencia Simple
Para este ejercicio, utilizaremos una persistencia muy básica guardando las tareas en un archivo de texto en el servidor.  
Esto significa que las tareas no se perderán al recargar la página.  

---

## 📂 Persistencia con XML

El archivo de persistencia será **`tareas.xml`**, con la siguiente estructura válida:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<tareas></tareas>

```

[⬇️ Descargar proyecto.php](https://github.com/Benemerito86/2doDAM/blob/main/optativa_dam/xml%2Bphp/optativa_dam/xml+php/index.php)
