<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="/css/global.css" />
        <link rel="stylesheet" href="../css/landing-page.css" />
        <link rel="stylesheet" href="../components/all.css">
        <link rel="icon" type="image/png" href="innovatio-icon.png" sizes="16x16">
    </head>
    <body>  
        <div class="landing-page">
            <?php include('../components/nav-login.php') ?>


            <div class="frame-wrapper">
                <div class="frame-2">
                    <div class="frame-3">
                        <div class="frame-4">
                            <p class="p">Smart Curriculum Evaluation</p>
                            <p class="evala-aims-to">
                                Evala uses AI to enhance education by gathering feedback from students, faculty, alumni, and industry advisors. It analyzes data to improve services, offering personalized recommendations, better resource allocation, and an improved learning environment.
                            </p>
                        </div>
                        <div class="start-eval-button"><div class="text-wrapper-2">Read Our Blogs</div></div>
                    </div>
                    <div class="group">
                        <div class="overlap-group">
                             <img src="../creator_profile/designer_1.png" alt="" width="1304" height="700">
                        </div>
                    </div>
                </div>
            </div>
            <div class="layout">
                <div class="frame-5">
                    <div class="frame-6">
                        <div class="frame-7">
                            <img src="../creator_profile/girl-flower.png" alt="" width="500" height="900">
                        </div>
                    </div>
                    <div class="column">
                        <div class="frame-4">
                            <p class="p">Learn About Us And What Sets Us Apart</p>
                            <p class="evala-aims-to">
                                Evala uses AI to enhance education by gathering feedback from students, faculty, alumni, and industry advisors. It analyzes data to improve services, offering personalized recommendations, better resource allocation, and an improved learning environment.
                            </p>
                        </div>
                    </div>
                </div>
            </div>



            <div class="layout-1">
                <div class="frame-5">
                    <div class="frame-6">
                        <div class="frame-7">
                            <img src="../creator_profile/girl-lookingdown.png" alt="" width="500" height="900">
                        </div>
                    </div>
                    <div class="column">
                        <div class="frame-4">
                            <p class="p">Learn About Us And What Sets Us Apart</p>
                            <p class="evala-aims-to">
                                Evala uses AI to enhance education by gathering feedback from students, faculty, alumni, and industry advisors. It analyzes data to improve services, offering personalized recommendations, better resource allocation, and an improved learning environment.
                            </p>
                        </div>
                        <div class="button-list">
                            <div class="start-eval-button"><div class="text-wrapper-2">Ask A Question</div></div>
                            <div class="start-hollow"><div class="text-wrapper-2">Ask A Question</div></div>
                        </div>
                    </div>
                </div>
            </div>


            
            <div class="frame-8">
                <div class="frame-3">
                    <div class="frame-9">
                        <div class="text-wrapper-3">Frequently Asked Questions</div>
                        <p class="text-wrapper-4">
                            Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut
                            laoreet.
                        </p>
                    </div>
                    <div class="start-eval-button"><div class="text-wrapper-2">Ask A Question</div></div>
                </div>
                <div class="frame-10">
                    <div class="faq-container">
                        <div class="faq-item">
                            <div class="faq-question" onclick="toggleFAQ(this)">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed?</p>
                                <span class="toggle-icon">+</span>
                            </div>
                            <div class="faq-answer">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea.</p>
                            </div>
                        </div>
                        <div class="faq-item">
                            <div class="faq-question" onclick="toggleFAQ(this)">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed?</p>
                                <span class="toggle-icon">+</span>
                            </div>
                            <div class="faq-answer">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea.</p>
                            </div>
                        </div>
                        <div class="faq-item">
                            <div class="faq-question" onclick="toggleFAQ(this)">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed?</p>
                                <span class="toggle-icon">+</span>
                            </div>
                            <div class="faq-answer">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include '../components/footer.php' ?>
        </div>
        <script>
            function toggleFAQ(element) {
                const faqItem = element.parentNode;
                faqItem.classList.toggle("expanded");
            }
        </script>
    </body>
</html>
