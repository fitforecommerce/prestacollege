<hr>

<div class="moduleconfig-content">
	<div class="row">
		<div class="col-xs-12">
      <h2>{l s='Fake Customers' mod='prestacollege'}</h2>
      <form id="db_snapshot_form" class="defaultForm form-horizontal"  action="{$form_action_url}" method="post" enctype="multipart/form-data" novalidate="">
        <input type="hidden" name="submitPrestaCollegeModule" value="1">
        <input type="hidden" name="PRESTACOLLEGE_ACTION" value="fakecustomers">
        <div class="input-group">
          <span class="input-group-addon">{l s='Number of customers' mod='prestacollege'}</span>
            <input type="text" name="fake_customers_number" id="fake_customers_number" value="10">
        </div>
        <div class="panel-footer">
          <input type="submit" value="{l s='Go' mod='prestacollege'}" class="btn btn-default pull-right">
        </div>
      </form>
		</div>
	</div>
</div>
