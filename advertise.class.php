<?php

class advertise extends WidgetHandler
{
	function proc($args)
	{
		$tpl_path = sprintf('%sskins/%s', $this->widget_path, $args->skin);
		$tpl_file = 'ads';

		$advertise = \Rhymix\Modules\Advertise\Models\Advertise::getOneActiveAdvertise();
		if ($args->size == 'big')
		{
			$width = 728;
			$height = 90;
			$img_url = $advertise->big_img_url;
		}
		else
		{
			$width = 320;
			$height = 100;
			$img_url = $advertise->small_img_url;
		}

		$click_url = getUrl('','mid','ads','act','dispAdvertiseMoveUrl','advertise_srl',$advertise->advertise_srl);
		$title = $advertise->title;

		Context::set('title', $title);
		Context::set('size', $args->size);
		Context::set('width', $width);
		Context::set('height', $height);
		Context::set('image_url', $img_url);
		Context::set('click_url', $click_url);
		Context::set('assign_banner_visible', $args->assign_banner_visible == 'Y');

		// Compile a template
		$oTemplate = &TemplateHandler::getInstance();
		return $oTemplate->compile($tpl_path, $tpl_file);
	}
}