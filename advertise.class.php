<?php

class advertise extends WidgetHandler
{
	function proc($args)
	{
		$tpl_path = sprintf('%sskins/%s', $this->widget_path, $args->skin);
		$tpl_file = 'ads';

		$advertise = \Rhymix\Modules\Advertise\Models\Advertise::getOneActiveAdvertise();
		$advertise_type = $advertise->advertise_type;
		if ($args->size == 'big')
		{
			$width = 728;
			$height = 90;
		}
		else
		{
			$width = 320;
			$height = 100;
		}
		
		if ($advertise_type == 'image')
		{
			if ($args->size == 'big')
			{
				$img_url = $advertise->big_img_url;
			}
			else
			{
				$img_url = $advertise->small_img_url;
			}
		}
		else if ($advertise_type == 'text')
		{
			$img_url = $advertise->thumb_img_url;
		}
		else if ($advertise_type == 'raw')
		{
			$img_url = null;
		}
		else
		{
			return;
		}

		$click_url = getUrl('','mid','ads','act','dispAdvertiseMoveUrl','advertise_srl',$advertise->advertise_srl);
		$title = $advertise->title;
		$content = $advertise->content;
		$assign_banner_visible = $args->assign_banner_visible == 'Y' && $advertise->hide_new_add != 'Y';

		Context::set('title', $title);
		Context::set('content', $content);
		Context::set('size', $args->size);
		Context::set('width', $width);
		Context::set('height', $height);
		Context::set('image_url', $img_url);
		Context::set('click_url', $click_url);
		Context::set('advertise_type', $advertise_type);
		Context::set('assign_banner_visible', $assign_banner_visible);

		// Compile a template
		$oTemplate = &TemplateHandler::getInstance();
		return $oTemplate->compile($tpl_path, $tpl_file);
	}
}