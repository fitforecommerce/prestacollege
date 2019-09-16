
<div class="row">
	<div class="col-xs-12">
    <h3><i class="icon-cart-plus"></i> {l s='Fake Carts' mod='prestacollege'}</h3>
    <form id="db_snapshot_form" class="defaultForm form-horizontal"  action="{$form_action_url}" method="post" enctype="multipart/form-data" novalidate="">
      <input type="hidden" name="submitPrestaCollegeModule" value="1">
      <input type="hidden" name="PRESTACOLLEGE_ACTION" value="fakecarts">

      <div class="form-group">
          <label class="control-label col-lg-4">{l s='Number of carts' mod='prestacollege'}</label>
          <div class="col-lg-4">
            <input type="text" name="fake_carts_number" id="fake_carts_number" value="10">
          </div>
      </div>
      
      <div class="panel-footer">
        <input type="submit" value="{l s='Go' mod='prestacollege'}" class="btn btn-default pull-right">
      </div>
    </form>
	</div>
</div>