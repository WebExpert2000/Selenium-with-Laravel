<?php

namespace Facebook\WebDriver\Chrome;
use DB;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverWait;
use Facebook\WebDriver\WebDriverExpectedCondition;
 use Facebook\WebDriver\Remote\WebDriverCapabilityType;

 
            $emailaddress=$user['name'];
            $pass=$user['password'];
            $proxy=$user['proxy'];
            $port=$user['port'];
           
            $host = 'http://localhost:4444/wd/hub'; // this is the default
            $options = new ChromeOptions();

            $options->addArguments(array("--disable-notifications"));
            $capabilities = DesiredCapabilities::chrome();
            $capabilities->setCapability(ChromeOptions::CAPABILITY, $options);
            
            $driver = RemoteWebDriver::create($host, $capabilities);

 
 

            $driver->get('https://www.facebook.com/marketplace/miami/'); 

            $element_username=$driver->findElement(WebDriverBy::name("email"));
            $element_pass=$driver->findElement(WebDriverBy::name("pass"));
            $element_btn=$driver->findElement(WebDriverBy::id("loginbutton"));
            $element_username->sendKeys($emailaddress);//i need user and password to login and test it !!!! 
            $element_pass->sendKeys($pass);
            $element_btn->click();
             $newurl = $driver->getCurrentUrl();
            
            if($newurl =="https://www.facebook.com/marketplace/miami/")
            {

                foreach ($items[$user['name']] as $item) 
                { 
                    $categories_name = $item['category'];
                    $what_to_sell = $item["selling"];
                    $price = $item["price"];
                    $description = $item["description"];
                     $remote_file_url = 'upload/'.$item['photo'];
                     
                    if (!file_exists('c:/img/'))
                         mkdir('c:/img/', 0777, true);
                        $local_file = 'c:\\img\\'.$item['photo'];   
                        $copy = copy( $remote_file_url, $local_file );echo $local_file; 
                 
                     $element_btn_seller=$driver->findElement(WebDriverBy::xpath('//*[@id="u_0_t"]/div/div[1]/div/div/div/button'));echo "Adsf";
                    $element_btn_seller->click(); 
                    
                    $element_btn_selle =$driver->wait(10)->until(WebDriverExpectedCondition::presenceOfAllElementsLocatedBy(WebDriverBy::className('_4d0f')));
                    $element_btn_seller1=$driver->findElements(WebDriverBy::className('_4d0f'));
                    $element_btn_seller1[0]->click();
                     
                    $temp=$driver->findElement(WebDriverBy::className('_2u1h'));//*[@id="rc.js_8"]/div/div[1]/div[2]/div[1]/label/input
                    $element_categories=$temp->findElement(WebDriverBy::tagName('input'));//*[@id="rc.js_8"]/div/div[1]/div[2]/div[1]/label/input

                    $element_categories->click();
                    $element_categories->sendKeys($categories_name);

                    $element_categories1=$driver->findElement(WebDriverBy::className('uiContextualLayerBelowLeft'));
                    $aa = $element_categories1->findElement(WebDriverBy::tagName('ul'));
                    $element_categories1->click();
                    $temp=$driver->findElement(WebDriverBy::className('_2t_f'));
                    $element_what_to_sell = $temp->findElement(WebDriverBy::tagName('input'));
                    $element_what_to_sell->sendKeys($what_to_sell);

                    $temp=$driver->findElement(WebDriverBy::className('_1hfy'));    
                    $element_price=$temp->findElement(WebDriverBy::tagName('input'));   
                    $element_price->sendKeys($price);

                    $element_description=$driver->findElement(WebDriverBy::className('_5rpu'));

                    $element_description->sendKeys($description);

                    
                    
                    $temp=$driver->findElement(WebDriverBy::className('_3jk'));
                    $element_img_uploader=$temp->findElement(WebDriverBy::tagName('input'));
                    //$element_img_uploader=$driver->findElement(WebDriverBy::className('fbScrollableAreaBody'));
                   
                    //$element_img_uploader->click();
                    $element_img_uploader->sendKeys($local_file);

                     sleep(7);
                    $temp = $driver->findElement(WebDriverBy::className('_2dck'));
                    $temp1 = $temp->findElement(WebDriverBy::className('_ohf'));
                    $element_btn_next = $temp1->findElement(WebDriverBy::tagName('button'));  //This is next button
                     $element_btn_next->click();
                     sleep(2);
                     $temp = $driver->findElement(WebDriverBy::className('_2dck'));
                    $temp1 = $temp->findElement(WebDriverBy::className('_ohf'));
                    $temp1 = $temp1->findElement(WebDriverBy::className('_332r'));
                    $element_btn_next = $temp1->findElement(WebDriverBy::tagName('button'));  //This is next button
                     $element_btn_next->click();
                     sleep(4);
                     $temp = $driver->findElement(WebDriverBy::className('_nx-'));
                    // $temp1 = $temp->findElement(WebDriverBy::tagName('div'));

                    $temp->click();

                    $newurl = $driver->getCurrentUrl();
                    $data =  array("facebook_link"=>$newurl,"posted_date"=>date('Y-m-d H:i:s'));
                  
                    // DB::table("items")->where("id",$id)->update(["facebook_linke"=>$newurl]);
                    DB::table("items")->where("id",$item["id"])->update($data);
                     # code...

                    $temp = $driver->findElement(WebDriverBy::className('_7tty'));
                    $element_btn_next = $temp->findElement(WebDriverBy::tagName('button'));
                    $element_btn_next->click();
                    sleep(5);
                 } 
            }
         
             $driver->quit();
             
       
        header("Location: /home");
die();
       // header('Location: '.$_SERVER['REQUEST_URI']);
?>
