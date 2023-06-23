<?php

class HTML {

    public function show_html_head() {
        echo <<<HTML
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Добави запис</title>
        </head>
        <body>
        HTML;
    }

    public function show_html_refuel_ref() {
        echo <<<HTML
        <hr>
        <section id="menu">
            <form method="POST" action="">
                <input type="submit" name="refuel_btn" value="Зареждане" /> | <input type="submit" name="ref_btn" value="Справка" />
            </form>
        </section>
        <hr/>
        HTML;
    }

    public function show_ref_table1() {
        echo <<<HTML
        
        <section>
            <form method="POST" action="">
                <div>
                    <input type="submit" name="show_add_tbl_btn" value="Добави"/>
                </div>
            </form>
        </section>
        <section id="refuel">
            <form method="POST" action="index.php">
                <table border="1">
                    <tr>
                        <th>Дата</th>
                        <th>Изминато разстояние</th>
                        <th>Общи километри</th>
                        <th>Заредени литри</th>
                        <th>Цена на литър</th>
                        <th>Обща сума</th>
                        <th>Бензиностанция</th>
                        <th>Марка гориво</th>
                        <th>Вид на шофиране</th>
                        <th>Действие</th>
                    </tr>
        HTML;
    }

    public function show_ref_form() {
        
        echo <<<HTML
    
            </table>
            </form>
        </section>
        <hr/>

        <section id="refuel_add">
        <form method="POST" action="index.php">
            <table border="1">
            <tr>
                <th>Дата</th>
                <td><input type="date" name="event_date" placeholder="Дата" value="" required/></th>
            </tr>
            <tr>
                <th>Изминато разстояние</th>
                <td><input type="number" name="event_distance" placeholder="километри" required/></th>
            </tr>
            <tr>
                <th>Общо изминато разстояние</th>
                <td><input type="number" name="global_distance" placeholder="километри" required/></th>
            </tr>
            <tr>
                <th>Заредени литри</th>
                <td><input type="number" name="fuel_quantity" placeholder="литри" required/></th>
            </tr>
            <tr>
                <th>Цена на литър</th>
                <td><input type="text" name="fuel_amount" placeholder="цена" required/></th>
            </tr>
            <tr>
                <th>Обща сума</th>
                <td><input type="number" name="total_price" placeholder="Обща сума" required/></th>
            </tr>
            <tr>
                <th>Марка гориво</th>
                <td><input type="text" name="gas_station_product" placeholder="Марка гориво" required/></th>
            </tr>
            <tr>
                <th>Бензиностанция</th>
                <td><input type="text" name="gas_station_name" placeholder="Бензиностанция" required/></th>
            </tr>
            <tr>
                <th>Вид на шофиране</th>
                <td>
                    <select name="driving_type">
                        <option value="Без значение">Без значение</option>
                        <option value="Градско">Градско</option>
                        <option value="Извънградско">Извънградско</option>
                        <option value="Смесено">Смесено</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="right">
                    <input type="submit" name="saveBtn" value="Запис" /> 
                </td>
            </tr>
            </table>
        </form>
        </section>
        HTML;
    }

    public function show_html_footer() {
        echo <<<HTML
        </body>
        </html>
        HTML;
    }
}