<?php /** @var string $error */ ?>
<?php /** @var array $data */ ?>
<?php /** @var \src\Data\DTO\UserDTO $user */ $user = $data[0] ?>

<div style="margin: 0 auto" id="layout" class="clearfix">
    <section id="layout-content">
        <div class="title">
            <h2>
                Profile
            </h2>
        </div>
        <form style="position: relative; margin-left: 0px" class="form-style-9" method="post" enctype="multipart/form-data">
            <ul>
                <?php if ($error): ?>
                <div id="error-message">
                    <li>
                        <?= $error ?>
                    </li>
                </div>
                <?php endif; ?>
                <li>
                    <input type="text" name="username" class="field-style field-split align-left" placeholder="Username" value="<?= $user->getUsername() ?>" minlength="4" maxlength="24" required />
                </li>
                <li>
                    <input type="text" name="first_name" class="field-style field-split align-left" placeholder="First Name" value="<?= $user->getFirstName() ?>" minlength="1" maxlength="24" required />
                </li>
                <li>
                    <input type="text" name="last_name" class="field-style field-split align-left" placeholder="Last Name" value="<?= $user->getLastName() ?>" minlength="1" maxlength="24" required />
                </li>
                <li>
                    <input type="date" name="born_on" class="field-style field-split align-left" value="<?= $user->getBornOn() ?>" />
                </li>
                <li>
                    <input type="submit" name="btnEdit" value="Edit"/>
                </li>
            </ul>
            <label for="img">
                <div class="profile-picture profile">
                    <?php if ($user->getProfilePictureUrl()): ?>
                        <img src="public/images/user/<?= $user->getProfilePictureUrl() ?>" alt="Profile Picture">
                        <input type="hidden" name="profile_picture_url" value="<?= $user->getProfilePictureUrl() ?>" />
                    <?php else: ?>
                        <img src="public/images/chat-icon.png" alt="Default Profile Picture">
                    <?php endif; ?>
                    <input type="file" id="img" name="img" class="field-style field-split align-left" accept="image/*" style="display: none;">
                </div>
            </label>
        </form>
    </section>
</div>

