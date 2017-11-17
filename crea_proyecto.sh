#!/bin/sh

if [ $# -eq 1 ]
then
    if [ -d $1 ]
    then
        echo "El directorio $1 existe"
        exit 1
    else
        mkdir $1
        if [ $? -eq 0 ]
        then
            echo "Se ha creado el directorio $1"
        else
            echo "Error al crear el directorio"
            exit 1
        fi
    fi
else
    echo "Solo se permite un parámetro"
    exit 1
fi

if [ -f /etc/hosts ]
then
    sudo sh -c "echo '127.0.0.1	$1.local' >> /etc/hosts"
    echo "Añadida la línea '127.0.0.1 $1.local' al archivo /etc/hosts"
else
    echo "El archivo /etc/hosts no existe"
    rm -rf $1
    exit 1
fi
if [ -d /etc/apache2/sites-available ]
then
    sudo rm -rf $1.conf
    sudo touch /etc/apache2/sites-available/$1.conf
    sudo sh -c "echo '<VirtualHost *:80>' >> /etc/apache2/sites-available/$1.conf"
    sudo sh -c "echo '	ServerName $1.local' >> /etc/apache2/sites-available/$1.conf"
    sudo sh -c "echo '	ServerAdmin webmaster@localhost' >> /etc/apache2/sites-available/$1.conf"
    sudo sh -c "echo '	DocumentRoot /var/www/web/$1' >> /etc/apache2/sites-available/$1.conf"
    sudo sh -c "echo '	ErrorLog ${APACHE_LOG_DIR}/error.log' >> /etc/apache2/sites-available/$1.conf"
    sudo sh -c "echo '	CustomLog ${APACHE_LOG_DIR}/access.log combined' >> /etc/apache2/sites-available/$1.conf"
    sudo sh -c "echo '</VirtualHost>' >> /etc/apache2/sites-available/$1.conf"
    sudo a2ensite $1.conf > /dev/null
    service apache2 reload
    echo "Archivo $1.conf creado y activado"    
fi

# Crea la base de datos
sudo -u postgres psql -c "CREATE USER $1 WITH PASSWORD '$1'"
sudo -u postgres createdb $1
mkdir ~/web/$1/db
echo "#!/bin/sh\nsudo -u postgres psql -h localhost -U $1 -d $1 < $1.sql" > ~/web/$1/db/$1.sh
chmod u+x ~/web/$1/db/$1.sh

exit 0
