<?php

/**
 *
 * Copyright 2011-2013, Museu Exploratório de Ciências da Unicamp (http://www.museudeciencias.com.br)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2011-2013, Museu Exploratório de Ciências da Unicamp (http://www.museudeciencias.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/museudecienciasunicamp/mexc_news.git Mexc News public repository
 */

switch ($type[0])
{
	case 'buro':
		switch ($type[1])
		{
			case 'form':
				echo $this->element('mexc_new_form', array('plugin' => 'mexc_news', 'data' => $data));
			break;
		}
	break;
	
	case 'list':
		foreach ($data as $one_data)
			echo $this->Jodel->insertModule('MexcNews.MexcNew', array($type[1]), $one_data);
	break;
	
	case 'preview':
		switch ($type[1])
		{
			case 'box':
			case 'unified_search':
				if (isset($data['MexcNew'])) {
					$item = $data['MexcNew'];
					$url = array('plugin' => 'mexc_news', 'controller' => 'mexc_news', 'action' => 'read', $item['id']);
				}
				else {
					$item = $data['SblSearchItem'];
					$url = array('plugin' => 'mexc_news', 'controller' => 'mexc_news', 'action' => 'read', $item['foreign_id']);
				}


				echo $this->Bl->h6(array('class' => 'post-type'), array(), 'Novidade');
				if (!empty($data['MexcSpace']['FactSite'][0]['name'])) {
					echo $this->Bl->anchor(array(), array('url' => '/programas/'.$data['MexcSpace']['id']),
						$this->Bl->div(array('class' => 'project'), array(), $data['MexcSpace']['FactSite'][0]['name']));
				}
				echo $this->Bl->div(array('class' => 'post-date'), array(), date('d/m/Y',strtotime($item['date'])));
				echo $this->Bl->anchor(array(), array('url' => $url),
					$this->Bl->h5(array('class' => 'title'), array(), $item['title']));
				echo $this->Bl->anchor(array(), array('url' => $url),
					$this->Bl->div(array('class' => 'post-body'), array(), $item['summary']));
				echo $this->Bl->div(array('class' => 'post-footer-hidder'));
			break;
		}
	break;

		//if (!empty($data['MexcNew']['img_id']))
		//{
			//$options['id'] = $data['MexcNew']['img_id'];
			//$options['version'] = 'preview_column';
			//if ($factSite)
				//$options['version'] = 'preview_column_fact';
			
			//echo $this->Bl->img(array(), $options);
		//}
		//echo $this->Bl->paraDry(explode("\n", $data['MexcNew']['summary']));
	
}
