<?php

namespace Management\Service;

use Management\Model\Team;
use Management\Model\Admin;

use Management\Form\AddTeamFilter;
use Zend\Session\Container;

class AdminService extends Common{

	protected $_em;
	protected $session;

	public function __construct($em){
		$this->_em = $em;
		$this->session = new Container('appl');
	}
	public function addteam($post, $addTeamForm)
	{
		$addTeamFilter = new AddTeamFilter();
		$addTeamForm->setInputFilter($addTeamFilter);
		$addTeamForm->setData($post);
		if ($addTeamForm->isValid()) 
		{
			$modelAdmin = new Admin($this->_em);
			$modelAdmin->addteam($post);
			return array('controller' => 'admin', 'action' => 'addteam');			
		}
	}
	public function getTeams()
	{
		$modelAdmin = new Admin($this->_em);
		$teamArr = $modelAdmin->getTeams();
		return json_decode(json_encode($teamArr, true));
	}
	public function getTeamDropdown()
	{
		$admin = new Admin($this->_em);
		$dropdownData = $admin->getTeamDropdown();
		$dropdownData = json_decode(json_encode($dropdownData, true));
		$teamDropdown = array();
		foreach ($dropdownData as $drop)
		{
			$teamDropdown[$drop->teamId] = $drop->teamAbbr;
		}
		return $teamDropdown;
	}
}