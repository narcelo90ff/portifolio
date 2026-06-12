<?php if(!empty($flash)): ?>
<div class="alert alert-<?= $flash['t'] ?>" id="flash-msg">
  <span><?= $flash['m'] ?></span>
  <button onclick="this.parentElement.remove()">✕</button>
</div>
<?php endif; ?>
