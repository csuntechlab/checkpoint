FROM csunmetalab/environment:checkpoint

# Retrieve the composer installer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer 
