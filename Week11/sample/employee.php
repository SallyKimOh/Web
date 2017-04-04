<?php

	class employee{
		protected $employeeId;
		protected $firstName;
		protected $lastName;
		protected $gender;
		protected $salary;
		protected $department;
		
		function __construct($employeeId, $firstName){
				$this->setEmployeeId($employeeId);
				$this->setFirstName($firstName);
		}
		public function getEmployeeId(){
			return $this->employeeId;
		}
		
		public function setEmployeeId($employeeId){
			$this->employeeId = $employeeId;
		}
		
		public function getFirstName(){
			return $this->firstName;
		}
		
		public function setFirstName($firstName){
			$this->firstName = $firstName;
		}
	}
?>