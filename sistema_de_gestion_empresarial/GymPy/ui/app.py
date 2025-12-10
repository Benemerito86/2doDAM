import tkinter as tk
from tkinter import ttk, messagebox
from datetime import datetime
from ui.styles import ModernStyle

class GymApp:
    def __init__(self, root, controller):
        self.root = root
        self.controller = controller
        self.root.title("GymForTheMoment | Gestión Integral")
        self.root.geometry("1000x700")
        
        ModernStyle.apply_theme(root)
        
        # Header
        header = tk.Frame(root, bg=ModernStyle.BG_COLOR, height=50)
        header.pack(fill="x", padx=20, pady=10)
        tk.Label(header, text="GymForTheMoment", bg=ModernStyle.BG_COLOR, fg=ModernStyle.ACCENT_COLOR, font=("Segoe UI", 24, "bold")).pack(side="left")
        tk.Label(header, text="Panel de Administración", bg=ModernStyle.BG_COLOR, fg="#888888", font=("Segoe UI", 12)).pack(side="left", padx=10, pady=(12, 0))

        # Main Container with Padding
        main_container = tk.Frame(root, bg=ModernStyle.BG_COLOR)
        main_container.pack(fill="both", expand=True, padx=20, pady=(0, 20))

        self.tab_control = ttk.Notebook(main_container)
        
        self.tab_clientes = ttk.Frame(self.tab_control)
        self.tab_maquinas = ttk.Frame(self.tab_control)
        self.tab_reservas = ttk.Frame(self.tab_control)
        self.tab_pagos = ttk.Frame(self.tab_control)

        self.tab_control.add(self.tab_clientes, text='👥 Clientes')
        self.tab_control.add(self.tab_maquinas, text='💪 Máquinas')
        self.tab_control.add(self.tab_reservas, text='📅 Reservas')
        self.tab_control.add(self.tab_pagos, text='💰 Pagos y Morosos')
        
        self.tab_control.pack(expand=1, fill="both")

        self.setup_clientes_tab()
        self.setup_maquinas_tab()
        self.setup_reservas_tab()
        self.setup_pagos_tab()

    def create_form_frame(self, parent, title):
        frame = ttk.LabelFrame(parent, text=title, padding=15)
        frame.pack(fill="x", padx=10, pady=10)
        return frame

    def create_treeview_frame(self, parent, columns):
        frame = ttk.Frame(parent)
        frame.pack(fill="both", expand=True, padx=10, pady=10)
        
        scroll_y = ttk.Scrollbar(frame)
        scroll_y.pack(side="right", fill="y")
        
        tree = ttk.Treeview(frame, columns=columns, show='headings', yscrollcommand=scroll_y.set)
        scroll_y.config(command=tree.yview)
        
        for col in columns:
            tree.heading(col, text=col)
            tree.column(col, width=100) # Default width
        
        tree.pack(fill="both", expand=True)
        return tree

    # --- CLIENTES ---
    def setup_clientes_tab(self):
        form = self.create_form_frame(self.tab_clientes, "Nuevo Cliente")
        
        ttk.Label(form, text="Nombre Completo").grid(row=0, column=0, padx=5, pady=5, sticky="w")
        self.entry_nombre = ttk.Entry(form, width=30)
        self.entry_nombre.grid(row=0, column=1, padx=5, pady=5)

        ttk.Label(form, text="DNI").grid(row=0, column=2, padx=5, pady=5, sticky="w")
        self.entry_dni = ttk.Entry(form, width=20)
        self.entry_dni.grid(row=0, column=3, padx=5, pady=5)

        ttk.Label(form, text="Teléfono").grid(row=0, column=4, padx=5, pady=5, sticky="w")
        self.entry_tel = ttk.Entry(form, width=20)
        self.entry_tel.grid(row=0, column=5, padx=5, pady=5)

        ttk.Button(form, text="Agregar Cliente", command=self.add_cliente).grid(row=1, column=0, columnspan=6, pady=15, sticky="e")

        self.tree_clientes = self.create_treeview_frame(self.tab_clientes, columns=("ID", "Nombre", "DNI", "Teléfono"))
        self.tree_clientes.column("ID", width=50, anchor="center")
        self.tree_clientes.column("Nombre", width=200)
        
        self.load_clientes()

    def add_cliente(self):
        if self.entry_nombre.get():
            self.controller.add_cliente(self.entry_nombre.get(), self.entry_dni.get(), self.entry_tel.get())
            self.load_clientes()
            self.entry_nombre.delete(0, tk.END)
            self.entry_dni.delete(0, tk.END)
            self.entry_tel.delete(0, tk.END)

    def load_clientes(self):
        for item in self.tree_clientes.get_children():
            self.tree_clientes.delete(item)
        for cli in self.controller.get_clientes():
            self.tree_clientes.insert("", "end", values=cli)

    # --- MAQUINAS ---
    def setup_maquinas_tab(self):
        form = self.create_form_frame(self.tab_maquinas, "Nueva Máquina")
        
        ttk.Label(form, text="Nombre/Identificador").grid(row=0, column=0, padx=5, sticky="w")
        self.entry_maq_nombre = ttk.Entry(form, width=30)
        self.entry_maq_nombre.grid(row=0, column=1, padx=5)

        ttk.Label(form, text="Tipo").grid(row=0, column=2, padx=5, sticky="w")
        self.entry_maq_tipo = ttk.Combobox(form, values=["Cardio", "Musculación", "Funcional", "Peso Libre"], width=20)
        self.entry_maq_tipo.grid(row=0, column=3, padx=5)

        ttk.Button(form, text="Agregar Máquina", command=self.add_maquina).grid(row=0, column=4, padx=20)

        self.tree_maquinas = self.create_treeview_frame(self.tab_maquinas, columns=("ID", "Nombre", "Tipo"))
        self.tree_maquinas.column("ID", width=50, anchor="center")
        self.load_maquinas()

    def add_maquina(self):
        if self.entry_maq_nombre.get():
            self.controller.add_maquina(self.entry_maq_nombre.get(), self.entry_maq_tipo.get())
            self.load_maquinas()
            self.entry_maq_nombre.delete(0, tk.END)

    def load_maquinas(self):
        for item in self.tree_maquinas.get_children():
            self.tree_maquinas.delete(item)
        for maq in self.controller.get_maquinas():
            self.tree_maquinas.insert("", "end", values=maq)

    # --- RESERVAS ---
    def setup_reservas_tab(self):
        # Top Control Bar
        control_frame = ttk.Frame(self.tab_reservas)
        control_frame.pack(fill="x", padx=10, pady=10)
        
        ttk.Label(control_frame, text="Ver programación del:").pack(side="left", padx=5)
        self.combo_dia = ttk.Combobox(control_frame, values=["Lunes", "Martes", "Miércoles", "Jueves", "Viernes"], state="readonly", width=15)
        self.combo_dia.current(0)
        self.combo_dia.pack(side="left", padx=5)
        
        ttk.Button(control_frame, text="Consultar", command=self.load_reservas).pack(side="left", padx=5)

        # Split: Form Left, List Right (or Top/Bottom)
        # Let's do Top Form, Bottom List for simplicity
        form = self.create_form_frame(self.tab_reservas, "Realizar Reserva")
        
        ttk.Label(form, text="ID Cliente").grid(row=0, column=0, padx=5, pady=5)
        self.entry_res_cli_id = ttk.Entry(form, width=10)
        self.entry_res_cli_id.grid(row=0, column=1, padx=5)
        
        ttk.Label(form, text="ID Máquina").grid(row=0, column=2, padx=5, pady=5)
        self.entry_res_maq_id = ttk.Entry(form, width=10)
        self.entry_res_maq_id.grid(row=0, column=3, padx=5)

        ttk.Label(form, text="Hora").grid(row=0, column=4, padx=5, pady=5)
        times = [f"{h:02d}:{m:02d}" for h in range(24) for m in (0, 30)]
        self.combo_hora = ttk.Combobox(form, values=times, width=10)
        self.combo_hora.grid(row=0, column=5, padx=5)

        ttk.Button(form, text="Confirmar Reserva", command=self.add_reserva).grid(row=0, column=6, padx=20)

        self.tree_reservas = self.create_treeview_frame(self.tab_reservas, columns=("Hora Inicio", "Máquina", "Cliente"))
        self.tree_reservas.column("Hora Inicio", width=100, anchor="center")
        self.load_reservas()

    def add_reserva(self):
        try:
            cid = self.entry_res_cli_id.get()
            mid = self.entry_res_maq_id.get()
            formatted_day = self.combo_dia.get() # Use selected day for booking too? Or allow separate selection? 
                                                 # Requirement says "generate list for a day". Let's assume booking is for the currently viewed day for simplicity or add selector.
                                                 # Better: Add selector in form.
            # Wait, let's just use the top selector for booking to keep UI clean, or force user to select.
            # Let's assume booking is for the *selected* day in the combo box to avoid errors.
            
            hora = self.combo_hora.get()
            
            if cid and mid and hora:
                self.controller.add_reserva(cid, mid, formatted_day, hora)
                messagebox.showinfo("Confirmado", f"Reserva creada para {formatted_day} a las {hora}")
                self.load_reservas()
        except Exception as e:
            messagebox.showerror("Error", f"No se pudo reservar: {e}")

    def load_reservas(self):
        dia = self.combo_dia.get()
        for item in self.tree_reservas.get_children():
            self.tree_reservas.delete(item)
        for r in self.controller.get_reservas_by_day(dia):
            self.tree_reservas.insert("", "end", values=r)

    # --- PAGOS ---
    def setup_pagos_tab(self):
        # Generation Panel
        gen_frame = self.create_form_frame(self.tab_pagos, "Generación de Recibos")
        
        ttk.Label(gen_frame, text="Mes").pack(side="left", padx=5)
        self.entry_mes = ttk.Entry(gen_frame, width=5)
        self.entry_mes.insert(0, str(datetime.now().month))
        self.entry_mes.pack(side="left", padx=5)

        ttk.Label(gen_frame, text="Año").pack(side="left", padx=5)
        self.entry_anio = ttk.Entry(gen_frame, width=8)
        self.entry_anio.insert(0, str(datetime.now().year))
        self.entry_anio.pack(side="left", padx=5)

        ttk.Button(gen_frame, text="Generar Todo", command=self.generate_receipts).pack(side="left", padx=20)

        # Payment Action
        pay_frame = self.create_form_frame(self.tab_pagos, "Registrar Pago")
        ttk.Label(pay_frame, text="ID de Recibo a pagar:").pack(side="left", padx=5)
        self.entry_recibo_id = ttk.Entry(pay_frame, width=15)
        self.entry_recibo_id.pack(side="left", padx=5)
        ttk.Button(pay_frame, text="Marcar Pagado", command=self.pay_receipt).pack(side="left", padx=10)

        ttk.Button(pay_frame, text="🔄 Refrescar Lista", command=self.load_morosos).pack(side="right", padx=10)

        # List
        ttk.Label(self.tab_pagos, text="Listado de Recibos Pendientes (Morosos)", font=("Segoe UI", 12, "bold"), foreground=ModernStyle.WARNING_COLOR).pack(pady=(10,0))
        self.tree_morosos = self.create_treeview_frame(self.tab_pagos, columns=("Cliente", "Mes", "Año", "ID Recibo"))
        self.load_morosos()

    def generate_receipts(self):
        try:
            m = int(self.entry_mes.get())
            y = int(self.entry_anio.get())
            count = self.controller.generate_receipts_for_month(m, y)
            messagebox.showinfo("Proceso Completo", f"Se generaron {count} nuevos recibos.")
            self.load_morosos()
        except ValueError:
            messagebox.showerror("Error", "Datos inválidos")

    def load_morosos(self):
        for item in self.tree_morosos.get_children():
            self.tree_morosos.delete(item)
        for m in self.controller.get_morosos():
            # m structure: nombre, mes, anio, id_recibo
            self.tree_morosos.insert("", "end", values=m)

    def pay_receipt(self):
        try:
            rid = int(self.entry_recibo_id.get())
            self.controller.pay_receipt(rid)
            messagebox.showinfo("Pago", "Pago registrado correctamente.")
            self.load_morosos()
            self.entry_recibo_id.delete(0, tk.END)
        except:
            messagebox.showerror("Error", "ID inválido o error en base de datos.")
