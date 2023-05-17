<?php $row_inherit_start = $row_inherit_end = '';
include 'view/system/row_inherit.php' ?>

<?php if (isset($data[$ID])) : ?>
    <?php foreach ($data[$ID] as $k => $v) : ?>
        <?php echo $row_inherit_start ?>
        <?php if ($v['pic1'] != '') : ?>
            <a href="javascript:;">
                <div class="itemImg img-rectangle itemImgHover hoverEffect1">
                    <img src="_i/assets/upload/<?php echo $this->data['router_method'] ?>/<?php echo $v['pic1'] ?>" alt="<?php echo $v['name'] ?>" onerror="javascript:this.src='images_v4/default.png';img.onerror=null;">
                </div>
            </a>
        <?php endif ?>
        <div class="subBlockTitle"><?php echo $v['name'] ?></div>
        <ul class="listStyle_faicon">
            <li><i class="fa fa-map-marker" aria-hidden="true"></i><a href="<?php echo $v['address_url'] ?>" target="_blank"><?php echo $v['url1'] ?></a></li>
            <?php if (isset($v['phone']) and $v['phone'] != '') : ?><li><i class="fa fa-phone" aria-hidden="true"></i><?php echo $v['phone'] ?></li><?php endif ?>
            <?php if (isset($v['fax']) and $v['fax'] != '') : ?><li><i class="fa fa-fax" aria-hidden="true"></i><?php echo $v['fax'] ?></li><?php endif ?>
            <?php if (isset($v['email']) and $v['email'] != '') : ?><li><i class="fa fa-envelope" aria-hidden="true"></i><a href="<?php echo $v['email_url'] ?>"><?php echo $v['email'] ?></a></li><?php endif ?>
            <?php if (isset($v['website_url']) and $v['website_url'] != '') : ?><li><i class="fa fa-external-link-square" aria-hidden="true"></i><a href="<?php echo $v['website_url'] ?>" target="_blank"><?php echo $v['website_url'] ?></a></li><?php endif ?>
        </ul>
        <?php echo $row_inherit_end ?>
    <?php endforeach ?>
<?php endif ?>

<?php if (1) : //下面為新增的區塊，有需要的時候再處理
?>

    <div class="locationContent locationContent_2">

        <div class=" sbb">
            <div class="row dist-wrap">

                <div class="col-12 col-lg-6">
                    <div class="dist-item">
                        <div class="dist-header">
                            <h6 class="fz-C">INDIA</h6>
                        </div>
                        <ul>
                            <li> <span class="field">公司</span> <span class="value">RAVIK</span> </li>

                            <li> <span class="field">住址</span> <span class="value">111/9, Kishangarh,Aruna Asaf Ali Marg,OPP. B-4, Vasant Kunj,New Delhi – 110070, INDIA</span> </li>

                            <li> <span class="field">電話</span> <span class="value"><a href="mailto:+91 9310272262">+91 9310272262</a></span> </li>

                            <li>
                                <a href="https://www.buyersline.com.tw/" class="link small" target="_blank">
                                    <div class="link_content">
                                        <div>前往官網</div>
                                    </div>
                                    <div class="link_mark">
                                        <i class="fa fa-arrow-right link_arrow_1" aria-hidden="true"></i>
                                        <i class="fa fa-arrow-right link_arrow_2" aria-hidden="true"></i>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="dist-item">
                        <div class="dist-header">
                            <h6 class="fz-C">INDONESIA</h6>
                        </div>
                        <ul>
                            <li> <span class="field">公司</span> <span class="value">OTANO MULTI MESINDO</span> </li>

                            <li> <span class="field">住址</span> <span class="value">Ruko Pulogadung Trade Center Blok 8A No 22</span> </li>

                            <li> <span class="field">電話</span> <span class="value"><a href="mailto:(+62) 21 4619808">(+62) 21 4619808</a></span> </li>

                            <li>
                                <a href="https://www.buyersline.com.tw/" class="link small" target="_blank">
                                    <div class="link_content">
                                        <div>前往官網</div>
                                    </div>
                                    <div class="link_mark">
                                        <i class="fa fa-arrow-right link_arrow_1" aria-hidden="true"></i>
                                        <i class="fa fa-arrow-right link_arrow_2" aria-hidden="true"></i>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="dist-item">
                        <div class="dist-header">
                            <h6 class="fz-C">JAPAN ( CUTTING )</h6>
                        </div>
                        <ul>
                            <li> <span class="field">公司</span> <span class="value">TANITEC</span> </li>

                            <li> <span class="field">住址</span> <span class="value">Industrial Park,Kamaidani 21-30, Iwayama,Ujit- awaracho,Tsuzukigun,Kyoto,610-0261 Japan</span> </li>

                            <li> <span class="field">電話</span> <span class="value"><a href="mailto:0774-88-5001">0774-88-5001</a></span> </li>

                            <li>
                                <a href="https://www.buyersline.com.tw/" class="link small" target="_blank">
                                    <div class="link_content">
                                        <div>前往官網</div>
                                    </div>
                                    <div class="link_mark">
                                        <i class="fa fa-arrow-right link_arrow_1" aria-hidden="true"></i>
                                        <i class="fa fa-arrow-right link_arrow_2" aria-hidden="true"></i>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="dist-item">
                        <div class="dist-header">
                            <h6 class="fz-C">JAPAN ( BENDING + LASER )</h6>
                        </div>
                        <ul>
                            <li> <span class="field">公司</span> <span class="value">LIN FINETECH Co.,Ltd.</span> </li>

                            <li> <span class="field">住址</span> <span class="value">( Office ) <br>1F ALCAZAR,3-31-5 YOYOGI SHIBUYA-KU,TOKYO #151-0053 JAPAN<br><br>( TOKYO SHOWROOM )<br>132-132 NANAE TOMISATO CITY CHIBA #286-0221 JAPAN</span> </li>

                            <li> <span class="field">電話</span> <span class="value"><a href="mailto:+81-3-3370-1428">+81-3-3370-1428</a></span> </li>

                            <li>
                                <a href="https://www.buyersline.com.tw/" class="link small" target="_blank">
                                    <div class="link_content">
                                        <div>前往官網</div>
                                    </div>
                                    <div class="link_mark">
                                        <i class="fa fa-arrow-right link_arrow_1" aria-hidden="true"></i>
                                        <i class="fa fa-arrow-right link_arrow_2" aria-hidden="true"></i>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="dist-item">
                        <div class="dist-header">
                            <h6 class="fz-C">KOREA</h6>
                        </div>
                        <ul>
                            <li> <span class="field">公司</span> <span class="value">K &amp; R</span> </li>

                            <li> <span class="field">住址</span> <span class="value">266 Deokbongseowon-ro, Gongdo-eup, Anseong, Gyeonggi-do, KOREA</span> </li>

                            <li> <span class="field">電話</span> <span class="value"><a href="mailto:266 Deokbongseowon-ro, Gongdo-eup, Anseong, Gyeonggi-do, KOREA">266 Deokbongseowon-ro, Gongdo-eup, Anseong, Gyeonggi-do, KOREA</a></span> </li>

                            <li>
                                <a href="https://www.buyersline.com.tw/" class="link small" target="_blank">
                                    <div class="link_content">
                                        <div>前往官網</div>
                                    </div>
                                    <div class="link_mark">
                                        <i class="fa fa-arrow-right link_arrow_1" aria-hidden="true"></i>
                                        <i class="fa fa-arrow-right link_arrow_2" aria-hidden="true"></i>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="dist-item">
                        <div class="dist-header">
                            <h6 class="fz-C">MALASYSIA</h6>
                        </div>
                        <ul>
                            <li> <span class="field">公司</span> <span class="value">DOSOCO</span> </li>

                            <li> <span class="field">住址</span> <span class="value">No. 15, Jalan Pengeluaran U1/78, Taman Perindustrian Batu Tiga, 40000 Shah Alam, Selangor Darul Ehsan, Malaysia</span> </li>

                            <li> <span class="field">電話</span> <span class="value"><a href="mailto:603-5510-7072">603-5510-7072</a></span> </li>

                            <li>
                                <a href="https://www.buyersline.com.tw/" class="link small" target="_blank">
                                    <div class="link_content">
                                        <div>前往官網</div>
                                    </div>
                                    <div class="link_mark">
                                        <i class="fa fa-arrow-right link_arrow_1" aria-hidden="true"></i>
                                        <i class="fa fa-arrow-right link_arrow_2" aria-hidden="true"></i>
                                    </div>
                                </a>
                            </li>
                            </li>
                        </ul>
                    </div>
                    <div class="dist-item">
                        <div class="dist-header">
                            <h6 class="fz-C">SINGAPORE</h6>
                        </div>
                        <ul>
                            <li> <span class="field">公司</span> <span class="value">DOSOCO</span> </li>

                            <li> <span class="field">住址</span> <span class="value">No. 15, Jalan Pengeluaran U1/78, Taman Perindustrian Batu Tiga, 40000 Shah Alam, Selangor Darul Ehsan, Malaysia</span> </li>

                            <li> <span class="field">電話</span> <span class="value"><a href="mailto:603-5510-7072">603-5510-7072</a></span> </li>

                            <li>
                                <a href="https://www.buyersline.com.tw/" class="link small" target="_blank">
                                    <div class="link_content">
                                        <div>前往官網</div>
                                    </div>
                                    <div class="link_mark">
                                        <i class="fa fa-arrow-right link_arrow_1" aria-hidden="true"></i>
                                        <i class="fa fa-arrow-right link_arrow_2" aria-hidden="true"></i>
                                    </div>
                                </a>
                            </li>
                            </li>
                        </ul>
                    </div>
                    <div class="dist-item">
                        <div class="dist-header">
                            <h6 class="fz-C">THAILAND</h6>
                        </div>
                        <ul>
                            <li> <span class="field">公司</span> <span class="value">THAISAKOL GROUP</span> </li>

                            <li> <span class="field">住址</span> <span class="value">14 Krungthep-Krita Road Thapchang, Sapansoong Bangkok 10250 Thailand</span> </li>

                            <li> <span class="field">電話</span> <span class="value"><a href="mailto:(662)736-0888">(662)736-0888</a></span> </li>

                            <li>
                                <a href="https://www.buyersline.com.tw/" class="link small" target="_blank">
                                    <div class="link_content">
                                        <div>前往官網</div>
                                    </div>
                                    <div class="link_mark">
                                        <i class="fa fa-arrow-right link_arrow_1" aria-hidden="true"></i>
                                        <i class="fa fa-arrow-right link_arrow_2" aria-hidden="true"></i>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="dist-item">
                        <div class="dist-header">
                            <h6 class="fz-C">VIETNAM</h6>
                        </div>
                        <ul>
                            <li> <span class="field">公司</span> <span class="value">TRI VIET</span> </li>

                            <li> <span class="field">住址</span> <span class="value">2829/3B 1A - An Phu Dong Ward - District 12 - HCMC</span> </li>

                            <li> <span class="field">電話</span> <span class="value"><a href="mailto:(08) 3719 8641">(08) 3719 8641</a></span> </li>

                            <li>
                                <a href="https://www.buyersline.com.tw/" class="link small" target="_blank">
                                    <div class="link_content">
                                        <div>前往官網</div>
                                    </div>
                                    <div class="link_mark">
                                        <i class="fa fa-arrow-right link_arrow_1" aria-hidden="true"></i>
                                        <i class="fa fa-arrow-right link_arrow_2" aria-hidden="true"></i>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- .locationContent -->

<?php endif ?>