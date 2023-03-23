<?php

namespace App\Config;

class Library {
	// CUSTOM METHODS

	public static function generateKey(int $lenght = 8): string
	{
		return bin2hex(random_bytes($lenght));
	} 

  // Create a profile image banner
  public static function getImage($text = false) {
    $color = "rgb(".rand(0, 255).",".rand(0, 255).",".rand(0, 255).")";
    
    $dislayText = $text ? '<div class="alt-profile clr-bg"><h3>'.$text.'</h3></div>' : '<div class="alt clr-bg"><h4>IMAGE</h4><span>'.$color.'</span></div>';
    $image = '<div class="box-image flex" style="--color: '.$color.'">'.$dislayText.'</div>';
    return $image;
  }

  // Date Fromater
  public static function get_date_time($date, $format = '') {

    /*
     * Date FORMART
     * -> normal   show actual date
     * -> interval Show time interval
     *
     */
    if(!$date) return 'Pending...';

      $cur = time() - $date;
      $D = $cur / 86400;
      $H = $cur / 3600;
      $M = $cur / 60;

      if($format == "normal") {
        $date = date('M d y', $date);
        return $date;
      }

      $year = 365;

      // Getting Years
      if($D > $year) {
        $Y = floor($D/$year);
        if($Y < 2){
          $int = '1'.' year';
        }else {
          $int = $Y.' years ';
        }
        $fin = $int." ago";
      }

      // Getting Months
      elseif($D > 30) {
        $Mon = floor($D/30);
        if($Mon < 2){
          $int = '1'.' month';
        }else {
          $int = $Mon.' months ';
        }
        $fin = $int." ago";
      }
      // Getting Weeks
      elseif($D > 7) {
        $W = floor($D/7);
        if($W < 2){
          $int = '1'.' week';
        }else {
          $int = $W.' weeks ';
        }
        $fin = $int." ago";
      }

      // Getting Days
      elseif($H > 24) {
        if($D < 2){
          $int = '1'.' day ';
        }else {
          $int = floor($D).' days';
        }
        $fin = $int." ago";
      }

      // Getting Hours
      elseif($M >= 60 && $H < 24){
        if($H < 2){
          $int = '1'.' hr';
        }else {
          $int = floor($H).' hrs';
        }
        $fin = $int.' ago';
      }

      // Getting Minutes
      elseif($M < 60 && $M >= 1){
        if($M < 2){
          $int = '1'.' min';
        }else {
          $int = ceil($M).' mins';
        }
        $fin = $int.' ago';
      }

      // Getting Seconds
      elseif($cur < 60){
        if($cur < 2){
          $int = '1'.' second';
        }else {
          $int = ceil($cur).' seconds';
        }
        $fin = $int.' ago';
      }

      return $fin;
  }
}