<?php
# A class for getting snapshots from jamando.fitforecommerce.eu
class JamandoJSONSource
{
  const JSON_URL = 'https://jamando.fitforecommerce.eu/musterdaten/index.json';

  public function json()
  {
    $json = file_get_contents(JamandoJSONSource::JSON_URL);
    return json_decode ($json);
  }
}
?>