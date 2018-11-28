<?php
    define('API_BASE_DIR', __DIR__); 

    require_once API_BASE_DIR . 'MyDBHelper.php'; 
    
    use tester\helpers\DBHelper; 

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $first = validateField($_POST["firstname"]); 
        $last = validateField($_POST["lastname"]); 
        $email = validateField($_POST["email"]); 
        $comment = validateField($_POST["comment"]); 
    }

    function myTest() {
        //  Or you can access via $GLOBALS['first'], $GLOBALS['last']
        global $first, $last; 

        //  If we ever need a *local* variable to retain its information after a function finishes executing, we can declare it as a static var: 
        # static $x = 0; 

        //  var_dump() returns the data type and value of a var: 
        # $x = 0; 
        # var_dump($x); 

        // strlen() returns the length of a string
        # echo strlen("Hello world!"); // outputs 12
        # echo str_word_count("Hello world!"); // outputs 2
        
        // strrev() reverses a string
        # echo strev("Hello world!"); // outputs !dlrow olleH

        // strpos searches for a substring and outputs the pos of the first match
        # echo strpos("Hello world!", "world"); // outputs 6

        // str_replace (case sensitive), str_ireplace (case insensitive)
        # echo str_replace("world", "Dolly", "Hello world!"); // outputs Hello Dolly!

        // count() returns the length of an array
        # $cars = array("Volvo", "BMW", "Toyota"); 
        # echo count($cars); // 3

        // Associative arrays, essentially a dictionary in the form of an array [key=>value]
        # $age = array("Peter"=>"35", "Ben"=>"37", "Joe"=>"43"); 
        # echo "Peter is " . $age['Peter'] . " years old."; 
        
        // Looping through an associative array is different...you have to use a foreach loop: 
        # foreach($age as $x => $x_value) {
        #     echo "Key=" . $x . ", Value=" . $x_value; 
        #     echo "<br>"; 
        # }

        // Super global variable that returns the filename of the currently executing script
        // However...this can bring about a huge security risk because you can perform XSS commands to execute inject scripts and steal info
        // ...We can prevent this by using htmlspecialchars and wrapping this var in that function call
        # $_SERVER["PHP_SELF"];

        // Converts special characters to HTML entities, preventing attackers frome exploiting code by injecting HTML or JS code in forms
        # htmlspecialchars($_SERVER["PHP_SELF"]); 

    }

    function validateForm() {
        global $first, $last, $email, $comment; 

        if(empty($first) || empty($last) || empty($email) || empty($comment)) {
            return false; 
        }

        return true; 
    }

    function validateField($data) {
        $data = trim($data); 
        $data = stripslashes($data); 
        $data = htmlspecialchars($data); 

        return $data; 
    }
?>

<?php if(!validateForm()): ?>
Missing information...
<?php else: ?>
Welcome <?php echo $first . " " . $last;?><br>
Your email address is: <?php echo $email; ?><br>
And this is what you said in the comment section: <?php echo $comment; ?>
<?php endif; ?>

</body>

</html>