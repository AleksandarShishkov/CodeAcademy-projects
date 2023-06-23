<?php

session_start();
if (!isset($_SESSION['id'])) {
    $_SESSION['id'] = 0;
}


class CalculatorController {

    private $refView;
    private $refModel;

    public function __construct() {
        $this->refView = new RefView();
        $this->refModel = new RefModel();
    }


    public function myApp() {

        $this->refView->get_header();

        $this->refView->get_refuel_ref();
        $this->refView->get_ref_table1();


        
        if(isset($_POST['show_add_tbl_btn'])) {
            $this->refView->get_ref_form();
        }
                        
        $this->menu_request();


        
        if(isset($_POST['editBtn'])) {
            $_SESSION['id'] = $_POST['editBtn'];
        
      
            echo "<script>location.href='http://localhost/Codix-codeacademy/homework/Project-gasCalculator/GasCalculator/src/app/views/EditView.php';</script>";
  
        }

        if(isset($_POST['delBtn'])) {
            $_SESSION['id'] = $_POST['delBtn'];
            echo "<script>location.href='http://localhost/Codix-codeacademy/homework/Project-gasCalculator/GasCalculator/src/app/views/DeleteView.php';</script>";
        }
                      
        if(isset($_POST['ref_btn'])) {
            $this->refModel->getData();
            $this->refModel->show_ref_tables();
        }

        if(isset($_POST['reportBtn'])){
            $this->refModel->getData();
            $this->refModel->show_ref_tables();
        }
        $this->refView->get_footer();
    } 

    public function menu_request() {
        
        if(isset($_POST['saveBtn'])) {


            $this->refModel->handle_menu_request();
            
            ob_start();
            $this->refModel->add_input_in_table1();
            ob_end_clean();
            
            $this->refModel->append_data_json();
            echo '</table><h4><a href="index.php"><button>Добави записа</ button></ a></ h4>';
        }
    }
}