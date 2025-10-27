# views/MainWindow.py
import tkinter as tk
from tkinter import messagebox, simpledialog
from controllers.Game_controller import GameController
from controllers.Score_controller import guardar_puntuacion
from views.Score_window import mostrar_puntuaciones

class MainWindow:
    def __init__(self, raiz):
        self.raiz = raiz
        self.raiz.title("🎬 Adivina la Película o Serie")
        self.raiz.geometry("500x450")
        self.raiz.resizable(False, False)
        self.raiz.configure(bg="#f5f7fa")

        # Estilos
        self.fuente_titulo = ("Segoe UI", 16, "bold")
        self.fuente_puntos = ("Segoe UI", 14, "bold")
        self.fuente_pista = ("Segoe UI", 12)
        self.fuente_botones = ("Segoe UI", 11)

        self.juego = None
        self.crear_interfaz()
        self.nuevo_juego()

    def crear_interfaz(self):
        # Marco principal
        marco = tk.Frame(self.raiz, bg="#f5f7fa")
        marco.pack(expand=True, fill="both", padx=30, pady=20)

        # Título
        tk.Label(
            marco,
            text="🧠 ¿Adivinas de qué se trata?",
            font=self.fuente_titulo,
            bg="#f5f7fa",
            fg="#2c3e50"
        ).pack(pady=(0, 15))

        # Puntos
        self.etiqueta_puntos = tk.Label(
            marco,
            text="Puntos: 30",
            font=self.fuente_puntos,
            bg="#f5f7fa",
            fg="#27ae60"
        )
        self.etiqueta_puntos.pack(pady=(0, 10))

        # Pista
        self.etiqueta_pista = tk.Label(
            marco,
            text="Pulsa 'Nueva Pista' para empezar",
            font=self.fuente_pista,
            bg="#f5f7fa",
            fg="#34495e",
            wraplength=400,
            justify="center"
        )
        self.etiqueta_pista.pack(pady=(0, 25))

        # Botones
        botones_frame = tk.Frame(marco, bg="#f5f7fa")
        botones_frame.pack()

        self.crear_boton(botones_frame, "🔍 Nueva Pista", self.pedir_pista).pack(pady=5, fill="x")
        self.crear_boton(botones_frame, "🎯 Adivinar", self.intentar_adivinar).pack(pady=5, fill="x")
        self.crear_boton(botones_frame, "📊 Ver Puntuaciones", mostrar_puntuaciones).pack(pady=5, fill="x")
        self.crear_boton(botones_frame, "🔄 Nuevo Juego", self.nuevo_juego, "#e74c3c", "#c0392b").pack(pady=5, fill="x")

    def crear_boton(self, padre, texto, comando, color_normal="#3498db", color_hover="#2980b9"):
        boton = tk.Button(
            padre,
            text=texto,
            command=comando,
            font=self.fuente_botones,
            bg=color_normal,
            fg="white",
            relief="flat",
            height=2,
            cursor="hand2"
        )
        # Efecto hover básico (opcional, requiere eventos)
        # Puedes omitirlo si no quieres complejidad
        return boton

    def nuevo_juego(self):
        self.juego = GameController()
        self.actualizar_interfaz()

    def actualizar_interfaz(self):
        self.etiqueta_puntos.config(text=f"Puntos: {self.juego.puntos}")
        if self.juego.indice_pista == 0:
            self.etiqueta_pista.config(text="¡Pide tu primera pista!")

    def pedir_pista(self):
        if self.juego.indice_pista >= 5:
            messagebox.showinfo("Fin del juego", "Ya no quedan más pistas. ¡Intenta adivinar!")
            return
        pista = self.juego.obtener_siguiente_pista()
        self.etiqueta_pista.config(text=pista)
        self.etiqueta_puntos.config(text=f"Puntos: {self.juego.puntos}")

    def intentar_adivinar(self):
        self.mostrar_ventana_adivinar()

    def mostrar_ventana_adivinar(self):
        # Crear ventana modal
        ventana_adivinar = tk.Toplevel(self.raiz)
        ventana_adivinar.title("🎯 Adivina la Película o Serie")
        ventana_adivinar.geometry("350x180")
        ventana_adivinar.resizable(False, False)
        ventana_adivinar.configure(bg="#f5f7fa")
        ventana_adivinar.transient(self.raiz)
        ventana_adivinar.grab_set()  # Modal
        ventana_adivinar.focus_set()

        # Centrar respecto a la ventana principal
        ventana_adivinar.update_idletasks()
        x = self.raiz.winfo_x() + (self.raiz.winfo_width() // 2) - (350 // 2)
        y = self.raiz.winfo_y() + (self.raiz.winfo_height() // 2) - (180 // 2)
        ventana_adivinar.geometry(f"+{x}+{y}")

        # Etiqueta
        tk.Label(
            ventana_adivinar,
            text="¿Cuál es la película o serie?",
            font=("Segoe UI", 12, "bold"),
            bg="#f5f7fa",
            fg="#2c3e50"
        ).pack(pady=(20, 5))

        # Entrada
        entrada = tk.Entry(
            ventana_adivinar,
            font=("Segoe UI", 11),
            justify="center",
            relief="solid",
            bd=1,
            width=30
        )
        entrada.pack(pady=10)
        entrada.focus()

        # Variable para almacenar el resultado
        self.intento_usuario = None

        def aceptar():
            valor = entrada.get().strip()
            if valor:
                self.intento_usuario = valor
                ventana_adivinar.destroy()
                self.procesar_intento(self.intento_usuario)

        def cancelar():
            ventana_adivinar.destroy()

        # Botones
        frame_botones = tk.Frame(ventana_adivinar, bg="#f5f7fa")
        frame_botones.pack(pady=10)

        btn_aceptar = tk.Button(
            frame_botones,
            text="✅ Aceptar",
            command=aceptar,
            font=("Segoe UI", 10, "bold"),
            bg="#27ae60",
            fg="white",
            relief="flat",
            width=10,
            height=1,
            cursor="hand2"
        )
        btn_aceptar.pack(side="left", padx=5)

        btn_cancelar = tk.Button(
            frame_botones,
            text="❌ Cancelar",
            command=cancelar,
            font=("Segoe UI", 10, "bold"),
            bg="#e74c3c",
            fg="white",
            relief="flat",
            width=10,
            height=1,
            cursor="hand2"
        )
        btn_cancelar.pack(side="left", padx=5)

        # Permitir Enter para aceptar
        entrada.bind("<Return>", lambda event: aceptar())
        entrada.bind("<Escape>", lambda event: cancelar())

    def procesar_intento(self, intento):
        if self.juego.verificar_intento(intento):
            messagebox.showinfo(
                "🎉 ¡Correcto!",
                f"¡Has acertado!\nPuntuación final: {self.juego.puntos} puntos"
            )
            nombre = simpledialog.askstring(
                "🏆 ¡Nuevo récord!",
                "Introduce tu nombre para el ranking:"
            )
            if nombre:
                guardar_puntuacion(nombre.strip(), self.juego.puntos)
            self.nuevo_juego()
        else:
            messagebox.showerror(
                "❌ Incorrecto",
                "¡No es correcto! Sigue intentándolo."
            )