# Pasteboard


## To run locally

1. Create a Private/env.php file to store the database credentials. For eg

```php
<?php

define("DB_SERVER", "your_server");
define("DB_USER", "your_username");
define("DB_PASS", "your_password");
define("DB_NAME", "your_database_name");
```

2. Install the depencencies using `composer install` after going to the project path in terminal.

3. Open the project folder in localhost.

> For eg, if the project is in root directory of the apache server, then just open `http://localhost/pasteboard`.

---

> To run locally versus on container with project path at /var/www/html/, change the following files
    *  Private/initialize.php
    *  Localhost in Private/env.php

    yet to resolve and simplfy this process.

