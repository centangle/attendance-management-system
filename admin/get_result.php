
<!-- Queries Developed By: Bilal Ahmad Ghouri -->

<?php
	include_once('../common/config.php'); //including DB Connection File
	include_once('../common/queryfunctions.php'); //including query functions
	include_once('../common/commonfunctions.php'); //including query functions
	
	function getGrade($num)
	{
		if($num >= 90) return "A";
		if($num >= 85) return "A-";
		if($num >= 80) return "B+";
		if($num >= 75) return "B";
		if($num >= 70) return "B-";
		if($num >= 65) return "C+";
		if($num >= 60) return "C";
		if($num >= 55) return "C-";
		if($num >= 50) return "D";
		return "F";
	}
	
	$stSemester=$_GET['q'];//getting the smester Number
	$stID=$_GET['sid'];

	?>
	
	<?php
	$sql1=mysql_query("SELECT SubjectID, catalog.Semester FROM catalog JOIN student ON catalog.DisciplineID = student.DisciplineID AND " .
						"catalog.Semester <= '" .$stSemester. "' AND student.StudentID = '" .$stID. "' AND " .
						"student.Semester > '" .$stSemester. "' ORDER BY catalog.SubjectID");
		if(mysql_num_rows($sql1))
		{
			$catalog = GetAll($sql1);
			//echo json_encode($catalog);
			$subjectIDs = getColumnArray($catalog, "SubjectID");
			//echo json_encode($subjectIDs);
			$sql2=mysql_query("SELECT SubjectID, Name, CreditHours FROM subject WHERE SubjectID IN (". implode(", ", $subjectIDs) . ") ORDER BY SubjectID");
			//echo "SELECT SubjectID, Name, CreditHours FROM subject WHERE SubjectID IN (". implode(", ", $subjectIDs) . ") ORDER BY SubjectID";
			if(mysql_num_rows($sql2))
			{
				$subjects = GetAll($sql2);
				
				$sql3=mysql_query("SELECT SubjectID, Marks, GPA FROM subjectstudied WHERE SubjectID IN (". implode(", ", $subjectIDs) . ") " .
																"AND StudentID = '" .$stID. "' ORDER BY SubjectID");
				if(mysql_num_rows($sql3))
				{
					$marks = GetAll($sql3);
					
					$gpaSubjects = array();
					$subjectsGPAs = 0;
					$creditHours = 0;
					$reqSemSubjectsGPAs = 0;
					$reqSemCreditHours = 0;
					$cataloglen = count($catalog);
					for($i = 0, $j = 0; $i < $cataloglen; $i++)
					{
						if($catalog[$i]["Semester"] == $stSemester)
						{
							if($subjects[$i]["SubjectID"] == $marks[$j]["SubjectID"])
								$result[] = array("Name" => $subjects[$i]["Name"], "CreditHours" => $subjects[$i]["CreditHours"], "Marks" => $marks[$j]["Marks"], "Grade" => getGrade($marks[$j]["Marks"]), "GPA" => $marks[$j]["GPA"]);
							else $result[] = array("Name" => $subjects[$i]["Name"], "CreditHours" => $subjects[$i]["CreditHours"], "Marks" => "0", "Grade" => "F", "GPA" => "0.0");
							
							$reqSemSubjectsGPAs += (float)$marks[$j]["GPA"] * (int)$subjects[$i]["CreditHours"];
							$reqSemCreditHours += (int)$subjects[$i]["CreditHours"];
						}
						if($subjects[$i]["SubjectID"] == $marks[$j]["SubjectID"])
						{
							$subjectsGPAs += (float)$marks[$j]["GPA"] * (int)$subjects[$i]["CreditHours"];
							$creditHours += (int)$subjects[$i]["CreditHours"];
							$j++;
						}
					}
					$output[] = $result;
					$output[][] = array("GPA" => sprintf('%0.2f', $reqSemSubjectsGPAs / $reqSemCreditHours),
										"CGPA" => sprintf('%0.2f', $subjectsGPAs / $creditHours));
				}
				else echo "a";
			}
			else echo "b";
		}
		else echo "c";

	
?>

	<div>
			<form>
			<table class="gpaTable">
				<tr>
					<td colspan="6"><hr /></td>
				</tr>
				<tr>
						<th style="font-weight:bold; font-size:15px;">Sr#</th>
						<th style="font-weight:bold; font-size:15px;">Name</th>
						<th style="font-weight:bold; font-size:15px;">Marks</th>
						<th style="font-weight:bold; font-size:15px;">Grade</th>
						<th style="font-weight:bold; font-size:15px;">GPA</th>
						<th style="font-weight:bold; font-size:15px;">Credit Hours</th>

				</tr>
				<tr>
					<td colspan="6"><hr /></td>
				</tr>
				<?php
						//echo json_encode($result);
						for($i=0; $i <=count($output[0])-1;  $i++)
						{
				?>
					<tr>
						<td><?php echo $i+1;?></td>
						<td><?php echo $output[0][$i]["Name"];?></td>
						<td><?php echo $output[0][$i]["Marks"];?></td>
						<td><?php echo $output[0][$i]["Grade"];?></td>
						<td><?php echo $output[0][$i]["GPA"];?></td>
						<td><?php echo $output[0][$i]["CreditHours"];?></td>
					</tr>
				<?php
						}
						//echo $output[1][0];//gpa
						//echo $output[1][1];//cgpa
						//exit();
				?>
				<tr>
					<td colspan="6"><hr /></td>
				</tr>
				<tr>
					<td style="font-weight:bold; font-size:15px;">GPA:</td>
					<td><?php echo $output[1][0]["GPA"];?></td>
					<td colspan="2">&nbsp;</td>
					<td style="font-weight:bold; font-size:15px;">CGPA:</td>
					<td><?php echo $output[1][0]["CGPA"];?></td>
				</tr>
				<tr>
					<td colspan="6"><hr /></td>
				</tr>
			</table>
			
			<p align="center"><a class="btnPrint" href="get_result.php?q=<?php echo $stSemester;?>&sid=<?php echo $stID; ?>">
				Print Result
				</a>
			</p>
	</div>
