<?php
	
	class supervisor extends employee{
		private $employees;
		
		function __construct($employeeId, $firstName, $employees){
			parent::__construct($employeeId, $firstName);
			$this->employees = $employees;
		}
		public function getEmployees(){
			return $this->employees;
		}
		
		public function setEmployees($employees){
			$this->employees = $employees;
		}
	}
?>