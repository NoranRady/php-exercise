# php-exercise
To run the project:
<pre>
docker-compose up --build -d<br>
</pre>

To run unit-tests:
<pre>
docker-compose exec app php artisan test --coverage-html=build/coverage <br>
</pre>

DataBase View :<br>
<pre>
Development:db<br>
http://localhost:8080/adminer<br>
system:MySQL<br>
server :db<br>
username:convertedIn<br>
passsword P@ssword<br>
</pre>
Testing database View:db<br>
<pre>
http://localhost:8080/adminer<br>
system:MySQL<br>
server :db_testing<br>
username:convertedIn<br>
passsword P@ssword<br>
</pre>
Access the Dashboard : 
<pre>
http://localhost/applications/create
</pre>
