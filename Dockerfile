FROM php:apache

# Instalar extensiones necesarias
RUN docker-php-ext-install mysqli

# # Habilitar mod_rewrite
 RUN a2enmod rewrite

# # Copiar el contenido del proyecto al contenedor
# COPY . /var/www/html/

# # Configurar permisos adecuados
# RUN chown -R www-data:www-data /var/www/html/