<?php include 'employee.php'; ?>
<?php include 'supervisor.php'; ?>
<!DOCTYPE html>
<html>
	<head>
		<title>OO PHP</title>
	</head>	
	<body>
		<h2>Object Oriented PHP</h2>
		<?php
			$employee1 = new employee(1, "Chris ");
			echo $employee1->getEmployeeId();
			echo '<br>';
			echo $employee1->getFirstName();
			
			$employee2 = new employee(2, 'Matt');
			
			$employees = Array(0 => $employee1, 1 => $employee2);
			$supervisor = new supervisor(3, 'Adam', $employees);
			
			foreach($supervisor->getEmployees() as $employee){
				echo $employee->getFirstName();
				echo '<br>';
				echo $employee->getEmployeeId();
			}
		?>
	</body>
</html>