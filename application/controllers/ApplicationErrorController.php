<?php
class ApplicationErrorController extends Zend_Controller_Action {
    public function indexAction(){
        //Get the controller's error.
        $errors = $this->_getParam('error_handler');
        $exception = $errors->exception;

        //Initialize view variables
        $this->view->exception = $exception;
    }
}

?>
