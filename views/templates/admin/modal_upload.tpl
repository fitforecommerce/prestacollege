  <div class="row">
    <h3><i class="icon icon-cloud-download"></i> {l s='Upload snapshot from url' mod='prestacollege'}</h3>
    <p><i class="ps-icon ps-icon-upload-to-cloud"></i>{l s='This will upload a snapshot file from a custom URL to your server' mod='prestacollege'}</p>
  </div>
  <div class="row">
    <form id="curlsnapshotform" class="defaultForm form-horizontal"  action="{$form_action_url}" method="post" enctype="multipart/form-data" novalidate="">
      <input type="hidden" name="submitPrestaCollegeModule" value="1">
      <input type="hidden" name="PRESTACOLLEGE_ACTION" value="curl{$curlaction}snapshot">
      <div class="row">
        <label for="snapshotcurlurl" class="control-label col-lg-2">{l s='Enter download url' mod='prestacollege'}</label>
        <div class="col-lg-10">
          <input type="text" name="snapshotcurlurl" >
        </div>
      </div>
      <input type="submit" value="{l s='Download snapshot from url' mod='prestacollege'}" class="btn btn-default pull-right">
    </form>
  </div>
  
  <div class="row">
    <h3><i class="icon icon-cloud-upload"></i> {l s='Upload snapshot file' mod='prestacollege'}</h3>
    <p><i class="ps-icon ps-icon-upload-to-cloud"></i>{l s='This will upload a snapshot file from your computer to your server' mod='prestacollege'}</p>
  </div>
  <div class="row">
    <form id="uploadsnapshotform" class="defaultForm form-horizontal"  action="{$form_action_url}&PRESTACOLLEGE_ACTION=upload{$curlaction}snapshot" method="post" enctype="multipart/form-data" novalidate="">
      <input type="hidden" name="submitPrestaCollegeModule" value="1">
      <input type="hidden" name="PRESTACOLLEGE_ACTION" value="upload{$curlaction}snapshot">
      <div class="row">
        <label for="snapshotfile" class="control-label col-lg-2">{l s='Choose snapshot file' mod='prestacollege'}</label>
        <div class="col-lg-10">
          <input type="file" name="snapshotfile" >
          <input type="hidden" name="MAX_FILE_SIZE" value="{$max_upload_size}" />
        </div>
      </div>
      <input type="submit" value="{l s='Download snapshot from url' mod='prestacollege'}" class="btn btn-default pull-right">
    </form>
  </div>