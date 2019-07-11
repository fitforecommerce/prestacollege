<table class="table">
  <thead>
    <tr>
      <th>{l s='Snapshot' mod='prestacollege'}</th>
      <th>{l s='Filesize' mod='prestacollege'}</th>
      <th></th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  {foreach $snapshots as $s}
    <tr>
      <td class="col-lg-9">
         {$s[0]}
      </td>
      <td class="col-lg-1">
        {$s[1]}
      </td>
      <td class="col-lg-1">
        <a href="{$form_action_url}&snapshot={$s[0]}&PRESTACOLLEGE_ACTION=download{$snapshottype}snapshot"><i class="icon icon-arrow-circle-o-down"></i></a> 
        <a href="{$form_action_url}&snapshot={$s[0]}&PRESTACOLLEGE_ACTION=download{$snapshottype}snapshot">{l s='Download'}</a>
      </td>
      <td class="col-lg-1">
        <a href="{$form_action_url}&snapshot={$s[0]}&PRESTACOLLEGE_ACTION=import{$snapshottype}snapshot"><i class="icon icon-arrow-circle-o-up"></i></a> 
        <a href="{$form_action_url}&snapshot={$s[0]}&PRESTACOLLEGE_ACTION=import{$snapshottype}snapshot" onclick="if (confirm('{l s='Import snapshot %s?' sprintf=$s[0] mod='prestacollege'}')) { return true; } else { event.stopPropagation(); event.preventDefault(); } ;">{l s='Import' mod='prestacollege'}</a>
      </td>
    </tr>
  {/foreach}
  </tbody>
</table>
