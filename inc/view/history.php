<?php
// specifying directory
$mydir = WUUC_DIR.'upload/history';
//
$org_array = array();
$file_type = array('success','failure');
$file_extension = array('csv','txt');
//scanning files in a given diretory in ascending order
$myfiles = array_slice(scandir($mydir), 2);
if(isset($_POST['delete_files'])){
	$delete_files = sanitize_text_field($_POST['delete_files']);
	unset( $_POST['check_update_file_loop']);
	foreach($file_extension as $extension){
		foreach($file_type as $type){
			$file_name = $delete_files.'-'.$type.'.'.$extension;
			$file_path = WUUC_DIR.'upload/history/'.$file_name;
			if(file_exists($file_path)){
				unlink($file_path);
			}
		}
	}
	$delete_files_date = date('m/d/Y h:i a', $delete_files);
}
// specifying directory
$mydir = WUUC_DIR.'upload/history';
//
$org_array = array();
$file_type = array('success','failure');
$file_extension = array('csv','txt');
//scanning files in a given diretory in ascending order
$myfiles = array_slice(scandir($mydir), 2);
rsort($myfiles);
foreach ($myfiles as $file) {
  //Get the file path
  $file_path = $mydir.$file;
  // Get the file extension
  $file_ext = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
  if ($file_ext == "csv" || $file_ext=="txt") {
    $file = str_replace('.'.$file_ext,'',$file);
		if(strpos($file,'-success')){
			$array_element = str_replace('-success','',$file);
			if(!in_array($array_element, $org_array)){
				$org_array[] = $array_element;
			}
		}elseif(strpos($file,'-failure')){
			$array_element = str_replace('-failure','',$file);
			if(!in_array($array_element, $org_array)){
				$org_array[] = $array_element;
			}
		}
  }
}
?>
<div class="col s12 wuuc-options">
		<div class="col s12 top-mar">
      <div class="col m6 s12">
        <h5 class="left zero-mar">History of Uploaded Files</h5>
      </div>
      <div class="col m6 s12">
        <a class="waves-effect waves-light btn right" href="<?php echo admin_url('admin.php?page=woo_update_customer&view=upload');?>"><i class="material-icons left">add</i>Upload New File</a>
      </div>
		</div>
    <div class="clearfix" ></div>
		<div class="divider top-mar"></div>
		<div class="row">
	    <div class="col s12">
			<?php
			if (isset($delete_files_date)){
				echo "<div class='notice notice-success top-mar'>
					<p><i class='material-icons right'>check_circle</i>".$delete_files_date." : Files are deleted Successfully!</p>
				</div>";
			}
			$i = 1;
			if (!empty($org_array) && is_array($org_array)){
				foreach($org_array as $single_upload){ ?>
				<div class="col s12 top-mar-30">
          <p class="left"><span class="new badge white-text wuuc-badge left" data-badge-caption=""><?php echo $i; ?></span><b><?php echo date('m/d/Y h:i a', $single_upload); ?></b></p>
       </div>
			<?php
			echo '<div class="col s12">';
			    foreach($file_extension as $extension){
						foreach($file_type as $type){
							$file_name = $single_upload.'-'.$type.'.'.$extension;
							$file_path = WUUC_DIR.'upload/history/'.$file_name;
							if(file_exists($file_path)){
								echo "<a class='btn waves-effect waves-light top-mar-10' style='margin-right:20px' href='".WUUC_URL."upload/history/".$file_name."'  name='check_update_file' value='Update' download>".$file_name."</a>";
							}
						}
					}?>
					<form action="#" method='POST' enctype='multipart/form-data'>
	            <button class="btn waves-effect waves-light top-mar-30" style="background-color:#DD7327" type="submit" name='delete_files' value='<?php echo $single_upload; ?>'>Delete Files</button>
			    </form>
				 <?php echo "</div>";
					$i++;
		     }
			}else{
				echo "<div class='notice notice-info top-mar'>
					<p><b>No Record founds!</b></p>
				</div>";
			}
			?>
		</div>
	</div>
	<div class="row">
	<div class="col s12">
	  <div class="clearfix"></div>
	  <div class="divider top-mar"></div>
	</div>
	</div>
</div>
<?php
