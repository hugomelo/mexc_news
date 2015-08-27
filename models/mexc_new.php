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

class MexcNew extends MexcNewsAppModel
{
	var $name = 'MexcNew';
	
	var $order = array('MexcNew.date' => 'DESC', 'MexcNew.created' => 'DESC');
	
	var $actsAs = array(
		'Containable', 
		'Tags.Taggable',
		'Dashboard.DashDashboardable', 
		'Status.Status' => array('publishing_status', 'display_level'),
		'JjMedia.StoredFileHolder' => array('img_id'),
		'ContentStream.CsContentStreamHolder' => array(
			'streams' => array(
				'content_stream_id' => 'new'
			)
		),
		'UnifiedSearch.Searcheable' => array(
			'contain' => array('MexcSpace')
		),
		'Temp.TempTemp' => array(
			'field' => 'is_temp',
			'modifiedBefore' => 1
		),
		'MexcRelated.MexcHasRelatedContent' => array(
			'MexcDocuments.MexcDocument',
			'MexcGalleries.MexcGallery',
			'MexcEvents.MexcEvent',
			'MexcNews.MexcNew'
		)
	);
	
	var $belongsTo = array(
		'MexcSpace.MexcSpace',
		'MexcEvents.MexcEvent'
	);

	var $validate = array(
		'mexc_space_id' => array(
			'rule' => 'notEmpty',
			'required' => true
		),
		'summary' => array(
			'rule' => array('between', 30, 400)
		)
	);
	
/**
 * Creates a blank row in the table. It is part of the backstage contract.
 *
 * @access public
 */
	function createEmpty()
	{
		$data = array(
			'MexcNew' => array(
				'date' => date('Y-m-d'),
				'publishing_status' => 'draft'
			)
		);
		$this->create();
		return $this->save($data, false);
	}
	
/**
 * The data that must be saved into the dashboard. Part of the Dashboard contract.
 * 
 * 
 * @access public
 * @param string $id
 */
	function getDashboardInfo($id)
	{
		$this->contain();
		$data = $this->findById($id);
		if ($data == null)
			return null;
		
		$dashdata = array(
			'dashable_id' => $id,
			'mexc_space_id' => $data['MexcNew']['mexc_space_id'],
			'dashable_model' => $this->name,
			'type' => 'new',
			'status' => $data['MexcNew']['publishing_status'],
			'created' => $data['MexcNew']['created'],
			'modified' => $data['MexcNew']['modified'],
			'name' => $data['MexcNew']['title'],
			'info' => 'Desc.: ' . mb_substr($data['MexcNew']['summary'],0,80) . '...',
			'idiom' => array()
		);
		
		return $dashdata;
	}
	
	/** When data is deleted from the Dashboard. Part of the Dashboard contract.
	 *  @todo Maybe we should study how to do it from Backstage contract.
	 */
	
	function dashDelete($id)
	{
		$data = $this->findById($id);
		return $this->delete($id);
	}

	function beforeSave() {
		if (isset($this->data[$this->alias]['mexc_space_id']) && $this->data[$this->alias]['mexc_space_id'] == '')
			$this->data[$this->alias]['mexc_space_id'] = null;
		return true;
	}
}
