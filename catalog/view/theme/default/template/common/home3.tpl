<?php echo $header; ?>

<section class="gallery">

    <div class="container">
        <?=$content_top?>

        <div class="row">
            
            <div class="col-md-12">
                
                <div class="title-news">

                    <h2 class="marquee"><span>Ласкаво просимо в інтернет магазин Drive Avto</span></h2>

                    <p class="marquee"><span>Широкий асортимент та низькі ціни</span></p>

                </div><!-- end title-news -->

            </div>

        </div><!-- end row -->

    </div><!-- end container -->
    
</section><!-- end gallery -->

<section class="content">
    
    <div id="banners_left" class="partner-blurb">

    </div><!-- end baner-left -->

    <div class="container">
      <div class="row"><?php echo $column_left; ?>
        <?php if ($column_left && $column_right) { ?>
        <?php $class = 'col-sm-5'; ?>
        <?php } elseif ($column_left || $column_right) { ?>
        <?php $class = 'col-sm-8'; ?>
        <?php } else { ?>
        <?php $class = 'col-sm-12'; ?>
        <?php } ?>
      

            </div><!-- end row -->

            <!--<div class="row">
                <div class="col-md-12">
                    
                    <div class="form-select">
                        
                        <p><span>*</span> - обов'язкові поля</p>

                        <form action="">

                            <article>Назва запчастини: <span>*</span></article>
                            <select name="nameSpare" id="nameSpare">
                                <option value=""></option>
                                <option value="n1">Назва 1</option>
                                <option value="n2">Назва 2</option>
                                <option value="n3">Назва 3</option>
                            </select><br />

                            <article>Група запчастини: <span>*</span></article>
                            <select name="groupSpare" id="groupSpare">
                                <option value=""></option>
                                <option value="g1">Група 1</option>
                                <option value="g2">Група 2</option>
                                <option value="g3">Група 3</option>
                            </select><br />

                            <article>Тип запчастин: <span>*</span></article>
                            <select name="typeSpare" id="typeSpare">
                                <option value=""></option>
                                <option value="t1">Тип 1</option>
                                <option value="t2">Тип 2</option>
                                <option value="t3">Тип 3</option>
                            </select>

                        </form>

                    </div><!-- end form-select --

                </div>

            </div><!-- end row -->

            <div class="row">
                
                <div class="col-md-12">
                    
                    <div class="cars-brand-list">

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/AUDI.png" height="90" width="90" alt="Audi" href="http://driveavto.com.ua/autoparts/audi/" />

                            <a href="http://driveavto.com.ua/autoparts/audi/">Audi</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/BMW.png" height="90" width="90" alt="BMW" />

                            <a href="http://driveavto.com.ua/autoparts/bmw/">BMW</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/CHEVR.png" height="90" width="90" alt="Chevr" />

                            <a href="http://driveavto.com.ua/autoparts/chevrolet/">Chevrolet</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/CITRO.png" height="90" width="90" alt="Citro" />

                            <a href="http://driveavto.com.ua/autoparts/citro%C3%8Bn/">Citroen</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/DAEWOO.png" height="90" width="90" alt="Daewoo" />

                            <a href="http://driveavto.com.ua/autoparts/daewoo/">Daewoo</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/FIAT.png" height="90" width="90" alt="Fiat" />

                            <a href="http://driveavto.com.ua/autoparts/fiat/">Fiat</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/FORD.png" height="90" width="90" alt="Ford" />

                            <a href="http://driveavto.com.ua/autoparts/ford/">Ford</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/HONDA.png" height="90" width="90" alt="Honda" />

                            <a href="http://driveavto.com.ua/autoparts/honda/">Honda</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/HYUNDAI.png" height="90" width="90" alt="Hyundai" />

                            <a href="http://driveavto.com.ua/autoparts/hyundai/">Hyundai</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/KIA.png" height="90" width="90" alt="KIA" />

                            <a href="http://driveavto.com.ua/autoparts/kia/">KIA</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/MAZDA.png" height="90" width="90" alt="Mazda" />

                            <a href="http://driveavto.com.ua/autoparts/mazda/">Mazda</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/MERCE.png" height="90" width="90" alt="Merce" />

                            <a href="http://driveavto.com.ua/autoparts/mercedes-benz/">Mercedes</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/MITSUBISHI.png" height="90" width="90" alt="Mitsubishi" />

                            <a href="http://driveavto.com.ua/autoparts/mitsubishi/">Mitsubishi</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/NISSA.png" height="90" width="90" alt="Nissa" />

                            <a href="http://driveavto.com.ua/autoparts/nissan/">Nissan</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/OPEL.png" height="90" width="90" alt="Opel" />

                            <a href="http://driveavto.com.ua/autoparts/opel/">Opel</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/PEUGE.png" height="90" width="90" alt="Peuge" />

                            <a href="http://driveavto.com.ua/autoparts/peugeot/">Peugeot</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/RENAU.png" height="90" width="90" alt="Renau" />

                            <a href="http://driveavto.com.ua/autoparts/renault/">Renault</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/SEAT.png" height="90" width="90" alt="Seat" />

                            <a href="http://driveavto.com.ua/autoparts/seat/">Seat</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/SKODA.png" height="90" width="90" alt="Skoda" />

                            <a href="http://driveavto.com.ua/autoparts/skoda/">Skoda</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/SUBAR.png" height="90" width="90" alt="Subar" />

                            <a href="http://driveavto.com.ua/autoparts/subaru/">Subaru</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/SUZUK.png" height="90" width="90" alt="Suzuk" />

                            <a href="http://driveavto.com.ua/autoparts/suzuki/">Suzuki</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/TOYOT.png" height="90" width="90" alt="Toyota" />

                            <a href="http://driveavto.com.ua/autoparts/toyota/">Toyota</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/VW.png" height="90" width="90" alt="VW" />

                            <a href="http://driveavto.com.ua/autoparts/vw/">VW</a>
                            
                        </div><!-- end brand-item -->
						 <div class="brand-item">

                            <img src="catalog/view/theme/default/image/ar.png" height="90" width="90" alt="ar" />

                            <a href="http://driveavto.com.ua/autoparts/">Все модели</a>
                            
                        </div><!-- end brand-item --
                        <br/>
                    </div><!-- end cars-brand-list -->

                </div>

            </div><!-- end row -->

        </div>
        <?php echo $column_right; ?></div>
    </div>
    <div id="banners_right" class="partner-blurb">
       
    </div><!-- end baner-right -->
</section><!-- end content -->
<div class="container">
<?php echo $content_bottom; ?>
</div>
<section class="online-order">
    <div class="container">
        
        <div class="row">
            
            <div class="col-md-8 col-md-offset-4">
                
                <div class="soc-list">

                    <span>Ми в соціальних мережах</span>
                    
                    <a href="https://twitter.com/driveauto11"></a>
                    <a href="https://www.facebook.com/profile.php?id=100011932722097"></a>
                    <a href="http://ok.ru/group/54034994102517  "></a>
                    <a href="http://vk.com/drive_auto1  "></a>

                </div><!-- end soc-list -->

            </div>

        </div><!-- end row -->

        <div class="row">
            
            <div class="col-md-12">
                
                <div class="footer-block-list">
                    
                    <a href="#" class="footer-block">
                    </a><!-- end footer-block -->

                    <a href="#" class="footer-block">
                    </a><!-- end footer-block -->

                    <a href="#" class="footer-block">
                    </a><!-- end footer-block -->

                    <a href="#" class="footer-block">
                    </a><!-- end footer-block -->

                    <a href="#" class="footer-block">
                    </a><!-- end footer-block -->

                    <a href="#" class="footer-block">
                    </a><!-- end footer-block -->

                </div><!-- end footer-block-list -->

            </div>

        </div><!-- end row -->

    </div><!-- end container -->

<div class="online">
    
    <a href="#" class="fancybox" id="order-online">Замовлення online</a>

</div><!-- end online -->
    
</section><!-- end online-order -->

<?php echo $footer; ?>
