<?php
/**
 * G.I.N. Générateur d'idée pour vos nouvelles
 *
 * @author Stéphane ATLANI
 * @copyright Stéphane ATLANI - www.stephaneatlani.com
 * @link      http://www.stephaneatlani.com 
 * @since     0.0.1
 * @license   https://opensource.org/licenses/GPL-3.0 GNU Licence 3
 */
?>

<h1>Liste des Antiprotagonistes disponible</h1>
<ul>
    <?php
    foreach ($allAntiAntiprotagonistes as $value){
    ?>
        <li><?=$value->valeur ?></li>
    <?php    
    }
    ?>
</ul>
