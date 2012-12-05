<?php
/**
 * CLinksColumn class file.
 *
 */

Yii::import('zii.widgets.grid.CGridColumn');
Yii::import('zii.widgets.grid.CLinkColumn');

/**
 * LinksColumn represents a grid view column that renders one or more hyperlinks in each of its data cells.
 *
 * The {@link label} and {@link url} properties determine how each hyperlink will be rendered.
 * The {@link labelExpression}, {@link urlExpression} properties may be used instead if they are available.
 * In addition, if {@link imageUrl} is set, an image link will be rendered.
 *
 */
class LinksColumn extends CLinkColumn
{
	/**
	 * @var string the seperator to use between multiple links.
	 */
	public $separator=', ';
	
	/**
	 * Renders the data cell content.
	 * This method renders a hyperlink in the data cell.
	 * @param integer $row the row number (zero-based)
	 * @param mixed $data the data associated with the row
	 */
	protected function renderDataCellContent($row,$data)
	{
		if($this->urlExpression!==null)
			if(is_array($this->urlExpression)){
				$url = array();
				$models = $this->evaluateExpression($this->urlExpression['model'],array('data'=>$data,'row'=>$row));
				foreach($models as $model){
					$params = array();
					if (isset($this->urlExpression['params'])){
						$params = $this->urlExpression['params'];
					}
					foreach($this->urlExpression['modelParams'] as $name=>$param){
						$params[$name] = $model->{$param};
					}
					$urlStr = Yii::app()->createUrl($this->urlExpression['route'], $params);
					//$urlStr = $this->urlExpression['route'] .'?';
					//foreach($this->urlExpression['params'] as $name=>$param){
					//	$urlStr .= $name .'=' . $model->{$param};
					//}
					$url[] = $urlStr;
				}
			}else
			$url=$this->evaluateExpression($this->urlExpression,array('data'=>$data,'row'=>$row));
		else
		$url=$this->url;
		if($this->labelExpression!==null)
			$label=$this->evaluateExpression($this->labelExpression,array('data'=>$data,'row'=>$row));
		else
			$label=$this->label;
		$options=$this->linkHtmlOptions;
		if(is_string($this->imageUrl))
			echo CHtml::link(CHtml::image($this->imageUrl,$label),$url,$options);
		else if(is_array($label)){
			$urlStr = '';
			if(is_array($url)){
				foreach($url as $i => $urlVal){
					$urlStr .= CHtml::link($label[$i],$urlVal,$options). $this->separator;
				}
			}
			else {
				foreach($label as $i => $labelVal){
					$urlStr .= CHtml::link($labelVal,$url,$options). $this->separator;
				}
			}
			if (strlen($urlStr)>1 ) $urlStr =  substr($urlStr, 0, -strlen($this->separator)); // trim last seperator
			echo $urlStr;
		}
		else
			echo CHtml::link($label,$url,$options);
	}
}
