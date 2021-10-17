# restful-todo


###Installation
```
PHP Version used: 7.4.24

run composer install
run cp .env.example .env
update database configuration in .env file
run file dump.sql on your database to create tables
```

###Routes
```
POST    /api/login              - To authenticate
GET     /api/todos              - Get all current authenticated user's todo list
GET     /api/todos/{id}         - Get current authenticated user's todo with an id of {id}
PATCH   /api/todos/{id}         - Update current authenticated user's todo with an id of {id}
POST    /api/todos              - Create a todo for current authenticated user
DELETE  /api/todos/{id}         - Delete current authenticted users' todo with an id of {id}
GET     /api/logout             - Logout current authenticated user

GET     /api/users/todos/all    - List all todo list
```

###Commands
```
run php artisan user:create     To create a new user
```

