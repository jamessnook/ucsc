<?php
/**
 * XMLUpdater handels calls to XML services to retreive data and update local datastores.
 * 
 * @author JSnook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.components
 */
class XMLReader extends DataReader
{
	
	/**
	 * 
	 * This is a genreral purpose update function used to call an xml service and import and save data to the applications models.
	 * @param striing $data    string of XML data.
	 */
    public function processData($data)
    {
		$xml = simplexml_load_string($data);
    	if (isset($this->config['elements'])){
    		$elementConfigs = $this->config['elements'];
    		// parse XML and create objects
			foreach ($xml->children() as $elem) {
				// find config or set to null
				$config = null;
				if (isset($elementConfigs[$elem->getName()])){
					$config = $elementConfigs[$elem->getName()];
				}
				$this->updateElement($elem, $config);  // recursive
			}
		}
    }

    
    /**
	 * 
	 * Recursive function to import the data in an individual xml element (node) into the local models
	 * This method attempts to match the axml data to models using naming configured in the config/main.php.  
	 * If there is no config information for a node the code attempts to match the node name to attributes or model names directly 
	 * or by translating from camel case to underbar naming conventions.
	 * @param SimpleXMLElement $xml  An object reperesentation of an xml node.
	 * @param array $config an array holdong the config information from config/main.php providing needed information about the schema for the xml.
	 * @param SimpleXMLElement $parent  An object reperesentation of the parent xml node. IF $xml has no parent then $parent is null.
	 */
    public function updateElement($elem, $config = null, $parent = null)
    {
		// Check for mapper.  If a mapper class is configured for this node then it is called 
		// to import the object rather then using the code below
		if ($config && isset($config['mapper'])){
			$model = new $config['mapper']($elem);
		} else { // If no mapper class is set then use the config information or name matching to help import the object
			if ($config && isset($config['model'])){  // see if a model class name is defined in the config
				$model = new $config['model'];
			} 
			else if (@class_exists($elem->getName())) { // If no model class name is defined try to use the xml element name
				// the @ in the call above suppresses warnings from the autoloader if the class is not found
				$className = $elem->getName();
				$model = new $className;
			} 
			else { // If no model class can be identified for this element do not import it
				return;
			}
			// First assign any inherited parent attributes which might be inherited by default, these will later be overridden if needed
			if ($parent){
				foreach ($parent->children() as $possibleAttribute) {
					// first look for configured parent attributes
					if ($config && isset($config['parentAttributes'][$possibleAttribute->getName()])){
						$model->setAttribute($config['parentAttributes'][$possibleAttribute->getName()],(string)$possibleAttribute); // safely returns false if attribute does not exist
					}
					// try name matching any parent attributes to child attributes (often needed in many-many associatin tables.)
					else if (!$model->setAttribute($possibleAttribute->getName(),(string)$possibleAttribute)){ 
						if (strtolower($possibleAttribute->getName()) == "id" ){  // special case to get parent id as default
							$model->setAttribute($parent->getName()."Id",(string)$possibleAttribute);
						}
					}
				}
			}
			// For child elements the which are multible elements with the same name 
			// but where the child element is a single value, this value needs to be mapped to an attribute of the child.  
			// This is common for many to many associations such as emplid for course instructors included in the class (course) element.
			if ($config && isset($config['thisAsAttribute'])){
				$model->setAttribute($config['thisAsAttribute'],(string)$elem); // safely returns false if attribute does not exist
			}
			// Now assign any hard coded defualts for child attributes.
			if ($config && isset($config['defaults'])){
				foreach ($config['defaults'] as $name=>$value) {
					$model->setAttribute($name, $value); // safely returns false if attribute does not exist
				}
			}
			// Now look at each of the attributes of the current xml element and try to import them.
			foreach ($elem->attributes() as $attribute) {
				assignItem($attribute, $config);
			}
			// Now look at each of the child nodes of the current xml element and try to import them as attribute or child elements.
			foreach ($elem->children() as $child) {
				assignItem($child, $config);
			}
		}
		// update or save model
		// If there is already data in the database for this primary key then perform an update, other wise do a save
		$modelPrior = $model->findByPk($model->getPrimaryKey());  
		if(!$modelPrior) {  // save
			$model->save();			
		} else{  // update
			$modelPrior->updateByPk($model->getPrimaryKey(), $model->getAttributes());			
		}
    }
    
	/**
	 * 
	 * Trys to match up an attribute or node and assign it to the model
	 * @param SimpleXMLElement $item  An object reperesentation of an xml node.
	 * @param array $config an array holdong the config information from config/main.php providing needed information about the schema for the xml.
	 * @param SimpleXMLElement $parent  An object reperesentation of the parent xml node. IF $xml has no parent then $parent is null.
	 */
    public function assignItem($item, $config = null, $parent = null)
    {
		// see if there is an attriute name defined in the config for this node 
		if ($config && isset($config['attributes'][$item->getName()])){
			$model->setAttribute($config['attributes'][$item->getName()],(string)$item); // safely returns false if attribute does not exist
		}
		// if there is no attriute name defined in the config for this node see if it is configed 
		// as a child element and call this method recursively
		else if ($config && isset($config['children'][$item->getName()])){
			$this->updateElement($item, $config['children'][$item->getName()], $elem);
		}
		// if there is no config setting for this attribute see if the xml node name matches a model attribute
		else if (!$model->setAttribute($item->getName(),(string)$item)){ // safely returns false if attribute does not exist
			// IF there is still no match try matching the node name to a possible child element model class 
			if (@class_exists($item->getName())) {
				// the @ in the call above suppresses warnings from the autoloader if the class is not found
				$this->updateElement($item);
			} 
		}
    }
}