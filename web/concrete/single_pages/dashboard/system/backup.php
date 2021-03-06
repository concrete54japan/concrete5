<?php 
$ifHelper = Loader::helper('concrete/interface');
?>
<script type="text/javascript">
dNum = 0;
function confirmDelete(strFn) {
   //   var ele = $('#confirmDelete').clone().attr('id','confirmDelete'+dNum);
   //   $('body').append($('#confirmDelete'+dNum)); 
   $('#confirmDelete').clone().attr('id', 'confirmDelete'+dNum).appendTo('body');
   var alink = $('#confirmDelete' + dNum + ' input[name=backup_file]').val(strFn); 
   confirmdlg = $.fn.dialog.open({
            title: '<?php echo t("Are you sure?") ?>',
            'element': $('#confirmDelete' + dNum), 
            width: 300,
            modal: false,
            height: 50
      });   
      dNum++;
}

rNum = 0;
function confirmRestore(strFn) {
   //   var ele = $('#confirmDelete').clone().attr('id','confirmDelete'+rNum);
   //   $('body').append($('#confirmDelete'+rNum)); 
   $('#confirmRestore').clone().attr('id', 'confirmRestore'+rNum).appendTo('body');
   var alink = $('#confirmRestore' + rNum + ' input[name=backup_file]').val(strFn); 
   $('#confirmRestore' + rNum + ' .confirmActionBtn a').attr('href',alink); 
   confirmdlg = $.fn.dialog.open({
            title: '<?php echo t("Are you sure?") ?>',
            'element': $('#confirmRestore' + rNum), 
            width: 300,
            modal: false,
            height: 50
      });   
      rNum++;
}
$(document).ready(function () {
   $('#executeBackup').click( function() { 
      if ($('#useEncryption').is(':checked')) {
         window.location.href = $(this).attr('href')+$('#useEncryption').val();
         return false;
      }
   });


   if ($.cookie('useEncryption') == "1" ) {
      $('#useEncryption').attr('checked','checked');
   }

   $('#useEncryption').change(function() {
      if ($('#useEncryption').is(':checked')) {
         $.cookie('useEncryption','1');
      } else {
         $.cookie('useEncryption','0');

      }
   }); 
});

</script>

<!--Dialog -->
<div id="confirmDelete" style="display:none"><?=t('This action <strong>cannot be undone</strong>. Are you sure?')?>

<div class="ccm-buttons">
<form method="post" action="<?=$this->action('delete_backup')?>">
<input type="hidden" name="backup_file" value="" />
<?=$ifHelper->button_js(t('Cancel'),"$.fn.dialog.close(0)", 'left');?>
<span class="confirmActionBtn">
<?=$ifHelper->submit(t('Delete Backup'),'right');?></span>

</form>
</div> 

</div>

<!-- End of Dialog //-->

<!--Dialog -->
<div id="confirmRestore" style="display:none"><?=t('This action <strong>cannot be undone</strong>. Are you sure?')?>

<div class="ccm-buttons">
<form method="post" action="<?=$this->action('restore_backup')?>">
<input type="hidden" name="backup_file" value="" />
<?=$ifHelper->button_js(t('Cancel'),"$.fn.dialog.close(0)", 'left');?>
<span class="confirmActionBtn">
<?=$ifHelper->submit(t('Restore Backup'),'right');?></span>
</form>
</div> 

</div>

<!-- End of Dialog //-->

<script type="text/javascript">
$(document).ready( function() { 
   $('a.dialog-launch').click( function() {
      $.fn.dialog.open({ href: $(this).attr('href'),modal:false });

      return false;
      
   });
});

</script>

<div style="width: 760px">

<?
$tp = new TaskPermission();
if ($tp->canBackup()) { ?>

<h1><span><?=t('Existing Backups')?></span></h1>
<div class="ccm-dashboard-inner">
<?php 
if (count($backups) > 0) {
?>
<br/>
<table class="grid-list" cellspacing="1" cellpadding="0" border="0">
<tr>
   <td class="subheader"><?=t('Date')?></td>
   <td class="subheader"><?=t('File')?></td>
   <td class="subheader">&nbsp;</td>
   <td class="subheader">&nbsp;</td>
   <td class="subheader">&nbsp;</td>
</tr>
   <?php  foreach ($backups as $arr_bkupInf) { ?>
   <tr> 
      <td style="white-space: nowrap"><?= date(DATE_APP_GENERIC_MDYT_FULL, strtotime($arr_bkupInf['date'])) ?></td>
      <td width="100%"><?= $arr_bkupInf['file'];?></td>
      <td><?=$ifHelper->button_js(t('Download'), 'window.location.href=\'' . $this->action('download', $arr_bkupInf['file']) . '\''); ?></td>
      <td>
      <? print $ifHelper->button_js(t("Restore"),"confirmRestore('" . $arr_bkupInf['file'] . "')"); ?>
      </td>
      <td>
	   <? print $ifHelper->button_js(t("Delete"),"confirmDelete('" . $arr_bkupInf['file'] . "')"); ?>
      </td>
   </tr>
   <? } ?>
</table>
<?php 
} else { ?>
	<p><?=t('You have no backups available.')?></p>
<? } ?>
</div>

<? 
$crypt = Loader::helper('encryption');
?>

<h1><span><?=t('Create New Backup')?></span></h1>
<div class="ccm-dashboard-inner">

<form method="post" action="<?=$this->action('run_backup')?>">
<table border="0" cellspacing="0" cellpadding="0">
<tr>
	<td style="padding-right: 20px">
		<?= $ifHelper->submit(t("Run Backup"))?>
	</td>
	<td>
	<? if ($crypt->isAvailable()) { ?>
		<input type="checkbox" name="useEncryption" id="useEncryption" value="1" />
		<?=t('Use Encryption')?>
	<? } else { ?>
		<input type="checkbox" value="0" disabled />
		<?=t('Use Encryption')?>
	<? } ?>
	</td>
</tr>
</table>
</form>
	<br/>

	<h2><?=t('Important Information about Backup & Restore')?></h2>
	
	<?=t('Running a backup will create a database export file and store it on your server. Encryption is only advised if you plan on storing the backup on the server indefinitely. This is <strong>not recommended</strong>. After running backup, download the file and make sure that the entire database was saved correctly. If any error messages appear during the backup process, do <b>not</b> attempt to restore from that backup.')?>

</div>

<? } else { ?>

<h1><span><?=t('Backup')?></span></h1>
<div class="ccm-dashboard-inner">
<p><?=t('You do not have permission to create or administer backups.')?></p>
</div>

<? } ?>
</div>