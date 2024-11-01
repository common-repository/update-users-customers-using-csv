<?php
?>
<div class="col s12 wuuc-options">
		<div class="col s12 top-mar">
      <div class="col m6 s12">
        <h5 class="left zero-mar">Rules for Uploading Files</h5>
      </div>
      <div class="col m6 s12">
        <a class="waves-effect waves-light btn right" href="<?php echo admin_url('admin.php?page=woo_update_customer&view=upload');?>"><i class="material-icons left">add</i>Upload New File</a>
      </div>
		</div>
    <div class="clearfix" ></div>
		<div class="divider top-mar"></div>
  <div class="row">
    <div class="col s12">
      <div class="col s12 top-mar">
        <p class="left font-p-med"><b>Here are list of simple rules for making file for updating user information. Please follow same.</b></p>
        <p class="left"><span class="new badge white-text wuuc-badge left" data-badge-caption="">1</span><b> File Format:</b> File must be comma separated <b>.csv</b> / <b>.txt</b> format.</p>
        <p class="left"><span class="new badge white-text wuuc-badge left" data-badge-caption="">2</span><b> Column Labels:</b> Column lables must be same to actual user field name where data needs to be updated.</p>
        <p class="left"><span class="new badge white-text wuuc-badge left" data-badge-caption="">3</span><b> Index Column:</b> File should have one index column which used for finding user for whom data is going to be updated. For example: <b>user_login</b>, <b>username</b>, <b>id</b>, <b>user_id</b></p>
        <p class="left"><span class="new badge white-text wuuc-badge left" data-badge-caption="">4</span><b> Data Parity:</b> Make sure each row of data for user has same number of data elements as many fields we need to update through file.</p>
        <p class="left"><span class="new badge white-text wuuc-badge left" data-badge-caption="">5</span><b> Skipping some Data elements:</b> If you do not have data of some fields for any user or not want to update some data fileds then you write " <b>skip</b> " in data cell and that perticular data will be skipped for that user.</p>
      </div>
      <div class="clearfix"></div>
      <div class="divider top-mar"></div>
    </div>
  </div>
</div>
<?php
