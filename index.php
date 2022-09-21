<?php
    include './Helpers/includes/autoloader.inc.php';
?>

<!DOCTYPE html>

<html lang="LV">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="grid.css" />
    <title>Filips Babris</title>
</head>

<body>

    <header class="site-header">
        <div class="container home_container">
            <div class="menu_toggle open">
                <svg
                    viewBox="0 0 100 80" 
                    width="40" 
                    height="40"
                    >
                    <use xlink:href="defs.svg#hamburger"></use>
                </svg>
            </div>
            <div class="row">
                <div class="col7 spacer"></div>
                <div class="col5 menu hidden" id="menu_mobile">
                    <nav class="menu_items closed" id="menu_items">
                        <a href="#home" class="active navHome">Par mani</a>
                        <a href="#skills" class="navSkills">Prasmes</a>
                        <a href="#portfolio" class="navPortfolio">Portfolio</a>
                        <a href="#contact" class="navContact">Sazināties</a>
                    </nav>
                </div>
            </div>

            <div id="nav-wrapper" class="row hidden">
                <nav class="menu_items col12" id="menu_scrolldown">
                    <a href="#home" class="active navHome">Par mani</a>
                    <a href="#skills" class="navSkills">Prasmes</a>
                    <a href="#portfolio" class="navPortfolio">Portfolio</a>
                    <a href="#contact" class="navContact">Sazināties</a>
                </nav>
            </div>

        </div>
    </header>

    <section class="section" id="home">
        <div class="container home">
            <div class="row home_menu">
                <div class="col12">
                    <nav class="menu_items" id="menu_pc">
                        <a href="#home" class="active">Par mani</a>
                        <a href="#skills">Prasmes</a>
                        <a href="#portfolio">Portfolio</a>
                        <a href="#contact">Sazināties</a>
                    </nav>
                </div>
            </div>

            <div class="row">
                <div class="col6 home_text">
                    <div class="home_centering">
                        <header class = "section-header" id="home_header">
                            <h2 class="home_title">Sveicināti, esmu</h2>
                        </header> 
                        <h1 class="home_name">Filips Babris</h1>
                        <p class="home_occupation">Topošais Front-end/ Back-end Izstrādātājs</p>
                        <div class="home_icons">
                            <a href="mailto: fbabris2@gmail.com" class="home__icons" id="email">
                                <svg
                                    width="35"
                                    height="35"
                                    viewBox="0 0 38 36"
                                    >
                                    <use xlink:href="defs.svg#email"></use>
                                </svg>
                            </a>
                            <a href="https://github.com/fbabris" class="home__icons" id="github">
                                <svg
                                    width="35" 
                                    height="35"
                                    viewBox="0 0 35 35"                      
                                    >
                                    <use xlink:href="defs.svg#github"></use>
                                </svg>                    
                            </a>
                            <a href="https://www.linkedin.com/in/filips-babris-6a254b111/" class="home__icons" id="linkedin">
                                <svg
                                    width="35" 
                                    height="35"
                                    viewBox="0 0 24 24"
                                    >
                                    <use xlink:href="defs.svg#in"></use>
                                </svg>
                            </a>
                        </div>
                    </div>

                </div>
                <div class="col6">
                    <img class="home_photo" src="./img/myphoto.png" alt="">
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container review">

            <div class="row" id="review_row"></div>
            
            <template id="review">
                <div class="col4">
                    <img src="#" alt="" id="img1">
                    <p class="review_name"></p>
                    <p class="review_text"></p>
                    <p class="review_date"></p>
                </div>
            </template> 

            <div class="row">
                <div class="col12 open review_btn">
                    <a href="#">+</a> 
                </div>
            </div>

            <div class="row hidden" id="review_container">
                <form class='col12 closed' id="review_form">
                    <div><input type="text" placeholder="Vārds, Uzvārds*" name="name" required></div>
                    <div><input type="email" placeholder="e-pasta adrese*" name="email" required></div>
                    <div><textarea id="review" name="review" placeholder='Atsauksme*' required></textarea></div>
                    <div><button class="button" onclick="document.getElementById('profile_picture').click()">Pievienot profila attēlu</button></div>
                    <div><input type="file" name="picture" id="profile_picture" style="display:none"></div> 
                    <div style="display: none;"><input type='hidden' name='review-url' placeholder="URL"></div>
                    <div><input class="button" type="submit" value="Iesniegt atsauksmi" id="review_submit"></div>
                    <div class='hidden' id="review_status"><p id="review_servermsg"></p></div>
                    <div><button class='button' id="review_close" onclick="closeReview()">Aizvērt</button></div>
                    <div id="rev_status_messages"><p id="rev_server_message"></p></div>
                    </form>
            </div>

        <div>
    </section>

    <section class="section" id="skills">
        <div class="container skills">
            <div class="row">
                <div class="col12">
                    <header class="section-header">
                        <h1 class="section-title">Prasmes</h1>
                    </header>
                </div>
            </div>
            <div class="row">
                <div class="col12 skills_header">
                    <h4 id="first_skills_header">Protu pielietot:</h4>
                </div>
            </div>
            <div class="row">
                <div class="col4 center">
                    <svg 
                        viewBox="0 0 85 100"
                        width="85" 
                        height="100">                             
                        <use xlink:href="defs.svg#HTML5"></use> 
                    </svg>
                    <p class="skills_names">HTML5</p>
                </div>
                <div class="col4 center">
                    <svg
                        viewBox="0 0 85 100"
                        width="85"
                        height="100">
                        <use xlink:href="defs.svg#CSS3"></use>
                    </svg>
                    <p class="skills_names">CSS3</p>
                </div>
                <div class="col4 center">
                    <svg             
                        width="128" 
                        height="100" 
                        viewBox="0 0 128 100">
                        <use xlink:href="defs.svg#SASS"></use>
                    </svg>
                    <p class="skills_names">SASS</p>
                </div>
                <div class="col4 center">
                    <svg             
                        width="100" 
                        height="100" 
                        viewBox="0 0 97 100">                         
                        <use xlink:href="defs.svg#JS"></use>
                    </svg>
                    <p class="skills_names">JAVASCRIPT</p>
                </div>
                <div class="col4 center">
                    <svg             
                        width="100" 
                        height="100" 
                        viewBox="0 0 97 100">                         
                        <use xlink:href="defs.svg#BS"></use>
                    </svg> 
                    <p class="skills_names">BOOTSTRAP</p>
                </div>
                <div class="col4 center">
                    <svg             
                        width="100" 
                        height="100"
                        viewBox="0 0 48 48">                         
                        <use xlink:href="defs.svg#GIT"></use>
                    </svg> 
                    <p class="skills_names">GIT</p>
                </div>
                <div class="col4 center">
                    <svg             
                        width="70" 
                        height="100" 
                        viewBox="0 0 70 100">                         
                        <use xlink:href="defs.svg#FIGMA"></use>
                    </svg> 
                    <p class="skills_names">FIGMA</p>
                </div>
            </div>

            <div class="row">
                <div class="col12 skills_header">
                    <h4>Pašlaik apgūstu:</h4>
                </div>
            </div>
            <div class="row">
                <div class="col4 center">
                    <svg 
                        viewBox="0 0 86 100" 
                        width="100px" 
                        height="100px">                         
                        <use xlink:href="defs.svg#nodejs"></use>
                    </svg>  
                    <p class="skills_names">NODEJS</p>
                </div>
                <div class="col4 center">
                    <svg 
                        viewBox="0 0 103 100" 
                        height="100px" 
                        width="100px">                         
                        <use xlink:href="defs.svg#mysql"></use>
                    </svg> 
                    <p class="skills_names">MYSQL</p>
                </div>
                <div class="col4 center">
                    <svg viewBox="0 0 563 563" width="100px" height="100px">                         
                        <use xlink:href="defs.svg#php"></use>
                    </svg> 
                    <p class="skills_names">PHP</p>
                </div>
            </div>

            <div class="row">
                <div class="col12 skills_header">
                    <h4>Citas prasmes:</h4>
                </div>
            </div>
            <div class="row">
                <div class="col4 center">
                    <img src="./img/flageng.png" />                    
                    <p class="skills_names">ENG</p>
                </div>
                <div class="col4 center">
                    <img src="./img/flagru.png" /> 
                    <p class="skills_names">RU</p>
                </div>
                <div class="col4 center">
                    <img src="./img/flaglv.png" />                    
                    <p class="skills_names">LV</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="portfolio">
        <div class="container portfolio">
            <div class="row">
                <div class="col12">
                    <header class="section-header portfolio-header">
                        <h1 class="section-title">Portfolio</h1>                   
                    </header>
                </div>
            </div>
        
            <div class="row">
                <div class="col12">
                    <nav class="portfolio_nav">
                        <a href="#portfolio" class="active" onclick="setActiveSlide('slide1')">visi</a>
                        <a href="#portfolio" onclick="setActiveSlide('slide2')">grafiskais dizains</a>
                        <a href="#portfolio" onclick="setActiveSlide('slide3')">izstrādātās mājaslapas</a>
                    </nav>
                </div>
            </div>

            <div class="portfolio_gallery" >
                
                <div class="row slides shown" id="slide1">
                    <div class="col4"><img class="portfolio_images" src="img/manalapa.png" alt="my portfolio page"></div>
                    <div class="col4"><img class="portfolio_images" src="img/manalapa.png" alt="my portfolio page"></div>
                    <div class="col4"><img class="portfolio_images" src="img/manalapa.png" alt="my portfolio page"></div>
                    <div class="col4"><img class="portfolio_images" src="img/manalapa.png" alt="my portfolio page"></div>
                    <div class="col4"><img class="portfolio_images" src="img/manalapa.png" alt="my portfolio page"></div>
                    <div class="col4"><img class="portfolio_images" src="img/manalapa.png" alt="my portfolio page"></div>
                </div>

                <div class="row slides" id="slide2">
                    <div class="col6"><img class="portfolio_images" src="img/manalapa.png" alt="my portfolio page"></div>
                    <div class="col6"><img class="portfolio_images" src="img/manalapa.png" alt="my portfolio page"></div>
                    <div class="col6"><img class="portfolio_images" src="img/manalapa.png" alt="my portfolio page"></div>
                    <div class="col6"><img class="portfolio_images" src="img/manalapa.png" alt="my portfolio page"></div>
                </div>

                <div class="row slides" id="slide3">
                    <div class="col6"><img class="portfolio_images" src="img/manalapa.png" alt="my portfolio page"></div>
                    <div class="col6"><img class="portfolio_images" src="img/manalapa.png" alt="my portfolio page"></div>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="contact">
        <div class="container contact">

            <div class="row">
                <div class="col12">
                    <header class="section-header">
                        <h1 class="section-title">Sazināties </h1>
                    </header>
                </div>
            </div>

            <div class="row">
                <form class='col12 form'>
                    <div><input type="text" placeholder="vārds, uzvārds*" name="contact_name" required></div>
                    <div><input type="email" placeholder="e-pasta adrese*" name="contact_email" required></div>
                    <div><input type="text" placeholder="tālruņa nummurs*" name="contact_phone" required></div>
                    <div><textarea id="message" name="contact_message" placeholder='Ziņa*' required></textarea></div>
                    <div style="display: none;"><input type='hidden' name='url' placeholder="URL"></div>
                    <div><input class="button" type="submit" value="Iesniegt" id="submit" name='submit'></div>
                    <div id="status_messages"><p id="server_message"></p></div>
                </form>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container footer">
            <div class="row">
                <div class="col12">
                    <a href="#">Uz sākumu</a>
                </div>
            </div>


            <div class="row footer_icons">
                <div class="col3">    
                    <a href="https://www.linkedin.com/in/filips-babris-6a254b111/">
                        <svg viewBox="0 0 30 31" width="30px" height="30px">
                            <use xlink:href="defs.svg#linkedin"></use>
                        </svg>
                    </a> 
                </div>

                <div class="col3">           
                    <a href="mailto: fbabris2@gmail.com">
                        <svg viewBox="0 0 30 28" height="30px" width="30px">
                            <use xlink:href="defs.svg#letter"></use>
                        </svg>
                    </a>
                </div>

                <div class="col3">            
                    <a href="https://www.instagram.com/fbfilips/">
                        <svg viewBox="0 0 30 30" height="30px" width="30px">
                            <use xlink:href="defs.svg#instagramm"></use>
                        </svg>
                    </a>
                </div>

                <div class="col3">            
                    <a href="https://www.facebook.com/Filips.Babris2/">
                        <svg viewBox="0 0 30 28" height="30px" width="30px">
                            <use xlink:href="defs.svg#facebook"></use>
                        </svg>
                    </a> 
                </div>           
            </div>

            <div class="row">
                <div class="col12">
                    <p><b>2022 Filips Babris</b> All Rights Reserved.</p>
                </div>
            </div>

        </div>
    </section>
    <script src="script.js"></script>
</body>
</html>

