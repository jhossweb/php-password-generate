# Password Generated

<p>
    Diariamente solemos entrar en portales y aplicaciones que requieren datos de registros, entre esos, la contraseña.
</p>

<p>
    Sabemos que una contraseña segura suele contener: letras, números y simbolos. Además de un longitud mínima de 8 caracteres.
</p>

<p>
    Recordar esas contraseña suele ser algo dificil y esa es la razón de este proyecto. El desarrollo de este proyecto consiste en un Gestor de contraseñas para poder almacenar y asociar nuestras constraseñas con las plataformas.
</p>


## Caracteristicas del Proyecto

<ul>
    <li>
        Lenguaje: PHP 8.3
    </li>
    <li>
        Framework: Slim 4
    </li>
    <li>
        Autenticación: firebase/php-jwt
    </li>
    <li>
        Docker
    </li>
</ul>

## Obtener Proyecto
<p>
    Para Obtener el proyecto, solo debes clonar el repositorio.
</p>

## Arrancando el proyecto

<p>
    Levantar servicios:
</p>

```
docker compose up
```

<p>
    Ver contenedores
</p>

```
docker ps
```

<p>
    Instalando Librerías: Para instalar slim, debes ingresar al contenedor server
</p>

```
docker exec -it server bash
```
<p>
    Una vez allí, usa el siguiente comando:
</p>

```
composer install
```

<p>
    Por último, ingresa a  <strong> http://localhost:80 </strong>
</p>
