<?php

/*Генериране на регулярен израз за числа в диапазон.

Да се състави програма, която генерира примерен регулярен израз, чрез който да се провери дали даден стринг представлява цяло число, 
което е:

а) по-голямо или равно на N.
б) по-малко или равно на N.
в) попада в диапазон N >= min и N <= max
г) добавете флаг към вашата функция за генериране, чрез който да може да се включва или изключват  граничните стойности 
(например при False: X > N  или при True: X >= N)

Пример:

Входно число N=176 (търсим string match на числа >= от 176)
Изходен регулярен израз: '/(17[6-9]|1[89][0-9]|[2-9][0-9]{2}|[1-9][0-9]{3,})/'
                       
Пдсказка:
Тъй като в регулярните изрази няма числени сравнения е нужно да се проверят всички възможни групи. 

всички стойности до достигане на следващата десетица 
176..179	-> RE: 17[6-9]

всички стойности до достигане на следващата стотица
180..199 	-> RE: 1[89][0-9]

всички сотйности до достигане на следващата хиляда
200..999	-> RE: [2-9][0-9]{2}*/
?>

<form action="" method="post">
    <label for="name">Check your numbers:</label><br/>
    <input type="text" name="number1" id="name1" ><br/>
    <input type="submit" name="submit">
</form>

<?php
 
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['submit'])){
        $num = $_POST['number1'];
        $numString = strval($num);
        $numLength = strlen($numString);
        
        $regExGroups = [];
        
        function getRepeatForIndex($index, $isLast) {
            if($index === 0) return "";
            if($index === 1) return "[0-9]";
            $max = $isLast;
            return "{".$index."}$|^"."[0-9]";
        }
        
        function getGroupForIndex($numString, $index, $revIndex) {
            $value = intval($numString[$revIndex]);
            $nextValue = $index === 0 ? $value : $value - 1;
            $group = $nextValue === 0 ? "[0-9]" : "[0-".$nextValue."]";
            $isLastIndex = $index === strlen($numString);
            $groupRepeat = getRepeatForIndex($index, $isLastIndex)."$";
            
            return $group.$groupRepeat;
        }
        
        for($index=0; $index<=$numLength-1; $index++){
            $revIndex = ($numLength-1)-$index;
            $group = getGroupForIndex($numString, $index, $revIndex);
            $regExGroups[] ="^". substr_replace($numString, $group, $revIndex, $index+1);
        }
        
        echo implode("|",$regExGroups);
    }
}