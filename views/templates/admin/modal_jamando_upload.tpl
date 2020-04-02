  <div class="row">
    <h3><i class="icon icon-cloud-download"></i> {l s='Load a Jamando snapshot' mod='prestacollege'}</h3>
    <p><i class="ps-icon ps-icon-upload-to-cloud"></i>{l s='Load a snapshot from jamando.fitforecommerce.eu to your installation' mod='prestacollege'}</p>
  </div>

  <div class="row">
    {$curproj = ''}
    {foreach $json as $jd}
      {if $jd->project != $curproj}
        {if $curproj != ''}
            </tbody></table>
          </div>
        {/if}
        {$curproj = $jd->project}
        <div class="panel col-lg-12 moduleconfig-content">
          <h3>{$jd->project}</h3>
          <table class="table">
            <thead>
              <tr>
                <th>{l s='Description'}</th>
                <th class='col-lg-1'>{l s='Download'}</th>
              </tr>
            </thead>
            <tbody>
      {/if}
        <tr>
          <td>
            <h4>{$jd->buildnumber}</h4>
            <p>{$jd->description}</p>
            <p>
            <span class='col-lg-4'>
              <strong>{l s='Contains' mod='prestacollege'}: </strong>
              {if isset($jd->snapshot_db_url)}
                {l s='Database snapshot' mod='prestacollege'}
              {/if} 
              {if isset($jd->snapshot_files_url)}
                {l s='File snapshot' mod='prestacollege'}
              {/if}
            </span>

            {if $jd->prestashop_version != ''}
              <span class='col-lg-4'><strong>{l s='Tested with' mod='prestacollege'}:</strong> Prestashop {$jd->prestashop_version}</span>
            {/if}
          </td>
          <td class='col-lg-2'>
            {if isset($jd->snapshot_db_url)}
            <p>
              <a href="{$form_action_url}&PRESTACOLLEGE_ACTION=curljamandosnapshot&project={$jd->project}&build={$jd->buildnumber}&curldb=1" title="">
                <i class="icon icon-arrow-circle-o-down"></i> {l s='Download' mod='prestacollege'} {l s="database snapshot" mod='prestacollege'}
              </a>
            </p>
            {/if} 
            {if isset($jd->snapshot_files_url)}
            <p>
              <a href="{$form_action_url}&PRESTACOLLEGE_ACTION=curljamandosnapshot&project={$jd->project}&build={$jd->buildnumber}&curlfile=1" title="">
                <i class="icon icon-arrow-circle-o-down"></i> {l s='Download' mod='prestacollege'} {l s="file snapshot" mod='prestacollege'}
              </a>
            </p>
            {/if}
            {if isset($jd->snapshot_db_url) && isset($jd->snapshot_files_url)}
            <p>
              <a href="{$form_action_url}&PRESTACOLLEGE_ACTION=curljamandosnapshot&project={$jd->project}&build={$jd->buildnumber}" title="">
                <i class="icon icon-arrow-circle-o-down"></i> {l s='Download both snapshots' mod='prestacollege'}
              </a>
            </p>
            {/if}
          </td>
        </tr>
    {/foreach}
      </tbody></table>
    </div>
  </div>