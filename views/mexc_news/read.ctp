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

echo $this->Bl->sbox(array(), array('size' => array('M' => 6, 'g' => -1), 'type' => 'cloud'));
	
	echo $this->Jodel->insertModule('MexcNews.MexcNew', array('full'), $new);
	
	echo $this->Bl->hr(array('class' => 'double'));
	
	// @todo Thread of comments
	
echo $this->Bl->ebox();


echo $this->Bl->sbox(array('class' => 'more_content'), array('type' => 'sky', 'size' => array('M' => 6, 'g' => -1)));
	// @todo Link to the right place
	echo $this->Bl->anchor(
		array('class' => 'non_visitable'),
		array('url' => array('plugin' => 'mexc_news', 'controller' => 'mexc_news', 'action' => 'index')),
		'Outras novidades do Museu'
	);
echo $this->Bl->ebox();


$second_column = !empty($new['MexcRelatedContent']) || !empty($latest_news) || !empty($latest_events);

if ($second_column)
{
	echo $this->Bl->sboxContainer(array(), array('size' => array('M' => 6)));
	echo $this->Bl->h2Dry(__d('mexc', 'veja também', true));
	echo $this->Bl->br();
}

if (!empty($new['MexcRelatedContent']))
{
	echo $this->Jodel->insertModule('MexcRelated.MexcRelatedContent', array('full', 6), $new);
}


if (!empty($latest_news))
{
	echo $this->Bl->sbox(array(), array('size' => array('M' => 3, 'g' => -1), 'type' => 'cloud'));
		
		echo $this->Bl->h5Dry(__d('mexc','Novidades mais recentes', true));
		
		foreach ($latest_news as $new)
		{
			echo $this->Bl->hr(array('class' => 'dotted'));
			echo $this->Jodel->insertModule('MexcNews.MexcNew', array('two_lines'), $new);
		}
		
	echo $this->Bl->ebox();
}

if (!empty($latest_events))
{
	echo $this->Bl->sbox(array(), array('size' => array('M' => 3, 'g' => -1), 'type' => 'cloud'));
		
		echo $this->Bl->h5Dry(__d('mexc', 'Agenda', true));
		
		foreach ($latest_events as $event)
		{
			echo $this->Bl->hr(array('class' => 'dotted'));
			echo $this->Jodel->insertModule('MexcEvents.MexcEvent', array('two_lines'), $event);
		}
		
	echo $this->Bl->ebox();
}

if ($second_column)
{
	echo $this->Bl->eboxContainer();
}

