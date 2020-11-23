<!doctype HTML>
<html>
	<head>
		<title>Check Form</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="www.w3schools.com/4/w3.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<style>
			.checked {
				color: orange;
			}
			.rating {
				display: none;
			}
		</style>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

		<script>
		dated();
			function dated()
			{
				var n= new Date();
				var d=n.getDate();
				var m=n.getMonth()+1;
				var y=n.getFullYear();
				if (m < 10) 
				{
					m = "0" + m;
				}
				if (d < 10)
				{
					d = "0" + d;
				}
				var today=y+"-"+m+"-"+d;
				document.getElementById("dob").setAttribute("max",today);
			}
			
			function act(m,star)
			{
				var f=document.getElementsByClassName(star);
				for (i=0;i<5;i++)
				{
					f[i].innerHTML="&#9734";
				}
				for (i=0;i<m;i++)
				{
					f[i].innerHTML="&#9733";
				}
			}
					
							
		</script>
	</head>
	
	<body onload=dated()>
		<?php
		
			$namerr=$doberr=$gerr=$mailerr=$raterr=$reverr="";
			$name=$dob=$gender=$mail=$rating=$review="";
			if($_SERVER["REQUEST_METHOD"]=="POST")
			{
				$name=test_input($_POST["name"]);
				$gender=test_input($_POST["gender"]);
				$dob=test_input($_POST["dob"]);
				$rating=test_input($_POST["rating"]);
				$review=test_input($_POST["review"]);
				$mail=test_input($_POST["mail"]);
			}
			
			function test_input($data) 
			{
				$data = trim($data);
				$data = stripslashes($data);
				$data = htmlspecialchars($data);
				return $data;
			}
			if ($name!="")
			{
				$dated=date("Y-m-d");
				$dbhost = 'localhost';
				$dbuser = 'pma';
				$dbdb='inputdata';
				$dbpass='4NCqboovsDCmOigB';
				$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbdb);
				if (!$conn) {
					die("Connection failed: " . mysqli_connect_error());
				} 
				$sql="INSERT INTO review(gen, name, dated, rate, review, mail) VALUES ('$gender','$name','$dated','$rating','$review','$mail')";
				mysqli_query($conn,$sql);
				mysqli_close($conn);
			}
		
		?>
	
		
		<h2>Form Fillup</h2>	
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="on" >
			
			<label for="name">NAME : </label>
			<input type="text" id="name" name="name" required>
			<span name="error">* <?php echo $namerr;?></span>
			<br><br>
			<label>Gender : </label>
			<input type="radio" id="male" name="gender" value="Male"> Male
			<input type="radio" id="female" name="gender" value="Female"> Female
			<input type="radio" id="trans" name="gender" value="Transgender"> Transgender
			<span name="error">* <?php echo $gerr;?></span>
			<br><br>
			<label for="dob">Date of Birth : </label>
			<input type="date" id="dob" name="dob" max="dated()">
			<span name="error">* <?php echo $doberr;?></span>
			<br><br>
			<label>Rating : </label>
			<input type="radio" id="1" name="rating" value="1" class="rating">
			<label for="1" onclick=act(1,"star") class="star">☆</label>
			<input type="radio" id="2" name="rating" value="2"  class="rating">
			<label for="2" onclick=act(2,"star") class="star">☆</label>
			<input type="radio" id="3" name="rating" value="3"  class="rating">
			<label for="3" onclick=act(3,"star") class="star">☆</label>
			<input type="radio" id="4" name="rating" value="4"  class="rating">
			<label for="4" onclick=act(4,"star") class="star">&#9734</label>
			<input type="radio" id="5" name="rating" value="5"  class="rating">
			<label for="5" onclick=act(5,"star") class="star">☆</label>
			<span name="error">* <?php echo $raterr;?></span>
			<br><br>
			<label for="review">Review :</label>
			<textarea id="review" name="review" rows="5" cols="35">Please put your review here.</textarea>
			<span name="error">* <?php echo $reverr;?></span>
			<br><br>
			<label for="email">Email : </label>
			<input type="email" name="mail" id="email">
			<span name="error">* <?php echo $mailerr;?></span>
			<br><br>
			<input type="submit" value="SUBMIT">
		</form>
		
		<script>
			showuser(1,0);
			
			function showuser(v,z)
			{
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.open("GET", "data_array1.php?q="+v+"&e="+z, true);
				xmlhttp.send();
				xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					var dl = JSON.parse(this.responseText);
					var c=dl.length;
					if(v==0)
					{
						$("#df").html("<button onclick=showuser(1,0)>SHOW ALL REVIEWS</button>");
						$("#df").append("<br><br>");
						y=$("<h2 style='text-align: center'></h2>").text(z+" STAR RATINGS");
						$("#df").append(y);
					}
					else
					{
						$("#df").text("");
					}
					var n=0;
					var s=0;
					var r=[0,0,0,0,0];
					$("#pil").html("<h2 style='text-align: center'>COMMENTS</h2><br><br>");
					$("#pil").append("<br>");
						for (i=0;i<c;i++)
						{	
							if(i%6==0)
							{
								
								$("#pil").append("<br>");
								if(dl[i]=="Male")
								{
									$("#pil").append('<img src="Male.png" class="ig"/>');
								}
								else if(dl[i]=="Female")
								{
									$("#pil").append('<img src="Female.png" class="ig"/>');
								}
								else if(dl[i]=="Transgender")
								{
									$("#pil").append('<img src="Trans.png" class="ig"/>');
								}
							}
							else if(i%6==1)
							{	
								var b=$("<span class='nm'></span>").text(dl[i]);
								$("#pil").append(b);
							}
							else if(i%6==2)
							{
								var b=$("<p></p>").text(dl[i]);
								$("#pil").append(b);
							}
							else if(i%6==3)
							{
								s+=parseInt(dl[i]);
								n++;
								for (j=0;j<5;j++)
								{
									if (j<parseInt(dl[i]))
									{
										var b=$("<span></span>").addClass("fa fa-star checked");
										$('#pil').append(b);
									}
									else	{
										var b=$("<span></span>").addClass("fa fa-star");
										$('#pil').append(b);
									}
								}
								$('#pil').append("<br>");
								r[dl[i]-1]+=1;
							}
							else if (i%6==4)
							{
								
								var b=$("<p></p>").text(dl[i]);
								$("#pil").append(b);
							}
							else if (i%6==5)
							{
								
								var b=$("<p></p>").text(dl[i]);
								$("#pil").append(b);
								$('#pil').append("<br>");
								$('#pil').append("<br>");
							}
					}
				$(".ig").attr({"width":"35px","height":"35px"});
				$(".ig").css({"margin":"10px","margin-bottom":"-10px"});
				$(".nm").css("font-size","40px");
				if (z==0)
				{
					x=Math.round(Math.ceil((s/n)*10))/10;
					var g=$("<h2 id='rt'></h2>").text(x+"/5");
					$("#pli").html("<h3 style='text-align: center'>AVERAGE RATINGS</h3>");
					$("#pli").append(g);
					$("#rt").css("text-align","center");
					$('#pli').append("<br>");
					$('#pli').append("<br>");
					for (i=5;i>=1;i--)
					{
						var o=Math.floor((r[i-1]/n)*100);
						var q=$("<label for='p1' style='padding-left: 10px'></label>").text(i+" Star : ");
						$("#pli").append(q);
						q=$("<progress id='p1' max='100'></progress>").attr({"value":o,"title":o+"%","onclick":"showuser(0,"+i+")"});
						$("#pli").append(q);
						$('#pli').append("<br>");
						$('#pli').append("<br>");
					}
				}
				}
				};
				}
		</script>	
		<br><hr><br>
		
		<form>
			<label for="lb">SORT BY : </label>
			<select onchange=showuser(this.value,0) style="margin-left: 20px" id="lb">
				<option value="1" selected>Most Recent</option>
				<option value="2">Positive First</option>
				<option value="3">Negative First</option>
			</select>
			<span id="df" style="margin-left: 50px"></span>
		</form>
		
		
		<!--<button  onclick=pli()>SHOW REVIEWS</button>-->
		<div class="flex-container" style="display: flex; flex-flow: row; align-content: space-between">
			<br><br><br>
			<div id="pil" class="w3-display-container" style="margin-left : 20px; width:750px; margin-top : 50px;  border: 1px solid #ccc; box-shadow : 8px 8px 12px grey; padding-left: 10px"><h2 style="text-align: center" >COMMENTS</h2><br><br></div>
			<div id="pli" class="w3-display-container" style="margin-left : 250px; width: 250px; height: 350px; margin-top : 50px;  border: 1px solid #ccc; box-shadow : 8px 8px 12px grey;"><h3 style="text-align: center">AVERAGE RATINGS</h3></div>
		</div>
		<!--<object data="revfile.txt" width="5000" height="5000">Error</object>-->

			
		
		
	</body>
</html>
					
					
		
			
			
			