<!-- Updated Modal Structure -->
<div class="fail-modal">
    <div id="failModal" class="modal"> <!-- Changed ID here -->
        <div class="modal-content">
            <div class="modal-icon">
        <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M11.25 16.25H13.75V18.75H11.25V16.25ZM11.25 6.25H13.75V13.75H11.25V6.25ZM12.5 0C5.5875 0 0 5.625 0 12.5C0 15.8152 1.31696 18.9946 3.66117 21.3388C4.8219 22.4996 6.19989 23.4203 7.71646 24.0485C9.23303 24.6767 10.8585 25 12.5 25C15.8152 25 18.9946 23.683 21.3388 21.3388C23.683 18.9946 25 15.8152 25 12.5C25 10.8585 24.6767 9.23303 24.0485 7.71646C23.4203 6.19989 22.4996 4.8219 21.3388 3.66117C20.1781 2.50043 18.8001 1.57969 17.2835 0.951506C15.767 0.323322 14.1415 0 12.5 0ZM12.5 22.5C9.84783 22.5 7.3043 21.4464 5.42893 19.5711C3.55357 17.6957 2.5 15.1522 2.5 12.5C2.5 9.84783 3.55357 7.3043 5.42893 5.42893C7.3043 3.55357 9.84783 2.5 12.5 2.5C15.1522 2.5 17.6957 3.55357 19.5711 5.42893C21.4464 7.3043 22.5 9.84783 22.5 12.5C22.5 15.1522 21.4464 17.6957 19.5711 19.5711C17.6957 21.4464 15.1522 22.5 12.5 22.5Z" fill="#727271" />
        </svg>
            </div>
            <div class="modal-message"></div>
            <button class="close-btn" onclick="closeModal('failModal')"> <!-- Updated closeModal call -->
        <svg width="8" height="9" viewBox="0 0 8 9" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M4.83429 4.5L8 7.66572V8.5H7.16571L4 5.33429L0.834286 8.5H0V7.66572L3.16571 4.5L0 1.33429V0.5H0.834286L4 3.66571L7.16571 0.5H8V1.33429L4.83429 4.5Z" fill="#727271" />
        </svg>
            </button>
        </div>
    </div>
</div>



<div class="success-modal">
    <div id="successModal" class="modal"> <!-- Changed ID here -->
        <div class="modal-content">
            <div class="modal-icon">
            <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12.5 0C5.625 0 0 5.625 0 12.5C0 19.375 5.625 25 12.5 25C19.375 25 25 19.375 25 12.5C25 5.625 19.375 0 12.5 0ZM12.5 22.5C6.9875 22.5 2.5 18.0125 2.5 12.5C2.5 6.9875 6.9875 2.5 12.5 2.5C18.0125 2.5 22.5 6.9875 22.5 12.5C22.5 18.0125 18.0125 22.5 12.5 22.5ZM18.2375 6.975L10 15.2125L6.7625 11.9875L5 13.75L10 18.75L20 8.75L18.2375 6.975Z" fill="#727271"/>
            </svg>
            </div>
            <div class="modal-message"></div>
            <button class="close-btn" onclick="closeModal('successModal')"> <!-- Updated closeModal call -->
        <svg width="8" height="9" viewBox="0 0 8 9" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M4.83429 4.5L8 7.66572V8.5H7.16571L4 5.33429L0.834286 8.5H0V7.66572L3.16571 4.5L0 1.33429V0.5H0.834286L4 3.66571L7.16571 0.5H8V1.33429L4.83429 4.5Z" fill="#727271" />
        </svg>
            </button>
        </div>
    </div>
</div>
