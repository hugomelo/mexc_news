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

echo $this->Bl->floatBreak();
echo $this->Bl->srow(array('class' => 'pages news'));
	echo $this->element('header', array('title' => 'Novidades', 'slug'=>'news'));
echo $this->Bl->erow();

echo $this->Jodel->insertModule('MexcNews.MexcNew', array('columns', 12), $mexc_news);
