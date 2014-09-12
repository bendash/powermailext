#
# Table structure for table 'tx_powermail_domain_model_fields'
#
CREATE TABLE tx_powermail_domain_model_fields (
	tx_powermailext_disabled tinyint(4) DEFAULT '0' NOT NULL,
	tx_powermailext_readonly tinyint(4) DEFAULT '0' NOT NULL,
	tx_powermailext_maxlength int(11) DEFAULT '0' NOT NULL,
	tx_powermailext_dependency tinyint(4) DEFAULT '0' NOT NULL,
	tx_powermailext_dependency_field int(11) DEFAULT '0' NOT NULL,
	tx_powermailext_dependency_operator tinyint(4) DEFAULT '0' NOT NULL,
	tx_powermailext_dependency_value varchar(255) DEFAULT '' NOT NULL,
	tx_powermailext_dependency_action tinyint(4) DEFAULT '0' NOT NULL,
	tx_extbase_type VARCHAR(255) DEFAULT 'Tx_Powermailext_Domain_Model_Field' NOT NULL,
);