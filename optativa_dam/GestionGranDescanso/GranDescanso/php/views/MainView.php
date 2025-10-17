<?php # Esta vista muestra la interfaz principal del sistema de gestión hotelera
require_once '../model/Conexion.php';
require_once '../pdo/Habitacion.php';
$habitacionObj = new Habitacion();
$habitaciones = $habitacionObj->obtenerHabitaciones();
require_once '../pdo/Huesped.php';
$huespedObj = new Huesped();
$huespedes = $huespedObj->obtenerHuespedes();
require_once '../pdo/Reservas.php';
$reservaObj = new Reservas();
$Reservas = $reservaObj->obtenerReservas();
require_once '../pdo/Mantenimiento.php';
$mantenimientoObj = new Mantenimiento();
$mantenimientos = $mantenimientoObj->obtenerMantenimientos();
?> 

<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>SGH — El Gran Descanso</title>
  <link href="../../css/styles.css" rel="stylesheet" />
</head>
<body>
  <h1>SGH — El Gran Descanso</h1>

  <div class="box">
    <h2>Habitaciones</h2>
    <form action="../controller/MainController.php" method="post">
      <div class="row">
        <label>Número: <input type="text" name="numero" placeholder="001" /></label>
        <label>Tipo:
          <select name="tipo">
            <option>Sencilla</option>
            <option>Doble</option>
            <option>Suite</option>
          </select>
        </label>
        <label>Precio base/noche: <input type="number" name="precio" placeholder="00.00" /></label>
        <label>Estado limpieza:
          <select name="estado_limpieza">
            <option>Limpia</option>
            <option>Sucia</option>
            <option>En mantenimiento</option>
          </select>
        </label>
        <button name="add_room" class="btn" type="submit">Registrar</button>
        <button name="del_room" class="btn" type="submit">Borrar</button>
        <button name="upd_room" class="btn" type="submit">Actualizar</button>

      </div>
    </form>

    <table>
      <thead>
        <tr><th>Número</th><th>Tipo</th><th>Precio base</th><th>Estado limpieza</th></tr>
      </thead>
      <tbody>
         <?php foreach ($habitaciones as $hab): ?>
          <tr>
            <td><?= htmlspecialchars($hab['numero']) ?></td>
            <td><?= htmlspecialchars($hab['tipo']) ?></td>
            <td><?= htmlspecialchars($hab['precio_base']) ?></td>
            <td><?= htmlspecialchars($hab['estado_limpieza']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="box">
    <h2>Huéspedes</h2>
    <form action="../controller/MainController.php" method="post">
      <div class="row">
        <label>Nombre: <input type="text" name="nombre" placeholder="Nombre completo" /></label>
        <label>Email: <input type="email" name="email" placeholder="email@ejemplo.com" /></label>
        <label>Documento: <input type="text" name="documento" placeholder="DNI / Pasaporte" /></label>
        <button name="add_guest" class="btn" type="submit">Registrar</button>
        <button name="del_guest" class="btn" type="submit">Borrar</button>
        <button name="upd_guest" class="btn" type="submit">Actualizar</button>
      </div>
    </form>

    <table>
      <thead><tr><th>Nombre</th><th>Email</th><th>Documento</th></tr></thead>
      <tbody>
        <?php foreach ($huespedes as $huesped): ?>
          <tr>
            <td><?= htmlspecialchars($huesped['nombre']) ?></td>
            <td><?= htmlspecialchars($huesped['email']) ?></td>
            <td><?= htmlspecialchars($huesped['documento']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="box">
    <h2>Reservas</h2>
    <form method="post" action="../controller/MainController.php">
      <div class="row">
        <label>Id:
          <select name="id" id="reserva_id">
            <option>new</option>
              <?php foreach ($Reservas as $reserva): ?>
                  <option value="<?= htmlspecialchars($reserva['id']) ?>"><?= htmlspecialchars($reserva['id']) ?></option>
              <?php endforeach; ?>
          </select>
        </label>

        <label>Huesped:
          <select name="huesped_email" id="huesped_email">
              <?php foreach ($huespedes as $huesped): ?>
                  <option value="<?= htmlspecialchars($huesped['email']) ?>"><?= htmlspecialchars($huesped['email']) ?></option>
              <?php endforeach; ?>
          </select>
        </label>

        <label>Numero habitación:
          <select name="habitacion_numero" id="habitacion_numero">
              <?php foreach ($habitaciones as $habitacion): ?>
                  <option value="<?= htmlspecialchars($habitacion['numero']) ?>"><?= htmlspecialchars($habitacion['numero']) ?></option>
              <?php endforeach; ?>
          </select>
        </label>
        <label>Desde:<input name="inicio" id="inicio" type="date" /></label>
        <label>Hasta:
          <input name="fin" id="fin" type="date" />
        </label>
        <label>Precio total: <input name="precio_total" id="precio_total" type="number" placeholder="00.00" /></label>
        </label>
        <label>Estado:
          <select name="estado" id="estado">
              <option>pendiente</option>
              <option>confirmada</option>
              <option>cancelada</option>
          </select>
        </label>
        <button name="add_reservation" class="btn" type="submit">Registrar</button>
        <button name="del_reservation" class="btn" type="submit">Borrar</button>
        <button name="upd_reservation" class="btn" type="submit">Actualizar</button>
      </div>
    </form>

    <table>
      <thead><tr><th>Id</th><th>Huésped</th><th>Hab</th><th>Desde</th><th>Hasta</th><th>Precio total</th><th>Estado</th></tr></thead>
      <tbody>
        <?php foreach ($Reservas as $reserva): ?>
          <tr>
            <td><?= htmlspecialchars($reserva['id']) ?></td>
            <td><?= htmlspecialchars($reserva['huesped_email']) ?></td>
            <td><?= htmlspecialchars($reserva['habitacion_numero']) ?></td>
            <td><?= htmlspecialchars($reserva['inicio']) ?></td>
            <td><?= htmlspecialchars($reserva['fin']) ?></td>
            <td><?= htmlspecialchars($reserva['precio_total']) ?></td>
            <td><?= htmlspecialchars($reserva['estado']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="box">
    <h2>Mantenimiento / Limpieza</h2>
    <form method="post" action="../controller/MainController.php">
      <div class="row">
        <label>Id:
          <select name="id">
            <option>new</option>
              <?php foreach ($mantenimientos as $mantenimiento): ?>
                  <option value="<?= htmlspecialchars($mantenimiento['id']) ?>"><?= htmlspecialchars($mantenimiento['id']) ?></option>
              <?php endforeach; ?>
          </select>
        <label>Numero habitación:
          <select name="habitacion_numero">
              <?php foreach ($habitaciones as $habitacion): ?>
                  <option value="<?= htmlspecialchars($habitacion['numero']) ?>"><?= htmlspecialchars($habitacion['numero']) ?></option>
              <?php endforeach; ?>
          </select>
        </label>
        <label>Desde:<input name="inicio" type="date"  /></label>
        <label>Hasta:<input name="fin" type="date" /></label>
        <label>Descripción: <input type="text" name="descripcion" placeholder="Descripción del mantenimiento" /></label>
        <button name="add_maintenance" class="btn" type="submit">Registrar</button>
        <button name="del_maintenance" class="btn" type="submit">Borrar</button>
        <button name="upd_maintenance" class="btn" type="submit">Actualizar</button>
      </div>
    </form>

    <table>
      <thead><tr><th>Hab</th><th>Inicio</th><th>Fin</th><th>Descripción</th></tr></thead>
      <tbody>
        <?php foreach ($mantenimientos as $mantenimiento): ?>
          <tr>
            <td><?= htmlspecialchars($mantenimiento['habitacion_numero']) ?></td>
            <td><?= htmlspecialchars($mantenimiento['inicio']) ?></td>
            <td><?= htmlspecialchars($mantenimiento['fin']) ?></td>
            <td><?= htmlspecialchars($mantenimiento['descripcion']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

</body>
<script>
const reservasData = <?php echo json_encode($Reservas); ?>;


const selectId = document.getElementById('reserva_id');

function rellenarFormulario() {
    const reservaId = parseInt(selectId.value);
    const reserva = reservasData.find(r => r.id === reservaId);
    if (reserva) {
        document.getElementById('huesped_email').value = reserva.huesped_email;
        document.getElementById('habitacion_numero').value = reserva.habitacion_numero;
        document.getElementById('inicio').value = reserva.inicio;
        document.getElementById('fin').value = reserva.fin;
        document.getElementById('precio_total').value = reserva.precio_total;
        document.getElementById('estado').value = reserva.estado;
    }
}


// Ejecutar al cambiar el select
selectId.addEventListener('change', rellenarFormulario);

// Ejecutar al cargar la página para mostrar la primera reserva
rellenarFormulario();



</script>
</html>

