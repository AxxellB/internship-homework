# W4E7

W3E6 consists of building a simple API which supports the following functions - login, get, get?id={id}, post,
put?id={id}, patch?id={id}, delete?id={id}

### Usage

Here are the options which our API supports:

- **`POST | /login`**  
  Requires username and password. On successful login, returns a JWT token and a success message. On failure, returns an error message indicating wrong username or password.

- **`GET | /`**  
  Requires no authorization and returns a list of all teachers.

- **`GET | /?id={5}`**  
  Requires no authorization. If the ID is correct, returns the teacher with the corresponding ID. If not, returns "Teacher not found."

- **`POST | /`**  
  Requires authorization (JWT token in headers). Requires `firstName`, `lastName`, `username`, and `password` fields. If all fields are filled, a new teacher will be created, and you will receive a "Teacher successfully created" response. If any field is missing, you will receive a "400, Please fill all fields" response.

- **`PUT | /?id={5}`**  
  Requires authorization (JWT token in headers). Requires `firstName`, `lastName`, `username`, and `password` fields. If all fields are filled, the teacher with the given ID will be updated, and you will receive a "Teacher updated successfully" response. If any field is missing, you will receive a "400, Please fill all the fields required!" response.

- **`PATCH | /?id={5}`**  
  Requires authorization (JWT token in headers). Requires at least one of the fields (`firstName`, `lastName`, `username`, or `password`) to be filled. If at least one field is provided, the teacher with the given ID will be updated, and you will receive a "Teacher updated successfully" response. If no fields are provided, you will receive a "400, Please fill all the fields required!" response.

- **`DELETE | /?id={5}`**  
  Requires authorization (JWT token in headers). If the ID is correct (a teacher with this ID exists), the teacher will be deleted, and you will receive a "200, Teacher deleted successfully" response. If the ID is incorrect (no teacher with this ID exists), you will receive a "404, Teacher not found" response.

