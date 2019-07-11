<div class="panel col-lg-12 moduleconfig-content">
  <div class="row">
    <h3><i class="material-icons">attach_file</i> {l s='Administrate File-Snapshots' mod='prestacollege'}</h2>
    <p>{l s='This action imports a file snapshot created with PrestaCollege. Use with CAUTION as this will OVERWRITE YOUR DATA in some folders.' mod='prestacollege'}</p>
  </div>
  <div class="row">
      <div class="row">
        <div>
          <div>
            {assign var="snapshottype" value="file"}
          {assign var="snapshots" value=$importfilesnapshots}
            {include file="$tpl_dir/snapshottable.tpl"}
          </div>
        </div>
  </div>
  <div class="row text-right">
    <a class="btn btn-primary" href="{$form_action_url}&PRESTACOLLEGE_ACTION=createfilesnapshot" title="">
      <i class="material-icons">note_add</i>
      {l s='Create file snapshot' mod='prestacollege'}
    </a>
    <a class="btn btn-primary" href="{$form_action_url}&PRESTACOLLEGE_ACTION=uploadfilesnapshotselect" title="">
      <i class="material-icons">cloud_upload</i>
      {l s='Upload file snapshot' mod='prestacollege'}
    </a>
  </div>
</div>
