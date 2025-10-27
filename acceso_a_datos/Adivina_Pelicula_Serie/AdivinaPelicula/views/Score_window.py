# views/ScoreWindow.py
import tkinter as tk
from tkinter import ttk
from models.Score import Score

def mostrar_puntuaciones():
    ventana = tk.Toplevel()
    ventana.title("📊 Historial de Puntuaciones")
    ventana.geometry("400x400")
    ventana.resizable(False, True)
    ventana.configure(bg="#f5f7fa")

    # Título
    tk.Label(
        ventana,
        text="🏆 Mejores Puntuaciones",
        font=("Segoe UI", 16, "bold"),
        bg="#f5f7fa",
        fg="#2c3e50"
    ).pack(pady=(15, 10))

    # Frame con scroll
    canvas = tk.Canvas(ventana, bg="#f5f7fa", highlightthickness=0)
    scrollbar = ttk.Scrollbar(ventana, orient="vertical", command=canvas.yview)
    scrollable_frame = tk.Frame(canvas, bg="#f5f7fa")

    scrollable_frame.bind(
        "<Configure>",
        lambda e: canvas.configure(scrollregion=canvas.bbox("all"))
    )

    canvas.create_window((0, 0), window=scrollable_frame, anchor="nw")
    canvas.configure(yscrollcommand=scrollbar.set)

    # Cargar puntuaciones
    puntuaciones = Score.obtener_todas()
    if not puntuaciones:
        tk.Label(
            scrollable_frame,
            text="No hay puntuaciones aún.",
            font=("Segoe UI", 12),
            bg="#f5f7fa",
            fg="#7f8c8d"
        ).pack(pady=20)
    else:
        for i, (nombre, puntos, fecha) in enumerate(puntuaciones[:20]):  # Máx 20
            color_fondo = "#ffffff" if i % 2 == 0 else "#f8f9fa"
            fila = tk.Frame(scrollable_frame, bg=color_fondo, relief="flat")
            fila.pack(fill="x", padx=20, pady=2)

            tk.Label(
                fila,
                text=f"{i+1}.",
                font=("Segoe UI", 10, "bold"),
                bg=color_fondo,
                fg="#7f8c8d",
                width=3
            ).pack(side="left")

            tk.Label(
                fila,
                text=nombre,
                font=("Segoe UI", 11),
                bg=color_fondo,
                fg="#2c3e50",
                anchor="w"
            ).pack(side="left", padx=(5, 10))

            tk.Label(
                fila,
                text=f"{puntos} pts",
                font=("Segoe UI", 11, "bold"),
                bg=color_fondo,
                fg="#27ae60"
            ).pack(side="right", padx=(0, 10))

            tk.Label(
                fila,
                text=fecha.split("T")[0],
                font=("Segoe UI", 9),
                bg=color_fondo,
                fg="#95a5a6"
            ).pack(side="right", padx=(0, 10))

    # Empaquetar canvas y scrollbar
    canvas.pack(side="left", fill="both", expand=True, padx=(10, 0), pady=10)
    scrollbar.pack(side="right", fill="y", padx=(0, 10), pady=10)

    # Permitir scroll con rueda del ratón
    def _on_mousewheel(event):
        canvas.yview_scroll(int(-1*(event.delta/120)), "units")
    canvas.bind_all("<MouseWheel>", _on_mousewheel)