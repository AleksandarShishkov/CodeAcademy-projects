<?php

require_once '..\..\config.php';

class RefView {

    private $html;
    private $model;

    public function __construct() {
        $this->html = new HTML();
        $this->model = new RefModel();
    }

    public function get_header() {
        $this->html->show_html_head();
        return $this;
    }

    public function get_refuel_ref() {
        $this->html->show_html_refuel_ref();
        return $this;
    }

    public function get_ref_table1() {
        $this->html->show_ref_table1();
        $this->model->add_input_in_table1();
        return $this;
    }

    public function get_ref_form() {
        $this->html->show_ref_form();
        return $this;
    }


    public function get_footer() {
        $this->html->show_html_footer();
        return $this;
    }


}