<?php
/**
 * Model - Save the data into the DB.
 * This code base can be used in other applications that need
 * data to be stored for a new users
 *
 */
class SaveAccount{
    /**
     * Save Account
     *
     * @param String $username
     * @param String $password
     * @param String $email
     */
    public function saveAccount($username, $password, $email){

        //Clean up data
        $username = $this->_db_escape($username);
        $password = $this->_db_escape($password);
        $email = $this->_db_escape($email);

        //Set up mysqli instance
        $dbconn = mysqli(
                'localhost',
                'root',
                'albertose'
                );
        $dbconn->select_db('loudbite');

        //Create the SQL statement and insert
        $statement = "INSERT INTO Accounts(username,password,email)
            VALUES('".$username."',
                '".$password."',
                '".$email."')";
        $dbconn->query($statemnt);

        //Close db connection
        $dbconn->close();
    }
}
?>
