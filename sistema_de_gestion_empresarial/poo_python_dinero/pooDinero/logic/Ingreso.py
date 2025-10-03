from .Dinero import Dinero

class Ingreso(Dinero):
    def __init__(self, dinero: float, descripcion: str):
        super().__init__()
        self.setDinero(dinero)
        self.setDescripcion(descripcion)

    def __str__(self):
        return f"Ingreso: {self.getDinero()} € - {self.getDescripcion()}"
