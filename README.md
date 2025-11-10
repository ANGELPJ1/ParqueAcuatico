# Documentación del Proyecto Server Center

## 🧭 Introducción

- **Descripción general**
  Sistema de gestión para Server Center compuesto por microservicios de backend en Spring Boot y un frontend en Angular. Gestiona usuarios y operaciones de almacén (componentes, productos, entradas, salidas), con autenticación JWT.

- **Objetivos del sistema**
  - **Usuarios:** autenticación, administración y obtención de perfil.
  - **Almacén:** alta/edición de componentes y productos, control de stock, registro de entradas y salidas.
  - **Frontend:** panel de control con módulos por área y catálogo.

- **Alcance y arquitectura general**
  Arquitectura cliente-servidor con frontend Angular 19 consumiendo dos microservicios Spring Boot (puertos 8081 y 8082) y MySQL como base de datos (dos esquemas: `usuarios` y `almacen`).

## ⚙️ Arquitectura técnica

- **Diagrama general (Backend + Frontend + BD)**
```mermaid
flowchart LR
  A[Angular 19 (navegacion)] --HTTP--> B[usuarios-service :8082]
  A --HTTP--> C[almacen-service :8081]
  B --JDBC--> D[(MySQL DB usuarios)]
  C --JDBC--> E[(MySQL DB almacen)]
```

- **Tecnologías utilizadas**
  - **Backend:** Java 21, Spring Boot 3.5.x, Spring Web, Spring Data JPA, Spring Security (JWT), Lombok, MySQL Driver
  - **Frontend:** Angular 19, RxJS, SSR opcional (@angular/ssr), Chart.js, SweetAlert2
  - **Base de Datos:** MySQL 8.0
  - **Dev/Deploy:** Docker (mysql:8.0.33), docker-compose

- **Estructura de carpetas del código**
  - `microservices/`
    - `pom.xml` (packaging pom; módulos `almacen-service`, `usuarios-service`)
    - `almacen-service/`
      - `src/main/java/com/servercenter/almacen_service/...`
      - `src/main/resources/application.properties`
      - Puerto: `8081`
    - `usuarios-service/`
      - `src/main/java/com/servercenter/usuarios_service/...`
      - `src/main/resources/application.properties`
      - Puerto: `8082`
    - `docker-compose.yml` (MySQL para ambos esquemas)
  - `navegacion/` (Angular 19)
    - `angular.json`, `package.json`, `src/app/...`

## 💾 Backend

- **Descripción de módulos**
  - `usuarios-service` (`com.servercenter.usuarios_service`)
    - Autenticación JWT, CRUD de usuarios y endpoint de perfil.
  - `almacen-service` (`com.servercenter.almacen_service`)
    - Gestión de componentes, productos (incluye imágenes y stock), entradas y salidas.

- **Configuración clave**
  - `microservices/almacen-service/src/main/resources/application.properties`
    - `server.port=8081`
    - `spring.datasource.url=jdbc:mysql://localhost:3306/almacen`
    - `spring.jpa.hibernate.ddl-auto=update`
  - `microservices/usuarios-service/src/main/resources/application.properties`
    - `server.port=8082`
    - `spring.datasource.url=jdbc:mysql://localhost:3306/usuarios`
    - `spring.security.user.*` (credenciales básicas de seguridad por defecto)

- **Flujo de APIs (endpoints, métodos, ejemplos JSON)**
  - `usuarios-service` base: `/usuario/usuarios`
    - `POST /login`
      - Body:
```json
{ "nombreUsuario": "admin", "contrasena": "secret" }
```
      - Respuesta 200:
```json
{ "token": "<JWT>", "area": "Almacen" }
```
    - `POST /registro`
      - Body: `Usuario` (nombre, apePat, apeMat, puesto, area, nombreUsuario, contrasena)
      - Respuesta 201: `{ token, area, message }`
    - `GET /list` (Auth: Bearer JWT)
    - `GET /list/{id}` (Auth)
    - `POST /save` (Auth)
    - `PUT /update/{id}` (Auth)
    - `DELETE /delete/{id}` (Auth)
    - `GET /me` (Auth) — usuario autenticado sin contraseña
  - `usuarios-service` código de verificación base: `/usuario/codigo`
    - `POST /guardar` — guarda hash (BCrypt) del código
    - `POST /verificar` — valida código contra id fijo `6`
    - `GET /todos`
  - `almacen-service` componentes base: `/Almacen/componentes`
    - `GET /todos`
    - `GET /{id}`
    - `GET /codigo/{codigo}`
    - `POST /` (multipart/form-data: `nombreComponente`, `codigoComponente`, `descripcionComponente?`, `imagenComponente?`)
    - `PUT /{id}` (multipart/form-data)
    - `DELETE /{id}`
    - `GET /{id}/imagen` (bytes JPEG)
  - `almacen-service` productos base: `/Almacen/productos`
    - `GET /todos`
    - `GET /{id}`
    - `GET /componente/{codigoComponente}`
    - `GET /categoria/{nombreComponente}`
    - `POST /crear` (multipart/form-data: datos de producto + `imagenProducto?`)
    - `PUT /actualizar/{id}` (multipart/form-data)
    - `PUT /actualizarStock/{id}`
```json
{ "stockChange": 5 }
```
    - `DELETE /eliminar/{id}`
    - `GET /{id}/imagen` (bytes JPEG)
  - `almacen-service` entradas base: `/Almacen/entradas`
    - `GET /Listar`
    - `GET /Listar/{id}`
    - `POST /Crear`
    - `PUT /Actualizar/{id}`
    - `DELETE /Eliminar/{id}`
  - `almacen-service` salidas base: `/Almacen/salidas`
    - `GET /Listar`
    - `GET /Listar/{id}`
    - `GET /Listar/codigo/{codigo}`
    - `POST /Registrar`
    - `PUT /Actualizar/{id}`
    - `DELETE /Eliminar/{id}`

- **Integraciones**
  - **Login/Seguridad:** JWT (`io.jsonwebtoken:jjwt-*`), `JwtUtil` para generación de token.
  - **CORS:** habilitado para `http://localhost:4200` en varios controladores.
  - No se observan integraciones de correo/notificaciones en el código actual.

## 🎨 Frontend (Angular 19)

- **Componentes y rutas principales** (`navegacion/src/app/app.routes.ts`)
  - Públicas: `login`, `principal`, `acerca`, `servicios`, `contacto`, `catalogo`, `servidores/:categoria`
  - Dashboard (hijo de `InicioComponent` con `AuthGuard`):
    - `almacen`, `ventas`, `embarque`, `registro-producto`, `catalogo-almacen/:categoria`
    - Administración: `administrador`, `gestion-usuarios`
    - Sistemas: `sistemas`, `farma`

- **Servicios conectados al backend** (`navegacion/src/app/services/`)
  - `usuario.service.ts` → `http://localhost:8082/usuario/usuarios` (login, CRUD, me)
  - `componente.service.ts` → `http://localhost:8081/Almacen/componentes`
  - `producto.service.ts` → `http://localhost:8081/Almacen/productos`
  - `entrada.service.ts` → `http://localhost:8081/Almacen/entradas`
  - `salida.service.ts` → `http://localhost:8081/Almacen/salidas`

- **Ejemplo de uso/flujo visual**
  - Login → guarda token JWT en `sessionStorage` → navegación a dashboard.
  - Módulo Almacén → CRUD de componentes/productos (con carga de imágenes) → actualización de stock → registro de salidas.

## 🧠 Base de Datos

- **Diagrama entidad-relación (ERD)**
```mermaid
erDiagram
  USUARIOS {
    int id PK
    varchar ape_mat
    varchar ape_pat
    varchar area
    varchar contrasena
    varchar nombre
    varchar nombre_usuario
    varchar puesto
  }
  CODIGO_VERIFICACION {
    int id_codigo PK
    varchar codigo_codigo (hash)
  }
  COMPONENTES {
    bigint id_componente PK
    int codigo_componente
    varchar nombre_componente
    blob? imagen
    text? descripcion
  }
  PRODUCTOS {
    bigint id_producto PK
    int codigo_componente FK
    varchar marca_producto
    varchar modelo_producto
    varchar NumeroParteGen_producto?
    varchar NumeroParte_producto?
    varchar NumeroSerie_producto?
    varchar capacidad_producto?
    int total_stock?
    blob? imagen
  }
  ENTRADAS {
    int idEntrada PK
    int codigo_componente FK
    ...
  }
  SALIDAS {
    bigint id_salida PK
    ...
  }
  COMPONENTES ||--o{ PRODUCTOS : "codigo_componente"
  COMPONENTES ||--o{ ENTRADAS : "codigo_componente"
```

- **Explicación de tablas y relaciones**
  - Esquema `usuarios`: tablas `usuarios`, `codigo_verificacion`.
  - Esquema `almacen`: `componentes`, `productos`, `entradas`, `salidas`.
  - No hay FKs explícitas en el dump; se infieren relaciones por `codigo_componente`.

- **Consultas SQL más relevantes**
  - Búsqueda por usuario: `SELECT * FROM usuarios WHERE nombre_usuario = ?` (usada por repositorio)
  - Filtrado de productos por `codigo_componente` y por categoría (nombre de componente) en servicios.

## 🧰 Despliegue y entorno

- **Configuración local**
  - Backend:
    - `usuarios-service` en `:8082`
    - `almacen-service` en `:8081`
    - Ajustar `spring.datasource.*` si se usan contenedores (ver puertos mapeados abajo).
  - Frontend:
    - `navegacion`: `npm install` → `npm start` (puerto `4200`)

- **Docker Compose** (`microservices/docker-compose.yml`)
  - `db-usuarios`: MySQL 8.0.33, puerto host `33061` → contenedor `3306`, DB `usuarios`
  - `db-almacen`: MySQL 8.0.33, puerto host `33062` → contenedor `3306`, DB `almacen`
  - Nota: En `application.properties` las URLs apuntan a `localhost:3306`. Si se usan estos contenedores, cambiar a:
    - `jdbc:mysql://localhost:33061/usuarios` (usuarios-service)
    - `jdbc:mysql://localhost:33062/almacen` (almacen-service)

- **Backup y restauración**
  - Backup:
    - `mysqldump -h 127.0.0.1 -P 33061 -u root -p usuarios > usuarios.sql`
    - `mysqldump -h 127.0.0.1 -P 33062 -u root -p almacen > almacen.sql`
  - Restore:
    - `mysql -h 127.0.0.1 -P 33061 -u root -p usuarios < usuarios.sql`
    - `mysql -h 127.0.0.1 -P 33062 -u root -p almacen < almacen.sql`

## 🧾 Manual de usuario

- **Uso del dashboard**
  - Iniciar sesión en `/login`. Tras éxito, se navega al panel principal.
  - Acceder a módulos según área: Almacén, Ventas, Embarque, Administración, Sistemas, Farma.

- **Roles**
  - Se infiere al menos rol de administración para gestionar usuarios; la autorización se basa en validación de JWT en backend.

- **Capturas de pantalla del flujo completo**
  - Pendiente de agregar. Sugerido: login, listado de usuarios, gestión de componentes, registro de producto, listado de salidas.

## 📄 Anexos

- **Créditos y autores**
  - Proyecto `Server Center` — equipo de desarrollo Tesis12.

- **Historial de versiones**
  - v0.1: Estructura inicial de microservicios, módulos de usuarios y almacén, Angular básico.

- **Plan de mejoras futuras**
  - Unificar convenciones de rutas REST (camelCase/snake_case y verbos)
  - Añadir relaciones FK explícitas en BD y migraciones
  - Externalizar configuración sensible (contraseñas) a variables de entorno
  - Mejorar seguridad de contraseñas (hash + salting para usuarios)
  - Añadir pruebas automatizadas y CI/CD
