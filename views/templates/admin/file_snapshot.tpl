<div class="panel col-lg-12 moduleconfig-content">
  <div class="row">
    <h3><i class="icon icon-arrow-circle-o-up"></i> {l s='Import File-Snapshot' mod='prestacollege'}</h2>
    <p>{l s='This action imports a file snapshot created with PrestaCollege. Use with CAUTION as this will OVERWRITE YOUR DATA in some folders.' mod='prestacollege'}</p>
  </div>
  <div class="row">
      <div class="row">
        <div>
          <table class="table">
            <thead>
              <tr>
                <th>{l s='Database Snapshot' mod='prestacollege'}</th>
                <th></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            {foreach $importfilesnapshots as $dbfp}
              <tr>
                <td class="col-lg-10">
                   {$dbfp}
                </td>
                <td class="col-lg-1">
                  <a href="{$form_action_url}&snapshot={$dbfp}&PRESTACOLLEGE_ACTION=downloadfilesnapshot"><i class="icon icon-arrow-circle-o-down"></i></a> 
                  <a href="{$form_action_url}&snapshot={$dbfp}&PRESTACOLLEGE_ACTION=downloadfilesnapshot">{l s='Download'}</a>
                </td>
                <td class="col-lg-1">
                  <a href="#"><i class="icon icon-arrow-circle-o-up"></i></a> 
                  <a href="#">{l s='Import' mod='prestacollege'}</a>
                </td>
              </tr>
            {/foreach}
            </tbody>
          </table>
        </div>
      <input type="submit" value="Import file snapshot" class="btn btn-default pull-right">
    </form>
  </div>
  <div class="row">
    <h3><i class="icon icon icon-share-sign"></i> {l s='Export File-Snapshot' mod='prestacollege'}</h3>
    <p>{l s='This action exports a snapshot of the most important folders of your Prestashop installation.' mod='prestacollege'}</p>
  </div>
  <div class="row">
    <form id="module_form" class="defaultForm form-horizontal"  action="{$form_action_url}" method="post" enctype="multipart/form-data" novalidate="">
      <input type="hidden" name="submitPrestaCollegeModule" value="1">
      <input type="hidden" name="PRESTACOLLEGE_ACTION" value="exportfilesnapshot">
      <input type="submit" value="Export file snapshot" class="btn btn-default pull-right">
    </form>
  </div>

  <div class="row">
    <h3><i class="icon icon-cloud-download"></i> {l s='Download File-Snapshot' mod='prestacollege'}</h3>
    <p>{l s='This will download a snapshot file from a custom URL' mod='prestacollege'}</p>
  </div>
  <div class="row">
    <form id="module_form" class="defaultForm form-horizontal"  action="{$form_action_url}" method="post" enctype="multipart/form-data" novalidate="">
      <input type="hidden" name="submitPrestaCollegeModule" value="1">
      <input type="hidden" name="PRESTACOLLEGE_ACTION" value="curlfilesnapshot">
      <div class="row">
        <label for="filesnapshotcurlurl" class="control-label col-lg-4">{l s='Enter download url' mod='prestacollege'}</label>
        <div class="col-lg-6">
          <input type="text" name="filesnapshotcurlurl" >
        </div>
      </div>
      <input type="submit" value="{l s='Download file snapshot' mod='prestacollege'}" class="btn btn-default pull-right">
    </form>
  </div>
</div>
