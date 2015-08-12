<div class="content">

    <!-- echo out the system feedback (error and success messages) -->
    <?php $this->renderFeedbackMessages(); ?>

    <div class="register-default-box">
        <h1>Register</h1>
        <!-- register form -->
        <form method="post" action="<?php echo URL; ?>login/register_action" name="registerform">
        <fieldset>
            <legend>Account Information</legend>
            <table class="registrationTable">
                <tr>
                    <td>
                        <!-- the user name input field uses a HTML5 pattern check -->
                        <label for="login_input_username"><strong>Username:</strong></label>
                    </td>
                    <td>
                        <input id="login_input_username" class="login_input" type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" required />
                    </td>
                    <td>
                        <label for="login_input_password_new"><strong>Password:</strong></label>
                    </td>
                    <td>
                        <input id="login_input_password_new" class="login_input" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" />
                    </td>
                </tr>
                <tr>
                    <td colspan=2>
                        <span style="display: block; font-size: 12px; color: #4f4f4f;">(only letters and numbers, 2 to 64 characters)</span>
                    </td>
                    <td colspan=2>
                        <span style="display: block; font-size: 12px; color: #4f4f4f;">Password must be at least 6 characters)</span> 
                    </td>
                </tr>
                <tr>
                    <td>
                        <!-- the email input field uses a HTML5 email type check -->
                        <label for="login_input_email"><strong>Email Address:</strong></label>
                    </td>
                    <td>
                        <input id="login_input_email" class="login_input" type="email" name="user_email" required />
                    </td>
                    <td>
                        <label for="login_input_password_repeat"><strong>Repeat password:</strong></label>
                    </td>
                    <td>
                        <input id="login_input_password_repeat" class="login_input" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" />
                    </td>
                </tr>
                <tr>
                    <td colspan=2>
                        <span style="display: block; font-size: 12px; color: #4f4f4f;">
                            (You will need to activate your account from this address)
                        </span>
                    </td>
                    <td colspan=2>
                        <span style="display: block; font-size: 12px; color: #4f4f4f;">
                            (This password must match the first password)
                        </span>
                    </td>
                </tr>
            </table>
        </fieldset>
        
        <fieldset>
            <legend>Personal Information</legend>
            The only information from this section we will store is your <strong>state.</strong> We will use the rest of the information to determine your congressional district, and we will store that.
            <table class="registrationTable">
                <tr>
                    <td><strong>Address:</strong></td>
                    <td>
                        <input id="login_input_address" class="login_input" type="text" name="user_address" placeholder="### Street Name"/>
                    </td>
					<td><strong>City</strong></td>
                    <td><input type="text" id="login_input_city" class="login_input" name="user_city" /></td>
                    
                </tr>
                <tr>
                    <td><strong>State:</strong></td>
                    <td>
                        <select id="login_input_state" class="login_input" name="user_state">
                            <option value="AL">Alabama</option>
                            <option value="AK">Alaska</option>
                            <option value="AZ">Arizona</option>
                            <option value="AR">Arkansas</option>
                            <option value="CA">California</option>
                            <option value="CO">Colorado</option>
                            <option value="CT">Connecticut</option>
                            <option value="DE">Delaware</option>
                            <option value="DC">District Of Columbia</option>
                            <option value="FL">Florida</option>
                            <option value="GA">Georgia</option>
                            <option value="HI">Hawaii</option>
                            <option value="ID">Idaho</option>
                            <option value="IL">Illinois</option>
                            <option value="IN">Indiana</option>
                            <option value="IA">Iowa</option>
                            <option value="KS">Kansas</option>
                            <option value="KY">Kentucky</option>
                            <option value="LA">Louisiana</option>
                            <option value="ME">Maine</option>
                            <option value="MD">Maryland</option>
                            <option value="MA">Massachusetts</option>
                            <option value="MI">Michigan</option>
                            <option value="MN">Minnesota</option>
                            <option value="MS">Mississippi</option>
                            <option value="MO">Missouri</option>
                            <option value="MT">Montana</option>
                            <option value="NE">Nebraska</option>
                            <option value="NV">Nevada</option>
                            <option value="NH">New Hampshire</option>
                            <option value="NJ">New Jersey</option>
                            <option value="NM">New Mexico</option>
                            <option value="NY">New York</option>
                            <option value="NC">North Carolina</option>
                            <option value="ND">North Dakota</option>
                            <option value="OH">Ohio</option>
                            <option value="OK">Oklahoma</option>
                            <option value="OR">Oregon</option>
                            <option value="PA">Pennsylvania</option>
                            <option value="RI">Rhode Island</option>
                            <option value="SC">South Carolina</option>
                            <option value="SD">South Dakota</option>
                            <option value="TN">Tennessee</option>
                            <option value="TX">Texas</option>
                            <option value="UT">Utah</option>
                            <option value="VT">Vermont</option>
                            <option value="VA">Virginia</option>
                            <option value="WA">Washington</option>
                            <option value="WV">West Virginia</option>
                            <option value="WI">Wisconsin</option>
                            <option value="WY">Wyoming</option>
                    </select>
                </td>
                    <td><strong>Zip Code</strong></td>
                    <td>
                        <input type="text" id="login_input_zipcode" class="login_input" name="user_zipcode"/>
                    </td>
                </tr>
            </table>
        </fieldset>
            <!-- show the captcha by calling the login/showCaptcha-method in the src attribute of the img tag -->
            <!-- to avoid weird with-slash-without-slash issues: simply always use the URL constant here -->
            <label>
                Please enter these characters
            </label><br />
            <img src="<?php echo URL; ?>login/showCaptcha" /><br />
            <input type="text" name="captcha" required /><br />
            <input type="submit"  name="register" value="Register" />

        </form>
    </div>

    <?php if (FACEBOOK_LOGIN == true) { ?>
        <div class="register-facebook-box">
            <h1>or</h1>
            <a href="<?php echo $this->facebook_register_url; ?>" class="facebook-login-button">Register with Facebook</a>
        </div>
    <?php } ?>

</div>
