import sqlite3
from tkinter import messagebox

class Database:
    def __init__(self, db_name="gym.db"):
        self.conn = sqlite3.connect(db_name)
        self.cursor = self.conn.cursor()
        self.create_tables()

    def create_tables(self):
        self.cursor.execute("""
            CREATE TABLE IF NOT EXISTS clientes (
                id_cliente INTEGER PRIMARY KEY AUTOINCREMENT,
                nombre TEXT NOT NULL,
                dni TEXT UNIQUE,
                telefono TEXT
            )
        """)
        self.cursor.execute("""
            CREATE TABLE IF NOT EXISTS maquinas (
                id_maquina INTEGER PRIMARY KEY AUTOINCREMENT,
                nombre TEXT NOT NULL,
                tipo TEXT
            )
        """)
        self.cursor.execute("""
            CREATE TABLE IF NOT EXISTS reservas (
                id_reserva INTEGER PRIMARY KEY AUTOINCREMENT,
                id_cliente INTEGER,
                id_maquina INTEGER,
                dia_semana TEXT,
                hora_inicio TEXT,
                FOREIGN KEY(id_cliente) REFERENCES clientes(id_cliente),
                FOREIGN KEY(id_maquina) REFERENCES maquinas(id_maquina),
                UNIQUE(id_maquina, dia_semana, hora_inicio)
            )
        """)
        self.cursor.execute("""
            CREATE TABLE IF NOT EXISTS recibos (
                id_recibo INTEGER PRIMARY KEY AUTOINCREMENT,
                id_cliente INTEGER,
                mes INTEGER,
                anio INTEGER,
                pagado INTEGER DEFAULT 0,
                FOREIGN KEY(id_cliente) REFERENCES clientes(id_cliente),
                UNIQUE(id_cliente, mes, anio)
            )
        """)
        self.conn.commit()

    def execute_query(self, query, params=()):
        try:
            self.cursor.execute(query, params)
            self.conn.commit()
            return self.cursor
        except sqlite3.Error as e:
            messagebox.showerror("Error de Base de Datos", str(e))
            return None

    def fetch_all(self, query, params=()):
        self.cursor.execute(query, params)
        return self.cursor.fetchall()

    def close(self):
        self.conn.close()
