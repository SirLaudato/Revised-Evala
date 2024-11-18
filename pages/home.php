<?php
// session_start();
// if (isset($_SESSION['username'])) {//redirect
//     header("Location: customer-page/welcome-page.php");
//     exit();

// }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="/css/global.css" />
    <link rel="stylesheet" href="/css/home.css" />
    <link rel="stylesheet" href="/components/all.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>

    </head>
    <body>
        <div class="home">
            <div class="navigator">
                <?php include('C:\Users\Lawrence\Documents\Revised Evala\components\nav.php') ?>
            </div>

        <div class="frame-wrapper">
            <div class="frame-2">
                <div class="welcome-container">
                    <div class="frame-3">
                        <div class="text-wrapper-3">Welcome, UserName</div>
=======
            <div class="frame-wrapper">
                <div class="frame-2">
                    <div class="welcome-container">
                        <div class="frame-3"><div class="text-wrapper-3">Welcome, UserName</div></div>
                        <div class="frame-4"><p class="p">User Role</p></div>
>>>>>>> 26e5470771eae04452c71a0277e8c13c2b787f29
                    </div>
                    <div class="frame-4">
                        <p class="p">Here is your overview of the evaluations</p>
                    </div>
                </div>
                <div class="frame-5">
                    <div class="frame-6">
                        <div class="total-evaluation">
                            <div class="frame-7">
                                <div class="frame-8">
                                    <div class="frame-9">
                                        <div class="text-wrapper-4">Total Evaluations</div>
                                    </div>
                                    <div class="frame-10">
                                        <div class="text-wrapper-5">0</div>
                                    </div>
                                </div>
                                <svg width="36" height="36" viewBox="0 0 36 36" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M28.125 14.8438C28.125 15.051 28.0427 15.2497 27.8962 15.3962C27.7497 15.5427 27.551 15.625 27.3438 15.625H14.8438C14.6365 15.625 14.4378 15.5427 14.2913 15.3962C14.1448 15.2497 14.0625 15.051 14.0625 14.8438C14.0625 14.6365 14.1448 14.4378 14.2913 14.2913C14.4378 14.1448 14.6365 14.0625 14.8438 14.0625H27.3438C27.551 14.0625 27.7497 14.1448 27.8962 14.2913C28.0427 14.4378 28.125 14.6365 28.125 14.8438ZM27.3438 20.3125H14.8438C14.6365 20.3125 14.4378 20.3948 14.2913 20.5413C14.1448 20.6878 14.0625 20.8865 14.0625 21.0938C14.0625 21.301 14.1448 21.4997 14.2913 21.6462C14.4378 21.7927 14.6365 21.875 14.8438 21.875H27.3438C27.551 21.875 27.7497 21.7927 27.8962 21.6462C28.0427 21.4997 28.125 21.301 28.125 21.0938C28.125 20.8865 28.0427 20.6878 27.8962 20.5413C27.7497 20.3948 27.551 20.3125 27.3438 20.3125ZM35.9375 2.34375V33.5938C35.9375 34.2154 35.6906 34.8115 35.251 35.251C34.8115 35.6906 34.2154 35.9375 33.5938 35.9375H2.34375C1.72215 35.9375 1.12601 35.6906 0.686468 35.251C0.24693 34.8115 0 34.2154 0 33.5938V2.34375C0 1.72215 0.24693 1.12601 0.686468 0.686468C1.12601 0.24693 1.72215 0 2.34375 0H33.5938C34.2154 0 34.8115 0.24693 35.251 0.686468C35.6906 1.12601 35.9375 1.72215 35.9375 2.34375ZM2.34375 34.375H7.8125V1.5625H2.34375C2.13655 1.5625 1.93784 1.64481 1.79132 1.79132C1.64481 1.93784 1.5625 2.13655 1.5625 2.34375V33.5938C1.5625 33.8009 1.64481 33.9997 1.79132 34.1462C1.93784 34.2927 2.13655 34.375 2.34375 34.375ZM34.375 2.34375C34.375 2.13655 34.2927 1.93784 34.1462 1.79132C33.9997 1.64481 33.8009 1.5625 33.5938 1.5625H9.375V34.375H33.5938C33.8009 34.375 33.9997 34.2927 34.1462 34.1462C34.2927 33.9997 34.375 33.8009 34.375 33.5938V2.34375Z"
                                        fill="#727271" />
                                </svg>

                            </div>
                        </div>
                        <div class="total-completed">
                            <div class="frame-11">
                                <div class="frame-12">
                                    <div class="frame-8">
                                        <div class="frame-9">
                                            <div class="text-wrapper-4">Total Completed</div>
                                        </div>
                                        <div class="frame-10">
                                            <div class="text-wrapper-5">0</div>
                                        </div>
                                    </div>
                                </div>
                                <svg width="36" height="36" viewBox="0 0 36 36" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M35.94 2.37419V33.6264C35.94 34.248 35.6931 34.8442 35.2535 35.2838C34.8139 35.7233 34.2177 35.9703 33.5961 35.9703H2.34391C1.72227 35.9703 1.12608 35.7233 0.686516 35.2838C0.246947 34.8442 0 34.248 0 33.6264V2.37419C0 1.75254 0.246947 1.15636 0.686516 0.716789C1.12608 0.27722 1.72227 0.0302734 2.34391 0.0302734H33.5961C34.2177 0.0302734 34.8139 0.27722 35.2535 0.716789C35.6931 1.15636 35.94 1.75254 35.94 2.37419ZM2.34391 34.4077H7.81304V1.59288H2.34391C2.1367 1.59288 1.93797 1.6752 1.79145 1.82172C1.64492 1.96824 1.56261 2.16697 1.56261 2.37419V33.6264C1.56261 33.8336 1.64492 34.0323 1.79145 34.1788C1.93797 34.3253 2.1367 34.4077 2.34391 34.4077ZM34.3774 2.37419C34.3774 2.16697 34.2951 1.96824 34.1486 1.82172C34.002 1.6752 33.8033 1.59288 33.5961 1.59288H9.37565V34.4077H33.5961C33.8033 34.4077 34.002 34.3253 34.1486 34.1788C34.2951 34.0323 34.3774 33.8336 34.3774 33.6264V2.37419Z"
                                        fill="#727271" />
                                    <path
                                        d="M21.5015 10.031C16.8068 10.031 13.0009 13.8368 13.0009 18.5316C13.0009 23.2265 16.8068 27.0322 21.5015 27.0322C26.1965 27.0322 30.0021 23.2265 30.0021 18.5316C30.0021 13.8368 26.1965 10.031 21.5015 10.031ZM21.5015 25.9863C17.4002 25.9863 14.0635 22.6328 14.0635 18.5315C14.0635 14.4303 17.4002 11.0935 21.5015 11.0935C25.6028 11.0935 28.9395 14.4303 28.9395 18.5315C28.9395 22.6328 25.6028 25.9863 21.5015 25.9863ZM24.894 15.4211L19.9066 20.4399L17.6605 18.1939C17.4531 17.9865 17.1168 17.9865 16.909 18.1939C16.7016 18.4014 16.7016 18.7377 16.909 18.9452L19.5386 21.575C19.7461 21.7822 20.0824 21.7822 20.2901 21.575C20.3141 21.5511 20.3345 21.5251 20.3531 21.498L25.6458 16.1726C25.853 15.9652 25.853 15.6289 25.6458 15.4211C25.4381 15.2137 25.1018 15.2137 24.894 15.4211Z"
                                        fill="#727271" />
                                </svg>

                            </div>
                        </div>
                        <div class="total-completed">
                            <div class="frame-11">
                                <div class="frame-13">
                                    <div class="frame-8">
                                        <div class="frame-9">
                                            <div class="text-wrapper-4">Total Upcoming</div>
                                        </div>
                                        <div class="frame-10">
                                            <div class="text-wrapper-5">0</div>
                                        </div>
                                    </div>
                                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M35.94 2.37419V33.6264C35.94 34.248 35.693 34.8442 35.2535 35.2838C34.8139 35.7233 34.2177 35.9703 33.5961 35.9703H2.34391C1.72227 35.9703 1.12608 35.7233 0.686516 35.2838C0.246947 34.8442 0 34.248 0 33.6264V2.37419C0 1.75254 0.246947 1.15636 0.686516 0.716789C1.12608 0.27722 1.72227 0.0302734 2.34391 0.0302734H33.5961C34.2177 0.0302734 34.8139 0.27722 35.2535 0.716789C35.693 1.15636 35.94 1.75254 35.94 2.37419ZM2.34391 34.4077H7.81304V1.59288H2.34391C2.1367 1.59288 1.93797 1.6752 1.79145 1.82172C1.64492 1.96824 1.56261 2.16697 1.56261 2.37419V33.6264C1.56261 33.8336 1.64492 34.0323 1.79145 34.1788C1.93797 34.3253 2.1367 34.4077 2.34391 34.4077ZM34.3774 2.37419C34.3774 2.16697 34.2951 1.96824 34.1486 1.82172C34.002 1.6752 33.8033 1.59288 33.5961 1.59288H9.37565V34.4077H33.5961C33.8033 34.4077 34.002 34.3253 34.1486 34.1788C34.2951 34.0323 34.3774 33.8336 34.3774 33.6264V2.37419Z"
                                            fill="#727271" />
                                        <path
                                            d="M21.5004 15.9192C21.1025 15.9192 20.7209 16.0596 20.4396 16.3097C20.1582 16.5597 20.0001 16.8989 20.0001 17.2525V17.3476C20.0001 17.4655 19.9475 17.5785 19.8537 17.6619C19.7599 17.7452 19.6327 17.7921 19.5001 17.7921C19.3674 17.7921 19.2402 17.7452 19.1465 17.6619C19.0527 17.5785 19 17.4655 19 17.3476V17.2525C19 16.6631 19.2634 16.0979 19.7323 15.6811C20.2013 15.2644 20.8372 15.0303 21.5004 15.0303H21.6164C22.1034 15.0304 22.5786 15.1631 22.9782 15.4104C23.3779 15.6577 23.6827 16.0079 23.8517 16.4138C24.0208 16.8197 24.0459 17.2618 23.9238 17.6808C23.8017 18.0998 23.5381 18.4755 23.1686 18.7574L22.3975 19.3449C22.2731 19.4399 22.1733 19.5576 22.1048 19.69C22.0363 19.8224 22.0007 19.9663 22.0004 20.1121V20.5858C22.0004 20.7037 21.9478 20.8167 21.854 20.9001C21.7602 20.9834 21.633 21.0303 21.5004 21.0303C21.3677 21.0303 21.2405 20.9834 21.1468 20.9001C21.053 20.8167 21.0003 20.7037 21.0003 20.5858V20.1121C21.0003 19.5574 21.2733 19.0312 21.7464 18.6703L22.5165 18.0836C22.7313 17.9201 22.8845 17.702 22.9556 17.4587C23.0268 17.2154 23.0123 16.9586 22.9143 16.7229C22.8162 16.4871 22.6393 16.2837 22.4072 16.14C22.1752 15.9963 21.8992 15.9192 21.6164 15.9192H21.5004ZM21.5004 23.0303C21.6993 23.0303 21.8901 22.96 22.0308 22.835C22.1714 22.71 22.2505 22.5404 22.2505 22.3636C22.2505 22.1868 22.1714 22.0172 22.0308 21.8922C21.8901 21.7672 21.6993 21.6969 21.5004 21.6969C21.3014 21.6969 21.1106 21.7672 20.97 21.8922C20.8293 22.0172 20.7503 22.1868 20.7503 22.3636C20.7503 22.5404 20.8293 22.71 20.97 22.835C21.1106 22.96 21.3014 23.0303 21.5004 23.0303Z"
                                            fill="#727271" />
                                        <path
                                            d="M13 18.5303C13 16.2759 13.8955 14.1139 15.4896 12.5199C17.0837 10.9258 19.2457 10.0303 21.5 10.0303C23.7543 10.0303 25.9163 10.9258 27.5104 12.5199C29.1045 14.1139 30 16.2759 30 18.5303C30 20.7846 29.1045 22.9466 27.5104 24.5407C25.9163 26.1347 23.7543 27.0303 21.5 27.0303C19.2457 27.0303 17.0837 26.1347 15.4896 24.5407C13.8955 22.9466 13 20.7846 13 18.5303ZM21.5 11.0303C19.5109 11.0303 17.6032 11.8204 16.1967 13.227C14.7902 14.6335 14 16.5411 14 18.5303C14 20.5194 14.7902 22.4271 16.1967 23.8336C17.6032 25.2401 19.5109 26.0303 21.5 26.0303C23.4891 26.0303 25.3968 25.2401 26.8033 23.8336C28.2098 22.4271 29 20.5194 29 18.5303C29 16.5411 28.2098 14.6335 26.8033 13.227C25.3968 11.8204 23.4891 11.0303 21.5 11.0303Z"
                                            fill="#727271" />
                                    </svg>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
<?php include 'C:\Users\Lawrence\Documents\Revised Evala\components\footer.php' ?>
    </body>
</html>