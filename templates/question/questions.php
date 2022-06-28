<?php

/** @var array $data */

/** @var \src\Data\DTO\QuestionDTO[] | \Generator $questions */
$questions = $data["questions"];

/** @var \src\Data\DTO\CategoryDTO[] $categories */
$categories = $data["categories"];

/** @var string $categoryName */
$categoryName = $data["categoryName"];

/** @var \core\Paginator\Paginator $paginator */
$paginator = $data["paginator"];

?>

<div id="layout" class="clearfix">
    <aside class="tips">
        <div class="inner">
            <?php if (isset($categoryName)): ?>
            <div>
                <button style="background-color: lightsalmon" onclick="document.location='askquestion/<?= $categoryName ?>'">New question</button>
            </div>
            <?php endif; ?>
            <br/>
            <h1 style="color: white;">Categories</h1><br/>
            <div class="panel">
                <?php foreach ($categories as $category): ?>
                    <?php if ($category->getName() === $categoryName): $color = "lightsalmon" ?>
                    <?php else: $color = "none" ?>
                    <?php endif; ?>
                    <a style="color: <?= $color ?>;" class="sidebar-links" href="questions/<?= $category->getName() ?>"><?= $category->getName() ?> - <?= $category->getQuestionsCount() ?></a>
                <?php endforeach; ?>
            </div>
        </div>
        <a href="javascript:void(0);" class="icon" onclick="myFunction()">&#9776;</a>
    </aside>
    <section id="layout-content">
        <div class="home-content">
            <?php if ($questions->valid()): ?>
                <?php foreach ($questions as $question): ?>
                    <article class="newsentry">
                        <header class="title">
                            <div class="temp-class">
                                <div class="profile-picture questions">
                                    <?php if ($question->getProfilePictureUrl()): ?>
                                        <img src="public/images/user/<?= $question->getProfilePictureUrl() ?>" alt="Profile Picture">
                                    <?php else: ?>
                                        <img src="public/images/chat-icon.png" alt="Default Profile Picture">
                                    <?php endif; ?>
                                </div>
                                <div class="username">
                                    <?= $question->getUsername() ?>
                                </div>
                            </div>
                            <h3 class="newstitle">
                                <a href="answers/<?= $question->getId() ?>/<?= str_replace(" ", "-", $question->getTitle()) ?>"><?= $question->getTitle() ?></a>
                            </h3>
                            <time>
                                <?= $question->getCreatedOn() ?>
                            </time>
                            <a style="color: black" class="sidebar-links" href="questions/<?= $question->getCategoryName() ?>"><?= $question->getCategoryName() ?></a>
                            <span class="answers-icon">
                                <img src="public/images/answers-icon.png" alt="Answers Icon" />
                                <?= $question->getAnswersCount() ?>
                            </span>
                        </header>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
            <div class="pagination">
                <?php if ($paginator::getCurrentPage() != 1): ?>
                    <a class="page-number" href="questions/?page=1"><</a>
                    <a class="page-number" href="questions/?page=<?= $paginator::getCurrentPage() - 1 ?>"><<</a>
                <?php endif; ?>
                <?php for ($i = 0; $i < count($paginator::getPages()); $i++): ?>
                    <?php $categoryPath = $categoryName ? "/$categoryName/" : "/"?>
                    <?php if ($paginator::getPages()[$i] == $paginator::getCurrentPage()): ?>
                        <a class="page-number selected" href="questions<?= $categoryPath ?>?page=<?= $paginator::getPages()[$i] ?>"><?= $paginator::getPages()[$i] ?></a>
                    <?php else: ?>
                        <a class="page-number" href="questions<?= $categoryPath ?>?page=<?= $paginator::getPages()[$i] ?>"><?= $paginator::getPages()[$i] ?></a>
                    <?php endif ?>
                <?php endfor; ?>
                <?php if ($paginator::getNumOfPages() > $paginator::getNumOfDisplayedPages()): ?>
                    <a class="page-number not-allowed">...</a>
                <?php endif; ?>
                <?php if ($paginator::getCurrentPage() != $paginator::getNumOfPages()): ?>
                    <a class="page-number" href="questions<?= $categoryPath ?>?page=<?= $paginator::getCurrentPage() + 1?>">>></a>
                    <a class="page-number" href="questions<?= $categoryPath ?>?page=<?= $paginator::getNumOfPages() ?>">></a>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>