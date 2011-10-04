<?php

/**
 *@description: copy the commented lines to your own mysite/_config.php file for editing...
 *
 *
 **/


Director::addRules(50, array(
	ReceiveFromMyBusinessWorld::get_url_segment() . '/$Action/$ID/$OtherID' => 'ReceiveFromMyBusinessWorld'
));

// copy the lines below to your mysite/_config.php file and set as required.
// __________________________________START ECOMMERCE MY BUSINESS WORLD MODULE CONFIG __________________________________
//RequestInformationFromMBW::set_connection_credential_username("xxx");
//RequestInformationFromMBW::set_connection_credential_password("xxx");
//RequestInformationFromMBW::set_db_credentials_saccessarea("xxx");
//RequestInformationFromMBW::set_db_credentials_scustomernumber("xxx");
//RequestInformationFromMBW::set_db_credentials_spassword("xxx");
//RequestInformationFromMBW::set_db_credentials_smethod("xxx");
// __________________________________ END ECOMMERCE MY BUSINESS WORLD MODULE CONFIG __________________________________



