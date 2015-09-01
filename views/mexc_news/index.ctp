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

echo $this->element('header-index', array('title' => 'Novidades', 'slug'=>'news'));

echo $this->Bl->srow(array('class' => 'pages news'));
	echo $this->Bl->sdiv(array('class' => "posts-list"), array());
		foreach ($mexc_news as $new) {
			echo $this->Bl->sdiv(array('class' => "col-xs-12 col-sm-6 col-md-4"), array());
				echo $this->Bl->sdiv(array('class' => "post new"), array());
					echo $this->Jodel->insertModule('MexcNews.MexcNew', array('preview', 'box'), $new);
				echo $this->Bl->ediv();
			echo $this->Bl->ediv();
		}
	echo $this->Bl->ediv();
echo $this->Bl->erow();
