<?php
$pageTitle = 'Главная';
ob_start();
?>

<div class="homepage">
    <h1>Добро пожаловать на наш сайт</h1>

    <div class="posts-grid">
        <?php foreach ($posts as $post): ?>
            <article class="post-card">
                <h2><a href="/post/<?php echo Security::escape($post['slug']); ?>">
                    <?php echo Security::escape($post['title']); ?>
                </a></h2>
                <div class="post-meta">
                    <span class="author">Автор: <?php echo Security::escape($post['author_name']); ?></span>
                    <span class="date"><?php echo date('d.m.Y', strtotime($post['published_at'])); ?></span>
                </div>
                <p><?php echo Security::escape(substr($post['excerpt'] ?: $post['content'], 0, 200)); ?>...</p>
                <a href="/post/<?php echo Security::escape($post['slug']); ?>" class="btn btn-link">Читать далее</a>
            </article>
        <?php endforeach; ?>
    </div>

    <!-- Пагинация -->
    <?php if ($totalPages > 1): ?>
        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <?php if ($i == $page): ?>
                    <span class="current"><?php echo $i; ?></span>
                <?php else: ?>
                    <a href="/?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                <?php endif; ?>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/frontend.php';
?>
