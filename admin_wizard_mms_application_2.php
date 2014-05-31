<?php
require_once('_merchant_registration.php');

global $ease_core;

/** MMS application hook **/
if(isset($_POST['action']) && $_POST['action'] == 'mmsApplication'){
	/** init class **/
	$mmsObj = new mmsApplicationProcessor($this, $_POST);
	$mmsResponse = $mmsObj->processApplication();
	
	if($mmsResponse['Result'] == "Approved"){

		/** update local record to completed **/
		$sql = "UPDATE billing_application SET complete = 'Completed' WHERE uuid=:uuid";
		$sqlParams = array(':uuid'=>'04df66fee0644a1bb070b730fab29f6d');
		$mmsQuery = $ease_core->db->prepare($sql);
		$mmsResult = $mmsQuery->execute($sqlParams);
		/** redirect on success or failure **/
		ease_set_value('api.response', "<p class='pHeader'>Success.... please read below.</p><p>Your application has been successfully submitted and we are reviewing the information.</p><p>You will receive and email when the application has been approved.</p>");
	}else{
		ease_set_value('api.response', "<p class='pHeader'>Oops.... There was an error in your applicaiton.</p><p>There was an error while processing your application.</p><p>Click on the 'Correct Application' button below to review your information.</p><input type='submit' value='Correct Application'/>");
	}

}else{
	ease_set_value('api.response', "");
	
}


?>
<script>
jQuery(document).ready(function(){
	$(".emailsignup").hide();
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
<form id="merchantApplication" name="merchantApplication" action="/" method="POST">
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

		<#[api.response]#>
	</div>
	<div style="clear: both;"></div>
</div>
<div style="clear: both;"></div>
</div>
</form>
<script type="text/javascript">

</script>
