<div class="moduleconfig-content">
  <hr>
  <div class="row">
    <h2>{l s='Import Database-Snapshot' mod='PrestaCollege'}</h2>
    <p>This action imports a snapshot created by PrestaCollege. This will <strong>OVERWRITE</strong> most of the data in the database!<br><strong>PLEASE USE WITH CAUTION!</strong></p>
  </div>
  <div class="row">
    <form id="module_form" class="defaultForm form-horizontal"  action="{$form_action_url}" method="post" enctype="multipart/form-data" novalidate="">
      <input type="hidden" name="submitPrestaCollegeModule" value="1">
      <input type="hidden" name="PRESTACOLLEGE_ACTION" value="importdbsnapshot">
      <div class="row">
        <label for="dbsnapshotname" class="control-label col-lg-4">{l s='Select database snapshot' mod='PrestaCollege'}</label>
        <div class="col-lg-6">
          <select name="dbsnapshotname">
            {foreach $importdbsnapshots as $dbfp}
            <option value="{$dbfp}">{$dbfp}</option>
            {/foreach}
          </select>
        </div>
      </div>
      <input type="submit" value="Import database snapshot" class="btn btn-default pull-right">
    </form>
  </div>

  <div class="row">
    <h2>{l s='Export Database-Snapshot' mod='PrestaCollege'}</h2>
    <p>{l s='This creates a snapshot which can be easily imported into other instances of Prestashop'}</p>
  </div>
  <div class="row">
    <form id="module_form" class="defaultForm form-horizontal"  action="{$form_action_url}" method="post" enctype="multipart/form-data" novalidate="">
      <input type="hidden" name="submitPrestaCollegeModule" value="1">
      <input type="hidden" name="PRESTACOLLEGE_ACTION" value="createdbsnapshot">
      <input type="submit" value="Create database snapshot" class="btn btn-default pull-right">
    </form>
  </div>  
</div>
