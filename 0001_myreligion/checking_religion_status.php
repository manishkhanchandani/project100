<?php

//a. if this record has status of approved, then do nothing, let user go ahead
if ($row_rsReligion['religion_status'] == 1) {

}//end if, don't do anything, just pass

//b. if status is deleted (2), then don't show view page or religion page to owner and anyone on the site.
if ($row_rsReligion['religion_status'] == 2) {
	//don't allow anyone, i will redirect user to index.php
	header("Location: index.php");
	exit;
}//end if

//c. , and if it not approved then i will check if logged in user is owner of this religion
if ($row_rsReligion['religion_status'] != 1) {
	if ($_SESSION['MM_UserId'] == $row_rsReligion['user_id']) {
		//allow to go into the page
	} else {
		header("Location: index.php");
		exit;
	}
}

if ($row_rsReligion['religion_status'] == 1) {
	//c. if it is public, allow any one to add
	if ($row_rsReligion['religion_type'] === 'public') {
		//allow all the users to go
	} else if ($row_rsReligion['religion_type'] === 'closed') {
		if ($_SESSION['MM_UserId'] == $row_rsReligion['user_id']) {
			//allow user to edit the page
		} else {
			header("Location: index.php");
			exit;
		}//end if
	}//end if
}
?>