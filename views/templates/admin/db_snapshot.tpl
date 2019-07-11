<div class="panel col-lg-12 moduleconfig-content">
  <div class="row">
    <h3><i class="icon icon-arrow-circle-o-up"></i> {l s='Import Database-Snapshot' mod='prestacollege'}</h3>
    <p>{l s='This action imports a snapshot created by PrestaCollege. This will OVERWRITE most of the data in the database!' mod='prestacollege'}<br><strong>{l s='PLEASE USE WITH CAUTION!' mod='prestacollege'}</strong></p>
  </div>
  <div class="row">
      <div class="row">
        <div>
          <table class="table">
            <thead>
              <tr>
                <th>Datenbank-Snapshot</th>
                <th></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            {foreach $importdbsnapshots as $dbfp}
              <tr>
                <td class="col-lg-10">
                   {$dbfp}
                </td>
                <td class="col-lg-1">
                  <a href="{$form_action_url}&snapshot={$dbfp}&PRESTACOLLEGE_ACTION=downloaddbsnapshot"><i class="icon icon-arrow-circle-o-down"></i></a> 
                  <a href="{$form_action_url}&snapshot={$dbfp}&PRESTACOLLEGE_ACTION=downloaddbsnapshot">{l s='Download'}</a>
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
      </div>
    </form>
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