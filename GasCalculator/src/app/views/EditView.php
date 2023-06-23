<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Промени запис</title>
</head>
<body>

<h1>Промени записa</h1>

    <?php 

        session_start();

        require_once '..\models\RefEditModel.php';
        $refEditModel = new RefEditModel();

        $date;
        $distance;
        $total_distance;
        $fuel_quantity;
        $fuel_amount;
        $total_price;
        $gas_station_product;
        $gas_station_name;
        $driving_type;

        $id = $_SESSION['id'];

        $refEvents = $refEditModel->open_json_file();

        foreach($refEvents as $refKey => $refVal) {
            foreach($refVal as $event) {
    
                if($event['id'] == $id) {
                    $date = $event['date'];
                    $distance = $event['distance'];
                    $total_distance = $event['total_odo'];
                    $fuel_quantity = $event['fuel_quantity'];
                    $fuel_amount = $event['fuel_amount'];
                    $total_price = $event['total_price'];
                    $gas_station_product = $event['gas_station_product'];
                    $gas_station_name = $event['gas_station_name'];
                    $driving_type = $event['driving_type'];

                    break;
                }
            }
        }

        $refEditModel->save_edit_data_json();

        if(isset($_POST['backBtn'])) {
            header('location: http://localhost/Codix-codeacademy/homework/Project-gasCalculator/GasCalculator/src/app/index.php');
        }           
        
    ?>

	<section id="refuel_edit">
	    <form method="POST" action="EditView.php">
            <table border="1">
                <tr>
                    <th>Дата</th>
                    <td><input type="text" name="event_date_edit" placeholder="дата" value="<?php echo $date ?>"/></th>
                </tr>
                <tr>
                    <th>Изминато разстояние</th>
                    <td><input type="text" name="event_distance_edit" placeholder="километри" value="<?php echo $distance ?>"/></th>
                </tr>
                <tr>
                    <th>Общо изминато разстояние</th>
                    <td><input type="number" name="global_distance_edit" placeholder="километри" value="<?php echo $total_distance ?>"/></th>
                </tr>
                <tr>
                    <th>Заредени литри</th>
                    <td><input type="number" name="fuel_quantity_edit" placeholder="литри" value="<?php echo $fuel_quantity ?>"/></th>
                </tr>
                <tr>
                    <th>Цена на литър</th>
                    <td><input type="text" name="fuel_amount_edit" placeholder="цена" value="<?php echo $fuel_amount ?>"/></th>
                </tr>
                <tr>
                    <th>Обща сума</th>
                    <td><input type="number" name="total_price_edit" placeholder="Обща сума" value="<?php echo $total_price ?>"/></th>
                </tr>
                <tr>
                    <th>Марка гориво</th>
                    <td><input type="text" name="gas_station_product_edit" placeholder="Марка гориво" value="<?php echo $gas_station_product ?>"/></th>
                </tr>
                <tr>
                    <th>Бензиностанция</th>
                    <td><input type="text" name="gas_station_name_edit" placeholder="Бензиностанция" value="<?php echo $gas_station_name ?>"/></th>
                </tr>
                <tr>
                    <th>Вид на шофиране</th>
                    <td>
                    <select name="driving_type_edit" value="<?php echo $driving_type ?>">
                        <option value="Без значение">Без значение</option>
                        <option value="Градско">Градско</option>
                        <option value="Извънградско">Извънградско</option>
                        <option value="Смесено">Смесено</option>
                    </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="right">
                    <button type="submit" name="saveEditBtn" value="<?php echo $id ?>">Запис</button>
                    <button type="submit" name="backBtn">Назад</button> 
                </td>
                </tr>
            </table>
        </form>
    </section>
</body>
</html>