<?php
require_once('_merchant_registration.php');

global $ease_core;

/** MMS application hook **/
if(isset($_POST['action']) && $_POST['action'] == 'mmsApplication'){
	/** init class **/
	$mmsObj = new mmsApplicationProcessor($this, $_POST);
	$mmsResponse = $mmsObj->processApplication();
	$mmsResponse = (array)$mmsResponse;
	if($mmsResponse['Result'] == "Approved"){

		/** update local record to completed **/
		$sql = "UPDATE billing_application SET complete = 'Completed' WHERE uuid=:uuid";
		$sqlParams = array(':uuid'=>'04df66fee0644a1bb070b730fab29f6d');
		$mmsQuery = $ease_core->db->prepare($sql);
		$mmsResult = $mmsQuery->execute($sqlParams);
		/** redirect on success or failure **/
		$api_response = "<p class='pHeader'>Success.... please read below.</p> <p>Your application has been successfully submitted and we are reviewing the information.</p> <p><b style='color: red;'>ATTENTION:</b> There is one more step to the process... Please upload scanned copies (front and back) of both your Drivers License and Utility Bill (electric, water, gas etc etc.) so that our underwriters (SecureNet) may use it in our vetting process. This information is kept strictly confidential and only reviewed by Cloudward Inc and SecureNet.</p><p>You will receive an email when the application has been approved.</p>";
		$mms_uploader = "<iframe style='width: 100%;height: 300px;border: 0;' src='https://secure.cloudward.com/?page=secure_uploader&d=".$_SERVER['HTTP_HOST']."'></iframe>";
	}else{
		$message = "<p class='pHeader'>Oops.... There was an error in your applicaiton.</p><p>The following error(s) occurred while processing your application.</p>";
		$message .= "<p>The Following errors occurred with your application:</p>";
		foreach($mmsResponse['Errors'] AS $item){
			$message .= "<p>".$item['ErrorCode']." -> ".$item['ErrorDescription']."</p>";
		}
		$message .= "<br><br>";
		$message .= "<p>Click on the 'Correct Application' button below to review your information.</p><input type='submit' value='Correct Application'/>";
		$api_response = $message;
	}

}else{
	$api_response = "";
}

?>
<script>
jQuery(document).ready(function(){
	jQuery(".emailsignup").hide();
});
</script>

<style>
	.divSpacer{margin-top: 5px;margin-bottom: 15px;}
	.instructions{font-size: 10px;margin-top: 10px;margin-bottom: 15px;}
	.subHeader{font-weight: bold;border-bottom: 1px #CCC dotted;}
	.applicationDemo input[type="text"]{
	    max-width: 200px;
	}
	.applicationDemo input[type="password"]{
	    max-width: 200px;
	}
	.applicationDemo select{
	    max-width: 200px;
	}
	.sections{
		list-style-type: none;
		width: 100%;
	}
	.sections li{
		display: block;
		min-height: 40px;
	}
	.marker{
		border-radius: 50px;
		background-color: #469BDD;
		color: #FFF;
		font-weight: bold;
		box-shadow: 1px 1px 2px #CCC;
		width: 14px;
		padding: 10px;
		text-align: center;
		float: left;
	}
	.markerLabel{
		width: 80%;
		line-height: 35px;
		padding-left: 40px;
	}
	.container{
		padding: 20px;
		border-radius: 3px;
		border: 1px #CCC solid;
		background-color: #FFF;
		box-shadow: 1px 1px 2px #CCC;
		float: left;
		width: 88%;
		margin-bottom: 20px;
		float: left;
	}
	.containerHeader{
		font-weight: bold;
		width: 100%;
		margin-bottom: 10px;
		font-size: 25px;
		text-shadow: 1px 1px #CCC;
	}
	.containerMessage{
		width: 60%;
		min-height: 200px;
		margin-left: auto;
		margin-right: auto;
		padding: 20px;
		border: 1px #CCC solid;
		border-radius: 3px;
		box-shadow: 1px 1px 2px #CCC;
		background-color: #FFF;
		color: #666;
		text-align: center;
	}
	.pHeader{
		font-weight: bold;
	}
</style>
<form id="merchantApplication" name="merchantApplication" action="/wp-admin/admin.php?page=ease_merchant_application&edit=04df66fee0644a1bb070b730fab29f6d" method="POST">
	<input type="hidden" name="page" value="admin_wizard_mms_application">
<?php
foreach($_POST AS $key => $value){
	if($key <> 'page'){
		echo "<input type='hidden' name='".$key."' value='".$value."'>";
	}
}

?>
<div id="otherformelements" class="applicationDemo"> 
	<div class="containerMessage">

		<?php echo $api_response; ?>
		<?php echo $api_response; ?>
	</div>
	<div style="clear: both;"></div>
</div>
<div style="clear: both;"></div>
</div>
</form>
<script type="text/javascript">

</script>
