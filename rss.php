<?php
//Git & GitHub - Partie 2 Activité
//---------------------------------------------------------------------------------------//
// Generation  automatique d'un flux RSS
//
//---------------------------------------------------------------------------------------//
// connextion à la base.


    $mysqli = new Mysqli('localhost','root','','xmlrss');

    if($mysqli->connect_error){

        die('Un probleme est survenu lors de la connexion à la BDD'.$mysqli->connect_error);

    }

    $mysqli -> set_charset("utf8");
   
//---------------------------------------------------------------------------------------//
// passe les requete.

   /* function executeRequete($req){

    global $mysqli;
    $resultat = $mysqli->query($req);

    if(!$resultat) {

        die('Erreur de requete SQL.<br>'. $mysqli->error. '<br>La requete est : '.$req );
        }   

    return $resultat; 
     }*/

//---------------------------------------------------------------------------------------//
//entete du fichier xml

    $flux='<?xml version="1.0"?>
           <rss version="2.0">
           <channel>
           <title> Voici un flux rss </title>
           <link>http://www.monsite.fr</link>
           <description>Flux rss du site</description>
           <pubDate>'.date("Y-m-d H:i:s").'</pubDate>'."\n";


//---------------------------------------------------------------------------------------//
//Requete a la BDD

    $requete ="SELECT * FROM articles ORDER BY date DESC LIMIT 0,10";

    $article = $mysqli->query($requete);

//---------------------------------------------------------------------------------------//
// Mise en forme des resultat de la requete.

     while ($data = $article -> fetch_assoc()){
         
         
            
            $data['titre'] = htmlentities( str_replace('<','<![CDATA[<]]>',$data['titre']));
            $data['description'] = htmlentities( str_replace('<','<![CDATA[<]]>',$data['description']));
         
            $flux .='<item>'."\n";
            $flux .="\t".'<title>'.$data['titre'].'</title>'."\n";
            $flux .="\t".'<link>http://cmondev.net/article.php?id='.$data['id'].'</link>'."\n";        
            $flux .="\t".'<description>'.$data['description'].'</description>'."\n";  
            $flux .="\t".'<pubDate>'.$data['date'].'</pubDate>'."\n";
            $flux .='</item>'."\n";
         
     } 





    $flux .= '</channel></rss>';
//---------------------------------------------------------------------------------------//
//creation du fichier rss.xml


    $fichier = fopen('flux_rss.xml','w+');

    fwrite($fichier,$flux);

    fclose($fichier);

?>