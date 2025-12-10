import tkinter as tk
from database import Database
from controller import GymController
from ui.app import GymApp

if __name__ == "__main__":
    db = Database()
    controller = GymController(db)
    
    root = tk.Tk()
    # root.iconbitmap('icon.ico') 
    app = GymApp(root, controller)
    root.mainloop()
