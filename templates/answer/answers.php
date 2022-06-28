<?php
/** @var \src\Data\DTO\QuestionDTO $question */
/** @var array $data */
/** @var string $error */

$question = $data["question"];
?>

<div id="layout" class="clearfix">
    <section id="layout-content">
        <div class="home-content">
            <article class="newsentry">
                <header class="title">
                    <div class="temp-class">
                        <div class="profile-picture answers">
                        <?php if ($question->getUser()->getProfilePictureUrl()): ?>
                            <img src="public/images/user/<?= $question->getUser()->getProfilePictureUrl() ?>" alt="Profile Picture">
                        <?php else: ?>
                            <img src="public/images/chat-icon.png" alt="Default Profile Picture">
                        <?php endif; ?>
                        </div>
                        <div class="username"><?= $question->getUser()->getUsername() ?></div>
                    </div>
                    <h3 class="newstitle"><?= $question->getTitle() ?></h3>
                </header>
                <div class="newscontent">
                    <p><?= $question->getBody() ?></p>
                    <a class="ref-link" href="javascript:void(0)" onclick="hideForm(); return false;">Answer</a>
                    <time class="answers-time"><?= $question->getCreatedOn() ?></time>
                </div>
            </article>
        </div>
        <br/>
        <form class="form-style-9 answer hidden" method="post">
            <ul>
                <?php if ($error): ?>
                <script>
                    document.getElementsByClassName("form-style-9 answer")[0].className = "form-style-9 answer";
                </script>
                <div id="error-message">
                    <li><?= $error ?></li>
                </div>
                <?php endif; ?>
                <li>
                    <textarea name="body" class="field-style field-full align-left" placeholder="Text" minlength="1" maxlength="1000" required></textarea>
                </li>
                <li>
                    <input type="submit" name="btnAnswer" value="Answer"/>
                </li>
            </ul>
        </form>
        <?php if($question->getAnswers()): ?>
        <div class="comment-thread">
        <?php foreach ($question->getAnswers() as $answer): ?>
            <!-- Comment 1 start -->
            <details open class="comment" id="<?= $answer->getId() ?>">
                <a href="#" class="comment-border-link">
                    <span class="sr-only">Jump to comment <?= $answer->getId() ?></span>
                </a>
                <summary>
                    <div class="comment-heading">
                        <div class="comment-info">
                            <a href="#" class="comment-author"><?= $answer->getUser()->getUsername() ?></a>
                            <p class="m-0"><?= $answer->getDaysOld() . " days old" ?></p>
                        </div>
                    </div>
                </summary>
                <div class="comment-body">
                    <p><?= $answer->getBody() ?></p>
                </div>
            </details>
            <!-- Comment 1 end -->
        <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </section>
</div>
