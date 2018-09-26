<div class="moduleconfig-content">
  <hr>
  <div class="row">
    <h2>{l s='Import File-Snapshot' mod='PrestaCollege'}</h2>
    <p>{l s='This action imports a file snapshot created with PrestaCollege. Use with CAUTION as this will OVERWRITE YOUR DATA in some folders.' mod='PrestaCollege'}</p>
  </div>
  <div class="row">
    <form id="module_form" class="defaultForm form-horizontal"  action="{$form_action_url}" method="post" enctype="multipart/form-data" novalidate="">
      <input type="hidden" name="submitPrestaCollegeModule" value="1">
      <input type="hidden" name="PRESTACOLLEGE_ACTION" value="importfilesnapshot">
      <div class="row">
        <label for="filesnapshotname" class="control-label col-lg-4">{l s='Select files snapshot' mod='PrestaCollege'}</label>
        <div class="col-lg-6">
          <select name="filesnapshotname">
            {foreach $importfilesnapshots as $dbfp}
            <option value="{$dbfp}">{$dbfp}</option>
            {/foreach}
          </select>
        </div>
      </div>
      <input type="submit" value="Import file snapshot" class="btn btn-default pull-right">
    </form>
  </div>
</div>

<div class="row">
  <h2>{l s='Export File-Snapshot' mod='PrestaCollege'}</h2>
  <p>{l s='This action exports a snapshot of the most important folders of your Prestashop installation.' mod='PrestaCollege'}</p>
</div>
<div class="row">
  <form id="module_form" class="defaultForm form-horizontal"  action="{$form_action_url}" method="post" enctype="multipart/form-data" novalidate="">
    <input type="hidden" name="submitPrestaCollegeModule" value="1">
    <input type="hidden" name="PRESTACOLLEGE_ACTION" value="exportfilesnapshot">
    <input type="submit" value="Export file snapshot" class="btn btn-default pull-right">
  </form>
</div>

  <div class="row">
    <h2>{l s='Download File-Snapshot' mod='PrestaCollege'}</h2>
    <p>{l s='This will download a snapshot file from a custom URL'}</p>
  </div>
  <div class="row">
    <form id="module_form" class="defaultForm form-horizontal"  action="{$form_action_url}" method="post" enctype="multipart/form-data" novalidate="">
      <input type="hidden" name="submitPrestaCollegeModule" value="1">
      <input type="hidden" name="PRESTACOLLEGE_ACTION" value="curlfilesnapshot">
      <div class="row">
        <label for="filesnapshotcurlurl" class="control-label col-lg-4">{l s='Enter download url'}</label>
        <div class="col-lg-6">
          <input type="text" name="filesnapshotcurlurl" >
        </div>
      </div>
      <input type="submit" value="Download file snapshot" class="btn btn-default pull-right">
    </form>
  </div>  
