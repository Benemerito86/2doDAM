from logic.Usuario import Usuario
from logic.Gasto import Gasto
from logic.Ingreso import Ingreso
from logic.Cuenta import Cuenta
from logic.gastoException import GastoException


def main():
    nombre = input("Introduce nombre: ")
    edad = int(input("Introduce edad: "))

    while True:
        dni = input("Introduce DNI: ")
        usuario = Usuario(nombre, edad, dni)
        if usuario.dni:
            break
        print("DNI incorrecto, intenta de nuevo.")

    cuenta = Cuenta(usuario)

    while True:
        print("\nRealiza una nueva accion")
        print("1 Introduce un nuevo gasto")
        print("2 Introduce un nuevo ingreso")
        print("3 Mostrar gastos")
        print("4 Mostrar ingresos")
        print("5 Mostrar saldo")
        print("0 Salir")

        opcion = input("Elige una opción: ")

        if opcion == "1":
            desc = input("Descripción del gasto: ")
            cantidad = float(input("Cantidad del gasto: "))
            gasto = Gasto(cantidad, desc)
            try:
                cuenta.addGasto(gasto)
                print(f"Gasto añadido. Saldo actual: {cuenta.getSaldo()} €")
            except GastoException as e:
                print(e)

        elif opcion == "2":
            desc = input("Descripción del ingreso: ")
            cantidad = float(input("Cantidad del ingreso: "))
            ingreso = Ingreso(cantidad, desc)
            cuenta.addIngreso(ingreso)
            print(f"Ingreso añadido. Saldo actual: {cuenta.getSaldo()} €")

        elif opcion == "3":
            print("\n--- Gastos ---")
            for g in cuenta.getGastos():
                print(g)

        elif opcion == "4":
            print("\n--- Ingresos ---")
            for i in cuenta.getIngresos():
                print(i)

        elif opcion == "5":
            print(f"\nSaldo actual: {cuenta.getSaldo()} €")

        elif opcion == "0":
            print("Saliendo del programa...")
            break

        else:
            print("Opción no válida, intenta de nuevo.")


if __name__ == "__main__":
    main()
