<?php foreach ($data as $row): ?>

<div class="box">
    <h4><?= $row->father_first_name ?></h4>
    <p><?= $row->father_mobile ?></p>
    <a href="view?id=<?= $row->id ?>">View</a>
</div>

<?php endforeach; ?>