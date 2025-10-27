# 🎬 Adivina la Película o Serie

> ¡Pon a prueba tus conocimientos cinematográficos! Adivina películas y series con pistas... ¡pero cada pista te cuesta puntos!

<img width="1067" height="599" alt="imagenAP" src="https://github.com/user-attachments/assets/c0745ebc-3ce9-42df-9475-26862cdc4266" />


---

## 🌟 ¿Qué es?

Un juego interactivo en Python con interfaz gráfica donde el jugador debe adivinar el nombre de una película o serie a partir de pistas progresivas. Comienza con 30 puntos y pierde 6 por cada pista solicitada. Al finalizar, se guarda tu puntuación en un histórico.

Ideal para fans del cine, series y juegos de deducción.

---

## 🧩 Características

✅ Interfaz gráfica moderna con Tkinter  
✅ Base de datos SQLite para guardar puntuaciones  
✅ 20 películas/series pre-cargadas con 5 pistas cada una  
✅ Sistema de puntuación: empiezas con 30 puntos, pierdes 6 por pista  
✅ Historial de puntuaciones con ranking  
✅ Botón "Nuevo Juego" para reiniciar sin perder historial  
✅ Ventana personalizada para adivinar (no usa ventanas nativas simples)

---

## 🗂️ Estructura del Proyecto

```text
AdivinaLaPelicula/
├── main.py
├── README.md
│
├── db/
│   └── database.py
│
├── models/
│   ├── Media.py
│   └── Score.py
│
├── views/
│   ├── Main_window.py
│   └── Score_window.py
│
└── controllers/
    ├── Game_controller.py
    └── Score_controller.py
```

---


## 🛠️ Tecnologías Usadas

| Tecnología | Uso en el proyecto |
|-----------|---------------------|
| **Python 3.x** | Lenguaje principal de desarrollo |
| **Tkinter** | Interfaz gráfica de usuario (GUI) |
| **SQLite** | Base de datos local para almacenar pistas y puntuaciones |
| **POO** | Arquitectura modular con clases y separación de responsabilidades |
| **Git + GitHub** | Control de versiones y alojamiento del código |
