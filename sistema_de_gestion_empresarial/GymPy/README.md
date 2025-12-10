# Documentación del Proyecto GymForTheMoment

## 1. Descripción General
Aplicación de escritorio desarrollada en **Python** con interfaz gráfica **Tkinter** (diseño moderno y tema oscuro) y base de datos **SQLite** para la gestión integral del gimnasio "GymForTheMoment". 

El sistema permite controlar clientes, inventario de máquinas, reservas de sesiones de entrenamiento y el estado de pagos/morosidad de los socios.

## 2. Estructura del Proyecto
El código ha sido refactorizado siguiendo una arquitectura modular (MVC - Model View Controller) para facilitar su mantenimiento y escalabilidad:

- **`main.py`**: Punto de entrada de la aplicación. Inicializa la base de datos, el controlador y lanza la interfaz gráfica.
- **`database.py`**: Módulo de acceso a datos. Gestiona la conexión con SQLite y la creación de tablas.
- **`controller.py`**: Lógica de negocio. Contiene las funciones para agregar clientes, gestionar reservas, generar recibos, etc.
- **`populate_db.py`**: Script de utilidad para poblar la base de datos con datos ficticios (clientes, reservas, recibos) para pruebas.
- **`ui/`**: Paquete de Interfaz de Usuario.
  - **`app.py`**: Clase principal de la ventana (GUI), pestañas y formularios.
  - **`styles.py`**: Definiciones de estilos visuales (colores, fuentes) para el tema oscuro moderno.

## 3. Requisitos funcionales del aplicativo

### Gestión de Gimnasio
1.  **Control de Horario**: Sistema preparado para gestionar reservas las 24 horas.
2.  **Gestión de Máquinas**: Registro individualizado de aparatos (ID único).
3.  **Reservas**:
    *   Duración fija de 30 minutos.
    *   Validación automática de disponibilidad (evita solapamientos de máquina/hora).
    *   Visualización de ocupación filtrada por día de la semana.

### Gestión Administrativa
1.  **Clientes**: Altas y listado de socios.
2.  **Facturación**: 
    *   Generación masiva de recibos mensuales.
    *   Control visual de recibos pagados vs. pendientes.
3.  **Control de Morosidad**: Listado específico de clientes con deuda pendiente.

## 4. Diagrama de Casos de Uso

### Actores
*   **Administrador**: Encargado de gestionar el gimnasio (único actor del sistema actual).

### Casos de Uso
*   **Gestionar Clientes**: Dar de alta nuevos socios, ver listados.
*   **Gestionar Máquinas**: Añadir y listar el equipamiento disponible.
*   **Gestionar Reservas**: Crear reservas de 30 min validando disponibilidad y aforo de máquina.
*   **Gestionar Pagos**: Generar recibos mensuales y marcar como pagados.
*   **Consultar Morosidad**: Identificar clientes con pagos pendientes.

## 5. Diagrama E-R y modelado ya normalizado

La base de datos `gym.db` consta de las siguientes tablas normalizadas:

**Tabla: Clientes**
- `id_cliente` (PK): Identificador único.
- `nombre`: Nombre completo.
- `dni`: Documento de identidad (Único).
- `telefono`: Contacto.

**Tabla: Maquinas**
- `id_maquina` (PK): Identificador único del aparato.
- `nombre`: Denominación (ej. "Cinta Correr 1").
- `tipo`: Categoría (Cardio, Musculación, etc.).

**Tabla: Reservas**
- `id_reserva` (PK)
- `id_cliente` (FK -> Clientes)
- `id_maquina` (FK -> Maquinas)
- `dia_semana`: Día de la reserva (Lunes..Viernes).
- `hora_inicio`: Hora en formato HH:MM.
- **Restricción Unique**: (id_maquina, dia_semana, hora_inicio) para evitar doble reserva.

**Tabla: Recibos**
- `id_recibo` (PK)
- `id_cliente` (FK -> Clientes)
- `mes`: Mes de facturación.
- `anio`: Año de facturación.
- `pagado`: Estado (0 = Pendiente, 1 = Pagado).

## 6. Instrucciones de Ejecución

### Requisitos previos
*   Python 3.x instalado.
*   Librería `tkinter` (incluida habitualmente con Python).

### Ejecutar la aplicación
1.  Para iniciar el programa principal:
    ```bash
    python main.py
    ```

2.  (Opcional) Para cargar datos de prueba (Clientes y Reservas falsas):
    ```bash
    python populate_db.py
    ```
    *Nota: Ejecutar esto reiniciará los datos actuales.*
