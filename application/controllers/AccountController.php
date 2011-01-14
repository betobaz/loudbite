<?php
/**
 *Account Controller
 *
 */
class AccountController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }
    /**
     *Process the account form
     *
     */
    public function successAction()
    {
         $form = $this->getSignupForm();

         //Check if the submitted data is POST type
         if($form->isValid($_POST)){
             $email = $form->getValue("email");
             $username = $form->getValue("username");
             $password = $form->getValue("password");

             //Save the user into the system
         }
         else{
             $this->view->errors = $form->getMessages();
             $this->view->form = $form;
         }
    }
	/**
 	 *Display the form form signing up
 	 *
 	 */
    public function newAction()
    {
        //Get the form
        $form = $this->getSignupForm();

        //Add the form to the view
        $this->view->form = $form;

    }
    /**
     * Activate Account. Used once the user
     * receives a welcome email an decides to authenticate
     * their account.
     *
     */
    public function activateAction()
    {
        //Fetch the email to update from the query param 'email'
        $emailToActivate = $this->_request->getQuery("email");

        //Check if the email exist
        //Activate the Account
    }

    /**
     * Update the user's data
     *
     */
     public function updateAction()
     {
         //Check if the user is logged in

         //Fetch the user's id

         //Fetch the users information

         //Create the form
         $form = $this->getUpdateForm();
         
         //Check if the form has been submitted
         //If so validate and process
         if($_POST){
             //Check if the form is valid
             if($form->isValid($_POST)){
                 //Get the values
                 $username = $form->getValue('username');
                 $password = $form->getValue('password');
                 $email = $form->getValue('email');
                 $aboutMe = $form->getValue('aboutme');

                 //Save the file
                 $form->avatar->receive();

                 //Save
             }
             //Otherwise redisplay the form
             else{
                 $this->view->form = $form;
             }
         }
         //Otherwise display the form
         else{
             $this->view->form = $form;
         }
     }
     /**
      * Create the sign up form
      */
     private function getSignupForm(){
         //Create Form
         $form = new Zend_Form();
         $form->setAction('success');
         $form->setMethod('post');
         $form->setAttrib('sitename','loudbite');

         //Add Elements
         require "Form/Elements.php";
         $LoudbiteElements = new Elements();

         //Create Username Field
         $form->addElement($LoudbiteElements->getUsernameTextField());

         //Create Email Field
         $form->addElement($LoudbiteElements->getEmailTextField());

         //Create Password Field
         $form->addElement($LoudbiteElements->getPasswordTextField());

         //Add Captcha
         $captchaElement = new Zend_Form_Element_Captcha(
                 'signup',
                 array(
                     'captcha'=>array(
                         'captcha'=>'Figlet',
                         'wordLen'=>6,
                         'timeout'=>600
                     )
                 )
         );
         $captchaElement->setLabel('Please type in the word below to continue');
         $form->addElement($captchaElement);


         $form->addElement('submit','submit');
         $submitButton = $form->getElement('submit');
         $submitButton->setLabel('Create My Account!');
         $submitButton->setOrder(4);

         return $form;
     }

     /**
      * Update Form
      */
     private function getUpdateForm()
     {
         //Create Form
         $form = new Zend_Form();
         $form->setAction('update');
         $form->setMethod('post');
         $form->setAttrib('sitename','loudbite');

         
         //Load Element class
         require "Form/Elements.php";
         //require "utils/Escape.php";
         //require "utils/Escape.php";
         $LoudbiteElements = new Elements();

         //Create Username Field
         $form->addElement($LoudbiteElements->getUsernameTextField());

         //Create Email Field.
         $form->addElement($LoudbiteElements->getEmailTextField());
         
         //Create Password Field
         $form->addElement($LoudbiteElements->getPasswordTextField());

         //Create Text Area for About me.
         $textAreaElement = new Zend_Form_Element_Textarea('aboutme');
         $textAreaElement->setLabel('About Me');
         $textAreaElement->setAttribs(
            array(
                'cols'=>15,
                'rows'=>5
                )
         );
         $form->addElement($textAreaElement);

         //Add File Update
         $fileUploadElement = new Zend_Form_Element_File('avatar');
         $fileUploadElement->setLabel('Your Avatar:');
         $fileUploadElement->setDestination('../public/users');
         $fileUploadElement->addValidator('Count',false,1);
         $fileUploadElement->addValidator('Extension',false,'jpg,gif');
         $form->addElement($fileUploadElement);

         $form->addElement('submit','submit');
         $submitElement = $form->getElement('submit');
         $submitElement->setLabel('Update My Account');
         
         return $form;
     }
	 /**
	  * Test our connection
	  */
	 public function testConnAction()
	 {
	 	try{

			$connParams = array(
				"host"=>"localhost",
				"port"=>"3306",
				"username"=>"loudbite",
				"password"=>"sFu7sndxDDpXsq4B",
				"dbname"=>"loudbite"
			);
			$db = new Zend_Db_Adapter_Pdo_Mysql($connParams);

		}catch(Zend_Db_Exception $e){
			echo $e->getMessage();
		}
		echo "Database object create.";

		//Turn off View Rendering.
		$this->_helper->viewRenderer->setNoRender();
	 }
	 /**
	  * Test Insert
	  */
	 public function testInsertAction()
	 {
	 	try{
			//Create a DB object
			require_once "Db/Db_Db.php";
			$db = Db_Db::conn();

			//DDL for initial 3 users
			$statement = "INSERT INTO accounts(username,email,password,status,create_date)
				VALUES('test_1','test@loudbite.com','password','active',NOW())";
			$statement2 = "INSERT INTO accounts(username,email,password,status,create_date)
				VALUES('test_2','test2@loudbite.com','password','active',NOW())";
			$statement3 = "INSERT INTO accounts(username,email,password,status,create_date)
				VALUES(?,?,?,?,NOW())";
			//Insert the above statements into the accounts.
			$db->query($statement);
			$db->query($statement2);

			//Insert the statement using ? flags.
			$db->query($statement3,array('test_3','text3@loudbite.com','password','active'));

			//Close Connection
			$db->closeConnection();

			echo "Completed Inserting";

		}catch(Zend_Db_Exception $e){
			echo $e->getMessage();
		}

		//Supress the View
		$this->_helper->viewRenderer->setNoRender();

	 }
	 /**
	  * Test Insert Method
	  * Insert data into table using insert()
	  */
	 public function testInsertMethodAction()
	 {
	 	try{

			//Create a DB object
			require_once "Db/Db_Db.php";
			$db = Db_Db::conn();

			//Data to save
			$userData1 = array(
				"username"=>'test_4',
				"email"=>'test_4@loudbite.com',
				"password"=>'password',
				"status"=>'active',
				"create_date"=>'0000-00-00 00:00:00'
			);
			$userData2 = array(
				"username"=>'test_5',
				"email"=>'test_5@loudbite.com',
				"password"=>'password',
				"status"=>'active',
				"create_date"=>'0000-00-00 00:00:00'
			);
			$userData3 = array(
				"username"=>'test_6',
				"email"=>'test_6@loudbite.com',
				"password"=>'password',
				"status"=>'active',
				"create_date"=>'0000-00-00 00:00:00'
			);
			//Insert into the Accounts.
			$db->insert('accounts',$userData1);
			$db->insert('accounts',$userData2);
			$db->insert('accounts',$userData3);
			
			//Close Connection
			$db->closeConnection();

			echo "Completed Inserting";
		}catch(Zend_Db_Exception $e){
			echo $e->getMessage();
		}

		//Supress the View
		$this->_helper->viewRenderer->setNoRender();
	 }
	 /**
	  * Test Expression
	  * Using Database Expressions.
	  */
	 public function testExpressionAction()
	 {
	 	try{
			//Create a DB object
			require_once "Db/Db_Db.php";
			$db = Db_Db::conn();

			$userData = array(
				"username"=>'test_7',
				"email"=>'test7@loudbite.com',
				"password"=>'password',
				"status"=>'action',
				"create_date"=> new Zend_Db_Expr("NOW()")
			);
			//Insert into the accounts.
			$db->insert('accounts',$userData);
			
			//Close Connection
			$db->closeConnection();
			echo "Completed Inserting";

		}catch(Zend_Db_Exception $e){
			echo $e->getMessage();
		}
		//Supress the View
		$this->_helper->viewRenderer->setNoRender();
	 }
}







