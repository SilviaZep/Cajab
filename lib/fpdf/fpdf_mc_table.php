<?php
include('fpdf.php');

class FPDF_MC_Table extends FPDF{
	var $widths;
	var $aligns;
	var $borderPosition;
	var $header='';
	var $footer='';
	var $angle=0;

	function SetWidths($w){
		//Set the array of column widths
		$this->widths=$w;
	}

	function SetAligns($a){
		//Set the array of column alignments
		$this->aligns=$a;
	}
	
	function SetBorderPosition($b){
		//Set the array of column alignments
		$this->borderPosition=$b;
	}
	
	function SetHeader($he){
		//Set the array of header attributes
		$this->header=$he;
	}
	
	function SetFooter($fo){
		//Set the array of footer attributes
		$this->footer=$fo;
	}
	
	function Row($data){
		//Calculate the height of the row
		$nb=0;
		for($i=0;$i<count($data);$i++)
			$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
			$h=5*$nb;
			//Issue a page break first if needed
			$this->CheckPageBreak($h);
			//Draw the cells of the row
			for($i=0;$i<count($data);$i++){
				$w=$this->widths[$i];
				$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
				//Save the current position
				$x=$this->GetX();
				$y=$this->GetY();
				//Draw the border
				$this->Rect($x,$y,$w,$h);
				//Print the text
				$this->MultiCell($w,5,$data[$i],0,$a);
				//Put the position to the right of the cell
				$this->SetXY($x+$w,$y);
			}
			//Go to the next line
			$this->Ln($h);
	}

	function CheckPageBreak($h){
		//If the height h would cause an overflow, add a new page immediately
		if($this->GetY()+$h>$this->PageBreakTrigger)
			$this->AddPage($this->CurOrientation);
	}

	function NbLines($w,$txt)
	{
		//Computes the number of lines a MultiCell of width w will take
		$cw=&$this->CurrentFont['cw'];
		if($w==0)
			$w=$this->w-$this->rMargin-$this->x;
			$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
			$s=str_replace("\r",'',$txt);
			$nb=strlen($s);
			if($nb>0 and $s[$nb-1]=="\n")
				$nb--;
				$sep=-1;
				$i=0;
				$j=0;
				$l=0;
				$nl=1;
				while($i<$nb)
				{
					$c=$s[$i];
					if($c=="\n")
					{
						$i++;
						$sep=-1;
						$j=$i;
						$l=0;
						$nl++;
						continue;
					}
					if($c==' ')
						$sep=$i;
						$l+=$cw[$c];
						if($l>$wmax)
						{
							if($sep==-1)
							{
								if($i==$j)
									$i++;
							}
							else
								$i=$sep+1;
								$sep=-1;
								$j=$i;
								$l=0;
								$nl++;
						}
						else
							$i++;
				}
				return $nl;
	}
	
	
	/*
	 * name= RowNoVerticalBorder
	 * description= It's a modification from the Row function that allows to add a row with no vertical borders by default, also it's possible to define a cell with custom background and text color
	 * only passing the array('color'=><rgb>, 'fill'=><rgb>) and the index of the target column.
	 * if no index defined the default target column is the last from the row.
	 * We can add a row with 'mixed' border type cells too.
	 * $data= info to be displayed in the row
	 * $attr= array with background and text color attributes
	 * $targetColumnFill= index of the target column
	 * $bordersArray= array with indexes and border type for each cell 
	 * */
	
	function RowNoVerticalBorder($data, $attr=array(), $targetColumnFill="", $bordersArray=array()) {
		
		// Calculate the height of the row
		$nb = 0;
		for($i = 0; $i < count ( $data ); $i ++)
			$nb = max ( $nb, $this->NbLines ( $this->widths [$i], $data [$i] ) );
			$h = 5 * $nb;
			// Issue a page break first if needed
			$this->CheckPageBreak ( $h );
			// Draw the cells of the row
			for($i = 0; $i < count ( $data ); $i ++) {
				$w = $this->widths [$i];
				$a = isset ( $this->aligns [$i] ) ? $this->aligns [$i] : 'C';
				$b = isset ( $this->borderPosition ) ? $this->borderPosition : 'T';
				
				if(sizeof($bordersArray)>0 && isset($bordersArray[$i])){
					$b=$bordersArray[$i];
				}
				
				$showFill=false;
				
				$this->SetFillColor ( 255, 255, 255 );
				
				if(($targetColumnFill!="" && $i==$targetColumnFill) || ($i==sizeof($data)-1 && sizeof($attr)>0 && $targetColumnFill=="")){					
					$this->SetTextColor ( $attr['color']['r'], $attr['color']['g'], $attr['color']['b']);
					$this->SetFillColor ( $attr['fill']['r'], $attr['fill']['g'], $attr['fill']['b']);
					$showFill=true;				
				}
				if($targetColumnFill!="" && $i==sizeof($data)-1){
					$this->SetTextColor ( 88, 89, 91);
				}
				
				// Save the current position
				$x = $this->GetX ();
				$y = $this->GetY ();
				// Draw the border				
				$this->Rect ( $x, $y, $w, $h, 'F');
				
				$this->MultiCell ( $w, 5, $data [$i], $b, $a, $showFill );
				
				// Put the position to the right of the cell
				$this->SetXY ( $x + $w, $y );
			}
			// Go to the next line
			$this->Ln ( $h );
	}

	function RowHeader($data) {
		// Calculate the height of the row
		$nb = 0;
		for($i = 0; $i < count ( $data ); $i ++)
			$nb = max ( $nb, $this->NbLines ( $this->widths [$i], $data [$i] ) );
			$h = 5 * $nb;
			// Issue a page break first if needed
			$this->CheckPageBreak ( $h );
			// Draw the cells of the row
			for($i = 0; $i < count ( $data ); $i ++) {
				$w = $this->widths [$i];
				$a = isset ( $this->aligns [$i] ) ? $this->aligns [$i] : 'C';
				// Save the current position
				$x = $this->GetX ();
				$y = $this->GetY ();
				// Draw the border
				$this->Rect ( $x, $y, $w, $h );
				// Print the text
				$this->AddFont('AvenirNextRegular','', 'AvenirNextRegular.php');
				$this->SetFont ( 'AvenirNextRegular', '', 12 );
				$this->SetTextColor ( 255, 255, 255 );
				$this->SetFillColor ( 136, 138, 140 );
				$this->MultiCell ( $w, 5, $data [$i], 'B', $a, 1 );
				// Put the position to the right of the cell
				$this->SetXY ( $x + $w, $y );
			}
			// Go to the next line
			$this->Ln ( $h );
	}
	
	function Rotate($angle,$x=-1,$y=-1){
		if($x==-1)$x=$this->x;
		if($y==-1)$y=$this->y;
		if($this->angle!=0)$this->_out('Q');
		$this->angle=$angle;
		if($angle!=0){
			$angle*=M_PI/180;
			$c=cos($angle);
			$s=sin($angle);
			$cx=$x*$this->k;
			$cy=($this->h-$y)*$this->k;
			$this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
		}
	}
	
	function _endpage(){
		if($this->angle!=0){
			$this->angle=0;
			$this->_out('Q');
		}
		parent::_endpage();
	}
		
	function Header(){
		if($this->header!=''){
			// Logo
			if(isset($this->header['logo'])){
				$x=!isset($this->header['logo']['x'])?10:$this->header['logo']['x'];
				$y=!isset($this->header['logo']['y'])?6:$this->header['logo']['y'];
				$width=!isset($this->header['logo']['width'])?40:$this->header['logo']['width'];
				$height=!isset($this->header['logo']['height'])?20:$this->header['logo']['height'];
				$this->Image($this->header['logo']['image'],$x,$y,$width, $height);
			}
			
			//Title
			if(isset($this->header['text'])){
				$x=!isset($this->header['text']['x'])?30:$this->header['text']['x'];
				$y=!isset($this->header['text']['y'])?10:$this->header['text']['y'];
				$a=!isset($this->header['text']['alignment'])?'C':$this->header['text']['alignment'];
				$b=!isset($this->header['border'])?0:$this->header['border'];
				$font=!isset($this->header['text']['font_name'])?'Arial':$this->header['text']['font_name'];
				$size=!isset($this->header['text']['font_size'])?10:$this->header['text']['font_size'];
				$style=!isset($this->header['text']['font_style'])?'B':$this->header['text']['font_style'];
				
				$this->SetFont($font,$style,$size);
				// Title
				$this->Cell($x,$y,$this->header['text']['title'],$b,0,$a);
			}

			// Line break
			if(isset($this->header['ln'])){
				$this->Ln($this->header['ln']);
			}
		}
	}
	
	function Footer(){
		if($this->footer!=''){
			$font=!isset($this->footer['text']['font_name'])?'Arial':$this->footer['text']['font_name'];
			$size=!isset($this->footer['text']['font_size'])?8:$this->footer['text']['font_size'];
			$style=!isset($this->footer['text']['font_style'])?'I':$this->footer['text']['font_style'];
			$a=!isset($this->footer['text']['alignment'])?'C':$this->footer['text']['alignment'];
			// Go to 1.5 cm from bottom
			$this->SetY(-15);
			// Select Arial italic 8
			$this->SetFont($font,$style,$size);
			// Print centered page number
			$this->Cell(0,10,'Page '.$this->PageNo(),0,0,$a);
		}
	}
	
}
?>