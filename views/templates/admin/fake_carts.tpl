
<div class="row">
	<div class="col-xs-12">
    <h3><i class="icon-cart-plus"></i> {l s='Fake Carts' mod='prestacollege'}</h3>
    <form id="db_snapshot_form" class="defaultForm form-horizontal"  action="{$form_action_url}" method="post" enctype="multipart/form-data" novalidate="">
      <input type="hidden" name="submitPrestaCollegeModule" value="1">
      <input type="hidden" name="PRESTACOLLEGE_ACTION" value="fakecarts">

      {foreach $cartfaker_def as $k => $v}
        {if $k == 'localization'}
          {continue}
        {/if}
          <div class="form-group">
              <label class="control-label col-lg-4">{$cartfaker_labels[$k]}</label>
              <div class="col-lg-4">
                <input type="text" name="{$k}" id="{$k}" value="{$v}">
              </div>
          </div>
      {/foreach}

      <div class="panel-footer">
        <input type="submit" value="{l s='Go' mod='prestacollege'}" class="btn btn-default pull-right">
      </div>
    </form>
	</div>
</div>