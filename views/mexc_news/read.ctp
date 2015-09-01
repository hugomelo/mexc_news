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

echo $this->element('header-read', array('title' => $new['MexcNew']['title'], 'slug'=>'news'));

echo $this->Bl->floatBreak();
echo $this->Bl->srow(array('class' => 'pages news'));
	echo $this->Bl->hr(array('class' => 'col-xs-12'));
	
	echo $this->Bl->sdiv(array('class' => 'col-xs-12 col-md-3 meta'), array());
		echo $this->Bl->div(array(), array(), 
			br_strftime("%d de %B, %Y",strtotime($new['MexcNew']['date']))
		);
		echo $this->Bl->div(array(), array(), 
			'por '.$new['MexcNew']['author']
		);
	echo $this->Bl->hr(array('class' => 'meta'));
		if (isset($new['Tag'])) {
			foreach($new['Tag'] as $tag) {
				echo $this->Bl->anchor(array(), array('url' => '/tag/'.$tag['keyname']), $tag['name']);
				if ($tag != end($new['Tag'])) echo ", ";
			}
			echo $this->Bl->hr(array('class' => 'meta'));
		}
	echo $this->Bl->ediv();
	echo $this->Bl->sdiv(array('class' => 'col-xs-12 col-md-9'), array());
		echo $this->Bl->srow(array('class' => ''));
			echo $this->Jodel->insertModule('ContentStream.CsContentStream', array('full', 'mexc_new'), $new['MexcNew']['content_stream_id']);
		echo $this->Bl->erow();
	echo $this->Bl->ediv();
	echo $this->Bl->hr(array('class' => 'col-xs-12'));

	if (!empty($new['MexcRelatedContent'])) {
		echo $this->Bl->h5(array('class' => 'related_content'), array(), 'Notícias relacionadas');
		echo $this->Bl->sdiv(array('class' => 'col-xs-12 related_content'), array());
			echo $this->Jodel->insertModule('MexcRelated.MexcRelatedContent', array('full'), $new);
		echo $this->Bl->ediv();
	}
echo $this->Bl->erow();
	
	
