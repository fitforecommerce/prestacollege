<div class="panel col-lg-12 moduleconfig-content">
  <div class="row">
    <h3><i class="icon icon-arrow-circle-o-up"></i> {l s='Import Database-Snapshot' mod='prestacollege'}</h3>
    <p>{l s='This action imports a snapshot created by PrestaCollege. This will OVERWRITE most of the data in the database!' mod='prestacollege'}<br><strong>{l s='PLEASE USE WITH CAUTION!' mod='prestacollege'}</strong></p>
  </div>
  <div class="row">
    <form id="module_form" class="defaultForm form-horizontal"  action="{$form_action_url}" method="post" enctype="multipart/form-data" novalidate="">
      <input type="hidden" name="submitPrestaCollegeModule" value="1">
      <input type="hidden" name="PRESTACOLLEGE_ACTION" value="importdbsnapshot">
      <div class="row">
        <label for="dbsnapshotname" class="control-label col-lg-4">{l s='Select database snapshot' mod='prestacollege'}</label>
        <div class="col-lg-6">
          <select name="dbsnapshotname">
            {foreach $importdbsnapshots as $dbfp}
            <option value="{$dbfp}">{$dbfp}</option>
            {/foreach}
          </select>
        </div>
      </div>
      <input type="submit" value="{l s='Import database snapshot' mod='prestacollege'}" class="btn btn-default pull-right">
    </form>
  </div>

  <div class="row">
    <h3><i class="icon icon-share-sign"></i> {l s='Export Database-Snapshot' mod='prestacollege'}</h3>
    <p>{l s='This creates a snapshot which can be easily imported into other instances of Prestashop' mod='prestacollege'}</p>
  </div>
  <div class="row">
    <form id="module_form" class="defaultForm form-horizontal"  action="{$form_action_url}" method="post" enctype="multipart/form-data" novalidate="">
      <input type="hidden" name="submitPrestaCollegeModule" value="1">
      <input type="hidden" name="PRESTACOLLEGE_ACTION" value="createdbsnapshot">
      <input type="submit" value="{l s='Create database snapshot' mod='prestacollege'}" class="btn btn-default pull-right">
    </form>
  </div>  

  <div class="row">
    <h3><i class="icon icon-cloud-download"></i> {l s='Download Database-Snapshot' mod='prestacollege'}</h3>
    <p><i class="ps-icon ps-icon-upload-to-cloud"></i>{l s='This will download a snapshot file from a custom URL' mod='prestacollege'}</p>
  </div>
  <div class="row">
    <form id="module_form" class="defaultForm form-horizontal"  action="{$form_action_url}" method="post" enctype="multipart/form-data" novalidate="">
      <input type="hidden" name="submitPrestaCollegeModule" value="1">
      <input type="hidden" name="PRESTACOLLEGE_ACTION" value="curldbsnapshot">
      <div class="row">
        <label for="dbsnapshotcurlurl" class="control-label col-lg-4">{l s='Enter download url' mod='prestacollege'}</label>
        <div class="col-lg-6">
          <input type="text" name="dbsnapshotcurlurl" >
        </div>
      </div>
      <input type="submit" value="{l s='Download database snapshot' mod='prestacollege'}" class="btn btn-default pull-right">
    </form>
  </div>  
</div>