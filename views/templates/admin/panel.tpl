<div class="panel" id="prestacollege-panel">
	<div class="row moduleconfig-header">
		<div class="col-xs-5 text-right">
			<img src="{$module_dir|escape:'html':'UTF-8'}views/img/prestacollege_icon@0,5x.png" style="width: 10.0em;"/>
		</div>
		<div class="col-xs-7 text-left">
			<h2>{l s='PrestaCollege' mod='prestacollege'}</h2>
			<h4>{l s='A module for classroom use of Prestashop - Created by Martin Kolb' mod='prestacollege'}</h4>
		</div>
	</div>
</div>
<div class="panel col-lg-12 moduleconfig-content">
	<div class="row">
		<div class="col-xs-12">
      <h2>{l s='Fake Data' mod='prestacollege'}</h2>
    </div>
    <div class="panel col-lg-12 moduleconfig-content">
      {include file="$tpl_dir/fake_customers.tpl"}
      {include file="$tpl_dir/fake_carts.tpl"}
    </div>
  </div>
</div>
<div class="panel col-lg-12 moduleconfig-content">
  {include file="$tpl_dir/db_snapshot.tpl"}
</div>
<div class="panel col-lg-12 moduleconfig-content">
  {include file="$tpl_dir/file_snapshot.tpl"}
</div>
