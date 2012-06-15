<?php
Yii::import('application.vendors.onelogin.src.OneLogin.Saml.*');		
require_once 'Response.php';	

/**
 * Create SAML2 Metadata documents
 */
class IDPResponse extends OneLogin_Saml_Response
{

    /**
     * Get the attributes provided by the SAML response from the IdP.
     * @return array of arrays holding attribute sets by name and index
     */
	public function getAttributes()
    {
        $entries = $this->_queryAssertion('/saml:AttributeStatement/saml:Attribute');

        $attributes = array();
        /** @var $entry DOMNode */
        foreach ($entries as $entry) {
            $attributeName = $entry->attributes->getNamedItem('Name')->nodeValue;

            $attributeValues = array();
            foreach ($entry->childNodes as $childNode) {
                //if ($childNode->tagName === 'saml:AttributeValue'){
                if ($childNode->tagName === 'saml:AttributeValue'
                	|| $childNode->tagName === 'saml2:AttributeValue'){
                     $attributeValues[] = $childNode->nodeValue;
                }
            }

            $attributes[$attributeName] = $attributeValues;
        }
        return $attributes;
    }


}