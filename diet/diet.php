<html>
    <head>
        <title>MEAL PLAN</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="diet.css?v=<?php echo time(); ?>">
    </head>
    <body>

    <?php

$connection=mysqli_connect('localhost','root','','FitFormula');

if(!$connection){
    echo "Could not connect to database! " . mysqli_connect_error();
    die();
}

$userid=6;

$query="SELECT * FROM User WHERE ID='$userid'";

if($result=mysqli_query($connection,$query)){
    $row=mysqli_fetch_assoc($result);
}

$cals=10*$row['Weight']+6.25*$row['Height']-5*$row['Age'];

if($row['Sex']=='M'){
    $cals=$cals+5;
}
else{
    $cals=$cals-161;
}

if($row['IdealWeight']>$row['Weight']){
    $cals=$cals*1.2;
}
else if($row['IdealWeight']<$row['Weight']){
    $cals=$cals*0.9;
}

if($row['BodyType']==1){
    $cals=$cals*1.2;
}
else if($row['BodyType']==3){
    $cals=$cals*0.9;
}



$diet=$row['DietType'];


$breakfastquery="SELECT * FROM Food WHERE DietType='$diet' AND Meal=1";

$breakfastcount=0;
if($breakfastresult=mysqli_query($connection,$breakfastquery)){
    while($breakfastrow[]=mysqli_fetch_assoc($breakfastresult)){
        $breakfastcount++;
    }
}



$smoothiequery="SELECT * FROM Food WHERE DietType='$diet' AND Meal=5";

$smoothiecount=0;
if($smoothieresult=mysqli_query($connection,$smoothiequery)){
    while($smoothierow[]=mysqli_fetch_assoc($smoothieresult)){
        $smoothiecount++;
    }
}



$lunchquery="SELECT * FROM Food WHERE DietType='$diet' AND Meal=2";

$lunchcount=0;
if($lunchresult=mysqli_query($connection,$lunchquery)){
    while($lunchrow[]=mysqli_fetch_assoc($lunchresult)){
        $lunchcount++;
    }
}



$snackquery="SELECT * FROM Food WHERE DietType='$diet' AND Meal=3";

$snackcount=0;
if($snackresult=mysqli_query($connection,$snackquery)){
    while($snackrow[]=mysqli_fetch_assoc($snackresult)){
        $snackcount++;
    }
}



$dinnerquery="SELECT * FROM Food WHERE DietType='$diet' AND Meal=4";

$dinnercount=0;
if($dinnerresult=mysqli_query($connection,$dinnerquery)){
    while($dinnerrow[]=mysqli_fetch_assoc($dinnerresult)){
        $dinnercount++;
    }
}



$array=array();
$caloriesBool=FALSE;
while($caloriesBool==FALSE){

    $array=calorieCount($array,$breakfastcount,$breakfastrow,$smoothiecount,$smoothierow,$lunchcount,$lunchrow,$snackcount,$snackrow,$dinnercount,$dinnerrow);

    $calorieSum=sumCalories($array);
    if($cals>$calorieSum){
        if($cals-$calorieSum<100){
            $caloriesBool=TRUE;
        }
    }
    else{
        if($calorieSum-$cals<100){
            $caloriesBool=TRUE;
        }
    }

}

function calorieCount($array,$breakfastcount,$breakfastrow,$smoothiecount,$smoothierow,$lunchcount,$lunchrow,$snackcount,$snackrow,$dinnercount,$dinnerrow){

    $breakfastrand=rand(0,$breakfastcount-1);
    $breakfastcalorie=$breakfastrow[$breakfastrand]['Calories'];
    $array[0]=$breakfastrand;
    $array[1]=$breakfastcalorie;


    $smoothierand=rand(0,$smoothiecount-1);
    $smoothiecalorie=$smoothierow[$smoothierand]['Calories'];
    $array[2]=$smoothierand;
    $array[3]=$smoothiecalorie;


    $lunchrand=rand(0,$lunchcount-1);
    $lunchcalorie=$lunchrow[$lunchrand]['Calories'];
    $array[4]=$lunchrand;
    $array[5]=$lunchcalorie;


    $snackrand=rand(0,$snackcount-1);
    $snackcalorie=$snackrow[$snackrand]['Calories'];
    $array[6]=$snackrand;
    $array[7]=$snackcalorie;


    $dinnerrand=rand(0,$dinnercount-1);
    $dinnercalorie=$dinnerrow[$dinnerrand]['Calories'];
    $array[8]=$dinnerrand;
    $array[9]=$dinnercalorie;

    return $array;

}

function sumCalories($array){
    $sum=0;
    for($i=1;$i<10;$i=$i+2){
        $sum=$sum+$array[$i];
    }

    return $sum;
}

?>


        <div class="split left">

            <h1> Daily Meal Plan - <?php echo sumCalories($array)." Calories"?></h1>

            <div class="containers">
                <div class="mealheader">
                   <div class="meal"> Breakfast </div>
                   <div class="dishname"> <?php echo " -".$breakfastrow[$array[0]]['Name']?> </div>
                </div>
                <div class="mealbody">
                    <div class="mealpic"> <?php echo '<img height=30px width=30px src="data:image/jpeg;base64,'.base64_encode($breakfastrow[$array[0]]['Picture']).'"/>';?> </div>
                    <div class="mealdesc">
                        <div class="mealcal"> <?php echo "Calories: ".$array[1]?>  <?php echo "Prep Time: ".$breakfastrow[$array[0]]['PrepTime']?> </div>
                        <div class="mealing"> <?php echo "Ingrudients: ".$breakfastrow[$array[0]]['Ingridients']?> </div>
                    </div>
                </div>
            </div>

            <div class="containers">
                <div class="mealheader">
                   <div class="meal"> Smoothie </div>
                   <div class="dishname"> <?php echo " -".$smoothierow[$array[2]]['Name']?> </div>
                </div>
                <div class="mealbody">
                    <div class="mealpic"> <?php echo '<img height=30px width=30px src="data:image/jpeg;base64,'.base64_encode($smoothierow[$array[2]]['Picture']).'"/>';?> </div>
                    <div class="mealdesc">
                        <div class="mealcal"> <?php echo "Calories: ".$array[3]?>  <?php echo "Prep Time: ".$smoothierow[$array[2]]['PrepTime']?> </div>
                        <div class="mealing"> <?php echo "Ingrudients: ".$smoothierow[$array[2]]['Ingridients']?> </div>
                    </div>
                </div>
            </div>

            <div class="containers">
                <div class="mealheader">
                   <div class="meal"> Lunch </div>
                   <div class="dishname"> <?php echo " -".$lunchrow[$array[4]]['Name']?> </div>
                </div>
                <div class="mealbody">
                    <div class="mealpic"> <?php echo '<img height=30px width=30px src="data:image/jpeg;base64,'.base64_encode($lunchrow[$array[4]]['Picture']).'"/>';?> </div>
                    <div class="mealdesc">
                        <div class="mealcal"> <?php echo "Calories: ".$array[5]?>  <?php echo "Prep Time: ".$lunchrow[$array[4]]['PrepTime']?> </div>
                        <div class="mealing"> <?php echo "Ingrudients: ".$lunchrow[$array[4]]['Ingridients']?> </div>
                    </div>
                </div>
            </div>

            <div class="containers">
                <div class="mealheader">
                   <div class="meal"> Snack </div>
                   <div class="dishname"> <?php echo " -".$snackrow[$array[6]]['Name']?> </div>
                </div>
                <div class="mealbody">
                    <div class="mealpic"> <?php echo '<img height=30px width=30px src="data:image/jpeg;base64,'.base64_encode($snackrow[$array[6]]['Picture']).'"/>';?> </div>
                    <div class="mealdesc">
                        <div class="mealcal"> <?php echo "Calories: ".$array[7]?>  <?php echo "Prep Time: ".$snackrow[$array[6]]['PrepTime']?> </div>
                        <div class="mealing"> <?php echo "Ingrudients: ".$snackrow[$array[6]]['Ingridients']?> </div>
                    </div>
                </div>
            </div>

            <div class="containers">
                <div class="mealheader">
                   <div class="meal"> Dinner </div>
                   <div class="dishname"> <?php echo " -".$dinnerrow[$array[8]]['Name']?> </div>
                </div>
                <div class="mealbody">
                    <div class="mealpic"> <?php echo '<img height=30px width=30px src="data:image/jpeg;base64,'.base64_encode($dinnerrow[$array[8]]['Picture']).'"/>';?> </div>
                    <div class="mealdesc">
                        <div class="mealcal"> <?php echo "Calories: ".$array[9]?>  <?php echo "Prep Time: ".$dinnerrow[$array[8]]['PrepTime']?> </div>
                        <div class="mealing"> <?php echo "Ingrudients: ".$dinnerrow[$array[8]]['Ingridients']?> </div>
                    </div>
                </div>
            </div>

        </div>


        <?php
        
        $body=$row['BodyType'];




        $shoulderquery="SELECT * FROM Exercises WHERE BodyType='$body' AND BodyPart=1";

        $shouldercount=0;
     
        if($shoulderresult=mysqli_query($connection,$shoulderquery)){
            while($shoulderrow[]=mysqli_fetch_assoc($shoulderresult)){
                $shouldercount++;
            }
        }

        $armquery="SELECT * FROM Exercise WHERE BodyType='$body' AND BodyPart=2";

        $armcount=0;
     
        if($armresult=mysqli_query($connection,$armquery)){
            while($armrow[]=mysqli_fetch_assoc($armresult)){
                $armcount++;
            }
        }

        $chestquery="SELECT * FROM Exercise WHERE BodyType='$body' AND BodyPart=3";

        $chestcount=0;
     
        if($chestresult=mysqli_query($connection,$chestquery)){
            while($chestrow[]=mysqli_fetch_assoc($chestresult)){
                $chestcount++;
            }
        }

        $absquery="SELECT * FROM Exercise WHERE BodyType='$body' AND BodyPart=4";

        $abscount=0;
     
        if($absresult=mysqli_query($connection,$absquery)){
            while($absrow[]=mysqli_fetch_assoc($absresult)){
                $abscount++;
            }
        }

        $backquery="SELECT * FROM Exercise WHERE BodyType='$body' AND BodyPart=5";

        $backcount=0;
     
        if($backresult=mysqli_query($connection,$backquery)){
            while($backrow[]=mysqli_fetch_assoc($backresult)){
                $backcount++;
            }
        }

        $thighsqeury="SELECT * FROM Exercise WHERE BodyType='$body' AND BodyPart=6";

        $thighscount=0;
     
        if($thighsresult=mysqli_query($connection,$thighsqeury)){
            while($thighsrow[]=mysqli_fetch_assoc($thighsresult)){
                $thighscount++;
            }
        }
        
        if($body==1){
            $tm=25;
        }
        else if($body==2){
            $tm=35;
        }
        else{
            $tm=45;
        }


        $array=array();
        $exBool=FALSE;
        while($exBool==FALSE){

            $array=calorieCount($array,$shouldercount,$shoulderrow,$armcount,$armsrow,$chestrow,$chestcount,$absrow,$abscount,$backrow,$backcount,$thighscount,$thighsrow);
            $timeSum=sumTime($array);
            if($timeSum-$tm<5){
                $exBool=true;
            }
            else if($tm-$timeSum<5){
                $exBool=true;
            }

        }

    function timeCount($array,$shouldercount,$shoulderrow,$armcount,$armsrow,$chestrow,$chestcount,$absrow,$abscount,$backrow,$backcount,$thighscount,$thighsrow){

        $shoulderrand=rand(0,$shouldercount-1);
        $shouldertime=$shoulderrow[$shoulderrand]['Time'];
        $array[0]=$shoulderrand;
        $array[1]=$shouldertime;


        $armsrand=rand(0,$armcount-1);
        $armstime=$armsrow[$armsrand]['Time'];
        $array[2]=$armsrand;
        $array[3]=$armstime;


        $chestrand=rand(0,$chestcount-1);
        $chesttime=$chestrow[$chestrand]['Time'];
        $array[4]=$chestrand;
        $array[5]=$chesttime;


        $absrand=rand(0,$abscount-1);
        $abstime=$absrow[$absrand]['Time'];
        $array[6]=$absrand;
        $array[7]=$abstime;


        $backrand=rand(0,$backcount-1);
        $backtime=$backrow[$backrand]['Time'];
        $array[8]=$backrand;
        $array[9]=$backtime;


        $thighsrand=rand(0,$thighscount-1);
        $thighstime=$thighsrow[$thighsrand]['Time'];
        $array[8]=$thighsrand;
        $array[9]=$thighstime;


        return $array;

    }

    function sumtime($array){
        $sum=0;
        for($i=1;$i<10;$i=$i+2){
            $sum=$sum+$array[$i];
        }

        return $sum;
    }
        ?>


        <div class="split right">

            <h1> Daily Exercise Plan <button onClick="window.location.reload();">Refresh Plan</button> </h1>

            <div class="containers">
                <div class="mealheader">
                   <div class="meal"> Shoulders </div>
                   <div class="dishname"> <?php echo " - ".$shoulderrow[$array[0]]['Emri'] . " ". $array[1]?> </div>
                </div>
                <div class="mealbody">
                    <div class="mealpic"> <?php echo '<img height=30px width=30px src="data:image/jpeg;base64,'.base64_encode($shoulderrow[$array[0]]['Foto']).'"/>';?> </div>
                    <div class="mealcal"> <?php echo "Description: ".$shoulderrow[$array[0]]['Pershkrimi']?> </div>
                </div>
            </div>

            <div class="containers">
                <div class="mealheader">
                   <div class="meal"> Arms </div>
                   <div class="dishname"> <?php echo " - ".$shoulderrow[$array[0]]['Emri'] . " ". $array[1]?> </div>
                </div>
                <div class="mealbody">
                    <div class="mealpic"> <?php echo '<img height=30px width=30px src="data:image/jpeg;base64,'.base64_encode($shoulderrow[$array[0]]['Foto']).'"/>';?> </div>
                    <div class="mealcal"> <?php echo "Description: ".$shoulderrow[$array[0]]['Pershkrimi']?> </div>
                </div>
            </div>

            <div class="containers">
                <div class="mealheader">
                   <div class="meal"> Chest </div>
                   <div class="dishname"> <?php echo " - ".$shoulderrow[$array[0]]['Emri'] . " ". $array[1]?> </div>
                </div>
                <div class="mealbody">
                    <div class="mealpic"> <?php echo '<img height=30px width=30px src="data:image/jpeg;base64,'.base64_encode($shoulderrow[$array[0]]['Foto']).'"/>';?> </div>
                    <div class="mealcal"> <?php echo "Description: ".$shoulderrow[$array[0]]['Pershkrimi']?> </div>
                </div>
            </div>

            <div class="containers">
                <div class="mealheader">
                   <div class="meal"> ABS </div>
                   <div class="dishname"> <?php echo " - ".$shoulderrow[$array[0]]['Emri'] . " ". $array[1]?> </div>
                </div>
                <div class="mealbody">
                    <div class="mealpic"> <?php echo '<img height=30px width=30px src="data:image/jpeg;base64,'.base64_encode($shoulderrow[$array[0]]['Foto']).'"/>';?> </div>
                    <div class="mealcal"> <?php echo "Description: ".$shoulderrow[$array[0]]['Pershkrimi']?> </div>
                </div>
            </div>

            <div class="containers">
                <div class="mealheader">
                   <div class="meal"> Back </div>
                   <div class="dishname"> <?php echo " - ".$shoulderrow[$array[0]]['Emri'] . " ". $array[1]?> </div>
                </div>
                <div class="mealbody">
                    <div class="mealpic"> <?php echo '<img height=30px width=30px src="data:image/jpeg;base64,'.base64_encode($shoulderrow[$array[0]]['Foto']).'"/>';?> </div>
                    <div class="mealcal"> <?php echo "Description: ".$shoulderrow[$array[0]]['Pershkrimi']?> </div>
                </div>
            </div>

            <div class="containers">
                <div class="mealheader">
                   <div class="meal"> Thighs </div>
                   <div class="dishname"> <?php echo " - ".$shoulderrow[$array[0]]['Emri'] . " ". $array[1]?> </div>
                </div>
                <div class="mealbody">
                    <div class="mealpic"> <?php echo '<img height=30px width=30px src="data:image/jpeg;base64,'.base64_encode($shoulderrow[$array[0]]['Foto']).'"/>';?> </div>
                    <div class="mealcal"> <?php echo "Description: ".$shoulderrow[$array[0]]['Pershkrimi']?> </div>
                </div>
            </div>

        </div>

    </body>
</html>
