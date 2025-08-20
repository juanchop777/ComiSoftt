# Sistema de Gestión de Actas - SENA

Este sistema permite gestionar las actas de novedades académicas y disciplinarias reportadas al Comité de Evaluación y Seguimiento del Centro de Formación Agroindustrial del SENA.

## 🚨 PROBLEMA ACTUAL - SOLUCIÓN INMEDIATA

Si ves "Información no disponible" en la tabla de actas, es porque las migraciones no se ejecutaron correctamente.

### **SOLUCIÓN RÁPIDA:**

1. **Ejecuta las migraciones:**
   ```bash
   php artisan migrate:fresh
   ```
   
2. **Si hay errores, ejecuta paso a paso:**
   ```bash
   php artisan migrate:rollback
   php artisan migrate
   ```

3. **Verifica que las tablas se crearon:**
   ```bash
   php artisan tinker
   >>> Schema::hasTable('ReportingPerson')
   >>> Schema::hasTable('Minutes')
   ```

## Características

- **Formulario por pasos**: Interfaz intuitiva dividida en 3 pasos para facilitar el llenado
- **Bloques dinámicos**: Permite agregar múltiples aprendices por acta
- **Validación completa**: Validación de campos requeridos y formatos
- **Almacenamiento en base de datos**: Persistencia de toda la información
- **Vista consolidada**: Lista de todas las actas registradas con detalles
- **Modal de detalles**: Visualización completa de cada acta

## Estructura de la Base de Datos

### Tabla: ReportingPerson
- `reporting_person_id` (Primary Key)
- `full_name` - Nombre completo de quien reporta
- `email` - Correo electrónico
- `phone` - Teléfono (opcional)
- `created_at`, `updated_at` - Timestamps

### Tabla: Minutes
- `minutes_id` (Primary Key)
- `act_number` - Número de acta
- `minutes_date` - Fecha del acta
- `trainee_name` - Nombre del aprendiz
- `trainee_email` - Email del aprendiz (opcional)
- `id_document` - Documento de identidad
- `program_name` - Programa de formación
- `batch_number` - Número de ficha
- `has_contract` - Si tiene contrato (0/1)
- `company_name` - Nombre de la empresa (opcional)
- `company_address` - Dirección de la empresa (opcional)
- `hr_manager_name` - Responsable de talento humano (opcional)
- `company_contact` - Contacto de la empresa (opcional)
- `incident_type` - Tipo de novedad (Academic/Disciplinary/Dropout)
- `incident_description` - Descripción de la novedad
- `reception_date` - Fecha de recepción
- `reporting_person_id` - Foreign key a ReportingPerson
- `created_at`, `updated_at` - Timestamps

## Instalación y Configuración

1. **Clonar el repositorio**
2. **Instalar dependencias**: `composer install`
3. **Configurar base de datos** en `.env`
4. **Ejecutar migraciones**: `php artisan migrate`
5. **Configurar autenticación** (Jetstream ya está configurado)

## Uso del Sistema

### Crear Nueva Acta

1. Ir a `/minutes` (ruta principal)
2. El formulario está dividido en 3 pasos:
   - **Paso 1**: Información de la persona que reporta
   - **Paso 2**: Detalles del acta (número y fecha)
   - **Paso 3**: Información de aprendices y novedades

3. Para agregar más aprendices, usar el botón "+ Agregar"
4. Completar todos los campos requeridos
5. Hacer clic en "Guardar"

### Ver Actas Registradas

- En la misma página `/minutes` se muestra la lista de todas las actas
- Hacer clic en "Ver" para abrir un modal con todos los detalles
- Las actas se agrupan por número de acta

## Rutas Disponibles

- `GET /minutes` - Vista principal con formulario y lista de actas
- `GET /minutes/create` - Solo formulario de creación
- `POST /minutes` - Guardar nueva acta

## Tecnologías Utilizadas

- **Backend**: Laravel 10
- **Frontend**: Blade templates con Bootstrap 4
- **Base de Datos**: MySQL/PostgreSQL
- **Autenticación**: Laravel Jetstream
- **Validación**: Validación del lado del servidor de Laravel
- **JavaScript**: Vanilla JS para funcionalidad del formulario

## Funcionalidades del Formulario

- **Navegación por pasos**: Botones "Anterior" y "Siguiente"
- **Campos dinámicos**: Los campos de empresa se muestran/ocultan según si tiene contrato
- **Validación en tiempo real**: Los campos requeridos se marcan automáticamente
- **Copia inteligente**: Al agregar nuevos bloques, se copian algunos valores del anterior
- **SweetAlert2**: Notificaciones elegantes de éxito/error

## Notas Importantes

- Cada acta puede tener múltiples aprendices
- La información de empresa solo se muestra si el aprendiz tiene contrato
- Todos los campos marcados con * son obligatorios
- El sistema agrupa automáticamente las actas por número
- Se mantiene un historial completo de todas las actas registradas
