<?php

function SetSelectForm($name_elements, $day_today, $n_max, $n_min = 1){

  echo '<select class="select_date_'.$name_elements.'" name="'.$name_elements.'" style="width:70px; margin-left: ">';
    for($n = $n_min; $n <= $n_max; $n++){
      if($n == $day_today){
    echo '<option value='.$n.' selected>'.$n.'</option>';
   } else {
    echo '<option value='.$n.'>'.$n.'</option>';
    }}
  echo '</select>';
}
