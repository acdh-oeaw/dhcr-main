<div id="footer" class="footer">
        <p class="imprint">
                <?= $this->Html->link('Imprint', '/pages/info/#imprint') ?>
        </p>
        <p>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <strong><?= $this->Html->link('FAQ', ['controller' => 'faqQuestions', 'action' => 'faqList', 'public']) ?></strong>
        </p>
        <p class="license">
                <?= $this->Html->link('CC-BY 4.0', 'https://creativecommons.org/licenses/by/4.0/', ['target' => '_blank']) ?>
        </p>
        <p class="copyright">
                &copy;2014-<?= date('Y') ?>
        </p>
</div>