## INFO REGARDING COURSEWORK

This coursework was built using Composer, on a Windows 11 machine.

It does not use Sail.

Faker is used to generate and seed data.

Basic controllers were setup to return JSON objects of the data, which is how the data was viewed in a web browser.

The database is SQLite located at /database/database.sqlite relative to the project directory.

## COMMANDS & REQUESTS USED IN VIDEO IN ORDER

php artisan migrate:fresh

php artisan migrate:fresh --seed

GET -- localhost:8000/api/posts

POST -- localhost:8000/api/posts/1/like

GET -- localhost:8000/api/posts

GET -- localhost:8000/api/posts/1 x2

GET -- localhost:8000/api/posts
