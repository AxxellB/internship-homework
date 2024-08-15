# Internship Homework
This repo will be used for uploading homeworks during the internship.
Files will be separated into folders representing each week and exercise. For example: W1E1 means Week 1, Exercise 1.

## W1E1
W1E1 consists of two command line interface(CLI) applications. 
The first application is an arithmetic calculator which supports addition, difference, multiplication, devision, modular devision and square root.
The second applicaiton is a figures calculator and supports finding the area and perimeter of a circle, a square and a triangle.

### Usage
In order to run any of this applications which have to run open a terminal in the directory where our script files are located.
In order to run the script we use the command `php calculator.php`
However in our case we want to pass extra arguments called options to our application so to do that our command would look like this:<br/>
`php calculator.php --type=arithmetic --operator=minus --param1=20 --param2=3`<br/>
It should be noted that options are passed as key value pairs and the data they contain is later on used in our application.

### Options
The basic arithmetic calculator applications can receive the following options:
- `--type`: (required) Operation type, must be set to "arithmetic" in order to work.
- `--operator`: (required) The type of the operator defines what operation our calculator will be executing. A list of the possible options is presented below.
  - `plus`
  - `minus`
  - `multiply`
  - `divide`
  - `modular_division`
  - `square_root`
- `--param1`: (required) The first parameter of our calculator.
- `--param2`: (required) The first parameter of our calculator.

The figures calculater can receive the following options:
- `--type`: (required) Operation type, must be set to "shape" in order to work.
- `--calculation` (required) Calculation type. A list of the possible options is presented below.
  - `area`
  - `perimeter`
- `--shape` (required) The type of shape we are calculating for. A list of the possible options is presented below.
  - `circle`
    - `--radius` (optional) However a value must be provided if the selected shape is a circle.
  - `triangle`
    - `--a` (optional, side a) However a value must be provided for each side if the selected shape is a triangle.
    - `--b` (optional, side b)
    - `--c` (optional, side c)
  - `square`
    - `--a` (optional, side length) However a value must be provided for side a if the selected shape is a square.


