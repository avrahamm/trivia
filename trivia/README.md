## About Trivia

- Trivia game is developped in Laravel framework.
- You can read the definition at the bottom.
- Briefly, multiple users connect to solve trivia questions.
- When solved, new question is generated and suggested to players.
- Question are generated from random api, stored to DB and to cache for faster reads.
- Users are created with login user name, and are deleted when loggged out.

## Steps to set up:
- git clone https://github.com/avrahamm/trivia.git
- create DB, for example call it trivia.

- I ran it on XAMP on windows, 
- you should either prepare virtual host for convenience,lets call it trivia,
- or run from as http://localhost/JobExams/golgi/trivia/public/

# set .env file with DB credentials, for example

- DB_CONNECTION=mysql
- DB_HOST=127.0.0.1
- DB_PORT=3306
- DB_DATABASE=trivia
- DB_USERNAME=avraham
- DB_PASSWORD=123456

# run migrations to build Db tables: 
- php artisan migrate

# to assure config and cache are ok, run
- php artisan config:clear
- php artisan config:cache

-You should be good to go, open http://trivia/trivia/login

## ======================================================================

## Trivia Definition 
Write a simple trivia competition game
--------------------------------------
Environment:
1 - PHP
4 - http app server (Apache)

The game goes like this:
User is connected via login from.
In response the user get a question to answer.
The question is similar to all  connected users and newly users.
Each user can send his answer through the game form.
If the answer is correct than the server pick another question to display to all users.

client side (HTML/javascript)
-----------------------------
forms:

1 - login form with user name field
2 - game form with fields: 
     the question - title
     user answer - input field
     send button - button
     message field (“answer is wrong”) - title clear upon user typing


server side
-----------
PHP api
GET /trivia/login - display the login form with user name field
POST /trivia/login - save the user name on the server side
GET /trivia/start - generate a question and save the question and answer on the server side 
GET /trivia/play - display the game form
POST /trivia/play - check the user answer and return write/wrong
GET /trivia/players - return list of login players

To get a random question and answer call this endpoint: http://jservice.io/api/random
The answer is match when user answer and answer recivied with the question contains similar “terms” in any order.

To analyse the answer:
1 - Remove any character that is not letter.
1 - Ignore words “for”, “the”, “a”, “an”, “and”,”or”,”nor”,”but”,”so”,”is”,”are”,”of”
2 - Remove the following suffixes from the words: “s”, “es”, “ed”, “ing”
3 - Ignore caps

for example “The building is tall and wide, and made of 1000 stones” is similar to “Stone made - Build wide/tall.”  





