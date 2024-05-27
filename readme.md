<h3>1. Titulo</h3>
Desarrollo de una aplicación web para la gestión y consulta del archivo histórico de calificaciones de la Facultad de Ciencias Artes y Tecnologías.

<h3>2. Justificación:</h3>

<li>El proyecto busca solucionar la problemática de la falta de acceso a la información histórica de calificaciones de la Facultad.</li>
<li>La aplicación web facilitará la búsqueda y consulta de las planillas de calificaciones por parte del personal de la secretaría.</li>
<li>El proyecto permitirá la preservación del archivo histórico de la Facultad.</li>

<h3>3. Objetivos:</h3>

<ol>
<li>Desarrollar una aplicación web que facilite la gestión y consulta del archivo histórico de calificaciones de la Facultad de Ciencias Artes y Tecnologías.</li>
<li>Digitalizar las planillas de calificaciones en formato papel.</li>
<li>Desarrollar una interfaz web intuitiva para la búsqueda y consulta de las planillas.</li>
<li>Implementar un sistema de seguridad para el acceso a la aplicación.</li>
</ol>

<h3>4. Documentación</h3>
<h4>Rutas</h4>
<ol>
<li>BASE_URL se define en la archivo /config/config.php</li>
<li>Las rutas de los cruds son BASE_URL/nombre_crud/index.php</li>
<li>Las rutas de las API son BASE_URL/nombre_crud/api.php</li>
</ol>

<h4>APIs</h4>
<ul><li><strong>GET Requests</strong>:<ul><li><code>action=list</code>: Devuelve todos los registros en formato JSON.</li><li><code>action=get&amp;id=?</code>: Devuelve un registro específico en formato JSON.</li><li><code>action=del&amp;id=?</code>: Elimina un registro específico y devuelve un mensaje en formato JSON.</li></ul></li><li><strong>POST Requests</strong>:<ul><li><code>action=new</code>: Agrega un nuevo registro con los datos del formulario y devuelve el registro agregado en formato JSON.</li><li><code>action=update</code>: Actualiza un registro específico con los datos del formulario y devuelve el registro actualizado en formato JSON.</li><li><code>action=change_password</code>: Cambia la contraseña de un usuario.</li><li><code>action=login</code>: Inicia sesión con las credenciales del usuario.</li></ul></li></ul>
<h4>API Usuarios</h4>
<ul><li><strong>GET Requests</strong>:<ul><li><code>action=list</code>: Devuelve todos los registros en formato JSON.</li><li><code>action=get&amp;id=?</code>: Devuelve un registro específico en formato JSON.</li><li><code>action=del&amp;id=?</code>: Elimina un registro específico y devuelve un mensaje en formato JSON.</li></ul></li><li><strong>POST Requests</strong>:<ul><li><code>action=new</code>: Agrega un nuevo registro con los datos del formulario y devuelve el registro agregado en formato JSON.</li><li><code>action=update</code>: Actualiza un registro específico con los datos del formulario y devuelve el registro actualizado en formato JSON.</li><li><code>action=change_password</code>: Cambia la contraseña de un usuario.</li><li><code>action=login</code>: Inicia sesión con las credenciales del usuario.</li></ul></li></ul>
<h4>Estructura de Directorios y Archivos</h4>
<pre>
|   readme.md
|
+---classes
|       Actas.php
|       Carreras.php
|       Database.php
|       Facultades.php
|       Materias.php
|       Oportunidades.php
|       Profesores.php
|       Roles.php
|       Usuarios.php
|
+---config
|       config.php
|       database.php
|
+---public
|   |   admin_cambiar_contrasena.php
|   |   cambiar_contrasena.php
|   |   index.php
|   |   login.php
|   |   logout.php
|   |   unauthorized.php
|   |
|   +---actas
|   |   |   api.php
|   |   |   crear.php
|   |   |   editar.php
|   |   |   eliminar.php
|   |   |   index.php
|   |   |
|   |   \---uploads
|   |           sw532_acta.pdf
|   |           sw532_planilla.pdf
|   |           sw533_acta.pdf
|   |           sw533_planilla.pdf
|   |           sw53p_acta.pdf
|   |           sw53p_planilla.pdf
|   |           sw53x_acta.pdf
|   |           sw53x_planilla.pdf
|   |
|   +---carreras
|   |       api.php
|   |       crear.php
|   |       editar.php
|   |       eliminar.php
|   |       index.php
|   |
|   +---css
|   |       styles.css
|   |
|   +---facultades
|   |       api.php
|   |       crear.php
|   |       editar.php
|   |       eliminar.php
|   |       index.php
|   |
|   +---includes
|   |       footer.php
|   |       header.php
|   |       navbar.php
|   |
|   +---js
|   +---materias
|   |       api.php
|   |       crear.php
|   |       editar.php
|   |       eliminar.php
|   |       index.php
|   |
|   +---oportunidades
|   |       api.php
|   |       crear.php
|   |       editar.php
|   |       eliminar.php
|   |       index.php
|   |
|   +---profesores
|   |       api.php
|   |       crear.php
|   |       editar.php
|   |       eliminar.php
|   |       index.php
|   |
|   +---roles
|   |       api.php
|   |       crear.php
|   |       editar.php
|   |       eliminar.php
|   |       index.php
|   |
|   +---uploads
|   \---usuarios
|           api.php
|           crear.php
|           editar.php
|           eliminar.php
|           index.php
|
+---sql
|       dw2_actas.sql
|
\---templates
</pre>

