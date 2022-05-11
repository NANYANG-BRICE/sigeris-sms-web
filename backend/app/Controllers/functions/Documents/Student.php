<?php  
	require('../../FPDF/fpdf.php');



	class PDF extends FPDF
	{
		function Logo(){
			$this->Image('images/logo.png',1,5.5,3);
		}

    	//change name of function
		function HeaderOne($xCor, $yCor, $text) 
		{
			$this->SetX($xCor);
			$this->SetY($yCor);
			$this->SetFont('Arial','B',18);
			$this->Cell(5,1,$text);
		}  

    	//Add bottom border
		function BorderLine() 
		{
			$this->SetDrawColor(0,0,0);
			$this->SetFillColor(0,0,0);
			$this->Rect(1, 10, 6.5, .015, 'F');        
		}
		function Footer()
		{
        // Go to 1.5 cm from bottom
			$this->SetY(-5.7);
        // Select Arial italic 8
			$this->SetFont('Arial','I',8);
        // Print centered page number
			$this->Cell(0,10,'Page '.$this->PageNo(),0,0,'R');
		}
		function Header(){
        	// Subtitle
			$this->SetY(.25);
			$this->SetX(1);
			$this->SetFont('Arial','',12);
			$this->Cell(6,1,'INNOVATION READINESS ASSESSMENT');
        	// Line
			$this->SetDrawColor(0,0,0);
			$this->SetFillColor(0,0,0);
			$this->Rect(1, .5, 6.5, .015, 'F');       
		}
	}
?>