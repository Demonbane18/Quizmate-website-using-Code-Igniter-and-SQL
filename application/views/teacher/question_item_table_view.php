		<tr id="question-<?php echo $question_id;?>" href="<?php echo $this->misc->getHref('teacher/qwarehouse/editq/')."/$question_id";?>">
			<td><?php echo $question_id;?></td>
			<td><?php echo $question;?></td>
			<td><?php
			switch ($type) {
				case 'choice':
					echo "Multiple Choice";
					break;
				case 'numeric':
					echo "Fill the answer with numbers";
					break;
				case 'boolean':
					echo "True/False";
					break;
				case 'matching':
					echo "Matching";
					break;
			}
			if ($type == "choice") {
				if ($answer_choice == "1") $answer = $choice1;
				elseif ($answer_choice == "2") $answer = $choice2;
				elseif ($answer_choice == "3") $answer = $choice3;
				elseif ($answer_choice == "4") $answer = $choice4;
				elseif ($answer_choice == "5") $answer = $choice5;
				elseif ($answer_choice == "6") $answer = $choice6;
			}
			if ($type == "boolean")
			{
				if (strtolower($answer_boolean) == "b")
					$answer = "True";
				else
					$answer = "False";
			}
			elseif ($type == "numeric")
			{
				$answer = $answer_numeric;
			}
			list($date, $time) = explode(' ', $created_time);
		?></td>
			<td><?php echo $answer;?></td>
			<td><span class="jtooltip" title="<?php
				echo $this->misc->getFullDateTH($date)."<br>Time ".$time."\">".
				$created_by; ?>
				</span>
			</td>
		</tr>
<?php
