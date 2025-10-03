from socket import fromfd

from logic.gastoException import GastoException

class Cuenta:
    def __init__(self, usuario):
        self.usuario = usuario
        self.saldo = 0.0
        self.gastos = []
        self.ingresos = []
    def getSaldo(self):
        return self.saldo
    def addIngreso(self, ingreso):
        self.ingresos.append(ingreso)
        self.saldo += ingreso.getDinero()
        return self.saldo
    def addGasto(self, gasto):
        if gasto.getDinero() > self.saldo:
            raise GastoException(f"Saldo insuficiente para gastar {gasto.getDinero()} €")
        self.gastos.append(gasto)
        self.saldo -= gasto.getDinero()
        return self.saldo
    def getIngresos(self):
        return self.ingresos
    def getGastos(self):
        return self.gastos
    def __str__(self):
        return (f"Cuenta de {self.usuario.nombre}\n"
                f"Saldo: {self.saldo} €\n"
                f"Ingresos: {len(self.ingresos)}\n"
                f"Gastos: {len(self.gastos)}")
