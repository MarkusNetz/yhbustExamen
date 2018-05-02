<?php 		
class person
{
	public $name;		
	public $height;		
	protected $social_insurance;
	private $pinn_number="My pin-code.";

	function __construct($persons_name) {
		$this->name = $persons_name;		
	}		

	protected function set_name($new_name) {
		if($new_name != "Jimmy Two Gun") {
			$this->name = strtoupper($new_name);
		}
	}	

	function get_name() {
		return $this->name;
	}
	
	private function get_pinn_number(){
		return $this->pinn_number;
	}
}


class employee extends person
{
	function __construct($employee_name){
		$this->set_name($employee_name);
	}
	
	protected function set_name($new_name){
		if($new_name == "Markus Sucks"){
			$this->name = $new_name;
		}
		else if ($new_name ==  "Johnny Fingers") {
			parent::set_name($new_name);
		} 
	}
}
?>