<?php

class advertise extends WidgetHandler
{
	function proc($args)
	{
		if ($arg->skin == '/USE_DEFAULT/') $arg->skin = 'default';

		$tpl_path = sprintf('%sskins/%s', $this->widget_path, $args->skin);
		$tpl_file = 'ads';

		$advertise = \Rhymix\Modules\Advertise\Models\Advertise::getOneActiveAdvertise();
		$advertise_type = $advertise->advertise_type;
		if ($args->size == 'auto')
		{
			$args->size =  Mobile::isFromMobilePhone() ? 'small' : 'big';
		}

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
			$height = -1;
		}
		else
		{
			return;
		}

		$click_url = getUrl('','mid','ads','act','dispAdvertiseMoveUrl','advertise_srl',$advertise->advertise_srl);
		$title = $advertise->title;
		$content = $advertise->content;
		$assign_banner_visible = $args->assign_banner_visible == 'Y' && $advertise->hide_new_add != 'Y';

		$button_color = $args->button_color ?: '#6f62a8';
		$button_text_color = $args->button_text_color ?: '#ffffff';
		$button_text = $args->button_text ?: '광고등록';
		$button_width_padding = $args->button_width_padding ?: '10px';
		$button_height_padding = $args->button_height_padding ?: '2px';
		Context::set('button_color', $button_color);
		Context::set('button_text_color', $button_text_color);
		Context::set('button_text', $button_text);
		Context::set('button_width_padding', $button_width_padding);
		Context::set('button_height_padding', $button_height_padding);

		Context::set('title', $title);
		Context::set('content', $content);
		Context::set('size', $args->size);
		Context::set('width', $width);
		Context::set('height', $height);
		Context::set('image_url', $img_url);
		Context::set('click_url', $click_url);
		Context::set('advertise_type', $advertise_type);
		Context::set('assign_banner_visible', $assign_banner_visible);
		Context::set('add_margin', $args->add_margin == 'Y' ? 'margin' : '');
		Context::set('advertise_srl', $advertise->advertise_srl);
		Context::set('auto_resize', $args->auto_resize == 'Y' ? 'auto_resize' : '');
		Context::set('width_full', $args->width_full == 'Y' ? 'width_full' : '');

		$logged_info = Context::get('logged_info');
		if ($logged_info->is_admin === 'Y')
		{
			Context::set('is_admin', true);
		}

		// Compile a template
		$oTemplate = &TemplateHandler::getInstance();
		return $oTemplate->compile($tpl_path, $tpl_file);
	}
}