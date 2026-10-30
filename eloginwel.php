<?php
$id = (isset($_GET['id']) ? $_GET['id'] : '');

require_once('process/dbh.php');

// Employee basic info
$sql_emp = "SELECT * FROM employee WHERE id = '$id'";
$result_emp = mysqli_query($conn, $sql_emp);
$employeen = mysqli_fetch_array($result_emp);
$empName = ($employeen['firstName']);

// Leaderboard
$sql = "SELECT employee.id, employee.firstName, employee.lastName, rank.points 
FROM employee 
JOIN rank ON rank.eid = employee.id 
ORDER BY rank.points DESC";

// Due projects
$sql1 = "SELECT pname, duedate FROM project WHERE eid = $id AND status = 'Due'";

// Leave status
$sql2 = "SELECT * FROM employee_leave WHERE eid = $id ORDER BY token";

// Salary
$sql3 = "SELECT * FROM salary WHERE eid = $id";

// Execute queries
$result = mysqli_query($conn, $sql);
$result1 = mysqli_query($conn, $sql1);
$result2 = mysqli_query($conn, $sql2);
$result3 = mysqli_query($conn, $sql3);
?>

<html>

<head>
	<title>Employee Panel | Employee Management System</title>
	<link rel="stylesheet" type="text/css" href="styleemplogin.css">
	<link href="https://fonts.googleapis.com/css?family=Lobster|Montserrat" rel="stylesheet">
</head>

<body>

	<header>
		<nav>
			<h1>Employee Management System</h1>
			<ul id="navli">
				<li><a class="homered" href="eloginwel.php?id=<?php echo $id ?>">HOME</a></li>
				<li><a class="homeblack" href="myprofile.php?id=<?php echo $id ?>">My Profile</a></li>
				<li><a class="homeblack" href="empproject.php?id=<?php echo $id ?>">My Projects</a></li>
				<li><a class="homeblack" href="applyleave.php?id=<?php echo $id ?>">Apply Leave</a></li>
				<li><a class="homeblack" href="elogin.html">Log Out</a></li>
			</ul>
		</nav>
	</header>

	<div class="divider"></div>

	<div id="divimg">

		<h2 style="text-align:center;">Welcome <?php echo $empName; ?></h2>

		<!-- Leaderboard -->
		<h2 style="text-align:center;">Employee Leaderboard</h2>

		<table>
			<tr bgcolor="#000">
				<th>Seq.</th>
				<th>Emp. ID</th>
				<th>Name</th>
				<th>Points</th>
			</tr>

			<?php
			$seq = 1;
			while ($employee = mysqli_fetch_assoc($result)) {
				echo "<tr>";
				echo "<td>" . $seq . "</td>";
				echo "<td>" . $employee['id'] . "</td>";
				echo "<td>" . $employee['firstName'] . " " . $employee['lastName'] . "</td>";
				echo "<td>" . $employee['points'] . "</td>";
				echo "</tr>";
				$seq++;
			}
			?>
		</table>

		<!-- Projects -->
		<h2 style="text-align:center;">Due Projects</h2>

		<table>
			<tr>
				<th>Project Name</th>
				<th>Due Date</th>
			</tr>

			<?php
			while ($project = mysqli_fetch_assoc($result1)) {
				echo "<tr>";
				echo "<td>" . $project['pname'] . "</td>";
				echo "<td>" . $project['duedate'] . "</td>";
				echo "</tr>";
			}
			?>
		</table>

		<!-- Salary -->
		<h2 style="text-align:center;">Salary Status</h2>

		<table>
			<tr>
				<th>Base Salary</th>
				<th>Bonus</th>
				<th>Total Salary</th>
			</tr>

			<?php
			while ($salary = mysqli_fetch_assoc($result3)) {
				echo "<tr>";
				echo "<td>" . $salary['base'] . "</td>";
				echo "<td>" . $salary['bonus'] . " %</td>";
				echo "<td>" . $salary['total'] . "</td>";
				echo "</tr>";
			}
			?>
		</table>

		<!-- Leave -->
		<h2 style="text-align:center;">Leave Status</h2>

		<table>
			<tr>
				<th>Start Date</th>
				<th>End Date</th>
				<th>Total Days</th>
				<th>Reason</th>
				<th>Status</th>
			</tr>

			<?php
			while ($leave = mysqli_fetch_assoc($result2)) {

				$date1 = new DateTime($leave['start']);
				$date2 = new DateTime($leave['end']);
				$interval = $date1->diff($date2);

				echo "<tr>";
				echo "<td>" . $leave['start'] . "</td>";
				echo "<td>" . $leave['end'] . "</td>";
				echo "<td>" . $interval->days . "</td>";
				echo "<td>" . $leave['reason'] . "</td>";
				echo "<td>" . $leave['status'] . "</td>";
				echo "</tr>";
			}
			?>
		</table>

	</div>

</body>

</html>