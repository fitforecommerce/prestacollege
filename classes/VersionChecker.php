<?php
/**
 * A class to check if updates are available
 *
 * @author     Martin Kolb <admin@vt-learn.de>
 */

class VersionChecker
{
  public function update_available()
  {
    
    return false;
  }

  public function get_release_data()
  {
    $url = 'https://api.github.com/repos/fitforecommerce/prestacollege/releases';
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($curl);
    return json_decode($response);
  }
} // END class VersionChecker
?>