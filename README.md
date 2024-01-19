# Examen técnico Desarrollador Backend
Se comparte un conjunto de requerimientos para desarrollar un conjunto de APIs 
REST FULL para poder validar los conocimientos técnicos y habilidades de resolución 
de problemas.

- API de Inicio se sesión
- API de Creación de usuarios
- API de Consulta de usuarios
- API de Actualización de usuarios
- API de Eliminación de usuarios
- API para la descarga del listado de usuarios


- http://localhost:8080/Usuarios

Para crear un nuevo usuario selecciona el metodo **POST** con la url descrita y el body seleccionamos **form-data** e ingresamos los datos del usuario.

> **nombre** -> coloca el nombre del usuario.

> **apellidos** -> Coloca los apellidos de usuario.

> **celular** -> Coloca el numero celular del usuario.

> **email** -> Coloca el correo electronico del usuario.

> **fotografia** -> Selecciona el archivo de la fotografia cel usuario.

> **contrasenia** -> Coloca la contraseña del usuario.

Esto devolvera un objeto JSON con la informacion ingresada

`
{
    "nombre": "Esli",
    "apellidos": "Castillo",
    "celular": "5540694518",
    "email": "santiago@gmail.com",
    "fotografia": "userImages/Esli_5540694518.png",
    "contrasenia": "b221d9dbb083a7f33428d7c2a3c3198ae925614d70210e28716ccaa7cd4ddb79"
}
`

- http://localhost:8080/Usuarios

Para listar todos los usuarios selecciona el metodo **GET** con la url descrita

Esto devolvera un objeto JSON con todos los usuarios que se encuentran en la base de datos

`
[
     {
        "id_usuario": "1",
        "nombre": "Jesus",
        "apellidos": "Castillo",
        "celular": "5540694516",
        "email": "carlos@gmail.com",
        "fotografia": "userImages/Carlos_5540694516.png",
        "contrasenia": "b221d9dbb083a7f33428d7c2a3c3198ae925614d70210e28716ccaa7cd4ddb79",
        "tipo_usuario": "administrador",
        "create_at": "2024-01-18 19:07:14",
        "modifi_at": "2024-01-19 05:43:41",
        "ultimo_login": "2024-01-19 03:49:51",
        "estatus": "1"
    },
    {
        "id_usuario": "3",
        "nombre": "Carlos",
        "apellidos": "Castillo",
        "celular": "5540694517",
        "email": "carlos@gmail.com",
        "fotografia": "userImages/Carlos_5540694516.jpg",
        "contrasenia": "b221d9dbb083a7f33428d7c2a3c3198ae925614d70210e28716ccaa7cd4ddb79",
        "tipo_usuario": "basico",
        "create_at": "2024-01-18 19:14:36",
        "modifi_at": "2024-01-19 04:38:07",
        "ultimo_login": null,
        "estatus": "0"
    }
]
`

- http://localhost:8080/Usuarios/{id}

Para listar el detalle de un spñp usuario selecciona el metodo **GET** con la url descrita y colocamos el id del usuario a mostrar

Esto devolvera un objeto JSON con el detalle del usuario

`
[
    {
        "id_usuario": "4",
        "nombre": "santiago6",
        "apellidos": "Castillo",
        "celular": "5540694518",
        "email": "santiago@gmail.com",
        "fotografia": "userImages/santiago_5540694518.png",
        "contrasenia": "b221d9dbb083a7f33428d7c2a3c3198ae925614d70210e28716ccaa7cd4ddb79",
        "tipo_usuario": "basico",
        "create_at": "2024-01-18 23:26:20",
        "modifi_at": "2024-01-19 05:44:22",
        "ultimo_login": null,
        "estatus": "1"
    }
]
`

- http://localhost:8080/Usuarios/{id}

Para eliminar un usuario selecciona el metodo **DELETE** con la url descrita y colocamos el id del usuario a eliminar

Esto devolvera un objeto JSON con el detalle de la accion

`
{
    "status": 200,
    "error": null,
    "messages": {
        "success": "Data Deleted"
    }
}
`

- http://localhost:8080/Usuarios/{id}

Para actualizar un usuario selecciona el metodo **PUT** con la url descrita y el body seleccionamos **form-urlencoded** e ingresamos los valores deseados.

> **nombre** -> coloca el nombre del usuario.

> **apellidos** -> Coloca los apellidos de usuario.

> **celular** -> Coloca el numero celular del usuario.

> **email** -> Coloca el correo electronico del usuario.

> **contrasenia** -> Coloca la contraseña del usuario.

> **tipo_usuario** -> Coloca el tipo de usuario (administrador, basico).

> **estatus** -> Coloca el estatus del usuario (0=eliminado, 1=activo).

Para este caso solo va a actualizar los datos que se introduscan, si no es introducido algun dato este se ignorara y no se actualizara

Esto devolvera un objeto JSON con el detalle de la accion

`
{
    "status": 200,
    "error": null,
    "messages": {
        "success": "Data Updated"
    }
}
`

- http://localhost:8080/Fotografia/{id}

Para actualizar la fotografia de un usuario selecciona el metodo **POST** con la url descrita y el body seleccionamos **form-data** e ingresamos el archivo.

> **fotografia** -> selecciona el archivo nuevo.


Esto devolvera un objeto JSON con el detalle de la accion

`
{
    "status": 200,
    "error": null,
    "messages": {
        "success": "Data Updated"
    }
}
`

- http://localhost:8080/login

Para loguearse y obtener el token de un usuario selecciona el metodo **POST** con la url descrita y el body seleccionamos **form-urlencoded** e ingresamos las credenciales de acceso.

> **celular** -> Colocamos el celular del usuario.

> **contrasenia** -> colocamos la contraseña del usuario.


Esto devolvera un objeto JSON con el token y el tipo de usuario

`
{
    "token": "Gw5+pNzDcCTkwgMFjJOHX6ddeztJ3hQSxbWBoOwgZMIuPNoCfGh+dnncEU4gfPQvcmRs4BjVI9m08FUtPtDangx8CrdWtps6RDWy+c5UQczwEj27jxaBhERN8xquyHprdldAy/u5eHWkLla4XfEgPw==",
    "tipo": "administrador"
}
`

- http://localhost:8080/usuariospdf

Para generar el pdf con la lista de los usuario selecciona el metodo **GET** con la url descrita

Esto devolvera un objeto JSON con el path del archivo generado

`
[
    "status": 200,
    "error": null,
    "messages": {
        "success": "File generate",
        "path": "pdf_files/usuarios_2024_01_19_07_09_50.pdf"
    }
]
`