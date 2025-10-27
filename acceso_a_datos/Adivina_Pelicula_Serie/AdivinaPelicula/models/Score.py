from datetime import datetime
from db.database import obtener_conexion

class Score:
    def __init__(self, nombre_usuario, puntuacion_final):
        self.nombre_usuario = nombre_usuario
        self.puntuacion_final = puntuacion_final
        self.fecha_jugada = datetime.now().isoformat()

    def guardar(self):
        conexion = obtener_conexion()
        cursor = conexion.cursor()
        cursor.execute(
            "INSERT INTO puntuaciones (nombre_usuario, puntuacion_final, fecha_jugada) VALUES (?, ?, ?)",
            (self.nombre_usuario, self.puntuacion_final, self.fecha_jugada)
        )
        conexion.commit()
        conexion.close()

    @classmethod
    def obtener_todas(cls):
        conexion = obtener_conexion()
        cursor = conexion.cursor()
        cursor.execute("SELECT nombre_usuario, puntuacion_final, fecha_jugada FROM puntuaciones ORDER BY puntuacion_final DESC")
        filas = cursor.fetchall()
        conexion.close()
        return filas