<?php /** @var string $error */ ?>
<div style="margin: 0 auto" id="layout" class="clearfix">
    <section id="layout-content">
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
                    <input type="text" name="title" class="field-style field-split align-left" placeholder="Title" minlength="4" maxlength="255" required />
                </li>
                <li>
                    <textarea name="body" class="field-style field-full align-left" placeholder="Text" minlength="4" maxlength="2000" required></textarea>
                </li>
                <li>
                    <input type="submit" name="btnAsk" value="Създай"/>
                </li>
            </ul>
        </form>
    </section>
</div>