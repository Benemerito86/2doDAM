# 🏪 Proyecto JAXB — Sistema de Gestión de Empresa XML

## 📖 Descripción del proyecto

Este proyecto consiste en el desarrollo de una **aplicación de consola en Java** que utiliza **JAXB** para leer, procesar y mostrar información desde un archivo **XML**, validado previamente mediante un **XSD**.  

El sistema simula una empresa inventada y permite consultar su catálogo de productos, filtrarlos por tipo y mostrar promociones especiales según la época del año.

---

## 🏢 1. Descripción de la empresa


---

## ⚙️ 2. Funcionalidades implementadas

El sistema de consola permite las siguientes acciones:

1. **Mostrar catálogo completo**  
Visualiza todos los productos disponibles en la tienda.

2. **Mostrar memorias**
Filtra y muestra únicamente los productos de tipo memoria.

3. **Mostrar tarjetas gráficas**
Filtra y muestra únicamente los productos de tipo tarjeta gráfica.

4. **Mostrar RAM**
Filtra y muestra únicamente los productos de tipo RAM.

5. **Salir del programa**
Cierra la aplicación de consola.

---

## 📄 3. Creación del XML

El catálogo de la empresa se almacena en un archivo **`datos.xml`**, donde se definen todos los productos con sus atributos (nombre, tipo, código, precio, etc.) siguiendo una estructura jerárquica y organizada por categorías.

---

## ✅ 4. Validación con XSD

El XML se valida mediante un archivo **`XSDdatos.xsd`**, el cual garantiza que los datos cumplen con el formato y estructura esperada.  
Esta validación asegura la integridad y coherencia de la información antes de ser procesada por la aplicación Java.

---

## 💻 5. Aplicación de consola en Java con JAXB

La aplicación utiliza la API **JAXB (Java Architecture for XML Binding)** para:

- Leer el archivo XML (`datos.xml`)  
- Mapear los elementos XML a clases Java (como `Tienda`, `ram`, `memoria`, `grafica`)  
- Procesar los datos y mostrarlos por consola según la opción seleccionada por el usuario  
