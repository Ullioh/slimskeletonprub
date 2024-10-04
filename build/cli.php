<?php
ini_set('memory_limit', '-1');
set_time_limit(10000);
require __DIR__ . '/../vendor/autoload.php';
session_start();

$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

require __DIR__ . '/../src/dependencies.php';

require __DIR__ . '/../src/middleware.php';

require __DIR__ . '/../src/routes.php';

require __DIR__ . '/../app/app_loader.php';



if (PHP_SAPI == 'cli') {
    $argv = $_SERVER['argv'];
    $json = file_get_contents(__DIR__."/build.json");
    $build = json_decode($json, true);
    if($argv[1]){
        $useAr = $argv[1];
        $useupper = $argv[1];
        $useupper[0] = strtoupper($useupper[0]);

        $dataUse = $build[$argv[1]];
        
        $name = $argv[1] != "route" ? strtolower($argv[2]).$useupper:strtolower($argv[2]);
        $name[0] = $argv[1] != "route" ? strtoupper($name[0]):$name[0];
        $name_file = $argv[2]."_$useAr.php";
        $name_file = strtolower($name_file);
        
        $php = file_get_contents(__DIR__."/base/$useAr.php");
        
        if(isset($dataUse["namespace"])){
            $namespace = generateNamespace($dataUse["namespace"]);
            $php = str_replace("ReplaceNamespace",$namespace,$php);
        }
        
        if(isset($dataUse["use"])){
            $use = generateUse($dataUse["use"]);
            $php = str_replace("ReplaceUse;",$use,$php);
        }

        switch ($useAr) {
            case 'route':
                $controllers = [];
                if(isset($argv[3])){
                    $controllers = explode(",",$argv[3]);
                }else{
                    do{
                        $a = readline('Enter a Controller (Enter to end): ');
                        strlen($a) ? $controllers[] = $a:"";
                    }while(strlen($a)>0);
                }
                $printController = "";
                $printRouteExample = "";
                for ($i=0; $i < count($controllers); $i++) { 
                    $printController.= "use App\\Controller\\".$controllers[$i].";\n";
                    $printRouteExample.= controllerInRoute($controllers[$i]);
                }
                $php = str_replace("routes;",$printRouteExample,$php);
                $php = str_replace("ReplaceController;",$printController,$php);
                break;
            case 'model':
                $column = [];
                $inserted = [];
                $edited = [];
                $shown = [];
                $filter = [];
                $status_delete = 'null';
                if(isset($argv[3])){
                    $table = $argv[3];
                }else{
                    do{
                        $a = readline('Table name: ');
                        strlen($a) ? $table = $a:"";
                    }while(strlen($a)==0);
                }
                do{
                    $col = readline('Enter a column (Enter to end): ');
                    if(strlen($col)){
                        $column[] = $col;
                        $a = readline('Can it be inserted? (Y or N): ');
                        ($a == "Y" || $a == "y") ? $inserted[] = "'".$col."'":"";

                        $a = readline('Can it be edited? (Y or N): ');
                        ($a == "Y" || $a == "y") ? $edited[] = "'".$col."'":"";

                        $a = readline('Can it be shown? (Y or N): ');
                        ($a == "Y" || $a == "y") ? $shown[] = "'".$col."'":"";

                        $a = readline('Can it be used to filter searches? (Y or N): ');
                        ($a == "Y" || $a == "y") ? $filter[] = "'".$col."'":"";
                    }
                }while(strlen($col));
                printf("What is the column for the logical deletion?\n");
                for ($i=0; $i < count($column); $i++) { 
                    printf("$i = ".$column[$i]."\n");
                }
                do{
                    $repeat = false;
                    $colDeleted = readline('Enter a number (enter N to skip): ');
                    if(strlen($colDeleted)>0 && is_numeric($colDeleted) && $colDeleted>=0 && $colDeleted<count($column)){
                        $valuesDeleted = readline('What is the value of the deletion? (0 default): ');
                    }else{
                        if($colDeleted=='n' || $colDeleted=='N'){
                            $repeat = false;
                        }else{
                            $repeat = true;
                        }
                    }
                }while($repeat);
                if($colDeleted!="N" && $colDeleted!="n"){
                    $valueDelete = strlen($valuesDeleted) ? $valuesDeleted:"0";
                    $status_delete = 'array(
                        "name"      =>  "'.$column[$colDeleted].'",
                        "deleted"   =>  '.$valueDelete.'
                    )';
                }
                $php = str_replace("tabla_use",$table,$php);
                $php = str_replace("inserted",implode(",",$inserted),$php);
                $php = str_replace("edited",implode(",",$edited),$php);
                $php = str_replace("shown",implode(",",$shown),$php);
                $php = str_replace("filteruse",implode(",",$filter),$php);
                $php = str_replace("status_delete",$status_delete,$php);
                break;
        }
        $php = str_replace("ReplaceName",$name,$php);
        $ar = fopen(__DIR__."/../app/$useAr/".$name_file, "a") or die("Problemas en la creacion");
        fputs($ar, $php);
        fclose($ar);
    }
}

function generateNamespace($namespace){
    return implode('\\',$namespace);
}

function generateUse($use){
    // use App\Config\InitController;
    $uses = "";
    for ($i=0; $i < count($use); $i++) { 
        $uses.= "use ".implode('\\',$use[$i]).";\n";
    }
    return $uses;
}

function controllerInRoute($controller){
    $showExample = '
    $this->get("test_get", TestController::class.":test");
    $this->get("test_get_middleware", TestController::class.":test")->add($middleware);
    $this->post("test_post", TestController::class.":test");
    $this->post("test_post_middleware", TestController::class.":test")->add($middleware);
    ';
    return str_replace("TestController",$controller,$showExample);
}