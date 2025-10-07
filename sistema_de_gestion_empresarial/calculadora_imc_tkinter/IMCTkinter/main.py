import tkinter as tk
from sys import flags
from tkinter import ttk
from warnings import catch_warnings

window = tk.Tk()
window.geometry("300x300")
window.title("Calculadora de IMC con Tkinter")
peso_var = tk.StringVar()
altura_var = tk.StringVar()

for texto, var in (("Peso (kg)", peso_var), ("Altura (m)", altura_var)):
    frame = ttk.Frame(window)
    frame.pack(side="top", fill="x", padx=10, pady=5)
    label = ttk.Label(frame, text=f"{texto}:")
    label.pack(side="left")
    entry = ttk.Entry(frame, textvariable=var)
    entry.pack(side="left", fill='x', expand=True)


def calcular():
    try:
        peso = float(peso_var.get())
        altura = float(altura_var.get())
        imc.config(text=f"El IMC es: {peso / (altura * altura)}")
    except ValueError:
        imc.config(text=f"Número/s inválido/s")


frame = ttk.Frame(window)
frame.pack(side="top", fill="x", padx=10, pady=5)
button = ttk.Button(frame, text="Calcular", command=lambda: calcular())
button.pack(side="right")
imc = ttk.Label(frame, text=f"El IMC es:")
imc.pack(side="left")

window.mainloop()