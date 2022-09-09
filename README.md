# Pasteboard


## Steps to run locally in docker

1. Install docker-compose.
2. Create a `docker-compose.yml` file in root directory as given in the `docker-compose-example.yml` file.
3. Create a `.env` file in the root directory as given in the `example.env` file.
4. Make sure the database credentials are same for both docker-compose.yml and .env
5. Run `docker-compose up`.
6. Access the site at `localhost:8000`

## Notes

* This env variable `INSTANCE_UNIX_SOCKET` has a default value of `local`(you can name it anything), it has the following logical use.
    * database.php file has condition to check whether the site is running locally(in this case it uses driver invocation method for PDO connection) or in cloud run(in this case it uses unix socket invocation method for PDO connection).
* When running locally using `docker-compose up`, `sql/sql_queries.sql` automatically runs and creates the required table. 
* Dockerfile has few conditional statement which run only when in cloud run environment (or should I say in any environment where a IS_THIS_LOCAL env variable is not supplied as YES to the Dockerfile as ARG)



