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

echo $this->element('search_box', array('module' => 'mexc_new'));

$size = array('M' => 9, 'g' => -1);
if ($currentSpace != null)
{
	$size['M'] = 12;
	echo $this->Bl->anchor(
		array('class' => 'fact_link_search'),
		array('url' => array()),
		'Ir para a busca'
	);
	echo $this->Bl->floatBreak();
}

echo $this->Bl->sbox(array(), array('size' => $size, 'type' => 'cloud'));

	echo $this->Bl->h2(array('class' => 'section_title'), array(), 'Arquivo de novidades');
	echo $this->element('pagination', array('modules' => 9, 'top' => true));
	echo $this->Jodel->insertModule('MexcNews.MexcNew', array('columns', $size['M']), $mexc_news);
	echo $this->element('pagination', array('modules' => 9));
	
echo $this->Bl->ebox();

if (!empty($mexc_scientific_news) && $currentSpace == null)
{
	echo $this->Bl->sbox(array('id' => 'science_news'), array('size' => array('M' => 3, 'g' => -1), 'type' => 'cloud'));
		
		echo $this->Bl->h2(array('class' => 'section_title'), array(), 'Notícias de ciências');
		echo $this->Bl->br();
		
		foreach ($mexc_scientific_news as $new)
		{
			echo $this->Jodel->insertModule('MexcScientificNews.MexcScientificNew', array('view'), $new);
			echo $this->Bl->hr(array('class' => 'dotted'));
		}
		
		echo $this->Bl->anchor(array(), array('url' => '', 'type' => 'to_right'), 'carregar mais');
	echo $this->Bl->ebox();
}
