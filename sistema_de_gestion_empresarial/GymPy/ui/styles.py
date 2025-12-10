from tkinter import ttk

class ModernStyle:
    BG_COLOR = "#2b2b2b"
    FG_COLOR = "#ffffff"
    ACCENT_COLOR = "#007acc"
    SECONDARY_BG = "#3c3f41"
    SUCCESS_COLOR = "#4caf50"
    WARNING_COLOR = "#ff9800"

    @staticmethod
    def apply_theme(root):
        style = ttk.Style(root)
        style.theme_use('clam')

        # General frame style
        style.configure("TFrame", background=ModernStyle.BG_COLOR)
        style.configure("TLabelframe", background=ModernStyle.BG_COLOR, foreground=ModernStyle.FG_COLOR)
        style.configure("TLabelframe.Label", background=ModernStyle.BG_COLOR, foreground=ModernStyle.FG_COLOR)
        
        # Label style
        style.configure("TLabel", background=ModernStyle.BG_COLOR, foreground=ModernStyle.FG_COLOR, font=("Segoe UI", 10))
        style.configure("Title.TLabel", font=("Segoe UI", 14, "bold"), foreground=ModernStyle.ACCENT_COLOR)

        # Entry style
        style.configure("TEntry", fieldbackground=ModernStyle.SECONDARY_BG, foreground=ModernStyle.FG_COLOR, insertcolor="white", borderwidth=0)
        
        # Button style
        style.configure("TButton", 
                        background=ModernStyle.ACCENT_COLOR, 
                        foreground="white", 
                        borderwidth=0, 
                        focuscolor="none", 
                        font=("Segoe UI", 9, "bold"))
        style.map("TButton", 
                  background=[('active', '#005f9e')], 
                  relief=[('pressed', 'flat')])

        # Combobox
        style.configure("TCombobox", fieldbackground=ModernStyle.SECONDARY_BG, background=ModernStyle.SECONDARY_BG, foreground=ModernStyle.FG_COLOR, arrowcolor="white")
        style.map("TCombobox", fieldbackground=[('readonly', ModernStyle.SECONDARY_BG)], selectbackground=[('readonly', ModernStyle.ACCENT_COLOR)])

        # Treeview
        style.configure("Treeview", 
                        background=ModernStyle.SECONDARY_BG, 
                        foreground=ModernStyle.FG_COLOR, 
                        fieldbackground=ModernStyle.SECONDARY_BG,
                        font=("Segoe UI", 9),
                        rowheight=25,
                        borderwidth=0)
        style.configure("Treeview.Heading", 
                        background="#1e1e1e", 
                        foreground="white", 
                        font=("Segoe UI", 9, "bold"),
                        relief="flat")
        style.map("Treeview", background=[('selected', ModernStyle.ACCENT_COLOR)])

        # Notebook (Tabs)
        style.configure("TNotebook", background=ModernStyle.BG_COLOR, borderwidth=0)
        style.configure("TNotebook.Tab", background="#333333", foreground="#aaaaaa", padding=[15, 5], font=("Segoe UI", 10))
        style.map("TNotebook.Tab", 
                  background=[('selected', ModernStyle.ACCENT_COLOR)], 
                  foreground=[('selected', 'white')])

        root.configure(bg=ModernStyle.BG_COLOR)
