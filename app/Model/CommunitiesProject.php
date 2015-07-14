<?php
App::uses('AppModel', 'Model');
/**
 * CommunitiesProject Model
 *
 * @property Project $Project
 * @property Community $Community
 */
class CommunitiesProject extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Project' => array(
			'className' => 'Project',
			'foreignKey' => 'project_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Community' => array(
			'className' => 'Community',
			'foreignKey' => 'community_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
