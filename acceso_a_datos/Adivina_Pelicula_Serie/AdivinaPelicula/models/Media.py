from db.database import obtener_conexion

class Media:
    def __init__(self, id_medio, titulo, pistas):
        self.id = id_medio
        self.titulo = titulo
        self.pistas = pistas  # lista de 5 pistas

    @classmethod
    def obtener_aleatorio(cls):
        conexion = obtener_conexion()
        cursor = conexion.cursor()
        cursor.execute("SELECT * FROM medios ORDER BY RANDOM() LIMIT 1")
        fila = cursor.fetchone()
        conexion.close()
        if fila:
            return cls(fila[0], fila[1], [fila[2], fila[3], fila[4], fila[5], fila[6]])
        return None