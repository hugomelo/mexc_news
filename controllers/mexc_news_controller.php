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

class MexcNewsController extends MexcNewsAppController
{
	var $name = 'MexcNews';
	
	var $uses = array('MexcNews.MexcNew', 'MexcScientificNews.MexcScientificNew', 'MexcEvents.MexcEvent', 'MexcRelated.MexcRelatedContent');
	
	var $paginate = array(
		'MexcNew' => array(
			'limit' => 9,
			'contain' => false
		)
	);
	
/**
 * action beforeFilter
 * 
 * @access private
 * @return void 
 */
	function beforeFilter()
	{
		parent::beforeFilter();
		if (!empty($this->currentSpace))
			$this->MexcNew->setActiveStatuses(array('display_level' => array('general', 'fact_site')));
		else
			$this->MexcNew->setActiveStatuses(array('display_level' => array('general')));
	}
	
	
/**
 * action index
 * 
 * @access public
 * @return void 
 */
	function index()
	{
		$conditions = $this->MexcSpace->getConditionsForSpaceFiltering($this->currentSpace);
		$mexc_news = $this->paginate('MexcNew', $conditions);
		$this->set(compact('mexc_news'));
	}

/**
 * action read
 * 
 * @access public
 * @param string $id The MexcNew id
 * @return void 
 */
	function read($id = false)
	{
		if (empty($id))
			$this->redirect('/novidades');
		
		$conditions = $this->MexcSpace->getConditionsForSpaceFiltering($this->currentSpace);
		$new = $this->MexcNew->find('first', array(
			'contain' => array('Tag', 'MexcRelatedContent'),
			'conditions' => array(
				'MexcNew.id' => $id,
				'MexcNew.date <=' => date('Y-m-d')
			) + $conditions
		));
		
		if (empty($new))
			$this->redirect('/novidades');
		
		$this->SectSectionHandler->addToPageTitleArray(array(null, null, $new['MexcNew']['title']));

		$this->set(compact('new'));
	}

/**
 * Action for science news. It is called by index action and by ajax requests.
 * 
 * @access public
 * @return void 
 */
	function read_science_news($page = 1)
	{
		$mexc_scientific_news = $this->MexcScientificNew->find('all', array(
			'contain' => 'MexcNewsSource',
			'limit' => 4,
			'page' => $page
		));
		$this->set(compact('mexc_scientific_news'));
	}
}
