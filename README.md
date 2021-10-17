# restful-todo


#Installation
```
run composer install
run cp .env.example .env
update database configuration in .env file
```

###Routes
```
POST    /api/login          - To authenticate
GET     /api/todos          - Get All Todos
GET     /api/todos/{id}     - Get Todo with id e.g. 1
PATCH   /api/todos/{id}     - Update Todo data
POST    /api/todos          - To create todo
DELETE  /api/todos/{id}     - Delete Todo with id e.g 1
GET     /api/logout         - Logout current authenticated user
```
