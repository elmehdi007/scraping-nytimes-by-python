
<html>
    <head>
        <body>
            <form method="POST" action="">
                Add Row Data
                <input type="text" name="input" required>
                <button type="submit" name="add">Add</button>
            </form>
            <form method="POST" action="">
                Remove Row Data
                <input type="number" name="input" placeholder="Row Number" required>
                <button type="submit" name="remove">Remove</button>
            </form>
            <form method="POST" action="">
                Update Row Data
                <input type="number" name="row" placeholder="Row Number" required>
                <input type="text" name="value" placeholder="Change Value" required>
                <button type="submit" name="update">Update</button>
            </form>
        </body>
    </head>
</html>

<b style="font-size:20px;">ROW and DATA</b><br>

<?php

$csvsource = 'WORLIST_one.csv';

$file = fopen($csvsource, "r");
$counter = 0;
while (($data = fgetcsv($file)) !== false) {
    foreach ($data as $i) {
        if($i != "Header")
        {
            $counter++;
            echo "Row <b>".$counter."</b> Data: <b>".$i."</b><br>";
        }
    }
}
fclose($file);

if(isset($_POST['add'])){
    $list = array($_POST['input']);
    $file = fopen($csvsource,'a');  // 'a' for append to file - created if doesn't exit
    
    foreach ($list as $line)
    {
        fputcsv($file,explode(',',$line));
    }

    fclose($file); 
    header('location: index.php');
}

if(isset($_POST['remove'])){
    $row = ((int)$_POST['input'])-1;

    if($row <= 0) die("<br>You Cannot Delete This Row!");

    else
    {
        $file = fopen($csvsource, 'r');
        $data = [];

        while (($line = fgetcsv($file)) !== FALSE) 
        {
            $data[] = $line;
        }

        fclose($file);

        if($row >= count($data)) die("<br>You Cannot Delete This Row!");

        else {
            unset($data[$row]);
            $file = fopen($csvsource, 'w');
            foreach ($data as $fields) {
                fputcsv($file, $fields);
            }
    
            fclose($file);
            header('location: index.php');
        }
    }
}

if(isset($_POST['update'])){
    $row = ((int)$_POST['row'])-1;
    $value = $_POST['value'];

    if($row <= 0) die("<br>You Cannot Update This Row!");

    else
    {
        $csv = array();
        if(($handle = fopen($csvsource, "r")) !== FALSE)
        {
            while(($data = fgetcsv($handle, 1000, ",")) !== FALSE)
            {
                $csv[] = $data;
            }
        }
        
        fclose($handle);

        if($row >= count($csv)) die("<br>You Cannot Update This Row");

        else {
            $csv[$row] = array($value);
            $file = fopen($csvsource, 'w');
    
            foreach ($csv as $fields) {
                fputcsv($file, $fields);
            }
            
            
            fclose($file);
            header('location: index.php');
        }
    }
}
 
?>



