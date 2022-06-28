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
                        Login
                    </h1>
                </li>
                <li>
                    <input type="text" name="username" class="field-style field-split align-left" placeholder="Username" required />
                </li>
                <li>
                    <input type="password" name="password" class="field-style field-split align-left" placeholder="Password" required />
                </li>
                <li>
                    <input type="submit" name="btnLogin" value="Login"/>
                </li>
            </ul>
        </form>
    </section>
</div>