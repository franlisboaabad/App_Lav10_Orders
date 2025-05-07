# Documentación del Sistema de Gestión de Órdenes de Servicio

## Estructura del Proyecto

### Vistas
- `resources/views/layouts/app.blade.php`: Layout principal
- `resources/views/partials/_sidebar.blade.php`: Menú lateral
- `resources/views/admin/`: Vistas de administración
  - `service-orders/`: Vistas de órdenes de servicio
    - `index.blade.php`: Listado de órdenes
    - `create.blade.php`: Crear nueva orden
    - `edit.blade.php`: Editar orden existente
    - `show.blade.php`: Ver detalles de orden

### Controladores
- `app/Http/Controllers/Admin/ServiceOrderController.php`: Controlador de órdenes de servicio

### Modelos
- `app/Models/ServiceOrder.php`: Modelo de orden de servicio
- `app/Models/Customer.php`: Modelo de cliente
- `app/Models/DeviceModel.php`: Modelo de dispositivo

## Base de Datos

### Tablas Principales
1. `service_orders`: Almacena las órdenes de servicio
   - Campos principales:
     - `code`: Código único de la orden
     - `customer_id`: ID del cliente
     - `device_model_id`: ID del modelo de dispositivo
     - `status`: Estado de la orden
     - `estimated_cost`: Costo estimado
     - `final_cost`: Costo final
     - `estimated_delivery_date`: Fecha estimada de entrega
     - `delivery_date`: Fecha real de entrega

2. `customers`: Información de clientes
3. `device_models`: Modelos de dispositivos
4. `brands`: Marcas de dispositivos
5. `device_types`: Tipos de dispositivos

## Menú Lateral (Sidebar)

### Estructura del Menú
El menú lateral está organizado en las siguientes secciones:

1. **Navegación**
   - Dashboard (`mdi-view-dashboard`)

2. **Gestión**
   - Usuarios (`mdi-account-multiple`)
   - Empresa (`mdi-domain`)

3. **Dispositivos**
   - Marcas (`mdi-tag-multiple`)
   - Tipos de Dispositivos (`mdi-devices`)
   - Modelos (`mdi-cellphone-link`)

4. **Clientes y Servicios**
   - Clientes (`mdi-account-group`)
   - Órdenes de Servicio (`mdi-tools`)

5. **Inventario**
   - Categorías (`mdi-shape`)
   - Proveedores (`mdi-truck-delivery`)
   - Productos (`mdi-package-variant`)

### Iconos
El sistema utiliza Material Design Icons (MDI) para los iconos del menú. Para que los iconos se muestren correctamente, asegúrese de incluir el siguiente CSS en el layout principal:

```html
<link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css" rel="stylesheet">
```

## Estados de Órdenes de Servicio

Los estados disponibles para las órdenes de servicio son:

1. `PENDING`: Pendiente
2. `IN_DIAGNOSIS`: En diagnóstico
3. `WAITING_APPROVAL`: Esperando aprobación
4. `IN_REPAIR`: En reparación
5. `READY`: Listo para entrega
6. `DELIVERED`: Entregado
7. `CANCELLED`: Cancelado

Cada estado tiene un color asociado que se muestra en la interfaz:
- Pending: Amarillo (warning)
- In Diagnosis: Azul (info)
- Waiting Approval: Azul primario (primary)
- In Repair: Gris (secondary)
- Ready: Verde (success)
- Delivered: Negro (dark)
- Cancelled: Rojo (danger)

## Funcionalidades Principales

### Gestión de Órdenes de Servicio
1. **Crear Orden**
   - Selección de cliente
   - Selección de modelo de dispositivo
   - Registro de número de serie
   - Descripción del problema
   - Costo estimado
   - Fecha estimada de entrega

2. **Editar Orden**
   - Actualización de información
   - Cambio de estado
   - Registro de diagnóstico
   - Registro de solución
   - Actualización de costos

3. **Ver Detalles**
   - Información completa de la orden
   - Historial de cambios
   - Estado actual
   - Costos y fechas

4. **Eliminar Orden**
   - Eliminación lógica (soft delete)
   - Confirmación requerida

### Validaciones
- Campos requeridos:
  - Cliente
  - Modelo de dispositivo
  - Descripción del problema
  - Estado
- Validaciones específicas:
  - Costos: valores numéricos positivos
  - Fechas: formato válido y lógico
  - Número de serie: único por dispositivo

## Datos de Prueba

El sistema incluye seeders para generar datos de prueba:

1. **BrandSeeder**: Marcas populares de dispositivos
2. **DeviceTypeSeeder**: Tipos comunes de dispositivos
3. **DeviceModelSeeder**: Modelos específicos por marca
4. **CustomerSeeder**: Clientes de prueba
5. **ServiceOrderSeeder**: Órdenes de servicio en diferentes estados

Para generar los datos de prueba, ejecute:
```bash
php artisan db:seed
```

## Roles y Permisos

El sistema utiliza el paquete Spatie Permission para la gestión de roles y permisos:

1. **Rol Admin**
   - Acceso completo al sistema
   - Gestión de usuarios
   - Gestión de todas las funcionalidades

2. **Rol Técnico**
   - Gestión de órdenes de servicio
   - Actualización de estados
   - Registro de diagnósticos y soluciones

3. **Rol Vendedor**
   - Creación de órdenes
   - Consulta de órdenes
   - Gestión de clientes

## Mantenimiento

### Actualizaciones
1. Verificar dependencias:
```bash
composer update
```

2. Limpiar caché:
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Respaldo
1. Base de datos:
```bash
php artisan backup:run
```

2. Archivos:
- Realizar respaldo manual de:
  - Archivos de configuración
  - Imágenes y documentos
  - Logs del sistema

## Soporte

Para reportar problemas o solicitar soporte:
1. Crear un issue en el repositorio
2. Contactar al administrador del sistema
3. Revisar la documentación actualizada 