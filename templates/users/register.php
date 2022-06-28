<?php /** @var string $error */ ?>
<div style="margin: 0 auto" id="layout" class="clearfix">
    <section id="layout-content" class="guest">
        <form class="form-style-9" method="post">
            <ul>
                <?php if ($error): ?>
                <div id="error-message">
                    <li>
                        <?= $error ?>
                    </li>
                </div>
                <?php endif; ?>
                <li>
                    <h1>
                        Register
                    </h1>
                </li>
                <li>
                    <input type="text" name="username" class="field-style field-full" placeholder="Username" minlength="4" maxlength="24" required />
                </li>
                <li>
                    <input type="text" name="first_name" class="field-style field-full" placeholder="First Name" minlength="1" maxlength="24" required />
                </li>
                <li>
                    <input type="text" name="last_name" class="field-style field-full" placeholder="Last Name" minlength="1" maxlength="24" required />
                </li>
                <li>
                    <input type="password" name="password" class="field-style field-full" placeholder="Password" required />
                </li>
                <li>
                    <input type="password" name="confirm_password" class="field-style field-full" placeholder="Confirm Password" required />
                </li>
                <li>
                    <input type="date" name="born_on" class="field-style field-full" placeholder="Date Of Birth"/>
                </li>
                <li>
                    <input type="submit" name="btnRegister" value="Register"/>
                </li>
            </ul>
        </form>
    </section>
</div>
