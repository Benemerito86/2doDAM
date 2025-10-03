import re

class Usuario:
    def __init__(self, nombre, edad, dni=None):
        self.nombre = nombre
        self.edad = edad
        self.dni = None
        if dni:
            if not self.set_dni(dni):
                print("DNI incorrecto")

    def set_dni(self, dni):#validacion dni
        if not isinstance(dni, str):
            return False

        dni = dni.upper().strip()#.strip() --> quitar espacios
        patron = r"^\d{8}-?[A-Z]$"

        if not re.match(patron, dni):
            return False

        self.dni = dni.replace("-", "") #eliminar el guion para almacenarlo
        return True

    def __str__(self):
        return (f"Nombre: {self.nombre}\n"
                f"Edad: {self.edad}\n"
                f"DNI: {self.dni}")
