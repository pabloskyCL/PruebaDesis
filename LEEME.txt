Configuración para levantar proyecto en local en ubuntu:

requisito tener instalado lo siguiente:

- php 8.4
- postgresql 14.0
- pgadmin4
- extensiones de php
- apache2
- activar modulo modprove:
  - sudo a2enmod rewrite
  - sudo systemctl restart apache2

para levantar el proyecto primero hay que clonarlo en la carpeta compartida con el servidor web que se indica en la configuración de apache:

después hay que crear una configuración para para apache:

/etc/apache2/sites-available/nombre-de-la-configuración.conf

debe quedar parecido a esto cambiando los directorio a los que corresponde y el servername puede debe quedar en desisproducts.local:

```
<VirtualHost *:80>
    ServerAdmin "tu server admin"
    DocumentRoot "tu carpeta raiz del proyecto" en mi caso /home/pablosky-cl/pruebas_tecnicas/desisproducts
    ServerName desisproducts.local

    <Directory "tu carpeta raiz del proyecto">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>

```

- reiniciar apache sudo systemctl restart apache2

agregar el servername a los hosts:

/etc/hosts:

```
127.0.0.1       localhost
::1             localhost
127.0.1.1       pop-os.localdomain      pop-os
127.0.0.1       desisproducts.local
```

- reiniciar apache sudo systemctl restart apache2

agregar el usuario actual al grupo www-data:

sudo usermod -aG www-data tu-usuario

en caso de tener problema de permisos:

sudo chmod -R g+w /home/tu-carpeta-home/tu ruta raiz del proyecto

modificar archivo Database.php con la información correspondiente a su usuario de postgres a utilizar, el usuario por defecto "postgres" o crear uno nuevo.

ingresar a pgadmin4 crear servidor y base de datos product abrir consola desde la base de datos products y abrir archivo SQL/backup.sql y ejecutar.
