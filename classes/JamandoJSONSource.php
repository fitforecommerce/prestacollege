<?php
# A class for getting snapshots from jamando.fitforecommerce.eu
class JamandoJSONSource
{
  const JSON_URL = 'https://jamando.fitforecommerce.eu/musterdaten/index.json';
  # const JSON_URL = 'http://localhost:4000/musterdaten/index.json';

  public function json()
  {
    $json = file_get_contents(JamandoJSONSource::JSON_URL);
    return json_decode ($json);
  }
  public function curl_urls()
  {
    $project = Tools::getValue('project');
    $build = Tools::getValue('build');
    $json = $this->json();
    $rv = array('db' => '', 'files' => '');

    foreach ($json as $release) {
      if($release->project==$project && $release->buildnumber==$build) {
        if(isset($release->snapshot_db_url)) {
          $rv['db'] = $release->snapshot_db_url;
        }
        if(isset($release->snapshot_files_url)) {
          $rv['files'] = $release->snapshot_files_url;
        }
      }
    }
    return $rv;
  }
}
?>