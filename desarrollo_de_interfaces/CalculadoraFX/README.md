# 🧮 CalculadoraFX

Este proyecto es una aplicación de escritorio desarrollada en **JavaFX** que forma parte de un menú interactivo con varias herramientas educativas. La aplicación principal incluye una **calculadora funcional**, junto con accesos a otros módulos como *Cálculo Mental* y *Sudoku*.

## 📌 Características principales

- **Interfaz gráfica clásica y limpia** usando `GridPane` para la disposición precisa de botones.
- Diseño personalizado mediante una **hoja de estilos CSS** (`style.css`), que define colores, fuentes, bordes y fondos.
- Integración en un **menú principal** que permite navegar entre diferentes aplicaciones:
  - 🧮 Calculadora
  - 🧠 Cálculo Mental
  - 🧩 Sudoku
- Código modular y organizado en clases separadas por funcionalidad.

## 🎨 Estilo visual

### Captura 1 Interfaz inicial
<img width="499" height="412" alt="image" src="https://github.com/user-attachments/assets/5ef562df-a550-4e0e-be74-d2a69072aa14" />


### Captura 2 Calculadora
<img width="274" height="469" alt="image" src="https://github.com/user-attachments/assets/61f1e705-6b0b-4ad1-8a78-4fd025da8b9b" />


### Captura 3 Calculo Mental
<img width="309" height="438" alt="image" src="https://github.com/user-attachments/assets/d199268d-4bd4-414d-9f62-18a096a9c511" />


### Captura 4: Sudoku
<img width="588" height="714" alt="image" src="https://github.com/user-attachments/assets/130ef86c-3aa6-4a3c-8ad4-1ab24fb70281" />

---
- Captura 4 Sudoku

La interfaz utiliza un diseño **clásico** con:
- Fondo en tonos oscuros o neutros (según preferencia).
- Botones con bordes definidos y sombras suaves.
- Tipografía legible y tamaño de texto adecuado para una experiencia de usuario cómoda.
- Todo gestionado mediante el archivo `style.css`, que se aplica a todas las ventanas.

## 📦 Entrega

El proyecto se entrega como un archivo comprimido con el nombre:  
**`calculadoraFX_ApellidosNombre.zip`**

Dentro debe incluirse todo el código fuente organizado en carpetas, listo para compilar y ejecutar con **JDK 21 + JavaFX**.

## 🚀 Ejecución

Para ejecutar el proyecto, asegúrate de tener:
- JDK 21 instalado
- Librerías de JavaFX configuradas en el classpath

Ejemplo de comando (ajusta las rutas según tu sistema):

```bash
java --module-path /ruta/a/javafx-sdk/lib \
     --add-modules javafx.controls,javafx.fxml \
     -cp bin calculadora.Main
