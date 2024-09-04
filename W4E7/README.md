# W4E7

W3E6 consists of building a simple API which supports the following functions - login, get, get?id={id}, post,
put?id={id}, patch?id={id}, delete?id={id}

## Usage

Here are the options which our api supports:
`POST | /login` - Requires username and password, returns on successful login - jwt token and success message, on fail
wrong username or password.
`GET | /` - Requires no authorization and will return a list of all our teachers.
`GET | ?id={5}` - Requires no authorization, if the id is correct will return the teacher with the corresponding id, if
it is not will return "Teacher not found".
`POST | /` - Requires authorization - you will need to pass your jwt token in the headers or you will get 403,
Unauthorized. It also requires you to fill values
for firstName, lastName, username and password. If all the fields are filled a new teacher will be created and you will
receive a "Teacher successfully created "
response. If a field's value is missing you will receive a response - 400, Please fill all fields.
`PUT | ?id={5}` - Requires authorizations, again you will need to fill all fields of the teacher in order for your
request to be successful, otherwise you will
get a "400, Please fill all the fields required!"
`PATCH | ?id={5}` - Requires authorizations, again you will need to fill at least one of the teacher's fields in order
for your request to be successful, otherwise you will
get a "400, Please fill all the fields required!"
`DELETE | ?id={5}` - Requires authorizations, if your id is correct(there is a teacher with this id), the teacher will
be deleted and you will receive a response saying
"200, Teacher deleted successfully", otherwise you will get a response "404, Teacher not found"
