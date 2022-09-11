Prueba técnica Nodriza tech  

Para montar el entorno en local lanzar docker-compose up -d  


sincronizar bbdd   
php bin/console doctrine:database:create  
php bin/console make:migration  
!!Comprobar solo este comando :php bin/console doctrine:migrations:migrate
