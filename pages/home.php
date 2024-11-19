<?php
session_start();
if (!isset($_SESSION['emailaddress'])) {
    header("Location: ../pages/login.php");
    exit();

}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../css/global.css" />
    <link rel="stylesheet" href="../css/home.css" />
    <link rel="stylesheet" href="../components/all.css">
</head>

<body>
    <div class="home-revised">
        <div class="navigator">
            <?php include('../components/nav.php') ?>
        </div>
        <div class="frame-2">
            <div class="support-container-wrapper">
                <div class="support-container">
                    <div class="frame-3">
                        <div class="text-wrapper-3">Welcome, <?php echo $_SESSION['first_name']; ?></div>
                    </div>
                    <div class="frame-3">
                        <div class="text-wrapper-4"><?php echo $_SESSION['role']; ?></div>
                    </div>
                </div>
            </div>
            <div class="frame-4">
                <div class="title-hero-wrapper">
                    <div class="title-hero">
                        <div class="text-wrapper-5">Evaluation Progress</div>
                        <p class="p">Here is your overview of the Evaluations.</p>
                    </div>
                </div>
                <div class="frame-wrapper">
                    <div class="frame-5">
                        <div class="total-evaluation">
                            <div class="frame-6">
                                <div class="frame-7">
                                    <div class="frame-8">
                                        <div class="text-wrapper-6">Total Evaluations</div>
                                    </div>
                                    <div class="frame-9">
                                        <div class="text-wrapper-7">0</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="total-evaluation">
                            <div class="frame-6">
                                <div class="frame-7">
                                    <div class="frame-8">
                                        <div class="text-wrapper-6">Total Completed</div>
                                    </div>
                                    <div class="frame-9">
                                        <div class="text-wrapper-7">0</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="total-evaluation">
                            <div class="frame-6">
                                <div class="frame-7">
                                    <div class="frame-8">
                                        <div class="text-wrapper-6">Total Completed</div>
                                    </div>
                                    <div class="frame-9">
                                        <div class="text-wrapper-7">0</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="frame-10">
            <div class="frame-11">
                <p class="nav-item">Get To Know Who We Are And What We Do - About Us</p>
                <p class="text-wrapper-8">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla fringilla nunc in molestie feugiat.
                    Nunc
                    auctor consectetur elit, quis pulvina. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    Nulla
                    fringilla nunc in molestie feugiat
                </p>
            </div>
            <div class="frame-12">
                <div class="frame-13">
                    <div class="frame-14">
                        <div class="frame-15">
                            <p class="text-wrapper-9">Learn About Us And What Sets Us Apart</p>
                            <p class="text-wrapper-10">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla fringilla nunc in
                                molestie feugiat.
                                Nunc auctor consectetur elit, quis pulvina. Lorem ipsum dolor sit amet, consectetur
                                adipiscing elit.
                                Nulla fringilla nunc in molestie feugiat. Nunc auctor consectetur elit, quis pulvina.
                            </p>
                        </div>
                        <div class="check-other-button">
                            <div class="text-wrapper-11">Check Other Evaluation</div>
                        </div>
                    </div>
                    <div class="group">
                        <div class="overlap-group">
                            <div class="rectangle"></div>
                            <div class="rectangle-2"></div>
                        </div>
                        <div class="rectangle-wrapper">
                            <div class="rectangle-3"></div>
                        </div>
                        <div class="group-2">
                            <div class="rectangle-4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="layout">
            <div class="frame-16">
                <div class="frame-17">
                    <div class="frame-18">
                        <p class="text-wrapper-9">Learn About Us And What Sets Us Apart</p>
                        <p class="text-wrapper-10">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla fringilla nunc in molestie
                            feugiat. Nunc
                            auctor consectetur elit, quis pulvina. Lorem ipsum dolor sit amet, consectetur adipiscing
                            elit. Nulla
                            fringilla nunc in molestie feugiat. Nunc auctor consectetur elit, quis pulvina.
                        </p>
                    </div>
                    <div class="check-other-button-2">
                        <div class="text-wrapper-11">Check Other Evaluation</div>
                    </div>
                </div>
                <div class="column">
                    <p class="text-wrapper-9">Learn About Us And What Sets Us Apart</p>
                    <p class="text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros
                        elementum
                        tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla, ut commodo diam
                        libero vitae
                        erat.
                    </p>
                    <div class="list">
                        <div class="list-item">
                            <div class="number">99%</div>
                            <p class="text">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in
                                eros.
                            </p>
                        </div>
                        <div class="list-item">
                            <div class="number">100%</div>
                            <p class="text">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in
                                eros.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="frame-19">
            <div class="frame-20">
                <div class="frame-3">
                    <div class="text-wrapper-12">About Innovatio.</div>
                </div>
                <div class="frame-3">
                    <p class="text-wrapper-13">
                        We care about your integrity, and continuously work toward making your Evala experience as safe
                        and secure
                        as possible. Read the Evala Privacy Policy to learn more about how we use and store personal
                        data.
                    </p>
                </div>
            </div>
            <div class="frame-21">
                <div class="frame-22">
                    <div class="frame-23">
                        <img class="rectangle-5" src="../creator profile/brent.jpg" />
                        <div class="frame-24">
                            <div class="text-wrapper-14">Programmer</div>
                            <div class="text-wrapper-15">Brent Rull</div>
                        </div>
                        <div class="footer-icons">
                            <div class="github">
                                <svg width="21" height="20" viewBox="0 0 21 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M10.2002 0.242188C8.88698 0.242187 7.58662 0.500845 6.37336 1.00339C5.1601 1.50594 4.05771 2.24253 3.12913 3.17112C1.25376 5.04648 0.200195 7.59002 0.200195 10.2422C0.200195 14.6622 3.0702 18.4122 7.0402 19.7422C7.5402 19.8222 7.7002 19.5122 7.7002 19.2422V17.5522C4.9302 18.1522 4.3402 16.2122 4.3402 16.2122C3.8802 15.0522 3.2302 14.7422 3.2302 14.7422C2.3202 14.1222 3.3002 14.1422 3.3002 14.1422C4.3002 14.2122 4.8302 15.1722 4.8302 15.1722C5.7002 16.6922 7.1702 16.2422 7.7402 16.0022C7.8302 15.3522 8.0902 14.9122 8.3702 14.6622C6.1502 14.4122 3.8202 13.5522 3.8202 9.74219C3.8202 8.63219 4.2002 7.74219 4.8502 7.03219C4.7502 6.78219 4.4002 5.74219 4.9502 4.39219C4.9502 4.39219 5.7902 4.12219 7.7002 5.41219C8.4902 5.19219 9.3502 5.08219 10.2002 5.08219C11.0502 5.08219 11.9102 5.19219 12.7002 5.41219C14.6102 4.12219 15.4502 4.39219 15.4502 4.39219C16.0002 5.74219 15.6502 6.78219 15.5502 7.03219C16.2002 7.74219 16.5802 8.63219 16.5802 9.74219C16.5802 13.5622 14.2402 14.4022 12.0102 14.6522C12.3702 14.9622 12.7002 15.5722 12.7002 16.5022V19.2422C12.7002 19.5122 12.8602 19.8322 13.3702 19.7422C17.3402 18.4022 20.2002 14.6622 20.2002 10.2422C20.2002 8.92897 19.9415 7.62861 19.439 6.41535C18.9364 5.2021 18.1998 4.09971 17.2713 3.17112C16.3427 2.24253 15.2403 1.50594 14.027 1.00339C12.8138 0.500845 11.5134 0.242188 10.2002 0.242188Z"
                                        fill="#727271" />
                                </svg>


                            </div>
                            <div class="github">
                                <svg width="21" height="20" viewBox="0 0 21 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M20.2002 10.0249C20.2002 4.5049 15.7202 0.0249023 10.2002 0.0249023C4.6802 0.0249023 0.200195 4.5049 0.200195 10.0249C0.200195 14.8649 3.6402 18.8949 8.2002 19.8249V13.0249H6.2002V10.0249H8.2002V7.5249C8.2002 5.5949 9.7702 4.0249 11.7002 4.0249H14.2002V7.0249H12.2002C11.6502 7.0249 11.2002 7.4749 11.2002 8.0249V10.0249H14.2002V13.0249H11.2002V19.9749C16.2502 19.4749 20.2002 15.2149 20.2002 10.0249Z"
                                        fill="#727271" />
                                </svg>

                            </div>
                            <div class="google">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M1.2642 5.51C2.09657 3.85353 3.37302 2.46106 4.95099 1.48806C6.52897 0.515073 8.34636 -0.000126487 10.2002 2.32934e-08C12.8952 2.32934e-08 15.1592 0.991 16.8902 2.605L14.0232 5.473C12.9862 4.482 11.6682 3.977 10.2002 3.977C7.5952 3.977 5.3902 5.737 4.6052 8.1C4.4052 8.7 4.2912 9.34 4.2912 10C4.2912 10.66 4.4052 11.3 4.6052 11.9C5.3912 14.264 7.5952 16.023 10.2002 16.023C11.5452 16.023 12.6902 15.668 13.5862 15.068C14.1056 14.726 14.5503 14.2822 14.8934 13.7635C15.2365 13.2448 15.4708 12.6619 15.5822 12.05H10.2002V8.182H19.6182C19.7362 8.836 19.8002 9.518 19.8002 10.227C19.8002 13.273 18.7102 15.837 16.8182 17.577C15.1642 19.105 12.9002 20 10.2002 20C8.88683 20.0005 7.58623 19.7422 6.37274 19.2399C5.15925 18.7375 4.05665 18.0009 3.12796 17.0722C2.19927 16.1436 1.46269 15.0409 0.96033 13.8275C0.457969 12.614 0.19967 11.3134 0.200196 10C0.200196 8.386 0.586196 6.86 1.2642 5.51Z"
                                        fill="#727271" />
                                </svg>

                            </div>
                        </div>
                    </div>
                    <div class="group-3">
                        <div class="frame-26">
                            <img class="rectangle-5" src="../creator profile/lawrence.jpg" />
                            <div class="frame-27">
                                <div class="text-wrapper-14">UI/UX Designer</div>
                                <div class="text-wrapper-15">Lawrence Laudato</div>
                            </div>
                            <div class="footer-icons">
                                <div class="github">
                                    <svg width="21" height="20" viewBox="0 0 21 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M10.2002 0.242188C8.88698 0.242187 7.58662 0.500845 6.37336 1.00339C5.1601 1.50594 4.05771 2.24253 3.12913 3.17112C1.25376 5.04648 0.200195 7.59002 0.200195 10.2422C0.200195 14.6622 3.0702 18.4122 7.0402 19.7422C7.5402 19.8222 7.7002 19.5122 7.7002 19.2422V17.5522C4.9302 18.1522 4.3402 16.2122 4.3402 16.2122C3.8802 15.0522 3.2302 14.7422 3.2302 14.7422C2.3202 14.1222 3.3002 14.1422 3.3002 14.1422C4.3002 14.2122 4.8302 15.1722 4.8302 15.1722C5.7002 16.6922 7.1702 16.2422 7.7402 16.0022C7.8302 15.3522 8.0902 14.9122 8.3702 14.6622C6.1502 14.4122 3.8202 13.5522 3.8202 9.74219C3.8202 8.63219 4.2002 7.74219 4.8502 7.03219C4.7502 6.78219 4.4002 5.74219 4.9502 4.39219C4.9502 4.39219 5.7902 4.12219 7.7002 5.41219C8.4902 5.19219 9.3502 5.08219 10.2002 5.08219C11.0502 5.08219 11.9102 5.19219 12.7002 5.41219C14.6102 4.12219 15.4502 4.39219 15.4502 4.39219C16.0002 5.74219 15.6502 6.78219 15.5502 7.03219C16.2002 7.74219 16.5802 8.63219 16.5802 9.74219C16.5802 13.5622 14.2402 14.4022 12.0102 14.6522C12.3702 14.9622 12.7002 15.5722 12.7002 16.5022V19.2422C12.7002 19.5122 12.8602 19.8322 13.3702 19.7422C17.3402 18.4022 20.2002 14.6622 20.2002 10.2422C20.2002 8.92897 19.9415 7.62861 19.439 6.41535C18.9364 5.2021 18.1998 4.09971 17.2713 3.17112C16.3427 2.24253 15.2403 1.50594 14.027 1.00339C12.8138 0.500845 11.5134 0.242188 10.2002 0.242188Z"
                                            fill="#727271" />
                                    </svg>


                                </div>
                                <div class="github">
                                    <svg width="21" height="20" viewBox="0 0 21 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M20.2002 10.0249C20.2002 4.5049 15.7202 0.0249023 10.2002 0.0249023C4.6802 0.0249023 0.200195 4.5049 0.200195 10.0249C0.200195 14.8649 3.6402 18.8949 8.2002 19.8249V13.0249H6.2002V10.0249H8.2002V7.5249C8.2002 5.5949 9.7702 4.0249 11.7002 4.0249H14.2002V7.0249H12.2002C11.6502 7.0249 11.2002 7.4749 11.2002 8.0249V10.0249H14.2002V13.0249H11.2002V19.9749C16.2502 19.4749 20.2002 15.2149 20.2002 10.0249Z"
                                            fill="#727271" />
                                    </svg>

                                </div>
                                <div class="google">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M1.2642 5.51C2.09657 3.85353 3.37302 2.46106 4.95099 1.48806C6.52897 0.515073 8.34636 -0.000126487 10.2002 2.32934e-08C12.8952 2.32934e-08 15.1592 0.991 16.8902 2.605L14.0232 5.473C12.9862 4.482 11.6682 3.977 10.2002 3.977C7.5952 3.977 5.3902 5.737 4.6052 8.1C4.4052 8.7 4.2912 9.34 4.2912 10C4.2912 10.66 4.4052 11.3 4.6052 11.9C5.3912 14.264 7.5952 16.023 10.2002 16.023C11.5452 16.023 12.6902 15.668 13.5862 15.068C14.1056 14.726 14.5503 14.2822 14.8934 13.7635C15.2365 13.2448 15.4708 12.6619 15.5822 12.05H10.2002V8.182H19.6182C19.7362 8.836 19.8002 9.518 19.8002 10.227C19.8002 13.273 18.7102 15.837 16.8182 17.577C15.1642 19.105 12.9002 20 10.2002 20C8.88683 20.0005 7.58623 19.7422 6.37274 19.2399C5.15925 18.7375 4.05665 18.0009 3.12796 17.0722C2.19927 16.1436 1.46269 15.0409 0.96033 13.8275C0.457969 12.614 0.19967 11.3134 0.200196 10C0.200196 8.386 0.586196 6.86 1.2642 5.51Z"
                                            fill="#727271" />
                                    </svg>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="group-3">
                        <div class="frame-26">
                            <img class="rectangle-5" src="../creator profile/ash.jpg" />
                            <div class="frame-28">
                                <div class="text-wrapper-16">Project Manager</div>
                                <div class="text-wrapper-17">Jaira Tafalla</div>
                            </div>
                            <div class="footer-icons">
                                <div class="github">
                                    <svg width="21" height="20" viewBox="0 0 21 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M10.2002 0.242188C8.88698 0.242187 7.58662 0.500845 6.37336 1.00339C5.1601 1.50594 4.05771 2.24253 3.12913 3.17112C1.25376 5.04648 0.200195 7.59002 0.200195 10.2422C0.200195 14.6622 3.0702 18.4122 7.0402 19.7422C7.5402 19.8222 7.7002 19.5122 7.7002 19.2422V17.5522C4.9302 18.1522 4.3402 16.2122 4.3402 16.2122C3.8802 15.0522 3.2302 14.7422 3.2302 14.7422C2.3202 14.1222 3.3002 14.1422 3.3002 14.1422C4.3002 14.2122 4.8302 15.1722 4.8302 15.1722C5.7002 16.6922 7.1702 16.2422 7.7402 16.0022C7.8302 15.3522 8.0902 14.9122 8.3702 14.6622C6.1502 14.4122 3.8202 13.5522 3.8202 9.74219C3.8202 8.63219 4.2002 7.74219 4.8502 7.03219C4.7502 6.78219 4.4002 5.74219 4.9502 4.39219C4.9502 4.39219 5.7902 4.12219 7.7002 5.41219C8.4902 5.19219 9.3502 5.08219 10.2002 5.08219C11.0502 5.08219 11.9102 5.19219 12.7002 5.41219C14.6102 4.12219 15.4502 4.39219 15.4502 4.39219C16.0002 5.74219 15.6502 6.78219 15.5502 7.03219C16.2002 7.74219 16.5802 8.63219 16.5802 9.74219C16.5802 13.5622 14.2402 14.4022 12.0102 14.6522C12.3702 14.9622 12.7002 15.5722 12.7002 16.5022V19.2422C12.7002 19.5122 12.8602 19.8322 13.3702 19.7422C17.3402 18.4022 20.2002 14.6622 20.2002 10.2422C20.2002 8.92897 19.9415 7.62861 19.439 6.41535C18.9364 5.2021 18.1998 4.09971 17.2713 3.17112C16.3427 2.24253 15.2403 1.50594 14.027 1.00339C12.8138 0.500845 11.5134 0.242188 10.2002 0.242188Z"
                                            fill="#727271" />
                                    </svg>


                                </div>
                                <div class="github">
                                    <svg width="21" height="20" viewBox="0 0 21 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M20.2002 10.0249C20.2002 4.5049 15.7202 0.0249023 10.2002 0.0249023C4.6802 0.0249023 0.200195 4.5049 0.200195 10.0249C0.200195 14.8649 3.6402 18.8949 8.2002 19.8249V13.0249H6.2002V10.0249H8.2002V7.5249C8.2002 5.5949 9.7702 4.0249 11.7002 4.0249H14.2002V7.0249H12.2002C11.6502 7.0249 11.2002 7.4749 11.2002 8.0249V10.0249H14.2002V13.0249H11.2002V19.9749C16.2502 19.4749 20.2002 15.2149 20.2002 10.0249Z"
                                            fill="#727271" />
                                    </svg>

                                </div>
                                <div class="google">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M1.2642 5.51C2.09657 3.85353 3.37302 2.46106 4.95099 1.48806C6.52897 0.515073 8.34636 -0.000126487 10.2002 2.32934e-08C12.8952 2.32934e-08 15.1592 0.991 16.8902 2.605L14.0232 5.473C12.9862 4.482 11.6682 3.977 10.2002 3.977C7.5952 3.977 5.3902 5.737 4.6052 8.1C4.4052 8.7 4.2912 9.34 4.2912 10C4.2912 10.66 4.4052 11.3 4.6052 11.9C5.3912 14.264 7.5952 16.023 10.2002 16.023C11.5452 16.023 12.6902 15.668 13.5862 15.068C14.1056 14.726 14.5503 14.2822 14.8934 13.7635C15.2365 13.2448 15.4708 12.6619 15.5822 12.05H10.2002V8.182H19.6182C19.7362 8.836 19.8002 9.518 19.8002 10.227C19.8002 13.273 18.7102 15.837 16.8182 17.577C15.1642 19.105 12.9002 20 10.2002 20C8.88683 20.0005 7.58623 19.7422 6.37274 19.2399C5.15925 18.7375 4.05665 18.0009 3.12796 17.0722C2.19927 16.1436 1.46269 15.0409 0.96033 13.8275C0.457969 12.614 0.19967 11.3134 0.200196 10C0.200196 8.386 0.586196 6.86 1.2642 5.51Z"
                                            fill="#727271" />
                                    </svg>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="group-3">
                        <div class="frame-29">
                            <img class="rectangle-5" src="../creator profile/louis.jpg" />
                            <div class="frame-30">
                                <div class="text-wrapper-18">System Analyst</div>
                                <div class="text-wrapper-19">Louis Barbuco</div>
                            </div>
                            <div class="footer-icons">
                                <div class="github">
                                    <svg width="21" height="20" viewBox="0 0 21 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M10.2002 0.242188C8.88698 0.242187 7.58662 0.500845 6.37336 1.00339C5.1601 1.50594 4.05771 2.24253 3.12913 3.17112C1.25376 5.04648 0.200195 7.59002 0.200195 10.2422C0.200195 14.6622 3.0702 18.4122 7.0402 19.7422C7.5402 19.8222 7.7002 19.5122 7.7002 19.2422V17.5522C4.9302 18.1522 4.3402 16.2122 4.3402 16.2122C3.8802 15.0522 3.2302 14.7422 3.2302 14.7422C2.3202 14.1222 3.3002 14.1422 3.3002 14.1422C4.3002 14.2122 4.8302 15.1722 4.8302 15.1722C5.7002 16.6922 7.1702 16.2422 7.7402 16.0022C7.8302 15.3522 8.0902 14.9122 8.3702 14.6622C6.1502 14.4122 3.8202 13.5522 3.8202 9.74219C3.8202 8.63219 4.2002 7.74219 4.8502 7.03219C4.7502 6.78219 4.4002 5.74219 4.9502 4.39219C4.9502 4.39219 5.7902 4.12219 7.7002 5.41219C8.4902 5.19219 9.3502 5.08219 10.2002 5.08219C11.0502 5.08219 11.9102 5.19219 12.7002 5.41219C14.6102 4.12219 15.4502 4.39219 15.4502 4.39219C16.0002 5.74219 15.6502 6.78219 15.5502 7.03219C16.2002 7.74219 16.5802 8.63219 16.5802 9.74219C16.5802 13.5622 14.2402 14.4022 12.0102 14.6522C12.3702 14.9622 12.7002 15.5722 12.7002 16.5022V19.2422C12.7002 19.5122 12.8602 19.8322 13.3702 19.7422C17.3402 18.4022 20.2002 14.6622 20.2002 10.2422C20.2002 8.92897 19.9415 7.62861 19.439 6.41535C18.9364 5.2021 18.1998 4.09971 17.2713 3.17112C16.3427 2.24253 15.2403 1.50594 14.027 1.00339C12.8138 0.500845 11.5134 0.242188 10.2002 0.242188Z"
                                            fill="#727271" />
                                    </svg>


                                </div>
                                <div class="github">
                                    <svg width="21" height="20" viewBox="0 0 21 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M20.2002 10.0249C20.2002 4.5049 15.7202 0.0249023 10.2002 0.0249023C4.6802 0.0249023 0.200195 4.5049 0.200195 10.0249C0.200195 14.8649 3.6402 18.8949 8.2002 19.8249V13.0249H6.2002V10.0249H8.2002V7.5249C8.2002 5.5949 9.7702 4.0249 11.7002 4.0249H14.2002V7.0249H12.2002C11.6502 7.0249 11.2002 7.4749 11.2002 8.0249V10.0249H14.2002V13.0249H11.2002V19.9749C16.2502 19.4749 20.2002 15.2149 20.2002 10.0249Z"
                                            fill="#727271" />
                                    </svg>

                                </div>
                                <div class="google">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M1.2642 5.51C2.09657 3.85353 3.37302 2.46106 4.95099 1.48806C6.52897 0.515073 8.34636 -0.000126487 10.2002 2.32934e-08C12.8952 2.32934e-08 15.1592 0.991 16.8902 2.605L14.0232 5.473C12.9862 4.482 11.6682 3.977 10.2002 3.977C7.5952 3.977 5.3902 5.737 4.6052 8.1C4.4052 8.7 4.2912 9.34 4.2912 10C4.2912 10.66 4.4052 11.3 4.6052 11.9C5.3912 14.264 7.5952 16.023 10.2002 16.023C11.5452 16.023 12.6902 15.668 13.5862 15.068C14.1056 14.726 14.5503 14.2822 14.8934 13.7635C15.2365 13.2448 15.4708 12.6619 15.5822 12.05H10.2002V8.182H19.6182C19.7362 8.836 19.8002 9.518 19.8002 10.227C19.8002 13.273 18.7102 15.837 16.8182 17.577C15.1642 19.105 12.9002 20 10.2002 20C8.88683 20.0005 7.58623 19.7422 6.37274 19.2399C5.15925 18.7375 4.05665 18.0009 3.12796 17.0722C2.19927 16.1436 1.46269 15.0409 0.96033 13.8275C0.457969 12.614 0.19967 11.3134 0.200196 10C0.200196 8.386 0.586196 6.86 1.2642 5.51Z"
                                            fill="#727271" />
                                    </svg>

                                </div>
                            </div>
                        </div>
                        <img class="rectangle-6" src="img/rectangle-5.svg" />
                    </div>
                </div>
            </div>
        </div>
        <?php include '../components/footer.php' ?>
    </div>
</body>

</html>