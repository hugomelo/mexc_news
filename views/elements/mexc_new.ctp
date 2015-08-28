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
			case 'unified_search':
				$item = $data['SblSearchItem'];

				echo $this->Bl->h6(array('class' => 'post-type'), array(), 'Novidade');
				if (!empty($data['MexcSpace']['FactSite'][0]['name']))
					echo $this->Bl->div(array('class' => 'project'), array(), $data['MexcSpace']['FactSite'][0]['name']);
				echo $this->Bl->div(array('class' => 'post-date'), array(), date('d/m/Y',strtotime($item['date'])));
				echo $this->Bl->h5(array('class' => 'title'), array(), $item['title']);
				echo $this->Bl->div(array('class' => 'post-body'), array(), $item['summary']);
				echo $this->Bl->div(array('class' => 'post-footer-hidder'));
			break;
		}
	break;

	case 'columns':
		$size['M'] = $type[1];
		$buffer = array();
		$old_month;
		$line = $count = 0;
		foreach ($data as $n => $new)
		{
			$news_time = strtotime($new['MexcNew']['date']);
			$end_of_line = ($n+1)%($size['M']/3) == 0;
			
			$month_name = br_strftime('%B / %Y', $news_time);
			$month = date('mY', $news_time);
			if (empty($old_month))
				$old_month = $month;
			
			if (!isset($buffer[$line]['labels'][$month_name]))
				$buffer[$line]['labels'][$month_name] = 0;
			
			$buffer[$line]['labels'][$month_name]++;
			$buffer[$line]['buffer'][] = 
				$this->Bl->sbox(array(), array('size' => array('M' => 3, 'g' => -1), 'type' => 'inner_column'))
				. $this->Jodel->insertModule('MexcNews.MexcNew', array('column'), $new)
				. $this->Bl->ebox();
			
			if ($end_of_line)
				$line++;
		}

		echo $this->Bl->sboxContainer(array(), array('size' => array('M' => $size['M']), 'type' => 'column_container'));
			foreach($buffer as $n => $line)
			{
				foreach ($line['labels'] as $label => $span)
					echo $this->Bl->box(
						array('class' => 'date_span' . (isset($buffer[$n+1]['labels'][$label]) ? ' continued' : '') . (isset($buffer[$n-1]['labels'][$label]) ? ' continuing' : '')),
						array('size' => array('M' => 3*$span, 'g' => -1, 'm' => -2),'type' => 'inner_column'),
						$this->Bl->spanDry($label)
					);
				echo $this->Bl->floatBreak();
				echo implode('', $line['buffer']);
				echo $this->Bl->floatBreak();
				echo $this->Bl->br();
			}
		echo $this->Bl->eboxContainer();
	break;
	
	case 'column':
		$factSite = isset($type[1]) && $type[1] == 'fact_site';
		$related = isset($type[1]) && $type[1] == 'related_content';
		
		if ($factSite || $related)
		{
			$date = $this->Bl->date(array(), array('date' => $data['MexcNew']['date']));
			echo $this->Bl->span(array('class' => 'light'), array(), $date.', por '.$data['MexcNew']['author']);
			echo $this->Bl->br();
		}
		
		if ($currentSpace != $data['MexcNew']['mexc_space_id'])
			echo $this->Bl->mexcSpaceTag(array(), array('space_id' => $data['MexcNew']['mexc_space_id']));
		
		echo $this->Bl->sh4();
			echo $this->Bl->anchor(
					array('class' => 'visitable'), 
					array(
						'url' => array('plugin' => 'mexc_news', 'controller' => 'mexc_news', 'action' => 'read', $data['MexcNew']['id']),
						'space' => $data['MexcNew']['mexc_space_id']
					),
					$data['MexcNew']['title']
				);
		echo $this->Bl->eh4();
		echo $this->Bl->br();
		
		if (!empty($data['MexcNew']['img_id']))
		{
			$options['id'] = $data['MexcNew']['img_id'];
			$options['version'] = 'preview_column';
			if ($factSite)
				$options['version'] = 'preview_column_fact';
			
			echo $this->Bl->img(array(), $options);
		}
		echo $this->Bl->paraDry(explode("\n", $data['MexcNew']['summary']));
	break;
	
	case 'column_grande_desafio':
		$data_mostrada = date('m/d/Y', strtotime($data['MexcNew']['date']));
		echo $mexc->data($data_mostrada, 'longo');
		echo $this->Bl->br();

		echo $gd->linque(
			$data['MexcNew']['title'],
			array('plugin' => 'grandedesafio', 'edicao' => $edicao['Edicao']['id'], 'edicao' => $edicao['Edicao']['id'], 'controller' => 'novidades', 'action' => 'artigo', $data['MexcNew']['id'])
		);
		
		echo $this->Bl->br();
		
		if (!empty($data['MexcNew']['img_id']))
		{
			$options['id'] = $data['MexcNew']['img_id'];
			$options['version'] = 'preview_column';
			echo $this->Bl->img(array('class' => 'blog_imagem'), $options);
		}
		
		echo $html->para('',$mexc->paragrafos($data['MexcNew']['summary'], null, true), array('style' => 'margin-bottom: 20px;'));
		
	break;
	
	case 'line':
		echo $this->Bl->sboxContainer(array('class' => 'mexc_list'), array('size' => array('M' => $type[1]), 'type' => 'column_container'));
			echo $this->Bl->box(
				array('class' => 'line_date'),
				array('size' => array('M'=> 1, 'm' => -1)),
				$this->Bl->date(
					array(), 
					array(
						'date' => $data['MexcNew']['date'],
						'format' => 'simple'
				))
			);
			echo $this->Bl->sbox(array('class' => 'mexc_list_link'), array('size' => array('M' => $type[1]-1, 'g' => -2)));
				if ($currentSpace != $data['MexcNew']['mexc_space_id'])
					echo $this->Bl->mexcSpaceTag(array(), array('space_id' => $data['MexcNew']['mexc_space_id']));
				
				echo $this->Bl->anchor(
					array('class' => 'visitable'), 
					array(
						'url' => array('plugin' => 'mexc_news', 'controller' => 'mexc_news', 'action' => 'read', $data['MexcNew']['id']),
						'space' => $data['MexcNew']['mexc_space_id']
					),
					$data['MexcNew']['title']
				);
			echo $this->Bl->ebox();
			echo $this->Bl->floatBreak();
		echo $this->Bl->eboxContainer();
		echo $this->Bl->floatBreak();
	break;
	
	case 'line_olimpiada':
		$data_mostrada = date('m/d/Y', strtotime($data['MexcNew']['date']));
		echo $mexc->data($data_mostrada, 'longo');
		echo $this->Bl->br();
		
		echo $this->Bl->sh4();
			echo $this->Bl->anchor(
				array('class' => 'link_texto link_em_nuvem'), 
				array('url' => array(
					'edicao' => $edicao, 'controller' => 'blog', 'plugin' => 'olimpiada', 'action' => 'novidade#'. $data['MexcNew']['id'])
				),
				$data['MexcNew']['title']
			);
		echo $this->Bl->eh4();
		echo $this->Bl->br();
		echo $this->Bl->floatBreak();
	break;
	
	case 'two_lines':
		echo $this->Bl->sdiv();
			echo $this->Bl->span(array('class' => 'small light'), array(), date('d/m/y', strtotime($data['MexcNew']['date'])));
			echo $this->Bl->br();
			echo $this->Bl->anchor(
				array('class' => 'visitable'), 
				array(
					'url' => array('plugin' => 'mexc_news', 'controller' => 'mexc_news', 'action' => 'read', $data['MexcNew']['id']),
					'space' => $data['MexcNew']['mexc_space_id']
				),
				$data['MexcNew']['title']
			);
		echo $this->Bl->ediv();
	break;
	
	case 'full':
		echo $this->Bl->h1Dry($data['MexcNew']['title']);
		
		$about = 'Publicada em ' . br_strftime('%d de %B', strtotime($data['MexcNew']['date'])) . ' por ' . $data['MexcNew']['author'];
		echo $this->Bl->span(array('class' => 'small'), array(), $about);
		echo $this->Bl->br();
		
		if (!empty($data['Tag']))
			echo $this->Bl->tagList(array(),array('tags' => $data['Tag'])),
				 $this->Bl->br();
		
		echo $this->Bl->hr(array('class' => 'double'));
		
		if (!empty($data['MexcNew']['img_id']) && $data['MexcNew']['embed_picture'])
			echo $this->Bl->img(array(), array('id' => $data['MexcNew']['img_id'], 'version' => 'view'));
		
		echo $this->Jodel->insertModule('ContentStream.CsContentStream', array('full', 'mexc_new'), $data['MexcNew']['content_stream_id']);
		
		echo $this->Bl->br();
		echo $this->Bl->hr();
		
		echo $this->element('social_medias', array('plugin' => false, 'module' => 'MexcNew'));
		
	break;
	
	case 'full_olimpiada':
		$data_mostrada = strtotime($data['MexcNew']['date']);
		$data_mostrada = date('m/d/Y', $data_mostrada);
		
		echo '<a id="'.$data['MexcNew']['id'].'"></a>';
		echo $olimpiada->subtitulo($data['MexcNew']['title']);
		echo '<span class="texto_pequeno mais_forte"> Postado por '. $data['MexcNew']['author'] .' em '.$mexc->data($data_mostrada,'longo').'</span>';

		if (!empty($data['MexcNew']['img_id']) && $data['MexcNew']['embed_picture'])
			echo $this->Bl->img(array('class' => 'blog_grande_imagem'), array('id' => $data['MexcNew']['img_id'], 'version' => 'view'));

		echo $this->Jodel->insertModule('ContentStream.CsContentStream', array('full', 'mexc_new'), $data['MexcNew']['content_stream_id']);
		echo $this->Bl->br();
		
	break;
	
	
	case 'full_grande_desafio':
		$data_mostrada = strtotime($data['MexcNew']['date']);
		$data_mostrada = date('m/d/Y', $data_mostrada);
		
		echo $html->tag('h2',$data['MexcNew']['title'], array('style' => 'margin-bottom: 3px;'));
		echo $html->para('mais_forte','Postado por '.$data['MexcNew']['author'].' em '.$mexc->data($data_mostrada, 'longo'));
		
		if (!empty($data['MexcNew']['img_id']) && $data['MexcNew']['embed_picture'])
			echo $this->Bl->img(array('class' => 'blog_grande_imagem'), array('id' => $data['MexcNew']['img_id'], 'version' => 'view'));
			
		echo $this->Jodel->insertModule('ContentStream.CsContentStream', array('full', 'mexc_new'), $data['MexcNew']['content_stream_id']);
		echo $this->Bl->br();
	break;
}
