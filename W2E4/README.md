# W2E4
W2E4 consists of another command line interface(CLI) applications.
The application aims to create an electronic diary for a school.

## Usage
The entry point of this application is the index.php file so in order the start the application you need to go to the directory which contains this file and run the command `php index.php`
Once you do that, you will be prompted to log in using your username and password. After you enter the application will give you different options depending on the role of your account, the possible roles you may have are admin, teacher and student.
Below is an example of what the application's menu looks like if you are logged in as an admin, if you are logged in as a student or a teacher it might be slightly different.

### Menus And Options
Admin menu
1. Create a subject
2. Create a teacher
3. Create a student
4. Remove a subject
5. Remove a teacher
6. Remove a student
7. Log out 

From this menu you can select what you want to do by pressing a number between 1 and 7. Once you choose a number the app will prompt you to provide the details needed in order to complete the operation e.g if you select 1, you will be
asked what you want the name of the subject you wish to add to be, it can not be blank! After you select a name, the subject will be added to the list of subjects available and you will be send back to the admin menu.
The teacher and the student menus work in exactly the same way, tho they have a limited functionality as compared to the admin menu.
Example of the teacher menu:

The subjects that you teach are: maths, history
Teacher menu
1. Grade a student
2. Log out

Example of the student menu:

Student menu
1. Check grades for a subject
2. Log out
