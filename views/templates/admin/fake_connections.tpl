	<div class="row">
      <h3><i class="icon-cogs"></i> {l s='Fake Connections' mod='prestacollege'}</h3>
		<div class="form-wrapper">
      <form id="db_snapshot_form" class="defaultForm form-horizontal"  action="{$form_action_url}" method="post" enctype="multipart/form-data" novalidate="">
        <input type="hidden" name="submitPrestaCollegeModule" value="1">
        <input type="hidden" name="PRESTACOLLEGE_ACTION" value="fakeconnections">
        {foreach $connfaker_def as $k => $v}
          {if $k == 'localization'}
            {continue}
          {/if}
            <div class="form-group">
                <label class="control-label col-lg-4">{$connfaker_labels[$k]}</label>
                <div class="col-lg-4">
                  <input type="text" name="{$k}" id="{$k}" value="{$v}">
                </div>
            </div>
        {/foreach}
        <div class="">
          <input type="submit" value="{l s='Go' mod='prestacollege'}" class="btn btn-default pull-right">
        </div>
      </form>
		</div>
	</div>