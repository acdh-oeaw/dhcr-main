<div class="flex-columns">
    <div class="flex-item wide">
        <p>
            Creating opportunities for collaboration across disciplines and borders
            is a key feature of research infrastructures.
            As such,
            <?= $this->Html->link('CLARIN', 'https://www.clarin.eu/',
                ['escape' => false, 'target' => '_blank']); ?> and
            <?= $this->Html->link('DARIAH', 'https://www.dariah.eu/',
            ['escape' => false, 'target' => '_blank']); ?>
            offer platforms, conferences and workshops,
            where researchers from various countries and disciplines meet each other.
        </p>
        <p>
            Within DARIAH, a number of working groups have been established about
            strategic areas such as Artificial Intelligence and Music, GeoHumanities or
            Women Writers in History. These working groups form a vital link between
            the infrastructure and the scientific community. The DHCR working group aims
            to create a link between research, academic teaching and the student community.
        </p>
        <p>
            Both CLARIN and DARIAH are a European Research Infrastructure Consortium (ERIC),
            a legal entity for infrastructures on a non-economic basis. The DHCR will be
            further developed and maintained as a collaboration of the two ERICs.
        </p>
    </div>
    <div class="flex-item narrow">
        <?= $this->Html->link($this->Html->image('clarin-frontpage-logo.jpg', ['class' => 'logo']),
            'https://www.clarin.eu/',
            ['escape' => false, 'target' => '_blank']) ?>
        <?= $this->Html->link($this->Html->image('dariah-logo.png', ['class' => 'logo']),
            'https://www.dariah.eu/',
            ['escape' => false, 'target' => '_blank']) ?>
    </div>
