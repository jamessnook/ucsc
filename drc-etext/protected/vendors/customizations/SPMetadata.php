<?php
Yii::import('application.vendors.onelogin.src.OneLogin.Saml.*');		
require_once 'Metadata.php';	

/**
 * Create SAML2 Metadata documents
 */
class SPMetadata extends OneLogin_Saml_Metadata
{
    /**
     * How long should the metadata be valid?
     */
    const VALIDITY_SECONDS = 4000000000; // 100 years+


}