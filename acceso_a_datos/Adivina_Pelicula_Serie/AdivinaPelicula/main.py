from db.database import inicializar_bd
from views.Main_window import MainWindow
import tkinter as tk

if __name__ == "__main__":
    inicializar_bd()
    raiz = tk.Tk()
    app = MainWindow(raiz)
    raiz.mainloop()