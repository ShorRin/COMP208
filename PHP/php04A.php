<!DOCTYPE html> 
<html>
    <head>
        <title>PHP Scalars</title> 
        <meta name=author content="SamXu">
    </head> 
    <body>
        <h1>PHP Scalars</h1>
        <?php 
        echo "Start of Q1;<br>\n";
            $user = "Sam Xu"; 
            print ("<p><b>Hello $user <br>\nHello World!</b></p>\n");
            
        echo "Start of Q2;<br>\n";
            define("PI",3.14159);
            define("SPEED_OF_LIGHT",299792458,true);
            print "1 - Value of PI: PI<br>\n";
            print "2 - Value of PI: ".PI."<br>\n";
            $diameter = 2;
            $time = 3;
            $circumference1 = PI * $diameter;
            $circumference2 = pi * $diameter;
            $distance = speed_of_light * $time;
            echo    "<p style=\"color:red\"><b>Diameter = $diameter => ",
                    "Circumference1 = $circumference1 | ", 
                    "Circumference2 = $circumference2<br>\n";
            echo    "Time = $time => Distance = $distance<br>\n</p></b>";
            
        echo "Start of Q3;<br>\n";
            $mode = rand(1,4); 
            if ($mode == 1) $randvar = rand();
            elseif ($mode == 2) $randvar = (string) rand();
            elseif ($mode == 3) $randvar = rand()/(rand()+1);
            else $randvar = (bool) $mode;
            echo "Random scalar: $randvar<br>\n";
            /*if (is_int($randvar)) echo "This is a natural number. <br>\n";
            elseif (is_float($randvar)) echo "This is a floating-point. <br>\n";
            elseif (is_string($randvar)) echo "This is a string. <br>\n";
            else echo "I don’t know what this is. <br>\n";
            */
            switch (getType($randvar)){
                case "integer":
                    echo "This is a natural number. <br>\n";
                    break;
                case "string": 
                    echo "This is a string. <br>\n";
                    break;
                case "double":
                    echo "This is a floating-point. <br>\n";
                    break;
                default: 
                    echo "I don’t know what this is. <br>\n";
            }
            
        echo "<br>Start of Q4; <br>\n";
            $a = array(0,123,1.23e2,"123",TRUE,FALSE);
            echo "<table border=’1’ cellpadding=’5’>\n";
            foreach ($a as $sa) foreach ($a as $sb) { 
                $val_sa = gettype($sa)."(".var_export($sa,true).")"; 
                $val_sb = gettype($sb)."(".var_export($sb,true).")"; 
                echo "<tr>"; 
                printf("<td>%20s == %20s -> %5s</td>", $val_sa,$val_sb, ($sa == $sb) ? "TRUE" : "FALSE");
                printf("<td>%20s === %20s -> %5s</td>",$val_sa,$val_sb, ($sa === $sb) ? "TRUE" : "FALSE");
                printf("<td>%20s != %20s -> %5s</td>", $val_sa,$val_sb, ($sa != $sb) ? "TRUE" : "FALSE");
                printf("<td>%20s !== %20s -> %5s</td>",$val_sa,$val_sb, ($sa !== $sb) ? "TRUE" : "FALSE");
                echo "</tr>"; 
            }
            echo "</table>\n<br>";
        ?>
    </body>
</html> 