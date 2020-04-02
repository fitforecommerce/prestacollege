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
    <div class="panel col-lg-3 moduleconfig-content">
      <h2>{l s='Fake Data' mod='prestacollege'}</h2>
      <ul class="list-group">
        <li class="list-group-item">
          <a class="btn " href="{$form_action_url}&PRESTACOLLEGE_ACTION=fake_customers_form">
            <i class="material-icons">person_add</i> 
            {l s='Fake Customers' mod='prestacollege'}
          </a>
        </li>
        <li class="list-group-item">
          <a class="btn " href="{$form_action_url}&PRESTACOLLEGE_ACTION=fake_carts_form">
            <i class="material-icons">add_shopping_cart</i> 
            {l s='Fake Carts' mod='prestacollege'}
          </a>
        </li>
        <li class="list-group-item">
          <a class="btn " href="{$form_action_url}&PRESTACOLLEGE_ACTION=fake_connections_form">
            <i class="material-icons">compare_arrows</i>  
            {l s='Fake Connections' mod='prestacollege'}
          </a>
        </li>
      </ul>
    </div>
    <div class="panel col-lg-3 col-lg-offset-1 moduleconfig-content">
      <h2>{l s='Jamando' mod='prestacollege'}</h2>
      <ul class="list-group">
        <li class="list-group-item">
          <a class="btn " href="{$form_action_url}&PRESTACOLLEGE_ACTION=loaddbjamandosnapshot" title="">
            <i class="material-icons">cloud_download</i>
            {l s='Get Jamando snapshot' mod='prestacollege'}
          </a>
        </li>
      </ul>
    </div>
    <div class="panel col-lg-3  col-lg-offset-1 moduleconfig-content">
      <h2>{l s='Administer Snapshots' mod='prestacollege'}</h2>
      <ul class="list-group">
        <li class="list-group-item">
          <a class="btn " href="{$form_action_url}&PRESTACOLLEGE_ACTION=administer_dbsnapshots">
            <i class="material-icons">note_add</i> 
            {l s='Administer Database Snapshots' mod='prestacollege'}</a>
        </li>
        <li class="list-group-item">
          <a class="btn " href="{$form_action_url}&PRESTACOLLEGE_ACTION=administer_filesnapshots">
            <i class="material-icons">insert_drive_file</i>
            {l s='Administer File Snapshots' mod='prestacollege'}
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>
