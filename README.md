# Rubén Escudero - Prueba técnica Nodriza tech

### Montar el entorno
El proyecto es un entorno dockerizado con PHP, NGINX y MySQL, se podrá acceder desde `http://localhost:8080/`. 
Para montarlo se ejecuta el comando `docker-compose up -d`, una vez termine se inician los contenedores y se creará la carpeta mysql dondé irá almacenada la bbdd. 

Una vez levantado el entorno será necesario instalar las dependencias, para instalarlas hay que entrar al contenedor  
de PHP con el comando `docker exec -it php-nodriza-container bash` y una vez estemos dentro del contenedor ejecutamos el comando `composer install`

El último paso será crear y migrar la bbdd, desde el mismo contenedor de PHP para crear la bbdd se ejecuta el comando 
`php bin/console doctrine:database:create`. En caso de que haya algún problema en la creación de la tabla planet se puede lanzar la migración con el comando `php bin/console doctrine:migrations:migrate`.  

## Ejercicio A

### Parte 1
Endpoint: - [get] /planets/{id}  

El primer endpoint es accesible mediante la URL http://localhost:8080/planets/1 con el campo id obligatorio.  
En caso de que la petición sea correcta devolverá el planeta en formato json y en caso de que el id no exista se indicará mediante el mensaje 'Planet not found, try other id.' u otro mensaje de error controlado.   

Para este ejercicio se ha utilizado el controlador PlanetController en el que se define el endpoint y el servicio PlanetService para obtener la información de la API externa y darle el formato correcto.  

### Parte 2
Endpoint: - [post] /planet

El segundo endpoint es accesible mediante una petición POST a la URL http://localhost:8080/planet y el json con los datos del planeta en el body.  

En este ejercicio se ha utilizado la clase PlanetController para crear el endpoint, la entidad Planet mapeada con el ORM Doctrine y la clase PlanetRepository.

Para la validación de los campos id y name se ha utilizado Validator Component en los atributos de la entidad.  
La validación para comprobar que los parámetros no tienen otra información más que la indicada se ha utilizado   
la función dynamicSetter en PlanetRepository, de manera que si un campo no se puede setear debido a que no existe lo devuelve como mensaje de error. 

### Test

Se han creado dos test en el directorio tests/Controller/PlanetControllerTest para que ejecutando el fichero phpunit.xml.dist con la opción Debug se pueda hacer una validación rápida.  

## Ejercicio B
Para ambos casos propondría hacer una segmentación de las consultas mediante OFFSET y LIMIT.

En el primer punto, en caso de que los resultados se muestren al usuario mediante algún tipo de tabla o listado, plantearía mostrar una paginación númerica de la consulta.  
En caso de que el listado se tuviese que mostrar entero propondría que en la parte de front se desarrollase un scroll infinito que segmentara la consulta y realizase las peticiones al back conforme sean necesarias.  

Para el segundo caso la solución es similar, programando en el batch las correspondientes segmentaciones de la consulta de tal forma que la tarea cron al lanzarse ejecute bloques de consultas.  
Otra opción sería dividir la tarea cron en tareas crons más específicas.

Para implementarlo previamente se harían las pruebas necesarías de la canitdad de resultados que se pueden solicitar y el tiempo que tardan en ser consultados.

