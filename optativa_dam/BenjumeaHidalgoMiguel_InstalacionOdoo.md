# MANUAL DE INSTALACIÓN DE ODOO 18 EN DEBIAN 13

**Autor:** Manual adaptado para entorno de desarrollo Odoo en Debian 13  
**Fecha:** Enero 2026  
**Sistema:** Debian 13 (Trixie)  
**Python:** 3.13.5  
**PostgreSQL:** 17.7  
**Odoo:** 18.0

---

## ÍNDICE

1. [Requisitos previos](#1-requisitos-previos)
2. [Actualización del sistema](#2-actualización-del-sistema)
3. [Instalación de PostgreSQL](#3-instalación-de-postgresql)
4. [Instalación de dependencias del sistema](#4-instalación-de-dependencias-del-sistema)
5. [Descarga de Odoo desde repositorio](#5-descarga-de-odoo-desde-repositorio)
6. [Configuración del entorno virtual de Python](#6-configuración-del-entorno-virtual-de-python)
7. [Instalación de dependencias de Odoo](#7-instalación-de-dependencias-de-odoo)
8. [Configuración de PostgreSQL para Odoo](#8-configuración-de-postgresql-para-odoo)
9. [Ejecución de Odoo](#9-ejecución-de-odoo)
10. [Problemas comunes y soluciones](#10-problemas-comunes-y-soluciones)

---

## 1. REQUISITOS PREVIOS

Antes de comenzar la instalación, asegúrate de tener:
- ✅ Debian 13 instalado y actualizado
- ✅ Acceso root o permisos sudo
- ✅ Conexión a internet estable
- ✅ Al menos 4GB de RAM
- ✅ 10GB de espacio en disco disponible

### Versiones requeridas:
- **Python:** 3.11 o superior (Debian 13 incluye 3.13.5)
- **PostgreSQL:** 12 o superior
- **Git:** Cualquier versión reciente

---

## 2. ACTUALIZACIÓN DEL SISTEMA

### Comando:
```bash
sudo apt update -y && sudo apt upgrade -y
```

### Propósito:
Actualiza la lista de paquetes disponibles y actualiza todos los paquetes instalados a sus últimas versiones. Esto garantiza que el sistema tenga los últimos parches de seguridad y mejoras de estabilidad.

### Explicación:
- `apt update`: Sincroniza los repositorios y descarga información de paquetes
- `apt upgrade`: Instala las versiones más recientes de los paquetes instalados
- `-y`: Responde automáticamente "sí" a todas las confirmaciones

---

## 3. INSTALACIÓN DE POSTGRESQL

### 3.1. Instalar PostgreSQL y módulos adicionales

```bash
sudo apt install -y postgresql postgresql-contrib
```

**Propósito:** Instala PostgreSQL (sistema de gestión de bases de datos) que Odoo utiliza para almacenar todos sus datos. El paquete `postgresql-contrib` incluye módulos y extensiones adicionales útiles.

**Explicación:**
- `postgresql`: Motor de base de datos principal
- `postgresql-contrib`: Extensiones adicionales (funciones, tipos de datos)

### 3.2. Verificar estado del servicio

```bash
sudo systemctl status postgresql
```

**Propósito:** Verifica que el servicio de PostgreSQL esté activo y funcionando correctamente. Debe mostrar "active (running)" en verde.

### 3.3. Iniciar PostgreSQL si no está activo

```bash
sudo systemctl start postgresql
sudo systemctl enable postgresql
```

**Propósito:**
- `start`: Inicia el servicio inmediatamente
- `enable`: Configura PostgreSQL para iniciarse automáticamente al arrancar

---

## 4. INSTALACIÓN DE DEPENDENCIAS DEL SISTEMA

### Comando:
```bash
sudo apt install -y git libpq-dev python3-dev libxml2-dev libxslt1-dev \
libldap2-dev libsasl2-dev libjpeg-dev libfreetype6-dev zlib1g-dev \
liblcms2-dev libtiff5-dev tk-dev tcl-dev libssl-dev node-less npm \
python3-venv
```

### Propósito:
Instala las bibliotecas del sistema que las dependencias de Python de Odoo necesitan para compilarse e instalarse correctamente.

### Explicación de paquetes principales:
- `git`: Control de versiones para descargar Odoo
- `libpq-dev`: Biblioteca de desarrollo de PostgreSQL
- `python3-dev`: Headers de Python para compilar extensiones
- `libxml2-dev`, `libxslt1-dev`: Procesamiento de archivos XML
- `libldap2-dev`: Soporte para autenticación LDAP
- `libjpeg-dev`, `libfreetype6-dev`: Procesamiento de imágenes
- `node-less`: Compilador de hojas de estilo CSS
- `python3-venv`: Módulo para crear entornos virtuales

---

## 5. DESCARGA DE ODOO DESDE REPOSITORIO

### 5.1. Clonar el repositorio de Odoo

```bash
cd ~
git clone https://www.github.com/odoo/odoo --depth 1 --branch 18.0 \
--single-branch odoo18
```

**Propósito:** Descarga el código fuente de Odoo 18 desde GitHub directamente a tu sistema.

**Explicación:**
- `--depth 1`: Descarga solo la última versión (no todo el historial)
- `--branch 18.0`: Especifica la rama de Odoo 18
- `--single-branch`: Descarga solo la rama especificada (ahorra espacio)
- `odoo18`: Nombre del directorio donde se guardará

**Alternativa para otra versión:**
```bash
git clone https://www.github.com/odoo/odoo --depth 1 --branch 17.0 \
--single-branch odoo17
```

**Tiempo estimado:** 5-15 minutos dependiendo de tu conexión a internet.

### 5.2. Verificar la descarga

```bash
ls -la odoo18/
```

**Propósito:** Lista el contenido del directorio de Odoo para verificar que se descargó correctamente. Deberías ver carpetas como "addons", "odoo", y el archivo "odoo-bin".

---

## 6. CONFIGURACIÓN DEL ENTORNO VIRTUAL DE PYTHON

### 6.1. Verificar versión de Python

```bash
python3 --version
```

**Salida esperada:** `Python 3.13.5` (o superior a 3.11)

### 6.2. Crear entorno virtual

```bash
python3 -m venv odoo18-venv
```

**Propósito:** Crea un entorno virtual de Python aislado donde se instalarán las dependencias de Odoo. Esto evita conflictos con paquetes del sistema y permite tener diferentes versiones de librerías para diferentes proyectos.

**Explicación:**
- `python3 -m venv`: Usa el módulo venv de Python 3
- `odoo18-venv`: Nombre del directorio del entorno virtual

### 6.3. Activar entorno virtual

```bash
source odoo18-venv/bin/activate
```

**Propósito:** Activa el entorno virtual. Tu prompt cambiará para mostrar `(odoo18-venv)` al inicio, indicando que estás trabajando dentro del entorno virtual.

**⚠️ IMPORTANTE:** Debes activar el entorno virtual CADA VEZ que abras una nueva terminal antes de trabajar con Odoo.

### 6.4. Desactivar entorno virtual (para referencia)

```bash
deactivate
```

**Propósito:** Sale del entorno virtual y vuelve al Python del sistema. No ejecutes esto ahora, solo es para que sepas cómo salir cuando termines.

---

## 7. INSTALACIÓN DE DEPENDENCIAS DE ODOO

**⚠️ ASEGÚRATE DE TENER EL ENTORNO VIRTUAL ACTIVADO** antes de ejecutar estos comandos.

### 7.1. Actualizar pip

```bash
pip install --upgrade pip
```

**Propósito:** Actualiza pip (el gestor de paquetes de Python) a su última versión para evitar problemas de compatibilidad durante la instalación de dependencias.

### 7.2. Instalar setuptools y wheel

```bash
pip install setuptools wheel
```

**Propósito:** Instala herramientas fundamentales para compilar e instalar paquetes de Python. Estos son necesarios antes de instalar las dependencias de Odoo.

**Explicación:**
- `setuptools`: Facilita la instalación de paquetes Python
- `wheel`: Formato de distribución de paquetes Python precompilados

### 7.3. Instalar dependencias de Odoo

```bash
pip install -r odoo18/requirements.txt
```

**Propósito:** Instala todas las librerías Python que Odoo necesita para funcionar. El archivo `requirements.txt` contiene la lista completa de dependencias con sus versiones específicas.

**⏱️ Tiempo estimado:** 10-20 minutos dependiendo de tu conexión y CPU.

### Dependencias principales incluidas:
- **Babel**: Internacionalización y localización
- **decorator**: Decoradores para funciones Python
- **docutils**: Procesamiento de documentación
- **feedparser**: Análisis de feeds RSS/Atom
- **gevent**: Librería de networking asíncrono
- **Jinja2**: Motor de plantillas
- **lxml**: Procesamiento de XML y HTML
- **Pillow**: Procesamiento de imágenes
- **psycopg2**: Conector de PostgreSQL
- **python-dateutil**: Manipulación de fechas
- **reportlab**: Generación de PDFs
- **requests**: Cliente HTTP
- **Werkzeug**: Utilidades WSGI
- **xlrd, xlwt, xlsxwriter**: Manejo de archivos Excel

### Problemas comunes durante la instalación:

Si algún paquete falla al instalarse, probablemente falte alguna dependencia del sistema. Revisa los mensajes de error y busca el paquete `-dev` correspondiente.

---

## 8. CONFIGURACIÓN DE POSTGRESQL PARA ODOO

### 8.1. Crear usuario de PostgreSQL

```bash
sudo -u postgres createuser -s tu_usuario
```

**Propósito:** Crea un usuario de PostgreSQL llamado "tu_usuario" con permisos de superusuario (`-s`). Odoo usará este usuario para conectarse a la base de datos.

**Explicación:**
- `sudo -u postgres`: Ejecuta el comando como el usuario postgres
- `createuser`: Utilidad de PostgreSQL para crear usuarios
- `-s`: Otorga privilegios de superusuario (necesario para crear/eliminar bases de datos)

**Ejemplo real:**
```bash
sudo -u postgres createuser -s benemerito
```

### 8.2. Establecer contraseña para el usuario

```bash
sudo -u postgres psql
```

Dentro de psql, ejecuta:
```sql
\password tu_usuario
```

**Propósito:** Accede a la consola de PostgreSQL y establece una contraseña para el usuario. Escribe tu contraseña cuando se solicite (no se mostrará mientras escribes por seguridad).

**Ejemplo:**
```sql
\password benemerito
```

Después de establecer la contraseña, sal con:
```sql
\q
```

**⚠️ IMPORTANTE:** Recuerda esta contraseña, la necesitarás para ejecutar Odoo.

### 8.3. Crear base de datos inicial (OPCIONAL)

```bash
sudo -u postgres createdb -O tu_usuario odoo_db
```

**Propósito:** Crea una base de datos llamada "odoo_db" con tu_usuario como propietario. Esto es opcional porque Odoo puede crear la base de datos automáticamente al ejecutarse por primera vez con el parámetro `-i base`.

**Explicación:**
- `createdb`: Utilidad de PostgreSQL para crear bases de datos
- `-O tu_usuario`: Define tu_usuario como propietario de la base de datos
- `odoo_db`: Nombre de la base de datos

### 8.4. Verificar usuario y base de datos

```bash
sudo -u postgres psql -c "\du"
sudo -u postgres psql -c "\l"
```

**Propósito:** Verifica que el usuario y la base de datos se crearon correctamente.

**Explicación:**
- `\du`: Lista todos los usuarios de PostgreSQL
- `\l`: Lista todas las bases de datos

---

## 9. EJECUCIÓN DE ODOO

### 9.1. Ejecutar Odoo por primera vez

**⚠️ Asegúrate de tener el entorno virtual activado:**
```bash
source odoo18-venv/bin/activate
```

**Comando para ejecutar Odoo:**
```bash
python odoo18/odoo-bin -r tu_usuario -w tu_password --addons-path=odoo18/addons \
-d odoo_db -i base
```

**Propósito:** Inicia el servidor de Odoo y crea/inicializa la base de datos con el módulo base instalado.

### Explicación de parámetros:
- `python`: Ejecuta Odoo con Python (usará el del entorno virtual activo)
- `odoo18/odoo-bin`: Script principal de Odoo
- `-r tu_usuario`: Usuario de PostgreSQL que creaste
- `-w tu_password`: Contraseña del usuario PostgreSQL
- `--addons-path=odoo18/addons`: Ruta donde están los módulos de Odoo
- `-d odoo_db`: Nombre de la base de datos a usar/crear
- `-i base`: Instala el módulo "base" (obligatorio en primera ejecución)

**Ejemplo real:**
```bash
python odoo18/odoo-bin -r benemerito -w 8686 --addons-path=odoo18/addons \
-d odoo_db -i base
```

### Salida esperada:

Verás muchas líneas de log. Al final debe aparecer:
```
INFO ? odoo.service.server: HTTP service (werkzeug) running on 0.0.0.0:8069
```

Esto significa que Odoo está corriendo correctamente.

### 9.2. Ejecutar Odoo en siguientes ocasiones

```bash
python odoo18/odoo-bin -r tu_usuario -w tu_password --addons-path=odoo18/addons \
-d odoo_db
```

**Propósito:** Inicia Odoo normalmente después de la primera instalación. Ya no necesitas el parámetro `-i base`.

### 9.3. Acceder a Odoo desde el navegador

**URL:**
```
http://localhost:8069
```

**Credenciales por defecto:**
- **Usuario:** `admin`
- **Contraseña:** `admin`

**Propósito:** Accede a la interfaz web de Odoo. La primera vez verás una pantalla de configuración inicial donde puedes cambiar la contraseña del administrador y configurar la empresa.

### 9.4. Ejecutar Odoo en puerto diferente (OPCIONAL)

```bash
python odoo18/odoo-bin -r tu_usuario -w tu_password --addons-path=odoo18/addons \
-d odoo_db --http-port=8070
```

**Propósito:** Si el puerto 8069 está ocupado, puedes usar otro puerto con `--http-port`.

### 9.5. Crear archivo de configuración (RECOMENDADO)

```bash
python odoo18/odoo-bin --save --config=odoo.conf --stop-after-init \
-r tu_usuario -w tu_password --addons-path=odoo18/addons -d odoo_db
```

**Propósito:** Genera un archivo de configuración `odoo.conf` con todos los parámetros. Así no tendrás que escribir todos los parámetros cada vez que ejecutes Odoo.

**Ejecutar Odoo con archivo de configuración:**
```bash
python odoo18/odoo-bin -c odoo.conf
```

### 9.6. Detener Odoo

Presiona **Ctrl+C** en la terminal donde está corriendo Odoo para detenerlo.

---

## 10. PROBLEMAS COMUNES Y SOLUCIONES

### PROBLEMA 1: Error "Permission denied" al instalar paquetes

**Síntomas:**
```
Error: Could not open lock file /var/lib/dpkg/lock-frontend - open (13: Permission denied)
```

**Causa:** No se instalaron las herramientas con permisos de administrador.

**Solución:**
Usa `sudo` antes del comando:
```bash
sudo apt install -y paquete
```

---

### PROBLEMA 2: Error de conexión a PostgreSQL

**Síntomas:**
```
FATAL: Peer authentication failed for user
could not connect to server: Connection refused
```

**Solución 1 - Verificar que PostgreSQL esté activo:**
```bash
sudo systemctl status postgresql
sudo systemctl start postgresql
```

**Solución 2 - Modificar método de autenticación:**
```bash
sudo nano /etc/postgresql/17/main/pg_hba.conf
```

Cambiar las líneas que digan "peer" por "md5":
```
local   all             all                                     md5
host    all             all             127.0.0.1/32            md5
```

Reiniciar PostgreSQL:
```bash
sudo systemctl restart postgresql
```

---

### PROBLEMA 3: Error "ImportError: libpq.so.5" o librerías faltantes

**Causa:** Falta alguna dependencia del sistema.

**Solución:**
```bash
sudo apt install -y libpq-dev libxml2-dev libxslt1-dev libldap2-dev \
libsasl2-dev libjpeg-dev libfreetype6-dev
```

---

### PROBLEMA 4: Odoo no crea las tablas en la base de datos

**Causa:** No se usó el parámetro `-i base` en la primera ejecución o faltan permisos.

**Solución 1 - Forzar instalación del módulo base:**
```bash
python odoo18/odoo-bin -r tu_usuario -w tu_password --addons-path=odoo18/addons \
-d odoo_db -i base
```

**Solución 2 - Dar permisos de superusuario:**
```bash
sudo -u postgres psql
ALTER USER tu_usuario WITH SUPERUSER;
\q
```

---

### PROBLEMA 5: Puerto 8069 ya está en uso

**Síntomas:**
```
OSError: [Errno 98] Address already in use
```

**Solución 1 - Verificar qué proceso usa el puerto:**
```bash
sudo lsof -i :8069
```

**Solución 2 - Usar otro puerto:**
```bash
python odoo18/odoo-bin -r tu_usuario -w tu_password --addons-path=odoo18/addons \
-d odoo_db --http-port=8070
```

---

### PROBLEMA 6: Error "No module named 'psycopg2'"

**Causa:** Las dependencias de Odoo no se instalaron correctamente.

**Solución:**
Activa el entorno virtual y reinstala dependencias:
```bash
source odoo18-venv/bin/activate
pip install psycopg2-binary
pip install -r odoo18/requirements.txt
```

---

### PROBLEMA 7: Error de permisos al crear base de datos

**Síntomas:**
```
permission denied to create database
```

**Solución:**
```bash
sudo -u postgres psql
ALTER USER tu_usuario CREATEDB;
ALTER USER tu_usuario WITH SUPERUSER;
\q
```

---

### PROBLEMA 8: Olvidé la contraseña del usuario admin de Odoo

**Solución:**
Accede a PostgreSQL y resetea la contraseña:
```bash
sudo -u postgres psql odoo_db
UPDATE res_users SET password='admin' WHERE login='admin';
\q
```

Luego accede con contraseña "admin" y cámbiala desde la interfaz.

---

### PROBLEMA 9: Error durante compilación de dependencias

**Síntomas:**
```
error: command 'gcc' failed
Building wheel for lxml ... error
```

**Solución:**
Instala herramientas de compilación:
```bash
sudo apt install -y build-essential python3-dev libxml2-dev libxslt1-dev
```

Luego reintenta la instalación:
```bash
pip install -r odoo18/requirements.txt
```

---

### PROBLEMA 10: Advertencias sobre Wkhtmltopdf

**Síntomas:**
```
You need Wkhtmltopdf to print a pdf version of the reports.
```

**Causa:** Falta el paquete para generar PDFs (no crítico para desarrollo).

**Solución (opcional):**
```bash
sudo apt install -y wkhtmltopdf
```

---

## COMANDOS DE REFERENCIA RÁPIDA

### Gestión del entorno virtual
```bash
# Activar entorno virtual
source odoo18-venv/bin/activate

# Desactivar entorno virtual
deactivate
```

### Ejecución de Odoo
```bash
# Con parámetros completos
python odoo18/odoo-bin -r benemerito -w 8686 --addons-path=odoo18/addons -d odoo_db

# Con archivo de configuración
python odoo18/odoo-bin -c odoo.conf

# Detener Odoo
Ctrl+C
```

### PostgreSQL
```bash
# Verificar estado
sudo systemctl status postgresql

# Iniciar/detener servicio
sudo systemctl start postgresql
sudo systemctl stop postgresql

# Acceder a psql
sudo -u postgres psql

# Listar bases de datos
sudo -u postgres psql -c "\l"

# Listar usuarios
sudo -u postgres psql -c "\du"
```

### Gestión de módulos
```bash
# Instalar módulo
python odoo18/odoo-bin -c odoo.conf -i nombre_modulo -d odoo_db

# Actualizar módulo
python odoo18/odoo-bin -c odoo.conf -u nombre_modulo -d odoo_db

# Actualizar lista de módulos
python odoo18/odoo-bin -c odoo.conf --update=all -d odoo_db
```

### Actualizar Odoo
```bash
# Actualizar a última versión de la rama 18.0
cd odoo18
git pull origin 18.0
```

---

## ESTRUCTURA DE DIRECTORIOS

```
~/odoo18/                    # Código fuente de Odoo
├── addons/                  # Módulos oficiales de Odoo
├── odoo/                    # Core de Odoo
├── odoo-bin                 # Script principal
└── requirements.txt         # Dependencias Python

~/odoo18-venv/               # Entorno virtual de Python
├── bin/                     # Ejecutables (python, pip, activate)
├── lib/                     # Librerías instaladas
└── ...

~/odoo.conf                  # Archivo de configuración (si lo creaste)
```

---

## SIGUIENTES PASOS

1. ✅ Explorar la interfaz de Odoo en `http://localhost:8069`
2. ✅ Instalar aplicaciones desde el menú "Apps"
3. ✅ Configurar tu empresa desde Ajustes
4. ✅ Cambiar la contraseña por defecto del administrador
5. ✅ Crear módulos personalizados:
   ```bash
   mkdir ~/odoo_custom_addons
   ```
   Luego agrega la ruta al ejecutar Odoo:
   ```bash
   --addons-path=odoo18/addons,~/odoo_custom_addons
   ```

6. ✅ Leer documentación oficial de desarrollo:
   - [https://www.odoo.com/documentation/18.0/developer.html](https://www.odoo.com/documentation/18.0/developer.html)

---

## RECURSOS ADICIONALES

- **Documentación oficial:** [https://www.odoo.com/documentation/18.0/](https://www.odoo.com/documentation/18.0/)
- **Repositorio GitHub:** [https://github.com/odoo/odoo](https://github.com/odoo/odoo)
- **Comunidad Odoo:** [https://www.odoo.com/forum](https://www.odoo.com/forum)
- **Videos tutoriales:** [https://www.youtube.com/c/Odoo](https://www.youtube.com/c/Odoo)

---

## CONFIGURACIÓN PARA PRODUCCIÓN (Opcional)

Para un entorno de producción, considera:

### 1. Crear servicio systemd

```bash
sudo nano /etc/systemd/system/odoo.service
```

Contenido del archivo:
```ini
[Unit]
Description=Odoo 18
After=network.target postgresql.service

[Service]
Type=simple
User=tu_usuario
Group=tu_usuario
ExecStart=/home/tu_usuario/odoo18-venv/bin/python /home/tu_usuario/odoo18/odoo-bin -c /home/tu_usuario/odoo.conf
StandardOutput=journal+console

[Install]
WantedBy=multi-user.target
```

Habilitar y iniciar el servicio:
```bash
sudo systemctl daemon-reload
sudo systemctl enable odoo
sudo systemctl start odoo
sudo systemctl status odoo
```

### 2. Configurar Nginx como proxy inverso

```bash
sudo apt install -y nginx
sudo nano /etc/nginx/sites-available/odoo
```

Configuración básica:
```nginx
server {
    listen 80;
    server_name tu_dominio.com;

    location / {
        proxy_pass http://localhost:8069;
        proxy_set_header Host \$host;
        proxy_set_header X-Real-IP \$remote_addr;
        proxy_set_header X-Forwarded-For \$proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto \$scheme;
    }
}
```

Activar configuración:
```bash
sudo ln -s /etc/nginx/sites-available/odoo /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

### 3. Configurar SSL con Let's Encrypt

```bash
sudo apt install -y certbot python3-certbot-nginx
sudo certbot --nginx -d tu_dominio.com
```

---

## NOTAS FINALES

- ⚠️ Recuerda **SIEMPRE** activar el entorno virtual antes de trabajar con Odoo
- 💾 Haz copias de seguridad regulares de tu base de datos PostgreSQL:
  ```bash
  pg_dump -U tu_usuario odoo_db > backup_odoo_$(date +%Y%m%d).sql
  ```
- 🔒 Para producción, **NO uses la contraseña "admin"**, cámbiala inmediatamente
- 🌐 Usa un proxy inverso (nginx) para HTTPS en entornos de producción
- 📊 Monitorea los logs de Odoo para detectar errores:
  ```bash
  tail -f /var/log/odoo/odoo.log
  ```

---

## DIFERENCIAS ENTRE ODOO, ODOO.SH Y ODOO.COM

- **Odoo (Community Edition):** Versión gratuita y de código abierto que instalas en tu propio servidor. Ideal para desarrollo y personalización total.

- **Odoo Enterprise:** Versión de pago con módulos adicionales y soporte oficial. Requiere licencia.

- **Odoo.sh:** Plataforma PaaS (Platform as a Service) de Odoo para hosting en la nube con integración Git. De pago.

- **Odoo.com:** SaaS (Software as a Service) donde Odoo gestiona todo el hosting y mantenimiento. De pago.

---

**¡Instalación completada con éxito! 🎉**

Si tienes problemas o dudas, revisa la sección de [Problemas comunes](#10-problemas-comunes-y-soluciones) o consulta la documentación oficial de Odoo.

---

*Manual creado en Enero 2026 - Versión 1.0*
