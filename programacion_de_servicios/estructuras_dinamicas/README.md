# 📚 Programación de Servicios y Procesos – 2º DAM 2025/26  
## **Práctica: Uso de Pilas y Colas en Java**

Este repositorio contiene la implementación de cuatro ejercicios propuestos en la asignatura **Programación de Servicios y Procesos** del ciclo formativo de **Desarrollo de Aplicaciones Multiplataforma (2º DAM)**, curso **2025/26**.  
Los ejercicios se centran en el uso de **estructuras dinámicas de datos**: **pilas (stacks)** y **colas (queues)**, implementadas desde cero en **Java**, sin recurrir a las clases de la biblioteca estándar (`java.util.Stack`, `java.util.Queue`, etc.).

---

## 📌 Ejercicios Implementados

### ✅ Ejercicio 01 – Inversión de texto con pila  
- **Objetivo**: Invertir una cadena introducida por el usuario usando únicamente operaciones de pila (`push`, `pop`, `isEmpty`).  
- **Restricciones**: No se permite recorrer la cadena hacia atrás ni usar métodos de inversión directa.

### ✅ Ejercicio 02 – Simulación de cola de clientes  
- **Objetivo**: Simular una fila de clientes atendidos por orden de llegada (FIFO).  
- **Funcionalidades**:
  - Añadir cliente (en cola).
  - Atender cliente (desencolar y mostrar).
  - Mostrar estado actual de la cola.
  - Menú interactivo en consola.

### ✅ Ejercicio 03 – Verificación de palíndromos  
- **Objetivo**: Determinar si una palabra o frase es palíndroma.
- **Método**:  
  - Normalizar el texto (convertir a minúsculas y eliminar espacios).
  - Insertar caracteres en una **pila** (para lectura inversa) y en una **cola** (para lectura directa).
  - Comparar carácter a carácter al desapilar y desencolar.

### ✅ Ejercicio 04 – Conversión decimal a binario  
- **Objetivo**: Convertir un número entero decimal positivo a su representación binaria.
- **Método**: Apilar los restos de las divisiones sucesivas entre 2; al desapilar, se obtiene el número binario correcto.

---

## 🛠️ Tecnologías y Requisitos

- **Lenguaje**: Java (versión 11 o superior recomendada)
- **Entorno**: Consola (aplicación de terminal)
- **Estructuras implementadas manualmente**:
  - `Pila` (con métodos `push`, `pop`, `isEmpty`)
  - `Cola` (con métodos `enqueue`, `dequeue`, `isEmpty`, `display`)

> ⚠️ **No se utilizan clases de la API estándar** como `Stack` o `LinkedList` para garantizar el uso de estructuras dinámicas propias.

---

[Descargar Proyecto]
