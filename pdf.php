<?php
require('pdf/fpdf.php');
define('EURO', chr(128));
define('EURO_VAL', 6.55957);

// Xavier Nicolay 2004
// Version 1.02
//
// Reste � faire :
// + Multipage (gestion automatique sur plusieurs pages)
// + Ajout de logo
// 

//////////////////////////////////////
// fonctions � utiliser (publiques) //
//////////////////////////////////////
//  function sizeOfText( $texte, $larg )
//  function addSociete( $nom, $adresse )
//  function fact_dev( $libelle, $num )
//  function addDevis( $numdev )
//  function addFacture( $numfact )
//  function addDate( $date )
//  function addClient( $ref )
//  function addPageNumber( $page )
//  function addClientAdresse( $adresse )
//  function addReglement( $mode )
//  function addEcheance( $date )
//  function addNumTVA($tva)
//  function addReference($ref)
//  function addCols( $tab )
//  function addLineFormat( $tab )
//  function lineVert( $tab )
//  function addLine( $ligne, $tab )
//  function addRemarque($remarque)
//  function addCadreTVAs()
//  function addCadreEurosFrancs()
//  function addTVAs( $params, $tab_tva, $invoice )
//  function temporaire( $texte )

class PDF_Invoice extends FPDF
{
	// variables priv�es
	var $colonnes;
	var $format;
	var $angle = 0;

	// fonctions priv�es
	function RoundedRect($x, $y, $w, $h, $r, $style = '')
	{
		$k = $this->k;
		$hp = $this->h;
		if ($style == 'F')
			$op = 'f';
		elseif ($style == 'FD' || $style == 'DF')
			$op = 'B';
		else
			$op = 'S';
		$MyArc = 4 / 3 * (sqrt(2) - 1);
		$this->_out(sprintf('%.2F %.2F m', ($x + $r) * $k, ($hp - $y) * $k));
		$xc = $x + $w - $r;
		$yc = $y + $r;
		$this->_out(sprintf('%.2F %.2F l', $xc * $k, ($hp - $y) * $k));

		$this->_Arc($xc + $r * $MyArc, $yc - $r, $xc + $r, $yc - $r * $MyArc, $xc + $r, $yc);
		$xc = $x + $w - $r;
		$yc = $y + $h - $r;
		$this->_out(sprintf('%.2F %.2F l', ($x + $w) * $k, ($hp - $yc) * $k));
		$this->_Arc($xc + $r, $yc + $r * $MyArc, $xc + $r * $MyArc, $yc + $r, $xc, $yc + $r);
		$xc = $x + $r;
		$yc = $y + $h - $r;
		$this->_out(sprintf('%.2F %.2F l', $xc * $k, ($hp - ($y + $h)) * $k));
		$this->_Arc($xc - $r * $MyArc, $yc + $r, $xc - $r, $yc + $r * $MyArc, $xc - $r, $yc);
		$xc = $x + $r;
		$yc = $y + $r;
		$this->_out(sprintf('%.2F %.2F l', ($x) * $k, ($hp - $yc) * $k));
		$this->_Arc($xc - $r, $yc - $r * $MyArc, $xc - $r * $MyArc, $yc - $r, $xc, $yc - $r);
		$this->_out($op);
	}

	function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
	{
		$h = $this->h;
		$this->_out(sprintf(
			'%.2F %.2F %.2F %.2F %.2F %.2F c ',
			$x1 * $this->k,
			($h - $y1) * $this->k,
			$x2 * $this->k,
			($h - $y2) * $this->k,
			$x3 * $this->k,
			($h - $y3) * $this->k
		));
	}

	function Rotate($angle, $x = -1, $y = -1)
	{
		if ($x == -1)
			$x = $this->x;
		if ($y == -1)
			$y = $this->y;
		if ($this->angle != 0)
			$this->_out('Q');
		$this->angle = $angle;
		if ($angle != 0) {
			$angle *= M_PI / 180;
			$c = cos($angle);
			$s = sin($angle);
			$cx = $x * $this->k;
			$cy = ($this->h - $y) * $this->k;
			$this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
		}
	}

	function _endpage()
	{
		if ($this->angle != 0) {
			$this->angle = 0;
			$this->_out('Q');
		}
		parent::_endpage();
	}

	// fonctions publiques
	function sizeOfText($texte, $largeur)
	{
		$index    = 0;
		$nb_lines = 0;
		$loop     = TRUE;
		while ($loop) {
			$pos = strpos($texte, "\n");
			if (!$pos) {
				$loop  = FALSE;
				$ligne = $texte;
			} else {
				$ligne  = substr($texte, $index, $pos);
				$texte = substr($texte, $pos + 1);
			}
			$length = floor($this->GetStringWidth($ligne));
			//$res = 1 + floor( $length / $largeur) ;
			$res = 1 + floor($length / 1);
			$nb_lines += $res;
		}
		return $nb_lines;
	}

	// Cette fonction affiche en haut, a gauche,
	// le nom de la societe dans la police Arial-12-Bold
	// les coordonnees de la societe dans la police Arial-10
	function addSociete($nom, $adresse)
	{
		$r1  = 10;
		$r2  = $r1 + 70;
		$mid = ($r1 + $r2) / 2;
		$y = 6;
		$x1 = 19;
		$y1 = 12;
		$y2  = $y1 + 26;
		//Positionnement en bas

		$this->SetXY($x1, $y1);
		$this->SetFillColor(255);
		$this->RoundedRect($r1, $y, ($r2 - $r1), $y2, 2.5, 'DF');
		$this->SetFont('Arial', 'B', 8);
		$length = $this->GetStringWidth($nom);
		$this->Cell($length, 2, $nom);
		$this->SetXY($x1, $y1 + 4);
		$this->SetFont('Arial', '', 7);
		$length = $this->GetStringWidth($adresse);
		//Coordonn�es de la soci�t�
		$lignes = $this->sizeOfText($adresse, $length);
		$this->MultiCell($length, 4, utf8_decode($adresse));
	}

	// Affiche en haut, a droite le libelle
	// (FACTURE, DEVIS, Bon de commande, etc...)
	// et son numero
	// La taille de la fonte est auto-adaptee au cadre
	function fact_dev($libelle, $num)
	{
		$r1  = $this->w - 80;
		$r2  = $r1 + 68;
		$y1  = 6;
		$y2  = $y1 + 2;
		$mid = ($r1 + $r2) / 2;

		$texte  = $libelle . " N� : " . $num;
		$szfont = 12;
		$loop   = 0;

		while ($loop == 0) {
			$this->SetFont("Arial", "B", $szfont);
			$sz = $this->GetStringWidth($texte);
			if (($r1 + $sz) > $r2)
				$szfont--;
			else
				$loop++;
		}

		$this->SetLineWidth(0.1);
		$this->SetFillColor(192);
		$this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 2.5, 'DF');
		$this->SetXY($r1 + 1, $y1 + 2);
		$this->Cell($r2 - $r1 - 1, 5, $texte, 0, 0, "C");
	}

	// Genere automatiquement un numero de devis
	function addDevis($numdev)
	{
		$string = sprintf("DEV%04d", $numdev);
		$this->fact_dev("Devis", $string);
	}

	// Genere automatiquement un numero de facture
	function addFacture($numfact)
	{
		$string = sprintf("FA%04d", $numfact);
		$this->fact_dev("Facture", $string);
	}

	// Affiche un cadre avec la date de la facture / devis
	// (en haut, a droite)
	function addDate($date)
	{
		$r1  = $this->w - 61;
		$r2  = $r1 + 30;
		$y1  = 17;
		$y2  = $y1;
		$mid = $y1 + ($y2 / 2);
		$this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 3.5, 'D');
		$this->Line($r1, $mid, $r2, $mid);
		$this->SetXY($r1 + ($r2 - $r1) / 2 - 5, $y1 + 3);
		$this->SetFont("Arial", "B", 10);
		$this->Cell(10, 5, "DATE", 0, 0, "C");
		$this->SetXY($r1 + ($r2 - $r1) / 2 - 5, $y1 + 9);
		$this->SetFont("Arial", "", 10);
		$this->Cell(10, 5, $date, 0, 0, "C");
	}

	// Affiche un cadre avec les references du client
	// (en haut, a droite)
	function addClient($ref)
	{
		$r1  = $this->w - 21;
		$r2  = $r1 + 19;
		$y1  = 17;
		$y2  = $y1;
		$mid = $y1 + ($y2 / 2);
		$this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 3.5, 'D');
		$this->Line($r1, $mid, $r2, $mid);
		$this->SetXY($r1 + ($r2 - $r1) / 2 - 5, $y1 + 3);
		$this->SetFont("Arial", "B", 10);
		$this->Cell(10, 5, "CLIENT", 0, 0, "C");
		$this->SetXY($r1 + ($r2 - $r1) / 2 - 5, $y1 + 9);
		$this->SetFont("Arial", "", 10);
		$this->Cell(10, 5, $ref, 0, 0, "C");
	}

	// Affiche un cadre avec un numero de page
	// (en haut, a droite)
	function addPageNumber($page)
	{
		$r1  = $this->w - 80;
		$r2  = $r1 + 19;
		$y1  = 17;
		$y2  = $y1;
		$mid = $y1 + ($y2 / 2);
		$this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 3.5, 'D');
		$this->Line($r1, $mid, $r2, $mid);
		$this->SetXY($r1 + ($r2 - $r1) / 2 - 5, $y1 + 3);
		$this->SetFont("Arial", "B", 10);
		$this->Cell(10, 5, "PAGE", 0, 0, "C");
		$this->SetXY($r1 + ($r2 - $r1) / 2 - 5, $y1 + 9);
		$this->SetFont("Arial", "", 10);
		$this->Cell(10, 5, $page, 0, 0, "C");
	}

	// Affiche l'adresse du client
	// (en haut, a droite)
	function addClientAdresse($nom, $adresse)
	{

		$r1     = $this->w - 80;
		$r2     = $r1 + 70;
		$y 		= 6;
		$y1     = 12;
		$x1 = 140;
		$y2  = $y1 + 26;
		$mid = $y1 + ($y2 / 2);
		$this->SetXY($x1, $y1);
		$this->SetFillColor(255);
		$this->RoundedRect($r1, $y, ($r2 - $r1), $y2, 2.5, 'DF');
		/*$this->SetXY( $r1, $y1);
	$this->SetFont('Arial','',7);
	$this->MultiCell( 60, 4,  utf8_decode($adresse));*/
		$this->SetFont('Arial', 'B', 8);
		$length = $this->GetStringWidth($nom);
		$this->Cell($length, 2, $nom);
		$this->SetXY($x1, $y1 + 4);
		$this->SetFont('Arial', '', 7);
		$length = $this->GetStringWidth($adresse);
		//Coordonn�es de la soci�t�
		$lignes = $this->sizeOfText($adresse, $length);
		$this->MultiCell($length, 4, utf8_decode($adresse));
	}



	// trace le cadre a gauche des infos de la facture
	function addCadreFacture($client)
	{
		$this->SetFont("Arial", "B", 8);
		$r1  = 10;
		$r2  = $r1 + 70;
		$y1  = 50;
		$y2  = $y1 + 10;

		$this->SetFillColor(255);
		$this->Rect($r1, $y1, ($r2 - $r1), ($y2 - $y1) + 15, "DF");
		$this->SetFillColor(230);
		$this->Rect($r1, $y1, 35, 25, "DF");
		$this->Line($r1 + 35, $y1, $r1 + 35, $y2 + 5);  // verticale 
		$this->SetXY($r1 + 1, $y1);
		$this->Cell(10, 6, "Facture #");
		$this->SetXY($r1 + 1, $y1 + 5);
		$this->Cell(10, 6, "Date de D�part :");
		$this->SetXY($r1 + 1, $y1 + 10);
		$this->Cell(10, 6, "Date de Retour :");
		$this->SetXY($r1 + 1, $y1 + 15);
		$this->Cell(10, 6, "Type de service :");
		$this->SetXY($r1 + 1, $y1 + 20);
		if ($client != "") {
			$lib_cli = "Client :";
		} else {
			$lib_cli = "";
		}
		$this->Cell(10, 6, $lib_cli);
		$this->Line($r1, $y1 + 5, $r2, $y1 + 5);  // horizontale 
		$this->Line($r1, $y1 + 10, $r2, $y1 + 10);  // horizontale 
		$this->Line($r1, $y1 + 15, $r2, $y1 + 15);  // horizontale 
		$this->Line($r1, $y1 + 20, $r2, $y1 + 20);  // horizontale
		$this->SetFont("Arial", "", 8);
	}

	// rempli le cadre a gauche des infos de la facture
	function fillCadreFacture($num, $datedep, $dateret, $type, $client)
	{
		$this->SetFont("Arial", "", 8);
		$r1  = 45;
		$r2  = $r1 + 70;
		$y1  = 50;
		$y2  = $y1 + 10;

		$this->SetXY($r1 + 1, $y1);
		$this->Cell(10, 6, $num);
		$this->SetXY($r1 + 1, $y1 + 5);
		$this->Cell(10, 6, $datedep);
		$this->SetXY($r1 + 1, $y1 + 10);
		$this->Cell(10, 6, $dateret);
		$this->SetXY($r1 + 1, $y1 + 15);
		$this->Cell(10, 6, $type);
		$this->SetXY($r1 + 1, $y1 + 20);
		$this->Cell(10, 6, $client);
	}

	// trace le cadre a droite des infos de la facture
	function addCadreFacture2()
	{
		$this->SetFont("Arial", "B", 8);
		$r1  = 130;
		$r2  = $r1 + 70;
		$y1  = 50;
		$y2  = $y1 + 10;

		$this->SetFillColor(255);
		$this->Rect($r1, $y1, ($r2 - $r1), ($y2 - $y1) + 15, "DF");
		$this->SetFillColor(230);
		$this->Rect($r1, $y1, 35, 25, "DF");
		$this->Line($r1 + 35, $y1, $r1 + 35, $y2 + 5);  // verticale 
		$this->SetXY($r1 + 1, $y1);
		$this->Cell(10, 6, "Date de Facture");
		$this->SetXY($r1 + 1, $y1 + 5);
		$this->Cell(10, 6, "Lieu de D�part :");
		$this->SetXY($r1 + 1, $y1 + 10);
		$this->Cell(10, 6, "Lieu de Retour :");
		$this->SetTextColor(255, 0, 0);
		$this->SetXY($r1 + 1, $y1 + 15);
		$this->Cell(10, 6, "REF :");
		$this->SetXY($r1 + 1, $y1 + 20);
		$this->Cell(10, 6, "LBG :");
		$this->SetTextColor(0, 0, 0);
		$this->Line($r1, $y1 + 5, $r2, $y1 + 5);  // horizontale 
		$this->Line($r1, $y1 + 10, $r2, $y1 + 10);  // horizontale 
		$this->Line($r1, $y1 + 15, $r2, $y1 + 15);  // horizontale 
		$this->Line($r1, $y1 + 20, $r2, $y1 + 20);  // horizontale
		$this->SetFont("Arial", "", 8);
	}

	// trace le cadre a droite des infos de la facture
	function fillCadreFacture2($datefact, $lieudep, $lieuret, $ref, $lbg)
	{
		$this->SetFont("Arial", "B", 8);
		$r1  = 165;
		$r2  = $r1 + 70;
		$y1  = 50;
		$y2  = $y1 + 10;

		$this->SetXY($r1 + 1, $y1);
		$this->Cell(10, 6, $datefact);
		$this->SetXY($r1 + 1, $y1 + 5);
		$this->SetFont("Arial", "", 6);
		$this->Cell(10, 6, utf8_decode($lieudep));
		$this->SetXY($r1 + 1, $y1 + 10);
		$this->Cell(10, 6, utf8_decode($lieuret));
		$this->SetFont("Arial", "B", 8);
		$this->SetXY($r1 + 1, $y1 + 15);
		$this->Cell(10, 6, $ref);
		$this->SetXY($r1 + 1, $y1 + 20);
		$this->Cell(10, 6, $lbg);
		$this->SetFont("Arial", "", 8);
	}

	// Affiche un cadre avec le r�glement (ch�que, etc...)
	// (en haut, a gauche)
	function addReglement($mode)
	{
		$r1  = 10;
		$r2  = $r1 + 60;
		$y1  = 80;
		$y2  = $y1 + 10;
		$mid = $y1 + (($y2 - $y1) / 2);
		$this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2 - $y1), 2.5, 'D');
		$this->Line($r1, $mid, $r2, $mid);
		$this->SetXY($r1 + ($r2 - $r1) / 2 - 5, $y1 + 1);
		$this->SetFont("Arial", "B", 10);
		$this->Cell(10, 4, "MODE DE REGLEMENT", 0, 0, "C");
		$this->SetXY($r1 + ($r2 - $r1) / 2 - 5, $y1 + 5);
		$this->SetFont("Arial", "", 10);
		$this->Cell(10, 5, $mode, 0, 0, "C");
	}



	// Affiche un cadre avec la date d'echeance
	// (en haut, au centre)
	function addEcheance($date)
	{
		$r1  = 80;
		$r2  = $r1 + 40;
		$y1  = 80;
		$y2  = $y1 + 10;
		$mid = $y1 + (($y2 - $y1) / 2);
		$this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2 - $y1), 2.5, 'D');
		$this->Line($r1, $mid, $r2, $mid);
		$this->SetXY($r1 + ($r2 - $r1) / 2 - 5, $y1 + 1);
		$this->SetFont("Arial", "B", 10);
		$this->Cell(10, 4, "DATE D'ECHEANCE", 0, 0, "C");
		$this->SetXY($r1 + ($r2 - $r1) / 2 - 5, $y1 + 5);
		$this->SetFont("Arial", "", 10);
		$this->Cell(10, 5, $date, 0, 0, "C");
	}

	// Affiche un cadre avec le numero de la TVA
	// (en haut, au droite)
	function addNumTVA($tva)
	{
		$this->SetFont("Arial", "B", 10);
		$r1  = $this->w - 80;
		$r2  = $r1 + 70;
		$y1  = 80;
		$y2  = $y1 + 10;
		$mid = $y1 + (($y2 - $y1) / 2);
		$this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2 - $y1), 2.5, 'D');
		$this->Line($r1, $mid, $r2, $mid);
		$this->SetXY($r1 + 16, $y1 + 1);
		$this->Cell(40, 4, "TVA Intracommunautaire", '', '', "C");
		$this->SetFont("Arial", "", 10);
		$this->SetXY($r1 + 16, $y1 + 5);
		$this->Cell(40, 5, $tva, '', '', "C");
	}

	// Affiche une ligne avec des reference
	// (en haut, a gauche)
	function addReference($ref)
	{
		$this->SetFont("Arial", "", 10);
		$length = $this->GetStringWidth("R�f�rences : " . $ref);
		$r1  = 10;
		$r2  = $r1 + $length;
		$y1  = 92;
		$y2  = $y1 + 5;
		$this->SetXY($r1, $y1);
		$this->Cell($length, 4, "R�f�rences : " . $ref);
	}

	// trace le cadre des colonnes du devis/facture
	function addCols($tab)
	{
		global $colonnes;
		$i = 0;
		$r1  = 10;
		$r2  = $this->w - ($r1 * 2);
		$y1  = 120;
		$y2  = $this->h - 65 - $y1;
		$this->SetFont("Arial", "B", 9);
		$this->SetXY($r1, $y1);
		$this->SetFillColor(230);
		$this->Rect($r1, $y1, $r2, $y1 + 10, "DF");
		$this->SetFillColor(255);
		$this->Rect($r1, $y1 + 10, $r2, $y2, "DF");
		$this->Line($r1, $y1 + 10, $r1 + $r2, $y1 + 10);
		$colX = $r1;
		$colonnes = $tab;

		while (list($lib, $pos) = each($tab)) {
			$i += 1;
			$this->SetXY($colX, $y1 + 4);
			$this->Cell($pos, 1, utf8_decode($lib), 0, 0, "C");
			$colX += $pos;
			if ($i == 8) {
				$test = 2;
			} else {
				$this->Line($colX, $y1, $colX, $y1 + $y2 + 10);
			}
		}
		$this->SetFont("Arial", "", 7);
	}

	function addCols2($tab)
	{
		global $colonnes;
		$i = 0;
		$r1  = 10;
		$r2  = $this->w - ($r1 * 2);
		$y1  = 50;
		$y2  = $this->h - 135 - $y1;
		$this->SetFont("Arial", "B", 9);
		$this->SetXY($r1, $y1);
		$this->SetFillColor(230);
		$this->Rect($r1, $y1, $r2, $y1 + 10, "DF");
		$this->SetFillColor(255);
		$this->Rect($r1, $y1 + 10, $r2, $y2, "DF");
		$this->Line($r1, $y1 + 10, $r1 + $r2, $y1 + 10);
		$colX = $r1;
		$colonnes = $tab;

		while (list($lib, $pos) = each($tab)) {
			$i += 1;
			$this->SetXY($colX, $y1 + 4);
			$this->Cell($pos, 1, utf8_decode($lib), 0, 0, "C");
			$colX += $pos;
			if ($i == 8) {
				$test = 2;
			} else {
				$this->Line($colX, $y1, $colX, $y1 + $y2 + 10);
			}
		}
		$this->SetFont("Arial", "", 7);
	}

	// m�morise le format (gauche, centre, droite) d'une colonne
	function addLineFormat($tab)
	{
		global $format, $colonnes;

		while (list($lib, $pos) = each($colonnes)) {
			if (isset($tab["$lib"]))
				$format[$lib] = $tab["$lib"];
		}
	}

	function lineVert($tab)
	{
		global $colonnes;

		reset($colonnes);
		$maxSize = 0;
		while (list($lib, $pos) = each($colonnes)) {
			$texte = $tab[$lib];
			$longCell  = $pos - 2;
			$size = $this->sizeOfText($texte, $longCell);
			if ($size > $maxSize)
				$maxSize = $size;
		}
		return $maxSize;
	}

	// Affiche chaque "ligne" d'un devis / facture
	/*    $ligne = array( "REFERENCE"    => $prod["ref"],
                      "DESIGNATION"  => $libelle,
                      "QUANTITE"     => sprintf( "%.2F", $prod["qte"]) ,
                      "P.U. HT"      => sprintf( "%.2F", $prod["px_unit"]),
                      "MONTANT H.T." => sprintf ( "%.2F", $prod["qte"] * $prod["px_unit"]) ,
                      "TVA"          => $prod["tva"] );
*/
	function addLine($ligne, $tab)
	{
		global $colonnes, $format;

		$ordonnee     = 10;
		$maxSize      = $ligne;

		reset($colonnes);
		while (list($lib, $pos) = each($colonnes)) {
			$longCell  = $pos - 2;
			$texte     = $tab[$lib];
			$length    = $this->GetStringWidth($texte);
			$tailleTexte = $this->sizeOfText($texte, $length);
			$formText  = $format[$lib];
			$this->SetXY($ordonnee, $ligne - 1);
			$this->MultiCell($longCell, 4, utf8_decode($texte), 0, $formText);
			if ($maxSize < ($this->GetY()))
				$maxSize = $this->GetY();
			$ordonnee += $pos;
		}
		return ($maxSize - $ligne);
	}

	// Ajoute une remarque (en bas, a gauche)
	function addRemarque($remarque)
	{
		$this->SetFont("Arial", "", 10);
		$length = $this->GetStringWidth("Remarque : " . $remarque);
		$r1  = 10;
		$r2  = $r1 + $length;
		$y1  = $this->h - 45.5;
		$y2  = $y1 + 5;
		$this->SetXY($r1, $y1);
		$this->Cell($length, 4, "Remarque : " . $remarque);
	}

	// Ajoute lignes question et penalit�s (en bas)
	function addQuestion($question, $contact, $penalite, $taux)
	{
		$ysous = 95;
		$length = $this->GetStringWidth($question);
		$r1  = ($this->w - $length) / 2;
		$y1  = $this->h - $ysous;
		$this->SetXY($r1, $y1);
		$this->SetFont("Arial", "", 7);
		$this->Cell($length, 4, utf8_decode($question));
		$length = $this->GetStringWidth($contact);
		$r1  = ($this->w - $length) / 2;
		$y1  = $this->h - $ysous + 3;
		$this->SetXY($r1, $y1);
		$this->SetTextColor(255, 0, 0);
		$this->SetFont("Arial", "B", 7);
		$this->Cell($length, 4, utf8_decode($contact));
		$length = $this->GetStringWidth($penalite);
		$r1  = 10 + ($this->w - $length) / 2;
		$y1  = $this->h - $ysous + 6;
		$this->SetTextColor(0, 0, 0);
		$this->SetFont("Arial", "", 7);
		$this->SetXY($r1, $y1);
		$this->Cell($length, 4, utf8_decode($penalite));
		$length = $this->GetStringWidth($taux);
		$r1  = ($this->w - $length) / 2;
		$y1  = $this->h - $ysous + 9;
		$this->SetTextColor(0, 0, 0);
		$this->SetXY($r1, $y1);
		$this->Cell($length, 4, utf8_decode($taux));
	}


	// trace le cadre des TVA
	function addCadreTVAs()
	{
		$this->SetFont("Arial", "", 8);
		$r1  = 10;
		$r2  = $r1 + 70;
		$y1  = $this->h - 78;
		$y2  = $y1 + 10;

		$this->SetFillColor(255);
		$this->Rect($r1, $y1, ($r2 - $r1), ($y2 - $y1) + 10, "DF");
		$this->SetFillColor(230);
		$this->Rect($r1, $y1, ($r2 - $r1), 5, "DF");
		$this->Line($r1 + 27, $y1, $r1 + 27, $y2 + 10);  // verticale
		$this->Line($r1 + 47, $y1, $r1 + 47, $y2 + 10);  // verticale  
		$this->SetXY($r1 + 5, $y1 - 1);
		$this->Cell(10, 7, "Montant H.T");
		$this->SetX($r1 + 30);
		$this->Cell(10, 7, "Tx TVA");
		$this->SetX($r1 + 49);
		$this->Cell(10, 7, "Montant TVA");
		$this->Line($r1, $y1 + 5, $r2, $y1 + 5);  // horizontale avant total tva
		$this->Line($r1, $y1 + 10, $r2, $y1 + 10);  // horizontale avant total ttc
		$this->Line($r1, $y1 + 15, $r2, $y1 + 15);  // horizontale avant total ttc
	}


	// trace le cadre des TVA
	function fillCadreTVAs($fact1ht, $taux1, $fact1tva, $fact2ht, $taux2, $fact2tva, $fact3ht, $taux3, $fact3tva)
	{
		$this->SetFont("Arial", "", 8);
		$r1  = 10;
		$r2  = $r1 + 70;
		$y1  = $this->h - 78;
		$y2  = $y1 + 10;

		$this->SetXY($r1 + 15, $y1 + 4);
		$this->Cell(10, 7, number_format($fact1ht, 2, '.', '') . " �", 0, 0, 'R');
		$this->SetXY($r1 + 31, $y1 + 4);
		$this->Cell(10, 7, $taux1);
		$this->SetXY($r1 + 56, $y1 + 4);
		$this->Cell(10, 7, number_format($fact1tva, 2, '.', '') . " �", 0, 0, 'R');
		$this->SetXY($r1 + 15, $y1 + 9);
		$this->Cell(10, 7, number_format($fact2ht, 2, '.', '') . " �", 0, 0, 'R');
		$this->SetXY($r1 + 31, $y1 + 9);
		$this->Cell(10, 7, $taux2);
		$this->SetXY($r1 + 56, $y1 + 9);
		$this->Cell(10, 7, number_format($fact2tva, 2, '.', '') . " �", 0, 0, 'R');
		$this->SetXY($r1 + 15, $y1 + 14);
		$this->Cell(10, 7, number_format($fact3ht, 2, '.', '') . " �", 0, 0, 'R');
		$this->SetXY($r1 + 31, $y1 + 14);
		$this->Cell(10, 7, $taux3);
		$this->SetXY($r1 + 56, $y1 + 14);
		$this->Cell(10, 7, number_format($fact3tva, 2, '.', '') . " �", 0, 0, 'R');
	}

	// trace le cadre des Totaux
	function addCadreTotaux()
	{
		$this->SetFont("Arial", "", 8);
		$r1  = 130;
		$r2  = $r1 + 70;
		$y1  = $this->h - 78;
		$y2  = $y1 + 10;

		$this->SetFillColor(255);
		$this->Rect($r1, $y1, ($r2 - $r1), ($y2 - $y1) + 5, "DF");
		$this->SetFillColor(230);
		$this->Rect($r1, $y1, 35, 15, "DF");
		$this->Line($r1 + 35, $y1, $r1 + 35, $y2 + 5);  // verticale 
		$this->SetXY($r1 + 10, $y1);
		$this->Cell(10, 6, "Total H.T");
		$this->SetXY($r1 + 10, $y1 + 5);
		$this->Cell(10, 6, "Total TVA");
		$this->SetXY($r1 + 10, $y1 + 10);
		$this->Cell(10, 6, "Total TTC");
		$this->SetXY($r1 + 6, $y1 + 20);
		$this->Line($r1, $y1 + 5, $r2, $y1 + 5);  // horizontale avant total tva
		$this->Line($r1, $y1 + 10, $r2, $y1 + 10);  // horizontale avant total ttc
	}

	// trace le cadre des Totaux
	function addCadreTotauxAcompte()
	{
		$this->SetFont("Arial", "", 8);
		$r1  = 130;
		$r2  = $r1 + 70;
		$y1  = $this->h - 78;
		$y2  = $y1 + 10;

		$this->SetFillColor(255);
		$this->Rect($r1, $y1, ($r2 - $r1), ($y2 - $y1) + 15, "DF");
		$this->SetFillColor(230);
		$this->Rect($r1, $y1, 35, 25, "DF");
		$this->Line($r1 + 35, $y1, $r1 + 35, $y2 + 15);  // verticale 
		$this->SetXY($r1 + 10, $y1);
		$this->Cell(10, 6, "Total H.T");
		$this->SetXY($r1 + 10, $y1 + 5);
		$this->Cell(10, 6, "Total TVA");
		$this->SetXY($r1 + 10, $y1 + 10);
		$this->Cell(10, 6, "Total TTC");
		$this->SetXY($r1 + 10, $y1 + 15);
		$this->Cell(10, 6, "Acompte");
		$this->SetXY($r1 + 10, $y1 + 20);
		$this->Cell(10, 6, "Reste D�");

		$this->SetXY($r1 + 6, $y1 + 20);
		$this->Line($r1, $y1 + 5, $r2, $y1 + 5);  // horizontale avant total tva
		$this->Line($r1, $y1 + 10, $r2, $y1 + 10);  // horizontale avant total ttc
		$this->Line($r1, $y1 + 15, $r2, $y1 + 15);
		$this->Line($r1, $y1 + 20, $r2, $y1 + 20);
	}

	// trace le cadre des Totaux
	function fillCadreTotaux($totalht, $totaltva, $totalttc)
	{
		$this->SetFont("Arial", "B", 8);
		$r1  = 165;
		$r2  = $r1 + 70;
		$y1  = $this->h - 78;
		$y2  = $y1 + 10;

		$this->SetXY($r1 + 15, $y1);
		$this->Cell(10, 6, number_format($totalht, 2, '.', '') . " �", 0, 0, 'R');
		$this->SetXY($r1 + 15, $y1 + 5);
		$this->Cell(10, 6, number_format($totaltva, 2, '.', '') . " �", 0, 0, 'R');
		$this->SetXY($r1 + 15, $y1 + 10);
		$this->Cell(10, 6, number_format($totalttc, 2, '.', '') . " �", 0, 0, 'R');
		$this->SetXY($r1 + 6, $y1 + 20);
	}

	// trace le cadre des Totaux
	function fillCadreTotauxAcompte($totalht, $totaltva, $totalttc, $reglement, $reste)
	{
		$this->SetFont("Arial", "B", 8);
		$r1  = 165;
		$r2  = $r1 + 70;
		$y1  = $this->h - 78;
		$y2  = $y1 + 10;

		$this->SetXY($r1 + 15, $y1);
		$this->Cell(10, 6, number_format($totalht, 2, '.', '') . " �", 0, 0, 'R');
		$this->SetXY($r1 + 15, $y1 + 5);
		$this->Cell(10, 6, number_format($totaltva, 2, '.', '') . " �", 0, 0, 'R');
		$this->SetXY($r1 + 15, $y1 + 10);
		$this->Cell(10, 6, number_format($totalttc, 2, '.', '') . " �", 0, 0, 'R');
		$this->SetXY($r1 + 15, $y1 + 15);
		$this->Cell(10, 6, number_format($reglement, 2, '.', '') . " �", 0, 0, 'R');
		$this->SetXY($r1 + 15, $y1 + 20);
		$this->Cell(10, 6, number_format($reste, 2, '.', '') . " �", 0, 0, 'R');
		$this->SetXY($r1 + 6, $y1 + 25);
	}



	// trace le cadre des TVA
	function addCadreBanque()
	{
		$this->SetFont("Arial", "", 8);
		$r1  = 10;
		$r2  = $this->w - 10;
		$y1  = $this->h - 47;
		$y2  = $y1 + 12;

		$this->SetFillColor(255);
		$this->Rect($r1, $y1, ($r2 - $r1), ($y2 - $y1), "F");
		$this->SetFillColor(230);
		$this->Rect($r1, $y1, ($r2 - $r1), 3, "F");
		$this->Line($r1, $y1, $r2, $y1);  // horizontale
		$this->SetFillColor(230);
		$this->Rect($r1, $y1 + 9, ($r2 - $r1), 3, "F");
		$this->Line($r1, $y2, $r2, $y2);  // horizontale

		$length = $this->GetStringWidth("R�f�rences Bancaires");
		$xref  = ($this->w - $length) / 2;
		$this->SetXY($xref, $y1 - 1);
		$this->SetFont("Arial", "B", 6);
		$this->Cell($length, 5, "R�f�rences Bancaires");
		$this->SetFont("Arial", "", 8);

		$this->SetFont("Arial", "", 6);
		$r1  = 10;
		$y1  = $this->h - 46;

		$this->SetXY($r1 + 7, $y1 + 2);
		$this->Cell(10, 3, "Cde. Banque");
		$this->SetXY($r1 + 32, $y1 + 2);
		$this->Cell(10, 3, "Cde. Guichet");
		$this->SetXY($r1 + 59, $y1 + 2);
		$this->Cell(10, 3, "N� Compte");
		$this->SetXY($r1 + 90, $y1 + 2);
		$this->Cell(10, 3, "Cl�");
		$this->SetXY($r1 + 135, $y1 + 2);
		$this->Cell(10, 3, "IBAN");
		$this->SetXY($r1 + 172, $y1 + 2);
		$this->Cell(10, 3, "SWIFT");
		$this->SetFont("Arial", "", 8);
	}

	// trace le cadre des TVA
	function fillCadreBanque($codebanque, $codeguichet, $numcompte, $cle, $iban, $swift)
	{
		$this->SetFont("Arial", "", 6);
		$r1  = 10;
		$y1  = $this->h - 43;

		$this->SetXY($r1 + 10, $y1 + 2);
		$this->Cell(10, 3, $codebanque);
		$this->SetXY($r1 + 35, $y1 + 2);
		$this->Cell(10, 3, $codeguichet);
		$this->SetXY($r1 + 60, $y1 + 2);
		$this->Cell(10, 3, $numcompte);
		$this->SetXY($r1 + 90, $y1 + 2);
		$this->Cell(10, 3, $cle);
		$this->SetXY($r1 + 120, $y1 + 2);
		$this->Cell(10, 3, $iban);
		$this->SetXY($r1 + 170, $y1 + 2);
		$this->Cell(10, 3, $swift);
		$this->SetFont("Arial", "", 8);
	}




	// Ajoute lignes SOCIETE (tout en bas)
	function addCompany($societe, $adresse, $tva, $contact)
	{
		$ysous = 34;
		$length = $this->GetStringWidth($societe);
		$r1  = ($this->w - $length) / 2;
		$y1  = $this->h - $ysous;
		$this->SetXY($r1, $y1);
		$this->SetFont("Arial", "B", 6);
		$this->SetTextColor(255, 0, 0);
		$this->Cell($length, 4, utf8_decode($societe));
		$this->SetTextColor(0, 0, 0);
		$this->SetFont("Arial", "", 6);
		$length = $this->GetStringWidth($adresse);
		$r1  = ($this->w - $length) / 2;
		$y1  = $this->h - $ysous + 3;
		$this->SetXY($r1, $y1);
		$this->Cell($length, 4, utf8_decode($adresse));
		$length = $this->GetStringWidth($tva);
		$r1  = ($this->w - $length) / 2;
		$y1  = $this->h - $ysous + 6;
		$this->SetXY($r1, $y1);
		$this->Cell($length, 4, utf8_decode($tva));
		$length = $this->GetStringWidth($contact);
		$r1  = ($this->w - $length) / 2;
		$y1  = $this->h - $ysous + 9;
		$this->SetTextColor(0, 0, 0);
		$this->SetXY($r1, $y1);
		$this->Cell($length, 4, utf8_decode($contact));
	}


	// trace le cadre des totaux
	function addCadreEurosFrancs()
	{
		$r1  = $this->w - 70;
		$r2  = $r1 + 60;
		$y1  = $this->h - 40;
		$y2  = $y1 + 20;
		$this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2 - $y1), 2.5, 'D');
		$this->Line($r1 + 20,  $y1, $r1 + 20, $y2); // avant EUROS
		$this->Line($r1 + 20, $y1 + 4, $r2, $y1 + 4); // Sous Euros & Francs
		$this->Line($r1 + 38,  $y1, $r1 + 38, $y2); // Entre Euros & Francs
		$this->SetFont("Arial", "B", 8);
		$this->SetXY($r1 + 22, $y1);
		$this->Cell(15, 4, "EUROS", 0, 0, "C");
		$this->SetFont("Arial", "", 8);
		$this->SetXY($r1 + 42, $y1);
		$this->Cell(15, 4, "FRANCS", 0, 0, "C");
		$this->SetFont("Arial", "B", 6);
		$this->SetXY($r1, $y1 + 5);
		$this->Cell(20, 4, "TOTAL TTC", 0, 0, "C");
		$this->SetXY($r1, $y1 + 10);
		$this->Cell(20, 4, "ACOMPTE", 0, 0, "C");
		$this->SetXY($r1, $y1 + 15);
		$this->Cell(20, 4, "NET A PAYER", 0, 0, "C");
	}

	// remplit les cadres TVA / Totaux et la remarque
	// params  = array( "RemiseGlobale" => [0|1],
	//                      "remise_tva"     => [1|2...],  // {la remise s'applique sur ce code TVA}
	//                      "remise"         => value,     // {montant de la remise}
	//                      "remise_percent" => percent,   // {pourcentage de remise sur ce montant de TVA}
	//                  "FraisPort"     => [0|1],
	//                      "portTTC"        => value,     // montant des frais de ports TTC
	//                                                     // par defaut la TVA = 19.6 %
	//                      "portHT"         => value,     // montant des frais de ports HT
	//                      "portTVA"        => tva_value, // valeur de la TVA a appliquer sur le montant HT
	//                  "AccompteExige" => [0|1],
	//                      "accompte"         => value    // montant de l'acompte (TTC)
	//                      "accompte_percent" => percent  // pourcentage d'acompte (TTC)
	//                  "Remarque" => "texte"              // texte
	// tab_tva = array( "1"       => 19.6,
	//                  "2"       => 5.5, ... );
	// invoice = array( "px_unit" => value,
	//                  "qte"     => qte,
	//                  "tva"     => code_tva );
	function addTVAs($params, $tab_tva, $invoice)
	{
		$this->SetFont('Arial', '', 8);

		reset($invoice);
		$px = array();
		while (list($k, $prod) = each($invoice)) {
			$tva = $prod["tva"];
			@$px[$tva] += $prod["qte"] * $prod["px_unit"];
		}

		$prix     = array();
		$totalHT  = 0;
		$totalTTC = 0;
		$totalTVA = 0;
		$y = 261;
		reset($px);
		natsort($px);
		while (list($code_tva, $articleHT) = each($px)) {
			$tva = $tab_tva[$code_tva];
			$this->SetXY(17, $y);
			$this->Cell(19, 4, sprintf("%0.2F", $articleHT), '', '', 'R');
			if ($params["RemiseGlobale"] == 1) {
				if ($params["remise_tva"] == $code_tva) {
					$this->SetXY(37.5, $y);
					if ($params["remise"] > 0) {
						if (is_int($params["remise"]))
							$l_remise = $param["remise"];
						else
							$l_remise = sprintf("%0.2F", $params["remise"]);
						$this->Cell(14.5, 4, $l_remise, '', '', 'R');
						$articleHT -= $params["remise"];
					} else if ($params["remise_percent"] > 0) {
						$rp = $params["remise_percent"];
						if ($rp > 1)
							$rp /= 100;
						$rabais = $articleHT * $rp;
						$articleHT -= $rabais;
						if (is_int($rabais))
							$l_remise = $rabais;
						else
							$l_remise = sprintf("%0.2F", $rabais);
						$this->Cell(14.5, 4, $l_remise, '', '', 'R');
					} else
						$this->Cell(14.5, 4, "ErrorRem", '', '', 'R');
				}
			}
			$totalHT += $articleHT;
			$totalTTC += $articleHT * (1 + $tva / 100);
			$tmp_tva = $articleHT * $tva / 100;
			$a_tva[$code_tva] = $tmp_tva;
			$totalTVA += $tmp_tva;
			$this->SetXY(11, $y);
			$this->Cell(5, 4, $code_tva);
			$this->SetXY(53, $y);
			$this->Cell(19, 4, sprintf("%0.2F", $tmp_tva), '', '', 'R');
			$this->SetXY(74, $y);
			$this->Cell(10, 4, sprintf("%0.2F", $tva), '', '', 'R');
			$y += 4;
		}

		if ($params["FraisPort"] == 1) {
			if ($params["portTTC"] > 0) {
				$pTTC = sprintf("%0.2F", $params["portTTC"]);
				$pHT  = sprintf("%0.2F", $pTTC / 1.196);
				$pTVA = sprintf("%0.2F", $pHT * 0.196);
				$this->SetFont('Arial', '', 6);
				$this->SetXY(85, 261);
				$this->Cell(6, 4, "HT : ", '', '', '');
				$this->SetXY(92, 261);
				$this->Cell(9, 4, $pHT, '', '', 'R');
				$this->SetXY(85, 265);
				$this->Cell(6, 4, "TVA : ", '', '', '');
				$this->SetXY(92, 265);
				$this->Cell(9, 4, $pTVA, '', '', 'R');
				$this->SetXY(85, 269);
				$this->Cell(6, 4, "TTC : ", '', '', '');
				$this->SetXY(92, 269);
				$this->Cell(9, 4, $pTTC, '', '', 'R');
				$this->SetFont('Arial', '', 8);
				$totalHT += $pHT;
				$totalTVA += $pTVA;
				$totalTTC += $pTTC;
			} else if ($params["portHT"] > 0) {
				$pHT  = sprintf("%0.2F", $params["portHT"]);
				$pTVA = sprintf("%0.2F", $params["portTVA"] * $pHT / 100);
				$pTTC = sprintf("%0.2F", $pHT + $pTVA);
				$this->SetFont('Arial', '', 6);
				$this->SetXY(85, 261);
				$this->Cell(6, 4, "HT : ", '', '', '');
				$this->SetXY(92, 261);
				$this->Cell(9, 4, $pHT, '', '', 'R');
				$this->SetXY(85, 265);
				$this->Cell(6, 4, "TVA : ", '', '', '');
				$this->SetXY(92, 265);
				$this->Cell(9, 4, $pTVA, '', '', 'R');
				$this->SetXY(85, 269);
				$this->Cell(6, 4, "TTC : ", '', '', '');
				$this->SetXY(92, 269);
				$this->Cell(9, 4, $pTTC, '', '', 'R');
				$this->SetFont('Arial', '', 8);
				$totalHT += $pHT;
				$totalTVA += $pTVA;
				$totalTTC += $pTTC;
			}
		}

		$this->SetXY(114, 266.4);
		$this->Cell(15, 4, sprintf("%0.2F", $totalHT), '', '', 'R');
		$this->SetXY(114, 271.4);
		$this->Cell(15, 4, sprintf("%0.2F", $totalTVA), '', '', 'R');

		$params["totalHT"] = $totalHT;
		$params["TVA"] = $totalTVA;
		$accompteTTC = 0;
		if ($params["AccompteExige"] == 1) {
			if ($params["accompte"] > 0) {
				$accompteTTC = sprintf("%.2F", $params["accompte"]);
				if (strlen($params["Remarque"]) == 0)
					$this->addRemarque("Accompte de $accompteTTC Euros exig� � la commande.");
				else
					$this->addRemarque($params["Remarque"]);
			} else if ($params["accompte_percent"] > 0) {
				$percent = $params["accompte_percent"];
				if ($percent > 1)
					$percent /= 100;
				$accompteTTC = sprintf("%.2F", $totalTTC * $percent);
				$percent100 = $percent * 100;
				if (strlen($params["Remarque"]) == 0)
					$this->addRemarque("Accompte de $percent100 % (soit $accompteTTC Euros) exig� � la commande.");
				else
					$this->addRemarque($params["Remarque"]);
			} else
				$this->addRemarque("Dr�le d'acompte !!! " . $params["Remarque"]);
		} else {
			if (strlen($params["Remarque"]) > 0)
				$this->addRemarque($params["Remarque"]);
		}
		$re  = $this->w - 50;
		$rf  = $this->w - 29;
		$y1  = $this->h - 40;
		$this->SetFont("Arial", "", 8);
		$this->SetXY($re, $y1 + 5);
		$this->Cell(17, 4, sprintf("%0.2F", $totalTTC), '', '', 'R');
		$this->SetXY($re, $y1 + 10);
		$this->Cell(17, 4, sprintf("%0.2F", $accompteTTC), '', '', 'R');
		$this->SetXY($re, $y1 + 14.8);
		$this->Cell(17, 4, sprintf("%0.2F", $totalTTC - $accompteTTC), '', '', 'R');
		$this->SetXY($rf, $y1 + 5);
		$this->Cell(17, 4, sprintf("%0.2F", $totalTTC * EURO_VAL), '', '', 'R');
		$this->SetXY($rf, $y1 + 10);
		$this->Cell(17, 4, sprintf("%0.2F", $accompteTTC * EURO_VAL), '', '', 'R');
		$this->SetXY($rf, $y1 + 14.8);
		$this->Cell(17, 4, sprintf("%0.2F", ($totalTTC - $accompteTTC) * EURO_VAL), '', '', 'R');
	}

	// Permet de rajouter un commentaire (Devis temporaire, REGLE, DUPLICATA, ...)
	// en sous-impression
	// ATTENTION: APPELER CETTE FONCTION EN PREMIER
	function temporaire($texte)
	{
		$this->SetFont('Arial', 'B', 50);
		$this->SetTextColor(203, 203, 203);
		$this->Rotate(45, 55, 190);
		$this->Text(55, 190, $texte);
		$this->Rotate(0);
		$this->SetTextColor(0, 0, 0);
	}





	// Affiche le logo
	// (en haut, à gauche)
	function addLogo($logo)
	{
		$x1 = $this->GetX();
		// $y = $this->GetY();
		$this->Image(DIR_FS_CATALOG . 'pdf/images/' . $logo, 23, $y1 + 9, 0, 21);
	}

	function addTitre($titre)
	{
		$this->SetAutoPageBreak(true, 1);
		$ysous = 35;
		$length = $this->GetStringWidth($titre);
		$r1  = ($this->w - $length) / 2 - 25;
		// $y1  = $this->GetY();	
		$this->SetFillColor(63, 95, 170);
		$this->Rect(21, $y1 + 7, 168, 25, "F");
		$this->SetXY($r1, $y);
		$this->SetFont("Arial", "B", 15);
		$this->SetFont('', 'I');
		$this->SetTextColor(255);
		$this->Cell($length, 4, utf8_decode($titre));
	}

	function add_titre_ah($titre)
	{
		$this->SetAutoPageBreak(true, 1);
		$this->Rect(15, 10, 175, 10);
		$this->SetFont("Times", "B", 10);
		$this->SetTextColor(0);
		$this->Cell(0, 4.5, utf8_decode($titre), 0, 1, 'C');
	}

	function case_a_cocher($x1, $y1, $x2, $y2)
	{
		$this->Line($x1, $y1, $x2, $y2);
		$this->Line($x1 + 4, $y1, $x2 - 4, $y2);
	}
	function petite_case_a_cocher($x1, $y1, $x2, $y2)
	{
		$this->Line($x1, $y1, $x2, $y2);
		$this->Line($x1 + 2, $y1, $x2 - 2, $y2);
	}

	function Footer()
	{
		// Positionnement à 1,5 cm du bas
		$this->SetY(-15);
		// Police Arial italique 8
		$this->SetFont('Times', 'I', 8);
		// Numéro de page centré
		$this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
	}

	function addSTitre($titre)
	{
		$y = $this->GetY() + 10;
		$length = $this->GetStringWidth($titre);
		$this->SetFillColor(240);
		$this->SetDrawColor(255);
		$this->Rect(10, $y, 190, 5, "DF");
		$this->SetXY(12, $y + 1);
		$this->SetFont("Arial", "B", 11);
		$this->SetTextColor(0, 0, 0);
		$this->Cell($length, 4, utf8_decode($titre));
	}

	function addText($titre, $valeur)
	{
		$y = $this->GetY() + 5;
		$this->SetXY(12, $y);
		$this->SetFont("Arial", "B", 8);
		$this->SetTextColor(0, 0, 0);
		$this->Cell($length, 4, utf8_decode($titre));
		$this->SetXY(62, $y);
		$this->SetFont("Arial", "", 8);
		$this->SetTextColor(0, 0, 0);
		$this->Cell($length, 4, utf8_decode($valeur));
	}


	function addLigne_montant($titre, $valeur)
	{
		$y = $this->GetY() + 5;
		$this->SetX(120);
		$this->SetFillColor(55, 95, 166);
		$this->SetFont("Arial", "B", 7);
		$this->SetTextColor(255);
		$this->Cell(50, 8, $titre, 1, 0, L, true);
		$this->SetTextColor(0);
		$this->SetFont("Arial", "", 7);
		$this->Cell(20, 8, $valeur . " " . chr(128), 1, 1, L, false);
	}

	function addLigne_montantB($titre, $valeur)
	{
		$y = $this->GetY() + 5;
		$this->SetX(120);
		$this->SetFillColor(55, 95, 166);
		$this->SetFont("Arial", "B", 7);
		$this->SetTextColor(255);
		$this->Cell(50, 8, $titre, 1, 0, L, true);
		$this->SetTextColor(0);
		$this->Cell(20, 8, $valeur . " " . chr(128), 1, 1, L, false);
	}



	function addTextSimple($titre)
	{
		$y = $this->GetY() + 5;
		$this->SetXY(12, $y);
		$this->SetFont("Arial", "", 8);
		$this->SetTextColor(0, 0, 0);
		$this->Cell($length, 4, utf8_decode($titre));
	}

	function addTextM($titre, $valeur)
	{
		$y = $this->GetY() + 5;
		$this->SetXY(90, $y);
		$this->SetFont("Arial", "B", 8);
		$this->SetTextColor(0, 0, 0);
		$this->Cell($length, 4, utf8_decode($titre));
		$this->SetXY(140, $y);
		$this->SetFont("Arial", "", 8);
		$this->SetTextColor(0, 0, 0);
		$this->Cell($length, 4, utf8_decode($valeur));
	}

	function addTextMc($titre)
	{
		$y = $this->GetY() + 5;
		$this->SetXY(45, $y);
		$this->SetFont("Arial", "B", 8);
		$this->SetTextColor(0, 0, 0);
		$this->Cell($length, 4, utf8_decode($titre));
	}

	function addTextCadre($titre)
	{
		$y = $this->GetY() + 5;
		$this->SetXY(120, $y);
		$this->SetFont("Arial", "", 9);
		$this->SetTextColor(0, 0, 0);
		$this->Cell($length, 4, utf8_decode($titre));
		$this->Ln(2);
	}

	function addTextCadreB($titre)
	{
		$y = $this->GetY() + 5;
		$this->SetXY(120, $y);
		$this->SetFont("Arial", "B", 9);
		$this->SetTextColor(0, 0, 0);
		$this->MultiCell(50, 3, utf8_decode($titre));
		$this->Ln(2);
	}

	function addTextSouligne($titre)
	{
		$y = $this->GetY() + 5;
		$this->SetXY(12, $y);
		$this->SetFont("Arial", "U", 8);
		$this->SetTextColor(0, 0, 0);
		$this->Cell($length, 4, utf8_decode($titre));
	}

	function addSText($titre)
	{
		$y = $this->GetY() + 3;
		$this->SetXY(12, $y);
		$this->SetFont("Arial", "I", 7);
		$this->SetTextColor(0, 0, 0);
		$this->MultiCell($length, 4, utf8_decode($titre));
	}

	function addTexte($texte, $prenom, $nom, $adresse, $email, $telephone)
	{
		$length = $this->GetStringWidth($texte);
		$r1  = 10;
		$y1  = 40;
		$this->SetXY($r1, $y1);
		$this->SetFont("Arial", "B", 9);
		$this->SetTextColor(0, 0, 0);
		$this->Cell($length, 4, utf8_decode($texte));
		$y1  = $y1 + 4;
		$this->SetXY($r1, $y1);
		$this->Cell($length, 4, "ET : ");
		$y1  = $y1 + 4;
		$this->SetXY($r1, $y1);
		$this->Cell($length, 4, "Nom : " . utf8_decode($prenom));
		$y1  = $y1 + 4;
		$this->SetXY($r1, $y1);
		$this->Cell($length, 4, "Nom : " . utf8_decode($nom));
		$y1  = $y1 + 4;
		$this->SetXY($r1, $y1);
		$this->Cell($length, 4, "Adresse : " . utf8_decode($adresse));
		$y1  = $y1 + 4;
		$this->SetXY($r1, $y1);
		$this->Cell($length, 4, "Email : " . utf8_decode($email));
		$y1  = $y1 + 4;
		$this->SetXY($r1, $y1);
		$this->Cell($length, 4, "T�l�phone : " . utf8_decode($telephone));
	}

	function addTexte2($ligne1, $ligne2, $ligne3, $ligne4, $ligne4b, $ligne5, $ligne6)
	{
		$length = $this->GetStringWidth($ligne1);
		$r1  = 10;
		$y1  = 70;
		$this->SetXY($r1, $y1);
		$this->SetFont("Arial", "", 8);
		$this->SetTextColor(0, 0, 0);
		$this->Cell($length, 4, utf8_decode($ligne1));
		$y1  = $y1 + 8;
		$this->SetXY($r1, $y1);
		$this->Cell($length, 4, utf8_decode($ligne2));
		$y1  = $y1 + 4;
		$this->SetXY($r1, $y1);
		$this->Cell($length, 4, utf8_decode($ligne3));
		$y1  = $y1 + 4;
		$this->SetXY($r1, $y1);
		$this->Cell($length, 4, utf8_decode($ligne4));
		$y1  = $y1 + 4;
		$this->SetXY($r1, $y1);
		$this->Cell($length, 4, utf8_decode($ligne4b));
		$y1  = $y1 + 8;
		$this->SetXY($r1, $y1);
		$this->Cell($length, 4, utf8_decode($ligne5));
		$y1  = $y1 + 8;
		$this->SetXY($r1, $y1);
		$this->Cell($length, 4, utf8_decode($ligne6));
	}

	function addTexteCli($ligne1, $ligne1b, $ligne2, $ligne2b, $ligne3, $ligne3b, $ligne4, $ligne4b)
	{
		$length = 0;
		$hauteur = 2;
		$r1  = 10;
		$y1  = 80;
		$this->SetXY($r1, $y1);
		$this->SetFont("Arial", "B", 8);
		$this->SetTextColor(0, 0, 0);
		$this->Cell($length, $hauteur, utf8_decode($ligne1));
		$this->SetFont("Arial", "", 8);
		$y1 = $this->GetY() + 6;
		$this->SetXY($r1, $y1);
		$this->MultiCell($length, $hauteur, utf8_decode($ligne1b));

		$y1 = $this->GetY() + 10;
		$this->SetXY($r1, $y1);
		$this->SetFont("Arial", "B", 8);
		$this->Cell($length, $hauteur, utf8_decode($ligne2));
		$this->SetFont("Arial", "", 8);
		$y1 = $this->GetY() + 6;
		$this->SetXY($r1, $y1);
		$this->MultiCell($length, $hauteur, utf8_decode($ligne2b));

		$y1 = $this->GetY() + 6;
		$this->SetXY($r1, $y1);
		$this->SetFont("Arial", "B", 8);
		$this->Cell($length, $hauteur, utf8_decode($ligne3));
		$this->SetFont("Arial", "", 8);
		$y1 = $this->GetY() + 6;
		$this->SetXY($r1, $y1);
		$this->MultiCell($length, $hauteur, utf8_decode($ligne3b));

		$y1 = $this->GetY() + 6;
		$this->SetXY($r1, $y1);
		$this->SetFont("Arial", "B", 8);
		$this->Cell($length, $hauteur, utf8_decode($ligne4));
		$this->SetFont("Arial", "", 8);
		$y1 = $this->GetY() + 6;
		$this->SetXY($r1, $y1);
		$this->MultiCell($length, $hauteur, utf8_decode($ligne4b));
	}

	function addTexte3($footer1, $footer2, $footer3, $position_y)
	{
		$length = $this->GetStringWidth($footer1);
		$r1  = 10;
		$y1  = $position_y;
		$this->SetXY($r1, $y1);
		$this->SetFont("Arial", "", 8);
		$this->SetTextColor(0, 0, 0);
		$this->Cell($length, 4, utf8_decode($footer1));
		$y1  = $y1 + 8;
		$this->SetXY($r1, $y1);
		$this->Cell($length, 4, utf8_decode($footer2));
		$r1  = $r1 + 120;
		$this->SetXY($r1, $y1);
		$this->Cell($length, 4, utf8_decode($footer3));
	}



	// *************************************** CREATION FONCTIONS BERNARD ***************************************


	function addTextMPE($valeur)
	{
		$y = $this->GetY() + 5;
		$this->SetXY(24, $y);
		$this->SetFont("Arial", "", 7);
		$this->SetTextColor(0, 0, 0);
		$this->Cell($length, 4, utf8_decode($valeur));
		$this->Ln(-1.5);
	}

	function MPEPageBas($valeur)
	{
		$y = $this->GetY() + 5;
		$this->SetXY(20, $y);
		$this->SetFont("Arial", "", 8);
		$this->SetTextColor(0, 0, 0);
		$this->Cell($length, 4, utf8_decode($valeur), 0, 0, C);
		$this->Ln(-1.5);
	}

	function text_header($text123)
	{
		$this->SetXY(12, 10);
		$this->SetFont("Arial", "B", 7);
	}

	function addTextCadreFactP($titre)
	{
		$y = $this->GetY() + 5;
		$this->SetXY(110, $y);
		$this->SetFont("Arial", "", 9);
		$this->SetTextColor(0, 0, 0);
		$this->Cell($length, 4, utf8_decode($titre));
		$this->Ln(1);
	}

	function addTextCadreFactPB($titre)
	{
		$y = $this->GetY() + 5;
		$this->SetXY(110, $y);
		$this->SetFont("Arial", "B", 9);
		$this->SetTextColor(0, 0, 0);
		$this->MultiCell(60, 4, utf8_decode($titre));
		$this->Ln(1);
	}
}
