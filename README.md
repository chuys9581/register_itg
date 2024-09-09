# Feed Instagram Register

**Plugin Name:** Feed Instagram Register  
**Version:** 1.0  
**Author:** Jesús Jiménez  
**Description:** Plugin personalizado para registrar usuarios en WordPress y enviar los datos del registro a Airtable. Inspirado en el registro de Instagram.  

## Descripción

El plugin **Feed Instagram Register** es un formulario de registro sencillo que permite a los usuarios registrarse en WordPress y, simultáneamente, enviar la información del usuario a una tabla en Airtable. Está diseñado para parecerse al proceso de registro de Instagram.

El plugin maneja tanto el registro en WordPress como la integración con Airtable, verificando si un usuario ya existe antes de realizar el registro y gestionando los datos de manera segura. Este formulario admite registro mediante email y número de teléfono (opcional).

## Características

- Registro de nuevos usuarios en WordPress.
- Envío de datos del usuario registrado a Airtable mediante la API de Airtable.
- Verificación de disponibilidad del nombre de usuario y el email antes de completar el registro.
- Guarda el número de teléfono como metadata del perfil de WordPress.
- Estilo simple inspirado en Instagram.
- Mensajes de error en caso de fallas o datos incompletos.
- Redirección a la página de inicio de sesión después de un registro exitoso.

## Instalación

1. Sube los archivos del plugin a la carpeta `/wp-content/plugins/feed-instagram-register` o instala el plugin directamente desde el panel de WordPress.
2. Activa el plugin desde el menú "Plugins" en WordPress.
3. Crea una página o un post y agrega el shortcode `[feed_instagram_register]` para mostrar el formulario de registro.
4. Asegúrate de tener una tabla en Airtable llamada `Usuarios` con las columnas correspondientes: `Nombre`, `Password`, `Telefono`, `email`.

## Uso

Una vez activado, agrega el siguiente shortcode en la página donde desees mostrar el formulario de registro:


Esto generará un formulario de registro similar al de Instagram, donde los usuarios podrán ingresar su email, nombre de usuario, contraseña, y opcionalmente, su número de teléfono. Al completar el registro, los datos del usuario se guardarán tanto en WordPress como en Airtable.

### Campos del formulario

- **Email:** Campo obligatorio para el registro.
- **Número de Teléfono:** Campo opcional.
- **Nombre de Usuario:** Campo obligatorio.
- **Contraseña:** Campo obligatorio.

## Funcionalidades

### 1. Registro de Usuario en WordPress

El plugin verifica si el nombre de usuario o el email ya están registrados. Si no, crea una cuenta nueva en WordPress con los datos proporcionados por el usuario. Si el número de teléfono es proporcionado, este se guarda en el perfil del usuario en WordPress como metadata.

### 2. Envío de Datos a Airtable

El plugin envía los datos del usuario registrado a Airtable mediante una solicitud `POST` a la API. Los campos enviados incluyen el nombre de usuario, contraseña, número de teléfono y email. Si hay algún error en la integración con Airtable, el usuario recibirá un mensaje de error.

### 3. Redirección a la Página de Inicio de Sesión

Después de un registro exitoso, el usuario es redirigido a la página de inicio de sesión para que pueda iniciar sesión en su nueva cuenta.

## Integración con Airtable

- **Endpoint de Airtable:** `https://api.airtable.com/v0/appzmB3zBmwWkhnkn/Usuarios`
- **Campos enviados a Airtable:**
  - `Nombre`: Nombre de usuario ingresado en el formulario.
  - `Password`: Contraseña ingresada por el usuario.
  - `Telefono`: Número de teléfono, si se proporciona.
  - `email`: Email del usuario.
  
**Nota:** El plugin utiliza la API Key de Airtable que debe estar configurada correctamente en el código del plugin.

## Requisitos

- Versión de WordPress: 5.0 o superior.
- Cuenta en Airtable con una tabla de usuarios.

## Personalización

Puedes modificar el estilo del formulario editando el archivo `style_register.css` y personalizar el comportamiento del script en el archivo `script_register.js`. Además, puedes ajustar la API Key de Airtable directamente en el código del plugin.

## Errores Comunes

- **Usuario o email ya registrado:** Si el nombre de usuario o el email ya existen en WordPress, el registro no se completará.
- **Error de conexión con Airtable:** Si no se puede conectar con Airtable o la API Key es incorrecta, el registro en Airtable fallará.

## Contribuciones

Si deseas contribuir al desarrollo o mejoras del plugin, por favor, abre un issue o envía un pull request en el repositorio.

## Licencia

Este plugin está licenciado bajo la [Licencia GPL v2 o posterior](https://www.gnu.org/licenses/gpl-2.0.html).
