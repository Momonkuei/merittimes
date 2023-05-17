<?php
include "config.inc.php";
$Config["CategoryMaxLevel"] = 3;

function countTotal($itemTotal = 0, $ItemNo = 0) {
	global $gProductOnsale, $DB, $lang_shopping_field_ship_3, $lang_shopping_field_ship_2;
	/*$totalNum=0;
	$sTotal=0;
	$Total=0;
	$nTotShipFee=0;
	foreach ($_SESSION['ShoppingCar'] as $key => $value) {
	if(is_array($value)){
	$sTotal+=$value['Price'] * $value['Quantity'];
	$nTotShipFee+=$value['ShipFee'];
	$totalNum++;
	}
	}
	if (!empty($_SESSION['ShipFeeFree']) && $_SESSION['ShipFeeFree'] <= $sTotal) $nTotShipFee = 0;
	else if(!empty($nTotShipFee) && !empty($_SESSION['ShipFee'])) $nTotShipFee += $_SESSION['ShipFee'];
	else if (!empty($nTotShipFee)) $nTotShipFee=$nTotShipFee;
	else $nTotShipFee = $_SESSION['ShipFee']; */

	$nCnt = 0;
	if (!empty($_SESSION['ShoppingCar'])) {
		foreach ($_SESSION['ShoppingCar'] as $key => $value) {
			if (is_array($value)) {
				if (empty($value["ProductNo"])) {continue;
				}

				//重新計算產品價格
				if (empty($_SESSION['CustNo'])) {$_SESSION['ShoppingCar'][$key]["Price"] = $value["MemberPrice"];
				}

				if ($_SESSION["CustVIP"] == 1) {$_SESSION['ShoppingCar'][$key]["Price"] = $value["MemberPrice"];
				}
				//Vip會員以VIP價計算
				 else if (!empty($_SESSION['CustNo'])) {$_SESSION['ShoppingCar'][$key]["Price"] = $value["MemberPrice"];
				}
				//Vip會員以VIP價計算
				$nCnt++;

				if ($gProductOnsale == 1) {

					$sql                        = "SELECT status,title FROM onsale_category WHERE saleNo=%s and status = 1 and (start_date <= NOW() OR start_date ='0000-00-00 00:00:00') and (end_date > NOW() OR end_date = '0000-00-00 00:00:00')";
					list($check_onsale, $Title) = $DB->queryFirstList($sql, $value['saleNo']);
					if (!$check_onsale) {
						$value['saleNo']                         = 0;
						$_SESSION['ShoppingCar'][$key]["saleNo"] = 0;
					}
					$productNos    = $value["ProductNo"];
					$sale_no       = $value["saleNo"];
					$queryProducts = "SELECT * FROM `".$LANG_DB."product` WHERE ProductNo =%s ";
					$rowProducts   = $DB->queryFirstRow($queryProducts, $productNos);
					if ($rowProducts['saleNo'] == $sale_no) {

						$querySale  = "SELECT * FROM `".$LANG_DB."onsale_category` WHERE `saleNo` = %s and status = 1 and (start_date <= now() OR start_date='0000-00-00 00:00:00') and (end_date > now() OR end_date = '0000-00-00 00:00:00')";
						$rowSale    = $DB->queryFirstRow($querySale, $sale_no);
						$onSaleName = $rowSale['title'];
					}
					if ($rowSale['discount_type'] == 1 || $rowSale['discount_type'] == 2) {
						$price = $value["Price"]*$value["Quantity"];

						$in_salePro = array_keys($sale[$sale_no]);
						if ($productNos == $in_salePro[0]) {
							$thisSaleNo                  = explode("@", $sale[$sale_no][$in_salePro[0]]);
							$sale[$sale_no][$productNos] = (int) $thisSaleNo[0]."@".((int) $thisSaleNo[1]+(int) $value["Quantity"]);
						} else {
							$sale[$sale_no][$productNos] = $value["Price"]."@".$value["Quantity"];
						}

					}
				}
				$nTotalNormal += $value["Price"]*$value["Quantity"];//全部購物的總和

				$nNorTotal += $value["Price"]*$$value["Quantity"];
				$nTotal  = $nTotalNormal;
				$nTotalo = $nTotalNormal;
				$nTotShipFee += $value["ShipFee"];
			}
		}
		$NextFlag = true;
	} else {
		$NextFlag = false;

	}

	if ($gProductOnsale == 1 && $sale !== null) {
		$saleNoArr = array_keys($sale);
		for ($s = 0; $s < count($sale); $s++) {
			$pnoArray  = array_keys($sale[$saleNoArr[$s]]);
			$querySale = "SELECT * FROM `".$LANG_DB."onsale_category` WHERE `saleNo` = %i and status = 1 and (start_date <= now() OR start_date='0000-00-00 00:00:00') and (end_date > now() OR end_date = '0000-00-00 00:00:00')";
			$rowSale   = $DB->queryFirstRow($querySale, $saleNoArr[$s]);
			if ($rowSale['discount_type'] == 1) {//如果活動是組合價類型
				for ($z = 0; $z <= count($pnoArray)-1; $z++) {
					$proNum   = explode("@", $sale[$saleNoArr[$s]][$pnoArray[$z]]);//產品價錢與數量
					$proPrice = $proNum[0];//原價
					$proQuant = $proNum[1];//數量
					if (!empty($lastQuant) && $lastQuant > 0) {// 如果有上一個產品的多餘數量，加到這次的商品中
						$proQuant  = $lastQuant+$proQuant;
						$lastQuant = 0;
					} else {
						$proQuant = $proQuant;
					}
					$salePrice = (int) ($proQuant/$rowSale['quantity']);
					$elsePrice = (int) $proQuant%$rowSale['quantity'];
					if ($elsePrice == 0) {
						if ($salePrice != 0) {$proQuantCount += $salePrice;
						}
					} else {
						if ($salePrice != 0) {$proQuantCount += $salePrice;
						}

						$lastQuant = $elsePrice;
						$lastPrice = $proPrice;
					}
					$orgPrice[$z] = $proNum[0]."@".$proNum[1];
				}//end for sale count
				if ($proQuantCount >= 1) {
					$price_onSale2 = round($rowSale['discount_price'])*$proQuantCount;
					if ($lastPrice != 0) {$price_onSale2 += $lastPrice*$lastQuant;
					}
				} else {
					$price_onSale2 = $lastPrice*$proQuant;
				}

				for ($k = 0; $k < count($orgPrice); $k++) {
					$numPrice = explode("@", $orgPrice[$k]);//產品價錢與數量
					$basePrice2 += $numPrice[0]*$numPrice[1];
				}
				$nTotalOnSale2 += $price_onSale2;
				$OnSale2 += $price_onSale2;
				$nomalTotal = $basePrice2;
				$Total2     = $basePrice2;
				$discount1  = $OnSale2-$Total2;
				$SaleType1  = '<strong>'.$rowSale['title'].':</strong><font id="font_discount1">'.$discount1.'</font>';
			}//end discount_type ==1

			if ($rowSale['discount_type'] == 2) {//如果活動是折數類型
				$sale_Count = 0;
				$count_tmp  = 0;
				//print_r($sale);

				for ($z = 0; $z <= count($pnoArray)-1; $z++) {
					$thisPNo  = explode("@", $sale[$saleNoArr[$s]][$pnoArray[$z]]);
					$proPrice = $thisPNo[0];
					$proQuant = $thisPNo[1];
					$allcountQuant += $proQuant;//計算這一個主題活動產品購買的數量
					$allbasePrice += $proPrice*$proQuant;
				}
				$set   = floor($allcountQuant/$rowSale['quantity']);
				$suite = $set*$rowSale['quantity'];
				for ($z = 0; $z <= count($pnoArray)-1; $z++) {
					if (($allcountQuant+$count_tmp)/$rowSale['quantity'] >= 1) {
						$thisPNo  = explode("@", $sale[$saleNoArr[$s]][$pnoArray[$z]]);
						$proPrice = $thisPNo[0];
						$proQuant = $thisPNo[1];

						for ($i = 1; $i <= $proQuant; $i++) {
							if (($allcountQuant+$count_tmp)/$rowSale['quantity'] >= 1) {
								$basePrice += $proPrice*1*$rowSale['discount_per'];
								$count_tmp++;
								if ($count_tmp/$rowSale['quantity'] == 1) {$count_tmp = 0;
								}
							} else {
								$basePrice += $proPrice*1;
							}

							$allcountQuant -= 1;
						}
						$countQuant += $proQuant;//計算這一個主題活動產品購買的數量
					} else {
						$thisPNo  = explode("@", $sale[$saleNoArr[$s]][$pnoArray[$z]]);
						$proPrice = $thisPNo[0];
						$proQuant = $thisPNo[1];
						$basePrice += $proPrice*$proQuant;
						$countQuant += $proQuant;//計算這一個主題活動產品購買的數量
						$allcountQuant -= $proQuant;
					}
				}
				$discount2 = $basePrice-$allbasePrice;
				$SaleType2 = '<strong>'.$rowSale['title'].':</strong><font id="font_discount2">'.$discount2.'</font>';
			}//end discount_type ==2

		}
		$nTotalo = $nTotal+$discount1+$discount2;

	}
	//計算遲費
	if (!empty($_SESSION['ShipFeeFree']) && $_SESSION['ShipFeeFree'] <= $nTotalo) {
		$nTotShipFee = 0;
		$ShopFee     = $_SESSION['ShipFeeFree'];

	} else if (!empty($nTotShipFee) && !empty($_SESSION['ShipFee'])) {
		$ShopFee = $nTotShipFee;
		$nTotShipFee += $_SESSION['ShipFee'];

	} else if (!empty($nTotShipFee)) {echo $ShopFee = $nTotShipFee;
	} else if (!empty($_SESSION['ShipFee'])) {
		$ShopFee     = $_SESSION['ShipFee'];
		$nTotShipFee = $_SESSION['ShipFee'];

	} else {
		$ShopFee = 0;
	}

	$_SESSION['ShoppingCar']['Amount']      = $nTotal;
	$_SESSION['ShoppingCar']['Total']       = $nTotal+$nTotShipFee-$_SESSION['ShoppingCar']['coupon']['total'];
	$_SESSION['ShoppingCar']['TotDiscount'] = $discount1+$discount2;
	$_SESSION['ShoppingCar']['TotShipFee']  = $nTotShipFee;

	$Ary = array("totalnum" => $nCnt, "itemtotal" => $itemTotal, "shopfee" => $nTotShipFee, "total" => $nTotalo+$nTotShipFee-$_SESSION['ShoppingCar']['coupon']['total'], "subtotal" => $nTotal, "ItemNo" => $ItemNo, "discountHTML" => array($SaleType1, $SaleType2));
	return $Ary;
}

if ($_POST['type'] == "addcar") {
	$ProductNo = $_POST['id'];
	$sql       = "SELECT * FROM ".$LANG_DB."product WHERE status=1 AND (start_date <= now() Or start_date is null Or start_date = '0000-00-00') And (end_date >= now() Or end_date is null Or end_date = '0000-00-00') and ProductNo=%s";

	$Product = $DB->queryFirstRow($sql, $ProductNo);

	if ($Product) {
		$_SESSION['ShipFeeFree']                          = $gFree_Shipfee;
		$_SESSION['ShipFee']                              = $gShoppingCar_Shipfee;
		if (!empty($_SESSION['ShoppingCar'])) {$nCarCount = count($_SESSION['ShoppingCar']);
		} else {
			$nCarCount = 0;
		}

		$AddFlag = true;
		for ($ii = 0; $ii < $nCarCount; $ii++) {
			//檢查購物車中是否已經有此產品編號、規格
			if ($_SESSION['ShoppingCar'][$ii]['ProductNo'] == $ProductNo) {$AddFlag = false;

			}
		}

		if ($AddFlag) {
			if ($Product["photo_s"] != "" && file_exists($Product_Upload_Path.$Product['photo_s'])) {$PhotoS = $Product_Path.$Product['photo_s'];
			} else {
				"images/spacer.gif";
			}

			$_SESSION['ShoppingCar'][$nCarCount]['ProductNo'] = $Product["ProductNo"];
			$_SESSION['ShoppingCar'][$nCarCount]['ProductID'] = $Product["ProductID"];
			if ($gProductOnsale == 1) {
				$_SESSION['ShoppingCar'][$nCarCount]['saleNo'] = $Product["saleNo"];
			}
			$_SESSION['ShoppingCar'][$nCarCount]['VIP']         = $Product["VIP"];
			$_SESSION['ShoppingCar'][$nCarCount]['ProductName'] = $Product["product_name"];
			$_SESSION['ShoppingCar'][$nCarCount]['Quantity']    = 1;
			$_SESSION['ShoppingCar'][$nCarCount]['ShipFee']     = 0;
			$_SESSION['ShoppingCar'][$nCarCount]['Price']       = $Product["price"];
			$_SESSION['ShoppingCar'][$nCarCount]['ListPrice']   = $Product["list_price"];
			$_SESSION['ShoppingCar'][$nCarCount]['MemberPrice'] = $Product["price"];
			$_SESSION['ShoppingCar'][$nCarCount]['VipPrice']    = $Product["vip_price"];
			$_SESSION['ShoppingCar'][$nCarCount]['Bonus']       = $Product["Bonus"];
			$_SESSION['ShoppingCar'][$nCarCount]['Photo_S']     = $PhotoS;
			$_SESSION['ShoppingCar'][$nCarCount]['CatNo']       = $Product["CatNo"];
			$_SESSION['ShoppingCar'][$nCarCount]['Stock']       = $Product['Stock'];
			//用來處理單一產品可多次加入，但不同規格
			$_SESSION['ShoppingCar'][$nCarCount]['ItemNo'] = time();

		} else {
			echo json_encode("error");
		}
		//計算商品數量、金額總價

		if ($_SESSION['ShoppingCar'] && $AddFlag) {
			$num   = 0;
			$total = 0;
			foreach ($_SESSION['ShoppingCar'] as $key => $value) {
				if (is_array($value)) {
					$num++;
					$tmp_shoppingCar[] = $value;
					if ($_SESSION['CustNo'] && $_SESSION['CustVip'] == "1") {
						$total += $value['VipPrice'];
					} else {
						$total += $value['Price'];
					}
				}
			}

			$i = (count($tmp_shoppingCar)-3 <= 0?0:count($tmp_shoppingCar)-3);

			for ($i; $i < count($tmp_shoppingCar); $i++) {
				$ret .= '<li class="item" id="sidecar_item_'.$tmp_shoppingCar[$i]['ItemNo'].'"><a href="product_detail.php?PNo='.$tmp_shoppingCar[$i]['ProductNo'].'"><div class="itemImg"><img src="'.$tmp_shoppingCar[$i]['Photo_S'].'"></div><p>'.$tmp_shoppingCar[$i]['ProductName'].'</p></a></li>';

			}

			if ($Product['photo_s'] != "") {$Photo = $Product_Path.$Product['photo_s'];
			} else {
				$Photo = "images/spacer.gif";
			}

			echo json_encode(array("num" => $num, "total" => $total, "name" => $Product['product_name'], "photo" => $Photo, "sidecar" => $ret, "OnsaleHTML" => $OnsaleHTML));
		}

	} else {
		echo json_encode(false);
	}
	exit;
} else if ($_POST['type'] == "udpatcar") {

	$num = $_POST['num'];
	$key = $_POST['key'];
	if ($gProductStock == 1) {
		$ProductNo = $_SESSION['ShoppingCar'][$key]['ProductNo'];
		$sql       = "SELECT stock FROM product WHERE productno=%s";
		$Stock     = $DB->queryFirstField($sql, $ProductNo);
		if ($num > $Stock) {
			echo json_encode(array("StockError", $Stock, $_SESSION['ShoppingCar'][$key]['ProductName']));
			exit;
		}

	}
	$_SESSION['ShoppingCar'][$key]['Quantity'] = $num;
	$_SESSION['ShoppingCar'][$key]['Stock']    = $Stock;
	//重新計算總數小計金額
	//$subNum=0;
	$itemTotal = $_SESSION['ShoppingCar'][$key]['Price']*$_SESSION['ShoppingCar'][$key]['Quantity'];

	echo json_encode(countTotal($itemTotal, $_SESSION['ShoppingCar'][$key]['ItemNo']));
	exit;
} else if ($_POST['type'] == "delitem") {
	$no = $_POST['no'];
	if (empty($_SESSION['ShoppingCar'])) {
		echo json_encode(false);
		exit;
	}
	foreach ($_SESSION['ShoppingCar'] as $key => $value) {
		if ($value['ItemNo'] == $no) {
			unset($_SESSION['ShoppingCar'][$key]);
			break;
		}
	}
	echo json_encode(countTotal());
	exit;
} else if ($_POST['type'] == "checkcoupon") {
	$couponno = $_POST['couponno'];
	if ($couponno == "") {exit;
	}

	$_SESSION['coupon'] = $couponno;

	$discount = coupon_discount($_SESSION['CustNo']);

	if ($discount['error']) {echo json_encode($discount["error"]);
	} else {
		$_SESSION['ShoppingCar']['coupon'] = $discount;
		echo json_encode("coupon");
	}
	exit;

} else if ($_POST['type'] == "chg_option") {
	$ProductNo = $_POST['productno'];
	$Spec      = $_POST['val'];
	if ($_SESSION['ShoppingCar']) {
		foreach ($_SESSION['ShoppingCar'] as $key => $value) {
			if ($value['ProductNo'] == $ProductNo) {
				$_SESSION['ShoppingCar'][$key]['Spec'] = $Spec;
				echo json_encode(true);
				exit;
			}
		}
	}
	echo json_encode(false);
	exit;
} else if ($_POST['type'] == "checkshoppingcar") {
	if ($_SESSION['ShoppingCar']) {
		foreach ($_SESSION['ShoppingCar'] as $key => $value) {
			if (is_array($value)) {
				if ($value['Spec'] == "" || !isset($value['Spec'])) {
					echo json_encode(false);
					exit;
				}
			}

		}
		echo json_encode(true);
		exit;
	}
	echo json_encode(false);
	exit;
} else if ($_REQUEST["type"] == "ios" && $_REQUEST["location"] == "index") {

	$sql           = "SELECT bannerno,photo_m from banner WHERE  locate='Index' AND (start_date <= now() Or start_date is null Or start_date = '0000-00-00') And (end_date >= now() Or end_date is null Or end_date = '0000-00-00') order by priority ASC ";
	$tmpBanner     = $DB->query($sql);
	$BannerDiction = Array();
	$BannerArray   = Array();
	if ($tmpBanner) {
		foreach ($tmpBanner as $key => $value) {
			$BannerDiction[$value["bannerno"]] = $value;
			$BannerArray[]                     = $value["bannerno"];
		}

	}
	$sql       = "SELECT title,cat_name_1,saleNo FROM onsale_category WHERE status = 1";
	$OnSaleTmp = $DB->query($sql);
	$OnSaleRtn = array();
	if ($OnSaleTmp) {
		foreach ($OnSaleTmp as $key => $value) {
			$sql = "SELECT count(*) as CNT FROM product WHERE saleNo = '".$value["saleNo"]."' and (start_date <= now() Or start_date is null Or start_date = '0000-00-00') And (end_date >= now() Or end_date is null Or end_date = '0000-00-00') ";
			$Num = $DB->queryFirstField($sql);
			if ($Num > 0) {
				$OnSaleRtn[] = $value;

			}
		}

	}
	$sql       = "SELECT app_photo,NewsNo FROM news WHERE status =1 order by priority DESC limit 0,1";
	$NewsIndex = $DB->queryFirstRow($sql);

	$sql                 = "SELECT appimage,catno,cat_name from category WHERE status =1 and appshow = 1 order by priority DESC ";
	$IndexCateArray      = Array();
	$IndexCateImageArray = Array();
	$tmpCateImage        = $DB->query($sql);
	if ($tmpCateImage) {
		foreach ($tmpCateImage as $key => $value) {
			$IndexCateArray[]                     = $value["catno"];
			$IndexCateImageArray[$value["catno"]] = $value;
		}

	}

	$sql                  = "SELECT menuimg,catno FROM category WHERE status=1 and appindexcateshow = 1 order by priority DESC";
	$tmpIndexCateImage    = $DB->query($sql);
	$IndexCateArray2      = Array();
	$IndexCateImageArray2 = Array();
	if ($tmpIndexCateImage) {
		foreach ($tmpIndexCateImage as $value) {
			$sql           = "SELECT SUM( b.click_count ) AS c_sum, a.product_name, a.price, a.photo_l FROM product a LEFT JOIN product_click b ON a.productno = b.productno WHERE a.Multiple_CatNo LIKE  '%".$value["catno"]."%' AND a.status =1 GROUP BY b.productno ORDER BY c_sum DESC LIMIT 0 , 3";
			$tmp_sum_array = $DB->query($sql);
			if (count($tmp_sum_array) == 3) {
				$IndexCateArray2[]                             = $value["catno"];
				$IndexCateImageData2[$value["catno"]]["image"] = $value["menuimg"];
				$IndexCateImageData2[$value["catno"]]["data"]  = $tmp_sum_array;
			}
		}
	}
	$sql        = "SELECT photo,bannerno from banner where locate='Index-Midd' AND (start_date <= now() Or start_date is null Or start_date = '0000-00-00') And (end_date >= now() Or end_date is null Or end_date = '0000-00-00') order by rand() limit 2 ";
	$BannerMidd = $DB->query($sql);

	$sql               = "SELECT newsno,subject,app_photo FROM news WHERE Active_Date < NOW() and status =1 and app_photo != '' order by priority DESC limit 0,3";
	$tmpIndexNewsList  = $DB->query($sql);
	$IndexNewsListArry = array();
	$IndexNewsListData = array();
	if ($tmpIndexNewsList) {
		foreach ($tmpIndexNewsList as $key => $value) {
			$IndexNewsListArry[]                 = $value["newsno"];
			$IndexNewsListData[$value["newsno"]] = $value;
		}

	}

	$sql          = "SELECT count(productno) as cnt,productno FROM order_detail group by productno order by cnt DESC ";
	$tmpSell      = $DB->query($sql);
	$TopSellArray = array();
	$TopSellData  = array();
	if ($tmpSell) {
		foreach ($tmpSell as $value) {
			$sql = "SELECT productno,productid,product_name,price,photo_m,photo_l FROM product WHERE productno = '".$value["productno"]."'";

			$tmpSellProduct = $DB->queryFirstRow($sql);
			if ($tmpSellProduct) {
				$count++;
				$TopSellArray[]                   = $value["productno"];
				$TopSellData[$value["productno"]] = $tmpSellProduct;

			}

		}
	}
	$sql            = "SELECT catno FROM news_category WHERE appshow = 1 order by priority DESC limit 0,1";
	$tmpCatno       = $DB->queryFirstField($sql);
	$IndexNewsArray = array();
	$IndexNewsData  = array();
	if ($tmpCatno) {
		$sql     = "SELECT newsno,subject,app_photo FROM news WHERE catno = '$tmpCatno' and status = 1 order by priority DESC ";
		$tmpNews = $DB->query($sql);
		if ($tmpNews) {
			foreach ($tmpNews as $key => $value) {
				$IndexNewsArray[]                = $value["newsno"];
				$IndexNewsData[$value["newsno"]] = $value;
			}

		}

	}
	$Level = 1;
	$sql   = "SELECT catno,cat_name FROM category WHERE status =1 and parent = 0 order by priority DESC ";

	$tmpCat1        = $DB->query($sql);
	$CateListArray  = array();
	$CateParentArry = array();
	//$CateListData   = array();
	$CateListLavel = array();
	if ($tmpCat1) {
		foreach ($tmpCat1 as $key => $value) {
			$value["level"]        = 1;
			$CateListArray[]       = $value["catno"];
			$CateParentArry["0"][] = $value["catno"];
			//$CateListData[$value["catno"]]  = $value;
			$tmpArray["catno"]              = $value["catno"];
			$tmpArray["cat_name"]           = $value["cat_name"];
			$tmpArray["Level"]              = 1;
			$CateListLavel[$value["catno"]] = $tmpArray;
			if ($Config["CategoryMaxLevel"] >= 2) {

				$sql     = "SELECT catno,cat_name FROM category WHERE status = 1 and parent = '".$value["catno"]."' order by priority DESC";
				$tmpCat2 = $DB->query($sql);
				if ($tmpCat2) {
					$tmp2 = array();
					foreach ($tmpCat2 as $k => $v) {
						$v["level"]                        = 2;
						$tmpArray["catno"]                 = $v["catno"];
						$tmpArray["cat_name"]              = $v["cat_name"];
						$tmpArray["Level"]                 = 2;
						$CateListLavel[$v["catno"]]        = $tmpArray;
						$CateParentArry[$value["catno"]][] = $v["catno"];
						$tmp2[$v["catno"]]                 = $v;
						if ($Config["CategoryMaxLevel"] >= 3) {

							$tmp3    = array();
							$sql     = "SELECT catno,cat_name FROM category WHERE status = 1 and parent = '".$v["catno"]."' order by priority DESC";
							$tmpCat3 = $DB->query($sql);
							if ($tmpCat3) {
								foreach ($tmpCat3 as $i => $j) {
									$j["level"]                    = 3;
									$tmpArray["catno"]             = $j["catno"];
									$tmpArray["cat_name"]          = $j["cat_name"];
									$tmpArray["Level"]             = 3;
									$CateListLavel[$j["catno"]]    = $tmpArray;
									$CateParentArry[$v["catno"]][] = $j["catno"];

									$tmp3[] = $j;
								}
								//if (count($tmp3) > 0) {$tmp2[$v["catno"]]["data"] = $tmp3;
								//}
							}
						}
					}

					//if (count($tmp2) > 0) {$CateListData[$value["catno"]]["data"] = $tmp2;

					//}
				}

			}
		}
	}
	$sql                   = "SELECT catno,cat_name FROM news_category WHERE status =1 order by priority DESC";
	$tmpNewsCategory       = $DB->query($sql);
	$CateNewsCategoryArray = array();
	$CateNewsCategoryData  = array();
	if ($tmpNewsCategory) {
		foreach ($tmpNewsCategory as $key => $value) {
			$CateNewsCategoryArray[]               = $value["catno"];
			$CateNewsCategoryData[$value["catno"]] = $value["cat_name"];
		}

	}
	$ret["Banner"]["Diction"]        = $BannerDiction;
	$ret["Banner"]["Array"]          = $BannerArray;
	$ret["OnSale"]                   = $OnSaleRtn;
	$ret["NewsIndex"]                = $NewsIndex?$NewsIndex:"";
	$ret["IndexCate"]["Diction"]     = $IndexCateImageArray;
	$ret["IndexCate"]["Array"]       = $IndexCateArray;
	$ret["IndexCate2"]["Diction"]    = $IndexCateImageData2;
	$ret["IndexCate2"]["Array"]      = $IndexCateArray2;
	$ret["BannerMidd"]               = $BannerMidd;
	$ret["IndexNewsList"]["Array"]   = $IndexNewsListArry;
	$ret["IndexNewsList"]["Diction"] = $IndexNewsListData;
	$ret["TopSell"]["Array"]         = $TopSellArray;
	$ret["TopSell"]["Diction"]       = $TopSellData;
	$ret["IndexNews"]["Array"]       = $IndexNewsArray;
	$ret["IndexNews"]["Diction"]     = $IndexNewsData;
	$ret["CateList"]["Array"]        = $CateParentArry;
	//$ret["CateList"]["Diction"]      = $CateListData;
	$ret["CateList"]["Array1"]      = $CateListArray;
	$ret["CateNewsCate"]["Array"]   = $CateNewsCategoryArray;
	$ret["CateListLevel"]           = $CateListLavel;
	$ret["CateNewsCate"]["Diction"] = $CateNewsCategoryData;
	echo json_encode($ret);
	exit;

} else if ($_REQUEST["type"] == "getProductList" && $_REQUEST["no"] != "") {

	$ProductNoString = $_REQUEST["no"];
	$sql             = "SELECT productno,photo_m,photo_l,product_name,price FROM product WHERE status =1 and productno in (".$ProductNoString.")";
	$ret             = $DB->query($sql);
	echo json_encode($ret);
	exit;

} else if ($_REQUEST["type"] == "getCateProduct" && $_REQUEST["cateno"] != "") {
	$CatNo   = $_REQUEST["cateno"];
	$sql     = "SELECT product_name,productno,photo_l,price FROM product WHERE status = 1 and NOW() >= start_date and multiple_catno like %ss order by priority DESC";
	$tmpData = $DB->query($sql, $CatNo);
	$Array   = array();
	$Data    = array();
	if ($tmpData) {
		foreach ($tmpData as $key => $value) {
			$Array[]                   = $value["productno"];
			$Data[$value["productno"]] = $value;
		}

	}
	$ret["Array"] = $Array;
	$ret["Data"]  = $Data;
	echo json_encode($ret);
	exit;

} else if ($_REQUEST["type"] == "history" && $_REQUEST["catnostring"] != "") {
	$CatNoString = $_REQUEST["catnostring"];
	$sql         = "SELECT product_name,productno,photo_l,price FROM product WHERE status = 1 and NOW() >= start_date and productno in (".$CatNoString.") order by priority DESC";

	$tmpData = $DB->query($sql);
	$Array   = array();
	$Data    = array();
	if ($tmpData) {
		foreach ($tmpData as $key => $value) {
			$Array[]                   = $value["productno"];
			$Data[$value["productno"]] = $value;
		}

	}
	$ret["Array"] = $Array;
	$ret["Data"]  = $Data;
	echo json_encode($ret);
	exit;

} else if ($_REQUEST["type"] == "Search" && $_REQUEST["SearchString"] != "") {
	$Search = $_REQUEST["SearchString"];
	$sql    = "SELECT product_name,productno,photo_l,price FROM product WHERE status = 1 and NOW() >= start_date and product_name like %ss order by priority DESC";

	$tmpData = $DB->query($sql, $Search);
	$Array   = array();
	$Data    = array();
	if ($tmpData) {
		foreach ($tmpData as $key => $value) {
			$Array[]                   = $value["productno"];
			$Data[$value["productno"]] = $value;
		}

	}
	$ret["Array"] = $Array;
	$ret["Data"]  = $Data;
	echo json_encode($ret);
	exit;

} else if ($_REQUEST["type"] == "productdetail" && $_REQUEST["productno"] != "") {
	$ProductNo = $_REQUEST["productno"];
	$sql       = "SELECT * FROM product WHERE status=1 AND (start_date <= now() Or start_date is null Or start_date = '0000-00-00') And (end_date >= now() Or end_date is null Or end_date = '0000-00-00') and ProductNo=%s";
	$Product   = $DB->queryFirstRow($sql, $ProductNo);
	if (!$Product) {
		echo json_encode(false);
		exit;
	}

	$ret["productdetail"] = $Product;
	$sql                  = "SELECT photo_b from product_photo WHERE productno = %s";
	$ProductPhoto         = $DB->query($sql, $ProductNo);
	if ($ProductPhoto) {
		foreach ($ProductPhoto as $key => $value) {
			$ret["productphoto"][] = $value["photo_b"];
		}
	}
	$ret["productphoto"][] = $Product["photo_b"];

	$sql             = "SELECT a.priority , a.related_productno as rproductno,b.product_name,b.price,b.photo_m,b.photo_l FROM product_related a left join product b on a.productno = b.productno WHERE a.productno = %s";
	$Product_related = $DB->query($sql, $ProductNo);
	$RelatedArray    = array();
	$RelatedData     = array();
	if ($Product_related) {
		foreach ($Product_related as $key => $value) {
			$RelatedArray[]                    = $value["rproductno"];
			$RelatedData[$value["rproductno"]] = $value;
		}

	}
	$sql       = "SELECT title,cat_name_1,saleNo FROM onsale_category WHERE status = 1";
	$OnSaleTmp = $DB->query($sql);
	$OnSaleRtn = array();
	if ($OnSaleTmp) {
		foreach ($OnSaleTmp as $key => $value) {
			$sql = "SELECT count(*) as CNT FROM product WHERE saleNo = '".$value["saleNo"]."' and (start_date <= now() Or start_date is null Or start_date = '0000-00-00') And (end_date >= now() Or end_date is null Or end_date = '0000-00-00') ";
			$Num = $DB->queryFirstField($sql);
			if ($Num > 0) {
				$OnSaleRtn[] = $value;

			}
		}

	}
	$ret["OnSale"]                = $OnSaleRtn;
	$ret["photorelated"]["Array"] = $RelatedArray;
	$ret["photorelated"]["Data"]  = $RelatedData;
	echo json_encode($ret);
	exit;
} else if ($_REQUEST["type"] == "getProduct" && $_REQUEST["no"] != "") {

	$ProductNoString = $_REQUEST["no"];
	$sql             = "SELECT productno,multiple_catno,datatime,catno,list_price,price,productid,photo_m,product_name,stock,status FROM product WHERE status =1 and productno in (".$ProductNoString.")";
	$tmp             = $DB->query($sql);
	if ($tmp) {
		foreach ($tmp as $key => $value) {
			$ret[$value["productno"]] = $value;
		}

	}
	echo json_encode($ret);
	exit;

} else if ($_REQUEST["type"] == "loginUser" && $_REQUEST["userid"] != "") {
	$UserID = $_REQUEST["userid"];
	$sql    = "SELECT count(*) as cnt FROM customer WHERE loginID = '$UserID' and status =1 ";
	$cnt    = $DB->queryFirstField($sql);
	if ($cnt == 0) {
		echo json_encode(false);
	} else {
		echo json_encode(true);
	}

	exit;

} else if ($_REQUEST["type"] == "SMSSend") {
	if ($_REQUEST["username"] == "" || $_REQUEST["pw"] == "" || $_REQUEST["userid"] == "") {

		echo json_encode("資料錯誤");
		exit;
	}

	$SMSUserName = $_REQUEST["username"];
	$SMSPassWord = $_REQUEST["pw"];
	$UserID      = $_REQUEST["userid"];
	$CompanyName = $_REQUEST["companyname"];
	$sql         = "SELECT sms_code FROM customer WHERE loginid = '$UserID'";
	$sms_code    = $DB->queryFirstField($sql);
	if (!$sms_code) {
		do {
			$sms_code  = rand(1000, 9999);
			$sql       = "SELECT count(custno) as cnt FROM customer WHERE sms_code = '$sms_code'";
			$tmpCustNo = $DB->queryFirstField($sql);
		} while ($tmpCustNo > 0);
		$DB->insert("customer", array("loginid" => $UserID, "sms_code" => $sms_code, "ios_deviceid" => $_REQUEST["deviceid"]));
	}

	$USER = $SMSUserName;//infant user
	$PWD  = $SMSPassWord;//infant pwd
	$msg  = iconv("utf-8", "big5", "親愛的{$CompanyName}會員您好，您的驗証碼為「{$sms_code}」，請你輸入輸入驗証碼後，繼續完成註冊程序。");

	$dstaddr = $UserID;//tel
	$name    = iconv("utf-8", "big5", $_REQUEST["Name"]);
	//$name = $rec_Name;   //username
	$smbody = urlencode($msg);//ms

	$return  = "http://192.168.0.200/infant/return.php";
	$qry_str = "?username=".$USER."&password=".$PWD."&dstaddr=".$dstaddr."&smbody=".$smbody;

	$ch = curl_init();

	// Set query data here with the URL
	curl_setopt($ch, CURLOPT_URL, 'http://smexpress.mitake.com.tw:9600/SmSendGet.asp'.$qry_str);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, '3');
	$content = trim(curl_exec($ch));
	curl_close($ch);
	echo json_encode(sprintf("%d", $sms_code));
	exit;

} else if ($_REQUEST["type"] == "addnewcustome" && $_REQUEST["mobileno"] != "") {
	$LoignID = $_REQUEST["mobileno"];
	$pw      = $_REQUEST["pw"];
	$mobile  = $LoignID;
	$res     = $DB->update("customer", array("password" => $pw, "status" => "1", "mobile" => $LoginID), "loginid = %s", $LoignID);

	if ($res) {
		$sql    = "SELECT custno FROM customer WHERE loginid = %s";
		$custno = $DB->queryFirstField($sql, $LoignID);
	}
	echo json_encode($custno);
	exit;

} else if ($_REQUEST["type"] == "customerlogin" && $_REQUEST["loginid"] != "" && $_REQUEST["pw"] != "") {
	$DeviceID = $_REQUEST["deviceid"];
	$LoignID  = $_REQUEST["loginid"];
	$sql      = "SELECT count(*) as cnt FROM customer WHERE ios_deviceid = %s ";
	$cnt      = $DB->queryFirstField($sql, $DeviceID);
	if ($cnt == 0) {
		$DB->update("customer", array("ios_deviceid" => $DeviceID), "loginid = %s", $LoignID);
	}

	$PW  = $_REQUEST["pw"];
	$sql = "SELECT custno,name,sex,mobile,email,address,infostatus,zip,county,district,birthday FROM customer WHERE loginid ='$LoignID' and password='$PW' and status = 1";

	$res = $DB->queryFirstRow($sql);
	echo json_encode($res);
	exit;
} else if ($_REQUEST["type"] == "fblogin" && $_REQUEST["username"] != "" && $_REQUEST["email"] != "" && $_REQUEST["userid"] != "") {
	$UserName = $_REQUEST["username"];
	$EMail    = $_REQUEST["email"];
	$LoginID  = $_REQUEST["userid"];
	$sql      = "SELECT custno,name,sex,mobile,email,address,infostatus,status,zip,county,district,birthday FROM customer WHERE loginid = %s ";
	$data     = $DB->queryFirstRow($sql, $LoginID);
	if ($data["status"] == "1") {

		echo json_encode($data);
		exit;
	} else {
		if ($data) {

			echo json_encode(false);
			exit;
		}
		$password = substr(md5(rand()), 0, 6);
		$res      = $DB->insert("customer", array("loginid" => $LoginID, "password" => $password, "email" => $EMail, "name" => $UserName, "status" => "1", "ios_deviceid" => $_REQUEST["deviceid"]));

		if ($res) {

			$custno = $DB->insertId();
			echo json_encode($custno);
			exit;
		} else {

			echo json_encode(false);
			exit;
		}

	}

} else if ($_REQUEST["type"] == "getTotalOrderPay" && $_REQUEST["custno"] != "") {
	$CustNo = $_REQUEST["custno"];

	$sql    = "SELECT sum(total) as s_total FROM `order` WHERE custno = %s and status ='2'";
	$sTotal = $DB->queryFirstField($sql, $CustNo);
	echo json_encode($sTotal?$sTotal:0);
	exit;
} else if ($_REQUEST["type"] == "getfeepay") {
	$ret["ship_fee"]        = $WebSet["ship_fee"];
	$ret["seven_fee"]       = $WebSet["seven_fee"];
	$ret["family_fee"]      = $WebSet["family_fee"];
	$ret["atm"]["atm_bank"] = $WebSet["pay_atm_bank"]["Name"];
	$ret["atm"]["atm_name"] = $WebSet["pay_atm_name"]["Name"];
	$ret["atm"]["atm_no"]   = $WebSet["pay_atm_num"]["Name"];
	$ret["atm"]["atm_code"] = $WebSet["pay_atm_code"]["Name"];
	echo json_encode($ret);
	exit;
} else if ($_REQUEST["type"] == "other") {
	$People = array("", "蔡明峰", "周家豪", "陳思穎", "吳聲辰", "張博彥", "林庭儀", "辜英日", "劉峻源", "席首席", "陳煒婷", "鄭哲明", "曾郁之", "黃耿賓", "李英昌", "傅譯賢", "陳室尹", "蕭智文",
		"尤崇智", "林明毅", "王暉媚", "巫佳蓉", "姚文元", "陳心鴻", "劉蕙榕", "陳信明", "楊勝發", "鍾興丞", "黃鉦元 ", "賴奕佑", "陳軍翰", "杜勝杰", "盧怡如", "莊總", "舜子姐");
	print_r(count($People));
	for ($i = 0; $i <= count($People); $i++) {
		print_r("i=".$i."<br>");
		if ($i == 0) {
			$Arr[] = "";
		} else {
			do {
				$ra = rand(1, count($People));
				print_r($ra."<br>");

			} while (in_array($ra, $Arr));
			$Arr[] = $ra;
		}

	}
	print_r($Arr);
	print_r(count($Arr));
	foreach ($Arr as $key => $value) {
		if ($key != 0) {
			print_r($key);
			switch ($key%3) {
				case 1:
					$team1[] = $People[$key];
					break;
				case 2:
					$team2[] = $People[$key];
					break;
				default:
					$team3[] = $People[$key];
					break;
			}
		}
	}
	print_r($team1);
	print_r($team2);
	print_r($team3);

} else if ($_REQUEST["type"] == "getcommonlyusedpersonal" && $_REQUEST["custno"] != "") {
	$CustNo = $_REQUEST["custno"];
	$sql    = "SELECT * FROM commcustomer WHERE custno = %s";
	$ret    = $DB->query($sql, $CustNo);
	echo json_encode($ret);
	exit;
} else if ($_REQUEST["type"] == "addcommonlyuser") {
	$Data = array("custno" => $_REQUEST["custno"], "name" => $_REQUEST["name"], "mobile" => $_REQUEST["mobile"], "zip" => $_REQUEST["zip"], "address" => $_REQUEST["address"], "city" => $_REQUEST["city"],
		"area"                => $_REQUEST["area"]);
	$res = $DB->insert("commcustomer", $Data);
	if ($res) {
		echo json_encode(true);
		exit;
	}
	echo json_encode(false);
	exit;

} else if ($_REQUEST["type"] == "editcommonlyuser") {
	$Data = array("name" => $_REQUEST["name"], "mobile" => $_REQUEST["mobile"], "zip" => $_REQUEST["zip"], "address" => $_REQUEST["address"], "city" => $_REQUEST["city"],
		"area"              => $_REQUEST["area"]);
	$res = $DB->update("commcustomer", $Data, "id=%s", $_REQUEST["id"]);
	if ($res) {
		echo json_encode(true);
		exit;
	}
	echo json_encode(false);
	exit;

} else if ($_REQUEST["type"] == "deletecommonlyuser") {
	$id  = $_REQUEST["id"];
	$res = $DB->delete("commcustomer", "id=%s", $id);
	echo json_encode($res);
	exit;
} else if ($_REQUEST["type"] == "getCard") {
	$CustNo = $_REQUEST["custno"];
	$sql    = "SELECT * FROM commcreditcard WHERE custno = %s";
	$Data   = $DB->query($sql, $CustNo);
	echo json_encode($Data);
	exit;
} else if ($_REQUEST["type"] == "addcommonlycreditcard") {
	$Data = Array("custno" => $_REQUEST["custno"], "cardno" => $_REQUEST["cardno"], "name" => $_REQUEST["name"], "mobile" => $_REQUEST["mobile"], "bank" => $_REQUEST["bank"], "type" => $_REQUEST["cardtype"]);
	$res  = $DB->insert("commcreditcard", $Data);
	echo json_encode($res);
	exit;
} else if ($_REQUEST["type"] == "editcommonlycreditcard") {
	$Data = Array("cardno" => $_REQUEST["cardno"], "name" => $_REQUEST["name"], "mobile" => $_REQUEST["mobile"], "bank" => $_REQUEST["bank"], "type" => $_REQUEST["cardtype"]);
	$id   = $_REQUEST["id"];
	$res  = $DB->update("commcreditcard", $Data, "id=%s", $_REQUEST["id"]);
	echo json_encode($res);
	exit;
} else if ($_REQUEST["type"] == "deletecommonlycredit") {
	$id  = $_REQUEST["id"];
	$res = $DB->delete("commcreditcard", "id=%s", $id);
	echo json_encode($res);
	exit;
} else if ($_REQUEST["type"] == "gettax") {
	$CustNo = $_REQUEST["custno"];
	$sql    = "SELECT * FROM commtax WHERE custno = %s";
	$Data   = $DB->query($sql, $CustNo);
	echo json_encode($Data);
	exit;
} else if ($_REQUEST["type"] == "addcommonlytax") {
	$Data = array("custno" => $_REQUEST["custno"], "taxid" => $_REQUEST["taxid"], "title" => $_REQUEST["title"], "zip" => $_REQUEST["zip"], "address" => $_REQUEST["address"], "city" => $_REQUEST["city"],
		"area"                => $_REQUEST["area"]);
	$res = $DB->insert("commtax", $Data);
	if ($res) {
		echo json_encode(true);
		exit;
	}
	echo json_encode(false);
	exit;

} else if ($_REQUEST["type"] == "editcommonlytax") {
	$Data = array("title" => $_REQUEST["title"], "taxid" => $_REQUEST["taxid"], "zip" => $_REQUEST["zip"], "address" => $_REQUEST["address"], "city" => $_REQUEST["city"],
		"area"               => $_REQUEST["area"]);
	$res = $DB->update("commtax", $Data, "id=%s", $_REQUEST["id"]);
	if ($res) {
		echo json_encode(true);
		exit;
	}
	echo json_encode(false);
	exit;

} else if ($_REQUEST["type"] == "deletecommonlytax") {
	$id  = $_REQUEST["id"];
	$res = $DB->delete("commtax", "id=%s", $id);
	echo json_encode($res);
	exit;
} else if ($_REQUEST["type"] == "do_order") {
	$CustNo       = $_REQUEST["custno"];
	$ShipWayArray = Array("seven_fee", "family_fee", "ok_fee", "hilift_fee", "ship_fee");

	$sql           = "SELECT * FROM customer WHERE custno = %s ";
	$CustData      = $DB->queryFirstRow($sql, $CustNo);
	$TaxInfo       = $_REQUEST["taxinfo"];
	$ProductNoArry = $_REQUEST["productnoarry"];
	//echo json_encode($TaxInfo);
	$Ary = array(
		"order_date" => date("Y-m-d H:i:s"),
		"CustNo"     => $_REQUEST["custno"]?$_REQUEST["custno"]:"",
		"amount"     => $_REQUEST["subtotal"]?$_REQUEST["subtotal"]:"",
		"shipfee"    => $_REQUEST["shopwaypay"]?$_REQUEST["shopwaypay"]:"",
		//"payment_add"=>$_REQUEST["subtotal"]?$_REQUEST["subtotal"]:"",
		"discount" => $_REQUEST["discount"]?$_REQUEST["discount"]:"",
		//"TicketNo"=>$rec_TicketNo?$rec_TicketNo:"",
		"total"     => $_REQUEST["total"]?$_REQUEST["total"]:"",
		"receiver"  => $_REQUEST["r_name"]?$_REQUEST["r_name"]:"",
		"r_TEL"     => $_REQUEST["r_phone"]?$_REQUEST["r_phone"]:"",
		"r_mobile"  => $_REQUEST["r_phone"]?$_REQUEST["r_phone"]:"",
		"r_ZIP"     => $_REQUEST["r_zip"]?$_REQUEST["r_zip"]:"",
		"r_address" => $_REQUEST["r_address"]?$_REQUEST["r_address"]:"",
		"r_email"   => $_REQUEST["email"]?$_REQUEST["email"]:"",
		//"invoice_type"=>$rec_InvoiceType?$rec_InvoiceType:"",
		//"be_invoice"=>$_REQUEST["be_invoice"]?$_REQUEST["be_invoice"]:"",
		"i_banno"   => $TaxInfo["taxid"]?$TaxInfo["taxid"]:"",
		"i_title"   => $TaxInfo["title"]?$TaxInfo["title"]:"",
		"i_address" => $TaxInfo["address"]?$TaxInfo["address"]:"",
		//"memo"=>$rec_Memo?$rec_Memo:"",
		"status" => 0,
		//"against"=>$_SESSION['ShoppingCar']['BonusProduct']?$_SESSION['ShoppingCar']['BonusProduct']:"",
		//"ship_date"=>$rec_ShipDate?$rec_ShipDate:"",
		//"ship_time"=>$rec_ShipTime?$rec_ShipTime:"",
		"ship_way"     => $_REQUEST["shipwaytype"]?$_REQUEST["shipwaytype"]:0,
		"cust_name"    => $CustData["name"]?$CustData["name"]:"",
		"payment"      => $_REQUEST["payment"]?$_REQUEST["payment"]:"",
		"cust_tel"     => $CustData["tel"]?$CustData["tel"]:"",
		"cust_mobile"  => $CustData["mobile"]?$CustData["mobile"]:"",
		"cust_zip"     => $CustData["zip"]?$CustData["zip"]:"",
		"cust_address" => $CustData["address"]?$CustData["address"]:"",
		"CVSStoreID"   => $_REQUEST["CVSStoreID"]?$_REQUEST["CVSStoreID"]:"",
		"CVSAddress"   => $_REQUEST["CVSAddress"]?$_REQUEST["CVSAddress"]:"",
		"CVSStoreName" => $_REQUEST["CVSStoreName"]?$_REQUEST["CVSStoreName"]:"",
		//"pay_type_9_cost"=>$pay_type_9_cost?$pay_type_9_cost:"",
		//"coupon_id"=>$coupon["id"]?$coupon["id"]:"",
		//"coupon_discount"=>$coupon["total"]?$coupon["total"]:"",

	);
	$res = $DB->insert("{$LANG_DB}order", $Ary);
	if ($res != "1") {

		echo json_encode(false);
		exit;

	} else {
		$OrderNo = $DB->insertId();
		$OrderID = date("Ymd")."00A".$OrderNo;
		$DB->update("order", array("orderid" => $OrderID), "orderno=%s", $OrderNo);
		foreach ($ProductNoArry as $key      => $value) {
			$sql = "SELECT * FROM product WHERE productno = %s";

			$PrdouctData = $DB->queryFirstRow($sql, $key);
			$tProduct[]  = $ProductData;
			$dAry        = array(
				"OrderNo"      => $OrderNo,
				"ProductNo"    => $key,
				"product_name" => $PrdouctData["product_name"],
				"ProductID"    => $PrdouctData["ProductID"],
				"price"        => $PrdouctData["price"],
				"quantity"     => $value,
				"amount"       => $PrdouctData["price"]*$value,
				"total"        => $PrdouctData["price"]*$value,

			);
			$DB->insert("{$LANG_DB}order_detail", $dAry);
			$sOrderDetail .=
			$ProductData["product_name"]." * ".$value.", ";
		}
		if ($tProduct) {
			foreach ($tProduct as $key => $value) {
				$Product[$value["ProductNo"]] = $value;
			}
		}
		$res = Array(array($OrderNo, $OrderID), $WebSet);
	}
	if ($_REQUEST["savepersoninfobool"] == "1") {
		$Data = array(
			"custno"  => $CustNo,
			"name"    => $_REQUEST["r_name"]?$_REQUEST["r_name"]:"",
			"mobile"  => $_REQUEST["r_phone"]?$_REQUEST["r_phone"]:"",
			"address" => $_REQUEST["r_address"]?$_REQUEST["r_address"]:"",
			"zip"     => $_REQUEST["r_zip"]?$_REQUEST["r_zip"]:"",
			"city"    => $_REQUEST["r_city"]?$_REQUEST["r_city"]:"",
			"area"    => $_REQUEST["r_area"]?$_REQUEST["r_area"]:"",
		);
		$DB->insert("commcustomer", $Data);
	}
	if ($_REQUEST["savecreditcardinfobool"] == true) {
		$Data = array(
			"custno" => $CustNo,
			"name"   => $_REQUEST["creditname"]?$_REQUEST["creditname"]:"",
			"cardno" => $_REQUEST["creditcardno"]?$_REQUEST["creditcardno"]:"",
			"mobile" => $_REQUEST["creditmobile"]?$_REQUEST["creditmobile"]:"",

		);
		//echo json_encode($Data);
		$DB->insert("commcreditcard", $Data);
	}
	echo json_encode($res);
	exit;
} else if ($_REQUEST["type"] == "updatecustomerdata") {
	$CustNo = $_REQUEST["custno"];
	$Data   = array(
		"name"       => $_REQUEST["name"]?$_REQUEST["name"]:"",
		"sex"        => $_REQUEST["sex"]?$_REQUEST["sex"]:"",
		"birthday"   => $_REQUEST["birthday"]?$_REQUEST["birthday"]:"",
		"email"      => $_REQUEST["email"]?$_REQUEST["email"]:"",
		"county"     => $_REQUEST["city"]?$_REQUEST["city"]:"",
		"district"   => $_REQUEST["area"]?$_REQUEST["area"]:"",
		"zip"        => $_REQUEST["zip"]?$_REQUEST["zip"]:"",
		"mobile"     => $_REQUEST["mobile"]?$_REQUEST["mobile"]:"",
		"tel"        => $_REQUEST["mobile"]?$_REQUEST["mobile"]:"",
		"address"    => $_REQUEST["address"]?$_REQUEST["address"]:"",
		"infostatus" => 1,

	);
	$res = $DB->update("customer", $Data, "custno = %s", $CustNo);
	if ($res) {
		$sql = "SELECT loginid,name,sex,mobile,email,address,infostatus,status,zip,county,district,birthday FROM customer WHERE custno = %s ";
		$rtn = $DB->queryFirstRow($sql, $CustNo);
		echo json_encode($rtn);
		exit;
	} else {
		echo json_encode(false);
	}
	exit;

} else if ($_REQUEST["type"] == "checkpw") {
	$CustNo = $_REQUEST["custno"];
	$sql    = "SELECT * FROM customer WHERE custno = %s and password = %s";
	$data   = $DB->query($sql, $CustNo, $_REQUEST["oldpw"]);
	if ($data) {
		echo json_encode(true);
	} else {
		echo json_encode(false);
	}
	exit;

} else if ($_REQUEST["type"] == "setpw") {
	$CustNo = $_REQUEST["custno"];
	$NewPW  = $_REQUEST["newpw"];
	$Data   = array("password" => $NewPW);
	$res    = $DB->update("customer", $Data, "custno=%s", $CustNo);
	echo json_decode($res);
	exit;
} else if ($_REQUEST["type"] == "siteinfo") {
	$id  = $_REQUEST["id"];
	$sql = "SELECT * FROM site_info WHERE id = %s";
	$res = $DB->queryFirstRow($sql, $id);
	echo json_encode($res);
	exit;
} else if ($_REQUEST["type"] == "checkorder") {
	$CustNo = $_REQUEST["custno"];
	$sql    = "SELECT orderno,orderid,order_date,total,status FROM `order` WHERE custno = %s order by orderno DESC";
	$Data   = $DB->query($sql, $CustNo);

	if ($Data) {
		foreach ($Data as $key => $value) {
			$rArray[]                    = $value["orderno"];
			$rDiction[$value["orderno"]] = $value;
		}

		$res = array("Array" => $rArray, "Diction" => $rDiction);
	}
	echo json_encode($res);
	exit;

} else if ($_REQUEST["type"] == "getorderdetail") {
	$OrderNo = $_REQUEST["orderno"];
	$sql     = "SELECT * FROM `order` WHERE orderno = %s";
	$Order   = $DB->queryFirstRow($sql, $OrderNo);
	if ($Order) {
		$sql    = "SELECT a.*,b.photo_m as photo_m FROM order_detail a left join product b on a.productno = b.productno WHERE a.orderno = %s";
		$Detail = $DB->query($sql, $OrderNo);
	}
	echo json_encode(Array("Data" => $Order, "Detail" => $Detail, "WebSet" => $WebSet));
	exit;
} else if ($_REQUEST["MerchantID"] == "2000214") {

	foreach ($_REQUEST as $key => $value) {
		$str .= $key."=>".$value."||";
	}
	$res     = $DB->insert("log", array("log" => $str));
	$OrderID = $_REQUEST["MerchantTradeNo"];
	$Data    = array(
		"TradeAmt"             => $_REQUEST["TradeAmt"]?$_REQUEST["TradeAmt"]:"",
		"tradedate"            => $_REQUEST["TradeDate"]?$_REQUEST["TradeDate"]:"",
		"tradeno"              => $_REQUEST["auth_code"]?$_REQUEST["auth_code"]:"",
		"paymentdate"          => $_REQUEST["PaymentDate"]?$_REQUEST["PaymentDate"]:"",
		"payamt"               => $_REQUEST["TradeAmt"]?$_REQUEST["TradeAmt"]:"",
		"rtnmsg"               => $_REQUEST["RtnMsg"]?$_REQUEST["RtnMsg"]:"",
		"rtncode"              => $_REQUEST["RtnCode"]?$_REQUEST["RtnCode"]:"",
		"paymenttypechargefee" => $_REQUEST["PaymentTypeChargeFee"]?$_REQUEST["PaymentTypeChargeFee"]:"",
		"notepay"              => 1,
		"status"               => 1,

	);
	$res = $DB->update("order", $Data, "orderid= %s", $OrderID);
	if ($res) {
		echo "1|OK";
	}

	exit;

} else if ($_REQUEST["MerchantTradeNo"] != "") {

	$OrderID = $_REQUEST["MerchantTradeNo"];

	$sql = " Select total From `order` where orderid = %s";

	echo $Total = $DB->queryFirstField($sql, $OrderID);
	exit;
} else if ($_REQUEST["type"] == "notepaysave") {
	$OrderNo = $_REQUEST["orderno"];
	$Ary     = array(
		"notepay"    => "1",
		"name1"      => $_REQUEST['name1']?$_REQUEST['name1']:"",
		"date1"      => $_REQUEST['date1']?$_REQUEST['date1']:"",
		"bank1"      => $_REQUEST['bank1']?$_REQUEST['bank1']:"",
		"payamount"  => $_REQUEST['payamount']?$_REQUEST['payamount']:"",
		"last5"      => $_REQUEST['name1']?$_REQUEST['last5']:"",
		"sysdate"    => DB::sqleval("NOW()"),
		"payed_date" => DB::sqleval("NOW()"),

	);
	$res = $DB->update("order", $Ary, "orderno = %s", $OrderNo);
	echo json_encode($res);
	exit;
} else if ($_REQUEST["type"] == "return" && $_REQUEST["orderno"] != "") {
	$OrderNo = $_REQUEST["orderno"];
	$Ary     = array(
		"status"      => 6,
		"memo_cancel" => $_REQUEST["memo"],
	);
	$res = $DB->update("order", $Ary, "orderno = %s", $OrderNo);
	echo json_encode($res);
	exit;
} else if ($_REQUEST["type"] == "newslist" && $_REQUEST["catno"] != "") {
	$CatNo = $_REQUEST["catno"];
	$sql   = "SELECT * FROM news_category WHERE catno = %s";
	$Data  = $DB->queryFirstRow($sql, $CatNo);
	if ($Data) {
		$sql     = "SELECT * FROM news WHERE CatNo = %s and active_date < NOW() and status = 1 order by priority DESC";
		$tmpData = $DB->query($sql, $CatNo);
		if ($tmpData) {
			foreach ($tmpData as $key => $value) {
				$Ary[]                  = $value["NewsNo"];
				$News[$value["NewsNo"]] = $value;
			}

		}

	}
	echo json_encode(array("Data" => $Data, "NewsAry" => $Ary, "NewsData" => $News));
	exit;
} else if ($_REQUEST["type"] == "newsdetail" && $_REQUEST["newsno"] != "") {
	$NewsNo = $_REQUEST["newsno"];
	$sql    = "SELECT * FROM news WHERE newsno = %s";
	$res    = $DB->queryFirstRow($sql, $NewsNo);
	echo json_encode($res);
	exit;
} else if ($_REQUEST["type"] == "Sale" && $_REQUEST["saleno"] != "") {

	$SaleNo  = $_REQUEST["saleno"];
	$sql     = "SELECT product_name,productno,photo_l,price FROM product WHERE status = 1 and NOW() >= start_date and saleNo = %s order by priority DESC";
	$tmpData = $DB->query($sql, $SaleNo);
	$Array   = array();
	$Data    = array();
	if ($tmpData) {
		foreach ($tmpData as $key => $value) {
			$Array[]                   = $value["productno"];
			$Data[$value["productno"]] = $value;
		}

	}
	$ret["Array"] = $Array;
	$ret["Data"]  = $Data;
	echo json_encode($ret);
	exit;

} else if ($_REQUEST["type"] == "savedevice" && $_REQUEST["id"] != "") {
	$DeviceID = $_REQUEST["id"];

	$sql = " SELECT count(*) as CNT FROM deviceid WHERE deviceid ='$DeviceID' ";

	$cnt = $DB->queryFirstField($sql);

	if (!$cnt && $cnt == 0) {
		$sql = "INSERT INTO deviceid (deviceid) values ('$DeviceID')";

		$res = $DB->query($sql);

		echo json_encode(true);
	} else {
		echo json_encode(false);
	}
	exit;

} else if ($_REQUEST["type"] == "pushall") {
	$DeviceData = $DB->query("SELECT * From deviceid");

	if ($DeviceData) {
		//没有空格

		$ctx = stream_context_create();
		//如果在Windows的服务器上，寻找pem路径会有问题，路径修改成这样的方法：
		//$pem = dirname(__FILE__) . '/' . 'apns-dev.pem';
		//linux 的服务器直接写pem的路径即可
		stream_context_set_option($ctx, "ssl", "local_cert", "ck_p.pem");
		$pass = "54775477";
		stream_context_set_option($ctx, 'ssl', 'passphrase', $pass);
		//此处有两个服务器需要选择，如果是开发测试用，选择第二名sandbox的服务器并使用Dev的pem证书，如果是正是发布，使用Product的pem并选用正式的服务器
		$fp = stream_socket_client("ssl://gateway.push.apple.com:2195", $err, $errstr, 60, STREAM_CLIENT_CONNECT, $ctx);
		//$fp = stream_socket_client("ssl://gateway.sandbox.push.apple.com:2195", $err, $errstr, 60, STREAM_CLIENT_CONNECT, $ctx);

		if (!$fp) {
			echo "Failed to connect $err $errstr";
			return;
		}
		print"Connection OK\n";
		foreach ($DeviceData as $key => $value) {
			$deviceToken = $value["deviceid"];
			$body        = array("aps"          => array("alert"          => urlencode('各位有收到推播嗎？'), "badge"          => $value["num"]+1, "sound"          => 'default'), 'custom_key'          => 'product|80');//推送方式，包含内容和声音
			$DB->update("deviceid", array("num" => $value["num"]+1), "deviceid = %s", $deviceToken);
			$payload = urldecode(json_encode($body));
			$msg     = chr(0).pack("n", 32).pack("H*", str_replace(' ', '', $deviceToken)).pack("n", strlen($payload)).$payload;
			echo "sending message :".$payload."\n";
			fwrite($fp, $msg);
		}

		fclose($fp);
	}

} else if ($_REQUEST["type"] == "pushNotificationUnSet") {
	$DeviceID = $_REQUEST["deviceid"];
	$res      = $DB->update("deviceid", array("num" => 0), "deviceid = %s", $DeviceID);

} else if ($_REQUEST["type"] == "getsetupstatus") {
	$DeviceID = $_REQUEST["deviceid"];
	$sql      = "SELECT * FROM deviceid WHERE deviceid = %s";
	$res      = $DB->queryFirstRow($sql, $DeviceID);
	echo json_encode($res);
	exit;
} else if ($_REQUEST["type"] == "changedevicestatus") {
	$DeviceID        = $_REQUEST["deviceid"];
	$DeviceValueType = $_REQUEST["valuetype"];
	$Value           = $_REQUEST["value"];
	$res             = $DB->update("deviceid", array($DeviceValueType => $Value), "deviceid = %s", $DeviceID);
	echo json_encode($res);
	exit;
} else if ($_REQUEST["type"] == "Message") {
	$CustNo = $_REQUEST["custno"];
	$Num    = $_REQUEST["start"];
	$sql    = "SELECT COUNT(*) as CNT FROM conversation WHERE sendid = %s or getid = %s";
	$CNT    = $DB->queryFirstField($sql, $CustNo, $CustNo);
	if ($Num > $CNT) {
		exit;
	} else if ($CNT-($Num+50) > 0) {
		$Start = $CNT-(50+$Num);
		$End   = 50;
	} else {
		$Start = 0;
		$End   = $CNT-$Num;
	}
	$sql = " SELECT * FROM conversation WHERE sendid = %s or getid = %s limit {$Start},{$End}";

	$res = $DB->query($sql, $CustNo, $CustNo);
	echo json_encode($res);
	exit;
} else if ($_REQUEST["type"] == "updatereadtime") {
	$CustNo = $_REQUEST["custno"];
	$Array  = array("readdatetime" => DB::sqleval("NOW()"), "readstatus" => 1);
	$res    = $DB->update("conversation", $Array, "getid = %s and readdatetime = '0000-00-00 00:00:00'", $CustNo);
	echo json_encode($res);
	exit;
} else if ($_REQUEST["type"] == "sendnewmessage") {
	$CustNo = $_REQUEST["custno"];
	$sql    = "SELECT ios_deviceid FROM customer WHERE custno = %s";

	$IOS_DeviceID = $DB->queryFirstField($sql, $CustNo);
	if (!$IOS_DeviceID || $IOS_DeviceID == "") {
		exit;
	}

	$Data = array(
		"sendid"       => $CustNo,
		"ios_deviceid" => $IOS_DeviceID,
		"senddatetime" => $_REQUEST["senddatetime"],
		"contant"      => $_REQUEST["contant"],
		"sendstatus"   => 1,
	);
	$res = $DB->insert("conversation", $Data);
	echo json_encode($res);
	exit;
} else if ($_REQUEST["type"] == "getCustomerNewMessage") {
	$CustNo = $_REQUEST["custno"];
	$sql    = "SELECT ios_deviceid FROM customer WHERE custno = %s";

	$IOS_DeviceID = $DB->queryFirstField($sql, $CustNo);

	if (!$IOS_DeviceID || $IOS_DeviceID == "") {
		exit;
	}
	$sql = "SELECT * FROM conversation WHERE getid = %s and readstatus = 0";
	$res = $DB->query($sql, $CustNo);
	if ($res) {
		$Data = array(
			"readstatus"   => 1,
			"readdatetime" => DB::sqleval("NOW()"),
		);
		$DB->update("conversation", $Data, "getid = %s and readstatus = 0", $CustNo);
		echo json_encode($res);
		exit;
	}
	echo json_encode($res);
	exit;

} else if ($_REQUEST["type"] == "insert250") {
	for ($i = 0; $i <= 250; $i++) {
		if ($i > 0 && $i%2 == 0) {
			$Data = array(
				"sendid"       => 76,
				"ios_deviceid" => "105CB42AF9A52B3C7F5147E0AE6DBE14EE9966FF9899056FDF272942FE6502B3",
				"senddatetime" => DB::sqleval("NOW()"),
				"contant"      => $i,
				"sendstatus"   => 1,
			);
		} else {
			$Data = array(
				"getid"        => 76,
				"ios_deviceid" => "105CB42AF9A52B3C7F5147E0AE6DBE14EE9966FF9899056FDF272942FE6502B3",
				"senddatetime" => DB::sqleval("NOW()"),
				"contant"      => $i,
				"sendstatus"   => 1,
			);
		}

		$DB->insert("conversation", $Data);

	}

} else if ($_REQUEST["type"] == "deleteNewCustomer") {
	$loginid = $_REQUEST["loginid"];
	$DB->delete("customer", "loginid = %s", $loginid);

}
/*"type":"do_order",

"custno":UserInfoDictionary["CustNo"] as String!,
"r_name":r_name,
"r_phone":r_phone,
"r_city":r_city,
"r_address":r_address,
"r_zip":r_zip,
"total":shoppingCarData.TotalInt,
"payment":shoppingCarData.PaymentInt,
"shopwaypay":shoppingCarData.ShipWayPayInt,
"discount":shoppingCarData.DiscountInt,
//"shopway":shoppingCarData.ShipWayArray[shoppingCarData.ShipWayType],
"shipwaytype":shoppingCarData.ShipWayType,
"subtotal":shoppingCarData.SubTotalInt,
"subtotalafterdiscount":shoppingCarData.SubTotalAfterDiscountInt,
"CVSStoreID":CVSStoreID,
"CVSAddress":CVSAddress,
"CVSStoreName":CVSStoreName,
"productnoarry":tDictionary, */
?>