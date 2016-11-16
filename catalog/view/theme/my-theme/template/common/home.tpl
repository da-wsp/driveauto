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
        <div id="content" class="<?php echo $class; ?>"><div id="search" class="search">
<button type="search"></button>
<input name="search" type="search" value="<?=$GLOBALS['search']['search']?>" placeholder="<?=$GLOBALS['search']['text_search']?>">
</div><div class="row">

                <div class="top-block-list">

                    <div class=" block block-one">

                        <span>Каталоги<br > оригінальних<br /> запчастин</span>
                            
                        <a href="#">Перейти до каталогів</a>

                    </div><!-- end block-one -->

                    <div class=" block block-two">

                        <article>Запит по <span>VIN</span></article>

                        <p>17 значний vin, або номер<br /> кузова для японського авто</p>
                            
                        <a href="#" class="fancybox">Відправити запит</a>

                    </div><!-- end block-two -->

                </div><!-- end top-block-list -->

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

                            <img src="catalog/view/theme/my-theme/image/car-brands/6.jpg" height="90" width="90" alt="AC" />

                            <a href="http://test2.da-wsp.com.ua/index.php?route=product/category&path=108_106">AC</a>
                           </div>
                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/AUDI.png" height="90" width="90" alt="Audi" />

                            <a href="#">Audi</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/BMW.png" height="90" width="90" alt="BMW" />

                            <a href="#">BMW</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/CHEVR.png" height="90" width="90" alt="Chevr" />

                            <a href="#">Chevr</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/CITRO.png" height="90" width="90" alt="Citro" />

                            <a href="#">Citro</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/DAEWOO.png" height="90" width="90" alt="Daewoo" />

                            <a href="#">Daewoo</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/FIAT.png" height="90" width="90" alt="Fiat" />

                            <a href="#">Fiat</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/FORD.png" height="90" width="90" alt="Ford" />

                            <a href="#">Ford</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/HONDA.png" height="90" width="90" alt="Honda" />

                            <a href="#">Honda</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/HYUNDAI.png" height="90" width="90" alt="Hyundai" />

                            <a href="#">Hyundai</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/KIA.png" height="90" width="90" alt="KIA" />

                            <a href="#">KIA</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/MAZDA.png" height="90" width="90" alt="Mazda" />

                            <a href="#">Mazda</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/MERCE.png" height="90" width="90" alt="Merce" />

                            <a href="#">Merce</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/MITSUBISHI.png" height="90" width="90" alt="Mitsubishi" />

                            <a href="#">Mitsubishi</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/NISSA.png" height="90" width="90" alt="Nissa" />

                            <a href="#">Nissa</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/OPEL.png" height="90" width="90" alt="Opel" />

                            <a href="#">Opel</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/PEUGE.png" height="90" width="90" alt="Peuge" />

                            <a href="#">Peuge</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/RENAU.png" height="90" width="90" alt="Renau" />

                            <a href="#">Renau</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/SEAT.png" height="90" width="90" alt="Seat" />

                            <a href="#">Seat</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/SKODA.png" height="90" width="90" alt="Skoda" />

                            <a href="#">Skoda</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/SUBAR.png" height="90" width="90" alt="Subar" />

                            <a href="#">Subar</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/SUZUK.png" height="90" width="90" alt="Suzuk" />

                            <a href="#">Suzuk</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/TOYOT.png" height="90" width="90" alt="Toyota" />

                            <a href="#">Toyota</a>
                            
                        </div><!-- end brand-item -->

                        <div class="brand-item">

                            <img src="catalog/view/theme/my-theme/image/car-brands/VW.png" height="90" width="90" alt="VW" />

                            <a href="#">VW</a>
                            
                        </div><!-- end brand-item -->
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
                    
                    <a href="#"></a>
                    <a href="#"></a>
                    <a href="#"></a>
                    <a href="#"></a>

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