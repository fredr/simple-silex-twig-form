Installation
====================

Clone the repository
    git clone https://github.com/fredr/simple-silex-twig-form.git

Change working dir to the projects dir
    cd simple-silex-twig-form

Install Composer
    curl -s http://getcomposer.org/installer | php

Install silex, twig and doctrine via composer
    php composer.phar install

Run the SQL in /database/database.sql in MySQL

Update the database connection info in /bootstrap.php