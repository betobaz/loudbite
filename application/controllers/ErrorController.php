<?php
class ErrorController extends Zend_Controller_Action {
    public function indexAction(){
        //Get the controller's errors.
        $errors = $this->_getParam('error_handler');
        $exception = $errors->exception;
        //Initialize view variables.
        $this->view->exception = $exception;
    }

    public function errorAction(){

    }
}
