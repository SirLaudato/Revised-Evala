<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <link rel="stylesheet" href="account.css"> <!-- Include your CSS file -->
    <link rel="stylesheet" href="all.css">
</head>
<div>

<?php include 'nav.php' ?>
<div class="containerism">
    <div class="account">
        <div class="tab-content" id="tab-content">
            <div id="tab-account" class="tab active">
                <form action="save_account.php" method="POST">
                    <div class="input-field">
                    <h4>Personal Information</h4>
                        <h>Full Name</h>
                        <div class="form-row">
                            <div>
                                <input type="text" id="first_name" name="first_name" required placeholder="First Name">
                            </div>
                            <div>
                                <input type="text" id="last_name" name="last_name" required placeholder="Last Name">
                            </div>
                        </div>                    </div>
                    <div class="input-field">
                        <h>Contact Information</h>
                        <div class="form-row">
                            <div>
                                <input type="text" id="first_name" name="first_name" required placeholder="Student Number">
                            </div>
                            <div>
                                <input type="text" id="last_name" name="last_name" required placeholder="School Email">
                            </div>
                        </div>
                    </div>
                    <div class="input-field">
                        <h>Password</h>
                        <div class="widefield">
                            <input type="text" id="first_name" name="first_name" required placeholder="Current Password">
                        </div>
                        <div class="form-row">
                            <div>
                                <input type="password" id="first_name" name="first_name" required placeholder="New Password">
                            </div>
                            <div>
                                <input type="password" id="last_name" name="last_name" required placeholder="New Password">
                            </div>
                        </div>
                    </div>
                    <button type="submit">Save</button>
                </form>




                <form>
                </form>

                <form>
                <div class="input-field">
                    <h4>Privacy Settings</h4>
                    <div class="form-row">
                        <p>We care about your integrity, and continuosly work toward making your
                            Innovatio experience as safe and secure as possible. Read the Innovatio Privacy Policy
                            to learn more about how we use and store personal data.
                        </p>
                    </div>

                    <div class="form-row">
                        <p>This page is where you will be able to manage your privacy settings.
                            Return to review this page, as it will be continuosly updated.
                        </p>
                    </div>
                    </div>
                </form>
                <button class="con-shopping">Privacy Settings</button>

                <form>
                <div class="input-field">
                    <h4>Closing Your Account</h4>
                    <div class="form-row">
                        <p> If you choose to close your account you will no longer be able to access our services including,
                         for example, viewing your order history, or viewing your registered products. For the time being
                         this is a manual process and needs to be initiated via an e-mail sent to us. Click the button below
                         to start the process.
                        </p>

                        
                    </div>
                    </div>
                </form>
                <button class="con-shopping">Close Account</button>


            </div>

                <div id="tab-registered-products" class="tab">
                    <div class="guide-info">
                    <p>You can also contact the Innovatio customer support team. For the fastest help however, we recommend looking through appropriate product manuals, FAQ sections, or checking the Innovatioauts user forum for answers.
                        
                    </p>
                    </div>

                        <form action="save_account.php" method="POST" id="billing-address-form">
                            <div class="input-field">
                                <h>Product</h>
                                <div class="form-row">
                                    <div>
                                        <input type="text" id="billing_first_name" name="billing_first_name" required placeholder="Product Title">
                                    </div>
                                    <div>
                                        <input type="text" id="billing_last_name" name="billing_last_name" required placeholder="Product Brand">
                                    </div>
                                </div>
                            </div>

                            <div class="input-field">
                                <h>Contact Information</h>
                                <div class="form-row">
                                    <div>
                                        <input type="text" id="billing_phone_number" name="billing_phone_number" required placeholder="Phone Number">
                                    </div>
                                    <div>
                                        <input type="email" id="billing_email" name="billing_email" required placeholder="Email">
                                    </div>
                                </div>
                            </div>

                            <div class="input-field">
                                <h>Address</h>
                                <div class="widefield">
                                    <input type="text" id="billing_address" name="billing_address" required placeholder="Address">
                                </div>
                                <div class="form-row">
                                    <div>
                                        <input type="text" id="billing_postal_code" name="billing_postal_code" required placeholder="Postal Code">
                                    </div>
                                    <div>
                                        <input type="text" id="billing_city" name="billing_city" required placeholder="City">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div>
                                        <input type="text" id="billing_province" name="billing_province" required placeholder="Province">
                                    </div>
                                    <div>
                                        <input type="text" id="billing_country" name="billing_country" required placeholder="Country">
                                    </div>
                                </div>
                            </div>

                                                        
                            <label for="file" class="file-upload-label">
                            <h>Note: Maximum of 3 images are permitted.</h>
                                <div class="file-upload-design">
                                <span class="con-shopping">Upload Image</span>
                                </div>
                                <input id="file" type="file" />
                                
                            </label>
                            <button class="con-shopping">Upload Product</button>
                        </form>
                </div>


                <div id="tab-sound-packs" class="tab">
                    <h2>Sound Packs</h2>
                    <p>Your sound packs will be displayed here.</p>
                    <!-- Add more content as needed -->
                </div>
                <div id="tab-orders" class="tab">
                    <h2>Orders</h2>
                    <p>Your orders will be displayed here.</p>
                    <!-- Add more content as needed -->
                </div>

        </div>
    </div>

    <div class="user-info">
        <div class="user">
            <div class="username">
                <h>Welcome, Lawrence</h>
            </div>
            <div class="Logout">
                <a href="logout.php">Logout</a>
            </div>
        </div>

        <div class="guide">
            <div class="guide-info">
                <p>In your account pages you can register your products, as well as view your order history.</p>
                <p>You can also contact the Innovatio customer support team. For the fastest help however, we recommend looking through appropriate product manuals, FAQ sections, or checking the Innovatioauts user forum for answers.</p>
            </div>



        </div>
</div>
</div>


<div id="cart-modal" class="cart-modal">
    <div class="cart-modal-content">
        <span class="close-button">&times;</span>
        <h2>Cart</h2>
        <hr>
        <div class="cart-items">
            <!-- Product 1 -->
            <div class="cart-item">
                <div class="cart-item-image"></div>
                <div class="cart-item-details">
                    <div class="cart-item-name">Product 1</div>
                    <div class="number-control">
                        <div class="number-left"></div>
                        <input type="number" name="number" class="number-quantity">
                        <div class="number-right"></div>
                    </div>
                </div>
                <div class="cart-pay">
                    <span class="remove-product">&times;</span>
                    <div class="cart-item-price">540.00</div>
                    <div class="cart-item-currency">PHP</div>
                </div>
            </div>

            <!-- Product 2 -->
            <div class="cart-item">
                <div class="cart-item-image"></div>
                <div class="cart-item-details">
                    <div class="cart-item-name">Product 2</div>
                    <div class="number-control">
                        <div class="number-left"></div>
                        <input type="number" name="number" class="number-quantity">
                        <div class="number-right"></div>
                    </div>
                </div>
                <div class="cart-pay">
                    <span class="remove-product">&times;</span>
                    <div class="cart-item-price">110.00</div>
                    <div class="cart-item-currency">PHP</div>
                </div>
            </div>

            <!-- Product 3 -->
            <div class="cart-item">
                <div class="cart-item-image"></div>
                <div class="cart-item-details">
                    <div class="cart-item-name">Product 3</div>
                    <div class="number-control">
                        <div class="number-left"></div>
                        <input type="number" name="number" class="number-quantity">
                        <div class="number-right"></div>
                    </div>
                </div>
                <div class="cart-pay">
                    <span class="remove-product">&times;</span>
                    <div class="cart-item-price">320.00</div>
                    <div class="cart-item-currency">PHP</div>
                </div>
            </div>
        </div>

        <div class="payment-info">
            <div class="subtotal">
                <span>Subtotal</span>
                <span class="amount">100.00</span>
            </div>
            <div class="discount">
                <span>Discount</span>
                <span class="amount">100.00</span>
            </div>
            <div class="shipping">
                <span>Shipping</span>
                <span class="amount">100.00</span>
            </div>
            <div class="total">
                <span>Total</span>
                <span class="amount">100.00</span>
            </div>
        </div>
        <div class="buttons-modal">
            <button class="check-out">Check out</button>
            <button class="con-shopping">Continue Shopping</button>
        </div>
    </div>
</div>


<?php include 'footer.php' ?>

</body>
</html>

<script src="index.js"></script>

<script>
        function showTab(tabId) {
            const tabs = document.querySelectorAll('.tab');
            const tabButtons = document.querySelectorAll('.tabs div');
            tabs.forEach(tab => {
                tab.classList.remove('active');
            });
            tabButtons.forEach(button => {
                button.classList.remove('active');
            });
            document.getElementById(tabId).classList.add('active');
            document.querySelector(`.tabs div[data-tab=${tabId}]`).classList.add('active');
        }
</script>

<script>
    function showTab(tabId) {
        const tabs = document.querySelectorAll('.tab');
        const tabButtons = document.querySelectorAll('.tabs div');
        tabs.forEach(tab => {
            tab.classList.remove('active');
        });
        tabButtons.forEach(button => {
            button.classList.remove('active');
        });
        document.getElementById(tabId).classList.add('active');
        document.querySelector(`.tabs div[data-tab=${tabId}]`).classList.add('active');
    }

    function toggleBillingAddress() {
        const billingForm = document.getElementById('billing-address-form');
        const isChecked = document.getElementById('same_as_shipping').checked;
        
        if (isChecked) {
            billingForm.classList.add('disabled');
            billingForm.querySelectorAll('input').forEach(input => {
                input.disabled = true;
            });
        } else {
            billingForm.classList.remove('disabled');
            billingForm.querySelectorAll('input').forEach(input => {
                input.disabled = false;
            });
        }
    }
</script>