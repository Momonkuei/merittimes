<?
    header("Cache-Control:private");
    $sqltext="is_enable=1 and ml_key=:ml_key";
    $sqlarray=array(':ml_key'=>$this->data['ml_key']);
    if(!empty($_GET["type"])){
        $_SESSION["sqltext"]="";
        $_SESSION["sqlarray"]="";
        if($_GET["type"]=="ishome"){
            $sqltext.=" and is_home = '1' ";
        }
        if($_GET["type"]=="ishome2"){
            $sqltext.=" and is_home_2 = '1' ";
        }
        if($_GET["type"]=="ishome3"){
            $sqltext.=" and is_home_3 = '1' ";
        }
    }
    if(!empty($_POST["sendtag"])){
        $sendtag=$_POST["sendtag"];
    }
    if(!empty($_POST["sendtagcode"])){
        $_SESSION["sqltext"]="";
        $_SESSION["sqlarray"]="";
        $sendtagcode=$_POST["sendtagcode"];
        $sqltext.=" and other6 like :other6";
        $sqlarray[":other6"]="%".$sendtagcode.",%";
    }
    if(!empty($_GET["searchtext"])){
        $_SESSION["sqltext"]="";
        $_SESSION["sqlarray"]="";
        $searchtext=$_GET["searchtext"];
        if(strpos($searchtext," ")){
            $expsearchtext=explode(" ",$searchtext);
            $sqltext.=" and (";
            $expcnt=0;
            foreach($expsearchtext as $expkey =>$expsearchtexts){
                if(!empty($expsearchtexts)){
                    if($expcnt==0){
                        $sqltext.="(name like :name_".$expkey." OR other5 like :other5_".$expkey.")";
                    }
                    else{
                        $sqltext.=" OR (name like :name_".$expkey." OR other5 like :other5_".$expkey.")";
                    }
                    $sqlarray[":name_".$expkey]="%".$expsearchtexts."%";
                    $sqlarray[":other5_".$expkey]="%".$expsearchtexts."%";
                    $expcnt+=1;
                }
            }
            $sqltext.=" ) ";
        }
        else{
            $sqltext.=" and (name like :name OR other5 like :other5)";
            $sqlarray[":name"]="%".$searchtext."%";
            $sqlarray[":other5"]="%".$searchtext."%";
        }
        
    }
    if(empty($_SESSION["sqltext"]) && empty($_SESSION["sqlarray"])){
        $_SESSION["sqltext"]=$sqltext;
        $_SESSION["sqlarray"]=$sqlarray;    
    }

    // $product_page = $this->db->createCommand()->from('html')->where('type="csrnews" AND is_enable=1')->order('sort_id asc')->queryAll();
    $product_page = $this->db->createCommand()->from('product')->where($_SESSION["sqltext"] ,$_SESSION["sqlarray"])->order('sort_id asc')->queryAll();
		$totalcount=count($product_page);
		$prev_url="";
		$next_url="";
		$per_page=12;//多少筆一頁
		$totalpage=ceil($totalcount/$per_page);
		if(empty($_SESSION["nowpage"])){
			$_SESSION["nowpage"]=1;
		}
		else{
			if(!empty($_GET["page"])){
				$_SESSION["nowpage"]=intval($_GET["page"]);
			}
			else{
				$_SESSION["nowpage"]=1;
			}
		}
		$nowpage=$_SESSION["nowpage"];
		$offsetpage=($nowpage-1)*$per_page;
		if($nowpage>1){
			$lastnum=$nowpage-1;
			if($lastnum==1){
				$prev_url="searchpage_".$this->data['ml_key'].".php";
			}
			else{
				$prev_url="searchpage_".$this->data['ml_key'].".php?page=".$lastnum;
			}
			
		}
		if($nowpage<$totalpage){
			$nextnum=$nowpage+1;
			$next_url="searchpage_".$this->data['ml_key'].".php?page=".$nextnum;
		}

    $searchresult = $this->db->createCommand()->from('product')->where($_SESSION["sqltext"] ,$_SESSION["sqlarray"])->limit($per_page)->offset($offsetpage)->order('sort_id asc')->queryAll();
    // $searchresult = $this->cidb->where($_SESSION["sqltext"],$_SESSION["sqlarray"])->order_by('sort_id asc')->limit($per_page,$offsetpage)->get('product')->result_array();
    if(!empty($searchresult)){
        // echo '<div class="row ">';
        echo '
        <div class="indexBox03 ">
        <div class="container">
            <div class="row v4_animate fadeUp delay_03">
                <div class="productListBlock productListStyle11">	
        ';
        $pidnew=array();
        foreach($searchresult as $searchresults){
            $pid=explode(",",$searchresults["class_ids"]);
            foreach($pid as $pids){
                if(!empty($pids)){
                    $pidnew[]=$pids;
                }
                if(empty($pidnew[0])){
                    $pidnew[0]=$searchresults["class_id"];
                }
            }
            echo '
                <div class="col-lg-3 col-sm-6 proItem">
                    <div class="proItemBorder">
                        <a class="proImgBox" href="productdetail_tw.php?id='.$searchresults["id"].'&pid='.$pidnew[0].'">
                            <div class="itemImg itemImgHover hoverEffect1">
                                    <img src="_i/assets/upload/product/'.$searchresults["pic1"].'" alt="">
                            </div>
                        </a>
                        <div class="productBrief text-center">
                            <p class="subBlockTxt">'.$searchresults["name"].'</p>
                            <div class="subBlockTitle">'.$searchresults["detail"].'</div>
                        </div>
                    </div>
                </div>
            ';
        }
        echo '</div></div></div></div>';
        ?>
        <div class="pageNumber col-12">
        <ul>
                <?php if($prev_url != ""):?>
                    <li class="prev"><a href="<?php echo $prev_url?>"><?php echo t('Prev','en')?></a></li>
                <?php else:?>
                    <li class="prev disabled"><a href="javascript:;"><?php echo t('Prev','en')?></a></li>
                <?php endif?>
            <li><?php echo $nowpage?></li>
            <li>/</li>
            <li><?php echo $totalpage?></li>
                <?php if($next_url != ""):?>
                    <li class="next"><a href="<?php echo $next_url?>"><?php echo t('Next','en')?></a></li>
                <?php else:?>
                    <li class="next disabled"><a href="javascript:;"><?php echo t('Next','en')?></a></li>
                <?php endif?>
        </ul>
        </div><!-- .pageNumber -->
        
    <?}
    else{
        echo '<div class="col-12 text-center ">查無結果</div>';
    }
    
?>
