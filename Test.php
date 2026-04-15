<!DOCTYPE html>
<html>
<body>

<h1>My first PHP page</h1>
<?php
$color ="red";
echo "My car is ". $color . "<br>"; 
// This is declaring a variable and outputting it onto the screen 
$y=5;
$x=2;
echo"2+6= ". $y+$x; // adding 2 numbers togther and then printing them on the screen 
$txt = "Is my favourite programming language";
echo "<br>". "PHP " . $txt ;
/*Example of a global scope
the variable will only work when outide of the function
*/
function myGlobal(){
}
myGlobal();
echo"<p>Variable y will only output outside function. Y outside the function is: $y</p>"
// if inside the function it will output an error
//Example of static variable below:
?>
<?php
function myStatic(){
	static $z = 10;
	echo $z;
	$z++;
}
myStatic();
echo "<br>";
myStatic();
echo "<br>";
myStatic();
?>
<?php 
//Below is examples of how titles and pargraphs are printed in php
echo "<h2> PHP is so amazing!!</h2>";
echo"<p> Printing in PHP is sooo simple<p>";
print "Can also use <q> print</q> to print text in php<br>";
?>
<?php 
// Data types:
//Integer:
echo"<h2> Data types</h2>";
$x = 23543;
var_dump($x);//Returns the data type and value
echo "<br>";
//float
$y=12.43234;
var_dump($y);
echo "<br>";
//array 
$cars = array("Ford","Audi","Lamborghini");
var_dump($cars);
?>
<?php 
// object oriented in php 
class phone {
  public $make;
  public $model;
  public function __construct($make, $model) {
    $this->make = $make;
    $this->model = $model;
  }
  public function message() {
    return "My phone is a " . $this->make . " " . $this->model . "!";
  }
}
echo "<br>";
$myPhone= new phone("Samsung", "S21 5G");
echo $myPhone -> message();
echo "<br>";
$myPhone= new phone("Iphone", "13 pro max");
echo $myPhone-> message();
?>
<?php 
//null value
echo"<br>"; 
$x = "Hello world";	
$x = null;
var_dump($x);
?>
<?php 
echo"<br>";
echo strlen("Hello world!");//outputs the characters 
echo"<br>";
echo str_word_count("Hello world!"); // outputs the number of words
echo"<br>";
echo strrev("Hello world!"); // outputs !dlrow olleH(reverses string) 
echo "<br>";
echo str_replace("world", "Alex", "Hello world!");//replaces "Hello world" to "Hello Alex"
?>
<?php
echo"<h2>Numbers!</h2>";
echo "<br>";
// Checks whether the following numbers are integers 
$x = 5985;
var_dump(is_int($x));

$x = 59.85;
var_dump(is_int($x));
echo"<br>";
//checks if the number is a float
$x = 10.365;
var_dump(is_float($x));
echo"<br>";
// checks if number is finte or infinte 
$x = 1.9e411;
var_dump($x);// number is infinte because it is larger than PHP_FLOAT_MAX
echo "<br>";
// invalid calculation will return a NaN value
$x = acos(32);
var_dump($x);
?>
<?php 
// checks whether the data type is a string or number 
echo "<br>";
$x = 76565;
var_dump(is_numeric($x));
echo "<br>";
$x = "76.54";
var_dump(is_numeric($x));
echo "<br>";
$x = "89.5" + 100;
var_dump(is_numeric($x));
echo "<br>";
$x = "Hello world";
var_dump(is_numeric($x));
echo "<br>";
// casting a float to int
$x = 23465.768;
$int_cast = (int)$x;
echo $int_cast;

echo "<br>";

// Cast string to int
$x = "23465.768";
$int_cast = (int)$x;
echo $int_cast;
?>
<?php 
echo "<h2>Maths</h2>";
echo"Pi = ". (pi());//this returns the value of pi 
echo "<br>";
echo(min(3, 1678, 10, 50, -542, -543));  // executes lowest number in the list 
echo"<br>";
echo(max(3, 1678, 10, 50, -542, -200));  // executes highest number in the list 
echo "<br>";
echo(abs(-23));  // returns the absolute positive value of a number 
echo "<br>" ;
echo(sqrt(64));  // square root of a number 
echo"<br>";
echo(round(0.50));  // rounds to nearest integer 
echo"<br>";
echo(round(50.45));  // rounds ti nearestt integer 
echo"<br>";
echo(rand());//generates a random number 
echo"<br>";
echo (rand(10,20));//generates a random number between 10 and 20 
echo"<br>";
echo "<h2>Constants</h2>";
define("title", "Welcome to A-Level Subjects");
echo title;
echo"<br>";
define("cars", [
  "ford",
  "audi",
  "BMW"
]);
echo cars[1];
//Operators on website use link on webpage to open tables in w3 schools 
echo "<br>";
?>
<a href="https://www.w3schools.com/php/php_operators.asp">PHP operators</a>;
<?php
echo"<h2> if statements</h2>";
echo"<br>";
$t = date("H");

if ($t < "20") {
  echo "Have a good day!";
} else {
	echo"Have a goodnight";
} 
echo"<br>";
$t = date("H");

if ($t < "10") {
  echo "Have a good morning!";
} elseif ($t < "20") {
  echo "Have a good day!";
} else {
  echo "Have a good night!";
}
echo"<br>";
$favcolor = "red";

switch ($favcolor) {
  case "red":
    echo "Your favorite color is red!";
    break;
  case "blue":
    echo "Your favorite color is blue!";
    break;
  case "green":
    echo "Your favorite color is green!";
    break;
  default:
    echo "Your favorite color is neither red, blue, nor green!";
}
echo"<h2>Switch (Exapmle from w3 schools)</h2>";
echo"<br>";
$favcolor = "red";

switch ($favcolor) {
  case "red":
    echo "Your favorite color is red!";
    break;//to prevent the code from running into the next case automatically. 
  case "blue":
    echo "Your favorite color is blue!";
    break;
  case "green":
    echo "Your favorite color is green!";
    break;
  default://if no match is found 
    echo "Your favorite color is neither red, blue, nor green!";
}
echo"<br>";
$x = 0;
echo"<h2>While loops</h2>";
echo"<br>";
while($x <= 100) {
  echo "The number is: $x <br>";
  $x+=10;
}
// do while loops which will check the condition and repeat the loop while the specified condition is true
echo"<h3>Do while loops</h3>";
echo"<br>";
$x = 1;

do {
  echo "The number is: $x <br>";
  $x++;
} while ($x <= 5);
echo"<h3>For loops</h3>";
for ($x = 0; $x <= 10; $x++) {
  echo "The number is: $x <br>";
}
// for rest of tutroials i will look at during my time when im comleting the project as i need to do sql before deadline 
/*
Sections i didn't learn:
Functions 
Arrays 
Superglobals 
RegEx
all of php forms 
and php advance 
*/ 
?>

</body>
</html>