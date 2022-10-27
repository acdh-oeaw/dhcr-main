<div class="row">
    <p></p>
    <h2><span class="glyphicon glyphicon-eye-open"></span>&nbsp;&nbsp;&nbsp;FAQ Question Details</h2>
    <?= $this->Html->link(__('Edit FAQ Question'), ['action' => 'edit', $faqQuestion->id], ['class' => 'button float-right']) ?>
    <p></p>
    <div class="column-responsive column-80">
        <div class="faqQuestions view content">
            <h3><?= h($faqQuestion->question) ?></h3>
            <p></p>
            <table>
                <tr>
                    <th align="left" style="padding: 5px">Category</th>
                    <td style="padding: 5px"><?= $faqQuestion->faq_category->name ?></td>
                </tr>
                <tr>
                    <th align="left" style="padding: 5px">Published</th>
                    <td style="padding: 5px"><span class="glyphicon glyphicon-<?= ($faqQuestion->published) ? 'ok' : 'remove' ?>"></span></td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <th align="left" style="padding: 5px">Answer</th>
                    <td style="padding: 5px">
                        <blockquote>
                            <?= $this->Text->autoParagraph(h($faqQuestion->answer)); ?>
                        </blockquote>
                    </td>
                </tr>
                <tr>
                    <th align="left" style="padding: 5px">Link</th>
                    <td style="padding: 5px"><?php
                                                if (strlen($faqQuestion->link_url) < 1) {
                                                    echo '-';
                                                } else {
                                                    echo $this->Html->link($faqQuestion->link_title, $faqQuestion->link_url);
                                                } ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>