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

echo $this->Buro->sform(array(), array(
		'model' => $fullModelName,
		'callbacks' => array(
			'onStart' => array('lockForm', 'js' => 'form.setLoading()'),
			'onComplete' => array('unlockForm', 'js' => 'form.unsetLoading()'),
			'onReject' => array('js' => '$("content").scrollTo(); showPopup("error");', 'contentUpdate' => 'replace'),
			'onSave' => array('js' => '$("content").scrollTo(); showPopup("notice");'),
		)
	));
		
	echo $this->Buro->input(
		array(),
		array(
			'fieldName' => 'id',
			'type' => 'hidden'
		)
	);
	
	// Space tag
	echo $this->Buro->input(
		array(),
		array(
			'type' => 'mexc_space'
		)
	);
	
	// Hard relation with event?
	echo $this->Buro->input(
		array(),
		array(
			'type' => 'mexc_event'
		)
	);
	
	// Display Level
	echo $this->Buro->input(
		array(),
		array(
			'fieldName' => 'display_level',
			'type' => 'select',
			'label' => __d('mexc_new', 'form - display level label', true),
			'instructions' => __d('mexc_new', 'form - display level instructions', true),
			'options' => array('options' => array (
				'general' => 'Geral',
				'fact_site' => 'Só no espaço',
				'private' => 'Privado'
			))
		)
	);
	
	// New headline
	echo $this->Buro->input(
		array(),
		array(
			'fieldName' => 'title',
			'label' => __d('mexc_new', 'form - title label', true),
			'instructions' => __d('mexc_new', 'form - title instructions', true)
		)
	);
	
	// Author name
	echo $this->Buro->input(
		array(),
		array(
			'fieldName' => 'author',
			'label' => __d('mexc_new', 'form - author label', true),
			'instructions' => __d('mexc_new', 'form - author instructions', true),
			'options' => array(
				'default' => $userData['name']
			)
		)
	);
	
	// Tags
	echo $this->Buro->input(array(), 
		array(
			'type' => 'tags',
			'fieldName' => 'tags',
			'label' => __d('mexc_new', 'form - tags input label', true),
			'instructions' => __d('mexc_new', 'form - tags input instructions', true),
			'options' => array(
				'type' => 'comma'
			)
		)
	);
	
	// Date
	echo $this->Buro->input(
		array(),
		array(
			'fieldName' => 'date',
			'type' => 'datetime',
			'options' => array(
				'dateFormat' => 'DMY',
				'timeFormat' => false,
				'separator' => '',
				'minYear' => date('Y')-10,
				'maxYear' => date('Y')+4,
			),
			'label' => __d('mexc_new', 'form - date label', true),
			'instructions' => __d('mexc_new', 'form - date instructions', true)
		)
	);
	
	// Main image
	
	echo $this->Buro->sinput(null, array(
		'type' => 'super_field',
		'label' => __d('mexc_new', 'form - image label', true),
		'instructions' => __d('mexc_new', 'form - image instructions', true)
	));	
	
		echo $this->Buro->input(
			array(),
			array(
				'fieldName' => 'img_id',
				'type' => 'image',
				'label' => __d('mexc_new', 'Arquivo de imagem', true),
				'instructions' => __d('mexc_new', 'Escolha o arquivo da imagem', true),
				'options' => array(
					'version' => 'backstage_preview'
				)
			)
		);
	
		echo $this->Buro->input(array('value' => '0', 'id' => 'embed_picture_'), array('type' => 'hidden', 'fieldName' => 'embed_picture'));
		echo $this->Buro->input(
			array(),
			array(
				'fieldName' => 'embed_picture',
				'type' => 'checkbox',
				'label' => '',
				'options' => array(
					'label' => 'Usar essa imagem <b>também</b> na página da notícia?',
					'hiddenField' => false,
					'escape' => false,
					'default' => true
				),
			)
		);

		echo $this->Bl->floatBreak();
		
	
	echo $this->Buro->einput();
	
	
	// Content stream
	echo $this->Buro->input(
		array(),
		array(
			'type' => 'content_stream',
			'label' => __d('mexc_new', 'form - content_stream label', true),
			'instructions' => __d('mexc_new', 'form - content_stream instructions', true),
			'options' => array(
				'foreignKey' => 'content_stream_id'
			)
		)
	);
	
	// Summary	
	echo $this->Buro->input(
		array(),
		array(
			'fieldName' => 'summary',
			'type' => 'textarea',
			'label' => __d('mexc_new', 'form - summary label', true),
			'instructions' => __d('mexc_new', 'form - summary instructions', true),
			'error' => __d('mexc_new', 'O texto deve ter entre 30 e 400 caracteres.', true)
		)
	);
		
	// Related contents
	echo $this->Buro->inputMexcRelatedContent();
	
	
	echo $this->Buro->submitBox(array(),array('publishControls' => false));
echo $this->Buro->eform();
