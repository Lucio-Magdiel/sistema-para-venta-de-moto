# Sistema de Venta de Motos 🏍️

Sistema web completo para la gestión de ventas de motocicletas desarrollado con Laravel 12, Inertia.js y Vue 3.

## 🚀 Características

### Módulos Principales

1. **Gestión de Motos** 🏍️
   - CRUD completo (Crear, Leer, Actualizar, Eliminar)
   - Control de inventario con stock
   - Búsqueda y filtrado
   - Clasificación por estado (nuevo/usado)

2. **Gestión de Clientes** 👥
   - Registro de clientes con datos completos
   - Historial de compras
   - Búsqueda avanzada
   - Perfil detallado del cliente

3. **Gestión de Ventas** 💰
   - Registro de ventas
   - Múltiples métodos de pago (Efectivo, Tarjeta, Transferencia, Financiamiento)
   - Control automático de stock
   - Vinculación con clientes y motos

4. **Dashboard Interactivo** 📊
   - Estadísticas en tiempo real
   - Ventas por mes (últimos 6 meses)
   - Motos más vendidas
   - Análisis por método de pago
   - Ventas recientes

5. **Sistema de Reportes** 📈
   - Reportes de ventas por período
   - Análisis por vendedor
   - Análisis por método de pago
   - Exportación e impresión

6. **Autenticación** 🔐
   - Sistema de login con Laravel Fortify
   - Registro de usuarios
   - Recuperación de contraseña

7. **Sistema de Roles y Permisos** 👮
   - Roles: Administrador y Vendedor
   - Control de acceso basado en roles
   - UI adaptativa según permisos
   - Restricciones a nivel de backend y frontend

## 🛠️ Tecnologías Utilizadas

- **Backend**: Laravel 12.42.0 (PHP 8.4)
- **Frontend**: Vue 3.5 + Inertia.js 2.0
- **Estilos**: Tailwind CSS 4.1
- **Base de Datos**: SQLite
- **Autenticación**: Laravel Fortify
- **Testing**: Pest PHP

## 📦 Instalación

El sistema ya está instalado y configurado. Para iniciarlo:

1. **Iniciar el servidor**:
   ```bash
   php artisan serve
   ```

2. **Acceder al sistema**:
   - URL: http://localhost:8000
   - Email: admin@motos.com
   - Password: password

## 👤 Usuarios de Prueba

El sistema viene con usuarios pre-configurados:

1. **Administrador**
   - Email: admin@motos.com
   - Password: password
   - **Permisos completos:**
     - ✅ Gestionar motos (crear, editar, eliminar, ver)
     - ✅ Gestionar clientes (crear, editar, eliminar, ver)
     - ✅ Gestionar ventas (crear, eliminar, ver)
     - ✅ Acceso a reportes
     - ✅ Todas las acciones del dashboard

2. **Vendedor**
   - Email: test@example.com
   - Password: password
   - **Permisos limitados:**
     - ✅ Ver motos (solo lectura)
     - ✅ Ver clientes (solo lectura)
     - ✅ Crear ventas
     - ✅ Ver ventas realizadas
     - ❌ No puede crear/editar/eliminar motos
     - ❌ No puede crear/editar/eliminar clientes
     - ❌ No puede eliminar ventas
     - ❌ No tiene acceso a reportes

## 📊 Datos de Prueba

El sistema incluye datos de ejemplo:
- 20 motos con diferentes características
- 15 clientes registrados
- 10 ventas realizadas
- Métodos de pago variados

## 🎯 Rutas Principales

- `/dashboard` - Dashboard principal con estadísticas
- `/motos` - Gestión de motos
- `/clientes` - Gestión de clientes
- `/ventas` - Gestión de ventas
- `/reportes` - Sistema de reportes

## 🔧 Comandos Útiles

### Resetear la base de datos con datos de prueba:
```bash
php artisan migrate:fresh --seed
```

### Compilar assets de frontend:
```bash
npm run build
```

### Modo desarrollo (con hot reload):
```bash
npm run dev
```

### Ejecutar tests:
```bash
php artisan test
```

## 📂 Estructura del Proyecto

```
sistema-venta-motos/
├── app/
│   ├── Http/Controllers/
│   │   ├── MotoController.php
│   │   ├── ClienteController.php
│   │   ├── VentaController.php
│   │   ├── DashboardController.php
│   │   └── ReporteController.php
│   └── Models/
│       ├── Moto.php
│       ├── Cliente.php
│       └── Venta.php
├── database/
│   ├── migrations/
│   ├── factories/
│   └── seeders/
├── resources/
│   ├── js/
│   │   ├── components/     # Componentes reutilizables
│   │   ├── layouts/        # Layouts de la aplicación
│   │   └── pages/          # Páginas Vue
│   └── css/
└── routes/
    └── web.php             # Rutas de la aplicación
```

## 🎨 Características de la Interfaz

- **Diseño Responsivo**: Adaptable a dispositivos móviles, tablets y desktop
- **Modo Oscuro**: Soporte completo para tema claro/oscuro
- **Componentes Reutilizables**: Button, Input, Select, Card, Alert, Pagination
- **Navegación Intuitiva**: Sidebar con acceso rápido a todas las secciones
- **Feedback Visual**: Mensajes de éxito/error en todas las operaciones

## 📝 Funcionalidades Detalladas

### CRUD de Motos
- Formularios validados
- Campos: Marca, Modelo, Año, Color, Cilindrada, Precio, Stock, Descripción, Estado
- Vista detallada con información completa
- Búsqueda por marca, modelo o color

### CRUD de Clientes
- Validación de email y documento únicos
- Campos: Nombre, Apellido, Documento, Email, Teléfono, Dirección
- Historial completo de compras
- Vista de perfil con estadísticas

### Registro de Ventas
- Selección de cliente y moto
- Auto-completado de precio según moto seleccionada
- Control automático de stock
- Registro de vendedor automático
- Observaciones opcionales

### Dashboard
- Total de ventas realizadas
- Ingresos totales generados
- Cantidad de clientes
- Stock disponible
- Gráficos de ventas por mes
- Top 5 motos más vendidas
- Distribución por método de pago

### Reportes
- Filtrado por rango de fechas
- Resumen ejecutivo (total ventas, ingresos, promedio)
- Desglose por método de pago
- Desglose por vendedor
- Detalle completo de todas las ventas
- Función de impresión

## 🔒 Seguridad

- Todas las rutas protegidas con middleware de autenticación
- **Control de acceso basado en roles (RBAC)**
  - Middleware `CheckRole` para protección de rutas
  - Validación de permisos en backend
  - UI adaptativa según rol del usuario
  - Menú lateral dinámico según permisos
- Validación de datos en backend y frontend
- Protección CSRF
- Passwords hasheados con Bcrypt
- Sanitización de inputs

### Implementación de Roles

El sistema implementa dos roles principales:

| Módulo | Admin | Vendedor |
|--------|-------|----------|
| **Motos** | CRUD completo | Solo lectura |
| **Clientes** | CRUD completo | Solo lectura |
| **Ventas** | Crear y eliminar | Solo crear |
| **Reportes** | Acceso completo | Sin acceso |
| **Dashboard** | Todas las acciones | Acciones limitadas |

## 🚀 Próximas Mejoras Sugeridas

1. Carga de imágenes de motos
2. Exportación de reportes a PDF/Excel
3. Notificaciones por email
4. Roles adicionales (supervisor, gerente)
5. Gráficos interactivos (Chart.js)
6. Historial de cambios en stock
7. Sistema de descuentos y promociones
8. Gestión de proveedores
9. Log de auditoría de acciones por usuario
10. Tablero personalizado por rol

## 📞 Soporte

Para cualquier consulta o problema:
- Revisa la documentación de Laravel: https://laravel.com/docs
- Documentación de Inertia.js: https://inertiajs.com/
- Documentación de Vue 3: https://vuejs.org/

## 📄 Licencia

Este proyecto es de código abierto y está disponible bajo la licencia MIT.

---

Desarrollado con ❤️ usando Laravel + Inertia.js + Vue 3
