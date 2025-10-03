from abc import ABC, abstractmethod

class Dinero(ABC):
    def __init__(self):
        self._dinero = 0.0
        self._descripcion = ""
    def setDinero(self, dinero: float):
        self._dinero = dinero
    def getDinero(self) -> float:
        return self._dinero
    def setDescripcion(self, descripcion: str):
        self._descripcion = descripcion
    def getDescripcion(self) -> str:
        return self._descripcion

    @abstractmethod
    def __str__(self) -> str:
        pass
