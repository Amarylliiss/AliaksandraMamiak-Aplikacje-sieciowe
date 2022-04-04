<?php


namespace app\controllers;


use app\forms\CalcForm;
use app\transfer\CalcResult;

class CalcCtrl {

	private $form;   
	private $result; 

	
	public function __construct(){
		
		$this->form = new CalcForm();
		$this->result = new CalcResult();
	}
	
	
	public function getParams(){
		$this->form->kwota = getFromRequest('kwota');
		$this->form->okres = getFromRequest('okres');
		$this->form->procent = getFromRequest('procent');
	}
	
	
	public function validate() {
		
		if (! (isset ( $this->form->kwota) && isset ( $this->form->okres ) && isset ( $this->form->procent ))) {
			
			return false;
		}
		
		
		if ($this->form->kwota == "") {
			getMessages()->addError('Nie podano kwoty');
		}
		if ($this->form->okres == "") {
			getMessages()->addError('Nie podano okresu');
		}
		if ($this->form->procent == "") {
			getMessages()->addError('Nie podano oprocentowania');
		}
		
		if (! getMessages()->isError()) {
			
			
			if (! is_numeric ( $this->form->kwota )) {
				getMessages()->addError('Pierwsza wartość nie jest liczbą całkowitą');
			}
			
			if (! is_numeric ( $this->form->okres )) {
				getMessages()->addError('Druga wartość nie jest liczbą całkowitą');
			}
			if (! is_numeric ( $this->form->procent )) {
				getMessages()->addError('Trzecia wartość nie jest liczbą całkowitą');
			}
		}
		
		return ! getMessages()->isError();
	}
	
	
	public function process(){

		$this->getParams();
		
		if ($this->validate()) {
				
			
			$this->form->kwota = intval($this->form->kwota);
			$this->form->okres = intval($this->form->okres);
			$this->form->procent = intval($this->form->procent);
				
			$this->result->result = ((($this->form->procent/100) * $this->form->okres * $this->form->kwota) + $this->form->kwota) / ($this->form->okres * 12);
			
			getMessages()->addInfo('Wykonano obliczenia.');
		}
		
		$this->generateView();
	}
	
	
	public function generateView(){
		
		
		getSmarty()->assign('page_title','Kalkulator kredytowy');
		getSmarty()->assign('page_description','Kolejne rozszerzenia dla aplikacja z jednym "punktem wejścia". Do nowej struktury dołożono automatyczne ładowanie klas wykorzystując w strukturze przestrzenie nazw.');
		getSmarty()->assign('page_header','Kontroler główny');
					
		getSmarty()->assign('form',$this->form);
		getSmarty()->assign('res',$this->result);
		
		getSmarty()->display('CalcView.tpl'); // już nie podajemy pełnej ścieżki - foldery widoków są zdefiniowane przy ładowaniu Smarty
	}
}
