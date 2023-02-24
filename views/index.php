<?php View::extends('layouts/common'); ?>'

<?php View::section('title', 'Главная страница'); ?>

<?php View::section('content'); ?>
    <?php if (!isset($_SESSION['logged_user'])){ require '../blocks/forma.php'; } ?>
    <?php foreach ($articles as $article) : ?>
            <article>
                <h1><?= $article->title ?></h1>
                <a style="cursor:pointer;" href="http://factorio-draft.ru/pages/watch.php?id=<?= $article->id ?>" >Просмотр</a>
                <section>
					<?= cutString($article->description, 500) ?>
                    <div><p>Автор: <?= $article->author ?></p></div>
                </section>
                <img src="planImg/<?= $article->imgurl ?>">
                <?= View::render('components/rate', ['rate' => $article->rate]) ?>
            </article>
    <?php endforeach; ?>
<?php View::endSection(); ?>