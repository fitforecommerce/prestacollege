<div class="panel col-lg-12 moduleconfig-content">
  <div class="row">
    <h3><i class="material-icons">backup</i> {l s='Administer Database Snapshots' mod='prestacollege'}</h3>
    <p>{l s='This action imports a snapshot created by PrestaCollege. This will OVERWRITE most of the data in the database!' mod='prestacollege'}<br><strong>{l s='PLEASE USE WITH CAUTION!' mod='prestacollege'}</strong></p>
  </div>
  <div class="row">
      <div class="row">
        <div>
          {assign var="snapshottype" value="db"}
          {assign var="snapshots" value=$importdbsnapshots}
          {include file="$tpl_dir/snapshottable.tpl"}
        </div>
      </div>
    </form>

    <div class="row text-right">
      <a class="btn btn-primary" href="{$form_action_url}&PRESTACOLLEGE_ACTION=createdbsnapshot" title="">
        <i class="material-icons">note_add</i>
        {l s='Create database snapshot' mod='prestacollege'}
      </a>
      <a class="btn btn-primary" href="{$form_action_url}&PRESTACOLLEGE_ACTION=uploaddbsnapshotselect" title="">
        <i class="material-icons">cloud_upload</i>
        {l s='Upload database snapshot' mod='prestacollege'}
      </a>
    </div>
  </div>
</div>