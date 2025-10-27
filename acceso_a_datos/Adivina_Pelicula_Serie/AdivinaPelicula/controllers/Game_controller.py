from models.Media import Media

class GameController:
    def __init__(self):
        self.medio_actual = Media.obtener_aleatorio()
        self.puntos = 36
        self.indice_pista = 0

    def obtener_siguiente_pista(self):
        if self.indice_pista < 5:
            pista = self.medio_actual.pistas[self.indice_pista]
            self.puntos -= 6
            self.indice_pista += 1
            return pista
        return None

    def verificar_intento(self, intento):
        return intento.strip().lower() == self.medio_actual.titulo.strip().lower()