./vendor/bin/openapi \
  --bootstrap vendor/autoload.php \
  --output src/docs/newdichsrc.json \
  --exclude vendor \
  --exclude apis \
  --exclude phpmyadmin \
  --exclude public \
  --exclude route \
  --exclude Schema \
  --exclude Auth \
  --exclude Cache \
  --exclude Dto \
  --exclude Mail \
  --exclude Middleware \
  --exclude composer.json \
  --exclude composer.lock \
  --exclude index.php \
  --exclude boostrap.php \
  --exclude .htaccess.php \
  --exclude README.txt \
  src/


./vendor/bin/openapi \
  --bootstrap vendor/autoload.php \
  --output app/docs/newdichsrc.json \
  --exclude vendor \
  --exclude apis \
  --exclude phpmyadmin \
  --exclude public \
  --exclude route \
  --exclude Schema \
  --exclude Auth \
  --exclude Cache \
  --exclude Dto \
  --exclude Mail \
  --exclude Middleware \
  --exclude composer.json \
  --exclude composer.lock \
  --exclude index.php \
  --exclude boostrap.php \
  --exclude .htaccess.php \
  --exclude README.txt \
  app/