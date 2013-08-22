<?php
//need to first check if user is still logged in
if (isset($_SESSION["user"])) {
	$user = $_SESSION["user"];
} else {
	unset($_SESSION["user"]);
	unset($_SESSION["pass"]);
	header( 'Location: login.php?error=submit_log' ) ;
}
if (isset($_SESSION["pass"])) {
	$pass = $_SESSION["pass"];
} else {
	unset($_SESSION["user"]);
	unset($_SESSION["pass"]);
	header( 'Location: login.php?error=submit_log' ) ;
}
//now check if user/pass is correct
$correct_login = false;
$fh=fopen("users.txt", "r");
while($line = fgets($fh)) {
	$thisline = explode("\t", $line);
	$user_check = str_replace("\r", "", $thisline[0]);
	$user_check = str_replace("\n", "", $user_check);
	$pass_check = str_replace("\r", "", $thisline[1]);
	$pass_check = str_replace("\n", "", $pass_check);
	if (($user_check == $user) && ($pass_check == $pass)) {
		$correct_login = true;
		break;
	}
}
fclose($fh);
if (! $correct_login) {
	unset($_SESSION["user"]);
	unset($_SESSION["pass"]);
	header( 'Location: login.php?error=submit_log' ) ;
}


$PMID = $_POST['pub_PMID'];
$fh=fopen("annotation/" . $PMID . ".csv", "w");

fwrite($fh, "pub_year" . "\t" . $_POST['publication_year'] . "\n");
fwrite($fh, "clinical_trial" . "\t" . $_POST['publication_clinical_trial'] . "\n");
fwrite($fh, "pub_country" . "\t" . $_POST['publication_country'] . "\n");
fwrite($fh, "pub_authors" . "\t" . $_POST['publication_authors'] . "\n");
fwrite($fh, "pub_title" . "\t" . $_POST['publication_title'] . "\n");
fwrite($fh, "inc_criteria" . "\t" . $_POST['publication_inclusion_criteria'] . "\n");
fwrite($fh, "pub_COI" . "\t" . $_POST['publication_conflict'] . "\n");
fwrite($fh, "treatment_focus" . "\t" . $_POST['publication_treatment_focus'] . "\n");
fwrite($fh, "drug_dosage" . "\t" . $_POST['publication_dosage'] . "\n");
fwrite($fh, "study_design" . "\t" . $_POST['publication_design'] . "\n");
fwrite($fh, "total_population" . "\t" . $_POST['publication_population'] . "\n");
fwrite($fh, "trial_length" . "\t" . $_POST['publication_trial_length'] . "\n");
fwrite($fh, "age_range" . "\t" . $_POST['publication_age_range'] . "\n");
fwrite($fh, "mean_age" . "\t" . $_POST['publication_age_mean'] . "\n");
fwrite($fh, "IQ" . "\t" . $_POST['publication_IQ'] . "\n");
fwrite($fh, "study_results" . "\t" . $_POST['publication_study_results'] . "\n");

fwrite($fh, "drug_name_generic" . "\t" . $_POST['drug_generic'] . "\n");
fwrite($fh, "drug_name_common" . "\t" . $_POST['drug_common'] . "\n");
fwrite($fh, "drug_class" . "\t" . $_POST['drug_class'] . "\n");
fwrite($fh, "drug_target" . "\t" . $_POST['drug_target'] . "\n");
fwrite($fh, "therapy_type" . "\t" . $_POST['drug_therapy_type'] . "\n");
fwrite($fh, "pharmacology" . "\t" . $_POST['drug_pharmacology'] . "\n");
fwrite($fh, "exc_hypo" . "\t" . $_POST['drug_excit_hypothesis'] . "\n");
fwrite($fh, "usage" . "\t" . $_POST['drug_usage'] . "\n");
fwrite($fh, "FDA" . "\t" . $_POST['drug_fda_approval'] . "\n");

fclose($fh);
header( 'Location: annotate.php?pmid=' . $PMID );
?>