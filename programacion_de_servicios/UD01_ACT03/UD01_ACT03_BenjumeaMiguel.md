# Trabajo de Investigación: Aportaciones de Dijkstra, Brinch Hansen y Hoare a la Gestión de Procesos

## 1. Edsger W. Dijkstra (1930–2002)

### Reseña histórica
Edsger Wybe Dijkstra fue un influyente científico informático neerlandés, galardonado con el **Premio Turing en 1972**. Sus contribuciones abarcan algoritmos, programación estructurada y, especialmente, la sincronización en sistemas concurrentes.

### Fecha clave: **1968**
En este año, Dijkstra publicó su artículo seminal **“Cooperating Sequential Processes”**, donde introdujo formalmente el problema de la **exclusión mutua** y propuso soluciones para la coordinación entre procesos concurrentes.

### Aportaciones a la gestión de procesos
- **Inventó los semáforos**: mecanismos de sincronización basados en dos operaciones atómicas:
  - `P()` (*proberen*: probar/bajar)
  - `V()` (*verhogen*: incrementar/subir)
- Resolvió el clásico **problema del productor-consumidor** usando semáforos.
- Sentó las bases de la **programación estructurada** con su artículo *"Go To Statement Considered Harmful"* (1968), influyendo en el diseño de sistemas más predecibles y seguros.

### Ejemplo: Semáforos en el problema productor-consumidor
```c
semaphore mutex = 1;   // Exclusión mutua
semaphore lleno = 0;   // Elementos en el buffer
semaphore vacio = N;   // Espacios libres (N = tamaño del buffer)

// Productor
P(vacio);
P(mutex);
// Añadir dato al buffer
V(mutex);
V(lleno);

// Consumidor
P(lleno);
P(mutex);
// Leer dato del buffer
V(mutex);
V(vacio);
```

## 2. Per Brinch Hansen (1938–2007)
### Reseña histórica
Ingeniero danés pionero en sistemas operativos y computación concurrente. Diseñó el sistema operativo **RC 4000** y fue profesor en la Universidad de Southern California.

### Fecha clave: 1973
Lanzó **Concurrent Pascal**, el **primer lenguaje de programación diseñado explícitamente para programación** concurrente.

### Aportaciones a la gestión de procesos
- **Implementó los monitores de forma práctica** en Concurrent Pascal, encapsulando datos compartidos y garantizando exclusión mutua automática.
- Su sistema **RC 4000** (1969–1970) introdujo una arquitectura basada en **mensajería entre procesos**, precursora de los **microkernels** modernos.
- Abogó por la **verificación formal** del comportamiento concurrente, promoviendo la corrección matemática del software.

### Ejemplo: Monitor en Concurrent Pascal
```c
monitor Buffer;
var
  datos: array[0..9] of integer;
  contador, inicio, fin: integer;
  noVacio, noLleno: condition;

procedure entrar(x: integer);
begin
  if contador = 10 then noLleno.wait;
  datos[fin] := x;
  fin := (fin + 1) mod 10;
  contador := contador + 1;
  noVacio.signal;
end;

procedure salir: integer;
begin
  if contador = 0 then noVacio.wait;
  contador := contador - 1;
  inicio := (inicio + 1) mod 10;
  noLleno.signal;
  return datos[inicio];
end;
```

## 3. Tony Hoare (C. A. R. Hoare, n. 1934)
### Reseña histórica
Científico informático británico, **Premio Turing en 1980**. Conocido por crear el algoritmo **Quicksort** y por su enfoque riguroso en la lógica de programación.

### Fecha clave: 1974
Publicó el artículo fundacional **“Monitors: An Operating System Structuring Concept”**, que formalizó el uso de monitores en sistemas concurrentes.

### Aportaciones a la gestión de procesos
- **Definió formalmente los monitores** como estructuras de alto nivel para sincronización segura.
- Introdujo **variables de condición** con operaciones ```wait()``` y ```signal()``` para suspender y reanudar procesos.
- Desarrolló la **Lógica de Hoare**, un sistema formal para razonar sobre la corrección de programas (incluida la concurrencia).
### Ejemplo: Monitor en estilo Java
```c
class Buffer {
    private int contenido;
    private boolean disponible = false;

    public synchronized void poner(int valor) {
        while (disponible) {
            try { wait(); } catch (InterruptedException e) {}
        }
        contenido = valor;
        disponible = true;
        notifyAll();
    }

    public synchronized int sacar() {
        while (!disponible) {
            try { wait(); } catch (InterruptedException e) {}
        }
        disponible = false;
        notifyAll();
        return contenido;
    }
}
```

### Línea histórica comparativa
| Año       | Evento clave                                                                 |
|-----------|------------------------------------------------------------------------------|
| 1965–1968 | Dijkstra introduce los **semáforos** y analiza procesos cooperativos.        |
| 1969–1970 | Brinch Hansen diseña el sistema **RC 4000** con IPC basado en mensajes.      |
| 1973      | Brinch Hansen lanza **Concurrent Pascal** con **monitores implementados**.   |
| 1974      | Hoare publica su teoría formal de **monitores**, consolidando el modelo.     |