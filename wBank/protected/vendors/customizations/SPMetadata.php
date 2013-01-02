<?php
Yii::import('application.vendors.onelogin.src.OneLogin.Saml.*');		
require_once 'Metadata.php';	

/**
 * Create SAML2 Metadata documents
 */
class SPMetadata extends OneLogin_Saml_Metadata
{
    /**
     * @return string
     */
    public function getXml()
    {

        return <<<METADATA_TEMPLATE
<?xml version="1.0"?>
<md:EntityDescriptor xmlns:md="urn:oasis:names:tc:SAML:2.0:metadata"
                     entityID="{$this->_settings->spIssuer}">
    <md:SPSSODescriptor protocolSupportEnumeration="urn:oasis:names:tc:SAML:2.0:protocol">
        <md:NameIDFormat>{$this->_settings->requestedNameIdFormat}</md:NameIDFormat>
        <md:AssertionConsumerService Binding="urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST"
                                     Location="{$this->_settings->spReturnUrl}"
                                     index="1"/>
    </md:SPSSODescriptor>
</md:EntityDescriptor>
METADATA_TEMPLATE;
    }

    
	
}