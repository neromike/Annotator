<?php include("check_login.php"); ?>
<?php include("header.php"); ?>
<?php
$this_PMID = $_GET['pmid'];
$fh = fopen("annotation/" . $this_PMID . ".csv", "r");
$data = array();
//study info
$data['pub_year'] = "";
$data['clinical_trial'] = "";
$data['pub_country'] = "United States";
$data['pub_authors'] = "";
$data['pub_title'] = "";
$data['inc_criteria'] = "";
$data['pub_COI'] = "";
$data['treatment_focus'] = "";
$data['drug_dosage'] = "";
$data['study_design'] = "";
$data['total_population'] = "";
$data['trial_length'] = "";
$data['age_range'] = "";
$data['mean_age'] = "";
$data['IQ'] = "";
$data['study_results'] = "";

//drug info
$data['drug_name_generic'] = "";
$data['drug_name_common'] = "";
$data['drug_class'] = "";
$data['drug_target'] = "";
$data['therapy_type'] = "";
$data['pharmacology'] = "";
$data['exc_hypo'] = "";
$data['usage'] = "";
$data['FDA'] = "";
while($line = fgets($fh)) {
	$line_exp = explode("\t", $line);
	if (count($line_exp) == 2) {	//skips blank lines in the csv file
		$line_exp[1] = str_replace("\r", "", $line_exp[1]);
		$line_exp[1] = str_replace("\n", "", $line_exp[1]);
		$data[$line_exp[0]] = $line_exp[1];
	}
}
fclose($fh);
?>
<style>
input { padding-left: 5px; }
textarea { font-family: Helvetica, Arial, sans-serif; }
.info_box {
	background-color: #DDD;
	border: solid 1px grey;
	border-radius: 10px;
	width: 90%;
	margin: 0 auto;
	margin-bottom: 10px;
	padding: 10px;
}
#outcome_box {
	margin-left: 60px;
	display: none;
}
.outcome_sub2 {
	width: 400px;
	float: left;
}
</style>

<table width="100%">
	<tr>
		<td>
			<h1>Annotation View</h1>
			<a href="index.php">&lt; Go to Paper Queue</a>
			<br />
		</td>
		<td align="right" style="font-size:12px;">
			Logged in as <em><?php echo $user; ?></em>
			<br />
			<a href="logout.php">Log out</a>
		</td>
	</tr>
</table>



<form action="submit_annotation.php" method="POST">
<center><input type="submit" value="Submit Data" /></center>
<div class="info_box">
	<h2>Study Information</h2>
		<table>
			<tr>
				<td>PMID</td>
				<td><input type="text" name="publication_PMID" placeholder="PMID" value="<?php echo $this_PMID; ?>" disabled /></td>
				<input type="hidden" name="pub_PMID" value="<?php echo $this_PMID; ?>" />
				<td>&nbsp;</td>
				<td>Publication Year</td>
				<td>
					<select name="publication_year">
						<?php
						for ($i=1950; $i<=2013; $i++) {
							echo "<option value='$i'";
							if ($i == $data['pub_year']) { echo " selected"; }
							echo ">$i</option>";
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Clinical Trial</td>
				<td><input type="text" name="publication_clinical_trial" placeholder="#" <?php if ($data['clinical_trial']!="") { echo "value='" . $data['clinical_trial'] . "' "; } ?>/></td>
				<td>&nbsp;</td>
				<td>Publication Country</td>
				<td>
					<select name="publication_country">
						<?php
							$country_list = array("Afghanistan","Albania","Algeria","Andorra","Angola","Antigua and Barbuda","Argentina","Armenia","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bhutan","Bolivia","Bosnia and Herzegovina","Botswana","Brazil","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Central African Republic","Chad","Chile","China","Colombia","Comoros","Congo (Brazzaville)","Congo","Costa Rica","Cote d'Ivoire","Croatia","Cuba","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","East Timor (Timor Timur)","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Fiji","Finland","France","Gabon","Gambia, The","Georgia","Germany","Ghana","Greece","Grenada","Guatemala","Guinea","Guinea-Bissau","Guyana","Haiti","Honduras","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Israel","Italy","Jamaica","Japan","Jordan","Kazakhstan","Kenya","Kiribati","Korea, North","Korea, South","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Morocco","Mozambique","Myanmar","Namibia","Nauru","Nepal","Netherlands","New Zealand","Nicaragua","Niger","Nigeria","Norway","Oman","Pakistan","Palau","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Qatar","Romania","Russia","Rwanda","SaintKitts and Nevis","Saint Lucia","Saint Vincent","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia and Montenegro","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","Spain","Sri Lanka","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Togo","Tonga","Trinidad and Tobago","Tunisia","Turkey","Turkmenistan","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Yemen","Zambia","Zimbabwe");
							foreach ($country_list as $this_country) {
								echo '<option value="' . $this_country . '"';
								if ($this_country == $data['pub_country']) { echo " selected "; }
								echo '>';
								echo $this_country;
								echo '</option>';
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Authors</td>
				<td><input type="text" name="publication_authors" placeholder="author list" size="30" <?php if ($data['pub_authors']!="") { echo "value='" . $data['pub_authors'] . "' "; } ?>/></td>
				<td>&nbsp;</td>
				<td>Study Title</td>
				<td><input type="text" name="publication_title" placeholder="title" size="30" <?php if ($data['pub_title']!="") { echo "value='" . $data['pub_title'] . "' "; } ?>/></td>
			</tr>
			<tr>
				<td>Patient Inclusion criteria</td>
				<td><input type="Ttext" name="publication_inclusion_criteria" placeholder="" size="30" <?php if ($data['inc_criteria']!="") { echo "value='" . $data['inc_criteria'] . "' "; } ?>/></td>
				<td>&nbsp;</td>
				<td>Conflict of Interest</td>
				<td><input type="text" name="publication_conflict" placeholder="" size="30" <?php if ($data['pub_COI']!="") { echo "value='" . $data['pub_COI'] . "' "; } ?>/></td>
			</tr>
			<tr>
				<td>Focus of Treatment</td>
				<td><input type="text" name="publication_treatment_focus" placeholder="" size="30" <?php if ($data['treatment_focus']!="") { echo "value='" . $data['treatment_focus'] . "' "; } ?>/></td>
				<td>&nbsp;</td>
				<td>Drug Dosage</td>
				<td><input type="text" name="publication_dosage" placeholder="" size="30" <?php if ($data['drug_dosage']!="") { echo "value='" . $data['drug_dosage'] . "' "; } ?>/></td>
			</tr>
			<tr>
				<td>Study Design</td>
				<td><input type="text" name="publication_design" placeholder="" size="30" <?php if ($data['study_design']!="") { echo "value='" . $data['study_design'] . "' "; } ?>/></td>
				<td>&nbsp;</td>
				<td>Total Population</td>
				<td><input type="text" name="publication_population" placeholder="#" size="30" <?php if ($data['total_population']!="") { echo "value='" . $data['total_population'] . "' "; } ?>/></td>
			</tr>
			<tr>
				<td>Length of Trial</td>
				<td><input type="text" name="publication_trial_length" placeholder="" size="30" <?php if ($data['trial_length']!="") { echo "value='" . $data['trial_length'] . "' "; } ?>/></td>
				<td>&nbsp;</td>
				<td>Age Range</td>
				<td><input type="text" name="publication_age_range" placeholder="" <?php if ($data['age_range']!="") { echo "value='" . $data['age_range'] . "' "; } ?>/></td>
			</tr>
			<tr>
				<td>Mean Age</td>
				<td><input type="text" name="publication_age_mean" placeholder="" <?php if ($data['mean_age']!="") { echo "value='" . $data['mean_age'] . "' "; } ?>/></td>
				<td>&nbsp;</td>
				<td>IQ</td>
				<td><input type="text" name="publication_IQ" placeholder="" <?php if ($data['IQ']!="") { echo "value='" . $data['IQ'] . "' "; } ?>/></td>
			</tr>
			<tr>
				<td colspan="5">
					Study Results <textarea name="publication_study_results" rows="2" cols="70"><?php if ($data['study_results']!="") { echo $data['study_results']; } ?></textarea>
				</td>
			</tr>
		</table>
	</div>



	<div class="info_box drug_box">
		<h2>Drug Information</h2>
		
		Generic Drug Name <input type="text" name="drug_generic" placeholder="" size="50" <?php if ($data['drug_name_generic']!="") { echo "value='" . $data['drug_name_generic'] . "' "; } ?>/><br />
		
		Common Drug Name <input type="text" name="drug_common" placeholder="" size="50" <?php if ($data['drug_name_common']!="") { echo "value='" . $data['drug_name_common'] . "' "; } ?>/><br />
		
		Drug Class <input type="text" name="drug_class" placeholder="" size="50" <?php if ($data['drug_class']!="") { echo "value='" . $data['drug_class'] . "' "; } ?>/><br />
		
		Drug Target <input type="text" name="drug_target" placeholder="" size="50" <?php if ($data['drug_target']!="") { echo "value='" . $data['drug_target'] . "' "; } ?>/><br />
		
		Therapy Type
		<select name="drug_therapy_type">
			<option value="Drug" <?php if ($data['therapy_type']=="Drug") { echo "selected"; } ?>>Drug</option>
			<option value="Medical Device" <?php if ($data['therapy_type']=="Medical Device") { echo "selected"; } ?>>Medical Device</option>
			<option value="Diet" <?php if ($data['therapy_type']=="Diet") { echo "selected"; } ?>>Diet</option>
		</select>
		<br />
		
		Pharmacology <input type="text" name="drug_pharmacology" placeholder="" <?php if ($data['pharmacology']!="") { echo "value='" . $data['pharmacology'] . "' "; } ?>/><br />
		
		Excitation/Inhibition Hypothesis
		<select name="drug_excit_hypothesis">
			<option value="Yes"<?php if ($data['exc_hypo']=="Yes") { echo " selected"; } ?>>Yes</option>
			<option value="No"<?php if ($data['exc_hypo']!="Yes") { echo " selected"; } ?>>No</option>		<!--default to no-->
		</select>
		<br />
		
		Usage <input type="text" name="drug_usage" placeholder="" <?php if ($data['usage']!="") { echo "value='" . $data['usage'] . "' "; } ?>/><br />
		
		FDA Approval Status
		<select name="drug_fda_approval">
			<option value="Yes"<?php if ($data['exc_hypo']=="Yes") { echo " selected"; } ?>>Yes</option>
			<option value="No"<?php if ($data['exc_hypo']!="Yes") { echo " selected"; } ?>>No</option>	<!--default to no-->
		</select>
		<br />
	</div>


	<script>
	var outcome_num = 0;
	var str_to_append = 'Sub-Study <input type="text" name="outcome_substudy" placeholder="" /><br />	\
	Outcome <input type="text" name="outcome_measure" placeholder="" /><br />	\
	Side-effects <input type="text" name="outcome_side_effects" placeholder="" /><br />	\
	Baseline Drug <input type="text" name="outcome_baseline_drug" placeholder="" /><br />	\
	Baseline SD <input type="text" name="outcome_baseline_SD" placeholder="" /><br />	\
	Baseline Placebo <input type="text" name="outcome_baseline_placebo" placeholder="" /><br />		\
	Baseline Placebo SD <input type="text" name="outcome_baseline_placebo_SD" placeholder="" /><br />	\
	Outcomes Drug <input type="text" name="outcome_outcomes_drug" placeholder="" /><br />	\
	Outcomes Drug SD <input type="text" name="outcome_outcomes_drug_SD" placeholder="" /><br />	\
	Placebo Outcomes <input type="text" name="outcome_placebo_outcomes" placeholder="" /><br />	\
	Placebo Outcomes SD <input type="text" name="outcome_placebo_outcomes_SD" placeholder="" /><br />	\
	Effect Size <input type="text" name="outcome_effect_size" placeholder="" /><br />	\
	P-value <input type="text" name="outcome_p_value" placeholder="" /><br /><hr /><br />';
	function remove_outcome (num) {
		console.log(num);
		$("#outcome" + num).remove();
		console.log( "#outcome" + num );
	}
	function add_outcome() {
		outcome_num = outcome_num + 1;
		$("#outcome_box").append('<div id="outcome' + outcome_num + '" class="outcome_sub">' + '<h3>Outcome #' + outcome_num + '</h3> - <small><a onclick="remove_outcome(' + outcome_num + ')">Delete this outcome</a></small><br />' + str_to_append + '</div>');
		$("#outcome_box").show();
	}
	</script>
	<h3><a style="margin-left:60px;" onclick="add_outcome();">Add an Outcome</a></h3>



	<div class="info_box" id="outcome_box">
		<h2>Outcome Information</h2>
	</div>

	<br clear="both" /><br />
	<center><input type="submit" value="Submit Data" /></center>
</form>
<?php include("footer.php"); ?>