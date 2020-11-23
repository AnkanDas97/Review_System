<?php 
			$dbhost = 'localhost';
			$dbuser = 'pma';
			$dbdb='inputdata';
			$dbpass='4NCqboovsDCmOigB';
			$q=intval($_GET['q']);
			$z=intval($_GET['e']);
			$conn = mysqli_connect($dbhost, $dbuser,$dbpass,$dbdb);
			if (!$conn) {
				die("Connection failed: " . mysqli_connect_error());
			}
			$sql="select gen, name, dated, rate, review, mail from review";
			if ($z==0)
			{
				if ($q==1)
				{
					$sql.=" order by ID DESC";
				} elseif ($q==2) {
					$sql.=" order by rate DESC, ID DESC";
				} else {
					$sql.=" order by rate";
				}
			}
			elseif ($z==1) {
				$sql.=" where rate='1' order by ID DESC";
			}
			elseif ($z==3) {
				$sql.=" where rate='2' order by ID DESC";
			}
			elseif ($z==2) {
				$sql.=" where rate='3' order by ID DESC";
			}
			elseif ($z==4) {
				$sql.=" where rate='4' order by ID DESC";
			}
			elseif ($z==5) {
				$sql.=" where rate='5' order by ID DESC";
			}
			$c=0;
			$result=mysqli_query($conn,$sql);
			$a=array();
			$att=array("gen","name","dated","rate","review","mail");
			if (mysqli_num_rows($result) > 0) {
				while($row = mysqli_fetch_assoc($result)) {
					for ($i=0;$i<6;$i++)
					{
						$a[$c]=$row[$att[$i]];
						$c++;
					}
				}
			}
			$h=json_encode($a);
			echo $h;
			mysqli_close($conn);
		?>