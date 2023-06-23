<?php


class RefEditModel {

    private $editView;
    private $date;
    private $distance;
    private $total_distance;
    private $fuel_quantity;
    private $fuel_amount;
    private $total_price;
    private $gas_station_product;
    private $gas_station_name;
    private $driving_type;


    public function open_json_file() {
        $data = file_get_contents('../database.json');
        $refEvents = json_decode($data, true);
        return $refEvents;
    }



    public function save_edit_data_json() {
        $id = $_SESSION['id'];

        $data = file_get_contents('../database.json');
        $refEvents = json_decode($data, true);

        if(isset($_POST['saveEditBtn'])) {
            foreach($refEvents as $refKey => $refVal) {
                foreach($refVal as $event) {
                    if($event['id'] == $id) {
                        $editData = array(
                            'id' => $id,
                            'date' => date('d/m/Y', strtotime($_POST['event_date_edit'])),
                            'distance' => $_POST['event_distance_edit'],
                            'total_odo' => $_POST['global_distance_edit'],
                            'fuel_quantity' => $_POST['fuel_quantity_edit'],
                            'fuel_amount' => $_POST['fuel_amount_edit'],
                            'total_price' => $_POST['total_price_edit'],
                            'gas_station_product' => $_POST['gas_station_product_edit'],
                            'gas_station_name' => $_POST['gas_station_name_edit'],
                            'driving_type' => $_POST['driving_type_edit']
                        );
    
                        $refEvents['refuel_events'][$id] = $editData;
    
                        $data = json_encode($refEvents, JSON_PRETTY_PRINT);
                        file_put_contents('../database.json', $data);
                        
                        header('location: http://localhost/Codix-codeacademy/homework/Project-gasCalculator/GasCalculator/src/app/index.php');
                    }
                }
            }
        }
        if(isset($_POST['backBtn'])) {
            header('location: http://localhost/Codix-codeacademy/homework/Project-gasCalculator/GasCalculator/src/app/index.php');
        }   
    }
}