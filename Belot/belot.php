<?php

/*
1. Опишете тесте от 52 карти в асоциативен или индексиран масив
(индекс => карта - например 0 => ‘AC’ - ace of clubs)
	A - Ace
	J - Jacks
	Q - queen
	K - king
	C - Clubs :clubs:
	D - Diamonds :diamonds:
	H - Hearts :hearts:
	S - Spades :spades:
2. Вземете картите, нужни за играта Белот в отделен масив
	* това са картите след 7 т.е. (7, 8, 9, 10, J, Q, K, A)
3. Разбъркайте картите в тестето за Белот
4. Раздайте картите на 4 играчи (в индексиран масив), като раздавате на всеки по 3 карти, после 2 и после пак 3.
5. Покажете резултатите от всяка стъпка посредством print_r();
*/


// creating the deck using associative array

// for reference: J => 11, Q => 12, K => 13, A => 14

$my_card_deck = [ 0 => "2C", 1 => "3C", 2 => "4C", 3 => "5C", 4 => "6C", 5 => "7C", 6 => "8C", 
                  7 => "9C", 8 => "10C", 9 => "11C", 10 => "12C", 11 => "13C", 12 => "14C",
                  13 => "2D", 14 => "3D", 15 => "4D", 16 => "5D", 17 => "6D", 18 => "7D", 19 => "8D",
                  20 => "9D", 21 => "10D", 22 => "11D", 23 => "12D", 24 => "13D", 25 => "14D",
                  26 => "2H", 27 => "3H", 28 => "4H", 29 => "5H", 30 => "6H", 31 => "7H", 32 => "8H",
                  33 => "9H", 34 => "10H", 35 => "11H", 36 => "12H", 37 => "13H", 38 => "14H",
                  39 => "2S", 40 => "3S", 41 => "4S", 42 => "5S", 43 => "6S", 44 => "7S", 45 => "8S",
                  46 => "9S", 47 => "10S", 48 => "11S", 49 => "12S", 50 => "13S", 51 => "14S"
];



// assigning the play cards to a new array

$my_play_deck = [];

foreach($my_card_deck as $card_key => $card_value) {

    if($card_value[0] > '6' || $card_value[0] == '1' ) {
        $my_play_deck[$card_key] = $card_value;
    }
}




// shuffling the new array

shuffle_play_deck($my_play_deck);


function shuffle_play_deck(&$arr_deck) {

    $temp_arr = [];
    $card_keys = array_keys($arr_deck);

    shuffle($card_keys);

    foreach($card_keys as $key) {
        
        $temp_arr[$key] = $arr_deck[$key];
        unset($arr_deck[$key]);

    }

    $arr_deck = $temp_arr;
}



// dealing the card to Rumqna, Vasil, Stoqnka, Krasi

$players = [
    $rumqna = [],
    $vasil = [],
    $stoqnka = [],
    $krasi = []
];



echo "<br><br>";

deal_to_players($my_play_deck);
show_score($players, count($players[0]));



function deal_to_players($deck) {


    global $players;

    $counter = 0;


    $pl_names = ["Rumqna", "Vasil", "Stoqnka", "Krasi"];


    $three_card_deal = 3;
    $two_card_deal = 2;
    
    $size_pl = count($players);

    $deck_vals_arr = array_values($deck);



    // array with the dealing params
    $dealing = [3, 2, 3];


    //dealing the cards
    foreach($dealing as $deal) {


        for($i = 0; $i < $size_pl; $i++) {
            
            for($j = 0; $j < $deal; $j++) {
    
                array_push($players[$i], array_shift($deck_vals_arr));         
    
            }

        }

    }    


    // showing the hands and if there are any bonus points
    for($i = 0; $i < $size_pl; $i++) {

        echo "<h4>Name: " . $pl_names[$i] . "</h4><br>";

        for($j = 0; $j < count($players[0]); $j++) {
            
            echo $players[$i][$j] . " ";

        }


        echo "<br><br>";
    }

}



function show_score($players, $size_p) {

    // size of the cards in the player`s hand
    $size_cards = $players[0];

    // to hold the card`s chars as an array
    $current_hand_expl = '';

    
    // temp array to hold the playr`s hand with the colors
    $temp_hand = [
        $rumqna_h = [],
        $vasil_h = [],
        $stoqnka_h = [],
        $krasi_h = []
    ];


    // 
    for($i = 0; $i < $size_p; $i++) {

        for($j = 0; $j < $size_cards; $j++) {

            $current_hand_expl = preg_split('/(\d+)/', $players[$i][$j]);

            $temp_hand[$i][$j] = $current_hand_expl[0];
            $temp_hand[$current_hand_expl[0]] = $current_hand_expl[1];

        }
    }

    foreach($temp_hand as $pl => $card) {
        echo '<h2>' . $pl . ' ' . $card . '</h2>';
        echo "<br/>";
    }

}


?>