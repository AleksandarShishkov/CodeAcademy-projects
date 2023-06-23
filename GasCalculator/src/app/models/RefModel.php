<?php

class RefModel {

    private $id = 0;

    // optional ----------->
    private $edit_view_path; 
    private $del_view_path;
    // -------------------->

    private $date;
    private $distance;
    private $total_distance;
    private $fuel_quantity;
    private $fuel_amount;
    private $total_price;
    private $gas_station_product;
    private $gas_station_name;
    private $driving_type;

    private $fuelCharges = [];
    private $fuelPrices = [];
    private $distances = [];
    private $fuelQuantity = [];
    private $fuelAmounts = [];
    private $gasStations = [];
    private $gasStationProducts = [];


    public function __construct() {}

    public function handle_menu_request() {

        $this->date = date('d/m/Y', strtotime($_POST['event_date']));
        $this->distance = $_POST['event_distance'];
        $this->total_distance = $_POST['global_distance'];
        $this->fuel_quantity = $_POST['fuel_quantity'];
        $this->fuel_amount = $_POST['fuel_amount'];
        $this->total_price = $_POST['total_price'];
        $this->gas_station_product = $_POST['gas_station_product'];
        $this->gas_station_name = $_POST['gas_station_name'];
        $this->driving_type = $_POST['driving_type'];
    }

    public function append_data_json() {

        $json_data = file_get_contents('.\database.json');
        $data = json_decode($json_data, true);
        $n_data = array(
            'id' => $this->id,
            'date' => $this->date,
            'distance' => $this->distance,
            'total_odo' => $this->total_distance,
            'fuel_quantity' => $this->fuel_quantity,
            'fuel_amount' => $this->fuel_amount,
            'total_price' => $this->total_price,
            'gas_station_product' => $this->gas_station_product,
            'gas_station_name' => $this->gas_station_name,
            'driving_type' => $this->driving_type
        );

        $data['refuel_events'][] = $n_data;

        $json_data = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents('.\database.json', $json_data);
    }

    public function add_input_in_table1() { 
        $jsonString = file_get_contents('.\database.json');
        $data = json_decode($jsonString);

        if(json_last_error() !== JSON_ERROR_NONE) {
            die('Error decoding the file' . json_last_error_msg());
        }

        $this->edit_view_path = 'D:\XAMPP\htdocs\Codix-codeacademy\homework\Project-gasCalculator\help-new\src\app\views\EditView.php';

        $refEvents = $data->refuel_events;
        $showData = '';
        $showData .= '<tr>';

        foreach($refEvents as $refEvent) {
            $showData .= '<tr>' . 
                         '<td>' . $refEvent->date . '</ td>' . 
                         '<td>' . $refEvent->distance . '</ td>' .
                         '<td>' . $refEvent->total_odo . '</ td>' .
                         '<td>' . $refEvent->fuel_quantity . '</ td>' .
                         '<td>' . $refEvent->fuel_amount . '</ td>' .
                         '<td>' . $refEvent->total_price . '</ td>' .
                         '<td>' . $refEvent->gas_station_product . '</ td>' . 
                         '<td>' . $refEvent->gas_station_name . '</ td>' .
                         '<td>' . $refEvent->driving_type . '</ td>' . 
                         '<td><a href="' . $this->edit_view_path . '"><button name="editBtn" value="' . $refEvent->id . '">Редактирай</button></a>  ' . 
                                                   '<button name="delBtn" value="' . $refEvent->id . '">Изтрий</ button></ td>' .
                         '</ tr>'; 

                         $this->id++;
        }

        $showData .= '</ tr>';
        echo $showData;
    }

    public function getData(){
        $json_data = file_get_contents('.\database.json');
        $data = json_decode($json_data, true);

        foreach($data['refuel_events'] as $key){
            $this->fuelCharges[] = $key['date'];
            $this->fuelPrices[] = $key['total_price'];
            $this->distances[] = $key['distance'];
            $this->fuelQuantity[] = $key['fuel_quantity'];
            $this->fuelAmounts[] = $key['fuel_amount'];
            $this->gasStations[] = $key['gas_station_name'];
            $this->gasStationProducts[] = $key['gas_station_product'];
        }
    }

    public function getLastDistance(){
        $json = json_decode(file_get_contents('.\database.json'));
        $lastObject = end($json->refuel_events);
        $objValues = get_object_vars($lastObject);
        $distanceRaw = $objValues['distance'];

        return $distanceRaw;
    }

    public function getLastFuelConsumption(){
        $json = json_decode(file_get_contents('.\database.json'));
        $lastObject = end($json->refuel_events);
        $objValues = get_object_vars($lastObject);
        $distanceRaw = $objValues['distance'];
        $fuel = $objValues['fuel_quantity'];

        $pricePer100Raw = round((($fuel / $distanceRaw) * 100), 2);

        return $pricePer100Raw;
    }

    public function getPriceForLastDistance(){
        $json = json_decode(file_get_contents('.\database.json'));
        $lastObject = end($json->refuel_events);
        $objValues = get_object_vars($lastObject);
        $distanceRaw = $objValues['distance'];
        $fuel = $objValues['fuel_quantity'];
        $fuelPrice = $objValues['fuel_amount'];

        $priceForFuel=$fuelPrice*$fuel;
        $price1kmRaw=round(($priceForFuel/intval($distanceRaw)),2);
        

        return $price1kmRaw;
    }

    public function getAverageChargesPerMonth() {

        $chargeCount = count($this->fuelCharges);
        $chargeMonths = [];
    
        foreach ($this->fuelCharges as $chargeDate) {
            $dateParts = explode('/', $chargeDate);
            $formattedDate = $dateParts[1] . '/' . $dateParts[0] . '/' . $dateParts[2];
            $monthYear = date('m/Y', strtotime($formattedDate));
            $chargeMonths[$monthYear] = isset($chargeMonths[$monthYear]) ? $chargeMonths[$monthYear] + 1 : 1;
        }
        $totalMonths = count($chargeMonths);
    
        if ($totalMonths === 0) {
            return 0;
        }
    
        $averageCharges = round(($chargeCount / $totalMonths),1);
        return $averageCharges;
    }

    public function getAveragePricePerMonth() {
        $priceCount = count($this->fuelCharges);
        $chargeMonths = [];
    
        foreach ($this->fuelCharges as $chargeDate) {
            $dateParts = explode('/', $chargeDate);
            $formattedDate = $dateParts[1] . '/' . $dateParts[0] . '/' . $dateParts[2];
            $monthYear = date('m/Y', strtotime($formattedDate));
            $chargeMonths[$monthYear] = isset($chargeMonths[$monthYear]) ? $chargeMonths[$monthYear] + 1 : 1;
        }
        $totalMonths = count($chargeMonths);
    
        if ($totalMonths === 0) {
            return 0;
        }
    
        $averagePrice = round((array_sum($this->fuelPrices) / $totalMonths),1);
        return $averagePrice;
    }

    public function getAverageFuelQnty() {
        $priceCount = count($this->fuelCharges);
        $chargeMonths = [];
    
        foreach ($this->fuelCharges as $chargeDate) {
            $dateParts = explode('/', $chargeDate);
            $formattedDate = $dateParts[1] . '/' . $dateParts[0] . '/' . $dateParts[2];
            $monthYear = date('m/Y', strtotime($formattedDate));
            $chargeMonths[$monthYear] = isset($chargeMonths[$monthYear]) ? $chargeMonths[$monthYear] + 1 : 1;
        }
        $totalMonths = count($chargeMonths);
    
        if ($totalMonths === 0) {
            return 0;
        }
    
        $averageFuel = round((array_sum($this->fuelQuantity) / $totalMonths),1);
        return $averageFuel;
    }

    public function getAveragePeriod() {

        usort($this->fuelCharges, function($a, $b) {
            $date1 = DateTime::createFromFormat('d/m/Y', $a);
            $date2 = DateTime::createFromFormat('d/m/Y', $b);
            return $date1 <=> $date2;
        });
    
        $totalDiff = 0;
        $chargeCount = count($this->fuelCharges);
    
        for ($i = 0; $i < $chargeCount - 1; $i++) {
            $date1 = DateTime::createFromFormat('d/m/Y', $this->fuelCharges[$i]);
            $date2 = DateTime::createFromFormat('d/m/Y', $this->fuelCharges[$i + 1]);
    
            $diff = $date2->diff($date1)->days;
            $totalDiff += $diff;
        }
    
        $averagePeriod = $totalDiff / ($chargeCount - 1);
    
        return round($averagePeriod, 1);
    }

    public function getAverageFuelConsumption() {

        $averageFuelConsumption = round(100*(array_sum($this->fuelQuantity)/(array_sum($this->distances))),1);
        return $averageFuelConsumption;
    
    }

    public function getMinFuelConsumption() {
        $json_data = file_get_contents('.\database.json');
        $data = json_decode($json_data, true);
        $selectedStation = isset($_POST['gas_station'])?$_POST['gas_station']:"Без значение бензиностанция";
        $selectedFuel = isset($_POST['gas_station_product'])?$_POST['gas_station_product']:"Без значение нарка гориво";
        $selectedDriving = isset($_POST['driving_type'])?$_POST['driving_type']:"Без значение вид на шофиране";
        $distances = [];
        $fuelQuantity = [];
        foreach($data['refuel_events'] as $index=>$key){
            if($key['gas_station_name'] == $selectedStation && $key['gas_station_product'] == $selectedFuel && $key['driving_type'] == $selectedDriving){
                $distances[] = $key['distance'];
                $fuelQuantity[] = $key['fuel_quantity'];
            }
        } 

        if (isset($_POST['gas_station']) && isset($_POST['gas_station_product']) && isset($_POST['driving_type'])){
            if(!empty($distances) && !empty($fuelQuantity)){
                $consumptionsArr = [];
                for($i = 0; $i<count($fuelQuantity); $i++){
                    $fuelConsumption = round((100*($fuelQuantity[$i]/$distances[$i])),1);
                    $consumptionsArr[] = $fuelConsumption;
                }
                return min($consumptionsArr);
            }
        }else {
            return NULL;
        }
    
    }

    public function getAverageFuelConsumptionBest() {
        $json_data = file_get_contents('.\database.json');
        $data = json_decode($json_data, true);
        $selectedStation = isset($_POST['gas_station'])?$_POST['gas_station']:"Без значение бензиностанция";
        $selectedFuel = isset($_POST['gas_station_product'])?$_POST['gas_station_product']:"Без значение нарка гориво";
        $selectedDriving = isset($_POST['driving_type'])?$_POST['driving_type']:"Без значение вид на шофиране";
        $distances = [];
        $fuelQuantity = [];
        foreach($data['refuel_events'] as $index=>$key){
            if($key['gas_station_name'] == $selectedStation && $key['gas_station_product'] == $selectedFuel && $key['driving_type'] == $selectedDriving){
                $distances[] = $key['distance'];
                $fuelQuantity[] = $key['fuel_quantity'];
            }
        } 
        if (isset($_POST['gas_station']) && isset($_POST['gas_station_product']) && isset($_POST['driving_type'])){
            if(!empty($distances) && !empty($fuelQuantity)){
                $averageFuelConsumptionBest = round(100*((array_sum($fuelQuantity)/array_sum($distances))),1);
                return $averageFuelConsumptionBest;
            }
        }else {
            return NULL;
        }
    
    }

    function getAveragePricePerDistance() {

        $chargeCount = count($this->fuelCharges);
        $chargeMonths = [];
    
        foreach ($this->fuelCharges as $chargeDate) {
            $dateParts = explode('/', $chargeDate);
            $formattedDate = $dateParts[1] . '/' . $dateParts[0] . '/' . $dateParts[2];
            $monthYear = date('m/Y', strtotime($formattedDate));
            $chargeMonths[$monthYear] = isset($chargeMonths[$monthYear]) ? $chargeMonths[$monthYear] + 1 : 1;
        }
        $totalMonths = count($chargeMonths);
    
        if ($totalMonths === 0) {
            return 0;
        }

        $averageFuelPrice = array_sum($this->fuelAmounts)/$chargeCount;
        $averagePricePerKm = round((((array_sum($this->distances)/100)*$this->getAverageFuelConsumption())*$averageFuelPrice/array_sum($this->distances)),2);
        return $averagePricePerKm;
    }

    function getMinPricePerDistance() {
        $json_data = file_get_contents('.\database.json');
        $data = json_decode($json_data, true);
        $selectedStation = isset($_POST['gas_station'])?$_POST['gas_station']:"Без значение бензиностанция";
        $selectedFuel = isset($_POST['gas_station_product'])?$_POST['gas_station_product']:"Без значение нарка гориво";
        $selectedDriving = isset($_POST['driving_type'])?$_POST['driving_type']:"Без значение вид на шофиране";
        $distances = [];
        $totalPrice = [];
        foreach($data['refuel_events'] as $index=>$key){
            if($key['gas_station_name'] == $selectedStation && $key['gas_station_product'] == $selectedFuel && $key['driving_type'] == $selectedDriving){
                $distances[] = $key['distance'];
                $totalPrice[] = $key['total_price'];
            }
        } 

        if (isset($_POST['gas_station']) && isset($_POST['gas_station_product']) && isset($_POST['driving_type'])){
            if(!empty($distances) && !empty($totalPrice)){
                $pricesPerKm = [];
                for($i = 0; $i<count($totalPrice); $i++){
                    $price = round((($totalPrice[$i]/$distances[$i])),2);
                    $pricesPerKm[] = $price;
                }
                return min($pricesPerKm);
            }
        
        }else {
            return NULL;
        }

    }

    function getAveragePricePerDistanceBest() {

        $json_data = file_get_contents('.\database.json');
        $data = json_decode($json_data, true);
        $selectedStation = isset($_POST['gas_station'])?$_POST['gas_station']:"Без значение бензиностанция";
        $selectedFuel = isset($_POST['gas_station_product'])?$_POST['gas_station_product']:"Без значение нарка гориво";
        $selectedDriving = isset($_POST['driving_type'])?$_POST['driving_type']:"Без значение вид на шофиране";
        $distances = [];
        $fuelAmounts = [];
        $charges = [];
        foreach($data['refuel_events'] as $index=>$key){
            if($key['gas_station_name'] == $selectedStation && $key['gas_station_product'] == $selectedFuel && $key['driving_type'] == $selectedDriving){
                $charges[] = $key['date'];
                $distances[] = $key['distance'];
                $fuelAmounts[] = $key['fuel_amount'];
            }
        } 
        $chargesCount = count($charges);
        if (isset($_POST['gas_station']) && isset($_POST['gas_station_product']) && isset($_POST['driving_type'])){
            if(!empty($distances) && !empty($fuelAmounts) && !empty($chargesCount)){
              
                $averageFuelPriceBest = array_sum($fuelAmounts)/$chargesCount;
                $averagePricePerKmBest = round((((array_sum($distances)/100)*$this->getAverageFuelConsumptionBest())*$averageFuelPriceBest/array_sum($distances)),2);
                return $averagePricePerKmBest;
            }
        }else {
            return NULL;
        }
    }

    public function show_ref_tables(){ 

        $this->distanceRaw = $this->getLastDistance();
        $this->lastFuelConsumption = $this->getLastFuelConsumption();
        $this->price1kmRaw = $this->getPriceForLastDistance();
        $this->averageChargesPerMonth = $this->getAverageChargesPerMonth();
        $this->averagePricePerMonth = $this->getAveragePricePerMonth();
        $this->averageFuelQnty = $this->getAverageFuelQnty();
        $this->averagePeriod = $this->getAveragePeriod();
        $this->averageFuelConsumption = $this->getAverageFuelConsumption();
        $this->averageFuelConsumptionBest = $this->getAverageFuelConsumptionBest();
        $this->minFuelConsumption = $this->getMinFuelConsumption();
        $this->averagePricePerDistance = $this->getAveragePricePerDistance();
        $this->averagePricePerDistanceBest = $this->getAveragePricePerDistanceBest();
        $this->minPricePerDistance = $this->getMinPricePerDistance();

    $htmlRefTable1 = <<<HTML
        </table>
        <section id="report_last_period">
            <h3>Справка за последен период на зареждане</h3>
            <table>
            <tr>
                <th>Изминато разстояние</td>
                <td>$this->distanceRaw (километри)</td>
            </tr>
            <tr>
                <th>Разход на гориво</td>
                <td>$this->lastFuelConsumption (литри / 100 километра)</td>
            </tr>
            <tr>
                <th>Цена за разстояние</th>
                <td>$this->price1kmRaw (лева / километър)</th>
            </tr>
            </table>
        </section>
        <hr/>
        HTML;

    $htmlRefTable2 = <<<HTML
        <section id="report_averages">
            <h3>Справка средни стойности</h3>
        <table>
            <tr>
                <th>Среден брой зареждания в месец</th>
                <td>$this->averageChargesPerMonth</td>
            </tr>
            <tr>
                <th>Средна цена на месец</th>
                <td>$this->averagePricePerMonth (лева)</td>
            </tr>
            <tr>
                <th>Средно количество гориво на месец</th>
                <td>$this->averageFuelQnty (литра)</td>
            </tr>
            <tr>
                <th>Среден период на зареждане</th>
                <td>$this->averagePeriod (дни)</td>
            </tr>
            <tr>
                <th>Среден разход на гориво</th>
                <td>$this->averageFuelConsumption (литра/100км)</th>
            </tr>
            <tr>
                <th>Средна цена за разстояние</th>
                <td>$this->averagePricePerDistance (лева/км)</th>
            </tr>
        </table>
        HTML;

        $stationOptions = '';
        $uniqueGasStationsArr = array_unique($this->gasStations);
        foreach($uniqueGasStationsArr as $gasStation){
            $stationOptions .= "<option value='$gasStation'>$gasStation</option>";
        }

        $fuelOptions = '';
        $uniqueFuelArr = array_unique($this->gasStationProducts);
        foreach($uniqueFuelArr as $fuel){
            $fuelOptions .= "<option value='$fuel'>$fuel</option>";
        }

    $htmlRefTable3 =<<<HTML
        <section id="report-best-option">
            <h3>Справка най-добра опция</h3>
            <form method="POST">
                <select name="gas_station">
                <option value="Без значение бензиностанция">Без значение бензиностанция</option>
                $stationOptions
            </select>
            <select name="gas_station_product">
                <option value="Без значение нарка гориво">Без значение марка гориво</option>
                $fuelOptions
            </select>
            <select name="driving_type">
                <option value="Без значение вид на шофиране">Без значение вид на шофиране</option>
                <option value="Градско">Градско</option>
                <option value="Извънградско">Извънградско</option>
                <option value="Смесено">Смесено</option>
            </select>
            <input type="submit" name="reportBtn" value="Преизчисли" />
        </form>
        
        <table>
            <tr>
                <th>Среден разход на гориво</th>
                <td>$this->averageFuelConsumptionBest (литри/100 километра)</td>
            </tr>
            <tr>
                <th>Средна цена за разстояние</th>
                <td>$this->averagePricePerDistanceBest (лева/километър)</td>
            </tr>
            <tr>
                <th>Най-нисък разход на гориво</th>
                <td>$this->minFuelConsumption (литри/100 километра)</td>
            </tr>
            <tr>
                <th>Най-ниска цена за разстояние</th>
                <td>$this->minPricePerDistance (лева/километър)</td>
            </tr>
        </table>
        </section>
        HTML;

  echo $htmlRefTable1;
  echo $htmlRefTable2;
  echo $htmlRefTable3;
    }  
}