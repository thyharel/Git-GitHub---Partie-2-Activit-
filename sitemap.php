<?php
// CONNEXION A LA BASE
//$mysqli = new mysqli("server","user","password","database");
$mysqli = new mysqli("localhost","root","","xml_rss");
if ($mysqli->connect_error){
	die( 'Probleme Mysql'.$mysqli->connect_error );
}

// PARTIE FIXE DE DEBUT DE SITEMAP
$monsitemap = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

// REQUETE
$requete = 'SELECT * FROM articles ORDER BY date DESC';
$resultat = $mysqli->query($requete);
// MISE EN FORME DES RESULTATS

while($article = $resultat->fetch_assoc()){

	$monsitemap .="<url>
<loc>http://www.monsite.fr/article.php?id=".$article['id']."</loc>
<lastmod>".$article['date']."</lastmod>
<changefreq>monthly</changefreq>
<priority>0.5</priority>
</url>";
}
// PARTIE FIXE DE FIN DE FLUX
$monsitemap .='</urlset>';

// Encodage en UTF8
$monsitemap = utf8_encode($monsitemap);

// CREATION DU FICHIER
$fichier = fopen('sitemap.xml', 'w+'); // w+ = mode d'ouverture du fichier 'fluxrss.xml'. Ici w+ signifie ouvert en lecture et en écriture. Si le fichier n'existe pas, on le crée. Si le fichier existe, on efface son contenu.

// fputs($fichier, $variable); copie le contenu de la variable dans le fichier.
// fputs() = fwrite() 
fputs($fichier, $monsitemap);
// équivalent à fwrite($fichier, $monsitemap);

// On ferme le fichier
fclose($fichier);






?>