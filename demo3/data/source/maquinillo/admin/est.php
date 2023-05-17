<?php 
// -------------------------------------------------------------------------- //
// AWStats Access 1.1.0 //
//Provides access to AWStats outside of cPanel, for when you don't want users to have full access. //
//Fixed error when choosing date other than current date. //
// ------------------------------------------------------------------------- //
// Copyright (C) 2003 GeekMob.com//
// crazeegeek@geekmob.com //
// ------------------------------------------------------------------------ //
// Core script was written by Real Web Host //
// (http://realwebhost.net //
// ------------------------------------------------------------------------ //
// This program is free software; you can redistribute it and/or modify //
// it under the terms of the GNU General Public License as published by //
// the Free Software Foundation; either version 2 of the License, or //
// (at your option) any later version. //
// ----------------------------------------------------------------------- //


     if (!isset($PHP_AUTH_USER)) {


         header('WWW-Authenticate: Basic realm="Site Statistics"');
        header('HTTP/1.0 401 Unauthorized');
        echo 'Authorization Required.';
        exit;


    } else if (isset($PHP_AUTH_USER)) {


        if (($PHP_AUTH_USER != "miguel") || ($PHP_AUTH_PW != "corredor")) {


            header('WWW-Authenticate: Basic realm="Site Statistics"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Authorization Required.';
            exit;


        } else {
            if($QUERY_STRING == ""){$query = "config=boulesis.com";}else{$query=$QUERY_STRING;};


              exec("/usr/bin/curl 'http://boulesis:1ove9arade@www.boulesis.com:2082/awstats.pl?$query'",$return_message_array, $return_number);


         for ($i = 0; $i < count($return_message_array); $i++) {
         $results = $results.$return_message_array[$i];
		}


         if($query == "config=boulesis.com"){$results = str_replace("src=\"", "src=\"?", $results);}


        if($framename==index){$results = str_replace("src=\"", "src=\"est.php?", $results);}
         $results = str_replace("action=\"", "action=\"est.php?", $results);
         $results = str_replace("href=\"", "href=\"?", $results);
         $results = str_replace("awstats.pl?", "", $results);
		 $results = str_replace("src=\"/images", "src=\"/media", $results);
		 $results = str_replace("SRC=\"/images", "src=\"/media", $results);

          echo $results;
        }
    } 
?>