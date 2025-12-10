import sqlite3
import random
from datetime import datetime, time

def populate():
    conn = sqlite3.connect("gym.db")
    cursor = conn.cursor()

    # Limpiar datos existentes (opcional, para evitar duplicados en desarrollo)
    cursor.execute("DELETE FROM reservas")
    cursor.execute("DELETE FROM recibos")
    cursor.execute("DELETE FROM clientes")
    cursor.execute("DELETE FROM maquinas")

    # 1. Crear Clientes
    nombres = ["Ana Garcia", "Carlos Lopez", "Maria Rodriguez", "Juan Martinez", "Lucia Fernandez", 
               "David Sanchez", "Elena Perez", "Miguel Gomez", "Laura Diaz", "Pedro Ruiz"]
    
    clientes_ids = []
    for i, nombre in enumerate(nombres):
        dni = f"{str(10000000+i)}X"
        tel = f"60000000{i}"
        cursor.execute("INSERT INTO clientes (nombre, dni, telefono) VALUES (?, ?, ?)", (nombre, dni, tel))
        clientes_ids.append(cursor.lastrowid)

    print(f"Insertados {len(clientes_ids)} clientes.")

    # 2. Crear Máquinas
    tipos = ["Cardio", "Musculación", "Funcional"]
    maquinas_data = [
        ("Cinta de Correr 1", "Cardio"),
        ("Cinta de Correr 2", "Cardio"),
        ("Elíptica 1", "Cardio"),
        ("Bicicleta Estática", "Cardio"),
        ("Press Banca", "Musculación"),
        ("Prensa de Piernas", "Musculación"),
        ("Mancuernas Set A", "Musculación"),
        ("Máquina Dorsal", "Musculación"),
        ("TRX Zona 1", "Funcional"),
        ("Kettlebells", "Funcional")
    ]
    
    maquinas_ids = []
    for nombre, tipo in maquinas_data:
        cursor.execute("INSERT INTO maquinas (nombre, tipo) VALUES (?, ?)", (nombre, tipo))
        maquinas_ids.append(cursor.lastrowid)

    print(f"Insertadas {len(maquinas_ids)} máquinas.")

    # 3. Crear Reservas (Aleatorias para la semana)
    dias = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes"]
    horas_base = [f"{h:02d}:{m:02d}" for h in range(8, 22) for m in (0, 30)] # De 08:00 a 21:30 para no llenar las 24h
    
    reservas_count = 0
    # Intentar generar unas 50 reservas
    for _ in range(50):
        cliente = random.choice(clientes_ids)
        maquina = random.choice(maquinas_ids)
        dia = random.choice(dias)
        hora = random.choice(horas_base)
        
        try:
            cursor.execute("INSERT INTO reservas (id_cliente, id_maquina, dia_semana, hora_inicio) VALUES (?, ?, ?, ?)", 
                           (cliente, maquina, dia, hora))
            reservas_count += 1
        except sqlite3.IntegrityError:
            # Si ya existe (maquina ocupada a esa hora), simplemente saltamos
            continue

    print(f"Insertadas {reservas_count} reservas.")

    # 4. Crear Recibos (Mes actual)
    mes_actual = datetime.now().month
    anio_actual = datetime.now().year
    
    # Generar recibos para todos
    for cid in clientes_ids:
        # Algunos pagados (1), otros no (0)
        pagado = random.choice([0, 1])
        cursor.execute("INSERT INTO recibos (id_cliente, mes, anio, pagado) VALUES (?, ?, ?, ?)", 
                       (cid, mes_actual, anio_actual, pagado))

    print("Recibos generados.")

    conn.commit()
    conn.close()

if __name__ == "__main__":
    populate()
