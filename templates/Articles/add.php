<h1>Add new Article</h1>
<?php
    echo $this->Form->create($article);
    echo $this->Form->control('User_Id',['type'=>'hidden', 'value'=>1]);
    echo $this->Form->control('Title');
    echo $this->Form->control('Body', ['rows' => '3']);
    echo $this->Form->button('Save Article');
    echo $this->Form->end();
?>