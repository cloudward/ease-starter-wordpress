<?php
/*
* This is to determine if this is an update or create
* If it is an update, get application data from gateway using getMmsApplication
*/

/** merchant registration api class **/
require_once('_merchant_registration.php');
global $ease_core;

/** get current application id **/
$mmsSql = "SELECT complete FROM billing_application WHERE uuid=:uuid";
$mmsParams = array(':uuid'=>'04df66fee0644a1bb070b730fab29f6d');
$mmsQuery = $ease_core->db->prepare($mmsSql);

$mmsResult = $mmsQuery->execute($mmsParams);
$mmsRow = $mmsQuery->fetch(PDO::FETCH_ASSOC);
$mmsStatus = $mmsRow['complete'];

/** is this and update or a create **/
if($mmsStatus == "completed"){
	
	/** this is an update, get merchant state data **/
	$params = array();
	$params['action'] = 'mmsApplication';
	$params['request'] = 'getApplication';
	$action_button = "<input type='submit' value='Update Application' id='updateApplication'/>";
	$action_request = "updateApplication";
	$dataObj = new mmsApplicationProcessor($this, $params);
	$stateData = $dataObj->processApplication();
	
	/** populate post array with application data **/
	
}else{
	
	/** create button and create request variable**/
	$action_button="<input type='submit' value='Submit Application' id='createApplication'/>";
	$action_request="createApplication";
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
</style>
<form id="merchantApplication" name="merchantApplication" action="/" method="POST">
<input type="hidden" name="page" id="page" value="admin_wizard_mms_application_2">
<input type="hidden" name="action" id="action" value="mmsApplication">
<input type="hidden" name="request" id="request" value="<#[action.request]#>">
<input type="hidden" name="masterAccountId" id="masterAccountId" value="<#[easvault.marketplace_id]#>">
<div id="otherformelements" class="applicationDemo"> 
	<p style="font-weight: bold;margin-top: 10px;">Merchant Application</p>
	<p style="font-size: 10px;">Complete each section below and submit your application using the submit button in the last section. All fields marked with a red * are required.</p>
	<div style="width: 100%;float: left;">
		<div style="font-weight: bold;">Application Sections</div>
			<ul class="sections">
				<li><a href="javascript: void(0);" id="merchantProfileTrigger" class="trigger"><div class="marker">1</div><div class="markerLabel">Merchant Profile</div></a></li>
				<li><a href="javascript: void(0);" id="merchantOwnershipTrigger" class="trigger"><div class="marker">2</div><div class="markerLabel">Merchant Ownership</div></a></li>
				<li><a href="javascript: void(0);" id="merchantAccountsTrigger" class="trigger"><div class="marker">3</div><div class="markerLabel">Merchant Accounts</div></a></li>
				<li><a href="javascript: void(0);" id="merchantUnderwrittingTrigger" class="trigger"><div class="marker">4</div><div class="markerLabel">Merchant Underwritting</div></a></li>
				<li><a href="javascript: void(0);" id="merchantBillingTrigger" class="trigger"><div class="marker">5</div><div class="markerLabel">Merchant Billing</div></a></li>
				<li><a href="javascript: void(0);" id="merchantServicesTrigger" class="trigger"><div class="marker">6</div><div class="markerLabel">Merchant Service</div></a></li>
				<li><a href="javascript: void(0);" id="merchantSiteTrigger" class="trigger"><div class="marker">7</div><div class="markerLabel">Merchant Site</div></a></li>
			</ul>
		</div>
		<!-- MERCHANT PROFILE -->
		<div id="merchantProfile" class="container" style="display: none;">
			<div class="containerHeader">
				<span>Merchant Profile - section 1</span>
			</div>
			<!-- right container -->
			<div style="width: 50%;float: right;">
				<div style="width: 100%;" class="subHeader">Business Information</div>
				<div class="divSpacer">
					<div class="label">
						Federal Tax ID<br><span style="font-size: 9px;">(Your Business Federal Tax ID, 9 digits, numbers only)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['MerchantFedTaxID']; ?>" name="MerchantFedTaxID"  required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Number of Locations<br><span style="font-size: 9px;">(Number of locations for your business, numbers only)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['NumberOfLocation']; ?>" name="NumberOfLocation"  required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						DBA Name<br><span style="font-size: 9px;">(Doing Business As Name)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['DBAName']; ?>" name="DBAName"  required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						DBA Address<br><span style="font-size: 9px;">(Doing Business As address)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['DBAAddress']; ?>" name="DBAAddress"  required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						DBA City<br><span style="font-size: 9px;">(Doing Business As City)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['DBACity']; ?>" name="DBACity"  required=required><span style="color: red;">*</span>
					</div>
				</div>	
				<div class="divSpacer">
					<div class="label">
						DBA State<br><span style="font-size: 9px;">(Doing Business As State)</span><br>
					</div>
					<div class="formElem">
						<select style="width:300px;height:18px;font-size:14px" name="DBAState" required=required>
							<?
							if(isset($_POST['DBAState']) && !empty($_POST['DBAState'])){
								echo "<option value='".$_POST['DBAState']."'>".$_POST['DBAState']."</option>";
							}
							?>
							<option value="AL">Alabama</option>
							<option value="AK">Alaska</option>
							<option value="AZ">Arizona</option>
							<option value="AR">Arkansas</option>
							<option value="CA">California</option>
							<option value="CO">Colorado</option>
							<option value="CT">Connecticut</option>
							<option value="DE">Delaware</option>
							<option value="DC">District Of Columbia</option>
							<option value="FL">Florida</option>
							<option value="GA">Georgia</option>
							<option value="HI">Hawaii</option>
							<option value="ID">Idaho</option>
							<option value="IL">Illinois</option>
							<option value="IN">Indiana</option>
							<option value="IA">Iowa</option>
							<option value="KS">Kansas</option>
							<option value="KY">Kentucky</option>
							<option value="LA">Louisiana</option>
							<option value="ME">Maine</option>
							<option value="MD">Maryland</option>
							<option value="MA">Massachusetts</option>
							<option value="MI">Michigan</option>
							<option value="MN">Minnesota</option>
							<option value="MS">Mississippi</option>
							<option value="MO">Missouri</option>
							<option value="MT">Montana</option>
							<option value="NE">Nebraska</option>
							<option value="NV">Nevada</option>
							<option value="NH">New Hampshire</option>
							<option value="NJ">New Jersey</option>
							<option value="NM">New Mexico</option>
							<option value="NY">New York</option>
							<option value="NC">North Carolina</option>
							<option value="ND">North Dakota</option>
							<option value="OH">Ohio</option>
							<option value="OK">Oklahoma</option>
							<option value="OR">Oregon</option>
							<option value="PA">Pennsylvania</option>
							<option value="RI">Rhode Island</option>
							<option value="SC">South Carolina</option>
							<option value="SD">South Dakota</option>
							<option value="TN">Tennessee</option>
							<option value="TX">Texas</option>
							<option value="UT">Utah</option>
							<option value="VT">Vermont</option>
							<option value="VA">Virginia</option>
							<option value="WA">Washington</option>
							<option value="WV">West Virginia</option>
							<option value="WI">Wisconsin</option>
							<option value="WY">Wyoming</option>
						</select>
						<span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						DBA Zip Code<br><span style="font-size: 9px;">(Doing Business As Zip Code, 5 digits, numbers only)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['DBAZipCode']; ?>" name="DBAZipCode" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						DBA Phone<br><span style="font-size: 9px;">(Doing Business As Phone Number, 10 digits, numbers only)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['DBAPhone']; ?>" name="DBAPhone" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Web Address<br><span style="font-size: 9px;">(Your Businesses Web Address)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['WebAddress']; ?>" name="WebAddress" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Business Start Date<br><span style="font-size: 9px;">(The date on which your business started, format: MMYYYY example: 081980 numbers only)</span><br>
					</div>
					<div class="formElem">
						<input type="date" style="width:200px;height:18px;font-size:14px" value="<?php echo $_POST['BussinessStartDate']; ?>" name="BussinessStartDate" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Years at Current Location<br><span style="font-size: 9px;">(Number of years at location, numbers only)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['YearsCurrentLocation']; ?>" name="YearsCurrentLocation" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Business Type<br><span style="font-size: 9px;">(The type of business you perform)</span><br>
					</div>
					<div class="formElem">
						<select style="width:300px;height:18px;font-size:14px" name="BusinessType" required=required>
							<?
							if(isset($_POST['BusinessType']) && !empty($_POST['BusinessType'])){
								echo "<option value='".$_POST['BusinessType']."'>".$_POST['BusinessType']."</option>";
							}
							?>
							<option value="1">Retail</option>
							<option value="2">Wholesale</option>
							<option value="3">Restaurant</option>
							<option value="4">Lodging</option>
							<option value="5">Mail or telephone order</option>
							<option value="6">Convenience store</option>
							<option value="7">Convenience store with gas</option>
							<option value="8">Ecommerce</option>
							<option value="9">Business to business</option>
							<option value="10">Home based</option>
							<option value="11">Other</option>
							<option value="12">Auto rental</option>
						</select>
						<span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						MCC Code<br><span style="font-size: 9px;">(Your Industry Type. Pick the closest that represents your company)</span><br>
					</div>
					<div class="formElem">
						<select style="width:300px;height:18px;font-size:14px" name="MCC" required=required>
							<?
							if(isset($_POST['MCC']) && !empty($_POST['MCC'])){
								echo "<option value='".$_POST['MCC']."'>".$_POST['MCC']."</option>";
							}
							?>
							<option value="0742">Veterinary Services</option>
							<option value="0763">Agricultural Cooperative</option>
							<option value="0780">Landscaping and Horticultural Services</option>
							<option value="1520">General Contractors—Residential and Commercial</option>
							<option value="1711">Heating, Plumbing, and Air Conditioning Contractors</option>
							<option value="1731">Electrical Contractors</option>
							<option value="1740">Masonry, Stonework, Tile Setting, Plastering and Insulation Contractors</option>
							<option value="1750">Carpentry Contractors</option>
							<option value="1761">Roofing, Siding, and Sheet Metal Work Contractors</option>
							<option value="1771">Concrete Work Contractors</option>
							<option value="1799">Special Trade Contractors—Not Elsewhere Classified</option>
							<option value="2741">Miscellaneous Publishing and Printing</option>
							<option value="2791">Typesetting, Plate Making and Related Services</option>
							<option value="2842">Specialty Cleaning, Polishing and Sanitation Preparations</option>
							<option value="4011">Railroads</option>
							<option value="4111">Local/Suburban Commuter Passenger Transportation, Including Ferries</option>
							<option value="4112">Passenger Railways</option>
							<option value="4119">Ambulance Services</option>
							<option value="4121">Taxicabs and Limousines</option>
							<option value="4131">Bus Lines</option>
							<option value="4214">Motor Freight Carriers and Trucking—Local and Long Distance, Moving and Storage Companies, and Local Delivery Services</option>
							<option value="4215">Courier Services—Air and Ground, and Freight Forwarders</option>
							<option value="4225">Direct Marketing, Inbound Teleservices Merchant</option>
							<option value="4411">Steamship and Cruise Lines</option>
							<option value="4457">Boat Rentals and Leasing</option>
							<option value="4468">Marinas, Marine Service, and Supplies</option>
							<option value="4511">Airlines and Air Carriers—Not Elsewhere Classified</option>
							<option value="4582">Airports, Flying Fields, and Airport Terminals</option>
							<option value="4722">Travel Agencies and Tour Operators</option>
							<option value="4784">Tolls and Bridge Fees</option>
							<option value="4789">Transportation Services—Not Elsewhere Classified</option>
							<option value="4812">Telecommunication Equipment and Telephone Sales</option>
							<option value="4814">Telecommunication Services, Including Local and Long Distance Calls, Credit Card Calls, Calls Through Use Of Magnetic Stripe Reading Telephones, and Fax Services</option>
							<option value="4816">Computer Network/Information Services</option>
							<option value="4821">Telegraph Services</option>
							<option value="4829">Wire Transfer Money Orders (WTMOs)</option>
							<option value="4899">Cable Satellite and Other Pay Television and Radio Services</option>
							<option value="4900">Utilities—Electric, Gas, Water, Sanitary</option>
							<option value="5013">Motor Vehicle Supplies and New Parts</option>
							<option value="5021">Office and Commercial Furniture</option>
							<option value="5039">Construction Materials—Not Elsewhere Classified</option>
							<option value="5044">Photographic, Photocopy, Microfilm Equipment and Supplies</option>
							<option value="5045">Computers and Computer Peripheral Equipment and Software</option>
							<option value="5046">Commercial Equipment—Not Elsewhere Classified</option>
							<option value="5047">Medical, Dental, Ophthalmic and Hospital Equipment and Supplies</option>
							<option value="5051">Metal Service Centers and Offices</option>
							<option value="5065">Electrical Parts and Equipment</option>
							<option value="5072">Hardware, Equipment and Supplies</option>
							<option value="5074">Plumbing and Heating Equipment and Supplies</option>
							<option value="5085">Industrial Supplies—Not Elsewhere Classified</option>
							<option value="5094">Precious Stones and Metals, Watches and Jewelry</option>
							<option value="5099">Durable Goods—Not Elsewhere Classified</option>
							<option value="5111">Stationery, Office Supplies, Printing and Writing Paper</option>
							<option value="5122">Drugs, Drug Proprietaries, and Druggist Sundries</option>
							<option value="5131">Piece Goods, Notions, and Other Dry Goods</option>
							<option value="5137">Men’s, Women’s, and Children’s Uniforms and Commercial Clothing</option>
							<option value="5139">Commercial Footwear</option>
							<option value="5169">Chemicals and Allied Products—Not Elsewhere Classified</option>
							<option value="5172">Petroleum and Petroleum Products</option>
							<option value="5192">Books, Periodicals and Newspapers</option>
							<option value="5193">Florists Supplies, Nursery Stock and Flowers</option>
							<option value="5198">Paints, Varnishes and Supplies</option>
							<option value="5199">Nondurable Goods—Not Elsewhere Classified</option>
							<option value="5200">Home Supply Warehouse Stores</option>
							<option value="5211">Lumber and Building Materials Stores</option>
							<option value="5231">Glass, Paint, and Wallpaper Stores</option>
							<option value="5251">Hardware Stores</option>
							<option value="5261">Nurseries and Lawn and Garden Supply Stores</option>
							<option value="5271">Mobile Home Dealers</option>
							<option value="5300">Wholesale Clubs</option>
							<option value="5309">Duty Free Stores</option>
							<option value="5310">Discount Stores</option>
							<option value="5311">Department Stores</option>
							<option value="5331">Variety Stores</option>
							<option value="5399">Miscellaneous General Merchandise</option>
							<option value="5411">Grocery Stores and Supermarkets</option>
							<option value="5422">Freezer and Locker Meat Provisioners</option>
							<option value="5441">Candy, Nut, and Confectionery Stores</option>
							<option value="5451">Dairy Products Stores</option>
							<option value="5462">Bakeries</option>
							<option value="5499">Miscellaneous Food Stores—Convenience Stores and Specialty Markets</option>
							<option value="5511">Car and Truck Dealers (New and Used) Sales, Service, Repairs, Parts, and Leasing</option>
							<option value="5521">Car and Truck Dealers (Used Only) Sales, Service, Repairs, Parts, and Leasing</option>
							<option value="5532">Automotive Tire Stores</option>
							<option value="5533">Automotive Parts and Accessories Stores</option>
							<option value="5541">Service Stations (with or without Ancillary Services)</option>
							<option value="5542">Automated Fuel Dispensers</option>
							<option value="5551">Boat Dealers</option>
							<option value="5561">Camper, Recreational and Utility Trailer Dealers</option>
							<option value="5571">Motorcycle Shops and Dealers</option>
							<option value="5592">Motor Home Dealers</option>
							<option value="5598">Snowmobile Dealers</option>
							<option value="5599">Miscellaneous Automotive, Aircraft, and Farm Equipment Dealers—Not Elsewhere Classified</option>
							<option value="5611">Men’s and Boys’ Clothing and Accessories Stores</option>
							<option value="5621">Women’s Ready-To-Wear Stores</option>
							<option value="5631">Women’s Accessory and Specialty Shops</option>
							<option value="5641">Children’s and Infants’ Wear Stores</option>
							<option value="5651">Family Clothing Stores</option>
							<option value="5655">Sports and Riding Apparel Stores</option>
							<option value="5661">Shoe Stores</option>
							<option value="5681">Furriers and Fur Shops</option>
							<option value="5691">Men’s and Women’s Clothing Stores</option>
							<option value="5697">Tailors, Seamstresses, Mending, and Alterations</option>
							<option value="5698">Wig and Toupee Stores</option>
							<option value="5699">Miscellaneous Apparel and Accessory Shops</option>
							<option value="5712">Furniture, Home Furnishings and Equipment Stores, Except Appliances</option>
							<option value="5713">Floor Covering Stores</option>
							<option value="5714">Drapery, Window Covering, and Upholstery Stores</option>
							<option value="5718">Fireplace, Fireplace Screens and Accessories Stores</option>
							<option value="5719">Miscellaneous Home Furnishing Specialty Stores</option>
							<option value="5722">Household Appliance Stores</option>
							<option value="5732">Electronics Stores</option>
							<option value="5733">Music Stores—Musical Instruments, Pianos, and Sheet Music</option>
							<option value="5734">Computer Software Stores</option>
							<option value="5735">Record Stores</option>
							<option value="5811">Caterers</option>
							<option value="5812">Eating Places and Restaurants</option>
							<option value="5813">Drinking Places (Alcoholic Beverages)—Bars, Taverns, Nightclubs, Cocktail Lounges, and Discotheques</option>
							<option value="5814">Fast Food Restaurants</option>
							<option value="5912">Drug Stores and Pharmacies</option>
							<option value="5921">Package Stores—Beer, Wine, and Liquor</option>
							<option value="5931">Used Merchandise and Secondhand Stores</option>
							<option value="5932">Antique Shops—Sales, Repairs, and Restoration Services</option>
							<option value="5933">Pawn Shops</option>
							<option value="5935">Wrecking and Salvage Yards</option>
							<option value="5937">Antique Reproductions</option>
							<option value="5940">Bicycle Shops—Sales and Service</option>
							<option value="5941">Sporting Goods Stores</option>
							<option value="5942">Book Stores</option>
							<option value="5943">Stationery Stores, Office and School Supply Stores</option>
							<option value="5944">Jewelry Stores, Watches, Clocks, and Silverware Stores</option>
							<option value="5945">Hobby, Toy and Game Shops</option>
							<option value="5946">Camera and Photographic Supply Stores</option>
							<option value="5947">Gift, Card, Novelty and Souvenir Shops</option>
							<option value="5948">Luggage and Leather Goods Stores</option>
							<option value="5949">Sewing, Needlework, Fabric and Piece Goods Stores</option>
							<option value="5950">Glassware/Crystal Stores</option>
							<option value="5960">Direct Marketing—Insurance Services</option>
							<option value="5962">Direct Marketing—Travel-Related Arrangement Services</option>
							<option value="5963">Door-To-Door Sales</option>
							<option value="5964">Direct Marketing—Catalog Merchant</option>
							<option value="5965">Direct Marketing—Combination Catalog and Retail Merchant</option>
							<option value="5966">Direct Marketing—Outbound Telemarketing Merchant</option>
							<option value="5967">Direct Marketing—Inbound Teleservices Merchant</option>
							<option value="5968">Direct Marketing—Continuity/Subscription Merchant</option>
							<option value="5969">Direct Marketing—Other Direct Marketers—Not Elsewhere Classified</option>
							<option value="5970">Artist’s Supply and Craft Shops</option>
							<option value="5971">Art Dealers and Galleries</option>
							<option value="5972">Stamp and Coin Stores</option>
							<option value="5973">Religious Goods Stores</option>
							<option value="5975">Hearing Aids—Sales, Service, and Supply</option>
							<option value="5976">Orthopedic Goods—Prosthetic Devices</option>
							<option value="5977">Cosmetic Stores</option>
							<option value="5978">Typewriter Stores—Sales, Rentals, Service</option>
							<option value="5983">Fuel Dealers—Fuel Oil, Wood, Coal, and Liquefied Petroleum</option>
							<option value="5992">Florists</option>
							<option value="5993">Cigar Stores and Stands</option>
							<option value="5994">News Dealers and Newsstands</option>
							<option value="5995">Pet Shops, Pet Foods and Supplies Stores</option>
							<option value="5996">Swimming Pools—Sales and Service</option>
							<option value="5997">Electric Razor Stores—Sales and Service</option>
							<option value="5998">Tent and Awning Shops</option>
							<option value="5999">Miscellaneous and Specialty Retail Shops</option>
							<option value="6010">Financial Institutions—Manual Cash Disbursements</option>
							<option value="6011">Financial Institutions—Automated Cash Disbursements</option>
							<option value="6012">Financial Institutions—Merchandise and Services</option>
							<option value="6051">Non-Financial Institutions—Foreign Currency, Money Orders (Not Wire Transfer), StoredValue Card/Load, and Travelers Cheques</option>
							<option value="6211">Security Brokers/Dealers</option>
							<option value="6300">Insurance Sales, Underwriting, and Premiums</option>
							<option value="6513">Real Estate Agents and Managers Rentals</option>
							<option value="7011">Lodging—Hotels, Motels, Resorts, Central Reservation Services—Not Elsewhere Classified</option>
							<option value="7012">Timeshares</option>
							<option value="7032">Sporting and Recreational Camps</option>
							<option value="7033">Trailer Parks and Campgrounds</option>
							<option value="7210">Laundry, Cleaning, and Garment Services</option>
							<option value="7211">Laundries—Family and Commercial</option>
							<option value="7216">Dry Cleaners</option>
							<option value="7217">Carpet and Upholstery Cleaning</option>
							<option value="7221">Photographic Studios</option>
							<option value="7230">Beauty and Barber Shops</option>
							<option value="7251">Shoe Repair Shops, Shoe Shine Parlors, and Hat Cleaning Shops</option>
							<option value="7261">Funeral Services and Crematories</option>
							<option value="7273">Dating and Escort Services</option>
							<option value="7276">Tax Preparation Services</option>
							<option value="7277">Counseling Services—Debt, Marriage, and Personal</option>
							<option value="7278">Buying and Shopping Services and Clubs</option>
							<option value="7296">Clothing Rental—Costumes, Uniforms, Formal Wear</option>
							<option value="7297">Massage Parlors</option>
							<option value="7298">Health and Beauty Spas</option>
							<option value="7299">Miscellaneous Personal Services—Not Elsewhere Classified</option>
							<option value="7311">Advertising Services</option>
							<option value="7321">Consumer Credit Reporting Agencies</option>
							<option value="7322">Debt Collection Agencies</option>
							<option value="7333">Commercial Photography, Art, and Graphics</option>
							<option value="7338">Quick Copy, Reproduction, and Blueprinting Services</option>
							<option value="7339">Stenographic and Secretarial Support</option>
							<option value="7342">Exterminating and Disinfecting Services</option>
							<option value="7349">Cleaning, Maintenance, and Janitorial Services</option>
							<option value="7361">Employment Agencies and Temporary Help Services</option>
							<option value="7372">Computer Programming, Data Processing, and Integrated Systems Design Services</option>
							<option value="7375">Information Retrieval Services</option>
							<option value="7379">Computer Maintenance, Repair and Services —Not Elsewhere Classified</option>
							<option value="7392">Management, Consulting, and Public Relations Services</option>
							<option value="7393">Detective Agencies, Protective Agencies, and Security Services, Including Armored Cars, and Guard Dogs</option>
							<option value="7394">Equipment, Tool, Furniture, and Appliance Rental and Leasing</option>
							<option value="7395">Photofinishing Laboratories and Photo Developing</option>
							<option value="7399">Business Service—Not Elsewhere Classified</option>
							<option value="7512">Automobile Rental Agency</option>
							<option value="7513">Truck and Utility Trailer Rentals</option>
							<option value="7519">Motor Home and Recreational Vehicle Rentals</option>
							<option value="7523">Parking Lots, Parking Meters and Garages</option>
							<option value="7531">Automotive Body Repair Shops</option>
							<option value="7534">Tire Retreading and Repair Shops</option>
							<option value="7535">Automotive Paint Shops</option>
							<option value="7538">Automotive Service Shops (Non-Dealer)</option>
							<option value="7542">Car Washes</option>
							<option value="7549">Towing Services</option>
							<option value="7622">Electronics Repair Shops</option>
							<option value="7623">Air Conditioning and Refrigeration Repair Shops</option>
							<option value="7629">Electrical and Small Appliance Repair Shops</option>
							<option value="7631">Watch, Clock and Jewelry Repair</option>
							<option value="7641">Furniture—Reupholstery, Repair, and Refinishing</option>
							<option value="7692">Welding Services</option>
							<option value="7699">Miscellaneous Repair Shops and Related Services</option>
							<option value="7829">Motion Picture and Video Tape Production and Distribution</option>
							<option value="7832">Motion Picture Theaters</option>
							<option value="7841">DVD/Video Tape Rental Stores</option>
							<option value="7911">Dance Halls, Studios and Schools</option>
							<option value="7922">Theatrical Producers (Except Motion Pictures) and Ticket Agencies</option>
							<option value="7929">Bands, Orchestras, and Miscellaneous Entertainers—Not Elsewhere Classified</option>
							<option value="7932">Billiard and Pool Establishments</option>
							<option value="7933">Bowling Alleys</option>
							<option value="7941">Commercial Sports, Professional Sports Clubs, Athletic Fields, and Sports Promoters</option>
							<option value="7991">Tourist Attractions and Exhibits</option>
							<option value="7992">Public Golf Courses</option>
							<option value="7993">Video Amusement Game Supplies</option>
							<option value="7994">Video Game Arcades/Establishments</option>
							<option value="7995">Betting, Including Lottery Tickets, Casino Gaming Chips, Off-Track Betting, and Wagers At Race Tracks</option>
							<option value="7996">Amusement Parks, Circuses, Carnivals, and Fortune Tellers</option>
							<option value="7997">Membership Clubs (Sports, Recreation, Athletic), Country Clubs, and Private Golf Courses</option>
							<option value="7998">Aquariums, Seaquariums, Dolphinariums</option>
							<option value="7999">Recreation Services—Not Elsewhere Classified</option>
							<option value="8011">Doctors and Physicians—Not Elsewhere Classified</option>
							<option value="8021">Dentists and Orthodontists</option>
							<option value="8031">Osteopaths</option>
							<option value="8041">Chiropractors</option>
							<option value="8042">Optometrists and Ophthalmologists</option>
							<option value="8043">Opticians, Optical Goods, and Eyeglasses</option>
							<option value="8049">Podiatrists and Chiropodists</option>
							<option value="8050">Nursing and Personal Care Facilities</option>
							<option value="8062">Hospitals</option>
							<option value="8071">Medical and Dental Laboratories</option>
							<option value="8099">Medical Services and Health Practitioners—Not Elsewhere Classified</option>
							<option value="8111">Legal Services and Attorneys</option>
							<option value="8211">Elementary and Secondary Schools</option>
							<option value="8220">Colleges, Universities, Professional Schools, and Junior Colleges</option>
							<option value="8241">Correspondence Schools</option>
							<option value="8244">Business and Secretarial Schools</option>
							<option value="8249">Vocational and Trade Schools</option>
							<option value="8299">Schools and Educational Services—Not Elsewhere Classified</option>
							<option value="8351">Child Care Services</option>
							<option value="8398">Charitable and Social Service Organizations</option>
							<option value="8641">Civic, Social, and Fraternal Associations</option>
							<option value="8651">Political Organizations</option>
							<option value="8661">Religious Organizations</option>
							<option value="8675">Automobile Associations</option>
							<option value="8699">Membership Organizations—Not Elsewhere Classified</option>
							<option value="8734">Testing Laboratories (Non-Medical Testing)</option>
							<option value="8911">Architectural, Engineering, and Surveying Services</option>
							<option value="8931">Accounting, Auditing, and Bookkeeping Services</option>
						</select>
						<span style="color: red;">*</span>
					</div>
				</div>
				<div>
					<input type="button" value="Continue to Section 2" id="merchantOwnershipTrigger" class="trigger">
				</div>
			</div>
		
			<!-- left container -->
			<div style="width: 50%; float: left;">
				<div style="width: 100%;" class="subHeader">Legal Information</div>
				<div class="divSpacer">
					<div class="label">
						Legal Name<br><span style="font-size: 9px;">(Your Businesses Legal Name)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['LegalName']; ?>" name="LegalName" required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Legal Address<br><span style="font-size: 9px;">(Your Businesses Legal Address)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['LegalAddress']; ?>" name="LegalAddress" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Legal City<br><span style="font-size: 9px;">(Your Business Legal City)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px"  value="<?php echo $_POST['LegalCity']; ?>" name="LegalCity" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="local divSpacer">
					<div class="label">
						Legal State<br><span style="font-size: 9px;">(Your Business Legal State)</span><br>
					</div>
					<div class="formElem">
						<select style="width:300px;height:18px;font-size:14px" name="LegalState" required=required>
							<?
							if(isset($_POST['LegalState']) && !empty($_POST['LegalState'])){
								echo "<option value='".$_POST['LegalState']."'>".$_POST['LegalState']."</option>";
							}
							?>
							<option value="AL">Alabama</option>
							<option value="AK">Alaska</option>
							<option value="AZ">Arizona</option>
							<option value="AR">Arkansas</option>
							<option value="CA">California</option>
							<option value="CO">Colorado</option>
							<option value="CT">Connecticut</option>
							<option value="DE">Delaware</option>
							<option value="DC">District Of Columbia</option>
							<option value="FL">Florida</option>
							<option value="GA">Georgia</option>
							<option value="HI">Hawaii</option>
							<option value="ID">Idaho</option>
							<option value="IL">Illinois</option>
							<option value="IN">Indiana</option>
							<option value="IA">Iowa</option>
							<option value="KS">Kansas</option>
							<option value="KY">Kentucky</option>
							<option value="LA">Louisiana</option>
							<option value="ME">Maine</option>
							<option value="MD">Maryland</option>
							<option value="MA">Massachusetts</option>
							<option value="MI">Michigan</option>
							<option value="MN">Minnesota</option>
							<option value="MS">Mississippi</option>
							<option value="MO">Missouri</option>
							<option value="MT">Montana</option>
							<option value="NE">Nebraska</option>
							<option value="NV">Nevada</option>
							<option value="NH">New Hampshire</option>
							<option value="NJ">New Jersey</option>
							<option value="NM">New Mexico</option>
							<option value="NY">New York</option>
							<option value="NC">North Carolina</option>
							<option value="ND">North Dakota</option>
							<option value="OH">Ohio</option>
							<option value="OK">Oklahoma</option>
							<option value="OR">Oregon</option>
							<option value="PA">Pennsylvania</option>
							<option value="RI">Rhode Island</option>
							<option value="SC">South Carolina</option>
							<option value="SD">South Dakota</option>
							<option value="TN">Tennessee</option>
							<option value="TX">Texas</option>
							<option value="UT">Utah</option>
							<option value="VT">Vermont</option>
							<option value="VA">Virginia</option>
							<option value="WA">Washington</option>
							<option value="WV">West Virginia</option>
							<option value="WI">Wisconsin</option>
							<option value="WY">Wyoming</option>
						</select>
						<span style="color: red;">*</span>
					</div>
				</div>
				<div class="local divSpacer">
					<div class="label">
						Legal Zip Code<br><span style="font-size: 9px;">(Your Business Legal Zip Code must be 5 digits numbers only)</span><br>
					</div>
					<div class="formElem">
						<input type="text" min="5" max="5" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['LegalZipCode']; ?>" name="LegalZipCode"  required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Legal Fax<br><span style="font-size: 9px;">(Business Legal Fax Number, must be 10 digits numbers only)</span><br>
					</div>
					<div class="formElem">
						<input type="text" min="10" max="10" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['LegalFax']; ?>" name="LegalFax" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Legal Email<br><span style="font-size: 9px;">(Your Business Legal Email, must be valid email address)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['LegalEmail']; ?>" name="LegalEmail" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Legal Merchant Contact<br><span style="font-size: 9px;">(Legal Person of Contact for your business)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['LegalMerchantContact']; ?>" name="LegalMerchantContact" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Legal Phone<br><span style="font-size: 9px;">(Your Business Legal Phone Number, 10 digits numbers only)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['LegalPhone']; ?>" name="LegalPhone" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Ownership Type<br><span style="font-size: 9px;">(The type of your business)</span><br>
					</div>
					<div class="formElem">
						<select style="width:300px;height:18px;font-size:14px" name="OwnershipType" required=required>
							<?
							if(isset($_POST['OwnershipType']) && !empty($_POST['OwnershipType'])){
								echo "<option value='".$_POST['OwnershipType']."'>".$_POST['OwnershipType']."</option>";
							}
							?>
							<option value="1">Sole Propietor</option>
							<option value="2">Partnership</option>
							<option value="3">Public Corporation</option>
							<option value="4">Private Corporation</option>
							<option value="5">Non-Profit</option>
							<option value="6">Government Corporation</option>
							<option value="7">LLC</option>
							<option value="11">Other</option>
						</select>
						<span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Other Ownership Type<br><span style="font-size: 9px;">(If "Other" Selected above, Explain)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['OwnershipTypeOther']; ?>" name="OwnershipTypeOther">
					</div>
				</div>
			</div>
			<div style="clear: both;"></div>
		</div>
		
		<!-- MERCHANT OWNERSHIP -->
		<div id="merchantOwnership" class="container" style="display: none;">
			<div class="containerHeader">
				<span>Merchant Ownership - section 2</span>
			</div>
			<!-- right container -->
			<div style="width: 50%;float: right;">
				<div style="width: 100%;" class="subHeader">Owner 2 Information</div>
				<div class="divSpacer">
					<div class="label">
						Owner 2 First Name<br><span style="font-size: 9px;">(Owner number two first name)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['Owner2FirstName']; ?>" name="Owner2FirstName" >
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Owner 2 Last Name<br><span style="font-size: 9px;">(Owner number two last name)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['Owner2LastName']; ?>" name="Owner2LastName" >
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Owner 2 Social Security Number<br><span style="font-size: 9px;">(Owner number two SSN)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['Owner2SSN']; ?>" name="Owner2SSN" >
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Owner 2 Date of Birth<br><span style="font-size: 9px;">(Owner number two DOB)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['Owner2DOB']; ?>" name="Owner2DOB" >
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Owner 2 Title<br><span style="font-size: 9px;">(Owner number two title)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['Owner2Title']; ?>" name="Owner2Title" >
					</div>
				</div>	
				<div class="divSpacer">
					<div class="label">
						Owner 2 Equity<br><span style="font-size: 9px;">(Owner number two equity)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['Owner2Equity']; ?>" name="Owner2Equity" id="Owner2Equity" >
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Owner 2 Address<br><span style="font-size: 9px;">(Owner number two address)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['Owner2Address']; ?>" name="Owner2Address" >
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Owner 2 City<br><span style="font-size: 9px;">(Owner number two City)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['Owner2City']; ?>" name="Owner2City" >
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Owner 2 State<br><span style="font-size: 9px;">(Owner number two state)</span><br>
					</div>
					<div class="formElem">
						<select style="width:300px;height:18px;font-size:14px" name="Owner2State">
							<?
							if(isset($_POST['Owner2State']) && !empty($_POST['Owner2State'])){
								echo "<option value='".$_POST['Owner2State']."'>".$_POST['Owner2State']."</option>";
							}
							?>
							<option value="AL">Alabama</option>
							<option value="AK">Alaska</option>
							<option value="AZ">Arizona</option>
							<option value="AR">Arkansas</option>
							<option value="CA">California</option>
							<option value="CO">Colorado</option>
							<option value="CT">Connecticut</option>
							<option value="DE">Delaware</option>
							<option value="DC">District Of Columbia</option>
							<option value="FL">Florida</option>
							<option value="GA">Georgia</option>
							<option value="HI">Hawaii</option>
							<option value="ID">Idaho</option>
							<option value="IL">Illinois</option>
							<option value="IN">Indiana</option>
							<option value="IA">Iowa</option>
							<option value="KS">Kansas</option>
							<option value="KY">Kentucky</option>
							<option value="LA">Louisiana</option>
							<option value="ME">Maine</option>
							<option value="MD">Maryland</option>
							<option value="MA">Massachusetts</option>
							<option value="MI">Michigan</option>
							<option value="MN">Minnesota</option>
							<option value="MS">Mississippi</option>
							<option value="MO">Missouri</option>
							<option value="MT">Montana</option>
							<option value="NE">Nebraska</option>
							<option value="NV">Nevada</option>
							<option value="NH">New Hampshire</option>
							<option value="NJ">New Jersey</option>
							<option value="NM">New Mexico</option>
							<option value="NY">New York</option>
							<option value="NC">North Carolina</option>
							<option value="ND">North Dakota</option>
							<option value="OH">Ohio</option>
							<option value="OK">Oklahoma</option>
							<option value="OR">Oregon</option>
							<option value="PA">Pennsylvania</option>
							<option value="RI">Rhode Island</option>
							<option value="SC">South Carolina</option>
							<option value="SD">South Dakota</option>
							<option value="TN">Tennessee</option>
							<option value="TX">Texas</option>
							<option value="UT">Utah</option>
							<option value="VT">Vermont</option>
							<option value="VA">Virginia</option>
							<option value="WA">Washington</option>
							<option value="WV">West Virginia</option>
							<option value="WI">Wisconsin</option>
							<option value="WY">Wyoming</option>
						</select>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Owner 2 Zip Code<br><span style="font-size: 9px;">(Owner number two zip code)</span><br>
					</div>
					<div class="formElem">
						<input type="date" style="width:200px;height:18px;font-size:14px" value="<?php echo $_POST['Owner2Zip']; ?>" name="Owner2Zip" >
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Owner 2 Country<br><span style="font-size: 9px;">(Owner number two country)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['Owner2Country']; ?>" name="Owner2Country" >
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Owner 2 Phone<br><span style="font-size: 9px;">(Owner number two phone number)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['Owner2Phone']; ?>" name="Owner2Phone" >
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Owner 2 Drivers License No.<br><span style="font-size: 9px;">(Owner number two government issues drivers license)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['Owner2DLNo']; ?>" name="Owner2DLNo" >
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Owner 2 Drivers License State<br><span style="font-size: 9px;">(Owner number two issuing state of drivers license)</span><br>
					</div>
					<div class="formElem">
						<select style="width:300px;height:18px;font-size:14px" name="Owner2DLState">
							<?
							if(isset($_POST['Owner2DLState']) && !empty($_POST['Owner2DLState'])){
								echo "<option value='".$_POST['Owner2DLState']."'>".$_POST['Owner2DLState']."</option>";
							}
							?>
							<option value="AL">Alabama</option>
							<option value="AK">Alaska</option>
							<option value="AZ">Arizona</option>
							<option value="AR">Arkansas</option>
							<option value="CA">California</option>
							<option value="CO">Colorado</option>
							<option value="CT">Connecticut</option>
							<option value="DE">Delaware</option>
							<option value="DC">District Of Columbia</option>
							<option value="FL">Florida</option>
							<option value="GA">Georgia</option>
							<option value="HI">Hawaii</option>
							<option value="ID">Idaho</option>
							<option value="IL">Illinois</option>
							<option value="IN">Indiana</option>
							<option value="IA">Iowa</option>
							<option value="KS">Kansas</option>
							<option value="KY">Kentucky</option>
							<option value="LA">Louisiana</option>
							<option value="ME">Maine</option>
							<option value="MD">Maryland</option>
							<option value="MA">Massachusetts</option>
							<option value="MI">Michigan</option>
							<option value="MN">Minnesota</option>
							<option value="MS">Mississippi</option>
							<option value="MO">Missouri</option>
							<option value="MT">Montana</option>
							<option value="NE">Nebraska</option>
							<option value="NV">Nevada</option>
							<option value="NH">New Hampshire</option>
							<option value="NJ">New Jersey</option>
							<option value="NM">New Mexico</option>
							<option value="NY">New York</option>
							<option value="NC">North Carolina</option>
							<option value="ND">North Dakota</option>
							<option value="OH">Ohio</option>
							<option value="OK">Oklahoma</option>
							<option value="OR">Oregon</option>
							<option value="PA">Pennsylvania</option>
							<option value="RI">Rhode Island</option>
							<option value="SC">South Carolina</option>
							<option value="SD">South Dakota</option>
							<option value="TN">Tennessee</option>
							<option value="TX">Texas</option>
							<option value="UT">Utah</option>
							<option value="VT">Vermont</option>
							<option value="VA">Virginia</option>
							<option value="WA">Washington</option>
							<option value="WV">West Virginia</option>
							<option value="WI">Wisconsin</option>
							<option value="WY">Wyoming</option>
						</select>
					</div>
				</div>
				<div>
					<input type="button" value="Back to Section 1" id="merchantProfileTrigger" class="trigger">
					<input type="button" value="Continue to Section 3" id="merchantAccountsTrigger" class="trigger">
				</div>
			</div>
		
			<!-- left container -->
			<div style="width: 50%; float: left;">
				<div style="width: 100%;" class="subHeader">Owner 1 Information</div>
				<div class="divSpacer">
					<div class="label">
						Owner 1 First Name<br><span style="font-size: 9px;">(Owner number one first name)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['Owner1FirstName']; ?>" name="Owner1FirstName" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Owner 1 Last Name<br><span style="font-size: 9px;">(Owner number one last name)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['Owner1LastName']; ?>" name="Owner1LastName" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Owner 1 Social Security Number<br><span style="font-size: 9px;">(Owner number one SSN, 9 digits, numbers only)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['Owner1SSN']; ?>" name="Owner1SSN" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Owner 1 Date of Birth<br><span style="font-size: 9px;">(Owner number one DOB, format: MM/DD/YYYY example: 08/09/1975)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['Owner1DOB']; ?>" name="Owner1DOB" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Owner 1 Title<br><span style="font-size: 9px;">(Owner number one title)</span><br>
					</div>
					<div class="formElem">
						<select style="width:300px;height:18px;font-size:14px" name="Owner1Title" required=required>
							<?
							if(isset($_POST['Owner1Title']) && !empty($_POST['Owner1Title'])){
								echo "<option value='".$_POST['Owner1Title']."'>".$_POST['Owner1Title']."</option>";
							}
							?>
							<option value="1">ADMINISTRATOR</option>
							<option value="2">CEO</option>
							<option value="3">CFO</option>
							<option value="4">COO</option>
							<option value="5">CORPORATE OFFICER TITLE</option>
							<option value="6">CO OWNER</option>
							<option value="7">DIRECTOR</option>
							<option value="8">GENERAL MANAGER</option>
							<option value="9">LEGAL CONTACT</option>
							<option value="10">OWNER</option>
							<option value="11">PARTNER</option>
							<option value="12">PRESIDENT</option>
							<option value="13">PRINCIPAL</option>
							<option value="14">TREASURER</option>
							<option value="15">VICE PRESIDENT</option>
						</select>
						<span style="color: red;">*</span>
					</div>
				</div>	
				<div class="divSpacer">
					<div class="label">
						Owner 1 Equity<br><span style="font-size: 9px;">(Owner number one equity, numbers only note: if not 100 than owner two information is required. equity must total 100)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['Owner1Equity']; ?>" name="Owner1Equity" id="Owner1Equity" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Owner 1 Address<br><span style="font-size: 9px;">(Owner number one address)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['Owner1Address']; ?>" name="Owner1Address" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Owner 1 City<br><span style="font-size: 9px;">(Owner number one City)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['Owner1City']; ?>" name="Owner1City" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Owner 1 State<br><span style="font-size: 9px;">(Owner number one state)</span><br>
					</div>
					<div class="formElem">
						<select style="width:300px;height:18px;font-size:14px" name="Owner1State" required=required>
							<?
							if(isset($_POST['Owner1State']) && !empty($_POST['Owner1State'])){
								echo "<option value='".$_POST['Owner1State']."'>".$_POST['Owner1State']."</option>";
							}
							?>
							<option value="AL">Alabama</option>
							<option value="AK">Alaska</option>
							<option value="AZ">Arizona</option>
							<option value="AR">Arkansas</option>
							<option value="CA">California</option>
							<option value="CO">Colorado</option>
							<option value="CT">Connecticut</option>
							<option value="DE">Delaware</option>
							<option value="DC">District Of Columbia</option>
							<option value="FL">Florida</option>
							<option value="GA">Georgia</option>
							<option value="HI">Hawaii</option>
							<option value="ID">Idaho</option>
							<option value="IL">Illinois</option>
							<option value="IN">Indiana</option>
							<option value="IA">Iowa</option>
							<option value="KS">Kansas</option>
							<option value="KY">Kentucky</option>
							<option value="LA">Louisiana</option>
							<option value="ME">Maine</option>
							<option value="MD">Maryland</option>
							<option value="MA">Massachusetts</option>
							<option value="MI">Michigan</option>
							<option value="MN">Minnesota</option>
							<option value="MS">Mississippi</option>
							<option value="MO">Missouri</option>
							<option value="MT">Montana</option>
							<option value="NE">Nebraska</option>
							<option value="NV">Nevada</option>
							<option value="NH">New Hampshire</option>
							<option value="NJ">New Jersey</option>
							<option value="NM">New Mexico</option>
							<option value="NY">New York</option>
							<option value="NC">North Carolina</option>
							<option value="ND">North Dakota</option>
							<option value="OH">Ohio</option>
							<option value="OK">Oklahoma</option>
							<option value="OR">Oregon</option>
							<option value="PA">Pennsylvania</option>
							<option value="RI">Rhode Island</option>
							<option value="SC">South Carolina</option>
							<option value="SD">South Dakota</option>
							<option value="TN">Tennessee</option>
							<option value="TX">Texas</option>
							<option value="UT">Utah</option>
							<option value="VT">Vermont</option>
							<option value="VA">Virginia</option>
							<option value="WA">Washington</option>
							<option value="WV">West Virginia</option>
							<option value="WI">Wisconsin</option>
							<option value="WY">Wyoming</option>
						</select>
						<span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Owner 1 Zip Code<br><span style="font-size: 9px;">(Owner number one zip code, 5 digits, numbers only)</span><br>
					</div>
					<div class="formElem">
						<input type="date" style="width:200px;height:18px;font-size:14px" value="<?php echo $_POST['Owner1Zip']; ?>" name="Owner1Zip" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Owner 1 Country<br><span style="font-size: 9px;">(Owner number one country)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['Owner1Country']; ?>" name="Owner1Country" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Owner 1 Phone<br><span style="font-size: 9px;">(Owner number one phone number, 10 digits, numbers only)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['Owner1Phone']; ?>" name="Owner1Phone" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Owner 1 Drivers License No.<br><span style="font-size: 9px;">(Owner number one government issues drivers license)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['Owner1DLNo']; ?>" name="Owner1DLNo" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Owner 1 Drivers License State<br><span style="font-size: 9px;">(Owner number one issuing state of drivers license)</span><br>
					</div>
					<div class="formElem">
						<select style="width:300px;height:18px;font-size:14px" name="Owner1DLState" required=required>
							<?
							if(isset($_POST['Owner1DLState']) && !empty($_POST['Owner1DLState'])){
								echo "<option value='".$_POST['Owner1DLState']."'>".$_POST['Owner1DLState']."</option>";
							}
							?>
							<option value="AL">Alabama</option>
							<option value="AK">Alaska</option>
							<option value="AZ">Arizona</option>
							<option value="AR">Arkansas</option>
							<option value="CA">California</option>
							<option value="CO">Colorado</option>
							<option value="CT">Connecticut</option>
							<option value="DE">Delaware</option>
							<option value="DC">District Of Columbia</option>
							<option value="FL">Florida</option>
							<option value="GA">Georgia</option>
							<option value="HI">Hawaii</option>
							<option value="ID">Idaho</option>
							<option value="IL">Illinois</option>
							<option value="IN">Indiana</option>
							<option value="IA">Iowa</option>
							<option value="KS">Kansas</option>
							<option value="KY">Kentucky</option>
							<option value="LA">Louisiana</option>
							<option value="ME">Maine</option>
							<option value="MD">Maryland</option>
							<option value="MA">Massachusetts</option>
							<option value="MI">Michigan</option>
							<option value="MN">Minnesota</option>
							<option value="MS">Mississippi</option>
							<option value="MO">Missouri</option>
							<option value="MT">Montana</option>
							<option value="NE">Nebraska</option>
							<option value="NV">Nevada</option>
							<option value="NH">New Hampshire</option>
							<option value="NJ">New Jersey</option>
							<option value="NM">New Mexico</option>
							<option value="NY">New York</option>
							<option value="NC">North Carolina</option>
							<option value="ND">North Dakota</option>
							<option value="OH">Ohio</option>
							<option value="OK">Oklahoma</option>
							<option value="OR">Oregon</option>
							<option value="PA">Pennsylvania</option>
							<option value="RI">Rhode Island</option>
							<option value="SC">South Carolina</option>
							<option value="SD">South Dakota</option>
							<option value="TN">Tennessee</option>
							<option value="TX">Texas</option>
							<option value="UT">Utah</option>
							<option value="VT">Vermont</option>
							<option value="VA">Virginia</option>
							<option value="WA">Washington</option>
							<option value="WV">West Virginia</option>
							<option value="WI">Wisconsin</option>
							<option value="WY">Wyoming</option>
						</select>
						<span style="color: red;">*</span>
					</div>
				</div>
			</div>
			<div style="clear: both;"></div>
		</div>
		
		<!-- MERCHANT ACCOUNTS -->
		<div id="merchantAccounts" class="container" style="display: none;">
			<div class="containerHeader">
				<span>Merchant Accounts - section 3</span>
			</div>
			<!-- right container -->
			<div style="width: 50%;float: right;">
				<div style="width: 100%;" class="subHeader">Account Information</div>
				<div class="divSpacer">
					<div class="label">
						Routing Number<br><span style="font-size: 9px;">(Routing number for account used for deposits, 9 digits, numbers only)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['DepAccRoutingNo']; ?>" name="DepAccRoutingNo" id="DepAccRoutingNo" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Account Number<br><span style="font-size: 9px;">(Account number for deposits, numbers only)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['DepAccAccountNo']; ?>" name="DepAccAccountNo"  required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Account Type<br><span style="font-size: 9px;">(Account type for deposits)</span><br>
					</div>
					<div class="formElem">
						<select style="width:300px;height:18px;font-size:14px" name="DepAccAccountType"  required=required>
							<?
							if(isset($_POST['DepAccAccountType']) && !empty($_POST['DepAccAccountType'])){
								echo "<option value='".$_POST['DepAccAccountType']."'>".$_POST['DepAccAccountType']."</option>";
							}
							?>
							<option value="C">Checking</option>
							<option value="S">Savings</option>
						</select>
						<span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Fee Account Routing Number<br><span style="font-size: 9px;">(Routing number for bank account for fees, 9 digits, numbers only)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['FeeAccRoutingNo']; ?>" name="FeeAccRoutingNo" id="FeeAccRoutingNo" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Fee Account Number<br><span style="font-size: 9px;">(Account number for bank account for fees, numbers only)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['FeeAccAccountNo']; ?>" name="FeeAccAccountNo"  required=required><span style="color: red;">*</span>
					</div>
				</div>	
				<div class="divSpacer">
					<div class="label">
						Fee Account Type<br><span style="font-size: 9px;">(Account type for bank for fees)</span><br>
					</div>
					<div class="formElem">
						<select style="width:300px;height:18px;font-size:14px" name="FeeAccAccountType"  required=required>
							<?
							if(isset($_POST['FeeAccAccountType']) && !empty($_POST['FeeAccAccountType'])){
								echo "<option value='".$_POST['FeeAccAccountType']."'>".$_POST['FeeAccAccountType']."</option>";
							}
							?>
							<option value="C">Checking</option>
							<option value="S">Savings</option>
						</select>
						<span style="color: red;">*</span>
					</div>
				</div>
				<div>
					<input type="button" value="Back to Section 2" id="merchantOwnershipTrigger" class="trigger">
					<input type="button" value="Continue to Section 4" id="merchantUnderwrittingTrigger" class="trigger">
				</div>
			</div>
		
			<!-- left container -->
			<div style="width: 50%; float: left;">
				<div style="width: 100%;" class="subHeader">Deposit Bank Information</div>
				<div class="divSpacer">
					<div class="label">
						Bank Name<br><span style="font-size: 9px;">(Name of bank for deposits)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['DepAccBankName']; ?>" name="DepAccBankName" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Bank Address<br><span style="font-size: 9px;">(Address of Bank for Deposits)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['DepAccBankAddr']; ?>" name="DepAccBankAddr" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Bank City<br><span style="font-size: 9px;">(City of bank for deposits)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['DepAccBankCity']; ?>" name="DepAccBankCity" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Bank State<br><span style="font-size: 9px;">(State of bank for deposit)</span><br>
					</div>
					<div class="formElem">
						<select style="width:300px;height:18px;font-size:14px" name="DepAccBankState" required=required>
							<?
							if(isset($_POST['DepAccBankState']) && !empty($_POST['DepAccBankState'])){
								echo "<option value='".$_POST['DepAccBankState']."'>".$_POST['DepAccBankState']."</option>";
							}
							?>
							<option value="AL">Alabama</option>
							<option value="AK">Alaska</option>
							<option value="AZ">Arizona</option>
							<option value="AR">Arkansas</option>
							<option value="CA">California</option>
							<option value="CO">Colorado</option>
							<option value="CT">Connecticut</option>
							<option value="DE">Delaware</option>
							<option value="DC">District Of Columbia</option>
							<option value="FL">Florida</option>
							<option value="GA">Georgia</option>
							<option value="HI">Hawaii</option>
							<option value="ID">Idaho</option>
							<option value="IL">Illinois</option>
							<option value="IN">Indiana</option>
							<option value="IA">Iowa</option>
							<option value="KS">Kansas</option>
							<option value="KY">Kentucky</option>
							<option value="LA">Louisiana</option>
							<option value="ME">Maine</option>
							<option value="MD">Maryland</option>
							<option value="MA">Massachusetts</option>
							<option value="MI">Michigan</option>
							<option value="MN">Minnesota</option>
							<option value="MS">Mississippi</option>
							<option value="MO">Missouri</option>
							<option value="MT">Montana</option>
							<option value="NE">Nebraska</option>
							<option value="NV">Nevada</option>
							<option value="NH">New Hampshire</option>
							<option value="NJ">New Jersey</option>
							<option value="NM">New Mexico</option>
							<option value="NY">New York</option>
							<option value="NC">North Carolina</option>
							<option value="ND">North Dakota</option>
							<option value="OH">Ohio</option>
							<option value="OK">Oklahoma</option>
							<option value="OR">Oregon</option>
							<option value="PA">Pennsylvania</option>
							<option value="RI">Rhode Island</option>
							<option value="SC">South Carolina</option>
							<option value="SD">South Dakota</option>
							<option value="TN">Tennessee</option>
							<option value="TX">Texas</option>
							<option value="UT">Utah</option>
							<option value="VT">Vermont</option>
							<option value="VA">Virginia</option>
							<option value="WA">Washington</option>
							<option value="WV">West Virginia</option>
							<option value="WI">Wisconsin</option>
							<option value="WY">Wyoming</option>
						</select>
						<span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Bank Zip Code<br><span style="font-size: 9px;">(Zip Code of bank for deposits, 5 digits, numbers only)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['DepAccBankZip']; ?>" name="DepAccBankZip" required=required><span style="color: red;">*</span>
					</div>
				</div>	
				<div class="divSpacer">
					<div class="label">
						Bank Phone<br><span style="font-size: 9px;">(Phone number of bank for deposits, 10 digits, numbers only)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['BankPhone']; ?>" name="BankPhone" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Bank Fax<br><span style="font-size: 9px;">(Fax number of bank for deposits, 10 digits, numbers only)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['BankFax']; ?>" name="BankFax" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Bank Contact<br><span style="font-size: 9px;">(Contact for bank of deposits)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['BankContact']; ?>" name="BankContact" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Fee Bank Name<br><span style="font-size: 9px;">(Name of bank for fees)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['FeeAccBankName']; ?>" name="FeeAccBankName" required=required><span style="color: red;">*</span>
					</div>
				</div>
			</div>
			<div style="clear: both;"></div>
		</div>
		
		<!-- MERCHANT UNDERWRITTING -->
		<div id="merchantUnderwritting" class="container" style="display: none;">
			<div class="containerHeader">
				<span>Merchant Underwritting - section 4</span>
			</div>
			<!-- right container -->
			<div style="width: 50%;float: right;">
				<div style="width: 100%;" class="subHeader">Trade Volume</div>
				<div class="divSpacer">
					<div class="label">
						Total Annual Sales Volume<br><span style="font-size: 9px;">(Your businesses total annual sale volume)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['TotalAnnualSalesVol']; ?>" name="TotalAnnualSalesVol" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Total Annual Credit Card Sales Volume<br><span style="font-size: 9px;">(Your businesses total credit card sales volume annually)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['ToatalAnnualCCSalesVol']; ?>" name="ToatalAnnualCCSalesVol" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Maximum Monthly Card Volume<br><span style="font-size: 9px;">(Your businesses maximum monthly Credit Card Volume)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['MaxMonthlyCardVol']; ?>" name="MaxMonthlyCardVol" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Average Card Ticket<br><span style="font-size: 9px;">(Your businesses average individual credit card sale)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['AvgCardTicket']; ?>" name="AvgCardTicket" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Average Monthly Credit Card Transaction<br><span style="font-size: 9px;">(Your businesses average monthly credit card transactions)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['AvgMonthlyCardTrans']; ?>" name="AvgMonthlyCardTrans" required=required><span style="color: red;">*</span>
					</div>
				</div>	
				<div class="divSpacer">
					<div class="label">
						Occasional High Credit Card Ticket<br><span style="font-size: 9px;">(Your businesses occasional hight credit card sale)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['OccasionalHighCardTicket']; ?>" name="OccasionalHighCardTicket" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Card Swipe Annual % Sales<br><span style="font-size: 9px;">(Your businesses annual percent of sales via card swipes, numbers only. NOTE: card, hand keyed, internet and moto must total 100)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['CardSwipeAnnuPercSales']; ?>" name="CardSwipeAnnuPercSales" id="CardSwipeAnnuPercSales" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Hand Keyed Annual % Sales<br><span style="font-size: 9px;">(Your businesses annual % of sales via hand keyed transactions, numbers only. NOTE: card, hand keyed, internet and moto must total 100)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['HandKeyedAnnuPercSales']; ?>" name="HandKeyedAnnuPercSales" id="HandKeyedAnnuPercSales" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Internet Annual % Sales<br><span style="font-size: 9px;">(Your businesses annual % of sales via internet/ecommerce transactions, numbers only. NOTE: card, hand keyed, internet and moto must total 100)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['InternetAnnuPercSales']; ?>" name="InternetAnnuPercSales" id="InternetAnnuPercSales" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Moto Annual % Sales<br><span style="font-size: 9px;">(Your businesses annual % of sales via mail order/telephone order transactions, numbers only. NOTE: card, hand keyed, internet and moto must total 100)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['MotoAnnuPercSales']; ?>" name="MotoAnnuPercSales" id="MotoAnnuPercSales" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Sales Settled At<br><span style="font-size: 9px;">(The percentage of orders actually delivered in Over 30 Days)</span><br>
					</div>
					<div class="formElem">
						<div class="formElem">
							<select style="width:300px;height:18px;font-size:14px" name="SalesSettledAt" required=required>
								<?
								if(isset($_POST['SalesSettledAt']) && !empty($_POST['SalesSettledAt'])){
									echo "<option value='".$_POST['SalesSettledAt']."'>".$_POST['SalesSettledAt']."</option>";
								}
								?>
								<option value="1">Date of Order</option>
								<option value="2">Date of Delivery</option>
							</select>
							<span style="color: red;">*</span>
						</div>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Fulfillment House Name<br><span style="font-size: 9px;">(The name of the institution that fulfills your orders)</span><br>
					</div>
					<div class="formElem">
						<div class="formElem">
							<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['FulfillmentHouseName']; ?>" name="FulfillmentHouseName" required=required><span style="color: red;">*</span>
						</div>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Fulfillment Address<br><span style="font-size: 9px;">(The address of the institution that fulfills your orders)</span><br>
					</div>
					<div class="formElem">
						<div class="formElem">
							<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['FulfillmentAddress']; ?>" name="FulfillmentAddress" required=required><span style="color: red;">*</span>
						</div>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Fulfillment City<br><span style="font-size: 9px;">(The city of the institution that fulfills your orders)</span><br>
					</div>
					<div class="formElem">
						<div class="formElem">
							<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['FulfillmentCity']; ?>" name="FulfillmentCity" required=required><span style="color: red;">*</span>
						</div>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Fulfillment State<br><span style="font-size: 9px;">(The state of the institution that fulfills your orders)</span><br>
					</div>
					<div class="formElem">
						<div class="formElem">
							<select style="width:300px;height:18px;font-size:14px" name="FulfillmentState" required=required>
								<?
								if(isset($_POST['FulfillmentState']) && !empty($_POST['FulfillmentState'])){
									echo "<option value='".$_POST['FulfillmentState']."'>".$_POST['FulfillmentState']."</option>";
								}
								?>
								<option value="AL">Alabama</option>
								<option value="AK">Alaska</option>
								<option value="AZ">Arizona</option>
								<option value="AR">Arkansas</option>
								<option value="CA">California</option>
								<option value="CO">Colorado</option>
								<option value="CT">Connecticut</option>
								<option value="DE">Delaware</option>
								<option value="DC">District Of Columbia</option>
								<option value="FL">Florida</option>
								<option value="GA">Georgia</option>
								<option value="HI">Hawaii</option>
								<option value="ID">Idaho</option>
								<option value="IL">Illinois</option>
								<option value="IN">Indiana</option>
								<option value="IA">Iowa</option>
								<option value="KS">Kansas</option>
								<option value="KY">Kentucky</option>
								<option value="LA">Louisiana</option>
								<option value="ME">Maine</option>
								<option value="MD">Maryland</option>
								<option value="MA">Massachusetts</option>
								<option value="MI">Michigan</option>
								<option value="MN">Minnesota</option>
								<option value="MS">Mississippi</option>
								<option value="MO">Missouri</option>
								<option value="MT">Montana</option>
								<option value="NE">Nebraska</option>
								<option value="NV">Nevada</option>
								<option value="NH">New Hampshire</option>
								<option value="NJ">New Jersey</option>
								<option value="NM">New Mexico</option>
								<option value="NY">New York</option>
								<option value="NC">North Carolina</option>
								<option value="ND">North Dakota</option>
								<option value="OH">Ohio</option>
								<option value="OK">Oklahoma</option>
								<option value="OR">Oregon</option>
								<option value="PA">Pennsylvania</option>
								<option value="RI">Rhode Island</option>
								<option value="SC">South Carolina</option>
								<option value="SD">South Dakota</option>
								<option value="TN">Tennessee</option>
								<option value="TX">Texas</option>
								<option value="UT">Utah</option>
								<option value="VT">Vermont</option>
								<option value="VA">Virginia</option>
								<option value="WA">Washington</option>
								<option value="WV">West Virginia</option>
								<option value="WI">Wisconsin</option>
								<option value="WY">Wyoming</option>
							</select>
							<span style="color: red;">*</span>
						</div>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Fulfillment Zip Code<br><span style="font-size: 9px;">(The Zip Code of the institution that fulfills your orders, 5 digits, numbers only)</span><br>
					</div>
					<div class="formElem">
						<div class="formElem">
							<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['FulfillmentZip']; ?>" name="FulfillmentZip" required=required><span style="color: red;">*</span>
						</div>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Fulfillment Phone<br><span style="font-size: 9px;">(The Phone number of the institution that fulfills your orders, 10 digits, numbers only)</span><br>
					</div>
					<div class="formElem">
						<div class="formElem">
							<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['FulfillmentPhone']; ?>" name="FulfillmentPhone" required=required><span style="color: red;">*</span>
						</div>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Fulfillment Delivery Timeframe<br><span style="font-size: 9px;">(The timeframe in which you fulfill your orders)</span><br>
					</div>
					<div class="formElem">
						<div class="formElem">
							<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['FulfillmentDeliveryTimeFrame']; ?>" name="FulfillmentDeliveryTimeFrame" required=required><span style="color: red;">*</span>
						</div>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Inventory Owner<br><span style="font-size: 9px;">(Who owns your inventory)</span><br>
					</div>
					<div class="formElem">
						<div class="formElem">
							<select style="width:300px;height:18px;font-size:14px" name="WhoOwnsInventory" required=required>
								<?
								if(isset($_POST['WhoOwnsInventory']) && !empty($_POST['WhoOwnsInventory'])){
									echo "<option value='".$_POST['WhoOwnsInventory']."'>".$_POST['WhoOwnsInventory']."</option>";
								}
								?>
								<option value="1">Merchant</option>
								<option value="2">Fulfillment House</option>
								<option value="3">Undefined</option>
							</select>
							<span style="color: red;">*</span>
						</div>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Merchandise Description<br><span style="font-size: 9px;">(Description of type of merchandise sold)</span><br>
					</div>
					<div class="formElem">
						<div class="formElem">
							<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['MechandiseDescription']; ?>" name="MechandiseDescription" required=required><span style="color: red;">*</span>
						</div>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Send Chargeback Retrieval To<br><span style="font-size: 9px;">(Place to send chargebacks to)</span><br>
					</div>
					<div class="formElem">
						<div class="formElem">
							<select style="width:300px;height:18px;font-size:14px" name="SendChargebackRetrievalTo" required=required>
								<?
								if(isset($_POST['SendChargebackRetrievalTo']) && !empty($_POST['SendChargebackRetrievalTo'])){
									echo "<option value='".$_POST['SendChargebackRetrievalTo']."'>".$_POST['SendChargebackRetrievalTo']."</option>";
								}
								?>
								<option value="1">Outlet</option>
								<option value="2">Corporate</option>
							</select>
							<span style="color: red;">*</span>
						</div>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Send Chargeback<br><span style="font-size: 9px;">(Send Chargebacks via)</span><br>
					</div>
					<div class="formElem">
						<div class="formElem">
							<select style="width:300px;height:18px;font-size:14px" name="SendChargebackRetrievalVia" required=required>
								<?
								if(isset($_POST['SendChargebackRetrievalVia']) && !empty($_POST['SendChargebackRetrievalVia'])){
									echo "<option value='".$_POST['SendChargebackRetrievalVia']."'>".$_POST['SendChargebackRetrievalVia']."</option>";
								}
								?>
								<option value="1">Fax</option>
								<option value="2">Mail</option>
							</select>
							<span style="color: red;">*</span>
						</div>
					</div>
				</div>
				<div>
					<input type="button" value="Back to Section 3" id="merchantAccountsTrigger" class="trigger">
					<input type="button" value="Continue to Section 5" id="merchantBillingTrigger" class="trigger">
				</div>
			</div>

			<!-- left container -->
			<div style="width: 50%; float: left;">
				<div style="width: 100%;" class="subHeader">Trade Information</div>
				<div class="divSpacer">
					<div class="label">
						Trade Reference Name<br><span style="font-size: 9px;">(Business Reference Name)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['TradeRefName']; ?>" name="TradeRefName" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Trade Address<br><span style="font-size: 9px;">(Trade address)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['TradeAddress']; ?>" name="TradeAddress" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Trade City<br><span style="font-size: 9px;">(Trade City)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['TradeCity']; ?>" name="TradeCity" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Trade State<br><span style="font-size: 9px;">(Trade State)</span><br>
					</div>
					<div class="formElem">
						<select style="width:300px;height:18px;font-size:14px" name="TradeState" required=required>
							<?
							if(isset($_POST['TradeState']) && !empty($_POST['TradeState'])){
								echo "<option value='".$_POST['TradeState']."'>".$_POST['TradeState']."</option>";
							}
							?>
							<option value="AL">Alabama</option>
							<option value="AK">Alaska</option>
							<option value="AZ">Arizona</option>
							<option value="AR">Arkansas</option>
							<option value="CA">California</option>
							<option value="CO">Colorado</option>
							<option value="CT">Connecticut</option>
							<option value="DE">Delaware</option>
							<option value="DC">District Of Columbia</option>
							<option value="FL">Florida</option>
							<option value="GA">Georgia</option>
							<option value="HI">Hawaii</option>
							<option value="ID">Idaho</option>
							<option value="IL">Illinois</option>
							<option value="IN">Indiana</option>
							<option value="IA">Iowa</option>
							<option value="KS">Kansas</option>
							<option value="KY">Kentucky</option>
							<option value="LA">Louisiana</option>
							<option value="ME">Maine</option>
							<option value="MD">Maryland</option>
							<option value="MA">Massachusetts</option>
							<option value="MI">Michigan</option>
							<option value="MN">Minnesota</option>
							<option value="MS">Mississippi</option>
							<option value="MO">Missouri</option>
							<option value="MT">Montana</option>
							<option value="NE">Nebraska</option>
							<option value="NV">Nevada</option>
							<option value="NH">New Hampshire</option>
							<option value="NJ">New Jersey</option>
							<option value="NM">New Mexico</option>
							<option value="NY">New York</option>
							<option value="NC">North Carolina</option>
							<option value="ND">North Dakota</option>
							<option value="OH">Ohio</option>
							<option value="OK">Oklahoma</option>
							<option value="OR">Oregon</option>
							<option value="PA">Pennsylvania</option>
							<option value="RI">Rhode Island</option>
							<option value="SC">South Carolina</option>
							<option value="SD">South Dakota</option>
							<option value="TN">Tennessee</option>
							<option value="TX">Texas</option>
							<option value="UT">Utah</option>
							<option value="VT">Vermont</option>
							<option value="VA">Virginia</option>
							<option value="WA">Washington</option>
							<option value="WV">West Virginia</option>
							<option value="WI">Wisconsin</option>
							<option value="WY">Wyoming</option>
						</select>
						<span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Trade Zip Code<br><span style="font-size: 9px;">(Trade Zip Code, 5 digits, numbers only)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['TradeZipCode']; ?>" name="TradeZipCode" required=required><span style="color: red;">*</span>
					</div>
				</div>	
				<div class="divSpacer">
					<div class="label">
						Trade Phone<br><span style="font-size: 9px;">(Trade phone number, 10 digits, numbers only)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['TradePhone']; ?>" name="TradePhone" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Trade Fax<br><span style="font-size: 9px;">(Trade fax number, 10 digits, numbers only)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['TradeFax']; ?>" name="TradeFax" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Is Business Seasonal<br><span style="font-size: 9px;">(Is your business seasonal)</span><br>
					</div>
					<div class="formElem">
						<select style="width:300px;height:18px;font-size:14px" name="IsBusinessSeasonal" required=required>
							<?
							if(isset($_POST['IsBusinessSeasonal']) && !empty($_POST['IsBusinessSeasonal'])){
								echo "<option value='".$_POST['IsBusinessSeasonal']."'>".$_POST['IsBusinessSeasonal']."</option>";
							}
							?>
							<option value="1">Yes</option>
							<option value="2">No</option>
						</select>
						<span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Seasonal Months<br><span style="font-size: 9px;">(The number of seasonal months your business operates in, numbers only)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['SeasonalMonths']; ?>" name="SeasonalMonths" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Advertising Method<br><span style="font-size: 9px;">(The main method of advertising your business employs)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['AdvertisingMethod']; ?>" name="AdvertisingMethod" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Current Processor<br><span style="font-size: 9px;">(Your businesses current payment gateway or processor)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['CurrentProcessor']; ?>" name="CurrentProcessor" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Reason for Leaving<br><span style="font-size: 9px;">(Your reason for leaving your current payment gateway provider)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['ReasonForLeaving']; ?>" name="ReasonForLeaving">
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Refund Policy<br><span style="font-size: 9px;">(Your businesses refund policy)</span><br>
					</div>
					<div class="formElem">
						<select style="width:300px;height:18px;font-size:14px" name="RefundPolicyType" required=required>
							<?
							if(isset($_POST['RefundPolicyType']) && !empty($_POST['RefundPolicyType'])){
								echo "<option value='".$_POST['RefundPolicyType']."'>".$_POST['RefundPolicyType']."</option>";
							}
							?>
							<option value="1">Credit</option>
							<option value="2">Full Refund in 30 days or less</option>
							<option value="3">Exchange Only</option>
							<option value="4">No Refunds</option>
							<option value="5">Store Credit</option>
						</select>
						<span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Is Customer Deposit Required<br><span style="font-size: 9px;">(Are your customers required to leave a deposit for your services or product)</span><br>
					</div>
					<div class="formElem">
						<div class="formElem">
							<select style="width:300px;height:18px;font-size:14px" name="IsConsumerReqDeposit" required=required>
								<?
								if(isset($_POST['IsConsumerReqDeposit']) && !empty($_POST['IsConsumerReqDeposit'])){
									echo "<option value='".$_POST['IsConsumerReqDeposit']."'>".$_POST['IsConsumerReqDeposit']."</option>";
								}
								?>
								<option value="0">No</option>
								<option value="1">Yes</option>
							</select>
							<span style="color: red;">*</span>
						</div>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Percentage of Deposit<br><span style="font-size: 9px;">(Percentage of deposit required, numbers only)</span><br>
					</div>
					<div class="formElem">
						<div class="formElem">
							<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['PercentageOfDeposit']; ?>" name="PercentageOfDeposit" required=required><span style="color: red;">*</span>
						</div>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Is Cited for Nacha Violation<br><span style="font-size: 9px;">(Has your business been previously cited for nacha violation)</span><br>
					</div>
					<div class="formElem">
						<div class="formElem">
							<select style="width:300px;height:18px;font-size:14px" name="IsCitedForNachaVoilation" required=required>
								<?
								if(isset($_POST['IsCitedForNachaVoilation']) && !empty($_POST['IsCitedForNachaVoilation'])){
									echo "<option value='".$_POST['IsCitedForNachaVoilation']."'>".$_POST['IsCitedForNachaVoilation']."</option>";
								}
								?>
								<option value="0">No</option>
								<option value="1">Yes</option>
							</select>
							<span style="color: red;">*</span>
						</div>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Days to Prepare Shipment<br><span style="font-size: 9px;">(Number of days to prepare shipments to consumer)</span><br>
					</div>
					<div class="formElem">
						<div class="formElem">
							<select style="width:300px;height:18px;font-size:14px" name="DaystoPrepareShipment" required=required>
								<?
								if(isset($_POST['DaystoPrepareShipment']) && !empty($_POST['DaystoPrepareShipment'])){
									echo "<option value='".$_POST['DaystoPrepareShipment']."'>".$_POST['DaystoPrepareShipment']."</option>";
								}
								?>
								<option value="1">0 to 7 Days</option>
								<option value="2">8 to 14 Days</option>
								<option value="3">15 to 30 Days</option>
								<option value="4">Over 30 Days</option>
							</select>
							<span style="color: red;">*</span>
						</div>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Percent of Order Delivered in 7 Days<br><span style="font-size: 9px;">(The percentage of orders actually delivered in 7 Days or less, numbers only)</span><br>
					</div>
					<div class="formElem">
						<div class="formElem">
							<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['PercOrderDeliveredIn7Days']; ?>" name="PercOrderDeliveredIn7Days" required=required><span style="color: red;">*</span>
						</div>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Percent of Order Delivered in 14 Days<br><span style="font-size: 9px;">(The percentage of orders actually delivered in 14 Days or less, numbers only)</span><br>
					</div>
					<div class="formElem">
						<div class="formElem">
							<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['PercOrderDeliveredIn14Days']; ?>" name="PercOrderDeliveredIn14Days" required=required><span style="color: red;">*</span>
						</div>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Percent of Order Delivered in 30 Days<br><span style="font-size: 9px;">(The percentage of orders actually delivered in 30 Days or less, numbers only)</span><br>
					</div>
					<div class="formElem">
						<div class="formElem">
							<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['PercOrderDeliveredIn30Days']; ?>" name="PercOrderDeliveredIn30Days" required=required><span style="color: red;">*</span>
						</div>
					</div>
				</div>
			</div>
			<div style="clear: both;"></div>
		</div>

		<!-- MERCHANT BILLING -->
		<div id="merchantBilling" class="container" style="display: none;">
			<div class="containerHeader">
				<span>Merchant Billing - section 5</span>
			</div>
			<!-- right container -->
			<div style="width: 50%;float: right;">
				<div style="width: 100%;" class="subHeader">Billing Information (continued)</div>
				<div class="divSpacer">
					<div class="label">
						Funding Time<br><span style="font-size: 9px;">(Your businesses funding time 0-99, numbers only)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['FundingTime']; ?>" name="FundingTime" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Reserve Limit<br><span style="font-size: 9px;">(Total dollar amount to hold for your business)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['ReserveLimit']; ?>" name="ReserveLimit" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Reserve Percentage<br><span style="font-size: 9px;">(Total percent of each batch to hold until reserve limit reached, numbers only)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['ReservePercentage']; ?>" name="ReservePercentage" required=required><span style="color: red;">*</span>
					</div>
				</div>
				<div>
					<input type="button" value="Back to Section 4" id="merchantUnderwrittingTrigger" class="trigger">
					<input type="button" value="Continue to Section 6" id="merchantServicesTrigger" class="trigger">
				</div>
			</div>
		
			<!-- left container -->
			<div style="width: 50%; float: left;">
				<div style="width: 100%;" class="subHeader">Billing Information</div>
				<div class="divSpacer">
					<div class="label">
						Billing Period<br><span style="font-size: 9px;">(Your billing period)</span><br>
					</div>
					<div class="formElem">
						<select style="width:300px;height:18px;font-size:14px" name="BillPeriod" >
							<?
							if(isset($_POST['BillPeriod']) && !empty($_POST['BillPeriod'])){
								echo "<option value='".$_POST['BillPeriod']."'>".$_POST['BillPeriod']."</option>";
							}
							?>
							<option value="M">Monthly</option>
							<option value="W">Weekly</option>
						</select>
						<span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Billing Method<br><span style="font-size: 9px;">(Your billing method)</span><br>
					</div>
					<div class="formElem">
						<select style="width:300px;height:18px;font-size:14px" name="BillMethod" >
							<?
							if(isset($_POST['BillMethod']) && !empty($_POST['BillMethod'])){
								echo "<option value='".$_POST['BillMethod']."'>".$_POST['BillMethod']."</option>";
							}
							?>
							<option value="4">ACH transmission details plus 1 tape</option>
							<option value="6">ACH for fees and discount plus 2 tape</option>
							<option value="C">check for deposits fees and discounts</option>
							<option value="D">ACH Transmission for deposit fees and discount</option>
							<option value="F">ACH for fees and discounts only</option>
							<option value="N">Neither AcH nor check</option>
						</select>
						<span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Billing Option<br><span style="font-size: 9px;">(Your billing Options)</span><br>
					</div>
					<div class="formElem">
						<select style="width:300px;height:18px;font-size:14px" name="BillOption" >
							<?
							if(isset($_POST['BillOption']) && !empty($_POST['BillOption'])){
								echo "<option value='".$_POST['BillOption']."'>".$_POST['BillOption']."</option>";
							}
							?>
							<option value="C">based on processing cycle and defer days</option>
							<option value="S">based on defer discounts and fees to statement cycle</option>
							<option value="D">based on release date and defer days</option>
						</select>
						<span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Industry<br><span style="font-size: 9px;">(Your companies industry)</span><br>
					</div>
					<div class="formElem">
						<select style="width:300px;height:18px;font-size:14px" name="IndustryCode" >
							<?
							if(isset($_POST['IndustryCode']) && !empty($_POST['IndustryCode'])){
								echo "<option value='".$_POST['IndustryCode']."'>".$_POST['IndustryCode']."</option>";
							}
							?>
							<option value="1">Auto rental</option>
							<option value="2">bank / financial</option>
							<option value="3">direct marketing</option>
							<option value="4">food / restaurant</option>
							<option value="5">grocery supermarket</option>
							<option value="6">hotel</option>
							<option value="7">oil automated fueling</option>
							<option value="8">passenger transport</option>
							<option value="9">retail</option>
						</select>
						<span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Bill Type<br><span style="font-size: 9px;">(Your businesses billing type)</span><br>
					</div>
					<div class="formElem">
						<select style="width:300px;height:18px;font-size:14px" name="BillType" >
							<?
							if(isset($_POST['BillType']) && !empty($_POST['BillType'])){
								echo "<option value='".$_POST['BillType']."'>".$_POST['BillType']."</option>";
							}
							?>
							<option value="S">Net Deposit</option>
							<option value="D">Gross Deposit</option>
						</select>
						<span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Discount Type<br><span style="font-size: 9px;">(Your businesses discount type)</span><br>
					</div>
					<div class="formElem">
						<select style="width:300px;height:18px;font-size:14px" name="DiscountType" >
							<?
							if(isset($_POST['DiscountType']) && !empty($_POST['DiscountType'])){
								echo "<option value='".$_POST['DiscountType']."'>".$_POST['DiscountType']."</option>";
							}
							?>
							<option value="D">Daily</option>
							<option value="M">Monthly</option>
						</select>
						<span style="color: red;">*</span>
					</div>
				</div>	
				
			</div>
			<div style="clear: both;"></div>
		</div>
		
		<!-- MERCHANT SERVICES -->
		<div id="merchantServices" class="container" style="display: none;">
			<div class="containerHeader">
				<span>Merchant Service - section 6</span>
			</div>
			<!-- right container -->
			<div style="width: 50%;float: right;">
				<div style="width: 100%;" class="subHeader">Merchant Services (American Express)</div>
				<div class="divSpacer">
					<div class="label">
						American Express<br><span style="font-size: 9px;">(Does your business take American Express)</span><br>
					</div>
					<div class="formElem">
						<select style="width:300px;height:18px;font-size:14px" name="AmercanExpress" id="AmericanExpress" required=required>
							<?
							if(isset($_POST['AmercanExpress']) && !empty($_POST['AmercanExpress'])){
								echo "<option value='".$_POST['AmercanExpress']."'>".$_POST['AmercanExpress']."</option>";
							}
							?>
							<option value="1">Yes</option>
							<option value="2">No</option>
						</select>
						<span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						American Express Merchant Number<br><span style="font-size: 9px;">(Your businesses Amex Merchant Number, numbers only)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['AmericanExpressMerchantNumber']; ?>" name="AmericanExpressMerchantNumber">
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Affiliated to CAP<br><span style="font-size: 9px;">(Does your business use AMEX CAP)</span><br>
					</div>
					<div class="formElem">
						<select style="width:300px;height:18px;font-size:14px" name="AffiliatedToCAP">
							<?
							if(isset($_POST['AffiliatedToCAP']) && !empty($_POST['AffiliatedToCAP'])){
								echo "<option value='".$_POST['AffiliatedToCAP']."'>".$_POST['AffiliatedToCAP']."</option>";
							}
							?>
							<option value="0">No</option>
							<option value="1">Yes</option>
						</select>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Affiliated CAP Number<br><span style="font-size: 9px;">(Your businesses CAP Number, numbers only)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" name="AffiliatedCAPNumber">
					</div>
				</div>
				<div>
					<input type="button" value="Back to Section 5" id="merchantBillingTrigger" class="trigger">
					<input type="button" value="Continue to Section 7" id="merchantSiteTrigger" class="trigger">
				</div>
			</div>
			<!-- left container -->
			<div style="width: 50%; float: left;">
				<div style="width: 100%;" class="subHeader">Merchant Services (Discover Card)</div>
				<div class="divSpacer">
					<div class="label">
						Discover Card<br><span style="font-size: 9px;">(Does your business take discover card, if yes then Merchant MAP Type is required)</span><br>
					</div>
					<div class="formElem">
						<select style="width:300px;height:18px;font-size:14px" name="Discover" id="Discover" required=required>
							<?
							if(isset($_POST['Discover']) && !empty($_POST['Discover'])){
								echo "<option value='".$_POST['Discover']."'>".$_POST['Discover']."</option>";
							}
							?>
							<option value="1">Yes</option>
							<option value="2">No</option>
						</select><span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Discover Merchant Number<br><span style="font-size: 9px;">(Your businesses discover merchant number)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['DiscoverMerchantNumber']; ?>" name="DiscoverMerchantNumber" id="DiscoverMerchantNumber">
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Discover MAP Merchant Type<br><span style="font-size: 9px;">(Your Discover MAP type, this is required if you answered "yes" to Discover Card)</span><br>
					</div>
					<div class="formElem">
						<select style="width:300px;height:18px;font-size:14px" name="DiscoverMAPMerchantType" id="DiscoverMAPMerchantType">
							<?
							if(isset($_POST['DiscoverMAPMerchantType']) && !empty($_POST['DiscoverMAPMerchantType'])){
								echo "<option value='".$_POST['DiscoverMAPMerchantType']."'>".$_POST['DiscoverMAPMerchantType']."</option>";
							}
							?>
							<option value="0">None</option>
							<option value="1">Self Managed</option>
							<option value="2">HQ</option>
							<option value="3">Outlet to a HQ account</option>
						</select>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Discover MAP Headquarter Number<br><span style="font-size: 9px;">(Discover Headquarter Number, numbers only)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px;" value="<?php echo $_POST['DiscoverMAPHeadQuarterNumber']; ?>" name="DiscoverMAPHeadQuarterNumber" >
					</div>
				</div>	
			</div>
			<div style="clear: both;"></div>
		</div>
		
		<!-- MERCHANT SITE -->
		<div id="merchantSite" class="container" style="display: none;">
			<div class="containerHeader">
				<span>Merchant Site - section 7</span>
			</div>
			<!-- right container -->
			<div style="width: 50%;float: right;">
				<div style="width: 100%;" class="subHeader">Merchant Landlord</div>
				<div class="divSpacer">
					<div class="label">
						Lease Landlord Name<br><span style="font-size: 9px;">(Name of your businesses leasing landlord, required if answered "yes" to leasing)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['LeaseLandlordName']; ?>" name="LeaseLandlordName">
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Lease Landlord Phone<br><span style="font-size: 9px;">(Phone number of your leasing landlord, 10 digits, numbers only, required if answered "yes" to leasing)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['LeaseLandlordPhone']; ?>" name="LeaseLandlordPhone">
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Comments<br><span style="font-size: 9px;">(Additional Comments)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['Comments']; ?>" name="Comments">
					</div>
				</div>
				<div>
					<input type="button" value="Back to Section 6" id="merchantServicesTrigger" class="trigger">
					<#[action.button]#>
				</div>
			</div>
		
			<!-- left container -->
			<div style="width: 50%; float: left;">
				<div style="width: 100%;" class="subHeader">Merchant Leasing</div>
				<div class="divSpacer">
					<div class="label">
						Site Location Type<br><span style="font-size: 9px;">(Your business location type)</span><br>
					</div>
					<div class="formElem">
						<select style="width:300px;height:18px;font-size:14px" name="SiteLocationType" required=required>
							<?
							if(isset($_POST['SiteLocationType']) && !empty($_POST['SiteLocationType'])){
								echo "<option value='".$_POST['SiteLocationType']."'>".$_POST['SiteLocationType']."</option>";
							}
							?>
							<option value="1">Retail Store</option>
							<option value="2">Office</option>
							<option value="3">Industrial Building</option>
							<option value="4">Residence</option>
							<option value="5">Tradeshow</option>
							<option value="6">Other</option>
						</select>
						<span style="color: red;">*</span>
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Other Site Location Type<br><span style="font-size: 9px;">(If Other is selected above, please specify)</span><br>
					</div>
					<div class="formElem">
						<input type="text" style="width:300px;height:18px;font-size:14px" value="<?php echo $_POST['OtherSiteLocationType']; ?>" name="OtherSiteLocationType">
					</div>
				</div>
				<div class="divSpacer">
					<div class="label">
						Is Merchant Leasing<br><span style="font-size: 9px;">(Are you leasing your retail space, if answer "yes" the landlord info is required)</span><br>
					</div>
					<div class="formElem">
						<select style="width:300px;height:18px;font-size:14px" name="IsMerchantLeasing" required=required>
							<?
							if(isset($_POST['IsMerchantLeasing']) && !empty($_POST['IsMerchantLeasing'])){
								echo "<option value='".$_POST['IsMerchantLeasing']."'>".$_POST['IsMerchantLeasing']."</option>";
							}
							?>
							<option value="0">No</option>
							<option value="1">Yes</option>
						</select>
						<span style="color: red;">*</span>
					</div>
				</div>	
			</div>
			<div style="clear: both;"></div>
		</div>
		
		<div style="clear: both;"></div>
	</div>
	<div style="clear: both;"></div>
</div>
</form>
<script type="text/javascript">
function scrollToAnchor(aid){
    var aTag = jQuery('#'+aid);
    jQuery('html,body').animate({scrollTop: aTag.offset().top},'slow');
}

jQuery(document).ready(function(){
	jQuery('.trigger').click(function(){
		switch(this.id){
			case "merchantProfileTrigger":
				if(jQuery(".container").css('visibility') === 'hidden'){
					jQuery('#merchantProfile').show('slow', function(){
						scrollToAnchor('merchantProfile');
					});
					
				}else{
					jQuery('.container').hide('fast', function(){});
					jQuery('#merchantProfile').show('slow', function(){
						scrollToAnchor('merchantProfile');
					});
					
				}
				break;
			case "merchantOwnershipTrigger":
				if(jQuery(".container").css('visibility') === 'hidden'){
					jQuery('#merchantOwnership').show('slow', function(){
						scrollToAnchor('merchantOwnership');
					});
				}else{
					jQuery('.container').hide('fast', function(){});
					jQuery('#merchantOwnership').show('slow', function(){
						scrollToAnchor('merchantOwnership');
					});	
				}		
				break;
			case "merchantAccountsTrigger":
				if(jQuery(".container").css('visibility') === 'hidden'){
					jQuery('#merchantAccounts').show('slow', function(){
						scrollToAnchor('merchantAccounts');
					});
				}else{

					jQuery('.container').hide('fast', function(){});
					jQuery('#merchantAccounts').show('slow', function(){
						scrollToAnchor('merchantAccounts');
					});
					
				}		
				break;
			case "merchantUnderwrittingTrigger":
				if(jQuery(".container").css('visibility') === 'hidden'){
					jQuery('#merchantUnderwritting').show('slow', function(){
						scrollToAnchor('merchantUnderwritting');
					});
				}else{

					jQuery('.container').hide('fast', function(){});
					jQuery('#merchantUnderwritting').show('slow', function(){
						scrollToAnchor('merchantUnderwritting');
					});
				}		
				break;
			case "merchantBillingTrigger":
				if(jQuery(".container").css('visibility') === 'hidden'){
					jQuery('#merchantBilling').show('slow', function(){
						scrollToAnchor('merchantBilling');
					});
				}else{

					jQuery('.container').hide('fast', function(){});
					jQuery('#merchantBilling').show('slow', function(){
						scrollToAnchor('merchantBilling');
					});
				}		
				break;
			case "merchantServicesTrigger":
				if(jQuery(".container").css('visibility') === 'hidden'){
					jQuery('#merchantServices').show('slow', function(){
						scrollToAnchor('merchantServices');
					});
				}else{

					jQuery('.container').hide('fast', function(){});
					jQuery('#merchantServices').show('slow', function(){
						scrollToAnchor('merchantServices');
					});
				}		
				break;
			case "merchantSiteTrigger":
				if(jQuery(".container").css('visibility') === 'hidden'){
					jQuery('#merchantSite').show('slow', function(){
						scrollToAnchor('merchantSite');
					});
				}else{

					jQuery('.container').hide('fast', function(){});
					jQuery('#merchantSite').show('slow', function(){
						scrollToAnchor('merchantSite');
					});
				}		
				break;
		}
	});
	
	/** browser detection **/
	var is_safari = navigator.userAgent.indexOf("Safari") > -1;
	var is_chrome = navigator.userAgent.indexOf('Chrome') > -1;
	var is_firefox = navigator.userAgent.indexOf('Firefox') > -1;
	var is_explorer = navigator.userAgent.indexOf('MSIE') > -1;

	if(is_safari){
		jQuery('#merchantApplication').submit(function(event){
			/** form validation **/
			var discover = jQuery('#Discover').val();
			var discMap = jQuery('#DiscoverMAPMerchantType').val();
			var discMerchNumb = jQuery('#DiscoverMerchantNumber').val();
			var cardSales = parseFloat(jQuery('#CardSwipeAnnuPercSales').val());
			var handKeySales = parseFloat(jQuery('#HandKeyedAnnuPercSales').val());
			var internetSales = parseFloat(jQuery('#InternetAnnuPercSales').val());
			var motoSales = parseFloat(jQuery("#MotoAnnuPercSales").val());
			var totalPercentSales = cardSales + handKeySales + internetSales + motoSales;
			var depAccRoutingNo = jQuery('#DepAccRoutingNo').val();
			var feeAccRoutingNo = jQuery('#FeeAccRoutingNo').val();
			var owner1Equity = parseFloat(jQuery('#Owner1Equity').val());
			var owner2Equity = parseFloat(jQuery('#Owner2Equity').val());
			if(owner1Equity == '' || typeof owner1Equity == 'undefined') owner1Equity = 0;
			if(owner2Equity == '' || typeof owner2Equity == 'undefined') owner2Equity = 0;
			var ownerEquityTotal = owner1Equity + owner2Equity;
			var triggerElem = '';
			var triggerId = '';
			if(ownerEquityTotal != 100){
				triggerElem = document.getElementById('Owner1Equity');
				triggerId = triggerElem.parentNode.parentNode.parentNode.parentNode.id;
				if(jQuery(".container").css('visibility') === 'hidden'){
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}else{

					jQuery('.container').hide('fast', function(){});
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}
				alert('The sum of the two owners equity must equal 100');
				event.preventDefault();
				return false;
			}
			if(depAccRoutingNo.length != 9){
				triggerElem = document.getElementById('DepAccRoutingNo');
				triggerId = triggerElem.parentNode.parentNode.parentNode.parentNode.id;
				if(jQuery(".container").css('visibility') === 'hidden'){
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}else{

					jQuery('.container').hide('fast', function(){});
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}
				alert('Deposit account number must be 9 digits');
				event.preventDefault();
				return false;
			}
			if(feeAccRoutingNo.length != 9){
				triggerElem = document.getElementById('FeeAccRoutingNo');
				triggerId = triggerElem.parentNode.parentNode.parentNode.parentNode.id;
				if(jQuery(".container").css('visibility') === 'hidden'){
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}else{

					jQuery('.container').hide('fast', function(){});
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}
				alert('Fee Deposit account number must be 9 digits');
				event.preventDefault();
				return false;
			}
			if(totalPercentSales != 100){
				triggerElem = document.getElementById('CardSwipeAnnuPercSales');
				triggerId = triggerElem.parentNode.parentNode.parentNode.parentNode.id;
				if(jQuery(".container").css('visibility') === 'hidden'){
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}else{

					jQuery('.container').hide('fast', function(){});
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}
				alert('The sum of all the types of annual percentage of sales must add up to 100');
				event.preventDefault();
				return false;
			}
			if(discMerchNumb.length != 15){
				triggerElem = document.getElementById('DiscoverMerchantNumber');
				triggerId = triggerElem.parentNode.parentNode.parentNode.parentNode.id;
				if(jQuery(".container").css('visibility') === 'hidden'){
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}else{

					jQuery('.container').hide('fast', function(){});
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}
				alert('Discover merchant number must be 15 digits');
				event.preventDefault();
				return false;
			}
			if(discover == '1' && (discMap == "" || typeof discMap === "Undefined")){
				triggerElem = document.getElementById('DiscoverMAPMerchantType');
				triggerId = triggerElem.parentNode.parentNode.parentNode.parentNode.id;
				if(jQuery(".container").css('visibility') === 'hidden'){
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}else{

					jQuery('.container').hide('fast', function(){});
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}
				alert('Discover Map Type must be selected');
				event.preventDefault();
				return false;
			}
			if(!this.checkValidity()){
				jQuery('#merchantApplication :input').each(function(){
					var thisName = this.name;
					if(!this.validity.valid){
						/** stop processing and flag invalid form element **/
						var triggerId = this.parentNode.parentNode.parentNode.parentNode.id;
						jQuery('.container').hide();
						jQuery('#'+triggerId).show('slow', function(){
							scrollToAnchor(triggerId);
						});
						jQuery(this).focus();
						return false;
					}
				});
				event.preventDefault();
			}	
		});
	} 
	if(is_chrome){
		jQuery('#createApplication').click(function(event){
			/** form validation **/
			var discover = jQuery('#Discover').val();
			var discMap = jQuery('#DiscoverMAPMerchantType').val();
			var discMerchNumb = jQuery('#DiscoverMerchantNumber').val();
			var cardSales = parseFloat(jQuery('#CardSwipeAnnuPercSales').val());
			var handKeySales = parseFloat(jQuery('#HandKeyedAnnuPercSales').val());
			var internetSales = parseFloat(jQuery('#InternetAnnuPercSales').val());
			var motoSales = parseFloat(jQuery("#MotoAnnuPercSales").val());
			var totalPercentSales = cardSales + handKeySales + internetSales + motoSales;
			var depAccRoutingNo = jQuery('#DepAccRoutingNo').val();
			var feeAccRoutingNo = jQuery('#FeeAccRoutingNo').val();
			var owner1Equity = parseFloat(jQuery('#Owner1Equity').val());
			var owner2Equity = parseFloat(jQuery('#Owner2Equity').val());
			if(owner1Equity == '' || typeof owner1Equity == 'undefined') owner1Equity = 0;
			if(owner2Equity == '' || typeof owner2Equity == 'undefined') owner2Equity = 0;
			var ownerEquityTotal = owner1Equity + owner2Equity;
			var triggerElem = '';
			var triggerId = '';
			if(ownerEquityTotal != 100){
				triggerElem = document.getElementById('Owner1Equity');
				triggerId = triggerElem.parentNode.parentNode.parentNode.parentNode.id;
				if(jQuery(".container").css('visibility') === 'hidden'){
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}else{

					jQuery('.container').hide('fast', function(){});
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}
				alert('The sum of the two owners equity must equal 100');
				return false;
			}
			if(depAccRoutingNo.length != 9){
				triggerElem = document.getElementById('DepAccRoutingNo');
				triggerId = triggerElem.parentNode.parentNode.parentNode.parentNode.id;
				if(jQuery(".container").css('visibility') === 'hidden'){
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}else{

					jQuery('.container').hide('fast', function(){});
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}
				alert('Deposit account number must be 9 digits');
				return false;
			}
			if(feeAccRoutingNo.length != 9){
				triggerElem = document.getElementById('FeeAccRoutingNo');
				triggerId = triggerElem.parentNode.parentNode.parentNode.parentNode.id;
				if(jQuery(".container").css('visibility') === 'hidden'){
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}else{

					jQuery('.container').hide('fast', function(){});
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}
				alert('Fee Deposit account number must be 9 digits');
				return false;
			}
			if(totalPercentSales != 100){
				triggerElem = document.getElementById('CardSwipeAnnuPercSales');
				triggerId = triggerElem.parentNode.parentNode.parentNode.parentNode.id;
				if(jQuery(".container").css('visibility') === 'hidden'){
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}else{

					jQuery('.container').hide('fast', function(){});
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}
				alert('The sum of all the types of annual percentage of sales must add up to 100');
				return false;
			}
			if(discMerchNumb.length != 15){
				triggerElem = document.getElementById('DiscoverMerchantNumber');
				triggerId = triggerElem.parentNode.parentNode.parentNode.parentNode.id;
				if(jQuery(".container").css('visibility') === 'hidden'){
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}else{

					jQuery('.container').hide('fast', function(){});
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}
				alert('Discover merchant number must be 15 digits');
				return false;
			}
			if(discover == '1' && (discMap == "" || typeof discMap === "Undefined")){
				triggerElem = document.getElementById('DiscoverMAPMerchantType');
				triggerId = triggerElem.parentNode.parentNode.parentNode.parentNode.id;
				if(jQuery(".container").css('visibility') === 'hidden'){
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}else{

					jQuery('.container').hide('fast', function(){});
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}
				alert('Discover Map Type must be selected');
				return false;
			}
			jQuery('#merchantApplication :input').each(function(){
				var thisName = this.name;
				if(!this.validity.valid){
					/** stop processing and flag invalid form element **/
					var triggerId = this.parentNode.parentNode.parentNode.parentNode.id;
					jQuery('.container').hide();
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
					jQuery(this).focus();
					return false;
				}
			});	
		});
	}
	if(is_firefox){
		
		jQuery('#createApplication').click(function(event){
			/** form validation **/
			var discover = jQuery('#Discover').val();
			var discMap = jQuery('#DiscoverMAPMerchantType').val();
			var discMerchNumb = jQuery('#DiscoverMerchantNumber').val();
			var cardSales = parseFloat(jQuery('#CardSwipeAnnuPercSales').val());
			var handKeySales = parseFloat(jQuery('#HandKeyedAnnuPercSales').val());
			var internetSales = parseFloat(jQuery('#InternetAnnuPercSales').val());
			var motoSales = parseFloat(jQuery("#MotoAnnuPercSales").val());
			var totalPercentSales = cardSales + handKeySales + internetSales + motoSales;
			var depAccRoutingNo = jQuery('#DepAccRoutingNo').val();
			var feeAccRoutingNo = jQuery('#FeeAccRoutingNo').val();
			var owner1Equity = parseFloat(jQuery('#Owner1Equity').val());
			var owner2Equity = parseFloat(jQuery('#Owner2Equity').val());
			if(owner1Equity == '' || typeof owner1Equity == 'undefined') owner1Equity = 0;
			if(owner2Equity == '' || typeof owner2Equity == 'undefined') owner2Equity = 0;
			var ownerEquityTotal = owner1Equity + owner2Equity;
			var triggerElem = '';
			var triggerId = '';
			if(ownerEquityTotal != 100){
				triggerElem = document.getElementById('Owner1Equity');
				triggerId = triggerElem.parentNode.parentNode.parentNode.parentNode.id;
				if(jQuery(".container").css('visibility') === 'hidden'){
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}else{

					jQuery('.container').hide('fast', function(){});
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}
				alert('The sum of the two owners equity must equal 100');
				return false;
			}
			if(depAccRoutingNo.length != 9){
				triggerElem = document.getElementById('DepAccRoutingNo');
				triggerId = triggerElem.parentNode.parentNode.parentNode.parentNode.id;
				if(jQuery(".container").css('visibility') === 'hidden'){
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}else{

					jQuery('.container').hide('fast', function(){});
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}
				alert('Deposit account number must be 9 digits');
				return false;
			}
			if(feeAccRoutingNo.length != 9){
				triggerElem = document.getElementById('FeeAccRoutingNo');
				triggerId = triggerElem.parentNode.parentNode.parentNode.parentNode.id;
				if(jQuery(".container").css('visibility') === 'hidden'){
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}else{

					jQuery('.container').hide('fast', function(){});
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}
				alert('Fee Deposit account number must be 9 digits');
				return false;
			}
			if(totalPercentSales != 100){
				triggerElem = document.getElementById('CardSwipeAnnuPercSales');
				triggerId = triggerElem.parentNode.parentNode.parentNode.parentNode.id;
				if(jQuery(".container").css('visibility') === 'hidden'){
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}else{

					jQuery('.container').hide('fast', function(){});
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}
				alert('The sum of all the types of annual percentage of sales must add up to 100');
				return false;
			}
			if(discMerchNumb.length != 15){
				triggerElem = document.getElementById('DiscoverMerchantNumber');
				triggerId = triggerElem.parentNode.parentNode.parentNode.parentNode.id;
				if(jQuery(".container").css('visibility') === 'hidden'){
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}else{

					jQuery('.container').hide('fast', function(){});
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}
				alert('Discover merchant number must be 15 digits');
				return false;
			}
			if(discover == '1' && (discMap == "" || typeof discMap === "Undefined")){
				triggerElem = document.getElementById('DiscoverMAPMerchantType');
				triggerId = triggerElem.parentNode.parentNode.parentNode.parentNode.id;
				if(jQuery(".container").css('visibility') === 'hidden'){
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}else{

					jQuery('.container').hide('fast', function(){});
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}
				alert('Discover Map Type must be selected');
				return false;
			}
			jQuery('#merchantApplication :input').each(function(){
				var thisName = this.name;
				if(!this.validity.valid){

					/** stop processing and flag invalid form element **/
					var triggerId = this.parentNode.parentNode.parentNode.parentNode.id;
					jQuery('.container').hide();
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
					jQuery(this).focus();
					return false;
				}
			});	
		});
	}
	if(is_explorer){
		jQuery('#createApplication').click(function(event){
			/** form validation **/
			var discover = jQuery('#Discover').val();
			var discMap = jQuery('#DiscoverMAPMerchantType').val();
			var discMerchNumb = jQuery('#DiscoverMerchantNumber').val();
			var cardSales = parseFloat(jQuery('#CardSwipeAnnuPercSales').val());
			var handKeySales = parseFloat(jQuery('#HandKeyedAnnuPercSales').val());
			var internetSales = parseFloat(jQuery('#InternetAnnuPercSales').val());
			var motoSales = parseFloat(jQuery("#MotoAnnuPercSales").val());
			var totalPercentSales = cardSales + handKeySales + internetSales + motoSales;
			var depAccRoutingNo = jQuery('#DepAccRoutingNo').val();
			var feeAccRoutingNo = jQuery('#FeeAccRoutingNo').val();
			var owner1Equity = parseFloat(jQuery('#Owner1Equity').val());
			var owner2Equity = parseFloat(jQuery('#Owner2Equity').val());
			if(owner1Equity == '' || typeof owner1Equity == 'undefined') owner1Equity = 0;
			if(owner2Equity == '' || typeof owner2Equity == 'undefined') owner2Equity = 0;
			var ownerEquityTotal = owner1Equity + owner2Equity;
			var triggerElem = '';
			var triggerId = '';
			if(ownerEquityTotal != 100){
				triggerElem = document.getElementById('Owner1Equity');
				triggerId = triggerElem.parentNode.parentNode.parentNode.parentNode.id;
				if(jQuery(".container").css('visibility') === 'hidden'){
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}else{

					jQuery('.container').hide('fast', function(){});
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}
				alert('The sum of the two owners equity must equal 100');
				return false;
			}
			if(depAccRoutingNo.length != 9){
				triggerElem = document.getElementById('DepAccRoutingNo');
				triggerId = triggerElem.parentNode.parentNode.parentNode.parentNode.id;
				if(jQuery(".container").css('visibility') === 'hidden'){
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}else{

					jQuery('.container').hide('fast', function(){});
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}
				alert('Deposit account number must be 9 digits');
				return false;
			}
			if(feeAccRoutingNo.length != 9){
				triggerElem = document.getElementById('FeeAccRoutingNo');
				triggerId = triggerElem.parentNode.parentNode.parentNode.parentNode.id;
				if(jQuery(".container").css('visibility') === 'hidden'){
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}else{

					jQuery('.container').hide('fast', function(){});
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}
				alert('Fee Deposit account number must be 9 digits');
				return false;
			}
			if(totalPercentSales != 100){
				triggerElem = document.getElementById('CardSwipeAnnuPercSales');
				triggerId = triggerElem.parentNode.parentNode.parentNode.parentNode.id;
				if(jQuery(".container").css('visibility') === 'hidden'){
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}else{

					jQuery('.container').hide('fast', function(){});
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}
				alert('The sum of all the types of annual percentage of sales must add up to 100');
				return false;
			}
			if(discMerchNumb.length != 15){
				triggerElem = document.getElementById('DiscoverMerchantNumber');
				triggerId = triggerElem.parentNode.parentNode.parentNode.parentNode.id;
				if(jQuery(".container").css('visibility') === 'hidden'){
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}else{

					jQuery('.container').hide('fast', function(){});
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}
				alert('Discover merchant number must be 15 digits');
				return false;
			}
			if(discover == '1' && (discMap == "" || typeof discMap === "Undefined")){
				triggerElem = document.getElementById('DiscoverMAPMerchantType');
				triggerId = triggerElem.parentNode.parentNode.parentNode.parentNode.id;
				if(jQuery(".container").css('visibility') === 'hidden'){
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}else{

					jQuery('.container').hide('fast', function(){});
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
				}
				alert('Discover Map Type must be selected');
				return false;
			}
			jQuery('#merchantApplication :input').each(function(){
				var thisName = this.name;
				if(!this.validity.valid){

					/** stop processing and flag invalid form element **/
					var triggerId = this.parentNode.parentNode.parentNode.parentNode.id;
					jQuery('.container').hide();
					jQuery('#'+triggerId).show('slow', function(){
						scrollToAnchor(triggerId);
					});
					jQuery(this).focus();
					return false;
				}
			});	
		});
	}
	
});


</script>

