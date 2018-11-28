<?php 
namespace tester\helpers; 

class DBHelper {
    public static $mysqli; 
    public static $dbUser = 'root';
    public static $dbPass = 'root'; 
    public static $dbName = 'tester';
    public static $dbHost = 'localhost'; 

    protected static $key = 'random'; 

    public static function createDB() {
        if( !self::$mysqli ) {
                
            self::$mysqli = mysqli_connect(self::$dbHost, self::$dbUser, self::$dbPass, self::$dbName); 
            
            if( mysqli_connect_errno() ) {
                printf("db error %s", mysqli_connect_error());
                exit();
            }
        }

        return self::$mysqli; 
    }
    
    public static function addEntry($data) {
      self::createDB();
      
      $result = [];

      $key = self::$key;
      $stmt = mysqli_stmt_init(self::$mysqli);
      $query = "INSERT INTO entries (firstName, lastName, email, comment) VALUES ('{$data['firstName']}', '{$data['lastName']}', '{$data['email']}', '{$data['comment']}')";
  
      $result['query'] = $query;
  
      if( mysqli_stmt_prepare($stmt, $query) ) {
        mysqli_stmt_execute($stmt);
  
        $result['entry'] = mysqli_stmt_affected_rows($stmt);
  
        mysqli_stmt_close($stmt);
  
        return $result;
      } else {
        $result['error'] = 'invalid query';
      }
  
      $result['entry'] = false;
  
      return $result;
      
    }
}

?>