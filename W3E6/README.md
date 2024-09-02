# W3E6

W3E6 consists of the same exercise we did in week 2 exercise 4.
The application aims to create an electronic diary for a school but this time it is web based.

## Usage

The entry point of this application is the index.php file but even though this is a mostly html file, it still consists
of some php needed for the rendering of
some elements which is why it is strongly recommended that you start a simple server using the command
`php -S 0.0.0.0:80` which would start a server on localhost, port 80. Simply open the link which you get in your
terminal after you execute the command and your
application should start immediately in a web browser of your choice(usually your default one).
Note: There are no dependencies that need to be install in order for the application to work!

### Menus And Options

We have 3 different roles - admin, teacher and user and each has different permission.
Therefore, if you are logged as an admin you will have the following options at your disposal:

1. Create a subject
2. Create a teacher
3. Create a student
4. Remove a subject
5. Remove a teacher
6. Remove a student
7. Log out

If you are logged as a teacher you will be able to do the following things:

1. Grade a student
2. Log out

And lastly if you are logged as a student you will be able to do these things:

1. Check grades for a subject
2. Log out
