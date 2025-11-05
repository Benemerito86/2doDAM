# Programación de Servicios y Procesos – 2º DAM  
## Curso 2025/26  
### Unidad Didáctica 01: Ejercicios de Algoritmos de Planificación

---

### Ejercicio 01: FCFS – Planificación básica por orden de llegada

| Proceso | Llegada | Ejecución |
|---------|---------|-----------|
| P1      | 0       | 4         |
| P2      | 1       | 3         |
| P3      | 2       | 2         |
| P4      | 3       | 1         |

**Tarea:**  
Calcular tiempos de espera, retorno y generar el diagrama de Gantt.

#### Tiempos de espera:
- P1: 0
- P2: 4 - 1 = 3
- P3: 7 - 2 = 5
- P4: 9 - 3 = 6
- Promedio = 3.5

#### Tiempo de retorno:
- P1: 4 - 0 = 4
- P2: 7 - 1 = 6
- P3: 9 - 2 = 7
- P4: 10 - 3 = 7
- Promedio: 6


#### Diagrama de Gantt - FCFS:

| Tiempo | 0-4 | 4-7 | 7-9 | 9-10 |
|--------|-----|-----|-----|------|
| Proceso| P1  | P2  | P3  | P4   |

---

### Ejercicio 02: SJF – Priorizar los procesos más cortos

| Proceso | Llegada | Ejecución |
|---------|---------|-----------|
| P1      | 0       | 7         |
| P2      | 2       | 4         |
| P3      | 4       | 1         |
| P4      | 5       | 4         |

**Tarea:**  
Determinar el orden óptimo de ejecución y comparar el **tiempo de espera promedio (WT)** con FCFS.

#### Tiempos de espera:
- P1: 0 - 0 = 0
- P2: 8 - 2 = 6
- P3: 7 - 4 = 3
- P4: 12 - 5 = 7
- Promedio: 4

#### Tiempo de retorno:
- P1: 7 - 0 = 7
- P2: 12 - 2 = 10
- P3: 8 - 4 = 4
- P4: 16 - 5 = 11
- Promedio: 8

#### Comparacion con FCFS:
- WT promedio ≈ 6.5 → SJF mejora el rendimiento.


---

### Ejercicio 03: Round Robin (RR) – Quantum = 2

| Proceso | Llegada | Ejecución |
|---------|---------|-----------|
| P1      | 0       | 5         |
| P2      | 1       | 4         |
| P3      | 2       | 2         |

**Tarea:**  
Calcular el orden de ejecución y el **tiempo de espera promedio**.

#### Orden de ejecución: 
P1 → P2 → P3 → P1 → P2 → P1
#### Finalización: 
P1=11, P2=10, P3=6
#### Ejecución:
P1: (11 − 0) − 5 = 6
P2: (10 − 1) − 4 = 5
P3: (6 − 2) − 2 = 2
promedio ≈ 4.33


---

### Ejercicio 04: Prioridades (sin expropiación)

| Proceso | Prioridad | Llegada | Ejecución |
|---------|-----------|---------|-----------|
| P1      | 3         | 0       | 4         |
| P2      | 1         | 1       | 3         |
| P3      | 4         | 2       | 1         |
| P4      | 2         | 3       | 2         |

> **Nota:** La prioridad **1 es la más alta**.

**Tarea:**  
Determinar el orden de ejecución según prioridad.
#### Orden:
P1 → P2 → P4 → P3


---

### Ejercicio 05: Prioridades con expropiación

| Proceso | Prioridad | Llegada | Ejecución |
|---------|-----------|---------|-----------|
| P1      | 3         | 0       | 7         |
| P2      | 1         | 2       | 4         |
| P3      | 2         | 4       | 3         |

**Tarea:**  
Mostrar cómo se interrumpe la CPU al llegar un proceso con **prioridad mayor** (más alta, es decir, número menor).

#### Ejecución:
- t=0–2: P1 ejecuta
- t=2: llega P2 (prioridad 1 < 3) → expropia a P1
- t=2–6: P2 ejecuta y termina
- t=6: entre P1 (prio=3) y P3 (prio=2) → se elige P3
- t=6–9: P3 termina
- t =9–14: P1 termina

---

### Ejercicio 06: Round Robin con quantum = 3

| Proceso | Llegada | Ejecución |
|---------|---------|-----------|
| P1      | 0       | 9         |
| P2      | 1       | 5         |
| P3      | 2       | 3         |
| P4      | 3       | 5         |

**Tarea:**  
Calcular el **diagrama de Gantt** y los **tiempos de espera**.

#### Finalización: 
P1=23, P2=17, P3=9, P4=20
#### WT:
- P1: (23 − 0) − 9 = 14
- P2: (17 − 1) − 5 = 11
- P3: (9 − 2) − 3 = 4
- P4: (20 − 3) − 5 = 12
- Promedio = 10.25


---

### Ejercicio 07: Mezcla de llegada tardía (FCFS vs SJF)

| Proceso | Llegada | Ejecución |
|---------|---------|-----------|
| P1      | 0       | 6         |
| P2      | 5       | 2         |
| P3      | 6       | 1         |

**Tarea:**  
Comparar el **orden de ejecución** y los **resultados (WT, TT)** bajo **FCFS** y **SJF**.
#### Orden de llegada: 
P1 → P2 → P3
#### Ejecución:
- P1: t=0 → t=6
- P2: t=6 → t=8
- P3: t=8 → t=9
#### Tiempos de espera:
- P1: 0 − 0 = 0
- P2: 6 − 5 = 1
- P3: 8 − 6 = 2
- Promedio = (0 + 1 + 2) / 3 = 1.0

---

### Ejercicio 08: SRTF – Procesos interrumpidos por llegada de más cortos

| Proceso | Llegada | Ejecución |
|---------|---------|-----------|
| P1      | 0       | 10        |
| P2      | 1       | 4         |
| P3      | 2       | 2         |
| P4      | 6       | 1         |

**Tarea:**  
Analizar el efecto de las interrupciones sobre el **tiempo medio de espera**.

> **SRTF** = Shortest Remaining Time First (versión expropiativa de SJF).


#### Ejecución:

- t=0–1: P1
- t=1: llega P2 (4 < 9) → expropia
- t=1–2: P2
- t=2: llega P3 (2 < 3) → expropia
- t=2–4: P3 termina
- t=4–6: P2 (resto=2)
- t=6: llega P4 (1 < 2) → expropia
- t=6–7: P4 termina
- t=7–8: P2 termina
- t=8–18: P1 termina

#### WT:
- P1: (18−0)−10 = 8
- P2: (8−1)−4 = 3
- P3: (4−2)−2 = 0
- P4: (7−6)−1 = 0
- promedio = 2.75
