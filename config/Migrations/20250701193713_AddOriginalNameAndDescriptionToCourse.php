<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

class AddOriginalNameAndDescriptionToCourse extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('courses');

        $table->addColumn('original_name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);

        $table->addColumn('original_description', 'text', [
            'default' => null,
            'null' => true,
        ]);

        $table->update();
    }
}
