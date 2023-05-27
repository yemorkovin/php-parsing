<?php 
$content_tinkusd = file_get_contents("https://p2p.binance.com/ru/trade/TinkoffNew/USDT?fiat=RUB");
$content_usdtink = file_get_contents("https://p2p.binance.com/ru/trade/sell/USDT?fiat=RUB&payment=TinkoffNew&asset=USDT");
$content_rosbankusd = file_get_contents("https://p2p.binance.com/ru/trade/RosBankNew/USDT?fiat=RUB");
$content_usdrosbank = file_get_contents("https://p2p.binance.com/ru/trade/sell/USDT?fiat=RUB&payment=RosBankNew");
	preg_match_all("#<div class=\"css-[0-9a-z]+\">([0-9]*[.,][0-9]+)</div>#su", $content_tinkusd, $res_1);
	preg_match_all("#<div class=\"css-[0-9a-z]+\">([0-9]*[.,][0-9]+)</div>#su", $content_usdtink, $res_2);
	preg_match_all("#<div class=\"css-[0-9a-z]+\">([0-9]*[.,][0-9]+)</div>#su", $content_rosbankusd, $res_3);
	preg_match_all("#<div class=\"css-[0-9a-z]+\">([0-9]*[.,][0-9]+)</div>#su", $content_usdrosbank, $res_4);
	if(!empty($res_1) && !empty($res_2) && !empty($res_3) && !empty($res_4)){
$stres = "<?xml version='1.0' encoding='UTF-8'?>
<rates>
	<item>
		<from>TINKUSDT</from>
		<to>RUB</to>
		<in>".convert($res_1)."</in>
		<out>1</out>
	</item>
	<item>
		<from>USDTTINK</from>
		<to>RUB</to>
		<in>1</in>
		<out>".convert($res_2)."</out>
	</item>
	<item>
		<from>SBERUSDT</from>
		<to>RUB</to>
		<in>".convert($res_3)."</in>
		<out>1</out>
	</item>
	<item>
		<from>USDTSBER</from>
		<to>RUB</to>
		<in>1</in>
		<out>".convert($res_4)."</out>
	</item>
</rates>";
		file_put_contents('courcep2p.xml',$stres);
	}
	function convert($res){
		$x1 = $res[1][0];
		$x2 = $res[1][1];
		$x3 = $res[1][2];
		$sr = ($x1 + $x2 + $x3)/3;
		$resstr = 0;
		$raz_1 = $sr - $x1;
		if($raz_1 < 0.2){
			$resstr = $x1;
		}else{
			$sr_1 = ($x2 + $x3)/2;
			$raz_2 = $sr_1 - $x2;
			if($raz_2 < 0.2){
				$resstr = $x2;
			}else{
				$resstr = $x3;
			}
		}
		return $resstr;
	}
?>