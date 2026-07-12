# Mi Gestor Pro - Smoke Test E2E

> **Objetivo:** Verificar que todos los flujos de la aplicación funcionan correctamente antes de producción.
>
> **Modo de uso:** Marca cada paso con ✅ OK, ⚠️ PARCIAL o ❌ FALLA. Al final, cuenta cuántos ✅ vs ❌.

## Pre-requisitos

- [ ] Servidor corriendo en `http://gestor-pro.test:3307`
- [ ] Base de datos MySQL con migraciones aplicadas (`php artisan migrate`)
- [ ] Sesión limpia (logout si hay sesión activa)
- [ ] Email del usuario admin conocido (ej: `admin@gestor.com`)
- [ ] Un archivo PDF de prueba (cualquier PDF pequeño < 1MB)

---

## 1. Registro y Login

### 1.1 Registro de usuario nuevo
- [ ] Ir a `/register` (sin estar autenticado)
- [ ] Llenar: nombre, email NUEVO, password, confirmar
- [ ] Click en "Crear cuenta"
- [ ] **Esperado:** Redirige a `/dashboard` con sesión iniciada
- [ ] **Verificar en DB:** El usuario existe en tabla `users`
- [ ] **Verificar en DB:** Existe registro en tabla `settings` con `user_id` correspondiente

### 1.2 Login con credenciales correctas
- [ ] Logout (botón en sidebar)
- [ ] Ir a `/login`
- [ ] Llenar email y password del usuario nuevo
- [ ] Click en "Acceder"
- [ ] **Esperado:** Redirige a `/dashboard`

### 1.3 Login con credenciales incorrectas
- [ ] Logout
- [ ] Llenar email correcto + password incorrecto
- [ ] **Esperado:** Error "Estas credenciales no coinciden con nuestros registros"
- [ ] Intentar 6 veces seguidas (rápido)
- [ ] **Esperado en el 6to intento:** Error "Demasiados intentos. Por favor espera un minuto"
- [ ] Esperar 1 minuto
- [ ] Intentar de nuevo
- [ ] **Esperado:** Funciona normalmente

---

## 2. Clientes

### 2.1 Crear cliente
- [ ] Ir a `/clientes/create`
- [ ] Llenar: nombre, email único, teléfono, empresa
- [ ] Click en "Crear Cliente"
- [ ] **Esperado:** Redirige a `/clientes`, aparece en la lista
- [ ] **Verificar en DB:** Existe en tabla `clientes` con `user_id` correcto

### 2.2 Ver detalle de cliente
- [ ] Click en el nombre de un cliente
- [ ] **Esperado:** Muestra `/clientes/{id}` con todos los datos

### 2.3 Editar cliente
- [ ] En el detalle, click en "Editar"
- [ ] Cambiar el nombre
- [ ] Click en "Guardar"
- [ ] **Esperado:** Redirige a `/clientes`, cambios reflejados

### 2.4 Eliminar cliente (sin proyectos)
- [ ] Crear un cliente nuevo (sin proyectos asociados)
- [ ] Click en eliminar (icono papelera)
- [ ] Confirmar
- [ ] **Esperado:** Cliente eliminado de la lista
- [ ] **Verificar:** Aparece notificación en el bell del header

### 2.5 Intentar eliminar cliente CON proyectos
- [ ] Crear un cliente + crear un proyecto para ese cliente
- [ ] Intentar eliminar el cliente
- [ ] **Esperado:** Error "No se puede eliminar el cliente porque tiene 1 proyecto(s) asociado(s)"
- [ ] Cliente NO se elimina

---

## 3. Proyectos

### 3.1 Crear proyecto
- [ ] Ir a `/proyectos/create`
- [ ] Llenar: título, descripción, fecha inicio, fecha entrega, estado
- [ ] Seleccionar cliente del dropdown
- [ ] Click en "Crear Proyecto"
- [ ] **Esperado:** Redirige a `/proyectos`, aparece en la lista

### 3.2 Ver detalle de proyecto
- [ ] Click en un proyecto
- [ ] **Esperado:** Muestra `/proyectos/{id}` con hero, 3 info cards, tareas, sidebar de archivos

### 3.3 Editar proyecto
- [ ] Click en "Editar"
- [ ] Cambiar título
- [ ] Guardar
- [ ] **Esperado:** Cambios reflejados

### 3.4 Exportar a PDF
- [ ] En `/proyectos/{id}`, click en "Exportar a PDF" (sidebar)
- [ ] **Esperado:** Descarga archivo `proyecto-{slug}.pdf`
- [ ] Abrir el PDF
- [ ] **Verificar:** Contiene datos del cliente, datos del proyecto, tabla de tareas con badges

### 3.5 Eliminar proyecto
- [ ] En `/proyectos/{id}`, click en "Eliminar proyecto" (sidebar)
- [ ] Confirmar
- [ ] **Esperado:** Redirige a `/proyectos`, proyecto no aparece
- [ ] **Verificar:** Notificación "Proyecto eliminado"

---

## 4. Tareas

### 4.1 Crear tarea
- [ ] En `/proyectos/{id}`, click en "Nueva Tarea"
- [ ] Llenar: nombre, descripción, prioridad, fecha límite
- [ ] Guardar
- [ ] **Esperado:** Aparece en la lista de tareas del proyecto

### 4.2 Marcar tarea como completada (individual)
- [ ] Click en el checkbox de una tarea pendiente
- [ ] **Esperado:** Tarea tachada, opacidad reducida
- [ ] **Verificar:** Bulk bar muestra "1 completada(s)"

### 4.3 Marcar todas como completadas
- [ ] Crear varias tareas pendientes
- [ ] Click en "Marcar todas como cumplidas" (bulk bar)
- [ ] Confirmar
- [ ] **Esperado:** Todas las tareas tachadas
- [ ] **Verificar:** Bulk bar muestra "N completada(s)"

### 4.4 Eliminar tarea individual
- [ ] Click en icono papelera de una tarea
- [ ] Confirmar
- [ ] **Esperado:** Tarea eliminada

### 4.5 Eliminar todas las tareas
- [ ] Click en "Eliminar todas las tareas" (bulk bar)
- [ ] Confirmar
- [ ] **Esperado:** Lista de tareas vacía
- [ ] **Verificar:** Mensaje "X tarea(s) eliminada(s)"

---

## 5. Archivos Adjuntos

### 5.1 Subir archivo
- [ ] En `/proyectos/{id}`, click en la zona de upload (sidebar)
- [ ] Seleccionar un PDF pequeño
- [ ] **Esperado:** Aparece en la lista con icono PDF, nombre, tamaño
- [ ] **Verificar en disco:** `storage/app/private/proyectos/{id}/` contiene un archivo UUID

### 5.2 Descargar archivo
- [ ] Click en el nombre del archivo
- [ ] **Esperado:** Descarga con nombre original

### 5.3 Eliminar archivo
- [ ] Click en icono papelera del archivo
- [ ] Confirmar
- [ ] **Esperado:** Desaparece de la lista
- [ ] **Verificar en disco:** El archivo UUID ya no existe

### 5.4 Validar tipo de archivo
- [ ] Intentar subir un .exe (si tienes uno)
- [ ] **Esperado:** Error "Tipo de archivo no permitido"

### 5.5 Validar tamaño
- [ ] Intentar subir un archivo > 10MB
- [ ] **Esperado:** Error "El archivo no puede superar los 10 MB"

---

## 6. Búsqueda Global

### 6.1 Búsqueda con resultados múltiples
- [ ] En el header, escribir "diseño" (o palabra clave de un cliente/proyecto/tarea)
- [ ] Esperar 300ms
- [ ] **Esperado:** Dropdown con resultados
- [ ] **Verificar:** Cada resultado tiene badge de color (azul claro = cliente, otro = proyecto, otro = tarea)

### 6.2 Búsqueda sin resultados
- [ ] Escribir "asdfghjkl" (texto que no existe)
- [ ] **Esperado:** Mensaje "No se encontraron resultados"

### 6.3 Búsqueda corta
- [ ] Escribir solo "a"
- [ ] **Esperado:** No se dispara búsqueda (mínimo 2 caracteres)

---

## 7. Notificaciones

### 7.1 Ver notificación después de acción
- [ ] Eliminar un cliente
- [ ] Click en el bell del header
- [ ] **Esperado:** Notificación "Cliente eliminado" con mensaje "Se eliminó el cliente: {nombre}"
- [ ] **Verificar:** Contador de no leídas en el badge

### 7.2 Marcar como leída
- [ ] En el dropdown, click en una notificación
- [ ] **Esperado:** Notificación se marca como leída (cambia estilo)
- [ ] El contador del bell disminuye

### 7.3 Ver todas
- [ ] Click en "Ver todas" en el dropdown
- [ ] **Esperado:** Lleva a `/notificaciones` con lista completa
- [ ] Click en "Marcar todas como leídas"
- [ ] **Esperado:** Todas pasan a estado leídas

### 7.4 Validar tiempo relativo
- [ ] Después de una notificación, esperar 30 segundos
- [ ] Refrescar el dropdown
- [ ] **Esperado:** Muestra "ahora", "5 s", "30 s" (NO "Invalid Date")

---

## 8. Configuración (Ajustes)

### 8.1 Cambiar perfil
- [ ] Ir a `/ajustes?tab=profile`
- [ ] Cambiar nombre y email
- [ ] Guardar
- [ ] **Esperado:** Mensaje "Perfil actualizado correctamente"
- [ ] **Verificar:** Nombre actualizado en el header (avatar + tooltip)

### 8.2 Cambiar contraseña
- [ ] Ir a `/ajustes?tab=security`
- [ ] Llenar: actual, nueva, confirmar
- [ ] Guardar
- [ ] **Esperado:** Mensaje "Contraseña actualizada correctamente"
- [ ] **Verificar:** Notificación "Contraseña cambiada"
- [ ] Logout, intentar login con la nueva contraseña
- [ ] **Esperado:** Funciona

### 8.3 Preferencias de notificaciones
- [ ] Ir a `/ajustes?tab=notifications`
- [ ] Desmarcar "Eliminación de clientes"
- [ ] Guardar
- [ ] Eliminar un cliente
- [ ] **Esperado:** NO aparece notificación de "Cliente eliminado"
- [ ] Reactivar la preferencia
- [ ] Eliminar otro cliente
- [ ] **Esperado:** SÍ aparece notificación

### 8.4 Modo oscuro
- [ ] Ir a `/ajustes?tab=appearance`
- [ ] Marcar "Modo Oscuro"
- [ ] Guardar
- [ ] **Esperado:** Mensaje "Apariencia actualizada" (pero el tema sigue claro — el dark mode real está pendiente)

---

## 9. Seguridad Multi-Tenant

### 9.1 Aislamiento de datos entre usuarios
- [ ] Registrar SEGUNDO usuario (`user2@test.com`)
- [ ] Logout del primer usuario
- [ ] Login con segundo usuario
- [ ] **Verificar:** NO ve clientes/proyectos/tareas del primer usuario
- [ ] Intentar acceder a `/clientes/{id-del-primer-usuario}` directamente
- [ ] **Esperado:** Error 403

### 9.2 Aislamiento de archivos
- [ ] Como user1, subir un archivo a un proyecto
- [ ] Logout, login como user2
- [ ] Intentar acceder a `/archivos/{id-del-archivo-de-user1}/descargar`
- [ ] **Esperado:** Error 403

---

## 10. Auditoría

### 10.1 Ver registro de actividades
- [ ] Ir a `/auditoria`
- [ ] **Esperado:** 3 stat cards arriba (totales de create/update/delete)
- [ ] Lista paginada con todas las acciones del usuario
- [ ] **Verificar:** Cada item muestra: usuario, acción, tipo de objeto, descripción, fecha

---

## 11. Navegación y Sidebar

### 11.1 Items del sidebar
- [ ] **Esperado:** 5 items: Dashboard, Clientes, Proyectos, Actividad, Ajustes
- [ ] El item activo se destaca con fondo oscuro
- [ ] **NO debe aparecer:** botón "New Project" (fue eliminado)

### 11.2 Logout
- [ ] Click en "Logout" (sidebar inferior)
- [ ] **Esperado:** Redirige a `/login`, sesión destruida

---

## Resumen de Resultado

| Módulo | Pasos | ✅ OK | ⚠️ Parcial | ❌ Falla |
|---|---|---|---|---|
| 1. Registro/Login | 3 | _ | _ | _ |
| 2. Clientes | 5 | _ | _ | _ |
| 3. Proyectos | 5 | _ | _ | _ |
| 4. Tareas | 5 | _ | _ | _ |
| 5. Archivos | 5 | _ | _ | _ |
| 6. Búsqueda | 3 | _ | _ | _ |
| 7. Notificaciones | 4 | _ | _ | _ |
| 8. Ajustes | 4 | _ | _ | _ |
| 9. Seguridad | 2 | _ | _ | _ |
| 10. Auditoría | 1 | _ | _ | _ |
| 11. Navegación | 2 | _ | _ | _ |
| **TOTAL** | **39** | _ | _ | _ |

### Criterio de aprobación

- ✅ **APROBADO:** Todos los pasos ✅ OK, máximo 2 ⚠️ sin ❌
- ⚠️ **APROBADO CON NOTAS:** Hasta 5 ⚠️ sin ❌
- ❌ **RECHAZADO:** Cualquier ❌ o más de 5 ⚠️

### Bugs encontrados

_(Anota aquí cualquier bug encontrado durante el test, con su número de paso y descripción)_

- Bug #1: [Paso X.X] Descripción
- Bug #2: [Paso X.X] Descripción

### Notas adicionales

_(Cualquier observación relevante)_

---

**Fecha del test:** _______________
**Tester:** _______________
**Versión:** DevVCV @ commit `32894b6`
