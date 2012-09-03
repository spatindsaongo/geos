<?php
namespace Geos\MainBundle\Lib;

class StatLib {

	private $maxValue; // Valeur maximal d'un indicateur
	private $colorCodes = array( '0'=>'#ef2929',
							    '1'=>'#fcaf3e',
								'2'=>'#fce94f',
								'3'=>'#8ae234',
								'4'=>'#729fcf',
								'5'=>'#ad7fa8',
								'6'=>'#e9b96e',
								'7'=>'#cc0000',
								'8'=>'#f57900',	);
	
	public function setMaxValue($value) {
		$this->maxValue = $value;
	}
	
	/**
	 * Retourne un code de couleur en fonction de la valeur d'un indicateur
	 * @param int $indicValue
	 */
	public function getColorCode ($indicValue) {
		
		$interval = $this->getInterval();
		
		
		foreach($this->colorCodes as $key => $value ){
			if(($indicValue >= ($key*$interval)) and ($indicValue < (($key+1)*$interval)))  
			{
				$colorCode = $value;		
			}
		} 
		
		return $colorCode;		
	}
	
	public function getLegend(){
		
		$interval = $this->getInterval();		
		
		foreach($this->colorCodes as $key => $value ){
				$legend[$key]['interval'] = 'de '.($key*$interval).' à '.(($key+1)*$interval);
				$legend[$key]['colorCode'] = $value;
		}
		
		return $legend;
		
	}
	
	private function getInterval(){
		
		$max = (int) $this->maxValue;
		
		return ceil($max/10);
	}
	
	
}
