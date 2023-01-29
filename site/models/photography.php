<?php

use Kirby\Cms\Pages;
use Kirby\Database\Db;


class PhotographyPage extends Kirby\Cms\Page
{
    public function children()
    {

        $records = $this->getRecords();
        $children = $this->mapPages($records);

        return Pages::factory($children, $this);
    }

    public function getRecords(): Kirby\Toolkit\Collection
    {

        return Db::table('albums')->all();
    }

    public function mapPages(Kirby\Toolkit\Collection $records): array
    {
        $pages = [];
        foreach ($records as $record) {
            $pages[] = $this->page($record);
        }
        return $pages;
    }

    public function page($record)
    {

        $content = [
            'status' => is_null($record->status()) ? 'draft' : $record->status(),
            'title' => $record->title() ?? 'New Album',
            'cover' => $record->cover() ?? null,
            'headline' => $record->headline() ?? null,
            'subheadline' => $record->subheadline() ?? null,
            'text' => $record->text() ?? null,
            'tags' => $record->tags() ?? null,
            'uuid' => Kirby\Uuid\Uuid::generate(),

        ];


        return [
            'slug' => $record->slug(),
            'num' => $record->status() === 'listed' ? 0 : null,
            'template' => 'album',
            'model' => 'album',
            'content' => $content,
        ];
    }
}
