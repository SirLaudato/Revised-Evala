<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="/css/global.css" />
        <link rel="stylesheet" href="/css/nav-login.css" />
        <link rel="stylesheet" href="/components/all.css">
    </head>
    <body>
        <div class="login-and-landing">
            <div class="frame">

                <div class="div-wrapper"><div class="text-wrapper">Innovatio.</div></div>

                <a href="login.php">
                    <button class="icon-button">
                        <svg width="29" height="21" viewBox="0 0 29 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.29492 8.5C10.5041 8.5 12.2949 6.70914 12.2949 4.5C12.2949 2.29086 10.5041 0.5 8.29492 0.5C6.08578 0.5 4.29492 2.29086 4.29492 4.5C4.29492 6.70914 6.08578 8.5 8.29492 8.5Z" />
                            <path d="M16.2949 16C16.2949 18.485 16.2949 20.5 8.29492 20.5C0.294922 20.5 0.294922 18.485 0.294922 16C0.294922 13.515 3.87692 11.5 8.29492 11.5C12.7129 11.5 16.2949 13.515 16.2949 16Z" />
                            <path d="M28.3953 8.31032L24.6468 11.9643L20.8983 8.31032C20.8314 8.2449 20.7415 8.20827 20.6478 8.20827C20.5542 8.20827 20.4643 8.2449 20.3973 8.31032C20.3649 8.34209 20.3392 8.38002 20.3216 8.42187C20.304 8.46373 20.2949 8.50867 20.2949 8.55407C20.2949 8.59947 20.304 8.64441 20.3216 8.68627C20.3392 8.72812 20.3649 8.76605 20.3973 8.79782L24.3851 12.6858C24.4551 12.7541 24.5491 12.7923 24.6468 12.7923C24.7446 12.7923 24.8386 12.7541 24.9086 12.6858L28.8963 8.79857C28.929 8.76677 28.955 8.72875 28.9727 8.68676C28.9904 8.64477 28.9995 8.59965 28.9995 8.55407C28.9995 8.50849 28.9904 8.46337 28.9727 8.42138C28.955 8.37938 28.929 8.34137 28.8963 8.30957Z" />
                        </svg>
                    </button>
                </a>

            </div>
        </div>
    </body>

    <script>
        const navbar = document.querySelector('.login-and-landing');

        window.addEventListener('scroll', function () {  // Removed extra parentheses here
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            if (scrollTop > 0) {
                navbar.classList.add('shadow');
            } else {
                navbar.classList.remove('shadow');
            }
        });
    </script>
</html>
