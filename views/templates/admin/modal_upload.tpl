  <div class="row">
    <h3><i class="icon icon-cloud-download"></i> {l s='Download Database-Snapshot' mod='prestacollege'}</h3>
    <p><i class="ps-icon ps-icon-upload-to-cloud"></i>{l s='This will download a snapshot file from a custom URL' mod='prestacollege'}</p>
  </div>
  <div class="row">
    <form id="module_form" class="defaultForm form-horizontal"  action="{$form_action_url}" method="post" enctype="multipart/form-data" novalidate="">
      <input type="hidden" name="submitPrestaCollegeModule" value="1">
      <input type="hidden" name="PRESTACOLLEGE_ACTION" value="curl{$curlaction}snapshot">
      <div class="row">
        <label for="snapshotcurlurl" class="control-label col-lg-4">{l s='Enter download url' mod='prestacollege'}</label>
        <div class="col-lg-6">
          <input type="text" name="snapshotcurlurl" >
        </div>
      </div>
      <input type="submit" value="{l s='Download snapshot from url' mod='prestacollege'}" class="btn btn-default pull-right">
    </form>
  </div>