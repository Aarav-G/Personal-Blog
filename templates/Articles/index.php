<h1>Articles List</h1>
<h3><?= $this->Html->link('Add New Article', ['action' => 'add']) ?></h3>
<table>
    <thead>
        <tr>
            <th>Title</th>
            <th>Created</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($articles as $article): ?>
        <tr>
            <td><?= $this->Html->link($article->Title,['action' => 'view', $article->Slug]); ?></td>
            <td><?= $article->Created->format(DATE_RFC850); ?></td>
            <td><?= $this->Html->link('Edit',['action'=>'edit', $article->Slug]); ?></td>
            <td><?= $this->Form->postLink('Delete', ['action' => 'delete', $article->Slug], ['confirm'=>'Are you sure?']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>