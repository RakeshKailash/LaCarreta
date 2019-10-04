<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * summary
 */
class Parserlib
{
	public function clearr($vals, $key)
	{
		if (!$vals || !sizeof($vals) || !$key) {
			return false;
		}

		$narr = array();

		foreach ($vals as $val) {
			array_push($narr, $val[$key]);
		}

		return $narr;
	}

	public function formatDate($data=null)
	{
		if (!$data) {
			return null;
		}

		$data = str_replace(" ", "", $data);
		$selector = "~^(\d{4})-(\d{2})-(\d{2})$~";

		if (preg_match($selector, $data)) {
			$clear = preg_replace($selector, '\3/\2/\1', $data);
			return $clear;
		}

		$clear = preg_replace("~[^\d]~", "", $data);
		$clear = preg_replace("~^(\d{4})(\d{2})(\d{2})$~", '\3/\2/\1', $clear);

		return $clear;
	}

	public function unformatDate($data=null)
	{
		if (!$data) {
			return null;
		}

		$data = str_replace(" ", "", $data);
		$selector = "~^(\d{2})/(\d{2})/(\d{4})$~";

		if (preg_match($selector, $data)) {
			$clear = preg_replace($selector, '\3-\2-\1', $data);
			return $clear;
		}

		$clear = preg_replace("~[^\d]~", "", $data);
		$clear = preg_replace("~^(\d{2})(\d{2})(\d{4})$~", '\3-\2-\1', $clear);

		return $clear;
	}

	public function formatTime($hora=null)
	{
		if (!$hora) {
			return null;
		}

		$hora = str_replace(" ", "", $hora);
		$selector = "~^(\d{2}):(\d{2}):(\d{2})$~";

		if (preg_match($selector, $hora)) {
			$clear = preg_replace($selector, '\1:\2h', $hora);
			return $clear;
		}

		$clear = preg_replace("~[^\d]~", "", $hora);
		$clear = preg_replace("~^(\d{2})(\d{2})(\d{2})$~", '\1:\2h', $clear);

		return $clear;
	}

	public function unformatTime($hora=null)
	{
		if (!$hora) {
			return null;
		}

		$hora = str_replace(" ", "", $hora);
		$selector = "~^(\d{2}):(\d{2})h$~";

		if (preg_match($selector, $hora)) {
			$clear = preg_replace($selector, '\1:\2:00', $hora);
			return $clear;
		}

		$clear = preg_replace("~[^\d]~", "", $hora);
		$clear = preg_replace("~^(\d{2})(\d{2})$~", '\1:\2:00', $clear);

		return $clear;
	}

	public function formatDatetime($data=null)
	{
		if (!$data) {
			return null;
		}

		// $data = str_replace(" ", "", $data);
		$selector = "~^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$~";

		if (preg_match($selector, $data)) {
			$clear = preg_replace($selector, '\3/\2/\1, \4:\5h', $data);
			return $clear;
		}

		$clear = preg_replace("~[^\d]~", "", $data);
		$clear = preg_replace("~^(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})$~", '\3/\2/\1, \4:\5h', $clear);

		return $clear;
	}

	public function unformatDatetime($data=null)
	{
		if (!$data) {
			return null;
		}

		// $data = str_replace(" ", "", $data);
		$selector = "~^(\d{2})/(\d{2})/(\d{4}), (\d{2}):(\d{2})h$~";

		if (preg_match($selector, $data)) {
			$clear = preg_replace($selector, '\3-\2-\1 \4:\5:00', $data);
			return $clear;
		}

		$clear = preg_replace("~[^\d]~", "", $data);
		$clear = preg_replace("~^(\d{2})(\d{2})(\d{4})(\d{2})(\d{2})$~", '\3-\2-\1 \4:\5:00', $clear);

		return $clear;
	}

	public function formatMoney($money=null)
	{
		if (!$money) {
			return null;
		}

		$money = str_replace(".", ",", $money);
		$money = str_replace(",", ".", $money);

		$money = (float) $money;
		$money = number_format($money, 2, ',', '.');
		return $money;
	}

	public function unformatMoney($money=null)
	{
		if (!$money) {
			return null;
		}

		$money = str_replace(".", "", $money);
		$money = str_replace(",", ".", $money);

		$money = (float) $money;
		$money = number_format($money, 2, '.', '');
		return $money;
	}

	public function formatDaterange($data=null, $data_2=null)
	{
		if (!$data || !$data_2) {
			return null;
		}

		$selector = "~^(\d{2}/\d{2}/\d{4}), (\d{2}:\d{2})h$~";

		$date_1 = preg_replace($selector, '\1', $data);
		$date_2 = preg_replace($selector, '\1', $data_2);
		$time_1 = preg_replace($selector, '\2', $data);
		$time_2 = preg_replace($selector, '\2', $data_2);

		if ($date_1 == $date_2) {
			$result = $date_1.", ".$time_1."h - ".$time_2."h";
			return $result;
		}

		return $date_1.", ".$time_1."h - ".$date_2.", ".$time_2."h";
	}

	public function removeNumMasks($val=null)
	{
		if (!$val) {
			return null;
		}

		$clear = preg_replace("~[^\d]~", "", $val);
		return $clear;
	}

	public function dtExtractDate($data=null, $formatted=true, $format=false)
	{
		if (!$data) {
			return null;
		}

		if (!$formatted) {
			$data = $this->unformatDatetime($data);
		}

		$selector = "~^(\d{4}-\d{2}-\d{2}) (\d{2}:\d{2}:\d{2})$~";

		if (preg_match($selector, $data)) {
			$clear = preg_replace($selector, '\1', $data);
			return $format ? $this->formatDate($clear) : $clear;
		}

		$clear = preg_replace("~[^\d]~", "", $data);
		$clear = preg_replace("~^(\d{4})(\d{2})(\d{2})(\d{2}\d{2}\d{2})$~", '\1-\2-\3', $clear);

		return $format ? $this->formatDate($clear) : $clear;
	}

	public function dtExtractTime($data=null, $formatted=true, $format=false)
	{
		if (!$data) {
			return null;
		}

		if (!$formatted) {
			$data = $this->unformatDatetime($data);
		}

		$selector = "~^(\d{4}-\d{2}-\d{2}) (\d{2}:\d{2}:\d{2})$~";

		if (preg_match($selector, $data)) {
			$clear = preg_replace($selector, '\2', $data);
			return $format ? $this->formatTime($clear) : $clear;
		}

		$clear = preg_replace("~[^\d]~", "", $data);
		$clear = preg_replace("~^(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})$~", '\4:\5:\6', $clear);

		return $format ? $this->formatTime($clear) : $clear;
	}

	public function dtGetPortion($port="", $data=null)
	{
		if (!$data || $port == "") {
			return null;
		}

		$selector = "~^(\d{2})/(\d{2})/(\d{4}), (\d{2}):(\d{2})h$~";

		if (!preg_match($selector, $data)) {
			return null;
		}

		switch ($port) {
			case "d":
			return preg_replace($selector, '\1', $data);
			break;
			case "m":
			return preg_replace($selector, '\2', $data);
			break;
			case "y":
			return preg_replace($selector, '\3', $data);
			break;
			case "h":
			return preg_replace($selector, '\4', $data);
			break;
			case "i":
			return preg_replace($selector, '\5', $data);
			break;
			default:
			return null;
			break;
		}

		// if (preg_match($selector, $data)) {
		// 	$clear = preg_replace($selector, '\1', $data);
		// 	return $format ? $this->formatDate($clear) : $clear;
		// }

		// $clear = preg_replace("~[^\d]~", "", $data);
		// $clear = preg_replace("~^(\d{4})(\d{2})(\d{2})(\d{2}\d{2}\d{2})$~", '\1-\2-\3', $clear);

		// return $format ? $this->formatDate($clear) : $clear;
	}

	function getMonthFromNum($num=null)
	{
		if (!$num) {
			return null;
		}

		$num = (int) $num;
		$num--;

		$months = array(
			'Janeiro', 
			'Fevereiro', 
			'Março', 
			'Abril', 
			'Maio', 
			'Junho', 
			'Julho', 
			'Agosto',
			'Setembro',
			'Outubro',
			'Novembro',
			'Dezembro'
		);

		return $months[$num];
	}

	function resume($text=null, $start=0, $end=50)
	{
		if (!$text) {
			return null;
		}

		return ($end - $start) >= strlen($text) ? substr($text, $start, $end) : substr($text, $start, $end)."...";
	}

	function mb_ucfirst($str=null)
	{
		if (!$str) {
			return null;
		}

		return mb_strtoupper(mb_substr($str, 0, 1)) . mb_substr($str, 1);
	}

	function titleCase($string, $delimiters = array(" ", "-", ".", "'", "O'", "Mc"), $exceptions = array("e", "de", "da", "dos", "das", "do", "I", "II", "III", "IV", "V", "VI"))
	{
		$string = mb_convert_case($string, MB_CASE_TITLE, "UTF-8");
		foreach ($delimiters as $dlnr => $delimiter) {
			$words = explode($delimiter, $string);
			$newwords = array();
			foreach ($words as $wordnr => $word) {
				if (in_array(mb_strtoupper($word, "UTF-8"), $exceptions)) {
                    // check exceptions list for any words that should be in upper case
					$word = mb_strtoupper($word, "UTF-8");
				} elseif (in_array(mb_strtolower($word, "UTF-8"), $exceptions)) {
                    // check exceptions list for any words that should be in upper case
					$word = mb_strtolower($word, "UTF-8");
				} elseif (!in_array($word, $exceptions)) {
                    // convert to uppercase (non-utf8 only)
					$word = ucfirst($word);
				}
				array_push($newwords, $word);
			}
			$string = join($delimiter, $newwords);
       }//foreach
		return $string;
	}

	function getParcelamento($total=null,$parcelas=null)
	{
	   	if (!$total || !$parcelas) {
	   		return null;
	   	}

	   	$result = array();
	   	$parcela = array();
	   	$val_parcelas = 0;
	   	$val_diferente = 0;

	   	for ($i = 2; $i <= $parcelas; $i++) {
	   		$val_parcelas = $total / $i;
	   		$val_parcelas = number_format($val_parcelas, 2, '.', '');
	   		$val_diferente = $total - ($val_parcelas * ($i-1));

	   		$parcela['qnt'] = $i;
	   		$parcela['valor_comum'] = $val_parcelas;
	   		$parcela['valor_diferente'] = $val_diferente;

	   		$result[$i] = (object) $parcela;
	   		$parcela = array();
	   	}

	   	return $result;
	}

	function getVencimentoParcela($parcela=1)
	{
		if (!$parcela || $parcela < 1) {
			return false;
		}

		date_default_timezone_set('America/Sao_Paulo');

		$venc = new DateTime();
		$venc->add(new DateInterval("P".$parcela."M"));
		// $venc->setTime(0,0,0);

		
		while($venc->format('N') < 1 || $venc->format('N') > 5) {
			$venc->add(new DateInterval("P1D"));
		}

		return ($venc->format('Y-m-d')) . " 00:00:00";
	}

	function removeCommonAccents($texto=null)
	{
		if (!$texto) {
			return "";
		}

		$texto = mb_strtolower($texto);

		$acentuadas = array(
			"á", "à", "ã", "â",
			"é", "ê",
			"ó", "ô", "õ",
			"í",
			"ú", "ü",
			"ç"
		);

		$subs = array(
			"a", "a", "a", "a",
			"e", "e",
			"o", "o", "o",
			"i",
			"u", "u",
			"c"
		);

		return str_replace($acentuadas, $subs, $texto);
	}
}