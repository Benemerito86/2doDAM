class GymController:
    def __init__(self, db):
        self.db = db

    def add_cliente(self, name, dni, phone):
        self.db.execute_query("INSERT INTO clientes (nombre, dni, telefono) VALUES (?, ?, ?)", (name, dni, phone))

    def move_cliente(self, id_cliente): 
        self.db.execute_query("DELETE FROM clientes WHERE id_cliente = ?", (id_cliente,))

    def get_clientes(self):
        return self.db.fetch_all("SELECT * FROM clientes")

    def add_maquina(self, name, type_):
        self.db.execute_query("INSERT INTO maquinas (nombre, tipo) VALUES (?, ?)", (name, type_))

    def get_maquinas(self):
        return self.db.fetch_all("SELECT * FROM maquinas")

    def add_reserva(self, client_id, machine_id, day, time):
        return self.db.execute_query("INSERT INTO reservas (id_cliente, id_maquina, dia_semana, hora_inicio) VALUES (?, ?, ?, ?)", 
                                     (client_id, machine_id, day, time))

    def get_reservas_by_day(self, day):
        query = """
            SELECT r.hora_inicio, m.nombre, c.nombre 
            FROM reservas r
            JOIN maquinas m ON r.id_maquina = m.id_maquina
            JOIN clientes c ON r.id_cliente = c.id_cliente
            WHERE r.dia_semana = ?
            ORDER BY r.hora_inicio, m.nombre
        """
        return self.db.fetch_all(query, (day,))

    def generate_receipts_for_month(self, month, year):
        clients = self.get_clientes()
        count = 0
        for client in clients:
            try:
                self.db.cursor.execute("INSERT OR IGNORE INTO recibos (id_cliente, mes, anio, pagado) VALUES (?, ?, ?, 0)", (client[0], month, year))
                if self.db.cursor.rowcount > 0:
                    count += 1
            except: pass
        self.db.conn.commit()
        return count

    def get_morosos(self):
        query = """
            SELECT c.nombre, r.mes, r.anio, r.id_recibo
            FROM recibos r
            JOIN clientes c ON r.id_cliente = c.id_cliente
            WHERE r.pagado = 0
            ORDER BY r.anio, r.mes, c.nombre
        """
        return self.db.fetch_all(query)

    def pay_receipt(self, receipt_id):
        self.db.execute_query("UPDATE recibos SET pagado = 1 WHERE id_recibo = ?", (receipt_id,))
