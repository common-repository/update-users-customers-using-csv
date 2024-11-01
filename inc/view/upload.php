<?php
function csv_to_array($path){
    try{
        if(!empty($path)){
          $csv = fopen($path, 'r');
          $rows = [];
          $header = [];
          $index = 0;
          $error_msgs = null;
          $error = '';
          if($csv){
            while (($line = fgetcsv($csv)) !== FALSE) {
                $index++;
                if ($index == 1) {
                    $header = $line;
                } else {
                    $row = [];
                    if(count($header) == count($line)){
                      for ($i = 0; $i < count($header); $i++) {
                          $row[$header[$i]] = $line[$i];
                      }
                      array_push($rows, $row);
                    }else{
                      $error_msgs[$index] = "<div class='notice notice-error top-mar'>
                        <p><i class='material-icons right'>close</i>Line Number:".$index." : Data element count not match with fileds count</p>
                      </div>";
                    }
                }
            }
          }else{
            echo "<div class='notice notice-error top-mar'>
              <p><i class='material-icons right'>close</i>Some error occured: Please Try Again!</p>
            </div>";
            return false;
          }
        }else{
          echo "<div class='notice notice-error top-mar'>
            <p><i class='material-icons right'>close</i>Some error occured: Please Try Again!</p>
          </div>";
          return false;
        }
        if(!empty($error_msgs)){
          foreach($error_msgs as $error_msg){
            $error .= $error_msg;
          }
          throw new Exception($error);
        }else{
          return $rows;
        }
    }catch (Exception $exception){
        echo $exception->getMessage();
        return false;
    }
}
function creating_uploading_file_form(){?>
  <div class="col offset-l3 l6 offset-m3 m6 s12">
    <p class="center-align"><b>Upload your .csv/.txt file for bulk updating users iformation.</b></p>
    <div class="top-mar-30"></div>
    <form action="#" method='POST' enctype='multipart/form-data'>
       <div class="file-field input-field">
         <div class="btn">
           <span>File</span>
             <input type='file' name='user_update_file'>
         </div>
         <div class="file-path-wrapper">
           <input class="file-path validate" type="text">
         </div>
       </div>
       <div class="row center-align">
         <button class="btn waves-effect waves-light top-mar-30"  type="submit" name='upload_update_file' value='upload'>Upload File</button>
       </div>
     </form>
   </div>
  <?php
}
function creating_buttons(){
  if($target = get_option("user_data_file_address")&& isset($_POST['check_update_file_loop'])){
    unset( $_POST['check_update_file_loop']);?>
    <form action="#" method='POST' enctype='multipart/form-data'>
      <div class="row">
        <div class="col s6">
            <button class="btn waves-effect waves-light top-mar-30"  type="submit" name='check_update_file' value='Update'>Update Users Info</button>
            <button class="btn waves-effect waves-light top-mar-30"  type="submit" name='check_update_file' value='Cancel'>Cancel</button>
        </div>
      </div>
    </form>
  <?php }elseif( isset($_POST['upload_update_file']) || ($target = get_option("user_data_file_address")) ){ ?>
    <form action="#" method='POST' enctype='multipart/form-data'>
      <div class="row">
        <div class="col s6">
          <button class="btn waves-effect waves-light top-mar-30"  type="submit" name='check_update_file_loop' value='Refresh'>Completed Data Checking!</button>
          <button class="btn waves-effect waves-light top-mar-30"  type="submit" name='check_update_file' value='Cancel'>Cancel</button>
        </div>
      </div>
    </form>
    <?php
  }
}

function creating_table($rows){
  $x = 0;
  $rows_keys = array_keys($rows[0]);
  if(is_array($rows_keys)){
    echo "<div class='row wrapper1' style='overflow: auto'><div class='div-up-scroll' style='height:20px'></div></div>";
    echo "<div class='row wrapper2' style='overflow: auto'>";
    echo "<table class='user-data responsive-table'>";
    echo "<thead><tr>";
    echo "<th>Index</th>";
    foreach($rows_keys as $element){
      echo "<th>".$element."</th>";
    }
    echo "</tr></thead><tbody>";
    foreach($rows as $row){
      $x++;
      echo "<tr>";
      echo "<td><span class='badge white-text wuuc-badge left'>".$x."</span></td>";
      foreach($row as $key=>$value){
        echo "<td>".$value."</td>";
      }
      echo "</tr>";
    }
    echo "</tbody></table></div>";
  }
}
?>
<div class="col s12 wuuc-options">
   <div class="col s12 top-mar">
      <div class="col m6 s12">
        <h5 class="left zero-mar">Update Customer Data</h5>
      </div>
      <div class="col m6 s12">
        <a class="waves-effect waves-light btn right" href="<?php echo admin_url('admin.php?page=woo_update_customer&view=rule');?>"><i class="material-icons left">info</i>Check Rules for File</a>
      </div>
   </div>
   <div class="clearfix" ></div>
   <div class="divider top-mar"></div>
   <?php
   $target = null;
   $rows = null;
   if(isset($_POST['check_update_file'])){
     if($_POST['check_update_file'] == 'Cancel'){
       unset( $_POST['check_update_file']);
       if(get_option("user_data_file_address")){
         if(empty($target)){
           $target = get_option("user_data_file_address");
         }
         unlink($target);
         delete_option("user_data_file_address");
       }
       echo "<div class='notice notice-error top-mar'>
         <p><i class='material-icons right'>close</i><b>We have cancelled operation as per your request!</b></p>
       </div>";
       creating_uploading_file_form();
     }elseif($_POST['check_update_file'] == 'Update'){
       unset( $_POST['check_update_file']);
       if(get_option("user_data_file_address")){
         $target = get_option("user_data_file_address");
         echo "<p><b>Completed updating user information as per file submission:</b></p>";
         $rows = csv_to_array($target);
         $currentTimeinSeconds = time();
         $success = fopen(str_replace("newfile","history/{$currentTimeinSeconds}-success",$target), 'w');
         $failure = fopen(str_replace("newfile","history/{$currentTimeinSeconds}-failure",$target), 'w');
         $replaced = false;
         $header_not_set = true;
         $data_index = null;
         $index_array = array('id','ID','user_id','user_login','username');
         if(is_array($rows)){
           foreach($rows as $row){
             if(is_array($row)){
               if(empty($data_index)){
                 foreach($index_array as $index){
                   if(array_key_exists($index, $row)){
                     if( ($index == 'user_login') || ($index == 'username')){
                       $data_index = $index;
                       $data_index_search = 'login';
                       break;
                     }else{
                       $data_index = $index;
                       $data_index_search = 'id';
                       break;
                     }
                   }
                 }
               }
               if(!empty($data_index)){
                 if($data_index_search =='login'){
                   $the_user_id = username_exists($row[$data_index]);
                 }else{
                   $the_user_id = $row[$data_index];
                   $user_data = get_user_by( 'id', $the_user_id );
                   if ( empty( $user_data ) ) {
                     $the_user_id = false;
                   }
                 }
                 if($the_user_id){
                   $skipped_in_update = false;
                   foreach($row as $key=>$value){
                     if(strtolower($value) != 'skip'){
                       if($key != $data_index){
                         if(update_user_meta($the_user_id,$key,$value) == false){
                           $row[$key] = skipped_.$value;
                           $skipped_in_update = true;
                         }
                       }
                     }
                   }
                   if($skipped_in_update){
                     echo "<div class='notice notice-success top-mar'>
                       <p><i class='material-icons right'>check_circle</i>".$row[$data_index]." : User Information Updated with some data elements which already there and have same values were skipped!</p>
                     </div>";
                     fputcsv($success, $row);
                   }else{
                     echo "<div class='notice notice-success top-mar'>
                       <p><i class='material-icons right'>check_circle</i>".$row[$data_index]." : User Information Successfully Updated!</p>
                     </div>";
                     fputcsv($success, $row);
                   }
                 }else{
                   echo "<div class='notice notice-error top-mar'>
                     <p><i class='material-icons right'>close</i>".$row[$data_index]." : User not Exist hence Information not Updated!</p>
                   </div>";
                   fputcsv($failure, $row);
                 }
               }else{
                 echo "<div class='notice notice-error top-mar'>
                   <p><i class='material-icons right'>close</i>File must contain id/user_id/user_login/username column.</p>
                 </div>";
               }
             }
           }
         }else{
           echo "Make sure all rows of file have equal number of elements.<br>";
         }
       }
         fclose($success);
         fclose($failure);
         unlink($target);
         delete_option("user_data_file_address");
     }
   }else{
     if(isset($_POST['upload_update_file'])){
       unset( $_POST['upload_update_file']);
       if(!file_exists($_FILES['user_update_file']['tmp_name']) || !is_uploaded_file($_FILES['user_update_file']['tmp_name'])) {
         echo "<div class='notice notice-error top-mar'>
           <p><i class='material-icons right'>close</i>File Not Uploaded. Please Upload it properly!</p>
         </div>";
       }else{
          $info = pathinfo(sanitize_file_name($_FILES['user_update_file']['name']));
          if($info){
            $ext = strtolower($info['extension']);
            if($ext == "csv" || $ext == "txt" ) {
              $newfile = "newfile.".$ext;
              $target = WUUC_DIR.'upload/'.$newfile;
              move_uploaded_file(sanitize_text_field($_FILES['user_update_file']['tmp_name']), $target);
              update_option("user_data_file_address",$target);
            }else{
              echo "<div class='notice notice-error top-mar'>
                <p><i class='material-icons right'>close</i>File Extension should be <b>txt</b> or <b>csv</b>.</p>
              </div>";
            }
         }
       }
     }
     if(get_option("user_data_file_address") || !empty($target) ){
        if(empty($target)){
          $target = get_option("user_data_file_address");
        }
        if(file_exists($target)){
          $rows = csv_to_array($target);
        }else{
          if(get_option("user_data_file_address")){
            delete_option("user_data_file_address");
            $target = null;
          }
        }
      }
      if(is_array($rows)){
      creating_buttons();
      creating_table($rows);
      }elseif($rows === false){ ?>
      <form action="#" method='POST' enctype='multipart/form-data'>
          <div class="col s12">
            <div class="row center-align">
              <button class="btn waves-effect waves-light top-mar-30"  type="submit" name='check_update_file' value='Cancel'>Try again with updated file!</button>
            </div>
          </div>
        </div>
      </form>
    <?php }else{
     creating_uploading_file_form();
   }
} ?>
<div class="row">
<div class="col s12">
  <div class="clearfix"></div>
  <div class="divider top-mar"></div>
</div>
</div>
</div>
<?php
