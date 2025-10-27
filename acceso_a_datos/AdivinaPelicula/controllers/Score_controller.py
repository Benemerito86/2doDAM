from models.Score import Score

def guardar_puntuacion(nombre_usuario, puntuacion):
    puntuacion2 = Score(nombre_usuario, puntuacion)
    puntuacion2.guardar()