### Building and running your application

When you're ready, start your application by running:

`docker compose up --build -d`.

`compser install`.

`npm install`.

PhpMyAdmin at http://localhost:8081/ -> Import Database from :  Database/db.sql  

If needed you can configure the application through the conf.php (DB - Routes - Api)

Your application will be available at http://localhost:9000/. (see conf.php to figure out all possible routes for API ) - The View side & Security developpment in progress.

A default user was created from DB import :

`Login = admin`.
`Password = admin`.
