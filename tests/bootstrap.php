<?php

exec(sprintf(
    'php "%s/bin/console" doctrine:schema:drop --env=test --force --no-interaction',
    dirname(__DIR__)
));
exec(sprintf(
    'php "%s/bin/console" doctrine:schema:update --env=test --force --no-interaction',
    dirname(__DIR__)
));
exec(sprintf(
    'php "%s/bin/console" doctrine:fixtures:load --env=test --no-interaction',
    dirname(__DIR__)
));
exec(sprintf(
    'php "%s/bin/console" cache:clear --env=test',
    dirname(__DIR__)
));

require sprintf('%s/vendor/autoload.php', dirname(__DIR__));

if (file_exists(sprintf('%s/config/bootstrap.php', dirname(__DIR__)))) {
    require sprintf('%s/config/bootstrap.php', dirname(__DIR__));
}
