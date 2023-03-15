@extends('layouts/common')
@section('title', 'Главная страница')
@section('content')
    <?php if (!isset($_SESSION['logged_user'])) echo View::render('components/form_sign_in_up', $form_sign_in_up_data); ?>
    <?php foreach ($articles as $article) : ?>
            <article>
                <h1><?= $article->title ?></h1>
                <a style="cursor:pointer;" href="http://factorio-draft.ru/pages/watch.php?id=<?= $article->id ?>" >Просмотр</a>
                <section>
					<?= strCut($article->description, 500) ?>
                    <div><p>Автор: <?= $article->author ?></p></div>
                </section>
                <img alt="Изображение чертежа" src="planImg/<?= $article->imgurl ?>">
                @render('components/rate', ['rate' => $article->rate])
            </article>
    <?php endforeach; ?>
@endSection

