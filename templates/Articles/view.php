<h1><?= $article->Title ?></h1>
<p><?= $article->Body ?></p>
<p><small>Created: <?= $article->Created->format(DATE_RFC850); ?></small></p>
<p><?= $this->Html->link('Edit', ['action'=>'edit', $article->Slug]); ?></p>
