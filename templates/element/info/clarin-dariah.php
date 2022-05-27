<div class="flex-columns">
    <div class="flex-item wide">
        <p>
            The DH Course Registry (DHCR) is a joint effort of two European research infrastructures:
            <?= $this->Html->link(
                'CLARIN-ERIC',
                'https://www.clarin.eu/',
                ['escape' => false, 'target' => '_blank']
            ); ?> and
            <?= $this->Html->link(
                'DARIAH-EU',
                'https://www.dariah.eu/',
                ['escape' => false, 'target' => '_blank']
            ); ?>.
        </p>
        <p>
            Research infrastructures (RIs) are legal entities that offer technical and social
            infrastructures in a more stable and sustainable way than short-term research projects.
            They also play an important role in educating new generations of researchers.
        </p>
        <p>
            One of the instruments for the maintenance of the DHCR is the DHCR working
            group in DARIAH, which aims to link research, academic teaching and the student community.
        </p>
        <p>
            The DHCR will be maintained and further developed these two European RIs (ERICs).
        </p>
    </div>
    <div class="flex-item narrow">
        <?= $this->Html->link(
            $this->Html->image('dariah-logo.png'),
            'https://www.dariah.eu/',
            ['escape' => false, 'target' => '_blank', 'class' => 'logo']
        ) ?>
        <?= $this->Html->link(
            $this->Html->image('clarin-logo.png'),
            'https://www.clarin.eu/',
            ['escape' => false, 'target' => '_blank', 'class' => 'logo']
        ) ?>
    </div>
</div>